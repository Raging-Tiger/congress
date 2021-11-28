@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item-primary">MCRU</h4>
                <div class="card-body">
                    
                    @foreach ($events as $event)
                        <h4>{{$event->events->name}}</h4>
                            
                        @if(Auth::user()->isPaidArticle($event->id))
                           
                           You can upload the article. Please notice, that all articles will go through a review. 
                           {{ Form::open(['action' => ['App\Http\Controllers\ArticleController@uploadArticle', $event->id]]) }}
                                {{ Form::submit(('Upload article'), ['class' => 'btn btn-primary'])}}
                            {{ Form::close() }}
                            
                            @if($event->events->article_curr(Auth::user()->id))
                                Status: {{$event->events->article_curr(Auth::user()->id)->articleStatuses->name}}
                                <br>
                                Review is available
                                <br>
                                {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@downloadReview', $event->events->article_curr(Auth::user()->id)->id], 'target' => '_blank']) }}
                                    {{ Form::submit(('Download review'), ['class' => 'btn btn-primary'])}}
                                {{ Form::close() }}
                                
                            @endif

                        @else
                            You are registrated only for participation
                        @endif

                    <div class="card-body">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection