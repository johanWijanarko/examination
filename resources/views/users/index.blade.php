@extends('layout.app',[
    
])
@section('content')
<style>
    .table-align-center {
        padding: 0px !important;
    }
    .table-align-center th, td{
        font-size: 14px !important;
        padding: 10px !important;
    }
    table,
    th,
    td {
        border-collapse: collapse;
        border-color: rgb(242, 242, 242) !important;
        height: 10px !important;

    }
    th {
        text-align: center !important;
    }
    label{
         font-size: 14px !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 margin-tb">
                <div class="pull-left mt-2">
                    <h5>Daftar Pengguna</h5>
                </div>
            </div>
            <div class="col-lg-6 margin-tb">
                <div class="pull-right">
                    <form action="{{ route('users.index') }}" method="GET">
                        {{ csrf_field() }}
                    <div class="input-group mt-lg-2">
                            <input type="text" class="form-control" name="cari" placeholder="Masukkan Username" value="{{ old('cari') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-success" type="button">Cari</button>
                            <a class="btn btn-outline-success btn-outline-oke" href="{{ route('users.create') }}">Tambah</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

         <div class="table-responsive mt-4">
            <table class="table table-bordered border-primary table-align-center table-inka" style="font-size: 10px !ipmportant;!important">
					<thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Name</th>
                        <th width="15%">Status</th>
                        <th width="25%">Roles</th>
                        <th width="15%">Action</th>
                    </tr>
					</thead>
					<tbody>
                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td style="text-align: center;">
                                @if($user->session_id)
                                    <a data-toggle="modal" id="out" title=""  data-target="#komentar_tindakLanjut" data-attr="{{ route('out_user', $user->id) }}" class="btn btn-success btn-sm">Login</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <a href="#" class="badge btn-sm badge-light">{{ $v }}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" href="{{ route('users.edit', $user->id) }}"><i class="far fa-edit"></i></a>
                                <a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ route('delete_user', $user->id) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
					</tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $data->render() !!}
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
                    {{-- logout user?  --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" id="komentar_tindakLanjut" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Komentar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody2">
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


    $(document).on('click', '#out', function(event) {
    event.preventDefault();
    let href = $(this).attr('data-attr');
    $.ajax({
        url: href
        , beforeSend: function() {
            $('#loader').show();
        },
        // return the result
        success: function(result) {
            $('#komentar_tindakLanjut').modal("show");
            $('#smallBody2').html(result).show();
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
