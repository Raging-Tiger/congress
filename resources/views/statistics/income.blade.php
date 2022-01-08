@extends('layouts.app_statistics')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>

{{-- Received: $events, $event_id, $participation_profit, $article_profit, $material_profit, $VAT --}}
{{-- Pass: event --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                       
                            {{-- Select event - drop-down list --}}
                            <div class="form-group">
                                {{ Form::open(['action' => ['App\Http\Controllers\StatisticController@incomeChart']]) }}
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
                    <div class="card-header">{{__('admin_messages.rec_income_share')}}</div>
                    
                    <div class="card-body">
                        
                        {{-- Chart container --}}
                        <div id="pie_chart_container"></div>
                    </div>
                    
                    <div class="card-header">{{__('admin_messages.rec_income_share_eur')}}</div>
                    
                    <div class="card-body">
                        
                        {{-- Chart container --}}
                        <div id="bar_chart_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
    
    //Localization of the chart name/axes
    var title_pie = <?php echo json_encode(trans('admin_messages.income_share'))?>;
    var title_bar = <?php echo json_encode(trans('admin_messages.rec_income_share_eur'))?>;
    var xAxis_bar = <?php echo json_encode(trans('admin_messages.source_of_income'))?>;
    
    //Chart data
    var participation_profit  = <?php echo $participation_profit?>;
    var article_profit = <?php echo $article_profit?>;
    var material_profit = <?php echo $material_profit?>;
    var VAT = <?php echo $VAT?>;

    //Render chart
    Highcharts.chart('pie_chart_container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: title_pie
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

    //Render chart
    Highcharts.chart('bar_chart_container', {

      chart: {
              type: 'column'
            },
            title: {
                text: title_bar
            },
            xAxis: {
                title: {
                    text: xAxis_bar
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


