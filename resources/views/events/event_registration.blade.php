@extends('layouts.app')
@section('content')

{{-- $event --}}
{{-- Pass: participation[] --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">       
                    <div class="card">
                        <h4 class="list-group-item list-group-item bg-primary text-white">{{$event->name}}</h4>
                        <div class="card-body">
                            
                            {{-- If participant is already registed for event - corresponding message.
                                 If not registed for event and registration is not ended, allow to choose registration option --}}
                            @if(Auth::user()->isRegistred($event->id))
                                <h5> {{__('user_messages.already_registred')}}. </h5>
                            @elseif($event->registration_until > Carbon\Carbon::now())
                                {{ Form::open(['action' => ['App\Http\Controllers\EventController@storeRegistration', $event->id ] , 'onchange'=>"calculate()"]) }}  
                                    <div class="form-group">  
                                        
                                        {{-- Registation options for private participant --}}
                                        @if(Auth::user()->isPrivate())
                                        
                                            {{-- If commercial exhibition is available --}}
                                            @if($event->eventTypes->id == 2 || $event->eventTypes->id == 3)
                                                {{ Form::label('participation', __('user_messages.cost_per_participation').': '.$event->billingPlans->cost_per_participation.' EUR ' ) }}
                                                {{ Form::checkbox('participation[0]', $event->billingPlans->cost_per_participation, false, ['class' => 'approved']) }}
                                                <br>
                                            @endif
                                            
                                            {{-- If conference is available --}}
                                            @if($event->eventTypes->id == 1 || $event->eventTypes->id == 3)
                                                {{ Form::label('participation', __('user_messages.cost_per_article').': '.$event->billingPlans->cost_per_article.' EUR ') }}
                                                {{ Form::checkbox('participation[1]', $event->billingPlans->cost_per_article, false, ['class' => 'approved']) }}
                                                <br>
                                            @endif
                                        @endif
                                        
                                        {{-- Registation options for commercial participant --}}
                                        @if(Auth::user()->isCommercial())
                                        
                                            {{-- If commercial exhibition is available --}}
                                            @if($event->eventTypes->id == 2 || $event->eventTypes->id == 3)
                                                {{ Form::label('participation', __('user_messages.cost_per_material').': '.$event->billingPlans->cost_per_material.' EUR ' ) }}
                                                {{ Form::checkbox('participation[2]', $event->billingPlans->cost_per_material, false, ['class' => 'approved']) }}
                                            @endif
                                        @endif
                                    </div>  
                                    <div class="form-group">  
                                        <div>
                                            {{-- Calculating total cost --}}
                                            <b> Total: 
                                                <div style="display: inline" id="Total">0.00</div> EUR 
                                            </b> 
                                        </div>
                                    </div>
                                    @if($errors->has('participation'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('participation') }}
                                        </div>
                                    @endif
                                
                                    {{-- Warning massage for commercial participant if tried to register for private-only event --}}
                                    @if(!(Auth::user()->isCommercial() && $event->eventTypes->id == 1))
                                        {{ Form::submit(__('user_messages.register'), ['class' => 'btn btn-primary']) }}
                                    @else
                                        <h5>{{__('user_messages.commercial_not_allowed')}}.</h5>
                                    @endif

                                {{ Form::close() }}     
                            @else
                                <h5>{{__('user_messages.registration_ended')}}.</h5>
                            @endif
                        </div>
                    </div>     
            
        </div>
     </div>
</div>
<script type="application/javascript">
    function calculate() {
        //Calculating total cost based on selected parameters
        totalText = document.getElementById('Total').textContent;
        var total = parseInt(totalText,10);
        var checkedBoxes = document.querySelectorAll('input[class=approved]:checked');
        var total_all = 0;
        for (i = 0; i < checkedBoxes.length; ++i) {
            total_all += parseFloat(checkedBoxes[i].value, 10);
        }
        document.getElementById("Total").innerHTML = total_all.toFixed(2);

  }

</script>
@endsection
