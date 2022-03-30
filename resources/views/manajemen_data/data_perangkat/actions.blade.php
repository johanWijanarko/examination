<a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" href="{{ url('m_data/perangkat/edit', $data_manajemen_id) }}"><i class="far fa-edit"></i></a>

<a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ route('confrimdelperangkat', $data_manajemen_id) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>