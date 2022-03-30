@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 margin-tb">
                <div class="pull-left mt-2">
                    <h5>Daftar Jenis Auditee</h5>
                </div>
            </div>
            <div class="col-lg-6 margin-tb">
                <div class="pull-right">
                    <form action="{{ route('jenis_auditee') }}" method="GET">
                        {{ csrf_field() }}
                    <div class="input-group mt-lg-2">
                        <input type="text" class="form-control" name="cari" placeholder="Masukkan Aspek Program Audit" value="{{ old('cari') }}">
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-success" type="button">Cari</button>
                        <a class="btn btn-outline-success btn-outline-oke" href="{{ route('tambahjenAuditee') }}">Tambah</a>
                        <a class="btn btn-outline-info btn-outline-oke" href="{{ route('parauditee') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="pegawai">
                <thead>
                    <tr>
                        <th style="width: 20px">No</th>
                        <th>Jenis Auditee</th>
                        <th style="width: 130px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisAuditee as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->jenis_auditee_name }}</td>
                            <td>
                                <a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" href="{{ route('editjenAuditee', $item->jenis_auditee_id) }}" ><i class="far fa-edit"></i></a>

                                <a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ route('confrimjenAuditee', $item->jenis_auditee_id) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $jenisAuditee->links() }}
            </div>
            
        </div>
    </div>
</div>


@endsection
@push('page-script')
<!-- small modal -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   // display a modal (small modal)
   $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            }
            , complete: function() {
                $('#loader').hide();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });


    
</script>

@endpush
