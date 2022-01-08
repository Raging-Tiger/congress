@extends('layouts.app')
@section('content')

{{-- Received: $events --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
                @foreach($events as $event)
                    <div class="card">
                        <h4 class="list-group-item list-group-item bg-primary text-white">{{$event->name}}</h4>
                        <div class="card-body">
                            <div class="float-right">
                                
                                {{-- Edit event data --}}
                                {{ Form::open(['action' => ['App\Http\Controllers\EventController@edit', $event->id]]) }}  
                                    {{ Form::submit(__('admin_messages.edit'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                <br>
                                
                                {{-- Delete event --}}
                                {{ Form::open(['action' => ['App\Http\Controllers\EventController@destroy', $event->id]]) }}  
                                    {{ Form::hidden('event_id', $event->id) }}
                                    {{ Form::submit(__('admin_messages.delete_event'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                <br>
                                
                                {{-- Download participants list --}}
                                {{ Form::open(['action' => ['App\Http\Controllers\EventController@downloadParticipantList', $event->id]]) }}  
                                    {{ Form::hidden('event_id', $event->id) }}
                                    {{ Form::submit(__('admin_messages.download_list'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                            </div>
                            <div>
                                <h5 class="card-title"><b>Event type: </b>{{$event->eventTypes->name}}</h5> 
                                <h5><b>Starting day of the event: </b>{{date('d-m-Y', strtotime($event->start_date))}}</h5> 
                                <h5><b>Ending day of the event: </b>{{date('d-m-Y', strtotime($event->end_date))}}</h5> 
                                <h5><b>Registration till: </b>{{date('d-m-Y', strtotime($event->registration_until))}}</h5>                               
                                <p> Event information: {{$event->info}}</p>
                            </div>
                            
                                
                        </div>
                    </div>       
                @endforeach
                
                {{-- Pagination --}}
                {!!$events->links()!!}
        </div>
     </div>
</div>


@endsection



