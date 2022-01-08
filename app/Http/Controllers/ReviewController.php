<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleStatus;
class ReviewController extends Controller
{
    public function __construct() {
       
        $this->middleware('reviewer')->only(['index', 'downloadArticle', 'uploadReview', 'edit', 'update']);
        $this->middleware('private')->only(['downloadReview']);
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(25);
        return view('articles/reviewer', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadArticle(Request $request)
    {
        $article = Article::where('id', '=', $request->article_id)->first();

        $reference = $article->reference;
        $storagePath  = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $folder_name = str_replace(' ', '_', strtolower($article->events->name)); 
        $small_path = '/public/articles/' . $folder_name.'/received/'.$reference;
        $received_articles_path = $storagePath.$small_path;
       
        if (\Storage::disk('local')->exists($small_path)) 
        {
            $article->article_status_id = 2;
            $article->save();
            return response()->file($received_articles_path);

        }    
        
    }
    
    public function downloadReview($id)
    {
        $article = Article::where('id', '=', $id)->where('user_id', '=', auth()->user()->id)->first();
        if($article == NULL)
        {
            abort(403);
        }
        $reference = $article->review_reference;
        $storagePath  = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $folder_name = str_replace(' ', '_', strtolower($article->events->name)); 
        $small_path = '/public/articles/' . $folder_name.'/received/'.$reference.'.pdf';
        $received_articles_path = $storagePath.$small_path;
       //dd($received_articles_path);
        if (\Storage::disk('local')->exists($small_path)) 
        {
            return response()->file($received_articles_path);

        }
        else
        {
            abort(404);
        }
        
    }

    public function uploadReview(Request $request)
    {
        $rules = array(
            'review' => 'required',
        );        
        $this->validate($request, $rules); 
        
        $article = Article::where('id', '=', $request->article_id)->first();
        if($article == NULL)
        {
            abort(404);
        }
        
        $event_name = $article->events->name;
        $reference = 'review_'.$article->reference;
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        $received_articles_path = '/public/articles/' . $folder_name.'/received';
        
        $file = $request->file('review');
        
        $reference = substr($reference, 0, strpos($reference, "."));

        
        $file_name = $reference.'.'.\File::extension($file->getClientOriginalName());
        $file->storeAs($received_articles_path, $file_name);
        $article->review_reference = $reference;
        $article->save();
        
        return redirect()->action('App\Http\Controllers\ReviewController@index');    
        
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
        $article = Article::where('id', '=', $id)->first();
        if($article == NULL)
        {
            abort(404);
        }
        
        $article_statuses = ArticleStatus::all();
        $statuses_list = $article_statuses->pluck('name', 'id');
        
        return view('articles/reviewer_edit', ['article' => $article, 'statuses' => $statuses_list]);
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
        $article = Article::where('id', '=', $id)->first();
        if($article == NULL)
        {
            abort(404);
        }
        
        $article->article_status_id = $request->status;
        
        
        if($request->status == 4)
        {
            $reference = $article->reference;
            $folder_name = str_replace(' ', '_', strtolower($article->events->name)); 
            $small_path = '/public/articles/' . $folder_name.'/received/'.$reference;

            if (\Storage::disk('local')->exists($small_path)) 
            {
                //dd('HERE');
                $article->reference = NULL;
                \Storage::disk('local')->delete($small_path);

            }
        }
        
        if($request->status == 3)
        {
            $reference = $article->reference;
            $folder_name = str_replace(' ', '_', strtolower($article->events->name)); 
            $old_small_path = '/public/articles/' . $folder_name.'/received/'.$reference;
            $new_small_path = '/public/articles/' . $folder_name.'/accepted/'.$reference;
            if (\Storage::disk('local')->exists($old_small_path)) 
            {
               \Storage::disk('local')->move($old_small_path, $new_small_path);
            }
        }
                            
        
        $article->save();
        return redirect()->action('App\Http\Controllers\ReviewController@index');    
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
