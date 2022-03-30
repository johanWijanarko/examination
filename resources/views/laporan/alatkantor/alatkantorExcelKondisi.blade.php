<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=Alat-kantor-Kondisi". rand().".xls");
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
                    Laporan Data Peralatan Kantor Per Kondisi
                        {{-- @foreach ($kategoris as $tp)
                            @if(in_array($tp, $tipe))
                            {{ $kategori_name[$tp] }}
                            @endif
                        @endforeach --}}
                    
                        {{-- TAHUN  --}}
                        {{-- @foreach ($tahun as $th)
                            @if(end($tahun) == $th)
                                {{ $th }}
                            @else
                            {{ $th }}, 
                            @endif
                    @endforeach --}}
                    </th>
                </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama Peralatan Kantor</th>
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
               
               
                    @foreach ($alatkantor as $i=> $apl)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $apl->trsHasData->data_manajemen_name }}</td>
                            <td>{{ $apl->trsHasData->manajemenHasMerk->nama_data_merk }}</td>
                            <td>{{ $apl->trsHasData->manajemenHasType->nama_data_type }}</td>
                            <td>{{ $apl->trsHasData->manajemenHasKondisi->nama_data_kondisi }}</td>
                            <td>{{ $apl->trsHasData->manajemenHasSupplier->supplier_name }}</td>
                            <td>{{ $apl->trsHasPegawai->pegawai_name }}</td>
                            <td>{{ $apl->trsHasBagian->nama_bagian }}</td>
                            <td>{{ $apl->trsHasSubBagian->sub_bagian_nama }}</td>
                            @php
                                 $status = [ 
                                    '1' => 'Dipakai',
                                    '2' => 'Dipinjam',
                                    '3' => 'Sedang diperbaiki',
                                    '4' => 'Dikembalikan',
                                    '5' => 'Dimutasi',
                                ];
                            @endphp
                            <td>{{ $apl->trsHasRuangan->nama_data_ruangan }}</td>
                            <td>{{ $status[$apl->trs_status_id] }}</td>
                            <td>{{ $apl->trs_name }}</td>
                        </tr>
                    @endforeach
                
            </table>
        
            
        
        <br>
    </body>
</html>
