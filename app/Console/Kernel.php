<?php

namespace App\Console;

use App\Model\Business;
use App\Model\Invoice;
use App\Repository\EbulkSMS;
use App\Repository\Rebrand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Yabacon\Paystack;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::info("Running Schedule.......");

//         Birthday & Holiday messages
         $schedule->call(function () {
             $this->sendBirthdayMessages();
             $this->sendHolidayMessages();
         })
             ->name('HOLIDAY_MESSAGES')
             ->withoutOverlapping()
//             ->everyMinute();
             ->dailyAt('06:00');


         // Invoice overdue
        $schedule->call(function () {
            $this->dueInvoicesReminder();
        })
            ->name('INVOICE_OVERDUE')
            ->withoutOverlapping()
//             ->everyMinute();
            ->twiceDaily();

        // Automatic invoice
        $schedule->call(function () {
            $this->automaticInvoice();
        })
            ->name('AUTO_INVOICE')
            ->withoutOverlapping()
//             ->everyMinute();
            ->dailyAt('06:00');


        $schedule->command('queue:work')->hourly();
    }

    protected function sendBirthdayMessages()
    {
        $businesses = Business::all();
        $businesses->each(function ( $business ) {
            $message = "Wishing a cherished customer and friend a very happy birthday celebration. Thank you for contributing the growth and success of the business";

            $business->customers->each(function ($customer) use ($business, $message) {
                if ( !is_null($customer->user->dob) && $customer->user->dob->format('m-d') == today()->format('m-d') ) {
                    Log::info($customer->user->dob . " : " . $customer->user->phone);

                    (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                }
            });
        });
    }

    protected function sendHolidayMessages()
    {
        $businesses = Business::all();

        // Independence day
        if ( today()->format('m-d') == '10-01') {
            $message = "Happy Independence day! Let’s make a strong decision to move our nation forward together in unity. Yes we can!";
            $businesses->each(function ( $business ) use ($message) {
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }

        // New year day
        if ( today()->format('m-d') == '01-01') {
            $message = "Happy new year! I wish you the best the year has to offer and good health";
            $businesses->each(function ( $business ) use ($message) {
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }

        // Democracy day
        if ( today()->format('m-d') == '06-12') {
            $businesses->each(function ( $business ) {
                $message = "Happy Democracy Day to you from {$business->name}";
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }


        // Workers’ Day
        if ( today()->format('m-d') == '05-01') {
            $businesses->each(function ( $business ) {
                $message = "Happy workers’ day to you from {$business->name}";
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }

        // Women’s day
        if ( today()->format('m-d') == '12-17') {
            $businesses->each(function ( $business ) {
                $message = "Cheers to every woman that have played significant roles in your life. \nHappy women’s day.";
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }

        // Boxing day
        if ( today()->format('m-d') == '12-26') {
            $businesses->each(function ( $business ) {
                $message = "Happy boxing day to you from {$business->name}";
                $business->customers->each(function ($customer) use ($business, $message) {
                    if ( !is_null($customer->user->phone) ) {
                        (new EbulkSMS())->toOne($message, $customer->user->phone, substr($business->name, 0, 10));
                    }
                });
            });
        }
    }

    protected function dueInvoicesReminder()
    {
        Invoice::whereDate('payment_due_date', today()->format('Y-m-d'))->each(function ( $invoice ) {
            $rebrand = Rebrand::brand(route('business.invoices.view', [$invoice->business_id, $invoice->id]));
            $branded = url($rebrand->brand);
            $message = "Invoice Overdue $branded";

            (new EbulkSMS())->toOne($message, $invoice->customer->user->phone, substr($invoice->business->name, 0, 10));
        });
    }

    protected function automaticInvoice()
    {
        $paystackSK = env('PAYSTACK_SK');
        $endpoint = "https://api.paystack.co/transaction/charge_authorization";

        Invoice::where('payment_option', 'AUTOMATIC')
            ->where('payment_status', '!=', 'FULLY PAID')
            ->whereDate('payment_due_date', today()->format('Y-m-d'))
            ->each(function ( $invoice ) use ($paystackSK, $endpoint) {
                $customer = $invoice->customer;
                $user = $customer->user;

                if ( $user->debitCards->count() > 0 ) {
                    Log::info($user->debitCards);
                    try{
                        $payload =  [
                            'authorization_code' => $user->debitCards[0]->authorization_code,
                            'email' => $user->email,
                            'amount' => ($invoice->products_sum - $invoice->amount_paid) * 100,
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $endpoint);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));  //Post Fields
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $headers = [
                            "Authorization: Bearer $paystackSK",
                            'Content-Type: application/json',
                        ];

                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $request = curl_exec ($ch);
                        curl_close ($ch);

                        Log::info('AUTOMATIC ====> ' . $request);

                        $response = json_decode($request);

                        $business = $invoice->business;

                        if ( !is_null($invoice->payments()->where('data->reference', $response->data->reference)->first()) ) {
                            return null;
                        }

                        if ($response->status == true) {
                            $data = $response->data;
                            $amount_paid = ($data->amount / 100) + $invoice->amount_paid;


                            // update invoice
                            $invoice->amount_paid = $amount_paid;
                            if ( $amount_paid >= $invoice->products_sum) {
                                $invoice->payment_status = 'FULLY PAID';
                            }
                            $invoice->save();

                            // save payment
                            $invoice->payments()->create(['data' => $data]);

                            $business->activities()->create([
                                'user_id'   => $business->user_id,
                                'info'      => request()->user()->name . ' paid for invoice(' . $invoice->id . ')',
                            ]);

                            return back();
                        }
                    }
                    catch(\Exception $e) {
                        Log::info('Automatic invoice payment ' . $user->email .' '. $e->getMessage());

                        return false;
                    }
                }
            });
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
