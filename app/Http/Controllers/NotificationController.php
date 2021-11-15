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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $notifications = Notification::orderBy('id', 'desc')->paginate(5);
      return view('notifications/notifications_list', ['notifications' => $notifications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        $notification_types = NotificationType::all();
        $notification_types_list = $notification_types->pluck('name', 'id');
        $notification = Notification::where('id', $id)->first();
      
        $languages = Language::all()->pluck('name', 'id');


        return view('notifications/edit_notification', ['notification' => $notification,
                                                        'notification_type' => $notification_types_list,
                                                        'languages' => $languages]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Notification::where('id', $request->notification_id)->delete();

        return Redirect::back();
        
    }
}
