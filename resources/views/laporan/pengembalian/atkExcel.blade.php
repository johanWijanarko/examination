<!DOCTYPE html>
<html>
<head>
    @php
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=pengembalian-atk-". rand().".xls");
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
                    Laporan Pengembalian Peralatan Kantor
                    </th>
                </tr>
                    <tr>
                        <th>No</th>
                        <th>Objek Pengembalian</th>
                        <th>Merk</th>
                        <th>Type / Kategory</th>
                        <th>Kondisi Sebelum</th>
                        <th>Kondisi Sesudah</th>
                        <th>Supplier</th>
                        <th>Nama Pegawai</th>
                        <th>Bagian</th>
                        <th>Sub Bagian</th>
                        <th>Keterangan</th>
                    </tr>
               
               
                    @foreach ($datakembali as $i=> $lap)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $lap->kembaliHasObjek->data_manajemen_name }}</td>
                            <td>{{ $lap->kembaliHasObjek->manajemenHasMerk->nama_data_merk }}</td>
                            <td>{{ $lap->kembaliHasObjek->manajemenHasType->nama_data_type }}</td>
                            <td>{{ $lap->kembaliHasKondisiSblm->nama_data_kondisi }}</td>
                            <td>{{ $lap->kembaliHasKondisiSkrg->nama_data_kondisi }}</td>
                            <td>{{ $lap->kembaliHasObjek->manajemenHasSupplier->supplier_name }}</td>
                            <td>{{ $lap->kembaliHasPegawai->pegawai_name }}</td>
                            <td>{{ $lap->kembaliHasPegawai->pegawaiHasBagian->nama_bagian }}</td>
                            <td>{{ $lap->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}</td>
                            <td>{{ $lap->pengembalian_keterangan }}</td>
                        </tr>
                    @endforeach
                
            </table>
        
            
        
        <br>
    </body>
</html>
