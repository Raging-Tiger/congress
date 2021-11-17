<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\BillingPlan;
use App\Models\Event;
use Illuminate\Http\Request;
define('ALL_EVENTS', 3);

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('id', 'desc')->paginate(5);
        return view('events/events', ['events' => $events]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $billing_plans = BillingPlan::all();
        $billing_plans_list = $billing_plans->pluck('name', 'id');

        $event_types = EventType::all()->take(2);

        return view('events/new_event', ['event_types' => $event_types, 'billing_plans' => $billing_plans_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event_id = 0;
        if(sizeof($request->selected_event_type) > 1)
        {
            $event_id = ALL_EVENTS;
        }
        
        else
        {
            $event_id = $request->selected_event_type[0];
        }
        
        Event::create([
                'name' => $request->event_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'registration_until' => $request->registration_till,
                'event_type_id' => $event_id,
                'billing_plan_id' => $request->billing_plan,
            ]);
        
        return redirect()->action('App\Http\Controllers\EventController@index');
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
