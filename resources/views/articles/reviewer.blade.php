@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item-primary">MCRU</h4>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Event name</th>
                            <th>Article title</th>
                            <th>Download article</th>
                            <th>Upload review</th>
                            <th>Edit data</th>
                        </tr>
                    
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{$article->events->name}}</td>
                            <td>{{$article->title}}</td>
                            
                            <td>
                                {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@downloadArticle']]) }}
                                    {{ Form::hidden('article_id', $article->id)}}
                                    {{ Form::submit('Download', ['class' => 'btn btn-primary'])}}
                                {{ Form::close() }} 
                            </td>
                            <td>{{   Form::open(array('url' => '/review/upload','files'=>'true')) }}
                                    {{ Form::file('review') }}
                                    {{ Form::hidden('article_id', $article->id)}}
                                    {{ Form::submit('Upload file') }}
                                 {{ Form::close() }}
                            </td>
                            <td>
                                {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@edit', $article->id]]) }}
                                    {{ Form::submit('Edit', ['class' => 'btn btn-primary'])}}
                                {{ Form::close() }} 
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection