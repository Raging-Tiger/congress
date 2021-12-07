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
    public function __construct() {
    
        $this->middleware('private')->only(['index', 'uploadArticle', 'storeArticle']);
    } 
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {           
        $user_conferences = Bill::where('user_id', auth()->user()->id)->where('total_cost_per_articles', '!=', NULL)->pluck('event_id');     
        $events = Event::whereIn('id', $user_conferences)->paginate(3);

        $events_ids = $events->pluck('id');
        $acceptance = array();
        foreach($events_ids as $id)
        {
            $all_articles = Article::where('event_id', $id)->count();
            $accepted_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', 3)->count();
            $declined_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', 4)->count();
            $reviewed_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', 2)->count();
            $not_processed = $all_articles - $accepted_articles - $declined_articles - $reviewed_articles;
            
            array_push($acceptance, array($accepted_articles, $declined_articles, $reviewed_articles, $not_processed));
        }
       // dd($acceptance);
        return view('articles/articles', ['events' => $events, 'acceptance' => $acceptance]);
    }
    
    public function uploadArticle($id) 
    {
        if(Event::where('id', '=', $id)->exists() && 
                UserEvent::where('event_id', '=', $id)
                ->where('user_id', auth()->user()->id)
                ->exists() && auth()->user()->isPaidArticle($id))
        {
            
        
        $existing_article = Article::where('event_id', '=', $id)->where('user_id', '=', auth()->user()->id)->first();

        return view('articles/article_submission', ['event' => Event::where('id', $id)->first(), 'article' => $existing_article]);
        }
        else
        {
            abort(404);
        }
        
        
    }
    
     public function storeArticle(Request $request)
    { 
        if(!($request->has('title')))
        {
            abort(403);
        }
        $rules = array(
            'title' => 'required',
            'co_authors' => 'required',
            'abstract' => 'required',
            'article' => 'required|mimes:docx,doc',
        );    
        $this->validate($request, $rules); 

        
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
    

}
