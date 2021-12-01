@extends('layouts.app')

@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">
            <div>
                {{ Form::open(['action' => 'App\Http\Controllers\NotificationController@create']) }}  
                 {{ Form::submit(__('admin_messages.create_notification'), ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
                <br>
            </div>
       
                @foreach($notifications as $notification)
                    <div class="card">
                            <h4 class="list-group-item list-group-item bg-primary text-white">{{$notification->header}}</h4>
                            <div class="card-body">

                                <div class="float-right">
                                {{ Form::open(['action' => 'App\Http\Controllers\NotificationController@destroy', 'onsubmit' => 'return ConfirmDelete()']) }}  
                                {{ Form::hidden('notification_id', $notification->id) }}
                                {{ Form::submit(__('admin_messages.delete_notification'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                </div>
                                
                                <div class="float-right">
                                {{ Form::open(['action' => ['App\Http\Controllers\NotificationController@edit', $notification->id]]) }}  
                                {{ Form::hidden('notification_id', $notification->id) }}
                                {{ Form::submit(__('admin_messages.edit'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                </div>
                                
                                <div>
                                <p> {!! nl2br(e($notification->message)) !!} </p>
                                </div>
                                
                                 <h5>{{ __('admin_messages.author') }}: 
                                    {{$notification->users->name}}; 
                                    {{ __('admin_messages.date') }}: 
                                    {{$notification->created_at }}; 
                                    {{ __('admin_messages.notification_type') }}: 
                                    {{$notification->notificationTypes->name }}</h5>
                                
                            </div> 

                
                @endforeach
                
                {!!$notifications->links()!!}
        </div>
     </div>
</div>
<script> 
function ConfirmDelete() {
    var confirmation = confirm('admin_messages.delete_notification_warning');
    if(confirmation === true)
    {
        return true;
    }
    else
    {
        return false;
    }
    
}
</script>

@endsection

