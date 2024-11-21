<?php

namespace App\Http\Controllers;

use App\Model\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class BusinessExpenses extends Controller
{
    private $model;

    public function __construct( \App\Model\Expense $model )
    {
        $this->model = $model;
    }

    public function index( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        $expenses = $business->expenses;

        return view('pages.business.expenses.index', compact('business', 'expenses'));
    }

    public function indexJson( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        return DataTables::of($business->expenses()->orderBy('id', 'desc'))->toJson();
    }

    public function create( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        $business_expenses = json_decode(Config::where('name', 'BUSINESS_EXPENSES')->first()->value);

        return view('pages.business.expenses.add', compact('business', 'business_expenses'));
    }

    public function store($business_id) {
        try {
            $business = \App\Model\Business::find($business_id);
            $data = request()->except('_token');

            $business->expenses()->create($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' added business expenses for ' . $business->name . ' )',
            ]);

            return redirect(route('business.expenses.index', [$business_id]))->with('message', 'Business expenses added successfully');
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error updating business');
        }
    }

    public function destroy( $business_id, $expenses_id )
    {
        $business = \App\Model\Business::find($business_id);
        $expense = $this->model->find($expenses_id);
        $expense->delete();

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' deleted business expenses for ' . $business->name . ' )',
        ]);

        return back()->with('message', 'Business expenses deleted successfully');
    }
}
