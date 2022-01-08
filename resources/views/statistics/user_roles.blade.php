@extends('layouts.app_statistics')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>

    {{-- Received: $userData --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('admin_messages.user_roles') }}</div>
                    
                    <div class="card-body">
                        
                        {{-- Chart container --}}
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
//Localization of the chart name/axes
var title = <?php echo json_encode(trans('admin_messages.user_roles'))?>;
var xAxis = <?php echo json_encode(trans('admin_messages.roles'))?>;
var yAxis = <?php echo json_encode(trans('admin_messages.num_of_users'))?>;

//Chart data
var userRolesData = <?php echo json_encode($userData)?>;

//Render chart
Highcharts.chart('container', {

  chart: {
          type: 'column'
        },
        title: {
            text: title
        },
        xAxis: {
            title: {
                text: xAxis
            },
            labels: {
            enabled: false
        },
            tickInterval: 1
        },
        yAxis: {
            title: {
                text: yAxis
            },
            tickInterval: 1
        },
        series: userRolesData,
        showInLegend: false

});
              
    </script>
@endsection