@extends('layouts.app')
@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">       
                @foreach($events as $event)
                    <div class="card">
                        <h4 class="list-group-item list-group-item bg-primary"><a class="text-white" href={{"/events/".$event->id}}>{{$event->name}}</a></h4>
                        <div class="card-body">
                                
                            <h5 class="card-title"><b>{{__('user_messages.event_type')}}: </b>{{$event->eventTypes->name}}</h5> 
                            <h5><b>{{__('user_messages.starting_day')}}: </b>{{date('d-m-Y', strtotime($event->start_date))}}</h5> 
                            <h5><b>{{__('user_messages.ending_day')}}: </b>{{date('d-m-Y', strtotime($event->end_date))}}</h5> 
                            <h5><b>{{__('user_messages.registration_till')}}: </b>{{date('d-m-Y', strtotime($event->registration_until))}}</h5> 
                                
                            <p> {{__('user_messages.event_info')}}: {!! nl2br(e($event->info)) !!}</p>
              
                        </div>
                             
                    </div>  
                    <br>
                @endforeach
                
                {!!$events->links()!!}
        </div>
     </div>
</div>


@endsection



