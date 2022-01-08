@extends('layouts.app')
@section('content')

{{-- Received: $notification --}}
{{-- Pass: header, message, notification_type, notification_id --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table class="table">
                    <tr><th style="width: 150px;">{{ __('admin_messages.header') }}:</th><td>{{$notification->header }}</td></tr>
                    <tr><th>{{ __('admin_messages.body') }}:</th><td>{!! nl2br(e($notification->message)) !!}</td></tr>
                    <tr><th>{{ __('admin_messages.notification_type') }}:</th><td>{{ucwords($notification->notificationTypes->name) }}</td></tr>
                    <tr><th>{{ __('admin_messages.author') }}:</th><td>{{$notification->users->name }}</td></tr>
                    <tr><th>{{ __('admin_messages.date') }}:</th><td>{{$notification->created_at }}</td></tr>
                </table>

                <h4 class="list-group-item list-group-item bg-primary text-white">{{ __('admin_messages.edit_notification') }}</h4>
                <div class="card-body">
                                
                            {{-- Form for editing notification --}}
                            {{ Form::open(['action' => 'App\Http\Controllers\NotificationController@update']) }}  
                     
                    {{-- Notification header, text, with attached errors displaying --}}
                    <div class="form-group">
                               {{ Form::label('header', __('admin_messages.header'), ['class' => 'control-label']) }}
                               {{ Form::text('header', $notification->header, ['class' => 'form-control'])}}
                                @if ($errors->has('header'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('header') }}
                                    </div>
                                @endif
                    </div>
                    
                    {{-- Notification message, scalable textbox, with attached errors displaying --}}
                    <div class="form-group">
                               {{ Form::label('message', __('admin_messages.body'), ['class' => 'control-label']) }}
                               {{ Form::textarea('message', $notification->message, ['class' => 'form-control'])}}
                                @if ($errors->has('message'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                    </div>
                    
                    {{-- Notification type, drop-down list, with attached errors displaying --}}
                    <div class="form-group">
                               {{ Form::label('notification_type', __('admin_messages.notification_type'), ['class' => 'control-label']) }}
                               {{ Form::select('notification_type', $notification_type ,  $notification->notificationTypes->id, ['class' => 'form-control'])}}
                                @if ($errors->has('status'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('notification_type') }}
                                    </div>
                                @endif
                    </div>
                                    {{ Form::hidden('notification_id', $notification->id) }}
                                    
                                    {{-- Submit form --}}
                                    {{ Form::submit(__('admin_messages.apply'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
