@extends('layout.app',[
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard'
])
@section('content')
  <div class="card">
    <div class="card-body">
            <h6 class="card-title">Parameter Auditee</h6>
            <br>
            <div class="row">
                <div class="col-md-3 mb-2">
                   <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('jabatan_auditee') }}" ><i class="fa fa-bookmark"></i> Jabatan Auditee</a>
                </div>
                <div class="col-md-3 mb-2">
                    <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('p_direktorat') }}" ><i class="fa fa-bookmark"></i> Direktorat</a>
                </div>
                <div class="col-md-3 mb-2">
                   <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('jenis_auditee') }}" ><i class="fa fa-bookmark"></i> Jenis Auditee </a>
                </div>    
            </div>
        </div>
  </div>
@endsection
@push('page-script')

@endpush