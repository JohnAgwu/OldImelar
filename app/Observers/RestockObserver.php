<?php

namespace App\Observers;

use App\Mail\SendLowstockEmail;
use App\Mail\StockUpdateNotification;
use App\Model\ProductStock;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RestockObserver
{
    /**
     * Handle the product stock "created" event.
     *
     * @param  \App\Model\ProductStock  $productStock
     * @return void
     */
    public function created(ProductStock $productStock)
    {
        if(!request()->has('type')) {
            $product = $productStock->product;
            $business = $product->business;

            $business->expenses()->create([
                'type'      => 'PRODUCT RESTOCK',
                'amount'    => (double) request()->total_purchase_price,
                'info'      => "Restock for " . $product->name
            ]);

            $business->expenses()->create([
                'type'      => 'PRODUCT RESTOCK EXPENSES',
                'amount'    => (double) collect(request()->expenses)->sum('amount'),
                'info'      => "Restock expenses for " . $product->name
            ]);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' restock product ' . $product->name,
            ]);

            $business->customers->each(function ($customer) use ($business, $product) {
                if ( !is_null($customer->user->email)) {
                    Mail::to(request()->user())->send(new StockUpdateNotification($business, $product, $customer));
                }
            });
        }
    }

    /**
     * Handle the product stock "updated" event.
     *
     * @param  \App\Model\ProductStock  $productStock
     * @return void
     */
    public function updated(ProductStock $productStock)
    {
        //
    }

    /**
     * Handle the product stock "deleted" event.
     *
     * @param  \App\Model\ProductStock  $productStock
     * @return void
     */
    public function deleted(ProductStock $productStock)
    {
        //
    }

    /**
     * Handle the product stock "restored" event.
     *
     * @param  \App\Model\ProductStock  $productStock
     * @return void
     */
    public function restored(ProductStock $productStock)
    {
        //
    }

    /**
     * Handle the product stock "force deleted" event.
     *
     * @param  \App\Model\ProductStock  $productStock
     * @return void
     */
    public function forceDeleted(ProductStock $productStock)
    {
        //
    }
}
