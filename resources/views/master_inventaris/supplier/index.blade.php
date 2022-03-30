@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <h5>Daftar Data Supplier</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " > 
            <a class="btn btn-outline-success btn-outline-oke" onclick="tambah()">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="supplier_data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
            <form action="" method="POST" id="tbhsupp">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode</label>
                            <input type="text" name="kode_sup" class="form-control" required>
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Nama Supplier</label>
                            <input type="text" name="nama_sup" class="form-control">
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" name="alamat_sup" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Provinsi</label>
                            <select class="custom-select" id="prov" name="prov" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsis as $provinsi)
                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}
                                    </option>
							    @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Kabupaten</label>
                            <select class="custom-select" id="kabupaten" name="kabupaten" required>
                            </select>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
            <form action="" method="POST" id="editsupp">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode</label>
                            <input type="text" name="kode_sup_e" class="form-control" required>
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Nama Supplier</label>
                            <input type="text" name="nama_sup_e" class="form-control">
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" name="alamat_sup_e" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Provinsi</label>
                            <select class="custom-select" id="prov_e" name="prov_e" required>
                              
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Kabupaten</label>
                            <select class="custom-select" id="kabupaten_e" name="kabupaten_e" required>
                            </select>
                            <input type="hidden" name="id_kd" id="id_kd">
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
    function tambah() {
        // document.getElementById("tbhsupp").reset();
        $("#prov option[selected]").removeAttr("selected"); 
        $('#tbhsupp').trigger("reset");
            $('#prov').select2({
                allowClear: true,
                appendTo: "#tambahModal",
                placeholder: '- Pilih -',
                dropdownParent: $("#tambahModal")
            });

            $('#kabupaten').select2({
                allowClear: true,
                appendTo: "#tambahModal",
                placeholder: '- Pilih -',
                dropdownParent: $("#tambahModal")
            });
        $('#tambahModal').modal("show");
    }
    
    $('#prov').on('change', function () {
        $.ajax({
            url: '{{ url('m_inventaris/get_kabupaten_sup') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                // console.log(response)
                $('#kabupaten').empty();
                        $('#kabupaten').append(new Option('- Pilih -', ''))
                $('#kabupaten').trigger('change')
            
                $.each(response, function (id, name) {
                    $('#kabupaten').append(new Option(name, id))
                    // console.log( $('#kabupaten').append(new Option(name, id)))
                })
            }
        })
    });


    function save(){
        var formData = $('#tbhsupp').serialize();
        $.ajax({
            type: "POST",
            url:  '{{ url('m_inventaris/data_save_supplier') }}',
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
                var oTable = $('#supplier_data').dataTable();
                    oTable.fnDraw(false);
            }
        });
    }

    function edit(id){
         $.ajax({
            type: "GET",
            url:  '{{ url('m_inventaris/data_supplier_edit/') }}'+id,
            dataType: "JSON",
            data: id,
                success: function (data) {
                    // console.log(data)
                    $('#prov_e').select2({
                        allowClear: true,
                        appendTo: "#editModal",
                        placeholder: '- Pilih -',
                        dropdownParent: $("#editModal")
                    });

                    $('#kabupaten_e').select2({
                        allowClear: true,
                        appendTo: "#editModal",
                        placeholder: '- Pilih -',
                        dropdownParent: $("#editModal")
                    });

                    $('#editModal').modal("show");

                    $('[name="kode_sup_e"]').val(data.supplier_kode);
                    $('[name="nama_sup_e"]').val(data.supplier_name);
                    $('[name="alamat_sup_e"]').val(data.supplier_alamat);
                    $('[name="id_kd"]').val(data.supplier_id);

                    var prov_id = data.supplier_provinsi_id;
                    getProvinsi(prov_id);

                    var kab_id = data.supplier_kabupaten_id;
                    getKabupaten(kab_id)
                }
        });
    }

    function getProvinsi(prov_id){
        $.ajax({
            url:  '{{ url('m_inventaris/get_prov_sup/') }}'+prov_id,
            method:"GET",
            success:function(data){
                $('#prov_e').html(data);
            }
        });
        return false;
    }

    function getKabupaten(kab_id){
        $.ajax({
            url:  '{{ url('m_inventaris/get_kab_sup/') }}'+kab_id,
            method:"GET",
            success:function(data){
                // console.log(data);
                // nama_bagian
               $('#kabupaten_e').html(data);
            }
        });
        return false;
    }

     $('#prov_e').on('change', function () {
        $.ajax({
            url: '{{ url('m_inventaris/get_kabupaten_sup') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                // console.log(response)
                $('#kabupaten_e').empty();
                        $('#kabupaten_e').append(new Option('- Pilih -', ''))
                $('#kabupaten_e').trigger('change')
            
                $.each(response, function (id, name) {
                    $('#kabupaten_e').append(new Option(name, id))
                })
            }
        })
    });
    function update(){
        var formData = $('#editsupp').serialize();
        $.ajax({
            type: "POST",
            url:  '{{ url('m_inventaris/data_supplier_update') }}',
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
                    $('#editModal').modal("hide");
                        
                } else {
                    swal("Error!", data.message, "error");
                        
                }
            },
            complete:function(data){
                $("#overlay").hide();
                var oTable = $('#supplier_data').dataTable();
                    oTable.fnDraw(false);
            }
        });
    }
    $(function() {
        $('#supplier_data').DataTable({
            processing: true,
            serverSide: true,
             responsive: true,
            ajax: '{{ url('m_inventaris/get_data_supplier') }}',
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'supplier_kode', name: 'supplier_kode' },
                { data: 'supplier_name', name: 'supplier_name' },
                { data: 'supplier_alamat', name: 'supplier_alamat' },
                { data: 'provinsi', name: 'provinsi' },
                { data: 'kabupaten', name: 'kabupaten' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            columnDefs: [
                { width: 50, targets: 0 },
                { width: 200, targets: 1 },
                { width: 200, targets: 2 },
                { width: 200, targets: 3 },
                { width: 200, targets: 4 },
                { width: 200, targets: 5 },
                { width: 130, targets: 6 },
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
