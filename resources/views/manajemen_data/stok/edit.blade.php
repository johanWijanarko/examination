@extends('layout.app',[
    
])
@section('content')
<style>
  .mandatory:after {
    content:" *";
    color: red;
  }
  .disable_section {
  pointer-events: none;
  /* opacity: 0.8; */
}
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <h4 class="card-title">Edit Stok</h4>
                       
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ route('update_stok', $getData->data_stok_id) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama Data</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="data_name" id="data_name" class="form-control" value="{{ $getData->data_name }}" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Masukkan Nama Perangkat
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Type / Kategori</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="{{old('type')}}">Pilih Type / Kategori</option>
                                        @foreach ($parType as $type)
                                            <option {{ ($getData->data_kategory_id == $type->data_type_id ) ? 'selected' : ''}}  value="{{$type->data_type_id}}" >{{$type->nama_data_type}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Type
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Merk / Jenis</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="merk" name="merk" required>
                                        <option value="{{old('merk')}}">Pilih Merk / Jenis</option>
                                        @foreach ($parMerks as $merk)
                                            <option {{ ($getData->data_merk_id == $merk->data_merk_id ) ? 'selected' : ''}}  value="{{$merk->data_merk_id}}" >{{$merk->nama_data_merk}}</option> 
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Merk / Jenis
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kondisi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="kondisi" name="kondisi" required>
                                        <option value="{{old('kondisi')}}">Pilih kondisi</option>
                                        @foreach ($parKondisi as $kondisi)
                                            <option {{ ($getData->data_kondisi_id == $kondisi->data_kondisi_id ) ? 'selected' : ''}}  value="{{$kondisi->data_kondisi_id}}" >{{$kondisi->nama_data_kondisi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Masukkan Kondisi
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Supplier</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="supplier" name="supplier" required>
                                        <option value="{{old('supplier')}}">Pilih Supplier</option>
                                        @foreach ($parSuppliers as $supplier)
                                            <option {{ ($getData->data_supplier_id == $supplier->supplier_id ) ? 'selected' : ''}}  value="{{$supplier->supplier_id}}" >{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="validation-errors"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Jumlah</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $getData->data_jumlah }}" placeholder="" >
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Klik update untuk tambah stok</label>
                                </div>
                                <div class="col-md-8">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{!! Form::label('stok_update','Update', [ 'class' => 'form-check-input position-static required']) !!}</strong>
                                     <input type="checkbox" name="is_user" id="is_user" onclick="enableCreateUser()" />
                                    
                                    <input type="number" name="up_jumlah" id="up_jumlah" class="form-control" placeholder="" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Keterangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $getData->data_keterangan }}" placeholder="" >
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('m_data/data_stok') }}" class="btn btn-info">Kembali</a>
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
$( document ).ready(function() {
    $('#up_jumlah').hide();
});
function enableCreateUser() {
  if (document.getElementById("is_user").checked) {
    $('#up_jumlah').show();
    $("#jumlah").prop("readonly", true);
  } else {
     $("#jumlah").prop("readonly", false);
     $("#up_jumlah").hide();
  }
}
</script>
@endpush
