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
            <a class="btn btn-primary" href="{{ url('dashboard') }}"> Back</a>
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
{{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!} --}}
{{-- {!! Form::model($user, ['method' => 'post','enctype'=>'multipart/form-data','route' => ['update_password', $user->id]]) !!} --}}
<form action="{{ route('update_password', $user->id) }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <strong>Username:</strong>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Kosongkan Password jika tidak mengubah password','class' => 'form-control')) !!}
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
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
{{-- {!! Form::close() !!} --}}
</div>
</div>
@endsection
@push('page-script')
<script>
$(document).on('click', '.del_file', function(event) {
    $(this).parent().remove()
});
</script>
    
@endpush

