@extends('layout.app',[
    
])
@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
        <div class="col-lg-6 margin-tb">
            <div class="pull-left mt-2">
                <h5>Daftar Sub Menu</h5>
            </div>
        </div>
        <div class="col-lg-6 margin-tb">
            <div class="pull-right">
                <form action="" method="GET">
                    {{ csrf_field() }}
                <div class="input-group mt-lg-2">
                    <input type="text" class="form-control" name="cari" placeholder="Masukkan Nama Menu" value="{{ old('cari') }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-outline-success" type="button">Cari</button>
                       <a class="btn btn-outline-success btn-outline-oke" href="{{ route('tbh_sub', $id) }}" >Tambah</a>
                       <a class="btn btn-outline-info btn-outline-oke" href="{{ route('menu.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                <th>No</th>
                <th>Menu</th>
                <th>Permission</th>
                <th>Url</th>
                <th>No Urut</th>
                <th width="15%">#</th>
            </tr>
            @foreach ($subMenu as $sub)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $sub->nama_menu }}</td>
                <td>{{ $sub->permission }}</td>
                <td>{{ $sub->url }}</td>
                <td>{{ $sub->no_urut }}</td>
                <td>
                    @csrf
                    @can('menu-edit')

                    <div class="btn-group">
                        <a href="{{ route('edit_sub',['id'=> $sub->id, 'parent'=> $id]) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                        <a  data-toggle="modal tooltip" id="smallButton" data-target="#smallModal" data-attr="{{ route('deleteMenusub',['id'=> $sub->id, 'parent'=> $id]) }}" data-placement="top" title="Delete" class="btn btn-sm btn-danger" style="cursor: pointer;"><i class="far fa-trash-alt" style="color: #FFFFFF;"></i></a>
                        @endcan
                    </div>
                </td>
                </tr>
            @endforeach
        </table>
    </div>

</div>
</div>
{{ $subMenu->appends(Request::get('page'))->links()}}
    {{-- {!! $menus->links() !!} --}}
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
