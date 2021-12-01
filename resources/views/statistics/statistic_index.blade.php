@extends('layouts.app_statistics')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('admin_messages.statistics_dashboard') }}</div>
                    <div class="card-body">
                        <div><h4>{{ __('admin_messages.statistic_welcome') }}.</h4></div>
                    </div>
             
                </div>
            </div>
        </div>
    </div>
@endsection
