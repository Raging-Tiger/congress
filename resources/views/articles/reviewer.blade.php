@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{__('user_messages.reviewer_dashboard')}}</h4>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>{{__('user_messages.event_name')}}</th>
                            <th>{{__('user_messages.article_title')}}</th>
                            <th>{{__('user_messages.download_article')}}</th>
                            <th>{{__('user_messages.upload_review')}}</th>
                            <th>{{__('user_messages.edit_status')}}</th>
                        </tr>
                    
                    @foreach ($articles as $article)
                        @if($article->articleStatuses->id == 3)
                            <tr class="table-success">
                        @elseif($article->articleStatuses->id == 4)
                            <tr class="table-danger">
                        @elseif($article->articleStatuses->id == 1)
                            <tr class="table-warning">
                        @else
                            <tr>
                        @endif
                            <td>{{$article->events->name}}</td>
                            <td>{{$article->title}}</td>
                            
                            <td>
                                @if($article->articleStatuses->id != 3 && $article->articleStatuses->id != 4)
                                    {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@downloadArticle']]) }}
                                        {{ Form::hidden('article_id', $article->id)}}
                                        {{ Form::submit('Download', ['class' => 'btn btn-primary'])}}
                                    {{ Form::close() }} 
                                @endif
                            </td>
                            <td>
                                @if($article->articleStatuses->id != 3 && $article->articleStatuses->id != 4)
                                    {{   Form::open(array('url' => '/review/upload','files'=>'true')) }}
                                        {{ Form::file('review') }}
                                        {{ Form::hidden('article_id', $article->id)}}
                                        {{ Form::submit('Upload file') }}
                                     {{ Form::close() }}
                                    @endif
                            </td>
                            <td>
                                @if($article->articleStatuses->id != 3 && $article->articleStatuses->id != 4)
                                    {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@edit', $article->id]]) }}
                                        {{ Form::submit('Edit', ['class' => 'btn btn-primary'])}}
                                    {{ Form::close() }} 
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </table>
                    
                    {!!$articles->links()!!}
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection