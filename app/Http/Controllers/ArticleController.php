<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bill;
use App\Models\Event;
use App\Models\UserEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$eligible_events = Event::where('event_type_id', 3)->pluck('id')->toArray();
        $eligible_events = Bill::where('user_id', auth()->user()->id)
                //->where('total_cost_per_articles', '!=', NULL)
                //->where('bill_status_id', 2)
                ->join('events', 'bills.event_id', '=', 'events.id')
                ->where('end_date', '>=', Carbon::today())
                ->where('event_type_id', '!=', 2)
                ->pluck('bills.id')->toArray();
        
        
        $events = UserEvent::where('user_id', auth()->user()->id)->whereIn('event_id', $eligible_events)->get();
        //dd($event);
        return view('articles/articles', ['events' => $events]);
    }
    
    public function uploadArticle($id) 
    {
        $existing_article = Article::where('event_id', '=', $id)->where('user_id', '=', auth()->user()->id)->first();

        return view('articles/article_submission', ['event' => Event::where('id', $id)->first(), 'article' => $existing_article]);
    }
    
     public function storeArticle(Request $request)
    {
        $event_name = Event::where('id', $request->event_id)->first('name');
        $folder_name = str_replace(' ', '_', strtolower($event_name->name));
        $received_articles_path = '/public/articles/' . $folder_name.'/received';
        $uniqe_id = uniqid();

        if(!(Article::where('event_id', '=', $request->event_id)->where('user_id', '=', auth()->user()->id)->exists()))
        {
            $file = $request->file('article');
            $file_name = $uniqe_id.'.'.\File::extension($file->getClientOriginalName());
            
            Article::create([			
                'co_authors' => $request->co_authors,
                'abstract' => $request->abstract,
                'title' => $request->title,
                'user_id' => auth()->user()->id,
                'event_id' => $request->event_id,
                'article_status_id' => 1,
                'reference' => $file_name,
            ]);

            $file->storeAs($received_articles_path, $file_name);
        }
        else
        {
            $existing_article = Article::where('event_id', '=', $request->event_id)->where('user_id', '=', auth()->user()->id)->first();
            $old_reference = $existing_article->reference;
            
            if(\Storage::disk('local')->exists($received_articles_path.'/'.$old_reference))
            {
                $file = $request->file('article');
                $file_name = $uniqe_id.'.'.\File::extension($file->getClientOriginalName());
                
                $existing_article->co_authors = $request->co_authors;
                $existing_article->abstract = $request->abstract;
                $existing_article->title = $request->title;
                $existing_article->reference = $file_name;
                $existing_article->article_status_id = 1;
                $existing_article->save();

                \Storage::delete($received_articles_path.'/'.$old_reference);
                
                $file->storeAs($received_articles_path, $file_name);
                    
            }
        }
        return redirect()->action('App\Http\Controllers\ArticleController@index');       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
