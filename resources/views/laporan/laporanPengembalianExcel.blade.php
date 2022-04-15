<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=nominatif-Pengembalian". rand().".xls");
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
                    <th colspan="9" style="font-size: 16px !important; ">

                    </th>
                </tr>
                <tr class="noBorder">
                    <th colspan="9" style="font-size: 16px !important;">
                    Laporan Pengembalian
                    </th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Jenis Pengembalian</th>
                    <th>Objek Pengembalian</th>
                    <th>Nama Pegawai</th>
                    <th>Bagian</th>
                    <th>Sub Bagian</th>
                    <th>Kondisi Sebelum</th>
                    <th>Kondisi Sesudah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datakembali as $i=> $apl)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $apl->kembaliHasType->nama_data_type }}</td>
                            <td>{{ $apl->kembaliHasObjek->data_name }}</td>
                            <td>{{ $apl->kembaliHasPegawai->pegawai_name }}</td>
                            <td>{{ $apl->kembaliHasPegawai->pegawaiHasBagian->nama_bagian ?? '' }}</td>
                            <td>{{ $apl->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama ?? '' }}</td>
                            <td>{{ $apl->kembaliHasKondisiSblm->nama_data_kondisi }}</td>
                            <td>{{ $apl->kembaliHasKondisiSkrg->nama_data_kondisi; }}</td>
                            <td>{{ $apl->pengembalian_keterangan }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        <br>
    </body>
</html>
