@extends('layouts.app')
@section('content')

{{-- Received: $bills --}}
<div class="container">
    <table class="table">
        <tr>
          <th>{{__('admin_messages.bill_no')}}</th>
          <th>{{__('admin_messages.participation')}}</th>
          <th>{{__('admin_messages.article')}}</th>
          <th>{{__('admin_messages.material')}}</th>
          <th>{{__('admin_messages.total')}}</th>
          <th>{{__('admin_messages.event')}}</th>
          <th>{{__('admin_messages.bill_status')}}</th>
          <th>{{__('admin_messages.display_payment')}}</th>
          <th>{{__('admin_messages.edit')}}</th>
        </tr>
        @foreach($bills as $bill)
            {{-- According to coloring scheme - Paid - Green, Underpaid - Gray, Waiting for confirmation - Yellow, Overdue - Red --}}
            @if($bill->billStatuses->id == 2)
                <tr class="table-success">
            @elseif($bill->billStatuses->id == 4)
                <tr class="table-warning">
            @elseif($bill->billStatuses->id == 3)
                <tr class="table-secondary">
            @elseif($bill->billStatuses->id == 5)
                <tr class="table-danger">
            @endif
                <td>{{ $bill->id }}</td>

                {{-- If exists - displayed --}}
                @if($bill->total_cost_per_participation)
                    <td>{{$bill->total_cost_per_participation}} EUR</td>
                @else
                    <td>-</td>
                @endif

                {{-- If exists - displayed --}}
                @if($bill->total_cost_per_articles)
                    <td>{{$bill->total_cost_per_articles}} EUR</td>
                @else
                    <td>-</td>
                @endif

                {{-- If exists - displayed --}}
                @if($bill->total_cost_per_materials)
                    <td>{{$bill->total_cost_per_materials}} EUR</td>
                @else
                    <td>-</td>
                @endif

               {{-- Total sum of all positions --}}
               <td>{{$bill->total_cost_per_articles + $bill->total_cost_per_participation + $bill->total_cost_per_materials}} EUR</td>
               <td>{{$bill->events->name}}</td>
               <td>{{$bill->billStatuses->name}}</td>
               
               {{-- If bill confirmation is uploaded - allow to download it --}}
               <td>
                   @if($bill->is_confirmation_uploaded != NULL ) 
                    {{ Form::open(['action' => ['App\Http\Controllers\BillController@displayPayment', $bill->id], 'target' => '_blank']) }}
                        {{ Form::submit(('Display payment'), ['class' => 'btn btn-primary'])}}
                    {{ Form::close() }}
                   @endif
               </td>
               
               {{-- Change bill status --}}
               <td>
                    {{ Form::open(['action' => ['App\Http\Controllers\BillController@edit', $bill->id]]) }}
                        {{ Form::submit((__('admin_messages.edit')), ['class' => 'btn btn-primary'])}}
                    {{ Form::close() }}
               </td>

            </tr>
        @endforeach
        
        {{-- Pagination --}}
        {!!$bills->links()!!}
        
    </table>
  
</div>
@endsection

