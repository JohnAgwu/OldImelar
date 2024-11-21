<?php

namespace App\Http\Controllers;

use App\Model\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class BusinessIncomes extends Controller
{
    private $model;

    public function __construct( \App\Model\Income $model )
    {
        $this->model = $model;
    }

    public function index( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        $incomes = $business->incomes;

        return view('pages.business.incomes.index', compact('business', 'incomes'));
    }

    public function indexJson( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        return DataTables::of($business->incomes)->toJson();
    }

    public function create( $business_id )
    {
        $business = \App\Model\Business::find($business_id);
        return view('pages.business.incomes.add', compact('business'));
    }

    public function store($business_id) {
        try {
            $business = \App\Model\Business::find($business_id);
            $data = request()->except('_token');

            $business->incomes()->create($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' added business income for ' . $business->name . ' )',
            ]);

            return redirect(route('business.incomes.index', [$business_id]))->with('message', 'Business income added successfully');
        }
        catch ( \Exception $exception ) {
//            dd($exception->getMessage());
            return back()->with('error', 'Error updating business');
        }
    }

    public function destroy( $business_id, $expenses_id )
    {
        $business = \App\Model\Business::find($business_id);
        $income = $this->model->find($expenses_id);
        $income->delete();

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' deleted business income for ' . $business->name . ' )',
        ]);

        return back()->with('message', 'Business income deleted successfully');
    }
}
