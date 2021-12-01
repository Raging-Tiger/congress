@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{ __('admin_messages.create_notification') }}</h4>
                <div class="card-body">

                     {{ Form::open(['action' => 'App\Http\Controllers\NotificationController@store']) }}  
                     <div class="form-group">
                               {{ Form::label('header', __('admin_messages.header'), ['class' => 'control-label']) }}
                               {{ Form::text('header', '', ['class' => 'form-control'])}}
                                @if ($errors->has('header'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('header') }}
                                    </div>
                                @endif
                    </div>
                    <div class="form-group">
                               {{ Form::label('message', __('admin_messages.body'), ['class' => 'control-label']) }}
                               {{ Form::textarea('message', '', ['class' => 'form-control'])}}
                                @if ($errors->has('message'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                    </div>
                    <div class="form-group">
                               {{ Form::label('notification_type', __('admin_messages.notification_visibility'), ['class' => 'control-label']) }}
                               {{ Form::select('notification_type', $notification_type, ['class' => 'form-control', 'placeholder' => 'Select visibility type'])}}
                                @if ($errors->has('notification_type'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('notification_type') }}
                                    </div>
                                @endif
                    </div>
                    <div class="form-group">
                               {{ Form::label('lang', __('admin_messages.lang'), ['class' => 'control-label']) }}
                               {{ Form::select('lang', $languages, ['class' => 'form-control', 'placeholder' => 'Select visibility type'])}}
                                @if ($errors->has('lang'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('lang') }}
                                    </div>
                                @endif
                    </div>
                    {{ Form::submit(__('admin_messages.create'), ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
