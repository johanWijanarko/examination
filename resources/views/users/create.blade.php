@extends('layout.app',[
   
])
@section('content')

<div class="card">
  <div class="card-body">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h5>Tambah Pengguna</h5>
            </div>
            <div class="pull-right mt-2 mb-2">
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

    {{-- {!! Form::open(array('route' => 'users.store','method'=>'POST', 'enctype="multipart/form-data"')) !!} --}}
    <form method="post" action="{{ route('users.store') }}" class="needs-validation-pegawai" id="validation-form" enctype="multipart/form-data">
        {{ csrf_field() }}
    <br>
    <div class="row">
        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>Klik salah satu untuk menetukan User Pegawai SPI / Auditee:</strong>
            <div class="form-check"><br>
                <strong>{!! Form::label('pegawai_cek','Pegawai SPI', [ 'class' => 'form-check-input position-static required']) !!}</strong>
                {!!Form::checkbox('pegawai_cek','1',false)!!}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>{!!Form::label('eksternal_cek','Auditee', [ 'class' => 'form-check-input position-static required', 'id'=> 'cek'])!!}</strong> 
                {!!Form::checkbox('eksternal_cek','2',false)!!}
            </div>
        </div>
        --}}
        <div class="col-xs-12 col-sm-12 col-md-12" id="data_pegawai">
            <div class="form-group">
                <strong>Pegawai SPI:</strong>
                {!! Form::select('pegawai', $data, [],array('class' => 'form-control','id' => 'pegawais','placeholder' => 'Pilih Pegawai...')) !!}
            </div>
        </div>
        {{-- <div class="col-xs-12 col-sm-12 col-md-12" id="pegawai_eksternal">
            <div class="form-group">
                <strong>Auditee:</strong>
                {!! Form::select('eksternal', $data2, [],array('class' => 'form-control','id' => 'eksternals', 'placeholder' => 'Pilih Auditee...')) !!}
            </div>
        </div> --}}
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Username:</strong>
                <input type="text" name="name" id="user_name" class="form-control" placeholder="UserName" value="{{ old('name') }}">
                {{-- {!! Form::text('name', null, array('placeholder' => 'UserName','class' => 'form-control','id' => 'user_name')) !!} --}}
                <div id="cek_user"></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                {{-- {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!} --}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" value="{{ old('confirm-password') }}">
                {{-- {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!} --}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Unggah Foto:</strong>
                <input type="file" name="file" id="file" accept=".jpg,.jpeg,.png" class="form-control" placeholder="masukan photo" >
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control', 'placeholder' => 'Pilih Role...')) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <a href="{{ url('user/daftar_user') }}" class="btn btn-info">Kembali</a>
                <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
            </div>
        </div>
        {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div> --}}
    </div>
    {{-- {!! Form::close() !!} --}}
    </form>

</div>
</div>
@endsection

@push('page-script')
<script>

$(document).ready(function() {
    // $("#data_pegawai").hide( );
    // $(function(){
    //     //listen for checkbox clicked, works for check and uncheck
    //     $("#pegawai_cek").click(function(){
    //         //get if checked, which returns a boolean value
    //         var formElementVisible = $(this).is(":checked");

    //         //show if checked
    //         if ( formElementVisible ){
    //             $("#eksternal_cek").prop("disabled", true);
    //             $("#data_pegawai").show( );
                
    //             return true;
    //         }
    //         //hide if unchecked
    //         $("#eksternal_cek").prop("disabled", false);
    //         $("#data_pegawai").hide( );       
    //     });
    // });

    // vendor
    // $("#pegawai_eksternal").hide( );
    // $(function(){
    //     //listen for checkbox clicked, works for check and uncheck
    //     $("#eksternal_cek").click(function(){
    //         //get if checked, which returns a boolean value
    //         var formElementVisible = $(this).is(":checked");

    //         //show if checked
    //         if ( formElementVisible ){
    //             $("#pegawai_cek").prop("disabled", true);
    //             $("#pegawai_eksternal").show( );
    //             return true;
    //         }

    //         //hide if unchecked
    //         $("#pegawai_cek").prop("disabled", false);
    //         $("#pegawai_eksternal").hide( ); 
    //     });
    // });

    $(document).ready(function() {
        // $('#eksternals').select2();
        $('#pegawais').select2();
        })
})

$('#user_name').blur(function(){
    $.ajax({
        type: 'POST',
        url: '{{ url('user/chek_user') }}',
        data: $(this).serialize(),
        success: function (data){
            var jsp = JSON.parse(data);

            var html = '';
            if(jsp.status) { // jika status true
                // console.log('pertama : '+jsp.status);
                html = '<font color="red">Username Sudah Digunkan / Sudah ada</font>';
            } 
            $('#cek_user').html(html);
            // $('#user_name_cek').val('');
        }
    });
});

</script>
    
@endpush