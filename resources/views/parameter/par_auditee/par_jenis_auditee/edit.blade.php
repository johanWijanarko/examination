@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        <h5 class="card-title">Edit Jenis Auditee</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('updatejenAuditee', $getData->jenis_auditee_id) }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                   <label class="col-form-label">Jenis Auditee</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="jenis_auditee" id="jenis_auditee" value="{{ $getData->jenis_auditee_name }}" class="form-control" placeholder="masukan Jenis Auditee" >
                                    <div class="invalid-feedback">
                                        Masukkan Jenis Auditee
                                    </div>
                                </div>
                            </div>
                            <fieldset>
                                <center>
                                    <a href="{{ route('jenis_auditee') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Back</a>
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
