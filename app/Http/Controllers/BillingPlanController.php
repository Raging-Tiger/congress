<?php

namespace App\Http\Controllers;

use App\Models\BillingPlan;
use App\Models\Event;
use Illuminate\Http\Request;
use function view;

class BillingPlanController  extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     *
     */
    public function __construct() {
        $this->middleware('admin');
    }
    
    /**
     * Display of all billing plans for admin.
     *
     * @return corresponing view.
     */
    public function index()
    {
        $billing_plans = BillingPlan::paginate(5);
        
        return view('bills/billing_plans', ['billing_plans' => $billing_plans]);
    }

    /**
     * Display the form for creating a new billing plan.
     *
     * @return corresponing view.
     */
    public function create()
    {
        return view('bills/new_billing_plan');
    }

    /**
     * Store a newly created billing plan in the DB.
     *
     * @param  $request from the form.
     * @return action BillingPlanController@index
     */
    public function store(Request $request)
    {
        $rules = array(
            'billing_plan_name' => 'required|max:255',
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
     * Show the form for editing the specified billing plan.
     *
     * @param  int  $id - corresponds to the database billing plan ID.
     * @return corresponing view.
     */
    public function edit($id)
    {
        $billing_plan = BillingPlan::where('id', $id)->first();
        
        /*If billing plan is not found - abort*/
        if($billing_plan == NULL)
        {
            abort(404);
        }
        
        return view('bills/edit_billing_plan', ['billing_plan' => $billing_plan]);

    }

    /**
     * Update the specified billing plan in DB.
     * 
     * @param  $request from the form.
     * @return action BillingPlanController@index
     */
    public function update(Request $request)
    {
        $rules = array(
            'billing_plan_name' => 'required|max:255',
            'cost_per_article' => 'required|numeric',
            'cost_per_participation' => 'required|numeric',
            'cost_per_material' => 'required|numeric',
        );        
       
        $this->validate($request, $rules);
        
        /* Updating all fields */
        $billing_plan = BillingPlan::where('id', $request->billing_plan_id)->first();
        $billing_plan->name = $request->billing_plan_name;
        $billing_plan->cost_per_article = $request->cost_per_article;
        $billing_plan->cost_per_participation = $request->cost_per_participation;
        $billing_plan->cost_per_material = $request->cost_per_material;
        $billing_plan->save();
        
        return redirect()->action('App\Http\Controllers\BillingPlanController@index');
    }

    /**
     * Deleting the specified billing plan from DB, if it is not attached to any event.
     *
     * @param  int  $id - corresponds to the database billing plan ID.
     * @return redirect back
     */
    public function destroy($id)
    {
        /* If there are no events with this billing plan - delete it */
        if(!Event::where('billing_plan_id', $id)->exists())
        {
            BillingPlan::where('id', $id)->delete();
            return \Redirect::back();
        }
        
        /* Else return error */
        return \Redirect::back()->withErrors(['msg' => 'Billing plan cannot be deleted, unless it is detached from the events']);
    }
}
