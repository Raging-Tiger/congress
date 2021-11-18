@extends('layouts.app')

@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">       
                    <div class="card">
                        <h4 class="list-group-item list-group-item-primary">{{$event->name}}</h4>
                        <div class="card-body">
                            {{ Form::open(['action' => ['App\Http\Controllers\EventController@storeRegistration', $event->id ] , 'onchange'=>"myFunction()"]) }}  
                                <div class="form-group">  
                                    @if(Auth::user()->isPrivate())
                                        {{ Form::label('selected_event_type', __('user_messages.cost_per_participation').': '.$event->billingPlans->cost_per_participation.' EUR ' ) }}
                                        {{ Form::checkbox('selected[]', $event->billingPlans->cost_per_participation, false, ['class' => 'approved']) }}
                                        <br>
                                        {{ Form::label('selected_event_type', __('user_messages.cost_per_article').': '.$event->billingPlans->cost_per_article.' EUR ') }}
                                        {{ Form::checkbox('selected[]', $event->billingPlans->cost_per_article, false, ['class' => 'approved']) }}
                                        <br>
                                    @elseif(Auth::user()->isCommercial())
                                        {{ Form::label('selected_event_type', __('user_messages.cost_per_material').': '.$event->billingPlans->cost_per_material.' EUR ' ) }}
                                        {{ Form::checkbox('selected[]', $event->billingPlans->cost_per_material, false, ['class' => 'approved']) }}
                                    @endif
                                </div>  
                                <div class="form-group">  
                                    <div> 
                                        <b> Total: 
                                            <div style="display: inline" id="Total">0.00</div> EUR 
                                        </b> 
                                    </div>
                                </div> 
                                {{ Form::submit(__('user_messages.register'), ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}                 
                        </div>
                    </div>     
            
        </div>
     </div>
</div>
<script type="application/javascript">
    function myFunction() {
        
        
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
