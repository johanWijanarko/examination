@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <h5>Daftar Data Gedung</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " > 
            <a class="btn btn-outline-success btn-outline-oke" onclick="tambah()">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="gedung">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Gedung</th>
                        <th>Nama Gedung</th>
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

<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Gedung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
            <form action="" method="POST" id="tbhgedung">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Gedung</label>
                        <input type="text" name="kode_gedung" class="form-control" id="kode_gedung" aria-describedby="emailHelp" placeholder="Enter kode" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama Gedung</label>
                        <input type="text" name="name_gedung" class="form-control" id="name_gedung" placeholder="Nama Gedung" required>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                    </div>
            </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Gedung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
            <form action="" method="POST" id="editgedung">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Gedung</label>
                        <input type="text" name="kode_gedung_e" class="form-control" id="kode_gedung_e" aria-describedby="emailHelp" placeholder="Enter kode" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama Gedung</label>
                        <input type="text" name="name_gedung_e" class="form-control" id="name_gedung_e" placeholder="Nama Gedung" required>
                        <input type="hidden" name="id_kd">
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="update()">Save</button>
                    </div>
            </form>
    </div>
  </div>
</div>
<script>
    var save_method;
    function tambah() {
        // alert('cek')
        document.getElementById("tbhgedung").reset();
        save_method = 'add';
        $('#tambahModal').modal('show');
    }

    function save(){
        var formData = $('#tbhgedung').serialize();
        $.ajax({
            type: "POST",
            url:  '{{ url('m_inventaris/data_save_gedung') }}',
            dataType: "JSON",
            data: formData,
                beforeSend: function(){
                    $("#overlay").show();
                },
            success: function (data) {
                $('#tambahModal').modal("hide");
                if (data.success === true) {
                    swal("Done!", data.message, "success");
                    $("#overlay").hide();
                    $('#tambahModal').modal("hide");
                        
                } else {
                    swal("Error!", data.message, "error");
                        
                }
            },
            complete:function(data){
                $("#overlay").hide();
                var oTable = $('#gedung').dataTable();
                    oTable.fnDraw(false);
            }
        });
    }


     function edit(id) {
        $.ajax({
            type: "GET",
            url:  '{{ url('m_inventaris/data_gedung_edit/') }}'+id,
            dataType: "JSON",
            data: id,
                success: function (data) {
                    console.log(data)
                    $('#editModal').modal("show");

                    $('[name="kode_gedung_e"]').val(data.kode_data_gedung);
                    $('[name="name_gedung_e"]').val(data.nama_data_gedung);
                    $('[name="id_kd"]').val(data.data_gedung_id);
                }
        });
    }

    function update(){
        var formData = $('#editgedung').serialize();
        $.ajax({
            type: "POST",
            url:  '{{ url('m_inventaris/data_gedung_update') }}',
            dataType: "JSON",
            data: formData,
                beforeSend: function(){
                    $("#overlay").show();
                },
            success: function (data) {
                $('#editModal').modal("hide");
                if (data.success === true) {
                    swal("Done!", data.message, "success");
                    $("#overlay").hide();
                        
                } else {
                    swal("Error!", data.message, "error");
                        
                }
            },
            complete:function(data){
                $("#overlay").hide();
                var oTable = $('#gedung').dataTable();
                    oTable.fnDraw(false);
            }
        });
    }

    $(function() {
        $('#gedung').DataTable({
            processing: true,
            serverSide: true,
             responsive: true,
            ajax: '{{ url('m_inventaris/get_data_gedung') }}',
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'kode_data_gedung', name: 'kode_data_gedung' },
                { data: 'nama_data_gedung', name: 'nama_data_gedung' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            columnDefs: [
                { width: 50, targets: 0 },
                { width: 250, targets: 1 },
                { width: 350, targets: 2 },
                { width: 100, targets: 3 },
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
