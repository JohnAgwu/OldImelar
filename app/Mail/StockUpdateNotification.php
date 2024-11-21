<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockUpdateNotification extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $business;
    public $product;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @param $business
     * @param $product
     * @param $customer
     */
    public function __construct( $business, $product, $customer )
    {
        $this->business = $business;
        $this->product = $product;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->customer->user->email, $this->customer->user->name)
            ->from($this->business->email, $this->business->name)
            ->subject("Restock alert!")
            ->markdown('pages.business.emails.stock-update');
    }
}
