@extends('layout.app',[
    
])
@section('content')
<style>
  .mandatory:after {
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
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <h4 class="card-title">Tambah Pegawai<Menu></Menu></h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('save_pegawai') }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">NIP</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nip" id="nip" class="form-control" value="{{old('nip')}}" maxlength="18" placeholder="" required>
                                    <label class="error_nip" style="display:none;"></label>
                                    <div id="cek_nip"></div>
                                    <div class="invalid-feedback">
                                        Masukkan NIP
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{old('nama')}}" placeholder="" >
                                    <div class="invalid-feedback">
                                        Masukkan Nama
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control jabatan" name="bagian" id="bagian" required>
                                        <option value="{{old('bagian')}}">Pilih Bagian</option>
                                        @foreach ($bagian as $bg)
                                            <option value="{{$bg->bagian_id}}">{{$bg->nama_bagian}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Bagian
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Sub Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control jabatan" name="subBagian" id="subBagian" required>
                                        <option value="{{old('subBagian')}}">Pilih Sub Bagian</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Bagian
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Alamat Rumah</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{old('alamat')}}" placeholder="" >
                                    <div class="invalid-feedback">
                                        Masukkan Alamat Rumah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">No. Hp</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" value="{{old('pegawai_telp')}}" name="pegawai_telp" id="pegawai_telp" class="form-control" placeholder="masukan Mobile" >
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Nomor HP
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Email</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" value="{{old('email_auditor')}}" name="email_auditor" id="email_auditor" class="form-control" placeholder="masukan Alamat Email" required>
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Email
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Unggah Foto</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="file" id="file" accept=".jpg,.jpeg,.png" class="form-control" placeholder="masukan photo" >
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Foto
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('pegawai/daftarpegawai') }}" class="btn btn-info">Kembali</a>
                                    <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<script>
// $("#tanggal_lahir").flatpickr({
//     maxDate: "today"
// })

$(function () {
    $("#tanggal_lahir").datepicker({
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        // autocomplete : off,
        // format: 'dd-mm-yy',
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
             
        }
    });
});

$('#nip').blur(function(){
    $.ajax({
        type: 'POST',
        url: '{{ url('pegawai/daftarpegawai/cek_nip') }}',
        data: $(this).serialize(),
        success: function (data){
            var jsp = JSON.parse(data);

            var html = '';
            if(jsp.status) { // jika status true
                // console.log('pertama : '+jsp.status);
                html = '<font color="red">Nip Sudah Digunakan</font>';
            } 
            $('#cek_nip').html(html);
        }
    });
});

 $('#bagian').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/perangkat_trans/getSubBagian') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                // console.log(response)
                $('#subBagian').empty();
				        $('#subBagian').append(new Option('- Pilih -', ''))
                $('#subBagian').trigger('change')
              
                response.forEach(item => {
                    $('#subBagian').append(new Option(item.nama, item.id))
                });
               
            }
        })
    });
</script>
@endpush
