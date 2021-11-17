<?php

namespace App\Http\Controllers;

use App\Models\BillingPlan;
use Illuminate\Http\Request;
use function view;

class BillingPlanController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing_plans = BillingPlan::paginate(5);
        
        return view('bills/billing_plans', ['billing_plans' => $billing_plans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bills/new_billing_plan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BillingPlan::create([
            'name' => $request->billing_plan_name,
            'cost_per_article' => $request->cost_per_article,
            'cost_per_participation' => $request->cost_per_participation,
            'cost_per_material' => $request->cost_per_material,
            ]);
        
        return redirect()->action('App\Http\Controllers\BillingPlanController@index');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
