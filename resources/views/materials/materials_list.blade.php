@extends('layouts.app')
@section('content')

{{-- Received: $materials --}}
{{-- Pass: material, event_id --}}
<div class="container">
    @if ($errors->has('bill'))
        <div class="alert alert-danger">
            {{ $errors->first('bill_confirmation') }}
        </div>
    @endif  
    <table class="table">
        <tr>
            
            <th>Event</th>
            <th>Material status</th>
            <th>Upload</th>
        </tr>
    @foreach($materials as $material)
        <tr>
            <td>{{$material->events->name}}</td>
            
            {{-- Depending on the material submission show appropriate message --}}
            <td> @if(isset($material->events->material_curr(Auth::user()->id)->reference))
                    Material is uploaded
                 @else
                    Material is not uploaded
                 @endif
            </td>
            <td>
                {{-- If event is not ended and bill is paid - allows submission of material.
                     If event is not ended and bill is not paid - corresponding message.
                     If event is ended  - corresponding message. --}}
                @if($material->events->end_date >= Carbon\Carbon::now())
                    @if($material->bill_status_id == 2)
                        {{   Form::open(array('url' => '/upload_material','files'=>'true')) }}
                            {{ Form::file('material') }}
                            {{ Form::hidden('event_id', $material->events->id)}}
                            {{ Form::submit('Upload file') }}
                        {{ Form::close() }}
                    @else
                        The bill is not paid
                    @endif
                @else
                    Event has ended
                @endif
            </td>
        </tr>
    @endforeach
    </table>
</div>

@endsection

