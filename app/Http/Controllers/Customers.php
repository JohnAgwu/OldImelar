<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Imports\CustomersImport;
use App\Model\Customer;
use App\User;
use Artdarek\OAuth\Facade\OAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class Customers extends Controller
{
    protected $model;
    protected $business;

    public function __construct( Customer $model, \App\Model\Business $business )
    {
        $this->model = $model;
        $this->business = $business;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $business_id )
    {
        $business = $this->business->find($business_id);
        $customers = $business->customers()->paginate();

        return view('pages.business.customers.index', compact('business', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.customers.add', compact('business'));
    }

    /**
     * Create a new customer.
     *
     * @param $business_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($business_id)
    {
        $business = $this->business->find($business_id);
        $data = request()->except('_token');

        $user = User::where('email', $data['email'])
            ->orWhere('phone', $data['phone'])->first();

        if ( is_null($user) ) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? NULL,
                'phone' => $data['phone'],
                'dob' => $data['dob'] ?? NULL,
                'gender' => $data['gender'] ,
                'password' => Hash::make(Str::random()),
                'email_verified_at' => now()
            ]);

            $user->assignRole('USER');
        }

        $business->customers()->updateOrCreate(['user_id' => $user->id]);

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' added customer (' . $data['name'] . ') to ' . $business->name . ' )',
        ]);

        return redirect(route('business.customers.index', [$business_id]))->with('message', 'customer added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($business_id, $id)
    {
        $business = $this->business->find($business_id);
        $customer = $this->model->find($id);

        return view('pages.business.customers.edit', compact('business', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($business_id, $id)
    {
//        try {

            $business = $this->business->find($business_id);
            $customer = $this->model->find($id);
            $data = \request()->except('_token');

            if ( $customer->user->phone !== \request('phone')) {
                $this->validate(\request(), [
                    'phone' => 'unique:users'
                ]);
            }

            $customer->user->update($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' updated info for customer ' . $data['name'],
            ]);

            return redirect(route('business.customers.index', [$business_id]))->with('message', 'customer details updated successfully');
//        } catch (\Exception $e) {
//            dd($e->getMessage());
////            return back()->with('error', $e->getMessage());
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($business_id, $id)
    {
        $business = $this->business->find($business_id);
        $customer = $this->model->find($id);

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' deleted customer ' . $customer->name,
        ]);

        $customer->delete();

        return redirect(route('business.customers.index', [$business_id]))->with('message', 'customer deleted successfully');
    }

    public function import($business_id, $type)
    {
        $business = $this->business->find($business_id);

        if ( $type == 'csv') {
            return view('pages.business.customers.import-csv', compact('business'));
        }

        return view('pages.business.customers.import-google', compact('business'));
    }

    public function importCSV($business_id)
    {
        $business = $this->business->find($business_id);
        $i = Excel::import(new CustomersImport($business), request()->file('file'));

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' imported customer for ' . $business->name,
        ]);

        return redirect(route('business.customers.index', [$business_id]))->with('message', 'customer imported successfully');
    }

    public function importGoogle($business_id)
    {
        $business = $this->business->find($business_id);

        // get data from request
        $code = \request('code');

        // get google service
        $googleService = OAuth::consumer('Google');

        // check if code is valid

        // if code is provided get user data and sign in
        if ( ! is_null($code)) {
            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&amp;max-results=400'), true);

            dd($result);

            // Going through the array to clear it and create a new clean array with only the email addresses
            $emails = []; // initialize the new array
            foreach ($result['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) { // Sometimes, a contact doesn't have email address
                    $emails[] = $contact['gd$email'][0]['address'];
                }
            }

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' imported customer for ' . $business->name,
            ]);

            return $emails;

        }

        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return redirect((string)$url);
        }

        return redirect(route('business.customers.index', [$business_id]))->with('message', 'customer imported successfully');
    }
}
