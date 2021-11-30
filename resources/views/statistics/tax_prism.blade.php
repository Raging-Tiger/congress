@extends('layouts.app_statistics')
@section('content')
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                      
                        
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

    var data = [{
        x: [0, 5, 5, 0, 0, 5, 5, 0],
        y: [0, 0, 5, 5, 0, 0, 5, 5],
        z: [0, 0, 0, 0, 5, 5, 5, 5],
        mode: 'markers',
        type: 'scatter3d',
        marker: {
          color: 'rgb(23, 190, 207)',
          size: 2
        }
    },{
        alphahull: 7,
        opacity: 0.35,
        type: 'mesh3d',
        x: [0, 0, 5, 5, 0, 0, 5, 5],
        y: [0, 5, 5, 0, 0, 5, 5, 0],
        z: [0, 0, 0, 0, 5, 5, 5, 5],
        i: [7, 0, 0, 0, 4, 4, 6, 6, 4, 0, 3, 2],
        j: [3, 4, 1, 2, 5, 6, 5, 2, 0, 1, 6, 3],
        k: [0, 7, 2, 3, 6, 7, 1, 1, 5, 5, 7, 6],
    },
    {
        x: [0, 7, 7, 0, 0, 7, 7, 0],
        y: [0, 0, 7, 7, 0, 0, 7, 7],
        z: [0, 0, 0, 0, 7, 7, 7, 7],
        mode: 'markers',
        type: 'scatter3d',
        marker: {
          color: 'rgb(255, 0, 0)',
          size: 4
        }
    },{
        alphahull: 7,
        opacity: 0.35,
        type: 'mesh3d',
        x: [0, 7, 7, 0, 0, 7, 7, 0],
        y: [0, 0, 7, 7, 0, 0, 7, 7],
        z: [0, 0, 0, 0, 7, 7, 7, 7],
        i: [7, 0, 0, 0, 4, 4, 6, 6, 4, 0, 3, 2],
        j: [3, 4, 1, 2, 5, 6, 5, 2, 0, 1, 6, 3],
        k: [0, 7, 2, 3, 6, 7, 1, 1, 5, 5, 7, 6],
    }];

    var layout = {
        autosize: true,
        height: 480,
        scene: {
            aspectratio: {
                x: 1,
                y: 1,
                z: 1
            },
            camera: {
                center: {
                    x: 0,
                    y: 0,
                    z: 0
                },
                eye: {
                    x: 1.25,
                    y: 1.25,
                    z: 1.25
                },
                up: {
                    x: 0,
                    y: 0,
                    z: 1
                }
            },
            xaxis: {
                type: 'linear',
                zeroline: false
            },
            yaxis: {
                type: 'linear',
                zeroline: false
            },
            zaxis: {
                type: 'linear',
                zeroline: false
            }
        },
        title: '3d point clustering',
        width: 1000
    };

    Plotly.newPlot('acceptance_chart_container', data, layout);


</script>

@endsection