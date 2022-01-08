@extends('layouts.app_statistics')
@section('content')
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{__('admin_messages.tax_prism')}} </div>
                    <div class="card-body">
                        <div id="acceptance_chart_container"></div>
                    </div>
             
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
    var title = <?php echo json_encode(trans('admin_messages.tax_prism_vat'))?>;

    //Chart data
    var L  = <?php echo $base_point?>;
    var n = <?php echo $height_point?>;

    var data = [{
        x: [0, L, L, 0, 0, L, L, 0],
        y: [0, 0, L, L, L, L, 0, 0],
        z: [0, 0, 0, 0, n, n, n, n],
        mode: 'markers',
        type: 'scatter3d',
        marker: {
          color: 'rgb(23, 190, 207)',
          size: 2
        }
    },{
        alphahull: -1,
        opacity: 0.35,
        type: 'mesh3d',
        x: [0, L, L, 0, 0, L, L, 0],
        y: [0, 0, L, L, L, L, 0, 0],
        z: [0, 0, 0, 0, n, n, n, n],
        i: [7, 3, 0, 2, 2, 2, 5, 5, 5, 1, 6, 7],
        j: [3, 4, 1, 3, 3, 4, 7, 7, 6, 2, 7, 1],
        k: [0, 7, 2, 0, 4, 5, 6, 4, 1, 5, 1, 0],
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
        title: title,
        width: 1000
    };

    Plotly.newPlot('acceptance_chart_container', data, layout);


</script>

@endsection