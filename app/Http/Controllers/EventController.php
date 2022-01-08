<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\BillingPlan;
use App\Models\Event;
use App\Models\UserEvent;
use App\Models\Bill;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use PDF;

define('ALL_EVENTS', 3);
define('EXHIBITION', 2);
define('CONFERENCE', 1);
define('BILL_STATUS_SENT', 1);

class EventController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     * Participant is generalization for Private and Commercial participant.
     *
     */

    public function __construct() {

        $this->middleware('admin')->only(['admin_index', 'create', 'store', 'edit',
                                          'update', 'destroy', 'downloadParticipantList']);

        $this->middleware('participant')->only(['show', 'register', 'storeRegistration']);
    }


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

        /* Taking only separate event types for checkboxes */
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

        $rules = array(
            'event_name' => 'required|unique:events,name',
            'start_date' => 'required|after_or_equal:today', //Starting date cannot be in the past
            'end_date' => 'required|after_or_equal:start_date', //Ending date cannot be before starting data
            'registration_till' => 'required|before_or_equal:start_date', //Registration must be completed before or in the starting day
            'event_info' => 'required',
            'selected_event_type' => 'required',
            'billing_plan' => 'required',
        );

        $this->validate($request, $rules);

        $event_type_id = 0;

        /* If both checkboxes were selected */
        if(sizeof($request->selected_event_type) > 1)
        {
            $event_type_id = ALL_EVENTS;
        }

        /* If only one checkbox was selected */
        else
        {
            $event_type_id = $request->selected_event_type[0];
        }

        /* Transforming dates from the beginning of the day (00:00) to the end of the day (23:59) */
        $last_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay()->toDateTimeString();
        $registration_till = Carbon::createFromFormat('Y-m-d', $request->registration_till)->endOfDay()->toDateTimeString();

        Event::create([
                'name' => $request->event_name,
                'start_date' => $request->start_date,
                'end_date' => $last_date,
                'registration_until' => $registration_till,
                'event_type_id' => $event_type_id,
                'info' => $request->event_info,
                'billing_plan_id' => $request->billing_plan,
            ]);

        /* Creating folder for storing payment confirmation uploads */
        $folder_name = str_replace(' ', '_', strtolower($request->event_name));
        $path = '/public/payments/' . $folder_name;
        Storage::makeDirectory($path);

        /* If conference or both conference&exhibition - create necessay directories */
        if($event_type_id == ALL_EVENTS || $event_type_id == CONFERENCE)
        {
           $general_articles_path = '/public/articles/' . $folder_name;
           Storage::makeDirectory($path);
           $received_articles_path = '/public/articles/' . $folder_name.'/received';
           $accepted_articles_path = '/public/articles/' . $folder_name.'/accepted';
           
           Storage::makeDirectory($general_articles_path);
           Storage::makeDirectory($received_articles_path);
           Storage::makeDirectory($accepted_articles_path);
        }

        /* If exhibition or both conference&exhibition - create necessay directories */
        if($event_type_id == ALL_EVENTS || $event_type_id == EXHIBITION)
        {
           $materials_path = '/public/materials/' . $folder_name;
           Storage::makeDirectory($materials_path);
        }

        return redirect()->action('App\Http\Controllers\EventController@admin_index');
    }

    /**
     * Separately displays the selected event.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return corresponing view or aborting by server with code 404.
     */
    public function show($id)
    {
        $event = Event::where('id', '=', $id)->first();
        
        /* if no event found - abort */
        if($event == NULL)
        {
            abort(404);
        }

        return view('events/event', ['event' => $event,
                                     'id' => $id]);
    }


    /**
     * Display the form for registration for the selected event.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return corresponing view or aborting by server with code 404.
     */
    public function register($id)
    {
        $event = Event::where('id', '=', $id)->first();
        
        /* if no event found - abort */
        if($event == NULL)
        {
            abort(404);
        }
        return view('events/event_registration', ['event' => $event]);
    }

    /**
     * Store a user registration for specific event in the DB.
     *
     * @param  $request from the form; int $id - corresponds to the database event id entry.
     * @return action BillController@index
     */
    public function storeRegistration(Request $request, $id)
    {

        $rules = array(
            'participation' => 'required',
        );
        $this->validate($request, $rules);

        /* Getting all possible values from request, if such index in array not exists - set as NULL.
         * At least one of the variable will have real value, maximum - two at the same time */
        $cost_per_participation = isset($request->participation[0]) ? $request->participation[0] : NULL;
        $cost_per_article = isset($request->participation[1]) ? $request->participation[1] : NULL;
        $cost_per_material = isset($request->participation[2]) ? $request->participation[2] : NULL;

        /* if bill for this event not exists for the user  - creates it */
        if(!Bill::where('user_id', auth()->user()->id)->where('event_id', $id)->exists())
        {
            UserEvent::create([
                    'user_id' => auth()->user()->id,
                    'event_id' => $id,
                ]);

            Bill::create([
                'total_cost_per_articles' => $cost_per_article,
                'total_cost_per_participation' => $cost_per_participation,
                'total_cost_per_materials' => $cost_per_material,
                'user_id' => auth()->user()->id,
                'event_id' => $id,
                'bill_status_id' => BILL_STATUS_SENT,
            ]);
        }

        return redirect()->action('App\Http\Controllers\BillController@index');
    }

    /**
     * Display the form for editing selected event data.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return corresponing view or aborting by server with code 404.
     */
    public function edit($id)
    {
        $event = Event::where('id', '=', $id)->first();
        
        /* if no event found - abort */
        if($event == NULL)
        {
            abort(404);
        }
        $billing_plans = BillingPlan::all();
        $billing_plans_list = $billing_plans->pluck('name', 'id');

        /* Taking only separate event types */
        $event_types = EventType::all()->take(2);


        return view('events/edit_event', ['event' => $event,
                                          'event_types' => $event_types,
                                          'billing_plans' => $billing_plans_list,
                                          'id' => $id]);
    }

    /**
     * Update selected event data in database.
     *
     * $request from the form.
     * @return redirect EventController@admin_index
     */
    public function update(Request $request)
    {
        $rules = array(
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'registration_till' => 'required|before_or_equal:start_date',
            'event_info' => 'required',
            'billing_plan' => 'required',
        );

        $this->validate($request, $rules);


        /* Transforming dates from the beginning of the day (00:00) to the end of the day (23:59) */
        $last_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay()->toDateTimeString();
        $registration_till = Carbon::createFromFormat('Y-m-d', $request->registration_till)->endOfDay()->toDateTimeString();

        $event = Event::where('id', $request->event_id)->first();
        $old_name = $event->name;

        /* if event name changed - all corresponding directories are renamed too */
        if($old_name != $request->event_name)
        {
            $old_folder_name = str_replace(' ', '_', strtolower($old_name));
            $old_articles_path = '/public/articles/' . $old_folder_name;
            $old_payment_path = '/public/payments/' . $old_folder_name;
            $new_folder_name = str_replace(' ', '_', strtolower($request->event_name));

            if (Storage::disk('local')->exists($old_articles_path))
            {
                $new_articles_path = '/public/articles/' . $new_folder_name;
                Storage::disk('local')->move($old_articles_path, $new_articles_path);
            }

            if (Storage::disk('local')->exists($old_payment_path))
            {
                $new_payment_path = '/public/payments/' . $new_folder_name;
                Storage::disk('local')->move($old_payment_path, $new_payment_path);

            }

                        $event->name = $request->event_name;
        }
        
        $event->start_date = $request->start_date;
        $event->end_date = $last_date;
        $event->registration_until = $registration_till;
        $event->info = $request->event_info;
        $event->billing_plan_id = $request->billing_plan;
        $event->save();

        return redirect()->action('App\Http\Controllers\EventController@admin_index');
    }

    /**
     * Remove specified event data from database.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return redirect back
     */
    public function destroy($id)
    {
        /* If no users are registrated for event, it can be deleted*/
        if(!UserEvent::where('event_id', $id)->exists())
        {
            $name = Event::where('id', $id)->first('name');
            $folder_name = str_replace(' ', '_', strtolower($name->name));

            /* Removing created directories */
            $articles_path = '/public/articles/' . $folder_name;
            $payment_path = '/public/payments/' . $folder_name;
            Event::where('id', $id)->delete();

            Storage::disk('local')->deleteDirectory($payment_path);
            Storage::disk('local')->deleteDirectory($articles_path);

            return \Redirect::back();
        }
        /* If there are users registrated for event - it cannot be deleted */
        return \Redirect::back()->withErrors(['msg' => 'Event cannot be deleted']);
    }
    
     /**
     * Downloads list of all participants for selected event in PDF format.
     *
     * @param  int  $id - corresponds to the database event id entry.
     * @return response - download or aborting by server with code 404. 
     */
    public function downloadParticipantList($id)
    {
        $event = Event::where('id', $id)->first();
        
        /* if no event found - abort */
        if($event == NULL)
        {
            abort(404);
        }
        
        $userEvents = UserEvent::where('event_id', $id)->get();
        $name = $event->name.'_participant_list'.'.pdf';
        $data = [
            'event' => $event,
            'participants' => $userEvents,
            ];
        
        /* Rendering PDF document in template */
        $pdf = PDF::loadView('/document_templates/user_list', $data);

        return $pdf->download($name);

    }
}
