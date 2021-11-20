@extends('layouts.app')
@section('content')
<div class="container">
    <table class="table">
        <tr>
          <th>Bill ID</th>
          <th>Cost per participation</th>
          <th>Cost per article</th>
          <th>Cost per material</th>
          <th>Total cost</th>
          <th>Event</th>
          <th>Bill status</th>
          <th>Download payment</th>
          <th>Edit</th>
        </tr>
        @foreach($bills as $bill)
        <tr>
            <td>{{ $bill->id }}</td>
            
            @if($bill->total_cost_per_participation)
                <td>{{$bill->total_cost_per_participation}} EUR</td>
            @else
                <td>-</td>
            @endif
            
            @if($bill->total_cost_per_articles)
                <td>{{$bill->total_cost_per_articles}} EUR</td>
            @else
                <td>-</td>
            @endif
            
            @if($bill->total_cost_per_materials)
                <td>{{$bill->total_cost_per_materials}} EUR</td>
            @else
                <td>-</td>
            @endif
            
           <td>{{$bill->total_cost_per_articles + $bill->total_cost_per_participation + $bill->total_cost_per_materials}} EUR</td>
           <td>{{$bill->events->name}}</td>
           <td>{{$bill->billStatuses->name}}</td>
           <td>
                {{ Form::open(['action' => ['App\Http\Controllers\BillController@displayPayment', $bill->id], 'target' => '_blank']) }}
                    {{ Form::submit(('Display payment'), ['class' => 'btn btn-primary'])}}
                {{ Form::close() }}
           </td>
           <td>
                {{ Form::open(['action' => ['App\Http\Controllers\BillController@edit', $bill->id]]) }}
                    {{ Form::submit(('Edit'), ['class' => 'btn btn-primary'])}}
                {{ Form::close() }}
           </td>

        </tr>
        @endforeach
        
        
    </table>
  
</div>
@endsection

