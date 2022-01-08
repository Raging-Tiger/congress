<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bill;
use App\Models\Event;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

define('ALL', 0);
define('VAT_RATE', 0.21);
define('TIMESTAMP_CORRECTION', 1000);
define('UNDER_REVIEW', 2);
define('ACCEPTED', 3);
define('DECLINED', 4);



class StatisticController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     */
    public function __construct() {
        $this->middleware('admin');
    }
    
    /**
     * Display statistical dashboard.
     *
     * @return corresponing view.
     */
    public function index()
    {
        return view('statistics/statistic_index');
    }
    
    /**
     * Display user role chart (rendered in the view).
     *
     * @return corresponing view.
     */
    public function userRolesChart()
    {

        /* Counts all users by thier role */
        $userRolesData = User::join('roles', 'users.role_id', '=', 'roles.id')
                 ->select('role_id', DB::raw('count(*) as total'))
                 ->groupBy('users.role_id')
                 ->get()->pluck('total', 'roles.name');
        
        /* Transforms data in necessary format for JS chart */
        $format_for_chart = array();
        foreach($userRolesData as $key => $value)
        {
            $subarray = array('name' => $key, 'data' => array($value));
            array_push($format_for_chart, $subarray);
            
        }
        //dd($arr);
        return view('statistics/user_roles', ['userData' => $format_for_chart]);

    }
    
    /**
     * Display profit share chart (rendered in the view) - all profit from all bills.
     *
     * @param  $request - selected event or all events
     * @return corresponing view.
     */
    public function profitShareGeneralChart(Request $request)
    {
        /* All events and option ALL*/
        $events = Event::orderBy('id', 'desc')
                ->pluck('name', 'id');
        $events->prepend('All', ALL);
        
        /* If selected specific event */
        if($request->filled('event') && $request->event != ALL)
        {
            /* Aggregated cost form all issued bills plus added VAT */
            $sum_cost_per_participation = Bill::where('event_id', $request->event)->sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::where('event_id', $request->event)->sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::where('event_id', $request->event)->sum('total_cost_per_materials');
            $VAT_sum = round(($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * VAT_RATE, 2);
            
            return view('statistics/profit', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events,
                                          'event_id' => $request->event]);
        }
        
        /* If selected all, or not selected anything - view just opened (all by default) */
        else
        {
            /* Aggregated cost form all issued bills plus added VAT */
            $sum_cost_per_participation = Bill::sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::sum('total_cost_per_materials');
            $VAT_sum = round(($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * VAT_RATE, 2);
            
            return view('statistics/profit', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events]);
        }

    }
 
     /**
     * Display income share chart (rendered in the view) - all income from only paid bills.
     *
     * @param  $request - selected event or all events
     * @return corresponing view.
     */
    public function incomeChart(Request $request)
    {
        /* All events and option ALL*/
        $events = Event::orderBy('id', 'desc')
                ->pluck('name', 'id');
        $events->prepend('All', ALL);
        
        /* If selected specific event */
        if($request->filled('event') && $request->event != ALL)
        {
            /* Aggregated cost form all paid bills plus added VAT */
            $sum_cost_per_participation = Bill::where('event_id', $request->event)
                                                ->where('bill_status_id', PAID)
                                                ->sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::where('event_id', $request->event)
                                           ->where('bill_status_id', PAID)
                                           ->sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::where('event_id', $request->event)
                                            ->where('bill_status_id', PAID)
                                            ->sum('total_cost_per_materials');
            $VAT_sum = round(($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * VAT_RATE, 2);
            
            return view('statistics/income', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events,
                                          'event_id' => $request->event]);
        }
        /* If selected all, or not selected anything - view just opened (all by default) */
        else
        {
            /* Aggregated cost form all paid bills plus added VAT */
            $sum_cost_per_participation = Bill::where('bill_status_id', PAID)
                                                ->sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::where('bill_status_id', PAID)
                                           ->sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::where('bill_status_id', PAID)
                                            ->sum('total_cost_per_materials');
            $VAT_sum = round(($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * VAT_RATE, 2);
            
            return view('statistics/income', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events]);
        }

    }
    
    
    /**
     * Display article acceptance widget (rendered in the view)
     *
     * @param  $request - selected event or all events
     * @return corresponing view.
     */
    public function acceptanceChart(Request $request)
    {
        /* All events and option ALL*/
        $events = Event::orderBy('id', 'desc')
                  ->pluck('name', 'id');
        $events->prepend('All', ALL);
        
         /* If selected specific event */
        if($request->filled('event') && $request->event != ALL)
        {
            /* Count of all articles by status: accepted, declined, under review, not processed */
            $all_articles = Article::where('event_id', $request->event)->count();
            $accepted_articles = Article::where('event_id', $request->event)
                                 ->where('article_status_id', ACCEPTED)->count();
            $declined_articles = Article::where('event_id', $request->event)
                                 ->where('article_status_id', DECLINED)->count();
            $reviewed_articles = Article::where('event_id', $request->event)
                                 ->where('article_status_id', UNDER_REVIEW)->count();
            $not_processed = $all_articles - $accepted_articles - $declined_articles - $reviewed_articles;
            return view('statistics/acceptance', ['accepted_articles' => $accepted_articles,
                                                  'declined_articles' => $declined_articles,
                                                  'not_processed' => $not_processed,
                                                  'under_review' => $reviewed_articles,
                                                  'event_id' => $request->event,
                                                  'events' => $events]); 
        }
        /* If selected all, or not selected anything - view just opened (all by default) */
        else
        {
            /* Count of all articles by status: accepted, declined, under review, not processed */
            $all_articles = Article::all()->count();
            $accepted_articles = Article::where('article_status_id', ACCEPTED)->count();
            $declined_articles = Article::where('article_status_id', DECLINED)->count();
            $reviewed_articles = Article::where('article_status_id', UNDER_REVIEW)->count();
            $not_processed = $all_articles - $accepted_articles - $declined_articles - $reviewed_articles;
            return view('statistics/acceptance', ['accepted_articles' => $accepted_articles,
                                                  'declined_articles' => $declined_articles,
                                                  'not_processed' => $not_processed,
                                                  'under_review' => $reviewed_articles,
                                                  'events' => $events]);
        }
        
    }
    
    /**
     * Display tax prism chart (rendered in the view)
     *
     * @return corresponing view.
     */
    public function taxChart()
    {
        /* Tax base (L) - aggregated cost form all paid bills plus added VAT */
        $sum_cost_per_participation = Bill::where('bill_status_id', PAID)
                                        ->sum('total_cost_per_participation');
        $sum_cost_per_articles = Bill::where('bill_status_id', PAID)
                                        ->sum('total_cost_per_articles');
        $sum_cost_per_materials = Bill::where('bill_status_id', PAID)
                                        ->sum('total_cost_per_materials');
        
        /* Amount of all taxes */
        $tax_amount = round(($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * VAT_RATE, 2);
        
        /* All profits + VAT received are forming tax base */
        $tax_base = $sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials + $tax_amount;
                
        /* Base of the tax prism = L - 2n */
        $base_of_tax_prism_side = $tax_base - (2 * $tax_amount);
                
        return view('statistics/tax_prism', ['base_point' => $base_of_tax_prism_side, 'height_point' => $tax_amount]);
    }
    
     /**
     * Display user registration chart (rendered in the view)
     *
     * @return corresponing view.
     */
    public function usersChart()
    {
        /* All users sorted by date */
        $userData = \DB::table('users')
                                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                                ->groupBy('date')
                                ->get();
        
        /* Pre-processing query data to fit format of the JS chart */
        $data = array();
        foreach($userData as $ud)
        {
            /* Timestamp correction by 1000 due to difference in PHP and JS format of timestamp */
            array_push($data, array(strtotime($ud->date) * TIMESTAMP_CORRECTION, $ud->count));
        }
        //dd($data);
        return view('statistics/users', ['userData' => $data]);
    }
}
