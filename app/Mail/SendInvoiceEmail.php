<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceEmail extends Mailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $invoice;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $customer)
    {
        $this->invoice = $invoice;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->invoice->url = route('business.invoices.view', [$this->invoice->business_id, $this->invoice->id]);

        return $this->to($this->customer->email, $this->customer->name)
            ->from($this->invoice->business->email, $this->invoice->business->name)
            ->subject("Invoice from " . $this->invoice->business->name)
            ->markdown('pages.business.emails.invoice');
    }
}
