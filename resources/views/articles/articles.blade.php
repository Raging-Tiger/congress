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