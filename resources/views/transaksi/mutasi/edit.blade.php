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
                        <h4 class="card-title">Edit Mutasi</h4>
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
                        <form method="post" action="{{ route('update_mutasi',['id' => $editMutasi->mutasi_id ]) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan Mutasi</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ketMutasi" id="ketMutasi" value="{{ $editMutasi->mutasi_keterangan }}" class="form-control" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Type / Kategori</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="typeMutasi" name="typeMutasi" required>
                                        <option value="">Pilih Type / Kategori</option>
                                        @foreach ($type as $tp)
                                            <option {{ ($editMutasi->mutasi_data_id == $tp->data_type_id ) ? 'selected' : ''}}  value="{{$tp->data_type_id}}" >{{$tp->nama_data_type}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="detail_mutasi" value="{{ $editMutasi->MutasiHasDetail->detail_id }}">
                                    <input type="hidden" name="detail_trs_id" value="{{$editMutasi->MutasiHasDetail->detail_mutasi_trs_id}}" id="">
                                    <input type="hidden" name="mutasi_id" value="{{$editMutasi->mutasi_id}}" id="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Mutasi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Mutasi</option>
                                        @foreach ($objekMutasi as $obj)
                                            <option {{ ($editMutasi->mutasi_objek_id == $obj->data_stok_id ) ? 'selected' : ''}}  value="{{$obj->data_stok_id}}" >{{$obj->data_name}}
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
                                            <option {{ ($editMutasi->MutasiHasDetail->detail_mutasi_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Ke Pegawai</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kePegawai" name="kePegawai" required>
                                        <option value="{{old('kePegawai')}}">Pilih Pegawai</option>
                                        @foreach ($dataPegawai as $pgw)
                                            <option {{ ($editMutasi->mutasi_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
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
                                            <option {{ ($editMutasi->mutasi_gedung_id == $gdg->data_gedung_id ) ? 'selected' : ''}}  value="{{$gdg->data_gedung_id}}" >{{$gdg->nama_data_gedung}}
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
                                            <option {{ ($editMutasi->mutasi_ruangan_id == $ru->data_ruangan_id ) ? 'selected' : ''}}  value="{{$ru->data_ruangan_id}}" >{{$ru->nama_data_ruangan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kondisi" name="kondisi" required>
                                        <option value="{{old('kondisi')}}">Pilih Kondisi</option>
                                        @foreach ($datakondisi as $kondisi)
                                            <option {{ ($editMutasi->mutasi_kondisi_id == $kondisi->data_kondisi_id ) ? 'selected' : ''}}  value="{{$kondisi->data_kondisi_id}}" >{{$kondisi->nama_data_kondisi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/mutasi') }}" class="btn btn-info">Kembali</a>
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
    $(' #pegawaian, #kePegawai, #gedung, #ruangan, #kondisi, #pegawai').select2();
    $('#typeMutasi,  #obj').prop("disabled", true)

});

$('#typeMutasi').on('change', function () {
    //  console.log($(this).val());
    $.ajax({
        url: '{{ url('transaksi_data/mutasi/getObejkMutasi') }}',
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
        url: '{{ url('transaksi_data/mutasi/getPegawiMutasi') }}',
        method: 'get',
        data: {id: $(this).val()},
        dataType : 'json',
        success: function (response) {
            $('#pegawai').empty();
            $('#pegawai').append(new Option('- Pilih -', ''))
            $('#pegawai').trigger('change')

            response.forEach(item => {
                console.log(item)
                $('#pegawai').append(new Option(item.pegawe_name, item.id_peg+':'+item.id));
            });
        }
    })
});
</script>
@endpush
