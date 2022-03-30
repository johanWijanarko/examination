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
                        <h4 class="card-title">Edit Pengembalian</h4>
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
                        <form method="post" action="{{ route('update_kembali', $datakembali->pengembalian_id) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Data Pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_pengembalian" name="data_pengembalian" required>
                                        <option value="">Pilih Data Pengembalian</option>
                                        <option value="1" {{($datakembali->pengembalian_data_id == '1' )? 'selected' : ''}}>Perangkat</option>
                                        <option value="2" {{($datakembali->pengembalian_data_id == '2' )? 'selected' : ''}}>Aplikasi</option>
                                        <option value="3" {{($datakembali->pengembalian_data_id == '3' )? 'selected' : ''}}>Alat Kantor</option>
                                        <option value="4" {{($datakembali->pengembalian_data_id == '3' )? 'selected' : ''}}>Inventaris Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Mutasi</option>
                                        @foreach ($objekMutasi as $obj)
                                            <option {{ ($datakembali->pengembalian_obejk_id == $obj->data_manajemen_id ) ? 'selected' : ''}}  value="{{$obj->data_manajemen_id}}" >{{$obj->data_manajemen_name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Dari Pegawai </label>
                                </div>
                                <div class="col-md-8">
                                   <select class="form-control" id="pegawai" name="pegawai" required>
                                        <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                                        @foreach ($dataPegawai as $pgw)
                                            <option {{ ($datakembali->pengembalian_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
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
                                    <input type="text" name="bagian_detail" id="bagian_detail" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasBagian->nama_bagian }}" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="bagian_detail_id" id="bagian_detail_id" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasBagian->bagian_id }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Sub Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="sub_bagian_detail" id="sub_bagian_detail" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="sub_bagian_detail_id" id="sub_bagian_detail_id" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_id }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Gedung</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="gedung_detail" id="gedung_detail" value="{{ $datakembali->kembaliHasTrs->trsHasGedung->nama_data_gedung }}" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="gedung_detail_id" id="gedung_detail_id" value="{{ $datakembali->kembaliHasTrs->trsHasGedung->data_gedung_id }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Ruangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ruangan_detail" id="ruangan_detail" value="{{ $datakembali->kembaliHasTrs->trsHasRuangan->nama_data_ruangan }}" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="ruangan_detail_id" id="ruangan_detail_id" value="{{ $datakembali->kembaliHasTrs->trsHasRuangan->data_ruangan_id }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi Saat diterima</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="kds_detail" id="kds_detail" value="{{ $datakembali->kembaliHasKondisiSblm->nama_data_kondisi }}" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="kds_detail_id" id="kds_detail_id" value="{{ $datakembali->kembaliHasKondisiSblm->data_kondisi_id }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi Sekarang</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kondisi" name="kondisi" required>
                                        <option value="{{old('kondisi')}}">Pilih Kondisi</option>
                                        @foreach ($datakondisi as $kondisi)
                                            <option {{ ($datakembali->pengembalian_kondisi_sekarang_id == $kondisi->data_kondisi_id ) ? 'selected' : ''}} value="{{ $kondisi->data_kondisi_id }}">{{ $kondisi->nama_data_kondisi }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ketkembali" id="ketkembali" value="{{ $datakembali->pengembalian_keterangan }}" class="form-control" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/pengembalian') }}" class="btn btn-info">Kembali</a>
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
    $('#data_pengembalian, #pegawai, #kePegawai, #gedung, #ruangan, #kondisi, #obj').select2();
});

$('#data_pengembalian').on('change', function () {
    //  console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/pengembalian/getObejkKembali') }}',
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
        url: '{{ url('transaksi_data/pengembalian/getPegawiKembali') }}',
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
        url: '{{ url('transaksi_data/pengembalian/getRekapKembali') }}',
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


</script>
@endpush
