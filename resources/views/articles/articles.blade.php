@extends('layouts.app')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item-primary">Article dashboard</h4>
                <div class="card-body">
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($events as $event)
                        <h4>{{$event->events->name}}</h4>
                        @php echo('<div class="acceptance_chart_container" id="'.$index.'"></div>'); @endphp
                           
                            @php
                                $index++;
                            @endphp
                        <div class="form-group">
                        @if(Auth::user()->isPaidArticle($event->id))
                           
                           You can upload the article. Please notice, that all articles will go through a review. 
                           {{ Form::open(['action' => ['App\Http\Controllers\ArticleController@uploadArticle', $event->id]]) }}
                                {{ Form::submit(('Upload article'), ['class' => 'btn btn-primary'])}}
                            {{ Form::close() }}
                            
                            @if($event->events->article_curr(Auth::user()->id))
                                Status: {{$event->events->article_curr(Auth::user()->id)->articleStatuses->name}}
                                <br>
                                Review is available
                                <br>
                                {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@downloadReview', $event->events->article_curr(Auth::user()->id)->id], 'target' => '_blank']) }}
                                    {{ Form::submit(('Download review'), ['class' => 'btn btn-primary'])}}
                                {{ Form::close() }}
                                
                            @endif
                        @elseif(Auth::user()->isArticleService($event->id))
                            The bill is not paid
                        @else
                            You are registrated only for participation
                        @endif
                        </div>
                    
                    @endforeach
                    {!!$events->links()!!}
                </div>
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