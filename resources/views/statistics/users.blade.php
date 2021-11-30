@extends('layouts.app_statistics')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    

                        <div class="card-header">Potential profit (EUR)</div>
                        <div class="card-body">
                            <div id="container"></div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript">
var data = <?php echo json_encode($userData)  ?>;
var data = [['1633305600', 1], ['1633305600', 5]];
const arr = [];
for (let i = 0; i < data.length; i++) {
    console.log(data[i]);
  arr.push(data[i]);
}
console.log(arr);

    Highcharts.stockChart('container', {


        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'New Users'
        },

        series: [{
            name: 'Registrated',
            data: arr,
            tooltip: {
                valueDecimals: 0
            }
        }]
    });
</script>
@endsection

