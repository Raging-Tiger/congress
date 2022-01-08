@extends('layouts.app_statistics')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
    
{{-- Received: $events, $event_id, $accepted_articles, $declined_articles, $not_processed, $under_review  --}}
{{-- Pass: event --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                       
                            {{-- Select event - drop-down list --}}
                            <div class="form-group">
                                {{ Form::open(['action' => ['App\Http\Controllers\StatisticController@acceptanceChart']]) }}
                                     {{ Form::label('event', __('admin_messages.select_event'), ['class' => 'control-label']) }}
                                        {{ Form::select('event', $events , $event_id ?? 0)}}
                                        @if ($errors->has('event'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('event') }}
                                            </div>
                                        @endif
                                    {{ Form::submit((__('admin_messages.retrieve')), ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                            </div>
                        
                    </div>
                    <div class="card-header">{{__('admin_messages.article_acceptance_rate')}}</div>
                    <div class="card-body">
                        
                        {{-- Chart container --}}
                        <div id="acceptance_chart_container"></div>
                    </div>
             
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">

    //Localization of name of the chart
    var title = <?php echo json_encode(trans('admin_messages.article_acceptance_rate_title'))?>;
    
    //Chart data
    var accepted_articles  = <?php echo $accepted_articles?>;
    var declined_articles = <?php echo $declined_articles?>;
    var not_processed = <?php echo $not_processed?>;
    var under_review = <?php echo $under_review?>;

//Render chart
Highcharts.chart('acceptance_chart_container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: title,
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
