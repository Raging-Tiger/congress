@extends('layouts.app')
@section('content')

{{-- Received: $article, $event --}}
{{-- Pass: title, co_authors, abstract, article, event_id --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{__('user_messages.article_submission_header')}} "{{$event->name}}"</h4>
                    <div class="card-body">
                        
                        {{-- Form for new article data --}}
                        
                        {{ Form::open(['action' => 'App\Http\Controllers\ArticleController@storeArticle', 'files' => true]) }} 
                            
                            {{-- Atricle title, text field, with attached errors displaying --}}
                            <div class="form-group">
                                {{ Form::label('title', __('user_messages.title'), ['class' => 'control-label']) }}
                                    {{ Form::text('title', $article->title ?? '', ['class' => 'form-control'])}}
                                        @if ($errors->has('title'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('title') }}
                                            </div>
                                        @endif
                            </div>
                            
                            {{-- co-authors, text field, with attached errors displaying --}}
                            <div class="form-group">
                                {{ Form::label('co_authors', __('user_messages.co'), ['class' => 'control-label']) }}
                                    {{ Form::text('co_authors', $article->co_authors ?? '', ['class' => 'form-control'])}}
                                        @if ($errors->has('co_authors'))
                                            <div class="alert alert-danger">
                                               {{ $errors->first('co_authors') }}
                                            </div>
                                        @endif
                            </div>
                            
                            {{-- Abstract, text area, with attached errors displaying --}}
                            <div class="form-group">
                                {{ Form::label('abstract', __('user_messages.abstract'), ['class' => 'control-label']) }}
                                    {{ Form::textarea('abstract', $article->abstract ?? '', ['class' => 'form-control'])}}
                                        @if ($errors->has('abstract'))
                                            <div class="alert alert-danger">
                                               {{ $errors->first('abstract') }}
                                            </div>
                                        @endif
                            </div>

                            {{-- File submission (article), with attached errors displaying --}}
                            <div class="form-group">
                                {{ Form::label('article', __('user_messages.article'), ['class' => 'control-label']) }}
                                    {{ Form::file('article') }}
                                    @if ($errors->has('article'))
                                            <div class="alert alert-danger">
                                               {{ $errors->first('article') }}
                                            </div>
                                    @endif

                            </div>

                            {{-- Hidden parameter - event ID --}}
                            {{ Form::hidden('event_id', $event->id) }}

                        {{-- Submit form --}}
                        {{ Form::submit(__('user_messages.upload'), ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                                
                
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
