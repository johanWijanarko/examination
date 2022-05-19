@extends('layout.app',[
'title' => 'Dashboard',
'pageTitle' => 'Dashboard'
])
@section('content')
<style>

    .table-modal th, td{
        padding: 5px !important;
    }

    /* .table-align-center {
        padding: 0px !important;
        font-family: verdana, sans-serif;
    }
    .table-align-center th, td{
        font-size: 12px !important;
        padding: 10px !important;
        font-family: verdana, sans-serif;
    }
    table,
    th,
    td {
        border-collapse: collapse;
        border-color: rgb(242, 242, 242) !important;
        height: 30px !important;
        font-family: verdana, sans-serif;

    }
    th {
        text-align: center !important;
        font-family: verdana, sans-serif;
    }
    .highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
} */

#datatable {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

#datatable caption {
    padding: 1em 0;
    font-size: 12px !important;
    color: #555;
}

#datatable th {
    font-weight: 600;
    padding: 0.5em;
}

#datatable td,
#datatable th,
#datatable caption {
    padding: 0.5em;
    font-size: 12px !important;
}

#datatable thead tr,
#datatable tr:nth-child(even) {
    background: #f8f8f8;
    font-size: 12px !important;
}

#datatable tr:hover {
    background: #f1f7ff;
}

</style>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-primary alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            Hello <strong>{{ strtoupper(Auth::user()->name) }}</strong>, Selamat Datang Di Sistem Administrasi Ujian
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                         {{-- <a href="#" class="stretched-link text-danger" style="position: relative;">Stretched link will not work here, because <code>position: relative</code> is added to the link</a> --}}
                        <i class="fas fa-desktop"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Peserta</h4>
                        </div>
                        <div class="card-body">
                            {{ $countPerangkat }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Soal</h4>
                            </div>
                            <div class="card-body">
                                {{ $countAplikasi }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                        <i class="fas fa-business-time"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Peserta Lulus</h4>
                        </div>
                        <div class="card-body">
                            {{ $countAtk }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                        <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Peserta Gagal</h4>
                        </div>
                        <div class="card-body">
                            {{ $countInv }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-md-12 col-sm-12 col-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Grafik Data Perangkat dan Aplikasi</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Grafik Data Peralatan Kantor dan Inventaris</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Data Perangkat
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container1"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Data Aplikasi
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container2"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                                Laporan Grafik Data Peralatan Kantor
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container3"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                                Laporan Grafik Data Inventaris
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                        <i class="fas fa-desktop"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Mutasi Perangkat</h4>
                        </div>
                        <div class="card-body">
                            {{ $getMutasiperangkat }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Rekapitulasi Mutasi Aplikasi</h4>
                            </div>
                            <div class="card-body">
                                {{ $getMutasiAplikasi }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                        <i class="fas fa-business-time"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Mutasi Alat Kantor</h4>
                        </div>
                        <div class="card-body">
                            {{ $getMutasiAtk }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                        <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Mutasi Inventaris</h4>
                        </div>
                        <div class="card-body">
                            {{ $getMutasiInv }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- grafik --}}
            <div class="row">
                <div class=" col-md-12 col-sm-12 col-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home1-tab" data-toggle="tab" href="#nav-home1" role="tab" aria-controls="nav-home1" aria-selected="true">Laporan Grafik Mutasi Perangkat dan Aplikasi</a>
                            <a class="nav-item nav-link" id="nav-profile1-tab" data-toggle="tab" href="#nav-profile1" role="tab" aria-controls="nav-profile1" aria-selected="false">Laporan Grafik Mutasi  Peralatan Kantor dan Inventaris Lainnya</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home1" role="tabpanel" aria-labelledby="nav-home1-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container4"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Mutasi Perangkat
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container5"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Mutasi Aplikasi
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile1-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container6"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                                Laporan Grafik Mutasi  Peralatan Kantor
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container7"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                                Laporan Grafik Mutasi Inventaris Lainnya
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                        <i class="fas fa-desktop"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Pengembalian Perangkat</h4>
                        </div>
                        <div class="card-body">
                            {{ $perangkatkembali }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Rekapitulasi Pengembalian Aplikasi</h4>
                            </div>
                            <div class="card-body">
                                {{ $aplikasikembali }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                        <i class="fas fa-business-time"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Pengembalian Alat Kantor</h4>
                        </div>
                        <div class="card-body">
                            {{ $atkkembali }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                        <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rekapitulasi Pengembalian Inventaris</h4>
                        </div>
                        <div class="card-body">
                            {{ $invkembali }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- grafik --}}
            <div class="row">
                <div class=" col-md-12 col-sm-12 col-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home3-tab" data-toggle="tab" href="#nav-home3" role="tab" aria-controls="nav-home3" aria-selected="true">Laporan Grafik Pengembalian Perangkat dan Aplikasi</a>
                            <a class="nav-item nav-link" id="nav-profile3-tab" data-toggle="tab" href="#nav-profile3" role="tab" aria-controls="nav-profile3" aria-selected="false">Laporan Grafik Pengembalian Peralatan Kantor dan Inventaris Lainnya</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home3" role="tabpanel" aria-labelledby="nav-home3-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container8"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Pengembalian Perangkat
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container9"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Pengembalian Aplikasi
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile3" role="tabpanel" aria-labelledby="nav-profile3-tab">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container10"></div>
                                            <p class="highcharts-description" style="text-align: center">
                                               Laporan Grafik Pengembalian Peralatan Kantor
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <figure class="highcharts-figure">
                                            <div id="container11"></div>
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
    </div>
@endsection

@push('page-script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Laporan Grafik Data Perangkat'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'unit'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}({point.unit:.0f}unit)'
            }
        }
    },
    series: [{
        name: 'total',
        colorByPoint: true,
        data: [{
            name: 'unit',
            y: {{ $countPerangkat }},
            sliced: true,
            selected: true
        }]
    }]
});

Highcharts.chart('container1', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Laporan Grafik Data Aplikasi'
    },
    subtitle: {
        // text: '<a>Garifk Tindak Lanjut</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Grafik Laporan Aplikasi'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b><br/>'
    },

    series: [
        {
            name: "Unit",
            colorByPoint: true,
            data: [
                {
                    name: "Data Aplikasi",
                    color: '#7CFC00',
                    y:{{ $countAplikasi }},
                    drilldown: "Data Aplikasi"
                }
            ]
        }
    ]
});


Highcharts.chart('container2', {
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
        text: ' Grafik Data Peralatan Kantor'
    },

    xAxis: {
        categories: ['Grafik Data Peralatan Kantor'],
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
            text: 'Grafik Data Peralatan Kantor',
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
        name: 'Peralatan Kantor',
        data: [{{ $countAtk }}],
        stack: 'male'
    }]
});

