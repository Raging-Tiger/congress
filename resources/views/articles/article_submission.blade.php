@extends('layouts.app')
@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <h4 class="list-group-item list-group-item-primary">ARTICLE</h4>
                  
                    {{ Form::open(['action' => 'App\Http\Controllers\ArticleController@storeArticle', 'files' => true]) }}  
                       
                        <div class="form-group">
                            {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                                {{ Form::text('title', $article->title ?? '', ['class' => 'form-control'])}}
                                    @if ($errors->has('abstract'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('abstract') }}
                                        </div>
                                    @endif
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('co_authors', 'Co-authors', ['class' => 'control-label']) }}
                                {{ Form::text('co_authors', $article->co_authors ?? '', ['class' => 'form-control'])}}
                                    @if ($errors->has('co_authors'))
                                        <div class="alert alert-danger">
                                           {{ $errors->first('header') }}
                                        </div>
                                    @endif
                        </div>
                    
                        <div class="form-group">
                            {{ Form::label('abstract', 'Abstract', ['class' => 'control-label']) }}
                                {{ Form::text('abstract', $article->abstract ?? '', ['class' => 'form-control'])}}
                                    @if ($errors->has('abstract'))
                                        <div class="alert alert-danger">
                                           {{ $errors->first('abstract') }}
                                        </div>
                                    @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('article', 'Article', ['class' => 'control-label']) }}
                                {{ Form::file('article') }}
                                @if ($errors->has('article'))
                                        <div class="alert alert-danger">
                                           {{ $errors->first('article') }}
                                        </div>
                                @endif
                           
                        </div>
                        
                                {{ Form::hidden('event_id', $event->id) }}

                                {{ Form::submit('Upload', ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                
                
         </div>
        </div>
     </div>
</div>

@endsection
