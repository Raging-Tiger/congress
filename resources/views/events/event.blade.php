@extends('layouts.app')
@section('content')

{{-- Received: $event, $billing_plans --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">       
                    <div class="card">
                        <h4 class="list-group-item list-group-item bg-primary text-white">{{$event->name}}</h4>
                        <div class="card-body">
                           
                            <div class="float-right">
                                
                                {{-- If event registration is not ended and participant is not already registred for it - allow registration.
                                     If event registration is not ended and already registrated - show corresponding message.
                                     If event registration ended - show corresponding message. --}}
                                @if($event->registration_until >= Carbon\Carbon::now() && !Auth::user()->isRegistred($id))
                                    {{ Form::open(['action' => ['App\Http\Controllers\EventController@register', $event->id]]) }}
                                        {{ Form::submit(__('user_messages.register_on_event'), ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                @elseif(Auth::user()->isRegistred($id))
                                    <p>{{__('user_messages.already_registred')}}</p>
                                @elseif($event->end_date <= Carbon\Carbon::now())
                                    <p>{{__('user_messages.event_ended')}}</p>
                                @else
                                    <p>{{__('user_messages.registration_ended')}}</p>                         
                                @endif
                            </div>
                                
                            <h5 class="card-title"><b>{{__('user_messages.event_type')}}: </b>{{$event->eventTypes->name}}</h5> 
                            <h5><b>{{__('user_messages.starting_day')}}: </b>{{date('d-m-Y', strtotime($event->start_date))}}</h5> 
                            <h5><b>{{__('user_messages.ending_day')}}: </b>{{date('d-m-Y', strtotime($event->end_date))}}</h5> 
                            <h5><b>{{__('user_messages.registration_till')}}: </b>{{date('d-m-Y', strtotime($event->registration_until))}}</h5> 
                                
                            <p> {{__('user_messages.event_info')}}: {!! nl2br(e($event->info)) !!}</p>
                                
                                       
                        </div>
                    </div>       
        </div>
     </div>
</div>

@endsection