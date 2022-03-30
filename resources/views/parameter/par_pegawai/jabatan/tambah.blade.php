@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                            <h5 class="card-title">Tambah Jabatan Pegawai SPI</h5>
                        {{-- </div> --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Harap Cek Kembali Inputan<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('savejabatan') }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Nama Jabatan Pegawai SPI</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control"  placeholder="masukan Nama Jabatan" required>
                                   
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Sort</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="sort" id="sort" class="form-control"  placeholder="masukan Sort" required>
                                   
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Posisi Penugasan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="posisi" name="posisi">
                                        <option>Pilih Posisi</option>
                                        <option value="0">Tidak Masuk Tim Audit</option>
                                        <option value="1">Masuk Tim Audit</option>
                                    </select>
                                </div>
                            </div> --}}
                           
                            <fieldset>
                                <center>
                                    <a href="{{ url('parameter/pegawaispi/jabatan') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Back</a>
                                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                </center>
                            </fieldset>
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
    $('#kabupaten').select2();
});
</script>
@endpush
