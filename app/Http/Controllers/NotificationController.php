<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Notification;
use App\Models\NotificationType;
use Illuminate\Http\Request;
use Redirect;
use Session;
class NotificationController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     */
    public function __construct() {
    
        $this->middleware('admin');
    } 
    /**
     * Display a listing of all notifications.
     *
     * @return corresponing view.
     */
    public function index()
    {
      $notifications = Notification::orderBy('id', 'desc')->paginate(5);
      return view('notifications/notifications_list', ['notifications' => $notifications]);
    }

    /**
     * Show the form for creating a new notification.
     *
     * @return corresponing view.
     */
    public function create()
    {
        $notification_types = NotificationType::all();
        $notification_types_list = $notification_types->pluck('name', 'id');
        
        $languages = Language::all()->pluck('name', 'id');
        
        return view('notifications/new_notification', ['notification_type' => $notification_types_list,
                                                       'languages' => $languages]);
    }

    /**
     * Store a newly created notification in DB.
     *
     * @param  $request from the form.
     * @return action NotificationController@index.
     */
    public function store(Request $request)
    {
        $rules = array(
            'header' => 'required',
            'message' => 'required',
            'notification_type' => 'required',
            'lang' => 'required',
        );    
        $this->validate($request, $rules);
        
        
        Notification::create([
                'header' => $request->header,
                'message' => $request->message,
                'notification_type_id' => $request->notification_type,
                'language_id' => $request->lang,
                'user_id' => auth()->user()->id,
            ]);

        
        
         return redirect()->action('App\Http\Controllers\NotificationController@index');
    }

    /**
     * Show the form for editing the specified notification.
     *
     * @param  int  $id - corresponds to the notification event ID.
     * @return corresponing view.
     */
    public function edit($id)
    {
        $notification = Notification::where('id', $id)->first();
        
        /* If notification not exists - abort */
        if($notification == NULL)
        {
            abort(404);
        }
            
        $notification_types = NotificationType::all();
        
        $notification_types_list = $notification_types->pluck('name', 'id');
        
      
        $languages = Language::all()->pluck('name', 'id');


        return view('notifications/edit_notification', ['notification' => $notification,
                                                        'notification_type' => $notification_types_list,
                                                        'languages' => $languages]);
    }

    /**
     * Update the specified notification in DB.
     *
     * @param  $request from the form.
     * @return action NotificationController@index.
     */
    public function update(Request $request)
    {
        $rules = array(
            'header' => 'required',
            'message' => 'required',
            'notification_type' => 'required',
        );        
        $this->validate($request, $rules); 
        
        $notification =  Notification::where('id', $request->notification_id)->first();
        $notification->header = $request->header;
        $notification->message = $request->message;
        $notification->notification_type_id = $request->notification_type;
        $notification->save();
 
        return redirect()->action('App\Http\Controllers\NotificationController@index');
    }

    /**
     * Remove the specified notification from DB.
     *
     * @param  $request from the form.
     * @return redirect back.
     */
    public function destroy(Request $request)
    {
        Notification::where('id', $request->notification_id)->delete();

        return Redirect::back();
        
    }
}
