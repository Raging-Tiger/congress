@extends('layouts.app')

@section('content')

<div class="container">
     <div class="row">
        <div class="col-md-12">       
                @foreach($billing_plans as $billing_plan)
                    <div class="card">
                            <h4 class="list-group-item list-group-item-primary">{{$billing_plan->name}}</h4>
                                {{$billing_plan->cost_per_article}}
                                
                                {{$billing_plan->cost_per_participation}}
                                
                                {{$billing_plan->cost_per_material}}
                                


                    </div>       
                @endforeach
                
                {!!$billing_plans->links()!!}
        </div>
     </div>
</div>


@endsection
