@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{ __('admin_messages.edit_billing_plan') }}</h4>
                    <div class="card-body">
                
                        {{ Form::open(['action' => 'App\Http\Controllers\BillingPlanController@update']) }}  
                            <div class="form-group">
                                {{ Form::label('billing_plan_name', __('admin_messages.billing_plan_name'), ['class' => 'control-label']) }}
                                {{ Form::text('billing_plan_name', $billing_plan->name, ['class' => 'form-control'])}}
                                @if ($errors->has('billing_plan_name'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('billing_plan_name') }}
                                    </div>
                                @endif
                            </div>
                
                            <div class="form-group">
                                {{ Form::label('cost_per_article', __('admin_messages.cost_per_article'), ['class' => 'control-label']) }}
                                {{ Form::number('cost_per_article', $billing_plan->cost_per_article , ['class' => 'form-control', 'step'=>'.01'])}}
                                @if ($errors->has('cost_per_article'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('cost_per_article') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                {{ Form::label('cost_per_participation', __('admin_messages.cost_per_participation'), ['class' => 'control-label']) }}
                                {{ Form::number('cost_per_participation', $billing_plan->cost_per_participation, ['class' => 'form-control', 'step'=>'.01'])}}
                                @if ($errors->has('cost_per_participation'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('cost_per_participation') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                {{ Form::label('cost_per_material', __('admin_messages.cost_per_material'), ['class' => 'control-label']) }}
                                {{ Form::number('cost_per_material', $billing_plan->cost_per_material, ['class' => 'form-control', 'step'=>'.01'])}}
                                @if ($errors->has('cost_per_material'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('cost_per_material') }}
                                    </div>
                                @endif
                            </div>
                        {{ Form::hidden('billing_plan_id', $billing_plan->id) }}
                        {{ Form::submit(__('admin_messages.apply'), ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

