@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
          
            <div class="card-body">
                <h4 class="list-group-item list-group-item-primary">{{ __('admin_messages.create_event') }}</h4>
                {{ Form::open(['action' => 'App\Http\Controllers\EventController@store']) }}  
                
                <div class="form-group">
                    {{ Form::label('event_name', __('admin_messages.event_name'), ['class' => 'control-label']) }}
                    {{ Form::text('event_name', '', ['class' => 'form-control'])}}
                    @if ($errors->has('event_name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('event_name') }}
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <div class="row"> 
                        <div class="col-md-4">
                            {{ Form::label('start_date', __('admin_messages.start_date'), ['class' => 'control-label']) }}
                            {{ Form::date('start_date', \Carbon\Carbon::now()) }}
                            @if ($errors->has('start_date'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                        </div>
                    
                        <div class="col-md-4">
                            {{ Form::label('end_date', __('admin_messages.end_date'), ['class' => 'control-label']) }}
                            {{ Form::date('end_date', \Carbon\Carbon::now()) }}
                            @if ($errors->has('end_date'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            {{ Form::label('registration_till', __('admin_messages.registration_till'), ['class' => 'control-label']) }}
                            {{ Form::date('registration_till', \Carbon\Carbon::now()) }}
                            @if ($errors->has('registration_till'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('registration_till') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('event_types', __('admin_messages.event_types'), ['class' => 'control-label']) }}:
                    <br>
                    @foreach($event_types as $event_type)
                        {{ Form::label('selected_event_type', $event_type->name) }}
                        {{ Form::checkbox('selected_event_type[]', $event_type->id) }}
                        <br>
                    @endforeach
                </div>
                
                <div class="form-group">
                           {{ Form::label('billing_plan', __('admin_messages.billing_plan'), ['class' => 'control-label']) }}
                           {{ Form::select('billing_plan', $billing_plans, ['class' => 'form-control', 'placeholder' => 'Select billing plan'])}}
                            @if ($errors->has('billing_plan'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('billing_plan') }}
                                </div>
                            @endif
                </div>
                
                {{ Form::submit(__('admin_messages.create'), ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    
</div>

@endsection