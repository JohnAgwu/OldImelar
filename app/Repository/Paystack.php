<?php
/**
 * Created by Canaan Etai.
 * Date: 1/25/20
 * Time: 9:36 AM
 */

namespace App\Repository;


use GuzzleHttp\Client;

class Paystack
{

    public static function getPaystack()
    {
        return new \Yabacon\Paystack(env('PAYSTACK_SK'));
    }

    public static function verify($reference)
    {
        try {
            $paystack = self::getPaystack();
            $response = $paystack->transaction->verify(['reference' => $reference]);

            if ($response->data->status == 'success') {
                return ['success' => true, 'data' => $response->data];
            }

            return ['success' => false, 'message' => 'Error verifying transaction'];

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    public static function createTransferRecipient($account_number, $account_name, $bank_code)
    {
        try {
            $payStackSK = env('PAYSTACK_SK');
            $endpoint = "https://api.paystack.co/transferrecipient";
            $data = [
                'type' => 'nuban',
                'name' => $account_name,
                'description' => 'Transfer recipient',
                'account_number' => $account_number,
                'bank_code' => $bank_code,
                'currency' => 'NGN',
            ];

            $headers = [
                "Authorization" => "Bearer $payStackSK",
                'Content-Type' => 'application/json',
                'Content-Length' => strlen(json_encode($data))
            ];

            $client = new Client();
            $res = $client->post($endpoint, [
                'headers'   => $headers,
                'json'      => $data
            ]);

            if ( $res->getStatusCode() == 200 || $res->getStatusCode() == 201 ) {
                return ['success' => true, 'data' => json_decode($res->getBody()->getContents(), true)];
            }
            else {
                return ['success' => false, 'message' => 'Error creating transfer recipient'];
            }
        }
        catch ( \Exception $exception ) {
            return ['success' => false, 'message' => $exception->getMessage()];
        }
    }


    public static function transfer($amount, $recipient_code, $narration)
    {
        try {
            $payStackSK = env('PAYSTACK_SK');
            $endpoint = "https://api.paystack.co/transfer";
            $data = [
                'source' => 'balance',
                'reason' => $narration,
                'amount' => $amount,
                'recipient' => $recipient_code,
            ];

            $headers = [
                "Authorization" => "Bearer $payStackSK",
                'Content-Type' => 'application/json',
                'Content-Length' => strlen(json_encode($data))
            ];

            $client = new Client();
            $res = $client->post($endpoint, [
                'headers'   => $headers,
                'json'      => $data
            ]);

            if ( $res->getStatusCode() == 200 || $res->getStatusCode() == 201 ) {
                return ['success' => true, 'data' => json_decode($res->getBody()->getContents(), true)];
            }
            else {
                return ['success' => false, 'message' => 'Error transferring to recipient'];
            }
        }
        catch ( \Exception $exception ) {
            return ['success' => false, 'message' => $exception->getMessage()];
        }
    }

}
