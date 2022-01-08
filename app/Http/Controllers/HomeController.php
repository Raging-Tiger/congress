<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Language;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

define('PUBLIC_ANNOUNCEMENT', 1);

class HomeController extends Controller
{

    /**
     * Show main page of the application dashboard.
     *
     * @param  $request - from the cookie - language locale.
     * @return corresponding view.
     */
    public function index(Request $request)
    {
        $lang = $request->cookie('language');
        
        /* If language cookie is defined - select announcements on this language */
        if (isset($lang))
        {
                $lang = Language::where('language_code', $lang)->first()->id;
        }
        
        /* If language cookie is not defined - select announcements based of default locale (English) */
        else
        {
                $lang = Language::where('language_code', \Lang::getLocale())->first()->id;
        }
        
        /* Get corresponding notifications record (all, public) */
        $all = Notification::where('language_id', $lang)->orderBy('id', 'desc')->paginate(5);
        $public = Notification::where('language_id', $lang)->where('notification_type_id', PUBLIC_ANNOUNCEMENT)->orderBy('id', 'desc')->paginate(5);
                      
        return view('general/index', ['privates' => $all, 'publics' => $public, 'lang' => $lang]);

    }
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        return view('home');
    }
}
