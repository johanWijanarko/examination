@extends('layout.app',[

])
@section('content')
<style>
    td.detail-control{

        cursor:pointer;
        width:18px;
    }
    .cek {
           background-color:#6777ef;
           height:100px;
         }
</style>
<div class="card">
    <div class="card-body">
        <div>
            <h5>Transaksi Alat Kantor</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " >
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('add_trs_alat_kantor') }}">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Alat Kantor</th>
                        <th>Nama Pegawai</th>
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

<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="contohModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header cek">
          <h5 class="modal-title" id="contohModalScrollableTitle" style="color: azure">Detail Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body" id="smallBody">
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">

$(function() {
        var table =$('#data_perangkat').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ url('transaksi_data/p_kantor_trans/getTrsAtk') }}',
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
            { data: 'trs_kode', name: 'trs_kode' },
            { data: 'perangkat', name: 'perangkat' },
            { data: 'pegawai', name: 'pegawai' },
            { data: 'status', name: 'status' },
            { data: 'keterangan', name: 'keterangan' },
        ]
    });

});


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

@endpush
