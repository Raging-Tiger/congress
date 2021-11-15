<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Language;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        #$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $lang = $request->cookie('language');
        
        if (isset($lang))
        {
                $lang = Language::where('language_code', $lang)->first()->id;
        }
        
        else
        {
                $lang = Language::where('language_code', \Lang::getLocale())->first()->id;
        }
            
            $n = Notification::where('language_id', $lang)->orderBy('id', 'desc')->paginate(5);
            $p = Notification::where('language_id', $lang)->where('notification_type_id',1)->orderBy('id', 'desc')->paginate(5);
            
        return view('general/index', ['privates' => $n, 'publics' => $p, 'lang' => $lang]);

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
