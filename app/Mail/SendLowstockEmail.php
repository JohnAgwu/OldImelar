<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLowstockEmail extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $business;
    public $products;

    /**
     * Create a new message instance.
     *
     * @param $business
     * @param $products
     */
    public function __construct( $business, $products )
    {
        $this->business = $business;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->business->email, $this->business->name)
            ->from(env('NOREPLY'), env('APP_NAME'))
            ->subject("Product(s) running out of stock")
            ->markdown('pages.business.emails.lowstock');
    }
}
