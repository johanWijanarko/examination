@extends('layout.app',[
    
])
@section('content')
<style>
    /* .table-align-center {
        padding: 0px !important;
    }
    .table-align-center th, td{
        font-size: 14px !important;
        padding: 14px !important;
    }
    table,
    th,
    td {
        border-collapse: collapse;
        border-color: rgb(242, 242, 242) !important;
        height: 30px !important;

    }
    th {
        text-align: center !important;
    } */
</style>
<div class="card">
    
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-header" style="background-color: rgb(230, 240, 209)"><h5>Tambah Role Akses</h5></div>
                        <div class="card-body">
                            
                        {{-- <h5 class="card-title">Tambah Role Aksest</h5> --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-outline-info btn-outline-oke float-right" href="{{ url('user/group_user') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                            {{ csrf_field() }}
                            <br>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="inputEmail3" class="mt-2"><h6>Name :</h6></label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class=""><h6>Permission :</h6></label>
                                    <table class="table table-bordered table-striped table-inka" id="pegawai">
                                        <thead>
                                            <tr>
                                                <th width="30%">Nama Menu</th>
                                                <th width="10%">list</th>
                                                <th width="10%">create</th>
                                                <th width="10%">edit</th>
                                                <th width="10%">delete</th>
                                                <th width="10%">detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getMenu1 as $mn)
                                                @php
                                                    $premis = $permission->where('name','like', $mn->permission .'-%' )->get();
                                                    $childs = DB::table('menu')->where('status',1)->where('master_menu', $mn->id)->orderBy('no_urut','asc')->get();
                                                @endphp
                                                    
                                                    <tr>
                                                       <td>{{ $mn->nama_menu }}</td>

                                                        @foreach ($premis as $item)
                                                            <td>
                                                                <input type="checkbox" name="permission[]" value="{{ $item->id }}" id="customSwitch{{ $item->id }}">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    @foreach ($childs as $child)
                                                        @php
                                                            $premis2 = $permission->where('name','like', $child->permission .'-%' )->get();
                                                        @endphp
                                                        <tr>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>> {{ $child->nama_menu }}</td>
                                                            @foreach ($premis2 as $item2)
                                                                <td>
                                                                    <input type="checkbox" name="permission[]" value="{{ $item2->id }}" id="customSwitch{{ $item2->id }}">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group rzow">
                                <div class="col-sm-12">
                                    <a class="btn btn-outline-info btn-outline-oke" href="{{ url('user/group_user') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')

<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script>

</script>

@endpush
