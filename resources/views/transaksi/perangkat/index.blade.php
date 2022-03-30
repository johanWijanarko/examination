@extends('layout.app',[
    
])
@section('content')
<style>
    td.detail-control{

        cursor:pointer;
        width:18px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div>
            <h5>Transaksi Perangkat</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " > 
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('add_trs_prangkat') }}">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>No</th>
                        <th>Nama Perangkat</th>
                        <th>Nama Pegawai</th>
                        <th>Bagian</th>
                        <th>Sub Bagian</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                       
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<!-- small modal -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> 

<script type="text/javascript">

$(function() {
            var template = Handlebars.compile($("#details-template").html());
            var table =$('#data_perangkat').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ url('transaksi_data/perangkat_trans/getTrsPerangkat') }}',
            columns: [
                  
                 {
                "className":      'details-control',
                "orderable":      false,
                "searchable":      false,
                "data":           null,
                "defaultContent": '',
                
                data: 'details_url', name: 'details_url',
            },
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'perangkat', name: 'perangkat' },
                { data: 'pegawai', name: 'pegawai' },
                { data: 'bagian', name: 'bagian' },
                { data: 'sub', name: 'sub' },
                { data: 'status', name: 'status' },
                { data: 'trs_name', name: 'trs_name' },
            ]
        });

        $('#data_perangkat tbody').on('click', '.cek', function (event) {
            event.preventDefault()
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var tableId = 'posts-' + row.data().trs_id;
            // console.log($(this).data('url'))
            // console.log(tableId)
            if (row.child.isShown()) {
        //     // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
        //     // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, $(this).data('url'));
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
        });
    });
    function initTable(tableId, data) {
        console.log(data)
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: data,
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'merk', name: 'merk' },
                { data: 'type', name: 'type' },
                { data: 'kondisi', name: 'kondisi' },
                { data: 'gedung', name: 'gedung' },
                { data: 'ruangan', name: 'ruangan' },
                { data: 'supplier', name: 'supplier' },
                { data: 'kelompok', name: 'kelompok' },
            ]
        })
    }

   // Add event listener for opening and closing details
    

   // display a modal (small modal)
   $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            }
            , complete: function() {
                $('#loader').hide();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
<script id="details-template" type="text/x-handlebars-template">
    <div style="text-align: center;">
        <h5>Detail Perangkat</h5>
    </div><br>
    <table class="table">
        <table class="table details-table" id="posts-@{{trs_id}}">
            <thead>
            <tr>
                <th>No</th>
                <th>Merk</th>
                <th>Type / Kategori</th>
                <th>Kondisi</th>
                <th>Gedung</th>
                <th>Ruangan</th>
                <th>Supplier</th>
                <th>Kelompok</th>
            </tr>
            </thead>
        </table>
    </table>
</script>
@endpush
