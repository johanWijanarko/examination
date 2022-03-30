@extends('layout.app',[
    
])
@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h5>Add New Menu</h5>
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


    <form action="{{ route('save_sub', $id) }}" method="POST">
    	@csrf
        <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nama Menu:</strong>
		            <input type="text" name="nama_menu" class="form-control" placeholder="Name">
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Url:</strong>
		            <input type="text" class="form-control"  name="url" placeholder="">
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Permission:</strong>
		            <input type="text" class="form-control"  name="permission" placeholder="">
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>No Urut:</strong>
		            <input type="text" class="form-control"  name="nourut" placeholder="">
                    <span class="mandatory">*</span>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group row">
					<div class="col-sm-12">
						<a href="{{ route('submenu', $id) }}" class="btn btn-info">Kembali</a>
						<button type="submit" id="disabled" class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>


    </form>

	</div>
</div>

@endsection