Highcharts.chart('container3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Grafik Data Peralatan Inventaris'
    },
    subtitle: {
        // text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: ['Unit'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            // text: 'Population (millions)',
            // align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Unit'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: '',
        data: [{{ $countInv }}]
    }]
});

Highcharts.chart('container4', {
    chart: {
        type: 'cylinder',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            depth: 50,
            viewDistance: 25
        }
    },
    title: {
        text: 'Laporan Grafik Mutasi Perangkat'
    },
    plotOptions: {
        series: {
            depth: 25,
            colorByPoint: true
        }
    },
    series: [{
        data: [{{ $getMutasiperangkat }}],
        name: 'Mutasi Perangkat',
        showInLegend: false
    }]
});

Highcharts.chart('container5', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Laporan Grafik Mutasi Aplikasi'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
         pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Mutasi Inventaris',
        data: [
            [{{ $getMutasiAplikasi }}]
        ]
    }]
});


Highcharts.chart('container6', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Laporan Grafik Mutasi  Peralatan Kantor'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'unit'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}({point.unit:.0f}unit)'
            }
        }
    },
    series: [{
        name: 'total',
        colorByPoint: true,
        data: [{
            name: 'unit',
            y: {{ $getMutasiAtk }},
            sliced: true,
            selected: true
        }]
    }]
});

Highcharts.chart('container7', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Laporan Grafik Mutasi Inventaris Lainnya'
    },
    subtitle: {
        // text: '<a>Garifk Tindak Lanjut</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Laporan Grafik Mutasi Inventaris Lainnya'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.f}</b><br/>'
    },

    series: [
        {
            name: "Unit",
            colorByPoint: true,
            data: [
                {
                    name: "Data Mutasi Inventaris",
                    color: '#7CFC00',
                    y:{{ $getMutasiInv }},
                    drilldown: "Data Mutasi Inventaris"
                }
            ]
        }
    ]
});

Highcharts.chart('container8', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Laporan Grafik Pengembalian Perangkat'
    },
    subtitle: {
        // text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: ['Unit'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            // text: 'Population (millions)',
            // align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Unit'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: '',
        data: [{{ $perangkatkembali }}]
    }]
});

Highcharts.chart('container9', {
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
        text: 'Laporan Grafik Pengembalian Aplikasi'
    },

    xAxis: {
        categories: ['Laporan Grafik Pengembalian Aplikasi'],
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
            text: 'Laporan Grafik Pengembalian Aplikasi',
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
        name: 'Aplikasi',
        data: [{{ $aplikasikembali }}],
        stack: 'male'
    }]
});

Highcharts.chart('container11', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Laporan Grafik Pengembalian Inventaris Lainnya'
    },
    subtitle: {
        // text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: ['Unit'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            // text: 'Population (millions)',
            // align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Unit'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: '',
        data: [{{ $invkembali }}]
    }]
});

Highcharts.chart('container10', {
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
        text: 'Laporan Grafik Pengembalian Peralatan Kantor'
    },

    xAxis: {
        categories: ['Laporan Grafik Pengembalian Peralatan Kantor'],
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
            text: 'Laporan Grafik Pengembalian Peralatan Kantor',
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
        name: 'Aplikasi',
        data: [{{ $atkkembali }}],
        stack: 'male'
    }]
});
</script>

@endpush
