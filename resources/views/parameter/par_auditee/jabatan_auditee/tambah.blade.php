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
                            <h5 class="card-title">Tambah Jabatan</h5>
                        {{-- </div> --}}
                        <form method="post" action="{{ route('savejabatanPic') }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Nama Jabatan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" maxlength="18" placeholder="masukan Nama Jabatan" required>
                                    <label class="error_nip" style="display:none;"></label>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Jabatan Short</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan_short" id="jabatan_short" class="form-control" maxlength="18" placeholder="masukan Nama Jabatan" required>
                                    <label class="error_nip" style="display:none;"></label>
                                </div>
                            </div>
                            <fieldset>
                                <center>
                                    <a href="{{ url('parameter/auditee/jabatan_auditee') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Back</a>
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
