<?php

namespace App\Http\Controllers;


use App\Model\TransfersRequest;
use App\Model\WalletTransfer;
use App\Repository\Paystack;
use App\Repository\Wallet;
use App\User;
use foo\bar;

class WalletController extends Controller
{
    public function index()
    {
//        \App\Model\Wallet::all()->each(function ($wallet) {
//            $wallet->account_number = Wallet::generateAccountNumber();
//            $wallet->save();
//        });

        User::all()->each(function ( $user ) {
            $user->wallet()->firstOrCreate([
                'balance'   => 0.0,
                'account_number' => \App\Repository\Wallet::generateAccountNumber(),
                'status'    => 'ACTIVE'
            ]);
        });

        $user = auth()->user();
        $wallet = $user->wallet;
        $transactions = $wallet->transactions()
            ->orderBy('id', 'desc')
            ->limit(10)->get();

        $received =  WalletTransfer::where('to_wallet_id', $wallet->id)->sum('amount');
        $transfer =  $wallet->transfers()->sum('amount');

        $wallet_debit = $wallet->transactions()->where('type', 'DEBIT')->sum('amount');
        $wallet_debit += $transfer;

        $wallet_credit = $wallet->transactions()->where(function ($q) {
            $q->where('type', 'CREDIT')
                ->orWhere('type', 'TOPUP');
        })->sum('amount');
        $wallet_credit += $received;

        return view('pages.wallet.index', compact('user', 'wallet', 'transactions', 'wallet_credit', 'wallet_debit'));
    }

    public function transactions()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $transactions = $wallet->transactions()->simplePaginate();

        return view('pages.wallet.transactions', compact('user', 'wallet', 'transactions'));
    }

    public function transferRequests()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if ( $user->isAdmin() ) {
            $transfers = TransfersRequest::orderBy('id', 'desc')->simplePaginate();
        }
        else {
            $transfers = $wallet->requests()->orderBy('id', 'desc')->simplePaginate();
        }

        return view('pages.wallet.transfers-requests', compact('user', 'wallet', 'transfers'));
    }

    public function topup()
    {
        $user = auth()->user();
        $ref = request('reference');

        if ( !is_null($user->wallet->transactions()->where('data->reference', $ref)->first())) {
            return back()->with('message', 'This transaction has already been processed.');
        }

        $transaction = Paystack::verify($ref);
        if ( $transaction['success']) {
            $data = $transaction['data'];

            Wallet::credit($user, (float) request('amount'), 'Wallet Topup', 'TOPUP', $data);
            return redirect(route('wallet'))->with('message', 'Wallet topup successful');
        }

        return back()->with('error', $transaction['message']);
    }

    public function walletTransfers()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $transfers = $wallet->transfers()->simplePaginate();

        return view('pages.wallet.wallet-transfers', compact('user', 'wallet', 'transfers'));
    }

    public function transferRequestView()
    {
        $user = auth()->user();
        $banks = $user->banks;

        if ($banks->count() < 1 ) {
            return back()->with('error', 'You do not have any bank in any of your businesses, please add a bank in one of your business first.');
        }

        return view('pages.wallet.request-a-transfer', compact('user', 'banks'));
    }

    public function makeTransferRequest()
    {
        try {
            $user = auth()->user();
            $wallet = $user->wallet;
            $amount = (double) request('amount');
            $bank = $user->banks()->find(request('bank_id'));

            if ($amount > $wallet->balance) {
                return redirect()->back()->with('error', "Insufficient Fund.");
            }

            $wallet->requests()->create([
                'amount'            => (float) $amount,
                'account_number'    => $bank->account_number,
                'account_name'      => $bank->account_name,
                'bank_name'         => $bank->name,
                'bank_code'         => $bank->code
            ]);

            return redirect(route('wallet.transfer-request'))
                ->with('message', 'You have successfully submitted a transfer request, your request will be attended to ASAP.');
        }
        catch (\Exception $exception) {
            dd($exception->getMessage());
            return back()->with('error', 'Error making a transfer request.');
        }
    }

    public function transferToWallet()
    {
        try {
            $user = auth()->user();
            $wallet = $user->wallet;
            $recipientWallet = \App\Model\Wallet::where('account_number', request('wallet_id'))->first();
            $amount = request('amount');


            if ( is_null($recipientWallet) ) {
                return back()->with('error', 'Recipient wallet not found');
            }

            $info = "Transfer $amount to walletID: {$recipientWallet->account_number}";
            $info2 = "Received $amount from walletID: {$wallet->account_number}";

            // debit my wallet
            Wallet::debit($user, (float) $amount, $info, 'TRANSFER');
            $wallet->transfers()->create([
                'to_wallet_id'  => $recipientWallet->id,
                'amount'        => (float) $amount,
            ]);


            // credit recipient's wallet
            Wallet::credit($recipientWallet->user, (float) $amount, $info2, 'TRANSFER');

            return redirect(route('wallet.transfers'))->with('message', 'Transfer to wallet was successfully');
        }
        catch (\Exception $exception) {
            return back()->with('error', 'Error with transfer to wallet.');
        }
    }

    public function denyTransferRequest( $id )
    {
        try {
            $request = TransfersRequest::find($id);
            $request->status = 'DENIED';
            $request->save();

            return back()->with('message', 'Transfer request denied successfully');
        }
        catch (\Exception $exception ) {
            return back()->with('error', 'Error denying transfer request');
        }
    }

    public function approveTransferRequest( $id )
    {
        try {
            $request = TransfersRequest::find($id);

            $recipient = Paystack::createTransferRecipient($request->account_number, $request->account_name, $request->bank_code);

//            dd($request->toArray(), $recipient);

            if ( $recipient['success']) {

                $amount = (double) $request->amount;
                $transfer = Paystack::transfer(
                    $amount * 100,
                    $recipient['data']['data']['recipient_code'],
                    'Fund transfer request approved');

                //add transfer charge
                $amount = $amount + $this->getTransferCharge($amount);
                $request->amount = $amount;
                $request->save();

                //deduct this transfer from user's wallet
                Wallet::debit($request->wallet->user, $amount, 'Wallet debit for approved transfer request');

                if ( $transfer['success'] ) {
                    $request->status = 'APPROVED';
                    $request->save();

                    return back()->with('message', 'Transfer request approved successfully');
                }

                return back()->with('error', 'Error transferring fund');
            }

            return back()->with('error', 'Error creating transfer recipient');
        }
        catch (\Exception $exception ) {
            dd($exception->getMessage());
            return back()->with('error', 'Error approving transfer request');
        }
    }

    public function getChargeRequest($amount)
    {
        return response()->json($this->getTransferCharge($amount));
    }


    private function getTransferCharge( $amount )
    {
        $amount = (int) $amount;

        if ($amount <= 5000) {
            $charge = 15;
        }elseif (($amount > 5000) && ($amount <= 50000)) {
            $charge = 35;
        }else{
            $charge = 65;
        }

        return $charge;
    }
}
