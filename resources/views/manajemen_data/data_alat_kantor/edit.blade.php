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
                        <h4 class="card-title">Edit Peralatan Kantor</h4>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="post" action="{{ url('m_data/alat_kantor/update', $getData->data_manajemen_id) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Nama Peralatan Kantor</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_atk" id="nama_atk" class="form-control" value="{{ $getData->data_manajemen_name }}" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Masukkan Nama Peralatan Kantor
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
                                            <option {{ ($getData->data_manajemen_merk_id == $merk->data_merk_id ) ? 'selected' : ''}}  value="{{$merk->data_merk_id}}" >{{$merk->nama_data_merk}}</option> 
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Merk
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
                                            <option {{ ($getData->data_manajemen_type_id == $type->data_type_id ) ? 'selected' : ''}}  value="{{$type->data_type_id}}" >{{$type->nama_data_type}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Type
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
                                            <option {{ ($getData->data_manajemen_kondisi_id == $kondisi->data_kondisi_id ) ? 'selected' : ''}}  value="{{$kondisi->data_kondisi_id}}" >{{$kondisi->nama_data_kondisi}}</option>
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
                                            <option {{ ($getData->data_manajemen_supplier_id == $supplier->supplier_id ) ? 'selected' : ''}}  value="{{$supplier->supplier_id}}" >{{ $supplier->supplier_name }}</option>
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
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $getData->data_manajemen_jumlah }}" placeholder="" required>
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
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $getData->data_manajemen_keterangan  }}" placeholder="" >
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('m_data/alat_kantor') }}" class="btn btn-info">Kembali</a>
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
