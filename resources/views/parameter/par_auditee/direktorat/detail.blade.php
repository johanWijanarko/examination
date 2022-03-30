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
                            <h5 class="card-title">Detail Jabatan</h5>
                        {{-- </div> --}}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Nama Jabatan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan" id="jabatan" value="{{ $jabatan->jenis_jabatan }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Sub Jabatan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="subjabatan" id="subjabatan" value="{{ $jabatan->jenis_jabatan_sub }}"  class="form-control"  readonly>
                                </div>
                            </div>
                            <fieldset>
                                <center>
                                    <a href="{{ url('parameter/direktorat') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Back</a>
                                </center>
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
