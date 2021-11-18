@extends('layouts.app')

@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">       
                @foreach($events as $event)
                    <div class="card">
                            <h4 class="list-group-item list-group-item-primary">{{$event->name}}</h4>

                                {{$event->eventTypes->name}}
                                
                                {{date('d-m-Y', strtotime($event->start_date))}}
                                
                                {{date('d-m-Y', strtotime($event->end_date))}}
                                
                                {{date('d-m-Y', strtotime($event->registration_until))}}

                    </div>       
                @endforeach
                
                {!!$events->links()!!}
        </div>
     </div>
</div>


@endsection



