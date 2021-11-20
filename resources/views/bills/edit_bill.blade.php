@extends('layouts.app')
@section('content')
<div class="container">
    
   <div div class="row">
    <table class="table table-responsive-sm table-bordered">
        <tr>
            <td> Bill ID </td>
            <td>{{$bill->id}}</td>
        </tr>
        <tr>
            <td> Customer </td>
            <td>{{$bill->users->roles->name}}: 
                {{$bill->users->companies->name ?? $bill->users->fullNames->name.' '.$bill->users->fullNames->surname}}
            </td>
        </tr>
        
        <tr>
            <td> Cost per participation </td>
            <td>{{($bill->total_cost_per_participation) ?  $bill->total_cost_per_participation. ' EUR' : '-'}}</td>
        </tr>
        
        <tr>
            <td> Cost per article </td>
            <td>{{($bill->total_cost_per_articles) ?  $bill->total_cost_per_articles. ' EUR' : '-'}} </td>
        </tr>
        
        <tr>
            <td> Cost per material </td>
            <td>{{($bill->total_cost_per_materials) ?  $bill->total_cost_per_materials. ' EUR' : '-'}}</td>
        </tr>
        
        <tr>
            <td> Total cost </td>
            <td>{{$bill->total_cost_per_articles + 
                  $bill->total_cost_per_participation + 
                  $bill->total_cost_per_materials}} EUR</td>
        </tr>
        
        <tr>
            <td> Event </td>
            <td>{{$bill->events->name}}</td>
        </tr>
        <tr>
            <td> Bill status </td>
            <td>{{$bill->billStatuses->name}}</td>
        </tr>

    </table>
   </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item-primary">Edit bill</h4>
                <div class="card-body">
                    {{ Form::open(['action' => ['App\Http\Controllers\BillController@update', $bill->id]]) }}
                    <div class="form-group">
                        
                             {{ Form::label('status', 'Bill status', ['class' => 'control-label']) }}
                                {{ Form::select('status', $statuses , $bill->billStatuses->id)}}
                                @if ($errors->has('status'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                    </div>
                        {{ Form::submit(('Save changes'), ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

