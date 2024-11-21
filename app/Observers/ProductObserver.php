<?php

namespace App\Observers;

use App\Mail\NewProductNotification;
use App\Mail\StockUpdateNotification;
use App\Model\Product;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param Product $product
     * @return void
     */
    public function created(Product $product)
    {
        $business = $product->business;

//        $business->expenses()->create([
//            'type'      => 'PRODUCT_PURCHASE',
//            'amount'    => collect($product->expenses)->sum('amount'),
//            'info'      => "Product purchase for " . $product->name
//        ]);

        $business->expenses()->create([
            'type'      => 'PRODUCT PURCHASE',
            'amount'    => $product->total_purchase_price,
            'info'      => "Product purchase (" . $product->name . ')'
        ]);

        $business->expenses()->create([
            'type'      => 'PRODUCT PURCHASE EXPENSES',
            'amount'    => collect($product->expenses)->sum('amount'),
            'info'      => "Product purchase for " . $product->name
        ]);

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' created product ' . $product->name,
        ]);

        $business->customers->each(function ($customer) use ($business, $product) {
            if ( !is_null($customer->user->email) ) {
                Mail::to(request()->user())->send(new NewProductNotification($business, $product, $customer));
            }
        });
    }

    /**
     * Handle the product "updated" event.
     *
     * @param Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
