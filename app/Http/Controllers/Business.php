<?php

namespace App\Http\Controllers;

use App\Model\BusinessMessage;
use App\Model\Config;
use App\Model\PromoPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class Business extends Controller
{
    private $model;

    public function __construct(\App\Model\Business $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $user = auth()->user();
        $businesses = $user->businesses;

        return view('pages.business.index', compact('businesses'));
    }

    public function businessDashboard($id)
    {
        $business = $this->model->find($id);

        $totalIncome = $business->invoices()
            ->where('payment_status', 'FULLY PAID')
            ->get()
            ->each(function ($inv) {
                $inv->amount = $inv->products()->sum('amount');
                return $inv;
            })->sum('amount');
        $totalIncome += $business->invoices()->where('payment_status', 'PART PAYMENT')->sum('amount_paid');

        // daily sales.
        $dailySales = $business->invoices()
            ->whereDate('created_at', today())
            ->get()->sum('products_sum');

        // monthly sales
        $monthlySales = $business->invoices()
            ->whereDate('created_at', '>=', today()->startOfMonth())
            ->whereDate('created_at', '<=', today()->endOfMonth())
            ->get()->sum('products_sum');

        // monthly sales
        $yearlySales = $business->invoices()
            ->whereDate('created_at', '>=', today()->startOfYear())
            ->whereDate('created_at', '<=', today()->endOfYear())
            ->get()->sum('products_sum');


        return view('pages.business.dashboard', compact('business', 'totalIncome', 'dailySales', 'monthlySales', 'yearlySales'));
    }

    public function create()
    {
        $ipinfo = json_encode(geoip($ip = '197.255.168.13')->toArray());

        $business_types = json_decode(Config::where('name', 'BUSINESS_TYPES')->first()->value);
        $social_accounts = json_decode(Config::where('name', 'SOCIAL_ACCOUNTS')->first()->value);

        return view('pages.business.add', compact('business_types', 'social_accounts', 'ipinfo'));
    }

    public function store()
    {
        try {
            $social_accounts = json_decode(Config::where('name', 'SOCIAL_ACCOUNTS')->first()->value);
            $payload = request()->except('_token');

            foreach ($payload['social'] as $key => $social) {
                if (!in_array(strtoupper($social['type']), collect($social_accounts)->values()->toArray())) {
                    unset($payload['social'][$key]);
                }
            }

            $business = request()->user()->businesses()->create($payload);

//            dd($payload);

            // save logo
            if (request()->has('logo')) {
                $file = 'images/business/' . Str::random() . '_business-' . $business->id . '.' . request('logo')->extension();
                $image = Image::make(request('logo'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream(request('logo')->extension()));

                $business->logo = $file;
                $business->save();
            }

            // save cover
            if (request()->has('cover')) {
                $file = 'images/business/' . Str::random() . '_business-' . $business->id . '.' . request('cover')->extension();
                $image = Image::make(request('cover'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream(request('cover')->extension()));

                $business->cover = $file;
                $business->save();
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' added a business ' . $business->name . ' )',
            ]);

            return redirect(route('my-business'))->with('message', 'Business(' . $business->name . ') updated successfully');
        } catch (\Exception $exception) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error adding business');
        }
    }

    public function edit($business_id)
    {
        $business = $this->model->find($business_id);
        $social = $business->social;
        switch (sizeof($social)) {
            case 2:
                array_push($social, ['type' => Str::random(), 'value' => '']);
                break;
            case 1:
                array_push($social, ['type' => Str::random(), 'value' => '']);
                array_push($social, ['type' => Str::random(), 'value' => '']);
                break;
            case 0:
                array_push($social, ['type' => Str::random(), 'value' => '']);
                array_push($social, ['type' => Str::random(), 'value' => '']);
                array_push($social, ['type' => Str::random(), 'value' => '']);
                break;
        }
        $business->social = $social;
        $business->logo = asset('storage/' . $business->logo);
        $business->cover = asset('storage/' . $business->cover);
//        dd($business->toArray());
        $business_types = json_decode(Config::where('name', 'BUSINESS_TYPES')->first()->value);
        $social_accounts = json_decode(Config::where('name', 'SOCIAL_ACCOUNTS')->first()->value);

        return view('pages.business.edit', compact('business', 'business_types', 'social_accounts'));
    }

    public function update($business_id)
    {
        try {
            $business = $this->model->find($business_id);
            $social_accounts = json_decode(Config::where('name', 'SOCIAL_ACCOUNTS')->first()->value);
            $payload = request()->all();

            foreach ($payload['social'] as $key => $social) {
                if (!in_array(strtoupper($social['type']), collect($social_accounts)->values()->toArray())) {
                    unset($payload['social'][$key]);
                }
            }

            $business->update($payload);

            // save logo
            if (request()->has('logo')) {
                $file = 'images/business/' . Str::random() . '_business-' . $business->id . '.' . request('logo')->extension();
                $image = Image::make(request('logo'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream(request('logo')->extension()));

                $business->logo = $file;
                $business->save();
            }

            // save cover
            if (request()->has('cover')) {
                $file = 'images/business/' . Str::random() . '_business-.' . $business->id . request('cover')->extension();
                $image = Image::make(request('cover'));
                $image->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                Storage::disk('public')->put($file, $image->stream(request('cover')->extension()));

                $business->cover = $file;
                $business->save();
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' updated business ' . $business->name . ' )',
            ]);

            return redirect(route('my-business'))->with('message', 'Business(' . $business->name . ') updated successfully');
        } catch (\Exception $exception) {
            return back()->with('error', 'Error updating business');
        }
    }

    public function delete($business_id)
    {
        try {
            $business = $this->model->find($business_id);

            // delete logo and cover
            if ( !is_null($business->logo) ) Storage::disk('public')->delete($business->logo);
            if ( !is_null($business->cover) ) Storage::disk('public')->delete($business->cover);

            $business->delete();

            return back()->with('message', 'Business(' . $business->name . ') deleted successfully');
        } catch (\Exception $exception) {
            return back()->with('error', 'Error deleting business');
        }
    }

    public function receivablePayable($business_id)
    {
        $business = $this->model->with('invoices')->find($business_id);

//        dd($business->receivables()->with(['project', 'invoice'])->get()->toArray());
//        $business = $this->model->with('receivables.product', 'receivables.invoice')->find($business_id);
//        dd($business->receivables[0]->invoice->toArray());

        return view('pages.business.receivable-payable', compact('business'));
    }

    public function receivablesJson($business_id)
    {
        $business = $this->model->with('receivables')->find($business_id);

        if ( $business->mode == 'FREELANCE') {
            return DataTables::of($business->receivables()->with(['project', 'invoice'])->get())->toJson();
        }

        return DataTables::of($business->receivables()->with(['product', 'invoice'])->get())->toJson();
    }

    public function payablesJson($business_id)
    {
        $business = $this->model->with('payables')->find($business_id);

        if ( $business->mode == 'FREELANCE') {
            return DataTables::of($business->payables()->with(['project', 'invoice'])->get())->toJson();
        }

        return DataTables::of($business->payables()->with(['product', 'invoice'])->get())->toJson();
    }


    public function editBusinessMessage($business_id, $message_id)
    {
        $business = $this->model->find($business_id);
        $message = BusinessMessage::find($message_id);

        return view('pages.business.promo.birthday.edit', compact('business', 'message'));
    }

    public function updateBusinessMessage($business_id, $message_id)
    {
        $business = $this->model->find($business_id);
        $message = BusinessMessage::find($message_id);
        $message->message = request('message');
        $message->channel = request('channel');
        $message->save();

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' updated business message for ' . $message->type . ' )',
        ]);

        if ( $message->type == 'NEW_ITEM_ALERT' ) {
            return redirect(route('business.settings.new-item-alert', [$business_id]))
                ->with('message', ucfirst($message->type) . ' message updated successfully');
        }

        return redirect(route('business.settings.promotions.' . strtolower($message->type), [$business_id]))
            ->with('message', ucfirst($message->type) . ' message updated successfully');
    }

    public function deleteBusinessMessage($business_id, $message_id)
    {
        $business = $this->model->find($business_id);
        $message = BusinessMessage::find($message_id);

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' deleted business message for ' . $message->type . ' )',
        ]);

        $message->delete();

        return back()->with('message', 'Message Deleted successfully');
    }

    public function activities($business_id)
    {
        $business = $this->model->find($business_id);

        return view('pages.business.activities', compact('business'));
    }

    public function viewPage($ref)
    {
        $page = PromoPage::where('ref', $ref)->with('business', 'user')->first();
//        dd($page->toArray());
        return view('pages.business.view-page', compact('page'));
    }
}
