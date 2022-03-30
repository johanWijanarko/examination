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
                    <h4 class="card-title">Edit form Pegawai</h4>
                    <form method="post" action="{{ route('updatepegawai', $detailAuditors->pegawai_id) }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label mandatory">NIP</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nip" id="nip" class="form-control" maxlength="18" placeholder="" value="{{ $detailAuditors->pegawai_nip }}" readonly>
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
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ $detailAuditors->pegawai_name }}" placeholder="" >
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
                                <select class="form-control" id="bagian" name="bagian" required>
                                    <option value="{{old('bagian')}}">Pilih Bagian</option>
                                    @foreach ($bagian as $bag)
                                        <option {{ ($detailAuditors->pegawai_bagian_id ==  $bag->bagian_id) ? 'selected' : '' }} value="{{ $bag->bagian_id }}">{{ $bag->nama_bagian }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label mandatory">Sub Bagian</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" id="subBagian" name="subBagian" required>
                                    <option value="{{old('subBagian')}}">Pilih Sub Bagian</option>
                                    @foreach ($subBagian as $sub)
                                        <option {{ ($detailAuditors->pegawai_sub_bagian_id == $sub->sub_bagian_id) ? 'selected' : '' }} value="{{ $sub->sub_bagian_id }}">{{ $sub->sub_bagian_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label">Alamat Rumah</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $detailAuditors->pegawai_alamat }}" placeholder="" >
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
                                <input type="text" value="{{ $detailAuditors->pegawai_telp }}" name="pegawai_telp" id="pegawai_telp" class="form-control" placeholder="masukan Mobile" >
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
                                <input type="text" value="{{ $detailAuditors->pegawai_email }}" name="email_auditor" id="email_auditor" class="form-control" placeholder="masukan Alamat Email" required>
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
                                <div>
                                    @if ($detailAuditors->pegawai_foto)
                                         <img src="{{ asset('storage/upload/'.$detailAuditors->pegawai_foto) }}" style="width: 200px; height: 200px;">
                                        <button class="btn btn-danger del_file" title="Delete File"><i class="fa fa-trash"></i></button>
                                        <input type="hidden" class="form-control" name="old[]" value="{{ $detailAuditors->pegawai_id }}" >

                                    @endif
                                </div>
                                <input type="file" name="file" id="file" class="form-control" placeholder="masukan photo" >
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

$(document).on('click', '.del_file', function(event) {
   $(this).parent().remove()
    
});

$(function () {
    $("#tanggal_lahir").datepicker({
        // numberOfMonths: 1,
        maxDate: "today",
        dateFormat: 'dd-mm-yy',
        
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
