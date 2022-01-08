@extends('layouts.app')
@section('content')

{{-- Received: $event, $billing_plans --}}
{{-- Pass: event_name, start_date, end_date, registration_till, event_info, billing_plan, event_id --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{ __('admin_messages.edit_event') }}</h4>
                    <div class="card-body">
                
                        {{ Form::open(['action' => 'App\Http\Controllers\EventController@update']) }}  
                
                            <div class="form-group">
                                {{ Form::label('event_name', __('admin_messages.event_name'), ['class' => 'control-label']) }}
                                {{ Form::text('event_name', $event->name, ['class' => 'form-control'])}}
                                @if ($errors->has('event_name'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('event_name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                
                                {{-- Row with 3 dates-chosing calendars --}}
                                <div class="row">
                                    
                                    {{-- Event starting day, calendar, focused on TODAY, with attached errors displaying --}}
                                    <div class="col-md-4">
                                        {{ Form::label('start_date', __('admin_messages.start_date'), ['class' => 'control-label']) }}
                                        {{ Form::date('start_date', \Carbon\Carbon::parse($event->start_date)) }}
                                        @if ($errors->has('start_date'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('start_date') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Event ending day, calendar, focused on TODAY, with attached errors displaying --}}
                                    <div class="col-md-4">
                                        {{ Form::label('end_date', __('admin_messages.end_date'), ['class' => 'control-label']) }}
                                        {{ Form::date('end_date', \Carbon\Carbon::parse($event->end_date)) }}
                                        @if ($errors->has('end_date'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('end_date') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Event register till day, calendar, focused on TODAY, with attached errors displaying --}}
                                    <div class="col-md-4">
                                        {{ Form::label('registration_till', __('admin_messages.registration_till'), ['class' => 'control-label']) }}
                                        {{ Form::date('registration_till', \Carbon\Carbon::parse($event->registration_until)) }}
                                        @if ($errors->has('registration_till'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('registration_till') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                
                            {{-- Event information, scalable textbox, with attached errors displaying --}}
                            <div class="form-group">
                                {{ Form::label('event_info', __('admin_messages.event_info'), ['class' => 'control-label']) }}
                                {{ Form::textarea('event_info', $event->info, ['class' => 'form-control'])}}
                                @if ($errors->has('event_info'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('event_info') }}
                                    </div>
                                @endif
                            </div>

                            {{-- Billing plans, drop-down list, with attached errors displaying. --}}
                            <div class="form-group">
                                       {{ Form::label('billing_plan', __('admin_messages.billing_plan'), ['class' => 'control-label']) }}
                                       {{ Form::select('billing_plan', $billing_plans, ['class' => 'form-control', 'placeholder' => $event->billing_plan_id])}}
                                        @if ($errors->has('billing_plan'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('billing_plan') }}
                                            </div>
                                        @endif
                            </div>
                            
                        {{ Form::hidden('event_id', $event->id) }}
                        {{-- Submit form --}}
                        {{ Form::submit(__('admin_messages.apply'), ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
            </div>
        </div>
    </div> 
</div>
@endsection

