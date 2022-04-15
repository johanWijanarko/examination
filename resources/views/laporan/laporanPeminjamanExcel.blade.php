<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=nominatif-peminjaman". rand().".xls");
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
                    <th colspan="12" style="font-size: 16px !important; ">

                    </th>
                </tr>
                <tr class="noBorder">
                    <th colspan="12" style="font-size: 16px !important;">
                    Laporan Peminjaman
                    </th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Type / Kategory </th>
                    <th>Objek Transaksi </th>
                    <th>Nama Pegawai</th>
                    <th>Bagian</th>
                    <th>Sub Bagian</th>
                    <th>Gedung</th>
                    <th>Ruangan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getDataPinjaman as $i=> $apl)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $apl->peminjamanHasType->nama_data_type }}</td>
                        <td>{{ $apl->peminjamanHasObjek->data_name }}</td>
                        <td>{{ $apl->peminjamanHasPegawai->pegawai_name }}</td>
                        <td>{{ $apl->peminjamanHasPegawai->pegawaiHasBagian->nama_bagian ?? '' }}</td>
                        <td>{{ $apl->peminjamanHasPegawai->pegawaiHasSubBagian->sub_bagian_nama ?? ''  }}</td>
                        <td>{{ $apl->peminjamanHasGedung->nama_data_gedung ?? ''  }}</td>
                        <td>{{ $apl->peminjamanHasRuangan->nama_data_ruangan ?? ''  }}</td>
                        <td>{{ date("d F Y", strtotime($apl->peminjaman_tanggal)) }}</td>
                        <td>{{ $apl->peminjaman_jumlah }}</td>
                        <td>{{ $apl->peminjaman_keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    </body>
</html>
