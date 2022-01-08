<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bill;
use App\Models\Event;
use App\Models\UserEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

define('SENT', 1);
define('UNDER_REVIEW', 2);
define('ACCEPTED', 3);
define('DECLINED', 4);

class ArticleController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     * 
     */
    public function __construct() {
    
        $this->middleware('private')->only(['index', 'uploadArticle', 'storeArticle']);
    } 
    
    /**
     * Display a listing of all events with conferences to private participant.
     *
     * @return corresponing view.
     */
    public function index()
    {   
        /* All events, where private participant wants to participate in conference */
        $user_conferences = Bill::where('user_id', auth()->user()->id)->where('total_cost_per_articles', '!=', NULL)->pluck('event_id');     
        $events = Event::whereIn('id', $user_conferences)->paginate(3);

        $events_ids = $events->pluck('id');
        $acceptance = array();
        
        /* Main article statuses for acceptance rate widget */
        foreach($events_ids as $id)
        {
            $all_articles = Article::where('event_id', $id)->count();
            $accepted_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', ACCEPTED)->count();
            $declined_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', DECLINED)->count();
            $reviewed_articles = Article::where('event_id', $id)
                                 ->where('article_status_id', UNDER_REVIEW)->count();
            $not_processed = $all_articles - $accepted_articles - $declined_articles - $reviewed_articles;
            
            array_push($acceptance, array($accepted_articles, $declined_articles, $reviewed_articles, $not_processed));
        }
       // dd($acceptance);
        return view('articles/articles', ['events' => $events, 'acceptance' => $acceptance]);
    }
    
    /**
     * Display a form for submitting the article.
     * 
     * @param  $id - event ID.
     * @return corresponing view.
     */
    public function uploadArticle($id) 
    {
        /* If event exists and user is registrated and paid bill */
        if(Event::where('id', '=', $id)->exists() && 
                UserEvent::where('event_id', '=', $id)
                ->where('user_id', auth()->user()->id)
                ->exists() && auth()->user()->isPaidArticle($id))
        {
            /* If article already has been submitted */
            $existing_article = Article::where('event_id', '=', $id)->where('user_id', '=', auth()->user()->id)->first();

            return view('articles/article_submission', ['event' => Event::where('id', $id)->first(), 'article' => $existing_article]);
        }
        /* If not found or not paid - abort */
        else
        {
            abort(404);
        }
    }
    
     /**
     * Store a article data in the DB.
     * Store article file in the local storage.
     *
     * @param  $request from the form.
     * @return action ArticleController@index
     */
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

        /* Generates path to storgae folder */
        $event_name = Event::where('id', $request->event_id)->first('name');
        $folder_name = str_replace(' ', '_', strtolower($event_name->name));
        $received_articles_path = '/public/articles/' . $folder_name.'/received';
        /* Generates unique file name */
        $uniqe_id = uniqid();

        /* If article submitted for the first time - creates corresponding DB entry and stores article */
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
                'article_status_id' => SENT,
                'reference' => $file_name,
            ]);

            $file->storeAs($received_articles_path, $file_name);
        }
        
        /* If article is re-submitted - updates corresponding DB entry, deletes previous version and stores new version of the article */
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
                $existing_article->article_status_id = SENT;
                $existing_article->save();

                \Storage::delete($received_articles_path.'/'.$old_reference);
                
                $file->storeAs($received_articles_path, $file_name);
                    
            }
        }
        return redirect()->action('App\Http\Controllers\ArticleController@index');       
    }
    

}
