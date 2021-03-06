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
                        <h4 class="card-title">Tambah Stok<Menu></Menu></h4>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="post" action="{{ route('save_stok') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama Data</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="data_name" id="data_name" class="form-control" value="{{old('data_name')}}" placeholder="" required>
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
                                            <option value="{{ $type->data_type_id }}">{{ $type->nama_data_type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Type
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Merk / Jenis</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="merk" name="merk">
                                        <option value="{{old('merk')}}">Pilih Merk / Jenis</option>
                                        @foreach ($parMerks as $merk)
                                            <option value="{{ $merk->data_merk_id }}">{{ $merk->nama_data_merk }}</option>
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
                                            <option value="{{ $kondisi->data_kondisi_id }}">{{ $kondisi->nama_data_kondisi }}</option>
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
                                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
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
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{old('jumlah')}}" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Keterangan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{old('keterangan')}}" placeholder="" >
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
    // function save(){

    //     var formData = $('#save_data').serialize();
    //      $('#save_data').validate();
    //     if ($('#save_data').valid()) // check if form is valid
    //     {
    //         alert('cek')
    //     }
    //     else 
    //     {
    //         // just show validation errors, dont post
    //     }
       
    // }

    
    
</script>
@endpush
