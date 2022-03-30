@extends('layout.app',[
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard'
])
@section('content')
  <div class="card">
    <div class="card-body">
            <h6 class="card-title">Parameter Pegawai</h6>
            <br>
            <div class="row">
                <div class="col-md-3 mb-2">
                   <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('jabatan') }}" ><i class="fa fa-bookmark"></i> Jabatan</a>
                </div>
                <div class="col-md-3 mb-2">
                    <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('unitspi') }}" ><i class="fa fa-bookmark"></i> Unit SPI</a>
                </div>
                <div class="col-md-3 mb-2">
                   <a  class="btn btn-primary btn-sm btn-block" aria-labelledby="headingUtilities" href="{{ route('p_pelatihan') }}" ><i class="fa fa-bookmark"></i> Jenis Pelatihan </a>
                </div>    
            </div>
        </div>
  </div>
@endsection
@push('page-script')

@endpush