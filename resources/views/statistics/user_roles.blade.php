@extends('layouts.app_statistics')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">Users Roles</div>
                    <div class="card-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
var userRolesData = <?php echo json_encode($userData)?>;
console.log(userRolesData)

Highcharts.chart('container', {

  chart: {
          type: 'column'
        },
        title: {
            text: 'Users'
        },
        xAxis: {
            title: {
                text: 'Roles'
            },
            labels: {
            enabled: false
        },
            tickInterval: 1
        },
        yAxis: {
            title: {
                text: 'Number of users'
            },
            tickInterval: 1
        },
        series: userRolesData,
        showInLegend: false

});
              
    </script>
@endsection