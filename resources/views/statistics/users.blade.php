@extends('layouts.app_statistics')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

    {{-- Received: $userData --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    

                        <div class="card-header">{{__('admin_messages.new_users_registration')}}</div>
                        <div class="card-body">
                            
                            {{-- Chart container --}}
                            <div id="container"></div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">

//Chart data
var data = <?php echo json_encode($userData)  ?>;
var title = <?php echo json_encode(trans('admin_messages.new_users_registration'))?>;

    //Render chart
    Highcharts.stockChart('container', {


        rangeSelector: {
            selected: 1
        },

        title: {
            text: title
        },

        series: [{
            name: 'Registrated',
            data: data,
            tooltip: {
                valueDecimals: 0
            }
        }]
    });
</script>
@endsection

