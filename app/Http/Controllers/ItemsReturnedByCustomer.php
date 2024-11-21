<?php

namespace App\Http\Controllers;

use App\Model\Config;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemsReturnedByCustomer extends Controller
{
    private $business;

    public function __construct( \App\Model\Business $model )
    {
        $this->business = $model;
    }

    public function index($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.items-returned-by-customer.index', compact('business'));
    }

    public function indexJson($business_id)
    {
        $business = $this->business->with('itemsReturnedByCustomer.product')->find($business_id);
//        dd($business->itemsReturnedByCustomer->toArray());

        return DataTables::of($business->itemsReturnedByCustomer)->toJson();
    }

    public function add($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.items-returned-by-customer.add', compact('business'));
    }

    public function addFetch($business_id)
    {
        $purchaseExpenses = json_decode(Config::where('name', 'PURCHASE_EXPENSES')->first()->value);
        $business = $this->business->find($business_id);
        $invoice = \App\Model\Invoice::with('products.product')
            ->find(\request('invoice_id'));

        if ( is_null($invoice) ) {
            return back()->withInput()->with('error', "Invalid Invoice Number");
        }

        return view('pages.business.items-returned-by-customer.add-item', compact('business', 'purchaseExpenses', 'invoice'));
    }

    public function save($business_id)
    {
        try {
            $business = $this->business->find($business_id);
            $product = \App\Model\Product::find(request('product_id'));

            $data = \request()->except('_token');
            $data['amount'] = (double) $data['amount'];
            $data['expenses'] = (double) $data['expenses_amount'];
            unset($data['expenses_amount']);

            $business->itemsReturnedByCustomer()->create($data);

            // update product.
            $product->quantity = $product->quantity + (int) \request('quantity');
            $product->total_purchase_price = $product->total_purchase_price + (double) $data['amount'];
            $product->updated_at = now();
            $product->save();

            $business->expenses()->create([
                'type'      => 'ITEMS_RETURNED_BY_CUSTOMER',
                'amount'    => $data['amount'],
                'info'      => \request('expenses')
            ]);

            return redirect(route('business.items.returned.by.customer', [$business_id]));
        }
        catch (\Exception $exception ) {
            dd($exception->getMessage());
            return back()->with('error', 'Error saving returned item');
        }
    }
}
