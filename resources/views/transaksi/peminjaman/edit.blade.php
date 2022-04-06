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
                        <h4 class="card-title">Edit Peminjaman</h4>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('updatepinjam', $getDataPinjaman->peminjaman_id) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kode Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="kode_pinjam" id="kode_pinjam" class="form-control" value="{{ $getDataPinjaman->peminjaman_kode }}" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Type / Kategori Pinjam</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_peminjaman" name="data_peminjaman" required>
                                        <option value="">Pilih Type</option>
                                        @foreach ($type as $item)
                                            <option {{ ($getDataPinjaman->peminjamanType == $item->data_type_id ) ? 'selected' : ''}}   value="{{ $item->data_type_id }}">{{ $item->nama_data_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Pinjam</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Pinjam</option>
                                            @foreach ($getObejkPeminjam as $obj)
                                                <option {{ ($getDataPinjaman->peminjaman_obejk_id == $obj->data_stok_id ) ? 'selected' : ''}}   value="{{ $obj->data_stok_id }}">{{ $obj->data_name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah" id="jumlah" value="{{ $getDataPinjaman->peminjamanHasObjek->data_jumlah }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah_pinjam" id="jumlah_pinjam" value="{{ $getDataPinjaman->peminjaman_jumlah }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                           
                            
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama Pegawai</label>
                                </div>
                                <div class="col-md-8">
                                   <select class="form-control" id="pegawai" name="pegawai" required>
                                        <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                                        @foreach ($dataPegawai as $pgw)
                                            <option {{ ($getDataPinjaman->peminjaman_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Gedung</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="gedung" name="gedung" required>
                                        <option value="{{old('gedung')}}">Pilih Gedung</option>
                                        @foreach ($gedung as $gdg)
                                            <option {{ ($getDataPinjaman->peminjaman_gedung_id == $gdg->data_gedung_id ) ? 'selected' : ''}}  value="{{$gdg->data_gedung_id}}" >{{$gdg->nama_data_gedung}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Ruangan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="ruangan" name="ruangan" required>
                                        <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                                        @foreach ($ruangan as $ru)
                                            <option {{ ($getDataPinjaman->peminjaman_ruangan_id == $ru->data_ruangan_id ) ? 'selected' : ''}}  value="{{$ru->data_ruangan_id}}" >{{$ru->nama_data_ruangan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Tanggal Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tglPinjam" id="tglPinjam" class="form-control" value="{{ $getDataPinjaman->peminjaman_tanggal }}" placeholder="dd/mm/yy" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="keterangan" value="{{ $getDataPinjaman->peminjaman_keterangan }}" id="keterangan" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <input type="hidden" name="trs_detail_id" value="{{ $getDataPinjaman->pinjamHasTrsDetail->trs_detail_id}}">
                            <input type="hidden" name="trs_id" value="{{ $getDataPinjaman->pinjamHasTrsDetail->trs_id}}">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/peminjaman') }}" class="btn btn-info">Kembali</a>
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
$(document).ready(function() {
    $("#data_peminjaman,#obj").prop("disabled", true);
    $('#pegawai').select2();
});

$('#data_peminjaman').on('change', function () {
    //  console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/peminjaman/getObejkPeminjam') }}',
        method: 'get',
        data: {id: $(this).val()},
        dataType : 'json',
        success: function (response) {
            // console.log(response)
            $('#obj').empty();
                    $('#obj').append(new Option('- Pilih -', ''))
            $('#obj').trigger('change')
            
            $.each(response, function (id, name) {
            // console.log(name)
                $('#obj').append(new Option(name, id))
                // console.log( $('#obj').append(new Option(name, id)))
            })
        }
    })
});

    $('#obj').on('change', function () {
         console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/peminjaman/getPinjam') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                $('#jumlah').val(response.data_jumlah)
                var jumlahstok = $('#jumlah').val(response.data_jumlah)
                //    console.log(jumlahstok)
            }
        })
    });
    var validate_stok = 0;
    $('#jumlah_pinjam').on('input',function(){   
        var jumlah= $(this).val();
        var stok = $('#jumlah').val()
       
            if(parseInt(jumlah) > parseInt(stok)){
                swal("Error!", 'Jumlah Pinjam tidak boleh melebihi jumlah stok') 
                $('#jumlah_pinjam').val('')
                validate_stok = 1;
                return false
            }
    });
    
</script>
@endpush
