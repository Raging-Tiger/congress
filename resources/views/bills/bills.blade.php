@extends('layouts.app')
@section('content')

{{-- Received: $bills --}}
<div class="container">
    @if ($errors->has('bill'))
        <div class="alert alert-danger">
            {{ $errors->first('bill_confirmation') }}
        </div>
    @endif  
    <table class="table">
        <tr>
            <th>{{__('admin_messages.bill_no')}}</th>

            @if(Auth::user()->isPrivate())
                <th>{{__('admin_messages.participation')}}</th>
                <th>{{__('admin_messages.article')}}</th>
            @elseif(Auth::user()->isCommercial())
                <th>{{__('admin_messages.material')}}</th>
            @endif

            <th>{{__('admin_messages.total')}}</th>
            <th>{{__('admin_messages.event')}}</th>
            <th>{{__('admin_messages.bill_status')}}</th>
            <th>{{__('user_messages.download_invoice')}}</th>
            <th>{{__('user_messages.upload_payment')}}</th>
        </tr>
    @foreach($bills as $bill)
        {{-- According to coloring scheme - Paid - Green, Underpaid - Gray, Sent - Yellow, Overdue - Red --}}
        @if($bill->billStatuses->id == 2)
            <tr class="table-success">
        @elseif($bill->billStatuses->id == 1)
            <tr class="table-warning">
        @elseif($bill->billStatuses->id == 3)
            <tr class="table-secondary">
        @elseif($bill->billStatuses->id == 5)
            <tr class="table-danger">
        @endif
            <td>{{$bill->id}}</td>
            
            {{-- Cost for private participant --}}
            @if(Auth::user()->isPrivate())
                
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
                {{-- Total sum of all positions --}}
                <td>{{$bill->total_cost_per_articles + $bill->total_cost_per_participation}} EUR</td>
            
            {{-- Cost for commercial participant --}}
            @elseif(Auth::user()->isCommercial())
                <td>{{$bill->total_cost_per_materials}} EUR</td>
                <td>{{$bill->total_cost_per_materials}} EUR</td>

            @endif
            <td>{{$bill->events->name}}</td>
            <td>{{$bill->billStatuses->name}}</td>
            
            {{-- Download corresponding invoice --}}
            <td>
                {{ Form::open(['action' => ['App\Http\Controllers\BillController@downloadInvoice']]) }}
                   {{ Form::hidden('bill_id', $bill->id)}}
                   {{ Form::submit(__('user_messages.download'), ['class' => 'btn btn-primary'])}}
               {{ Form::close() }} 
            </td>
            
            {{-- If bill is not paid, allows to upload payment confirmation --}}
            <td>
                @if ($bill->billStatuses->id != 2)
                 {{   Form::open(array('url' => '/upload_confirmation','files'=>'true')) }}
                    {{ Form::file('bill_confirmation') }}
                    {{ Form::hidden('bill_id', $bill->id)}}
                    {{ Form::submit('Upload file') }}
                 {{ Form::close() }}
                @endif
                
            </td>
        </tr>
    @endforeach
    </table>
    {{-- Pagination --}}
    {!!$bills->links()!!}
</div>

@endsection
