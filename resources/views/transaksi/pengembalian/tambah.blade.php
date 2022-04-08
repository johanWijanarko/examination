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
                        <h4 class="card-title">Input Pengembalian</h4>
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
                        <form method="post" action="{{ route('savekembali') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Data Pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_pengembalian" name="data_pengembalian" required>
                                        <option value="">Pilih Pengembalian</option>
                                        @foreach ($type as $item)
                                        <option value="{{ $item->data_type_id }}">{{ $item->nama_data_type}}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Objek Pengembalian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi Saat diterima</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="kds_detail" id="kds_detail" class="form-control" placeholder="" readonly>
                                    <input type="hidden" name="kds_detail_id" id="kds_detail_id" class="form-control" placeholder="" readonly>
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
                                    <input type="hidden" name="trs_detail_id" id="trs_detail_id" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jmlPjm" id="jmlPjm" class="form-control" placeholder="" readonly>
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
                                            <option value="{{ $kondisi->data_kondisi_id }}">{{ $kondisi->nama_data_kondisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah Pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah_kembali" id="jumlah_kembali" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan pengembalian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="ketkembali" id="ketkembali" class="form-control" placeholder="" >
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
            // console.log(response.id)
            $('#pegawai').empty();
                    $('#pegawai').append(new Option('- Pilih -', ''))
            $('#pegawai').trigger('change')
            
            response.forEach(item => {
                // $('#pegawai').append(new Option(item.pegawe_name, item.id_peg))
                $('#pegawai').append(new Option(item.pegawe_name, item.id_peg+':'+item.stok_id))
                // console.log(item.kondisi)
                $('#kds_detail').val(item.kondisi)
                $('#kds_detail_id').val(item.kondisi_id)
                
               
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
            // console.log(response)
            $('#jmlPjm').val(response.trs_detail_jumlah)
            $('#trs_detail_id').val(response.trs_detail_id)
           
        }
    })
})

var validate_stok = 0;
    $('#jumlah_kembali').on('input',function(){   
        var jumlah= $(this).val();
        var jmlPjm = $('#jmlPjm').val()
       
            if(parseInt(jumlah) > parseInt(jmlPjm)){
                swal("Error!", 'Jumlah Pengambalian tidak boleh melebihi jumlah peminjaman') 
                $('#jumlah_kembali').val('')
                validate_stok = 1;
                return false
            }
    });
</script>
@endpush
