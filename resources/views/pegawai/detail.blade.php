@extends('layout.app',[
    
])
@section('content')
<style>
    .required:after {
    content:" *";
    color: red;
  }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Detail</a>
                                <a class="nav-link" id="nav-pendidikan-tab" data-toggle="tab" href="#nav-pendidikan" role="tab" aria-controls="nav-pendidikan" aria-selected="false">Riwayat Pendidikan</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                               <h4 class="card-title">Detail Pegawai <Menu></Menu></h4>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">NIP</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="nip" id="nip" value="{{ $detailAuditors->pegawai_nip }}" class="form-control" maxlength="18" placeholder="masukan NIP" readonly>
                                    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Nama</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $detailAuditors->pegawai_name }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Alamat Rumah</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $detailAuditors->pegawai_alamat }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Bagian</label>
                                    </div>
                                    <div class="col-md-8">
                                            <input type="text" name="nama" id="nama" value="{{ $detailAuditors->pegawaiHasBagian->nama_bagian }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Sub Bagian</label>
                                    </div>
                                    <div class="col-md-8">
                                            <input type="text" name="nama" id="nama" value="{{ $detailAuditors->pegawaiHasSubBagian->sub_bagian_nama }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Telp</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="telp" id="telp" class="form-control" value="{{ $detailAuditors->pegawai_telp }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="email_auditor" id="email_auditor" class="form-control" value="{{ $detailAuditors->pegawai_email }}" readonly>
                                    </div>
                                </div>
                                    @if ($detailAuditors->pegawai_foto)
                                         <img src="{{ asset('storage/upload/'.$detailAuditors->pegawai_foto) }}" style="width: 200px; height: 200px;">
                                    {{-- <button class="btn btn-danger del_file" title="Delete File"><i class="fa fa-trash"></i></button> --}}
                                        <input type="hidden" class="form-control" name="old[]" value="{{ $detailAuditors->pegawai_id }}" >
                                    @endif
                                   

                                </div>
                            </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('pegawai/daftarpegawai') }}" class="btn btn-info">Kembali</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')

<!-- small modal1 -->
<div class="modal fade" id="smallModal1" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody1">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal pendiiakan add-->
<div class="modal fade" id="addpendidikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pendidikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('tbhPendidikan') }}" class="needs-validation-pegawai" id="addpendidikan" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                 <input type="hidden" name="auidtor_id_" id="auidtor_id_" value="{{ $detailAuditors->pegawai_id }}" class="form-control" >
                <div class="col-md-3">
                    <label class="col-form-label required">Tingkat Pendidikan</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control required" name="pendidikan" id="pendidikan" required>
                        <option value="">Choose...</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label required">Institusi</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Institusi" id="Institusi" class="form-control" placeholder="" required value="{{ old('Institusi') }}">
                    <div class="invalid-feedback">
                        Masukkan Institusi
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Kota</label>
                </div>
                <div class="col-md-8">
                     <input type="text" name="Kota" id="Kota" class="form-control" placeholder="" value="{{ old('Kota') }}">
                  
                    <div class="invalid-feedback">
                        Masukkan Kota
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Negara</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Negara" id="Negara" class="form-control" placeholder="" value="{{ old('Negara') }}">
                </div>
                <div class="invalid-feedback">
                    Masukkan Negara
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label required">Tahun</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Tahun" id="Tahun" class="form-control" placeholder="" value="{{ old('Tahun') }}" required>
                </div>
                <div class="invalid-feedback">
                    Masukkan Tahun
                </div>
            </div>
             <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label required">Jurusan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Jurusan" id="Jurusan" class="form-control" placeholder="" value="{{ old('Jurusan') }}" required>
                </div>
                <div class="invalid-feedback">
                    Masukkan Jurusan
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label required">Nilai/IPK</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="ipk" id="ipk" class="form-control" placeholder="" value="{{ old('ipk') }}" required>
                </div>
                <div class="invalid-feedback">
                    Masukkan ipk
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal pendiiakan edit-->
<div class="modal fade" id="editpendidikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pendidikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('pendidikan/update') }}" class="needs-validation-pegawai" id="adddata" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-md-3">
                    <input type="hidden" name="pegawai_id_" id="pegawai_id_">
                     <input type="hidden" name="pend_id" id="pend_id">
                    <label class="col-form-label">Tingkat Pendidikan</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="pendidikan_edit" id="pendidikan_edit" >
                        <option value="">Choose...</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Institusi</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Instiusi_edit" id="Instiusi_edit" class="form-control" placeholder="" >
                  
                    <div class="invalid-feedback">
                        Masukkan Instiusi
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Kota</label>
                </div>
                <div class="col-md-8">
                     <input type="text" name="Kota_edit" id="Kota_edit" class="form-control" placeholder="" >
                  
                    <div class="invalid-feedback">
                        Masukkan Kota
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Negara</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Negara_edit" id="Negara_edit" class="form-control" placeholder="" >
                </div>
                <div class="invalid-feedback">
                    Masukkan Negara
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Tahun</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Tahun_edit" id="Tahun_edit" class="form-control" placeholder="" >
                </div>
                <div class="invalid-feedback">
                    Masukkan Tahun
                </div>
            </div>
             <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Jurusan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="Jurusan_edit" id="Jurusan_edit" class="form-control" placeholder="" >
                </div>
                <div class="invalid-feedback">
                    Masukkan Jurusan
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="col-form-label">Nilai/IPK</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="ipk_edit" id="ipk_edit" class="form-control" placeholder="" >
                </div>
                <div class="invalid-feedback">
                    Masukkan ipk
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- small modal1 -->
<div class="modal fade" id="smallModal2" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody2">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>

