@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <h5>Daftar Jabatan Auditee</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " >
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('tambahjabatanPic') }}">Tambah</a>
            <a class="btn btn-outline-info btn-outline-oke" href="{{ route('parauditee') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="jabatanPic">
                <thead>
                      <tr>
                        <th>No</th>
                        <th>Pic Jabatan</th>
                        <th>Action</th>
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
    <div class="modal-dialog modal-md" role="document">
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
<script>
$(function() {
    $('#jabatanPic').DataTable({
        processing: true,
        serverSide: true,
         responsive: true,
        ajax: '{{ url('parameter/auditee/getjabatanPic') }}',
        columns: [
          { "data": 'DT_RowIndex',orderable: false, searchable: false },
            { data: 'jabatan_pic_name', name: 'jabatan_pic_name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false}
        ],
        columnDefs: [
            { width: 50, targets: 0 },
             { width: 150, targets: 2 }
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
