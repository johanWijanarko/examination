@extends('layout.app',[
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard'
])
@section('content')
<div class="card">
    <div class="card-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h5>Edit Pengguna</h5>
        </div>
        <div class="pull-right">
           {{-- <a href="{{ url('user/daftar_user') }}" class="btn btn-info">Kembali</a> --}}
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<br>

{!! Form::model($user, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['users.update', $user->id]]) !!}
@php
    // $checked_p = false;
    // $checked_v = false;
    // if($user->login_as == 1){
    //     $checked_p= true;
    // }elseif($user->login_as == 2){
    //     $checked_v= true;
    // }
    // $show_p = 'd-none';
    // $show_v = 'd-none';
    // if($checked_p == true){
    //     $show_p = '';
    //     $show_v = 'd-none';
    // } elseif ($checked_v == true) {
    //     $show_p = 'd-none';
    //     $show_v = '';
    // }
    
@endphp
<div class="row">
    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
        <strong>Klik salah satu untuk menetukan User Pegawai SPI / Auditee:</strong>
        <div class="form-check"><br>
            <strong>{!! Form::label('pegawai_cek','Pegawai', [ 'class' => 'form-check-input position-static required']) !!}</strong>
            {!!Form::checkbox('pegawai_cek','1',$checked_p)!!}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>{!!Form::label('vendor_cek','Auditee', [ 'class' => 'form-check-input position-static required', 'id'=> 'cek'])!!}</strong>
            {!!Form::checkbox('vendor_cek','2',$checked_v)!!}
        </div>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12" id="data_pegawai">
        <div class="form-group">
            <strong>Pegawai:</strong>
            {{-- {!! Form::select('pegawai', $data, [],array('class' => 'form-control','id' => 'pegawais','')) !!} --}}
            {!! Form::select('pegawai', $data, $user->user_internal_id,array('class' => 'form-control','id' => 'pegawais','placeholder' => 'Pilih Pegawai...')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Username:</strong>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Kosongkan password jika tidak ingin mengubah password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Unggah Foto</strong>
            <div class="col-md-8"><br>
                <input type="file" name="file" id="file" class="form-control" placeholder="masukan photo" >
                <div>
                    @if ($user->user_foto)
                        <img src="{{ asset('storage/upload/'.$user->user_foto) }}" style="width: 200px; height: 200px;">
                        <button class="btn btn-danger del_file" title="Delete File"><i class="fa fa-trash"></i></button>
                        <input type="hidden" class="form-control" name="old[]" value="{{ $user->id }}" >
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <a href="{{ url('user/daftar_user') }}" class="btn btn-info">Kembali</a>
            <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
        </div>
    </div>
</div>
{{-- </form> --}}
{!! Form::close() !!}
</div>
</div>
@endsection
@push('page-script')
<script>
$(document).on('click', '.del_file', function(event) {
   $(this).parent().remove()
    
});

$(document).ready(function() {
    $('#vendors').select2();
    $('#pegawais').select2();

})



</script>
    
@endpush