function tambahPelatihan(){
    $('#addpelatihan').modal('show');
    $('#adddata')[0].reset();
}
$("#mulai").flatpickr({
    maxDate: "today"
})
$("#akhir").flatpickr({
    maxDate: "today"
})
$('#mulai_edit').flatpickr({
    maxDate: "today"
})
$('#akhir_edit').flatpickr({
    maxDate: "today"
})
function editPel(id){
    $.ajax({
        url: '{{ url('pelatihan/detail') }}',
        method: 'get',
        data: {id:id},
        dataType : 'json',
        success: function (response) {
        // console.log(response.jabatan_pic.jabatan_pic_name)
        $('#edit_pel').modal('show');
        $("#pelatihan_id_edit").find("option[value="+response.jenis_pelatihan.kompetensi_id+"]").attr("selected", "selected");
        $('[name="pelatihan_edit"]').val(response.pelatihan_nama);
        $('[name="jam_edit"]').val(response.pelatihan_durasi);
        $('[name="mulai_edit"]').val(response.pelatihan_tanggal_awal);
        $('[name="akhir_edit"]').val(response.pelatihan_tanggal_akhir);
        $('[name="penyelenggara_edit"]').val(response.pelatihan_penyelenggara);
        $('[name="file_edit"]').val(response.pelatihan_sertifikat.substring(14));
        $('[name="pelatihan_id"]').val(response.pelatihan_id);
        
            
        }
    })
} 

function updatepel(){
    var formData =new FormData($('#updatedata')[0]);
    // console.log(formData);
    $.ajax({
        type: "POST",
        url:  '{{ url('pelatihan/update') }}',
        processData: false,
        contentType: false,
        dataType: "JSON",
        data: formData,
            success: function (data) {
                $('#edit_pel').modal('hide');
            location.reload(true); 
            }
    });
} 

   // display a modal (small modal)
$(document).on('click', '#smallButton1', function(event) {
    event.preventDefault();
    let href = $(this).attr('data-attr');
    $.ajax({
        url: href
        , beforeSend: function() {
            $('#loader').show();
        },
        // return the result
        success: function(result) {
            $('#smallModal1').modal("show");
            $('#smallBody1').html(result).show();
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

function tambahPend(){
    $('#addpendidikan').modal('show');
    $('#addpendidikan')[0].reset();
}

function editPend(id){
    $.ajax({
        url: '{{ url('pendidikan/edit') }}',
        method: 'get',
        data: {id:id},
        dataType : 'json',
        success: function (response) {
        // // console.log(response.jabatan_pic.jabatan_pic_name)
            $("#pendidikan_edit").find("option[value="+response.pendidikan_tingkat+"]").attr("selected", "selected");
            $('#editpendidikan').modal('show');
            $('[name="Instiusi_edit"]').val(response.pendidikan_institusi);
            $('[name="Kota_edit"]').val(response.pendidikan_kota);
            $('[name="Negara_edit"]').val(response.pendidikan_negara);
            $('[name="Tahun_edit"]').val(response.pendidikan_tahun);
            $('[name="Jurusan_edit"]').val(response.pendidikan_jurusan);
            $('[name="ipk_edit"]').val(response.pendidikan_nilai);
            $('[name="pegawai_id_"]').val(response.pendidikan_pegawai_id);
             $('[name="pend_id"]').val(response.pendidikan_id);
            

        }
    })
} 

   // display a modal (small modal)
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
@endpush
