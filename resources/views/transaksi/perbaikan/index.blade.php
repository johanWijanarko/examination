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
            <h5>Permohonan Perbaikan</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " >
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('tambahPerbaikan') }}">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>No</th>
                        <th>Data Perbaikan</th>
                        <th>Objek Perbaikan</th>
                        <th>Pegawai</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Estimasi Selesai</th>
                        <th>Status Perbaikan</th>
                        <th>Keterangan Perbaikan</th>
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
            ajax: '{{ url('transaksi_data/perbaikan/getDataPerbaikan') }}',
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
                { data: 'dataPerbaikan', name: 'dataPerbaikan' },
                { data: 'ObjekMutasi', name: 'ObjekMutasi' },
                { data: 'pegawai', name: 'pegawai' },
                { data: 'tgl', name: 'tgl' },
                { data: 'estimasi', name: 'estimasi' },
                { data: 'status', name: 'status' },
                { data: 'perbaikan_keterangan', name: 'perbaikan_keterangan' },
            ]
            // ,
            // columnDefs: [
            //     { width: 50, targets: 0 },
            //     { width: 250, targets: 1 },
            //     { width: 350, targets: 2 },
            //     { width: 100, targets: 3 },
            // ]
        });

        $('#data_perangkat tbody').on('click', '.cek', function (event) {
            event.preventDefault()
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var tableId = 'posts-' + row.data().perbaikan_id;
            // console.log($(this).data('url'))
            // console.log(tableId)
            if (row.child.isShown()) {
        //     // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
        //     // Open this row
            console.log(row.data())
            row.child(template(row.data())).show();
            initTable(tableId, $(this).data('url'));
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
        });
    });
    function initTable(tableId, data) {
        // console.log(tableId)
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: data,
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'merk', name: 'merk' },
                { data: 'type', name: 'type' },
                // { data: 'kondisi', name: 'kondisi' },
                { data: 'gedung', name: 'gedung' },
                { data: 'ruangan', name: 'ruangan' },
                { data: 'supplier', name: 'supplier' },
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
            <h5>Detail Permohonan Perbaikan</h5>
        </div><br>
    <table class="table">
        <table class="table details-table" id="posts-@{{perbaikan_id}}">
            <thead>
            <tr>
                <th>No</th>
                <th>Merk</th>
                <th>Type / Kategori</th>
                <th>Gedung</th>
                <th>Ruangan</th>
                <th>Supplier</th>
            </tr>
            </thead>
        </table>
    </table>
</script>
@endpush
