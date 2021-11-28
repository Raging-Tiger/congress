@extends('layouts.app_statistics')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                       
                            <div class="form-group">
                                {{ Form::open(['action' => ['App\Http\Controllers\StatisticController@profitShareGeneralChart']]) }}
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
                    <div class="card-header">Potential profit share</div>
                    <div class="card-body">
                        <div id="pie_chart_container"></div>
                    </div>
                    <div class="card-header">Potential profit (EUR)</div>
                    <div class="card-body">
                        <div id="bar_chart_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
    var participation_profit  = <?php echo $participation_profit?>;
    var article_profit = <?php echo $article_profit?>;
    var material_profit = <?php echo $material_profit?>;
    var VAT = <?php echo $VAT?>;

    Highcharts.chart('pie_chart_container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Profit share'
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
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Income',
            colorByPoint: true,
            data: [{
                name: 'Profit from participation',
                y: participation_profit,
                
            }, {
                name: 'Profit from articles',
                y: article_profit
            }, {
                name: 'Profit from materials',
                y: material_profit
            }, {
                name: 'Value-added Tax',
                y: VAT
            }]
        }]
    });

    Highcharts.chart('bar_chart_container', {

      chart: {
              type: 'column'
            },
            title: {
                text: 'Potential profit (EUR)'
            },
            xAxis: {
                title: {
                    text: 'Source of income'
                },
                labels: {
                enabled: false
            },
                tickInterval: 1
            },
            yAxis: {
                title: {
                    text: 'EUR'
                },
                tickInterval: 1
            },
            series: [{
            name: 'Profit from participation',
            data: [participation_profit]
            }, {
                name: 'Profit from articles',
                data: [article_profit]
            }, {
                name: 'Profit from materials',
                data: [material_profit]
            },{
                name: 'Value-added Tax',
                data: [VAT]
            }]

    });
</script>
@endsection
