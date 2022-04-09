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
            <h5>Pengembalian</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " >
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('add_kembali') }}">Tambah</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat">
                <thead>
                    <tr>
                        <th>Action</th>
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


<div class="modal fade" id="smallModal2" tabindex="-1" role="dialog" aria-labelledby="contohModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header cek">
          <h5 class="modal-title" id="contohModalScrollableTitle" >Detail Pengembalian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body" id="smallBody2">
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        ajax: '{{ url('transaksi_data/pengembalian/getDataPengembalian') }}',
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
            { data: 'objek', name: 'objek' },
            { data: 'pegawai', name: 'pegawai' },
            { data: 'bagian', name: 'bagian' },
            { data: 'subbagian', name: 'subbagian' },
            { data: 'konseb', name: 'konseb' },
            { data: 'konsek', name: 'konsek' },
            { data: 'ket', name: 'ket' },
            ]
        });


    });

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
                $('#smallModal2').modal("show");
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

    $(document).on('click', '#smallButton2', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal2').modal("show");
                $('#smallBody2').html(result).show();
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
        <h5>Detail Pengembalian</h5>
    </div><br>
    <table class="table">
        <table class="table details-table" id="posts-@{{pengembalian_id}}">
            <thead>
            <tr>
                <th>No</th>
                <th>Merk</th>
                <th>Type</th>
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
