<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=mutasi-perangkat-pergedung". rand().".xls");
        header("Cache-Control: max-age=0");
    @endphp
    <style>
        table, th, td
            {
                border-collapse:collapse;
                border: 1px solid black;
                /* font-size: 12px !important; */
            }
        th, td 
            {
                padding: 5px 10px;
                vertical-align: top;
                font-family: Arial, Helvetica, sans-serif;
            }
        .noBorder
            {
                border: 0px !important;
            }
        .font{
            font-size: 16px !important;
        }
        
    </style>
</head>
    <body>
        <table class="table table-bordered table-striped table-inka" id="data_perangkat">
            <tr class="noBorder">
                <th colspan="11" style="font-size: 16px !important; ">
                
                </th>
            </tr>
            <tr class="noBorder">
                <th colspan="11" style="font-size: 16px !important;">
                Laporan Mutasi Peralatan Kantor Per Gedung
                </th>
            </tr>
                <tr>
                    <th>No</th>
                    <th>Objek Mutasi</th>
                    <th>Mutasi Dari</th>
                    <th>Penerima Mutasi </th>
                    <th>Bagian</th>
                    <th>Sub Bagian</th>
                    <th>Gedung</th>
                    <th>Ruangan</th>
                    <th>Kondisi Saat Ini</th>
                    <th>Tanggal Mutasi</th>
                    <th>Keterangan Mutasi</th>
                </tr>
            
            
                @foreach ($getMutasi as $i=> $mut)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $mut->mutasiHasManajemen->data_manajemen_name }}</td>
                        <td>{{ $mut->MutasiHasPegawai->pegawai_name }}</td>
                        <td>{{ $mut->MutasiHasDetail->DetailMutasiHasPegawai->pegawai_name }}</td>
                        <td>{{ $mut->MutasiHasBagian->nama_bagian }}</td>
                        <td>{{ $mut->MutasiHasSubBagian->sub_bagian_nama }}</td>
                        <td>{{ $mut->MutasiHasGedung->nama_data_gedung }}</td>
                        <td>{{ $mut->MutasiHasRuangan->nama_data_ruangan }}</td>
                        <td>{{ $mut->mutasiHasKondisi->nama_data_kondisi }}</td>
                        <td>{{ $mut->mutasi_tgl }}</td>
                        <td>{{ $mut->mutasi_keterangan }}</td>
                    </tr>
                @endforeach
        </table>
        <br>
    </body>
</html>
