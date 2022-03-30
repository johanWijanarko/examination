@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Jabatan Unit SPI</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('saveunitspi') }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Jabatan Unit SPI</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="masukan Jabatan Unit SPI" >
                                    <div class="invalid-feedback">
                                        Masukkan Jabatan Unit SPI
                                    </div>
                                </div>
                            </div>
                            <fieldset>
                                <center>
                                    <a href="{{ url('parameter/pegawaispi/unitspi') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Back</a>
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
$("textarea").each(function(){
    CKEDITOR.replace( this );
});
</script>
@endpush
