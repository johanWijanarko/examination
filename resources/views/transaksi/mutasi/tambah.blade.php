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
                        <h4 class="card-title">Input Mutasi</h4>
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
                        <form method="post" action="{{ route('saveMutasi') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan Mutasi</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ketMutasi" id="ketMutasi" class="form-control" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Data Mutasi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_mutasi" name="data_mutasi" required>
                                        <option value="">Pilih Data Mutasi</option>
                                        <option value="1">Perangkat</option>
                                        <option value="2">Aplikasi</option>
                                        <option value="3">Alat Kantor</option>
                                        <option value="4">Inventaris Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Mutasi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Mutasi</option>
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
                                    </select>
                                </div>
                            </div>
                            <p>
                                <a class="btn btn-primary" title="Detail" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i><span>
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body" style="background-color: #F4F7FA">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Bagian</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="bagian_detail" id="bagian_detail" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="bagian_detail_id" id="bagian_detail_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Sub Bagian</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="sub_bagian_detail" id="sub_bagian_detail" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="sub_bagian_detail_id" id="sub_bagian_detail_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Gedung</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="gedung_detail" id="gedung_detail" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="gedung_detail_id" id="gedung_detail_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Ruangan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="ruangan_detail" id="ruangan_detail" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="ruangan_detail_id" id="ruangan_detail_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Kondisi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kds_detail" id="kds_detail" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="kds_detail_id" id="kds_detail_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Ke Pegawai</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kePegawai" name="kePegawai" required>
                                        <option value="{{old('kePegawai')}}">Pilih Pegawai</option>
                                        @foreach ($dataPegawai as $pegawai)
                                            <option value="{{ $pegawai->pegawai_id }}">{{ $pegawai->pegawai_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="bagian_" id="bagian_" readonly>
                                    <input type="text" class="form-control" name="bagian" id="bagian" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Sub Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="subBagian_" id="subBagian_" readonly>
                                    <input type="text" class="form-control" name="subBagian" id="subBagian" readonly>
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
                                            <option value="{{ $gdg->data_gedung_id }}">{{ $gdg->nama_data_gedung }}</option>
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
                                            <option value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
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
                                            <option value="{{ $kondisi->data_kondisi_id }}">{{ $kondisi->nama_data_kondisi }}</option>
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
    $('#data_mutasi, #pegawai, #kePegawai, #gedung, #ruangan, #kondisi, #obj').select2();
});

$('#data_mutasi').on('change', function () {
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
        url: '{{ url('transaksi_data/mutasi/getRekapMutasi') }}',
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
