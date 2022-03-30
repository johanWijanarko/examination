@extends('layout.app',[
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard'
])
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 margin-tb">
                <div class="pull-left mt-2">
                    <h5>Role Akses</h5>
                </div>
            </div>
            <div class="col-lg-6 margin-tb">
                <div class="pull-right">
                    <form action="{{ route('roles.index') }}" method="GET">
                        {{ csrf_field() }}
                    <div class="input-group mt-lg-2">
                        <input type="text" class="form-control" name="cari" placeholder="Masukkan Role" value="{{ old('cari') }}">
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-success" type="button">Cari</button>
                        <a class="btn btn-outline-success btn-outline-oke" href="{{  route('roles.create')  }}">Tambah</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka">
                <tr>
                    <th width="20%">No</th>
                    <th>Name</th>
                    <th width="15%" style="text-align :center;">Action</th>
                </tr>
                    @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td align="center">
                        {{-- <a data-toggle="tooltip" title="Detail Data" class="btn btn-sm btn-icon btn-info" href="{{ route('roles.show',$role->id) }}"><i class="fas fa-info-circle"></i></a> --}}
                        
                        <a data-toggle="tooltip" title="Ubah Data" class="btn btn-sm btn-icon btn-warning" href="{{ route('roles.edit',$role->id) }}"><i class="far fa-edit"></i></a>
                        
                        <a data-toggle="modal" id="smallButton"  data-target="#smallModal" title="Delete"  data-attr="{{ url('user/groupconfrimDel', $role->id) }}" class="btn btn-sm btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    
                    </td>
                </tr>
                    @endforeach
            </table>
        </div>
        {!! $roles->render() !!}
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