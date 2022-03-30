<a data-toggle="tooltip" title="Detail Data" class="btn btn-sm btn-icon btn-info" href="{{ route('detailpegawai', $pegawai_id) }}"><i class="fas fa-info-circle"></i></a>
             
<a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" href="{{ route('editlpegawai', $pegawai_id) }}"><i class="far fa-edit"></i></a>

<a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ route('confrimDelpgw', $pegawai_id) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>