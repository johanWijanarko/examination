@extends('layout.app',[
    
])
@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h5>Edit Menu</h5>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('update_sub', $sub_menu->id) }}" method="POST">
    	@csrf

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nama Menu:</strong>
		            <input type="text" name="nama_menu" value="{{ $sub_menu->nama_menu }}" class="form-control" placeholder="Name" >
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Url:</strong>
		            <input type="text" class="form-control"  name="url" value="{{ $sub_menu->url }}" placeholder="" readonly>
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Permission:</strong>
                    <input type="hidden" name="parent" value="{{ $parent }}">
		            <input type="text" class="form-control"  name="permission" value="{{ $sub_menu->permission }}" {{  ($sub_menu->permission == null) ? '': "readonly" }} placeholder="">
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>No Urut:</strong>
		            <input type="text" class="form-control"  name="nourut" placeholder="" value="{{ $sub_menu->no_urut }}" >
                    <span class="mandatory">*</span>
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group row">
					<div class="col-sm-12">
						<a href="{{ route('submenu', $parent) }}" class="btn btn-info">Kembali</a>
						<button type="submit" id="disabled" class="btn btn-success">Simpan</button>
					</div>
				</div>
		    </div>
		</div>
    </form>
	</div>
</div>
@endsection