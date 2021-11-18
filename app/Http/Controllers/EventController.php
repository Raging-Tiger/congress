<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\BillingPlan;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
define('ALL_EVENTS', 3);

class EventController extends Controller
{
    /**
     * Display a listing of all events to users.
     *
     * @return corresponing view.
     */
    public function index()
    {
        $events = Event::orderBy('id', 'desc')->paginate(5);
        return view('events/events', ['events' => $events]);

    }
    
    /**
     * Display a listing of all events to admin.
     *
     * @return corresponing view
     */
    public function admin_index()
    {
        $events = Event::orderBy('id', 'desc')->paginate(5);
        return view('events/admin_events', ['events' => $events]);

    }

    /**
     * Show the form for creating a new event to admin.
     *
     * @return corresponing view.
     */
    public function create()
    {
        $billing_plans = BillingPlan::all();
        $billing_plans_list = $billing_plans->pluck('name', 'id');

        $event_types = EventType::all()->take(2);

        return view('events/new_event', ['event_types' => $event_types, 'billing_plans' => $billing_plans_list]);
    }

    /**
     * Store a newly created event in the DB.
     *
     * @param  $request from the form.
     * @return redirect to the list of all events via EventController@admin_index.
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
        
        /* Transforming dates from the beginning of the day (00:00) to the end of the day (23:59) */
        $last_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay()->toDateTimeString();
        $registration_till = Carbon::createFromFormat('Y-m-d', $request->registration_till)->endOfDay()->toDateTimeString();

        Event::create([
                'name' => $request->event_name,
                'start_date' => $request->start_date,
                'end_date' => $last_date,
                'registration_until' => $registration_till,
                'event_type_id' => $event_id,
                'billing_plan_id' => $request->billing_plan,
            ]);
        
        return redirect()->action('App\Http\Controllers\EventController@admin_index');
    }

    /**
     * Separately displays the selected event.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return corresponing view.
     */
    public function show($id)
    {
        $event = Event::where('id', '=', $id)->first();
        return view('events/event', ['event' => $event]);
    }
    
    
    /**
     * Display the form for registration for the selected event.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return corresponing view.
     */
    public function register($id)
    {
        $event = Event::where('id', '=', $id)->first();
        return view('events/event_registration', ['event' => $event]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeRegistration(Request $request)
    {

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
