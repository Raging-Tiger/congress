@extends('layouts.app')
@section('content')
<div class="container">
    @if ($errors->has('bill'))
        <div class="alert alert-danger">
            {{ $errors->first('bill_confirmation') }}
        </div>
    @endif  
    <table class="table">
        <tr>
            <th>Bill id</th>

            @if(Auth::user()->isPrivate())
                <th>Cost per participation</th>
                <th>Cost per article</th>
            @elseif(Auth::user()->isCommercial())
                <th>Cost per material</th>
            @endif

            <th>Total cost</th>
            <th>Event</th>
            <th>Bill status</th>
            <th>Download invoice</th>
            <th>Upload payment</th>
        </tr>
    @foreach($bills as $bill)
        <tr>
            <td>{{$bill->id}}</td>
            @if(Auth::user()->isPrivate())
                
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
                <td>{{$bill->total_cost_per_articles + $bill->total_cost_per_participation}} EUR</td>
            @elseif(Auth::user()->isCommercial())
                <td>{{$bill->total_cost_per_materials}} EUR</td>
                <td>{{$bill->total_cost_per_materials}} EUR</td>

            @endif
            <td>{{$bill->events->name}}</td>
            <td>{{$bill->billStatuses->name}}</td>
            
            <td>
                {{ Form::open(['action' => ['App\Http\Controllers\BillController@downloadInvoice']]) }}
                   {{ Form::hidden('bill_id', $bill->id)}}
                   {{ Form::submit('Download', ['class' => 'btn btn-primary'])}}
               {{ Form::close() }} 
            </td>
            
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
</div>

@endsection
