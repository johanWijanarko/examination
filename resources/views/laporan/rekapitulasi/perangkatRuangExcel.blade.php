<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=rekap-prangkat-ruang". rand().".xls");
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
                    Laporan Rekapitulasi Data Perangkat Per Ruang
                    </th>
                </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama Perangkat</th>
                        <th>Merk</th>
                        <th>Type / Kategory</th>
                        <th>Kondisi</th>
                        <th>Supplier</th>
                        <th>Nama Pegawai</th>
                        <th>Bagian</th>
                        <th>Sub Bagian</th>
                        <th>Ruangan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
               
               
                    @foreach ($lapperangkat as $i=> $lap)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $lap->trsHasData->data_manajemen_name }}</td>
                            <td>{{ $lap->trsHasData->manajemenHasMerk->nama_data_merk }}</td>
                            <td>{{ $lap->trsHasData->manajemenHasType->nama_data_type }}</td>
                            <td>{{ $lap->trsHasData->manajemenHasKondisi->nama_data_kondisi }}</td>
                            <td>{{ $lap->trsHasData->manajemenHasSupplier->supplier_name }}</td>
                            <td>{{ $lap->trsHasPegawai->pegawai_name }}</td>
                            <td>{{ $lap->trsHasBagian->nama_bagian }}</td>
                            <td>{{ $lap->trsHasSubBagian->sub_bagian_nama }}</td>
                            @php
                                 $status = [ 
                                    '1' => 'Dipakai',
                                    '2' => 'Dipinjam',
                                    '3' => 'Sedang diperbaiki',
                                    '4' => 'Dikembalikan',
                                    '5' => 'Dimutasi',
                                ];
                            @endphp
                            <td>{{ $lap->trsHasRuangan->nama_data_ruangan }}</td>
                            <td>{{ $status[$lap->trs_status_id] }}</td>
                            <td>{{ $lap->trs_name }}</td>
                        </tr>
                    @endforeach
                
            </table>
        
            
        
        <br>
    </body>
</html>
