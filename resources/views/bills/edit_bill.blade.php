@extends('layouts.app')
@section('content')
<div class="container">
    
   <div div class="row">
    <table class="table table-responsive-sm table-bordered">
        <tr>
            <td>{{__('admin_messages.bill_no')}}</td>
            <td>{{$bill->id}}</td>
        </tr>
        <tr>
            <td> Customer </td>
            <td>{{$bill->users->roles->name}}: 
                {{$bill->users->companies->name ?? $bill->users->fullNames->name.' '.$bill->users->fullNames->surname}}
            </td>
        </tr>
        
        <tr>
            <td>{{__('admin_messages.participation')}}</td>
            <td>{{($bill->total_cost_per_participation) ?  $bill->total_cost_per_participation. ' EUR' : '-'}}</td>
        </tr>
        
        <tr>
            <td>{{__('admin_messages.article')}}</td>
            <td>{{($bill->total_cost_per_articles) ?  $bill->total_cost_per_articles. ' EUR' : '-'}} </td>
        </tr>
        
        <tr>
            <td>{{__('admin_messages.material')}}</td>
            <td>{{($bill->total_cost_per_materials) ?  $bill->total_cost_per_materials. ' EUR' : '-'}}</td>
        </tr>
        
        <tr>
            <td>{{__('admin_messages.total')}}</td>
            <td>{{$bill->total_cost_per_articles + 
                  $bill->total_cost_per_participation + 
                  $bill->total_cost_per_materials}} EUR</td>
        </tr>
        
        <tr>
            <td>{{__('admin_messages.event')}}</td>
            <td>{{$bill->events->name}}</td>
        </tr>
        <tr>
            <td>{{__('admin_messages.bill_status')}}</td>
            <td>{{$bill->billStatuses->name}}</td>
        </tr>

    </table>
   </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{__('admin_messages.edit_bill_status')}}</h4>
                <div class="card-body">
                    {{ Form::open(['action' => ['App\Http\Controllers\BillController@update', $bill->id]]) }}
                    <div class="form-group">
                        
                             {{ Form::label('status', __('admin_messages.bill_status'), ['class' => 'control-label']) }}
                                {{ Form::select('status', $statuses , $bill->billStatuses->id)}}
                                @if ($errors->has('status'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                    </div>
                        {{ Form::submit((__('admin_messages.apply')), ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

