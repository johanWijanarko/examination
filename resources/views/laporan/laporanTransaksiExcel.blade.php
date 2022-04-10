<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=nominatif-trs". rand().".xls");
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
                <th colspan="10" style="font-size: 16px !important; ">

                </th>
            </tr>
            <tr class="noBorder">
                <th colspan="10" style="font-size: 16px !important;">
                Laporan Nominatif Transaksi
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
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>


                @foreach ($laporan as $i=> $lap)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $lap->trsHasStok2->stokHasType->nama_data_type }}</td>
                        <td>{{ $lap->trsHasStok2->data_name }}</td>
                        <td>{{ $lap->trsHasPegawai2->pegawai_name }}</td>
                        <td>{{ $lap->trsHasPegawai2->pegawaiHasBagian->nama_bagian ?? '' }}</td>
                        <td>{{ $lap->trsHasPegawai2->pegawaiHasSubBagian->sub_bagian_nama ?? '' }}</td>
                        <td>{{ $lap->trsHasGedung->nama_data_gedung ?? '' }}</td>
                        <td>{{ $lap->trsHasRuangan->nama_data_ruangan ?? '' }}</td>
                        @php
                            $status = [
                                '1' => 'Dipakai',
                                '2' => 'Dipinjam',
                                '3' => 'Sedang diperbaiki',
                                '4' => 'Dikembalikan',
                                '5' => 'Dimutasi',
                                '6' => 'Selesai diperbaikai',
                                '7' => 'Tidak dapat diperbaik',
                            ];
                        @endphp
                        <td>{{ $status[$lap->trs_detail_status] }}</td>
                        <td>{{ $lap->mainTransaksi->trs_keterangan }}</td>
                    </tr>
                @endforeach

        </table>
        <br>
    </body>
</html>
