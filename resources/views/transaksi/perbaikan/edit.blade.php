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
                        <h4 class="card-title">Edit Permohonan Perbaikan</h4>
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
                                        <option value="">Pilih Type</option>
                                        @foreach ($type as $item)
                                            <option {{ ($dataPerbaikan->perbaikan_data_id == $item->data_type_id ) ? 'selected' : ''}}   value="{{ $item->data_type_id }}">{{ $item->nama_data_type}}</option>
                                        @endforeach
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
                                            <option {{ ($dataPerbaikan->perbaikan_objek_id == $obj->data_stok_id ) ? 'selected' : ''}}  value="{{$obj->data_stok_id}}" >{{$obj->data_name}}
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
                                        <option value="3" {{($dataPerbaikan->perbaikan_status == '3' )? 'selected' : ''}}>Sedang diperbaiki</option>
                                        <option value="6" {{($dataPerbaikan->perbaikan_status == '6' )? 'selected' : ''}}>Selesai diperbaiki</option>
                                        <option value="7" {{($dataPerbaikan->perbaikan_status == '7' )? 'selected' : ''}}>Tidak dapat diperbaiki</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="trs_detail_id" value="{{ $dataPerbaikan->perbaikan_trs_id }}">
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
    $('#data_perbaikan, #pegawai,  #obj').prop("disabled", true)

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
            console.log(response)
            $('#pegawai').empty();
                    $('#pegawai').append(new Option('- Pilih -', ''))
            $('#pegawai').trigger('change')

            response.forEach(item => {
                $('#pegawai').append(new Option(item.pegawe_name, item.id_peg+':'+item.id))
            });
        }
    })
});

</script>
@endpush
