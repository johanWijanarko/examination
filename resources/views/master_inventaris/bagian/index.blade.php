@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <h5>Daftar Bagian</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " > 
            <a class="btn btn-outline-success btn-outline-oke" onclick="tambah()">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="bagian">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Bagian</th>
                        <th>Nama Bagian</th>
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

<!-- Modal  tambah-->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Bagian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Harap Cek Kembali Inputan<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('bagianSave') }}" method="POST" id="tbhbagian">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Bagian</label>
                        <input type="text" name="kode_bagian" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter kode" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama Bagian</label>
                        <input type="text" name="bagian" class="form-control" id="exampleInputPassword1" placeholder="Nama Bagian">
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
    </div>
  </div>
</div>

{{-- edit --}}
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Bagian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="#" method="POST" id="update_bagian">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Bagian</label>
                        <input type="text" name="kode_b" id="kode_b" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter kode">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama Bagian</label>
                        <input type="text" name="nama_b" id="nama_b" class="form-control" id="exampleInputPassword1" placeholder="Keterangan">
                         <input type="hidden" name="id_kd" id="id_kd" class="form-control" id="exampleInputPassword1" placeholder="Keterangan">
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="update()" >Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    function tambah() {
        // alert('cek')
        document.getElementById("tbhbagian").reset();
        $('#tambahModal').modal("show");
    }

    function edit(id) {
        $.ajax({
            type: "GET",
            url:  '{{ url('m_inventaris/bagianEdit/') }}'+id,
            dataType: "JSON",
            data: id,
                success: function (data) {
                    // console.log(data)
                    $('#update_modal').modal("show");

                    $('[name="kode_b"]').val(data.kode_bagian);
                    $('[name="nama_b"]').val(data.nama_bagian);
                    $('[name="id_kd"]').val(data.bagian_id);
                }
        });
    }

    function update(){
         var formData = $('#update_bagian').serialize();
            $.ajax({
                type: "POST",
                url:  '{{ url('m_inventaris/bagianUpdate') }}',
                dataType: "JSON",
                data: formData,
                    beforeSend: function(){
                        $("#overlay").show();
                    },
                success: function (data) {
                    $('#update_modal').modal("hide");
                    if (data.success === true) {
                        swal("Done!", data.message, "success");
                        $("#overlay").hide();
                           
                    } else {
                        swal("Error!", data.message, "error");
                           
                    }
                },
                complete:function(data){
                    $("#overlay").hide();
                    var oTable = $('#bagian').dataTable();
                        oTable.fnDraw(false);
                }
            });
    }
    
    $(function() {
        $('#bagian').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ url('m_inventaris/getDataBagian') }}',
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'kode_bagian', name: 'kode_bagian' },
                { data: 'nama_bagian', name: 'nama_bagian' },
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
