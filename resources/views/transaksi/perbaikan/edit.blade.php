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
                        <h4 class="card-title">Input Permohonan Perbaikan</h4>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('updatePerbaikan', $dataPerbaikan) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <br>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Data Perbaikan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_perbaikan" name="data_perbaikan" required>
                                        <option value="">Pilih Data Perbaikan</option>
                                        <option value="1" {{($dataPerbaikan->perbaikan_data_id == '1' )? 'selected' : ''}}>Perangkat</option>
                                        <option value="2" {{($dataPerbaikan->perbaikan_data_id == '2' )? 'selected' : ''}}>Aplikasi</option>
                                        <option value="3" {{($dataPerbaikan->perbaikan_data_id == '3' )? 'selected' : ''}}>Alat Kantor</option>
                                        <option value="4" {{($dataPerbaikan->perbaikan_data_id == '3' )? 'selected' : ''}}>Inventaris Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Perbaikan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Perbaikan</option>
                                        @foreach ($opjekPerbaikan as $obj)
                                            <option {{ ($dataPerbaikan->perbaikan_objek_id == $obj->data_manajemen_id ) ? 'selected' : ''}}  value="{{$obj->data_manajemen_id}}" >{{$obj->data_manajemen_name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Pegawai </label>
                                </div>
                                <div class="col-md-8">
                                   <select class="form-control" id="pegawai" name="pegawai" required>
                                        <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                                        @foreach ($dataPegawai as $pgw)
                                            <option {{ ($dataPerbaikan->perbaikan_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="bagian_detail" value="{{ $dataPerbaikan->perbaikanHasPegawai->pegawaiHasBagian->nama_bagian }}" id="bagian_detail" class="form-control" placeholder="" readonly>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Sub Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="sub_bagian_detail" id="sub_bagian_detail" value="{{ $dataPerbaikan->perbaikanHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}" class="form-control" placeholder="" readonly>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Gedung</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="gedung_detail" id="gedung_detail" value="{{ $dataPerbaikan->perbaikanHasTrs->trsHasGedung->nama_data_gedung }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Ruangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ruangan_detail" id="ruangan_detail" value="{{ $dataPerbaikan->perbaikanHasTrs->trsHasRuangan->nama_data_ruangan }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="kds_detail" id="kds_detail" value="{{ $dataPerbaikan->perbaikanHasObjek->manajemenHasKondisi->nama_data_kondisi }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Tanggal Perbaikan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tglPerbikan" id="tglPerbikan" value="{{ $dataPerbaikan->perbaikan_tgl_in }}" class="form-control" placeholder="dd/mm/yy" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Estimasi Selesai</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="estimasi" id="estimasi" value="{{ $dataPerbaikan->perbaikan_estimasi }}" class="form-control" placeholder="dd/mm/yy" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan Perbaikan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ketPerbaikan" id="ketPerbaikan" value="{{ $dataPerbaikan->perbaikan_keterangan }}" class="form-control ketPerbaikan" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Status Perbaikan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Pilih Data Perbaikan</option>
                                        <option value="1" {{($dataPerbaikan->perbaikan_status == '1' )? 'selected' : ''}}>Sedang diperbaiki</option>
                                        <option value="2" {{($dataPerbaikan->perbaikan_status == '2' )? 'selected' : ''}}>Selesai diperbaiki</option>
                                        <option value="3" {{($dataPerbaikan->perbaikan_status == '3' )? 'selected' : ''}}>Tidak dapat diperbaiki</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/perbaikan') }}" class="btn btn-info">Kembali</a>
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
    $('#data_perbaikan, #pegawai,  #obj').select2();
});

$('#data_perbaikan').on('change', function () {
    //  console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/perbaikan/getObejkPerbaikan') }}',
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
    //  console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/perbaikan/getPegawiPerbaikan') }}',
        method: 'get',
        data: {id: $(this).val()},
        dataType : 'json',
        success: function (response) {
            // console.log(response)
            $('#pegawai').empty();
                    $('#pegawai').append(new Option('- Pilih -', ''))
            $('#pegawai').trigger('change')
            
            response.forEach(item => {
                $('#pegawai').append(new Option(item.pegawe_name, item.id_peg+':'+item.id))
            });
        }
    })
});

$('#pegawai').on('change', function () {
    // console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/perbaikan/getRekapPerbaikan') }}',
        method: 'get',
        data: {id: $(this).val()},
        dataType : 'json',
        success: function (response) {
            console.log(response)
            $('#bagian_detail').val(response.trs_has_bagian.nama_bagian);
            $('#sub_bagian_detail').val(response.trs_has_sub_bagian.sub_bagian_nama);
            $('#gedung_detail').val(response.trs_has_gedung.nama_data_gedung);
            $('#ruangan_detail').val(response.trs_has_ruangan.nama_data_ruangan);
            $('#kds_detail').val(response.trs_has_data.manajemen_has_kondisi.nama_data_kondisi);
            
            //   insert to  pivot table

            $('#bagian_detail_id').val(response.trs_has_bagian.bagian_id);
            $('#sub_bagian_detail_id').val(response.trs_has_sub_bagian.sub_bagian_id);
            $('#gedung_detail_id').val(response.trs_has_gedung.data_gedung_id);
            $('#ruangan_detail_id').val(response.trs_has_ruangan.data_ruangan_id);
            $('#kds_detail_id').val(response.trs_has_data.manajemen_has_kondisi.data_kondisi_id);
        }
    })
});

 
    

    $('#kePegawai').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/perangkat_trans/getPegawai') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                console.log(response)
                $('#bagian_').val(response.pegawai_has_bagian.bagian_id)
                $('#subBagian_').val(response.pegawai_has_sub_bagian.sub_bagian_id)

                $('#bagian').val(response.pegawai_has_bagian.nama_bagian)
                $('#subBagian').val(response.pegawai_has_sub_bagian.sub_bagian_nama)
                
               
            }
        })
    });
</script>
@endpush
