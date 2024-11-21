<?php

namespace App\Http\Controllers;

use App\Model\Config;
use App\Repository\Paystack;

class UserDashboard extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->updated_at = now();
        $invoices = $user->invoices;
        $customers = collect([]);

        $totalRevenue = 0;
        $totalExpenses = 0;
        $totalCustomers = 0;
        $totalUnPaidInvoice = 0;

        $user->businesses->each(function ( $business ) use (&$totalRevenue, &$totalExpenses, &$totalCustomers, &$totalUnPaidInvoice, &$customers) {

             $totalRevenue += $business->invoices()->sum('amount_paid');
             $totalExpenses += $business->expenses()->sum('amount');
             $totalCustomers += $business->customers()->count();

             $unpaid1 = $business->invoices()->where('payment_status', 'UNPAID')->get()->sum('products_sum');
             $unpaid2S = $business->invoices()->where('payment_status', 'PART PAYMENT')->get();
             $unpaid2 = $unpaid2S->sum('products_sum') - $unpaid2S->sum('amount_paid');
             $totalUnPaidInvoice += ($unpaid1 + $unpaid2);

             $customers->push($business->customers);
        });

        $customers = $customers->flatten();


        return view('pages.dashboard', compact('invoices', 'customers', 'totalRevenue', 'totalExpenses', 'totalCustomers', 'totalUnPaidInvoice'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('pages.profile', compact('user'));
    }

    public function updateProfile()
    {
        try {
            request()->user()->update(request()->except('_token'));

            return back()->with('message', 'Profile updated successfully');
        }
        catch (\Exception $exception) {
//            dd($exception->getMessage());
            return back()->with('message', 'Error updating profile');
        }
    }

    public function received()
    {
        $invoices = auth()->user()->invoices()
            ->orderBy('id', 'desc')
            ->with(['business', 'products'])->paginate();
//        dd($invoices[0]->toArray());
        return view('pages.users.received', compact('invoices'));
    }

    public function viewInvoice($invoice_id)
    {
        $invoice = \App\Model\Invoice::with(['products', 'customer.user'])->find($invoice_id);
        $debitCards = auth()->user()->debitCards;
//        dd($invoice->toArray());

        return view('pages.business.invoice.view', compact('invoice', 'debitCards'));
    }

    public function productsPurchased()
    {
        $invoices = auth()->user()->invoices()->with(['business', 'products'])->get();
        $products = collect([]);
        foreach ($invoices as $invoice) {
            foreach ($invoice->products as $ip) {
                $products->put($ip->product->id, $ip->product);
            }
        }

        return view('pages.users.products-purchased', compact('products'));
    }


    public function settings()
    {
        $settings = Config::where('name', 'CHANNELS')->get()    ;
        dd($settings->toArray());
        return view('pages.users.received', compact('invoices'));
    }


    public function addDebitCard($ref)
    {
        try {
            $user = auth()->user();
            $response = Paystack::verify($ref);

            if ($response['success']) {
                $data = $response['data'];

                $user->debitCards()->create([
                    'authorization_code'    => $data->authorization->authorization_code,
                    'last4'                 => $data->authorization->last4,
                    'exp_month'             => $data->authorization->exp_month,
                    'exp_year'              => $data->authorization->exp_year,
                    'card_type'             => $data->authorization->card_type,
                    'bank'                  => $data->authorization->bank,
                    'customer_email'        => $data->customer->email,
                ]);

                return back()->with('message', 'Debit card added successfully');
            }

            return back()->with('error', 'Error adding Debit card');
        }

        catch ( \Exception $exception ) {
            return back()->with('error', 'Error adding Debit card ('. $exception->getMessage(). ')');
        }
    }

}
