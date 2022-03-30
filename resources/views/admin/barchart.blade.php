@extends('layout.app',[
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard'
])
@section('content')

<div class="jumbotron">
    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
        </p>
    </figure>
    <div class="table-responsive">
    <table id="detil_grafik" class="table table-bordered" >
        <tr>
            <th>No</th>
            <th style="text-align: center;" width="30px">Kode Spk</th>
            <th style="text-align: center;">Nama Proyek</th>
            <th style="text-align: center;">Ref Number</th>
            <th style="text-align: center;">Vendor</th>
            <th style="text-align: center;">Target Selesai</th>
            {{-- <th style="text-align: center;">Lokasi</th> --}}
        </tr>
    </table>
    </div>
</div>



@endsection

@push('page-script')
    <script>
      Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Data Inspeksi'
    },
    subtitle: {
        text: 'Source: winnerproyek.com'
    },
    xAxis: {
        categories: [
            'Open',
            'Reject',
            'Approve',
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Banyak Data'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        series: {
            point: {
                events: {
                    click: function () {
                        $.ajax({
                            type: "POST",
                            url:  '{{ url('detailChart') }}',
                            // processData: false,
                            // contentType: false,
                            dataType: "JSON",
                            data: {
                                category: this.category
                            },
                                success: function (data) {
                                    //Loop and inject html table data to specific table 
                                    if ($("#detil_grafik tbody").length === 0) {
                                    $("#detil_grafik").append("<tbody></tbody>");
                                        }
                                        $('#detil_grafik').find("tr:gt(0)").remove();
                                        $.each(data, function(i, item){
                                        $("#detil_grafik tbody").append(
                                            "<tr>" +
                                            "<td>" + (++i) + "</td>"+
                                            "<td>" + item.insepksiproyek.pic_spk + "</td>"+
                                            "<td>" + item.insepksiproyek.pic_short_name+ "</td>"+
                                            "<td>" + item.ref_number + "</td>"+
                                            "<td>" +  + "</td>"+
                                            "<td>" + item.insepksiproyek.pic_tanggal_selesai+ "</td>"+
                                            // "<td>" +  + "</td>"+
                                            "</tr>"
                                            );
                                        });
                                    // console.log(data);
                                        }
                                // }
                            });
                    }
                }
            }
        }
    },
    series: [{
        name: 'Status',
        data: [{{ $userinspeksiOpen }}, {{ $userinspeksiReject }}, {{ $userinspeksiApprove }}]

    }]
});
    </script>
@endpush