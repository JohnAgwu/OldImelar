<?php

namespace App\Http\Controllers;

use App\Model\Config;

class Bank extends Controller
{
    private $model;
    private $business;

    public function __construct( \App\Model\Bank $model, \App\Model\Business $business )
    {
        $this->model = $model;
        $this->business = $business;
    }

    public function index($business_id)
    {
        $business = $this->business->with('banks')->find($business_id);
//        dd($business->banks->toArray());

        return view('pages.business.bank.index', compact('business'));
    }

    public function create( $business_id )
    {
        $business = $this->business->find($business_id);
        if ( $business->banks->count() > 2 ) {
            return redirect(route('business.settings.banks', ['id' => $business_id]))->with('message', 'Maximum bank for this business reached.');
        }
        $banks = json_decode(Config::where('name', 'BANKS')->first()->value);

        return view('pages.business.bank.add', compact('banks', 'business'));
    }

    public function store( $business_id )
    {
        try {
            $data = request()->except('_token');
            $data = array_merge($data, collect(json_decode($data['bank']))->toArray());
            unset($data['bank']);

            $business = $this->business->find($business_id);
            $business->banks()->create($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' added a bank('. $data['account_number'] . ')',
            ]);

            return redirect(route('business.settings.banks', ['business_id' => $business_id]))->with('message', 'Bank added successfully');
        }
        catch ( \Exception $exception ) {
            return back()->with('error', 'Error adding bank account')->withInput();
        }
    }

    public function edit( $business_id, $account_id )
    {
        try {
            $business = $this->business->find($business_id);
            $ba = $this->model->find($account_id);
            $banks = json_decode(Config::where('name', 'BANKS')->first()->value);

            return view('pages.business.bank.edit', compact('ba', 'banks', 'business'));
        }
        catch ( \Exception $exception ) {
            return back()->with('error', 'Error editing bank')->withInput();
        }
    }

    public function update($business_id, $id)
    {
        try {
            $business = $this->business->find($business_id);
            $data = request()->except('_token');
            $data = array_merge($data, collect(json_decode($data['bank']))->toArray());
            unset($data['bank']);

            $this->model->find($id)->update($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' Updated bank('. $data['account_number'] . ')',
            ]);

            return redirect(route('business.settings.banks', ['business_id' => $business_id]))->with('message', 'Bank account updated successfully');
        }
        catch ( \Exception $exception ) {
            return back()->with('error', 'Error adding bank account')->withInput();
        }
    }

    public function deleteAccount( $business_id, $account_id )
    {
        try {
            $business = $this->business->find($business_id);
            $bank = $this->model->find($account_id);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' Deleted bank('. $bank->account_number . ')',
            ]);

            $bank->delete();

            return back()->with('message', 'Bank account deleted successfully')->withInput();
        }
        catch ( \Exception $exception ) {
            return back()->with('error', 'Error editing bank')->withInput();
        }
    }
}
