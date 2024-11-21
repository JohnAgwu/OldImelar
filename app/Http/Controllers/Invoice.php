<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoiceEmail;
use App\Mail\SendLowstockEmail;
use App\Model\Config;
use App\Model\Customer;
use App\Model\Receivable;
use App\Repository\EbulkSMS;
use App\Repository\Paystack;
use App\Repository\Rebrand;
use App\Repository\Wallet;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class Invoice extends Controller
{
    private $model;
    private $business;
    private $product;

    public function __construct( \App\Model\Invoice $model, \App\Model\Product $product, \App\Model\Business $business )
    {
        $this->model = $model;
        $this->business = $business;
        $this->product = $product;
    }

    public function index($business_id)
    {
        $business = $this->business->with('invoices')->find($business_id);
        return view('pages.business.invoice.index', compact('business'));
    }

    public function indexJson($business_id)
    {
        $business = $this->business->find($business_id);
        if ( $business->isFreelance() ) {
            $invoices = $this->model->where('business_id', $business_id)
                ->with(['projects.project', 'customer.user'])
                ->orderBy('id', 'desc')->get();
        }
        else {
            $invoices = $this->model->where('business_id', $business_id)
                ->with(['products.product', 'customer.user'])
                ->orderBy('id', 'desc')->get();
        }

        return datatables()->of($invoices)->toJson();
    }

    public function received()
    {
        return view('pages.business.invoice.received');
    }

    public function invoicesReceivedJson()
    {
        $invoices = $this->model->with(['business', 'product'])->where('customer_email', auth()->user()->email)->get();
//        dd($invoices[0]->toArray());

        return DataTables::of($invoices)->toJson();
    }

    public function viewInvoice($business_id, $invoice_id)
    {
        $invoice = $this->model->with(['products', 'customer.user'])->find($invoice_id);
        $debitCards = auth()->check() ? auth()->user()->debitCards : [];

        return view('pages.business.invoice.view', compact('invoice', 'debitCards'));
    }

    public function loginViewInvoice($business_id, $invoice_id)
    {
        session()->flash('invoice_url', session()->previousUrl());

        return \redirect('/login');
    }

    public function create( $business_id, $product_id = null )
    {
        $business = $this->business->with(['products', 'projects'])->find($business_id);
        $customers = $business->customers()->with('user')->get();
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $paymentMethods = Config::where('name', 'PAYMENT_METHODS')->first()->value;
        $channels = Config::where('name', 'CHANNELS')->first()->value;
        $businessExpenses = Config::where('name', 'BUSINESS_EXPENSES')->first()->value;
        $banks = $business->banks;

//        dd($banks);

        return view('pages.business.invoice.send', compact('business', 'customers', 'paymentStatus', 'paymentMethods', 'banks', 'channels', 'businessExpenses', 'product_id'));
    }

    public function store( $business_id )
    {
        try {
            $business = $this->business->find($business_id);
            $request = request()->except(['_token', 'save', 'bank', 'products', 'projects']);
            $request['expenses_incurred'] = (double) collect(request('expenses'))->sum('amount');

            if ( $business->isFreelance() ) {
                $rProjects = collect([]);
                collect(request('projects'))->map(function ($project) use (&$rProjects) {
                    $rProjects->put($project['project_id'], $project);
                });

                $projectTitles = '';
                $projects = \App\Model\Project::whereIn('id', $rProjects->map(function($p, $index) {
                    return $index;}))->get();
                $projects->map(function($p, $i) use (&$projectTitles) {
                    $projectTitles .= $p->title;
                });
            }
            else {
                $rProducts = collect([]);
                collect(request('products'))->map(function ($product) use (&$rProducts) {
                    $rProducts->put($product['product_id'], $product);
                });

                $products = \App\Model\Product::whereIn('id', $rProducts->map(function($p, $index) {
                    return $index;}))->get();

                foreach ($products as $product) {
                    if ((int) $rProducts[$product->id]['quantity'] > $product->quantity) {
                        return back()->with('error', 'Product is out of stock')->withInput();
                    }
                }
            }

            if ( request('action') == 'save' ) {
                $request['completed'] =  false;
            }
            else {
                $request['completed'] =  true;
            }

            $customer = Customer::find($request['customer_id']);

            unset($request['action']);

            $request['customer_id'] = $customer->id;
            if ( $request['payment_status'] == 'FULLY PAID' ) {
                if ( $business->isFreelance() ) {
                    $request['amount_paid'] = $rProjects->sum('price');
                } else {
                    $request['amount_paid'] = $rProducts->sum('amount');
                }
            }


            $invoice = $business->invoices()->create($request);
            if ( $business->isFreelance() ) {
                $invoice->projects()->createMany(
                    $rProjects->toArray()
                );
            } else {
                $invoice->products()->createMany(
                    $rProducts->toArray()
                );
            }


            // update product.
            if ( !$business->isFreelance() ) {
                $products = $invoice->products;
                $lowStock = [];
                $products->each(function ($p) use ($invoice, &$lowStock) {
                    $p->product->quantity -= $p->quantity;
                    $p->product->save();

                    $pr = \App\Model\Product::find($p->product->id);
                    if ( $pr->quantity < 4 ) {
                        array_push($lowStock, $pr);
                    }
                });
            }

            // business expenses
            if ( $business->isFreelance() ) {
                $business->expenses()->create([
                    'type'      => 'PROJECT EXPENSES',
                    'amount'    => collect(request('expenses'))->sum('amount'),
                    'info'      => "Project expenses for (".$projectTitles.")"
                ]);
            }
            else {
                $business->expenses()->create([
                    'type'      => 'PRODUCT SALES',
                    'amount'    => collect(request('expenses'))->sum('amount'),
                    'info'      => "Product sales for (".$product->name.")"
                ]);
            }

            switch ($request['payment_status']) {
                case 'UNPAID':
                    if ( $business->isFreelance() ) {
                        $projects->each(function ($p) use ($invoice, $business_id, $request, $rProjects) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'project_id' => $p->id,
                                'amount' => (double) $rProjects->sum('price'), 'payment_method' => $request['payment_method'] ?? null
                            ]);
                        });
                    }
                    else {
                        $products->each(function ($p) use ($invoice, $business_id, $request, $rProducts) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'product_id' => $p->product->id,
                                'amount' => (double) $rProducts->sum('amount'), 'payment_method' => $request['payment_method'] ?? null
                            ]);
                        });
                    }
                    break;

                case 'PART PAYMENT':
                    if ( $business->isFreelance() ) {
                        $business->incomes()->create([
                            'type'      => 'PROJECT INCOME',
                            'amount'    => $request['amount_paid'],
                            'info'      => "Product sales for (".$projectTitles.")"
                        ]);
                        $projects->each(function ($p) use ($invoice, $business_id, $request, $rProjects) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'project_id' => $p->id,
                                'payment_method' => $request['payment_method'],
                                'amount' => (double) $rProjects->sum('price') - (double) $request['amount_paid']
                            ]);
                        });
                    }
                    else {
                        $business->incomes()->create([
                            'type'      => 'PRODUCT SALES',
                            'amount'    => $request['amount_paid'],
                            'info'      => "Product sales for (".$product->name.")"
                        ]);
                        $products->each(function ($p) use ($invoice, $business_id, $request, $rProducts) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'product_id' => $p->id,
                                'payment_method' => $request['payment_method'],
                                'amount' => (double) $rProducts->sum('amount') - (double) $request['amount_paid']
                            ]);
                        });
                    }
                    break;

                case 'FULLY PAID':
                    if ( $business->isFreelance() ) {
                        $business->incomes()->create([
                            'type'      => 'PROJECT INCOME',
                            'amount'    => collect(request('projects'))->sum('price'),
                            'info'      => "Product sales for (".$projectTitles.")"
                        ]);
                    }
                    else {
                        $business->incomes()->create([
                            'type'      => 'PRODUCT SALES',
                            'amount'    => collect(request('products'))->sum('amount'),
                            'info'      => "Product sales for (".$product->name.")"
                        ]);
                    }
                    break;
            }

            // send invoice;
            if ( request('action') == 'send' ) {
                // send invoice;
                if ( $invoice->sending_channel == 'WHATSAPP' ) {
                    $invoice->sending_channel = 'SMS';
                }

                $this->sendInvoice($invoice->sending_channel, $invoice);

                $business->activities()->create([
                    'user_id'   => $business->user_id,
                    'info'      => request()->user()->name . ' sent invoice(' . $invoice->id . ') for ' . $business->name,
                ]);

                // send lowstock warning email
                if ( !$business->isFreelance() ) {
                    if ( sizeof($lowStock ) > 0 ) {
                        Mail::to(request()->user())->sendNow(new SendLowstockEmail($business, $lowStock));
                    }
                }

                return redirect(route('business.invoices', ['business_id' => $business_id]))->with('message', 'Invoice sent successfully');
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' added invoice(' . $invoice->id . ') for ' . $business->name,
            ]);

            return redirect(route('business.invoices.edit', [$business_id, $invoice->id]))->with('message', 'Invoice saved successfully!');
        }
        catch ( \Exception $exception ) {
            dd($exception->getMessage(), $exception->getLine());
            return back()->with('error', 'Error saving invoice')->withInput();
        }
    }

    public function edit( $business_id, $invoice_id )
    {
        $invoice = $this->model->with(['products', 'projects', 'customer.user'])->find($invoice_id);
        $business = $this->business->with(['products', 'projects'])->find($business_id);
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $paymentMethods = Config::where('name', 'PAYMENT_METHODS')->first()->value;
        $channels = Config::where('name', 'CHANNELS')->first()->value;
        $banks = $business->banks;

        return view('pages.business.invoice.edit', compact('invoice', 'business', 'paymentStatus', 'paymentMethods', 'banks', 'channels'));
    }

    public function update( $business_id, $invoice_id )
    {
        try {
//            dd(request()->all());
            $request = request()->except(['_token', 'save', 'bank', 'products', 'projects']);
            $business = $this->business->find($business_id);
            $invoice = $this->model->find($invoice_id);
            $projects = $invoice->projects;
            $products = $invoice->products;

            if ( $business->isFreelance() ) {
                $rProjects = collect([]);
                collect(request('projects'))->map(function ($project) use (&$rProjects) {
                    $rProjects->put($project['project_id'], $project);
                });

                $projectTitles = '';
                $pjts = \App\Model\Project::whereIn('id', $rProjects->map(function($p, $index) {
                    return $index;}))->get();
                $pjts->map(function($p, $i) use (&$projectTitles) {
                    $projectTitles .= $p->title;
                });
            }
            else {
                $rProducts = collect([]);
                collect(request('products'))->map(function ($product) use (&$rProducts) {
                    $rProducts->put($product['product_id'], $product);
                });

                foreach ($products as $p) {
                    $product = $p->product;
                    if ((int) $rProducts[$p->product_id]['quantity'] > $product->quantity) {
                        return back()->with('error', 'Product is out of stock')->withInput();
                    }
                }
            }

            switch ($request['payment_status']) {
                case 'UNPAID':
                    if ( $business->isFreelance() ) {
                        $projects->each(function ($p) use ($invoice, $business_id, $request, $rProjects) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'project_id' => $p->id,
                                'amount' => (double) $rProjects->sum('price'), 'payment_method' => $request['payment_method'] ?? null
                            ]);
                        });
                    }
                    else {
                        $products->each(function ($p) use ($invoice, $business_id, $request, $rProducts) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'product_id' => $p->product->id,
                                'amount' => (double) $rProducts->sum('amount'), 'payment_method' => $request['payment_method'] ?? null
                            ]);
                        });
                    }
                    break;

                case 'PART PAYMENT':
                    if ( $business->isFreelance() ) {
                        $business->incomes()->create([
                            'type'      => 'PROJECT INCOME',
                            'amount'    => $request['amount_paid'],
                            'info'      => "Product sales for (".$projectTitles.")"
                        ]);
                        $projects->each(function ($p) use ($invoice, $business_id, $request, $rProjects) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'project_id' => $p->id,
                                'payment_method' => $request['payment_method'],
                                'amount' => (double) $rProjects->sum('price') - (double) $request['amount_paid']
                            ]);
                        });
                    }
                    else {
                        $business->incomes()->create([
                            'type'      => 'PRODUCT SALES',
                            'amount'    => $request['amount_paid'],
                            'info'      => "Product sales for (".$product->name.")"
                        ]);
                        $products->each(function ($p) use ($invoice, $business_id, $request, $rProducts) {
                            $invoice->receivable()->create([
                                'business_id' => $business_id, 'product_id' => $p->product->id,
                                'payment_method' => $request['payment_method'],
                                'amount' => (double) $rProducts->sum('amount') - (double) $request['amount_paid']
                            ]);
                        });
                    }
                    break;

                case 'FULLY PAID':
                    if ( $business->isFreelance() ) {
                        $business->incomes()->create([
                            'type'      => 'PROJECT INCOME',
                            'amount'    => collect(request('projects'))->sum('price'),
                            'info'      => "Product sales for (".$projectTitles.")"
                        ]);
                    }
                    else {
                        $business->incomes()->create([
                            'type'      => 'PRODUCT SALES',
                            'amount'    => collect(request('products'))->sum('amount'),
                            'info'      => "Product sales for (".$product->name.")"
                        ]);
                    }
                    break;
            }

            if ( request('action') =='save' ) {
                $request['completed'] =  false;
            }
            else {
                $request['completed'] =  true;
            }


            $customer = Customer::find($request['customer_id']);
            $request['customer_id'] = $customer->id;

            unset($request['action']);


            if ( !$business->isFreelance() ) {
                // Update product
                $products->each(function ($p) use ($invoice, $request, $rProducts) {
                    $quantity = (int) $rProducts[$p->product_id]['quantity'];
                    if ( $quantity > $p->quantity ) {
                        $p->product->quantity -= ($quantity - $p->quantity);
                        $p->product->save();
                    }

                    if ( $p->quantity > $quantity ) {
                        $p->product->quantity += ($p->quantity - $quantity);
                        $p->product->save();
                    }

                    $p->quantity = $quantity;
                    $p->amount = (double) $rProducts[$p->product_id]['amount'];
                    $p->save();
                });
            }

            $invoice->update($request);


            // send invoice;
            if ( request('action') == 'send' ) {
                if ( $invoice->sending_channel == 'WHATSAPP' ) {
                    $invoice->sending_channel = 'SMS';
                }
                $this->sendInvoice($invoice->sending_channel, $invoice);

                $business->activities()->create([
                    'user_id'   => $business->user_id,
                    'info'      => request()->user()->name . ' updated and sent invoice(' . $invoice->id . ') for ' . $business->name,
                ]);

                return redirect(route('business.invoices', [$business_id]))->with('message', 'Invoice sent successfully');
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' updated invoice(' . $invoice->id . ') for ' . $business->name,
            ]);
            return redirect(route('business.invoices', [$business_id]))->with('message', 'Invoice updated successfully!');
        }
        catch ( \Exception $exception ) {
            dd($exception->getMessage(), $exception->getLine());
            return back()->with('error', 'Error updating invoice')->withInput();
        }
    }

    public function deleteInvoice( $business_id, $invoice_id )
    {
        try {
            $invoice = $this->model->with(['products', 'customer.user'])->find($invoice_id);
            Receivable::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();

            return back()->with('message', 'Invoice deleted successfully');
        }
        catch (\Exception $exception) {
            return back()->with('error', 'Error deleting invoice');
        }
    }

    public function resend( $business_id, $invoice_id )
    {
        try {
            $business = $this->business->find($business_id);
            $invoice = $this->model->find($invoice_id);

            // send invoice;
            if ( $invoice->sending_channel == 'WHATSAPP' ) {
                return $this->sendInvoice($invoice->sending_channel, $invoice);
            }

            $this->sendInvoice($invoice->sending_channel, $invoice);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' re-sent invoice(' . $invoice->id . ') for ' . $business->name,
            ]);

            return back()->with('message', 'Invoice sent successfully');
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error re-sending invoice')->withInput();
        }
    }


    public function makePayment( $business_id, $invoice_id, $ref )
    {
        try {
            $business = $this->business->find($business_id);
            $invoice = $this->model->find($invoice_id);

            $products = '';
            $invoice->products->each(function ($p) use (&$products) {
                if ( $products == '' ) {
                    $products .= ''. $p->product->name;
                } else {
                    $products .= ', '. $p->product->name;
                }
            });

//            if ( !is_null($invoice->payments()->where('data->reference', $ref)->first()) ) {
//                return back()->with('error', 'Payment already exist');
//            }

            $response = Paystack::verify($ref);

            if ($response['success']) {
                $data = $response['data'];
                $amount_paid = ($data->amount / 100) + $invoice->amount_paid;

                // update invoice
                $invoice->amount_paid = $amount_paid;
                if ( $amount_paid >= $invoice->products_sum) {
                    $invoice->payment_status = 'FULLY PAID';
                }
                $invoice->save();

                // save payment
                $invoice->payments()->create(['data' => $data]);

                // update wallet
                Wallet::credit(auth()->user(), ($data->amount / 100), 'Invoice(#'.$invoice->id. ') payment');

                $business->incomes()->create([
                    'type'      => 'INVOICE PAYMENT',
                    'amount'    => $data->amount / 100,
                    'info'      => "Product sales for (".$products.")"
                ]);

                $business->activities()->create([
                    'user_id'   => $business->user_id,
                    'info'      => request()->user()->name . ' paid for invoice(' . $invoice->id . ')',
                ]);

                return back();
            }
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error validating payment');
        }
    }


    private function sendInvoice($channel, $invoice) {
        switch ($channel) {
            case 'EMAIL':
                Mail::to(request()->user())->sendNow(new SendInvoiceEmail($invoice, $invoice->customer->user));
                break;

            case 'SMS':
                $rebrand = Rebrand::brand(route('business.invoices.view', [$invoice->business_id, $invoice->id]));
                $branded = url($rebrand->brand);
                $message = "Invoice nos: #".str_pad($invoice->id, 8, '0', STR_PAD_LEFT). "\n Total Due: N".($invoice->products_sum - $invoice->amount_paid). "\n Grand Total: N".$invoice->products_sum."\n Thanks for your patronage. Click $branded to view invoice";

                (new EbulkSMS())->toOne($message, $invoice->customer->user->phone, substr($invoice->business->name, 0, 10));
                break;

            case 'WHATSAPP':
                $rebrand = Rebrand::brand(route('business.invoices.view', [$invoice->business_id, $invoice->id]));
                $branded = url($rebrand->brand);
                $message = 'Hello ' . explode(' ', $invoice->customer->user->name)[0] . ', your invoice is ready! Kindly click ' . $branded . ' to view and make payment. Thank you very much for your patronage.';
                $path = 'whatsapp://send?text=' . urlencode($message);
                if ( request()->has('device') && request('device') == 'desktop') {
                    $path = 'https://web.whatsapp.com/send?text=' . urlencode($message);
                }
                return Redirect::away($path);
                break;
        }
    }
}
