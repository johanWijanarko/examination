@extends('layout.app',[
    
])
@section('content')
<style>
.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
<div class="card">
    <div class="card-header" style="text-align: center !important">
       <h5>Laporan Grafik Pengembalian Inventaris Lainnya</h5>
    </div>
    <div class="row">
            <div class=" col-md-12 col-sm-12 col-12">
                        <div class="row mt-5">
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="card card-statistic-1">
                                    <figure class="highcharts-figure">
                                        <div id="container"></div>
                                        <p class="highcharts-description" style="text-align: center">
                                            Laporan Grafik Pengembalian Inventaris Lainnya
                                        </p>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
</div>
{{-- @if ($lapperangkat == null)

@else --}}

{{-- @endif --}}
@endsection
@push('page-script')

<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> 

<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            viewDistance: 25,
            depth: 40
        }
    },

    title: {
        text: ' Laporan Grafik Pengembalian Inventaris Lainnya'
    },

    xAxis: {
        categories: ['Pengembalian Inventaris'],
        labels: {
            skew3d: true,
            style: {
                fontSize: '16px'
            }
        }
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'Laporan Grafik Pengembalian Inventaris Lainnya',
            skew3d: true
        }
    },

    tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
    },

    plotOptions: {
        column: {
            stacking: 'normal',
            depth: 40
        }
    },

    series: [{
        name: 'Inventaris',
        data: [{{ $kembali_inv }}],
        stack: 'male'
    }]
})

//     $(function () {
//     $("#start").datepicker({
//         numberOfMonths: 1,
//         dateFormat: 'dd-mm-yy',
//         onSelect: function (selected) {
//             // var dt = new Date(selected);
//             // dt.setDate(dt.getDate() + 1);
//             // $("#end").datepicker("option", "minDate", dt);
             
//         }
//     });
//     $("#end").datepicker({
//         dateFormat: 'dd-mm-yy',
//         numberOfMonths: 1,
//         onSelect: function (selected) {
//             // var dt = new Date(selected);
//             // dt.setDate(dt.getDate() - 1);
//             // $("#start").datepicker("option", "maxDate", dt);
//         }
//     });
// });
// $(document).ready(function() {
//     $('#gedung').select2();
// });

</script>
@endpush
