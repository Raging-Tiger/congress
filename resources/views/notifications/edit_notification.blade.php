@extends('layouts.app')
@section('content')
<div class="container">
     <div class="row">
        <div class="col-md-12">
            
            <table class="table">
                <tr><th>{{ __('admin_messages.header') }}:</th><td>{{$notification->header }}</td></tr>
                <tr><th>{{ __('admin_messages.body') }}:</th><td>{{$notification->message }}</td></tr>
                <tr><th>{{ __('admin_messages.notification_type') }}:</th><td>{{ucwords($notification->notificationTypes->name) }}</td></tr>
                <tr><th>{{ __('admin_messages.author') }}:</th><td>{{$notification->users->name }}</td></tr>
                <tr><th>{{ __('admin_messages.date') }}:</th><td>{{$notification->created_at }}</td></tr>
            </table>
            
            
            <div class="card-body">
                                {{ Form::open(['action' => 'App\Http\Controllers\NotificationController@update']) }}  
                 <div class="form-group">
                           {{ Form::label('header', __('admin_messages.header'), ['class' => 'control-label']) }}
                           {{ Form::text('header', $notification->header, ['class' => 'form-control'])}}
                            @if ($errors->has('header'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('header') }}
                                </div>
                            @endif
                </div>
                <div class="form-group">
                           {{ Form::label('message', __('admin_messages.body'), ['class' => 'control-label']) }}
                           {{ Form::text('message', $notification->message, ['class' => 'form-control'])}}
                            @if ($errors->has('message'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('message') }}
                                </div>
                            @endif
                </div>
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
                                {{ Form::submit(__('admin_messages.apply'), ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                
         </div>
        </div>
     </div>
</div>
@endsection
