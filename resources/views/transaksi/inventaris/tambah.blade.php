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
                        <h4 class="card-title">Input Transaksi Inventaris<Menu></Menu></h4>
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
                        <form method="post" action="{{ route('save_trsInv') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Id Transaksi</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $getKodeTrs }}" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Inventaris</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="inv" name="inv" required>
                                        <option value="{{old('aplikasi')}}">Pilih Inventaris</option>
                                        @foreach ($dataInv as $inv)
                                            <option value="{{ $inv->data_manajemen_id }}">{{ $inv->data_manajemen_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah Perangkat</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="" readonly>
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
                                            <label class="col-form-label mandatory">Merk / Jenis</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="merk" id="merk" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Type</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="type" id="type" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Kondisi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kondisi" id="kondisi" class="form-control" placeholder="" readonly>
                                            <input type="hidden" name="kondisi_id" id="kondisi_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Supplier</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="supplier" id="supplier" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama Pegawai</label>
                                </div>
                                <div class="col-md-8">
                                   <select class="form-control" id="pegawai" name="pegawai" required>
                                        <option value="{{old('pegawai')}}">Pilih Pegawai</option>
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
                                    <label class="col-form-label mandatory">Kelompok</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kelompok" name="kelompok" required>
                                        <option value="{{old('kelompok')}}">Pilih Kelompok</option>
                                        @foreach ($kelompok as $kel)
                                            <option value="{{ $kel->data_kelompok_id }}">{{ $kel->nama_data_kelompok }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/invtentaris_trans') }}" class="btn btn-info">Kembali</a>
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
    $('#inv, #pegawai , #kelompok, #gedung, #ruangan' ).select2();
});

    $('#inv').on('change', function () {
    //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/invtentaris_trans/gatInv') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                console.log(response);
                $('[name="merk"]').val(response.getMerk.nama_data_merk);
                $('#type').val(response.typeKategory.nama_data_type);
                $('#kondisi').val(response.kondisi.nama_data_kondisi);
                $('#kondisi_id').val(response.kondisi.data_kondisi_id);
                $('#supplier').val(response.supplier.supplier_name);
                $('#jumlah').val(response.getInv.data_manajemen_jumlah+' Unit');
               
            }
        })
    });

    $('#bagian').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/p_kantor_trans/getSubBagian') }}',
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


    $('#pegawai').on('change', function () {
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
