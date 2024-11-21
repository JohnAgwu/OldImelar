<?php

namespace App\Http\Controllers;

use App\Model\Config;

class Project extends Controller
{
    private $model;
    private $business;

    public function __construct( \App\Model\Project $model, \App\Model\Business $business )
    {
        $this->model = $model;
        $this->business = $business;
    }

    public function index($business_id)
    {
        $business = $this->business->find($business_id);
//        dd($business->products->toArray());

        return view('pages.business.project.index', compact('business'));
    }

    public function create( $business_id )
    {
        $business = $this->business->find($business_id);
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $purchaseExpenses = Config::where('name', 'PURCHASE_EXPENSES')->first()->value;

        return view('pages.business.project.add', compact('business', 'unitOfMearsurement', 'paymentStatus', 'purchaseExpenses'));
    }

    public function store( $business_id )
    {
        try {
            request()->request->set('type', 'ADD_PROJECT');

            $data = request()->except(['_token']);
            unset($data['type']);
            $data['project_expenses'] = (double) collect(request('expenses'))->sum('amount');

            $data['expenses'] = collect(request('expenses'))->values()->toArray();

            $business = $this->business->find($business_id);
            $project = $business->projects()->create($data);

            switch (request('payment_status')) {
                case 'UNPAID':
                    $project->payable()->create(['business_id' => $business_id, 'amount' => (double) request('price')]);
                    break;

                case 'PART PAYMENT':
                    $project->payable()->create(['business_id' => $business_id, 'amount' => (double) request('price') - (double) request('amount_paid')]);
                    break;
            }


            return redirect(route('business.projects', [$business_id]))->with('message', 'Project added successfully');
        }
        catch ( \Exception $exception ) {
//            $business = $this->business->find($business_id);
//            dd($exception->getMessage());
            return back()->with('error', 'Error adding new project')->withInput();
        }
    }

    public function update( $business_id, $product_id )
    {
        try {
            $business = $this->business->find($business_id);
            $data = request()->except(['_token']);
            $data['project_expenses'] = (double) collect(request('expenses'))->sum('amount');
            $data['expenses'] = collect(request('expenses'))->values()->toArray();

            $product = $this->model->find($product_id);
            $product->update($data);

            $business->activities()->create([
                'user_id'   => $business->user_id,
                'info'      => request()->user()->name . ' updated project ' . $product->name,
            ]);

            return redirect(route('business.projects', [$business_id]))->with('message', 'Project updated successfully');
        }
        catch ( \Exception $exception ) {
            return back()->with('error', 'Error updating project')->withInput();
        }
    }

    public function edit($business_id, $project_id)
    {
        $project = $this->model->find($project_id);
        $business = $this->business->find($business_id);
        $paymentStatus = Config::where('name', 'PAYMENT_STATUS')->first()->value;
        $projectExpenses = Config::where('name', 'PURCHASE_EXPENSES')->first()->value;

        return view('pages.business.project.edit', compact('project', 'business', 'paymentStatus', 'projectExpenses'));
    }

    public function destroy($business_id, $project_id)
    {
        $this->model->find($project_id)->delete();

        return back()->with('messgae', 'project deleted successfully');
    }
}
