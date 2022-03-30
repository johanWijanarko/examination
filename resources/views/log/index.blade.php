@extends('layout.app',[
    
])
@section('content')
<style>
 
</style>

<div class="card">
    <div class="card-body">
     <div class="row">
            <div class="col-lg-6 margin-tb">
                <div class="pull-left mt-2">
                    <h5>Log Aktivitas</h5>
                </div>
            </div>
            <div class="col-lg-6 margin-tb">
                <div class="pull-right">
                    <form action="{{ route('logs') }}" method="GET">
                        {{ csrf_field() }}
                    <div class="input-group mt-lg-2">
                        <input type="text" class="form-control" name="cari" placeholder="" value="">
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-success" type="button">Cari</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

         <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="pegawai">
                <thead>
                    <th>No</th>
                    <th width="20%" style="text-align: center;">Keterangan</th>
                    <th width="20%" style="text-align: center;">Waktu</th>
                    <th style="text-align: center;">Log IP</th>
                    <th width="15%" style="text-align: center;">User</th>
                    <th width="30%" style="text-align: center;">Data</th>
                    {{-- <th class="td-select" width="15%">Action</th> --}}
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td style="vertical-align: text-top">{{ ++$i }}</td>
                            <td style="vertical-align: text-top">{{ $log->log_subject }}</td>
                            <td style="vertical-align: text-top">{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</td>
                            <td style="text-align: center; vertical-align: text-top;">{{ $log->log_ip }}</td>
                            <td style="text-align: center; vertical-align: text-top;">{{ $log->log_user }}</td>
                            {{-- <td style="text-align: center; vertical-align: text-top;">{{ $log->log_keterangan }}</td> --}}
                            <td style="text-align: center; vertical-align: text-top;">{{ $log->log_data }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
            {{ $logs->appends(Request::get('page'))->links()}}
            {{-- {{ $logs->links() }} --}}
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
