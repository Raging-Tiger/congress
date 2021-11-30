@extends('layouts.app_statistics')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                       
                            <div class="form-group">
                                {{ Form::open(['action' => ['App\Http\Controllers\StatisticController@acceptanceChart']]) }}
                                     {{ Form::label('event', 'Select event', ['class' => 'control-label']) }}
                                        {{ Form::select('event', $events , $event_id ?? 0)}}
                                        @if ($errors->has('event'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('event') }}
                                            </div>
                                        @endif
                                    {{ Form::submit(('Retrieve'), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                            </div>
                        
                    </div>
                    <div class="card-header">Article acceptance </div>
                    <div class="card-body">
                        <div id="acceptance_chart_container"></div>
                    </div>
             
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
    var accepted_articles  = <?php echo $accepted_articles?>;
    var declined_articles = <?php echo $declined_articles?>;
    var not_processed = <?php echo $not_processed?>;
    var under_review = <?php echo $under_review?>;
    
Highcharts.chart('acceptance_chart_container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Article<br>acceptance',
        align: 'center',
        verticalAlign: 'middle',
        y: 60
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Articles share',
        innerSize: '50%',
        data: [
            ['Accepted', accepted_articles],
            ['Declined', declined_articles],
            ['Not Reviewed', not_processed],
            ['In process', under_review],
        ]
    }]
});
</script>

@endsection
