@extends('layouts.app')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('user_messages.article_dashboard')}}</div>
                    @php
                        $index = 1;
                    @endphp
                    
                    @foreach ($events as $event)
                        <h4 class="list-group-item list-group-item bg-primary text-white">{{$event->name}}</h4>
                        <div class="card-body">
                            <div class="float-right" style="width: 50%;">@php echo('<div class="acceptance_chart_container" id="'.$index.'"></div>'); @endphp</div>

                                @php
                                    $index++;
                                @endphp
                               
                            <div class="form-group">
                                <div class="float-left">
                                    @if(Auth::user()->isPaidArticle($event->id))
                                            @if($event->end_date >= Carbon\Carbon::now())
                                                @if(!($event->article_curr(Auth::user()->id)) || 
                                                     $event->article_curr(Auth::user()->id)->article_status_id == 1 || 
                                                     $event->article_curr(Auth::user()->id)->article_status_id == 5)

                                                    <p>{{__('user_messages.upload_article_message')}}.</p>
                                                    {{ Form::open(['action' => ['App\Http\Controllers\ArticleController@uploadArticle', $event->id]]) }}
                                                        {{ Form::submit((__('user_messages.upload_article')), ['class' => 'btn btn-primary'])}}
                                                    {{ Form::close() }}

                                                @endif
                                            @else
                                                <p>{{__('user_messages.submission_ended')}}</p>
                                            @endif
                                        
                                        @if($event->article_curr(Auth::user()->id))
                                         <p>{{__('user_messages.article_uploaded')}}</p>
                                            @if($event->article_curr(Auth::user()->id)->reference || $event->article_curr(Auth::user()->id)->review_reference)
                                                <p>{{__('user_messages.status')}}: {{$event->article_curr(Auth::user()->id)->articleStatuses->name}}</p>
                                            @endif

                                            
                                            @if($event->article_curr(Auth::user()->id)->review_reference)

                                                <p>{{__('user_messages.review_available')}}.</p>
                                                
                                                {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@downloadReview', $event->article_curr(Auth::user()->id)->id], 'target' => '_blank']) }}
                                                    {{ Form::submit((__('user_messages.download_review')), ['class' => 'btn btn-primary'])}}
                                                {{ Form::close() }}     
                                            @endif
                                        @endif
                                    @elseif(Auth::user()->isArticleService($event->id))
                                            <p>{{__('user_messages.not_paid')}}.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                    {!!$events->links()!!}              
            </div>
        </div>
    </div>    
</div>
<script type="application/javascript">
    var ids = $('.acceptance_chart_container').map(function(_, x) { return x.id; }).get();
    var acceptance = <?php echo json_encode($acceptance)?>;
    console.log(acceptance[0]);
    ids.forEach(function(item) {
        
        var accepted_articles = acceptance[item - 1][0];
        var declined_articles = acceptance[item - 1][1];
        var under_review = acceptance[item - 1][2];
        var not_processed = acceptance[item - 1][3];
        
        Highcharts.chart(item, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Article<br>acceptance<br>rate',
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

    
    
});
</script>
@endsection