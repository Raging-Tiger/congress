<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bill;
use App\Models\Event;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class StatisticController extends Controller
{
    public function userRolesChart()
    {

        
        $userRolesData = User::join('roles', 'users.role_id', '=', 'roles.id')
                 ->select('role_id', DB::raw('count(*) as total'))
                 ->groupBy('users.role_id')
                 ->get()->pluck('total', 'roles.name');
         
        $format_for_chart = array();
        foreach($userRolesData as $key => $value)
        {
            $subarray = array('name' => $key, 'data' => array($value));
            array_push($format_for_chart, $subarray);
            
        }
        //dd($arr);
        return view('statistics/user_roles', ['userData' => $format_for_chart]);

    }
    
    public function profitShareGeneralChart(Request $request)
    {
        $events = Event::orderBy('id', 'desc')
                ->pluck('name', 'id');
        $events->prepend('All',0);
        
        if($request->filled('event') && $request->event != 0)
        {
            $sum_cost_per_participation = Bill::where('event_id', $request->event)->sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::where('event_id', $request->event)->sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::where('event_id', $request->event)->sum('total_cost_per_materials');
            $VAT_sum = ($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * 0.21;
            
            return view('statistics/profit', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events,
                                          'event_id' => $request->event]);
        }
        else
        {
            $sum_cost_per_participation = Bill::sum('total_cost_per_participation');
            $sum_cost_per_articles = Bill::sum('total_cost_per_articles');
            $sum_cost_per_materials = Bill::sum('total_cost_per_materials');
            $VAT_sum = ($sum_cost_per_participation + $sum_cost_per_articles + $sum_cost_per_materials) * 0.21;
            
            return view('statistics/profit', ['participation_profit' => $sum_cost_per_participation,
                                          'article_profit' => $sum_cost_per_articles,
                                          'material_profit' => $sum_cost_per_materials,
                                          'VAT' => $VAT_sum,
                                          'events' => $events]);
        }

    }
    
    public function acceptaceChart()
    {
        $events = Event::orderBy('id', 'desc')
                ->pluck('name', 'id');
        $events->prepend('All',0);
        
        $all_articles = Article::all()->count();
        $accepted_articles = Article::where('article_status_id', 3)->count();
        $declined_articles = Article::where('article_status_id', 4)->count();
        $reviewed_articles = Article::where('article_status_id', 2)->count();
        $not_processed = $all_articles - $accepted_articles - $declined_articles - $reviewed_articles;
        return view('statistics/acceptance', ['accepted_articles' => $accepted_articles,
                                              'declined_articles' => $declined_articles,
                                              'not_processed' => $not_processed,
                                              'under_review' => $reviewed_articles,
                                              'events' => $events]);
        
    }
}
