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
                                    <label class="col-form-label mandatory">Data Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="data_peminjaman" name="data_peminjaman" required>
                                        <option value="">Pilih Data Peminjaman</option>
                                         <option value="1" {{($getDataPinjaman->peminjaman_data_id == '1' )? 'selected' : ''}}>Perangkat</option>
                                        <option value="2" {{($getDataPinjaman->peminjaman_data_id == '2' )? 'selected' : ''}}>Aplikasi</option>
                                        <option value="3" {{($getDataPinjaman->peminjaman_data_id == '3' )? 'selected' : ''}}>Alat Kantor</option>
                                        <option value="4" {{($getDataPinjaman->peminjaman_data_id == '3' )? 'selected' : ''}}>Inventaris Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Objek Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="obj" name="obj" required>
                                        <option value="{{old('obj')}}">Pilih Perangkat</option>
                                        @foreach ($getObejkPeminjam as $obj)
                                            <option {{ ($getDataPinjaman->peminjaman_obejk_id == $obj->data_manajemen_id ) ? 'selected' : ''}}  value="{{$obj->data_manajemen_id}}" >{{$obj->data_manajemen_name}}
                                            </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah" id="jumlah" value="{{ $getDataPinjaman->peminjamanHasObjek->data_manajemen_jumlah }}" class="form-control" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah Peminjaman</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jumlah_pinjam" id="jumlah_pinjam" value="{{ $getDataPinjaman->peminjaman_jumlah }}" class="form-control" placeholder="">
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
                                            <input type="text" name="merk" id="merk" class="form-control" value="{{ $getDataPinjaman->peminjamanHasObjek->manajemenHasMerk->nama_data_merk }}" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Type</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="type" id="type" value="{{ $getDataPinjaman->peminjamanHasObjek->manajemenHasType->nama_data_type }}"class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Kondisi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kondisi"  id="kondisi" class="form-control" value="{{ $getDataPinjaman->peminjamanHasObjek->manajemenHasKondisi->nama_data_kondisi }}" placeholder="" readonly>
                                            <input type="hidden" name="kondisi_id" id="kondisi_id" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label mandatory">Supplier</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ $getDataPinjaman->peminjamanHasObjek->manajemenHasSupplier->supplier_name }}" name="kondisi" id="sup" class="form-control" placeholder="" readonly>
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
                                        @foreach ($dataPegawai as $pgw)
                                            <option {{ ($getDataPinjaman->peminjaman_pegawai_id == $pgw->pegawai_id ) ? 'selected' : ''}}  value="{{$pgw->pegawai_id}}" >{{$pgw->pegawai_name}}
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
                                    <input type="hidden" class="form-control" name="bagian_" id="bagian_" readonly>
                                    <input type="text" class="form-control" name="bagian" id="bagian" value="{{ $getDataPinjaman->peminjamanHasPegawai->pegawaiHasBagian->nama_bagian }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Sub Bagian</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="subBagian_" id="subBagian_" readonly>
                                    <input type="text" class="form-control" name="subBagian" id="subBagian" value="{{ $getDataPinjaman->peminjamanHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}"  readonly>
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
                                    <label class="col-form-label mandatory">Kelompok</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kelompok" name="kelompok" required>
                                        <option value="{{old('kelompok')}}">Pilih Kelompok</option>
                                         @foreach ($kelompok as $kel)
                                            <option {{ ($getDataPinjaman->peminjaman_kelompok_id == $kel->data_kelompok_id ) ? 'selected' : ''}}  value="{{$kel->data_kelompok_id}}" >{{$kel->nama_data_kelompok}}</option>
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
    $('#data_peminjaman, #obj, ').select2();
    $('#pegawai').select2();
    $('#kelompok').select2();
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
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/peminjaman/getPinjam') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                // console.log(response.getMerk)
                $('[name="merk"]').val(response.getMerk.nama_data_merk);
                $('#type').val(response.typeKategory.nama_data_type);
                $('#kondisi').val(response.kondisi.nama_data_kondisi);
                $('#kondisi_id').val(response.kondisi.data_kondisi_id);
                $('#sup').val(response.supplier.supplier_name);
                $('#jumlah').val(response.getPinjam.data_manajemen_jumlah+' Unit');
            }
        })
    });

 $('#pegawai').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/peminjaman/getPegawai') }}',
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
