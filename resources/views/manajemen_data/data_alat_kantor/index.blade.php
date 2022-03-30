@extends('layout.app',[
    
])
@section('content')
<div class="card">
    <div class="card-body">
        <div>
            <h5>Data Peralatan Kantor</h5>
        </div><br>
        <div class="input-group-append" style="float: right; margin-bottom: 10px; " > 
            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('add_Atk') }}">Tambah</a>
          {{-- <a class="btn btn-outline-info btn-outline-oke" href="{{ url('parameter/par_audit') }}"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peralatan Kantor</th>
                        <th>Merk / Jenis</th>
                        <th>Type</th>
                        <th>Kondisi</th>
                        <th>Supplier</th>
                        <th>Jumlah (Unit)</th>
                        <th>Dipakai</th>
                        <th>Rusak</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<!-- small modal -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
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

    $(function() {
        $('#data_perangkat').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ url('m_data/alat_kantor/getDataAtk') }}',
            columns: [
                { "data": 'DT_RowIndex',orderable: false, searchable: false },
                { data: 'data_manajemen_name', name: 'data_manajemen_name' },
                { data: 'merk', name: 'merk' },
                { data: 'type', name: 'type' },
                { data: 'kondisi', name: 'kondisi' },
                { data: 'supplier', name: 'supplier' },
                { data: 'data_manajemen_jumlah', name: 'data_manajemen_jumlah' },
                { data: 'data_manajemen_jumlah_pemakai', name: 'data_manajemen_jumlah_pemakai' },
                { data: 'data_manajemen_jumlah_rusak', name: 'data_manajemen_jumlah_rusak' },
                { data: 'data_manajemen_keterangan', name: 'data_manajemen_keterangan' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ]
           ,
            columnDefs: [
                { width: 50, targets: 0 },
                { width: 350, targets: 1 },
                { width: 250, targets: 2 },
                { width: 250, targets: 3 },
                { width: 250, targets: 4 },
                { width: 250, targets: 5 },
                { width: 250, targets: 6 },
                { width: 250, targets: 7 },
                { width: 250, targets: 8 },
                { width: 250, targets: 9 },
                { width: 250, targets: 10 },
            ]
        });
    });

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
