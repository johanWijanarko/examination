<a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" onclick="edit({{ $supplier_id }})"><i class="far fa-edit"></i></a>

<a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ route('confrimdelsupplier',$supplier_id ) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>