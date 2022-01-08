@extends('layouts.app')
@section('content')

{{-- Received: $billing_plans --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">
            {{-- Error of deletion --}}
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
                @foreach($billing_plans as $billing_plan)
                    <div class="card">
                            <h4 class="list-group-item list-group-item bg-primary text-white">{{$billing_plan->name}}</h4>
                            <div class="card-body">
                                <h5>{{__('admin_messages.cost_per_article')}}: {{$billing_plan->cost_per_article}} EUR</h5>
                                
                                <h5>{{__('admin_messages.cost_per_participation')}}: {{$billing_plan->cost_per_participation}} EUR</h5>
                                
                                <h5>{{__('admin_messages.cost_per_material')}}: {{$billing_plan->cost_per_material}} EUR</h5>  
                                <div class="float-left">
                                    <p>
                                        {{-- If billing plan is used in any number of events - counts in how many --}}
                                        @if($billing_plan->events)
                                            {{__('admin_messages.used_in')}} 
                                            {{$billing_plan->events->count()}} 
                                            {{trans_choice('admin_messages.event_plur', $billing_plan->events->count())}}.
                                        @endif
                                    </p>
                                </div>
                                 
                                <div class="float-right"> 
                                    {{ Form::open(['action' => ['App\Http\Controllers\BillingPlanController@destroy', $billing_plan->id]]) }}  
                                        {{ Form::submit(__('admin_messages.delete_plan'), ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                </div>
                                <div class="float-right">
                                    {{ Form::open(['action' => ['App\Http\Controllers\BillingPlanController@edit', $billing_plan->id]]) }}  
                                        {{ Form::submit(__('admin_messages.edit'), ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                </div> 
                            </div>

                    </div>       
                @endforeach
                {{-- Pagination --}}
                {!!$billing_plans->links()!!}
        </div>
     </div>
</div>
@endsection
