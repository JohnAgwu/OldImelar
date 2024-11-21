<?php

namespace App\Http\Controllers;

use App\Model\Config;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemsReturnedToSupplier extends Controller
{
    private $business;

    public function __construct( \App\Model\Business $model )
    {
        $this->business = $model;
    }

    public function index($business_id)
    {
        $business = $this->business->find($business_id);
//        dd($business->itemsReturnedBySupplier->toArray());

        return view('pages.business.items-returned-to-supplier.index', compact('business'));
    }

    public function indexJson($business_id)
    {
        $business = $this->business->with('itemsReturnedToSupplier.product')->find($business_id);

        return DataTables::of($business->itemsReturnedToSupplier)->toJson();
    }

    public function add($business_id)
    {
        $business = $this->business->find($business_id);
        $purchaseExpenses = json_decode(Config::where('name', 'PURCHASE_EXPENSES')->first()->value);

        return view('pages.business.items-returned-to-supplier.add', compact('business', 'purchaseExpenses'));
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

            $business->itemsReturnedToSupplier()->create($data);

            // update product.
            $product->quantity = $product->quantity - (int) \request('quantity');
            $product->total_purchase_price = $product->total_purchase_price - $data['amount'];
            $product->updated_at = now();
            $product->save();

            $business->expenses()->create([
                'type'      => 'ITEMS_RETURNED_TO_SUPPLIER',
                'amount'    => $data['amount'],
                'info'      => \request('expenses')
            ]);

            return redirect(route('business.items.returned.to.supplier', [$business_id]));
        }
        catch (\Exception $exception ) {
            return back()->with('error', 'Error saving returned item');
        }
    }
}
