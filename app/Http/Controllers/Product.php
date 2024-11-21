<?php

namespace App\Http\Controllers;


use App\Mail\StockUpdateNotification;
use App\Model\Config;
use App\Model\Payable;
use App\Model\ProductStock;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Product extends Controller
{
    private $model;
    private $business;

    public function __construct( \App\Model\Product $model, \App\Model\Business $business )
    {
        $this->model = $model;
        $this->business = $business;
    }

    public function index($business_id)
    {
        $business = $this->business->with('products.image')->find($business_id);
//        dd($business->products->toArray());

        return view('pages.business.product.index', compact('business'));
    }

    public function create( $business_id )
    {
        $business = $this->business->find($business_id);
        $unitOfMearsurement = Config::where('name', 'UNIT_OF_MEASUREMENT')->first()->value;
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $purchaseExpenses = Config::where('name', 'PURCHASE_EXPENSES')->first()->value;

        return view('pages.business.product.add', compact('business', 'unitOfMearsurement', 'paymentStatus', 'purchaseExpenses'));
    }

    public function store( $business_id )
    {
        try {
            request()->request->set('type', 'ADD_PRODUCT');

            $data = request()->except(['_token', 'image']);
            unset($data['type']);
            $data['purchase_expenses'] = (double) collect(request('expenses'))->sum('amount');

            $data['expenses'] = collect(request('expenses'))->values()->toArray();

            $business = $this->business->find($business_id);
            $product = $business->products()->create($data);

            $product->stocks()->create([
                'quantity'  => request('quantity'),
                'total_purchase_price' => $data['total_purchase_price'],
                'amount_paid' => $data['amount_paid'] ?? null,
                'purchase_expenses' => $data['purchase_expenses'],
                'expenses' => $data['expenses'],
            ]);

            switch (request('payment_status')) {
                case 'UNPAID':
                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price')]);
                    break;

                case 'PART PAYMENT':
                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price') - (double) request('amount_paid')]);
                    break;
            }

            if ( request()->has('image') && !empty(request('image'))) {
                $file = 'images/product/' . Str::random() . '_p-' . $product->id .'.jpg';
                $image = Image::make(request('image'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream('jpg'));

                $product->image()->create(['path' => $file]);
            }

            return redirect(route('business.products', ['business_id' => $business_id]))->with('message', 'Product added successfully');
        }
        catch ( \Exception $exception ) {
//            $business = $this->business->find($business_id);
//            dd($exception->getMessage(), $business->toArray());
            return back()->with('error', 'Error adding new product')->withInput();
        }
    }

    public function update( $business_id, $product_id )
    {
        try {
            $business = $this->business->find($business_id);
            $data = request()->except(['_token', 'image']);
            $data['purchase_expenses'] = (double) collect(request('expenses'))->sum('amount');
            $data['expenses'] = collect(request('expenses'))->values()->toArray();

            $product = $this->model->find($product_id);
            $product->update($data);

            $stock = $product->stocks()->orderBy('id', 'desc')->first();
            $stock->quantity = $data['quantity'];
            $stock->total_purchase_price = $data['total_purchase_price'];
            $stock->amount_paid = $data['amount_paid'] ?? 0;
            $stock->purchase_expenses = $data['purchase_expenses'];
            $stock->expenses = $data['expenses'];
            $stock->save();

//            switch (request('payment_status')) {
//                case 'UNPAID':
//                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price')]);
//                    break;
//
//                case 'PART PAYMENT':
//                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price') - (double) request('amount_paid')]);
//                    break;
//            }

            if ( request()->has('image') && !empty(request('image'))) {
                $file = $product->image->path;
                $image = Image::make(request('image'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream('jpg'));

                $product->image->path = $file;
                $product->image->save();
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' updated product ' . $product->name,
            ]);

            return redirect(route('business.products', ['business_id' => $business_id]))->with('message', 'Product updated successfully');
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error adding new product')->withInput();
        }
    }

    public function edit($business_id, $product_id)
    {
        $product = $this->model->with('image')->find($product_id);
        $business = $this->business->find($business_id);
        $unitOfMearsurement = Config::where('name', 'UNIT_OF_MEASUREMENT')->first()->value;
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $purchaseExpenses = Config::where('name', 'PURCHASE_EXPENSES')->first()->value;

        return view('pages.business.product.edit', compact('product', 'business', 'unitOfMearsurement', 'paymentStatus', 'purchaseExpenses'));
    }

    public function destroy($business_id, $product_id)
    {
        $this->model->find($product_id)->delete();

        return back()->with('messgae', 'product deleted successfully');
    }

    public function restock($business_id, $product_id)
    {
        if(request()->method() == 'GET') {
            $product = $this->model->with('image')->find($product_id);
            $business = $this->business->find($business_id);
            $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
            $purchaseExpenses = Config::where('name', 'PURCHASE_EXPENSES')->first()->value;

            return view('pages.business.product.restock', compact('product', 'business', 'paymentStatus', 'purchaseExpenses'));
        }

        // POST
        try {
            $data = request()->except(['_token', 'image']);

            $business = $this->business->find($business_id);
            $product = $this->model->find($product_id);

            $product->quantity = $product->quantity + (int) $data['quantity'];
            $product->total_purchase_price = $product->total_purchase_price + (int) $data['total_purchase_price'];
            $product->purchase_expenses = $product->purchase_expenses + (double) collect(request('expenses'))->sum('amount');
            $product->amount_paid = $product->amount_paid + (double) ($data['amount_paid'] ?? 0);
            $product->expenses = collect($data['expenses'])->merge($product->expenses);
            $product->payment_status = $data['payment_status'];
            $product->save();

            $product->stocks()->create([
                'quantity'  => request('quantity'),
                'total_purchase_price' => $data['total_purchase_price'],
                'amount_paid' => $data['amount_paid'] ?? null,
                'purchase_expenses' => collect(request('expenses'))->sum('amount'),
                'expenses' => $data['expenses'],
            ]);

            switch (request('payment_status')) {
                case 'UNPAID':
                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price')]);
                    break;

                case 'PART PAYMENT':
                    $product->payable()->create(['business_id' => $business_id, 'amount' => (double) request('total_purchase_price') - (double) request('amount_paid')]);
                    break;
            }

            return redirect(route('business.products', ['business_id' => $business_id]))->with('message', 'Product stock updated successfully');
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error adding to stock')->withInput();
        }
    }

    public function productStocks($business_id, $product_id)
    {
        $product = $this->model->with('image')->find($product_id);
        $business = $this->business->find($business_id);

        return view('pages.business.product.stocks', compact('product', 'business'));
    }

    public function deleteStock($business_id, $stock)
    {
        $business = $this->business->find($business_id);
        ProductStock::find($stock)->delete();

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' delete product stock'
        ]);

        return back()->with('message', 'Stock deleted successfully');
    }
}
