<?php

namespace App\Http\Controllers;

use App\Models\BillingPlan;
use App\Models\Event;
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
        $rules = array(
            'billing_plan_name' => 'required',
            'cost_per_article' => 'required|numeric',
            'cost_per_participation' => 'required|numeric',
            'cost_per_material' => 'required|numeric',
        );        
       
        $this->validate($request, $rules);
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
        $billing_plan = BillingPlan::where('id', $id)->first();
        
        return view('bills/edit_billing_plan', ['billing_plan' => $billing_plan]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $billing_plan = BillingPlan::where('id', $request->billing_plan_id)->first();
        $billing_plan->name = $request->billing_plan_name;
        $billing_plan->cost_per_article = $request->cost_per_article;
        $billing_plan->cost_per_participation = $request->cost_per_participation;
        $billing_plan->cost_per_material = $request->cost_per_material;
        $billing_plan->save();
        
        return redirect()->action('App\Http\Controllers\BillingPlanController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Event::where('billing_plan_id', $id)->exists())
        {
            BillingPlan::where('id', $id)->delete();
            return \Redirect::back();
        }
        
        return \Redirect::back()->withErrors(['msg' => 'Billing plan cannot be deleted, unless it is detached from the events']);
    }
}
