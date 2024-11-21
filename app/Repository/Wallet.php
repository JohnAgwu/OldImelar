<?php
/**
 * Created by Canaan Etai.
 * Date: 1/25/20
 * Time: 9:36 AM
 */

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Wallet
{

    public static function generateAccountNumber()
    {
        $no = (string) random_int(0000000000, 1111111111);

        if ( strlen($no) != 10 ) {
            return self::generateAccountNumber();
        }

        if ( \App\Model\Wallet::where('account_number', $no)->count() > 0 ) {
            return self::generateAccountNumber();
        }

        return $no;
    }

    /**
     * Credit Wallet
     *
     * @param $user
     * @param $amount
     * @param $info
     * @param null $type
     * @param null $data
     * @return array
     */
    public static function credit($user, $amount, $info, $type = null, $data = null)
    {
        try {
            $wallet = $user->wallet;

            // Check if wallet is active
            if ($wallet->status !== 'ACTIVE') {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            $prev_bal = $wallet->balance;

            $wallet->balance += $amount;
            $wallet->updated_at = now();
            $wallet->save();

            $wallet->transactions()->create([
                'amount' => $amount,
                'type' => $type ?? 'CREDIT',
                'prev_balance' => $prev_bal,
                'new_balance' => $wallet->balance,
                'info' => $info,
                'data'  => $data
            ]);


            return [
                'success' => true,
                'message' => 'Wallet crediting was successful.'
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Debit Wallet
     *
     * @param $user
     * @param $amount
     * @param $info
     * @param null $type
     * @param null $data
     * @return array
     */
    public static function debit($user, $amount, $info, $type = null, $data = null)
    {
        try {
            $wallet = $user->wallet;

            // Check if wallet is active
            if ($wallet->status !== 'ACTIVE') {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            $prev_bal = $wallet->balance;

            $wallet->balance -= $amount;
            $wallet->updated_at = now();
            $wallet->save();

            $wallet->transactions()->create([
                'amount' => $amount,
                'type' => $type ?? 'DEBIT',
                'prev_balance' => $prev_bal,
                'new_balance' => $wallet->balance,
                'info' => $info,
                'data'  => $data
            ]);


            return [
                'success' => true,
                'message' => 'Wallet debit was successful.'
            ];

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public static function topUpCharge($amount)
    {
        $charge = 0;

        if ( $amount < 2500 ) {
            $charge = (.015 * $amount) + 10;
        }

        return $charge;
    }
}
