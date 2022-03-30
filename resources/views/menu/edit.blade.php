@extends('layout.app',[
    
])
@section('content')
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-left">
					<h4>Edit Menu</h4>
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

		@foreach ($menus as $menu)
			<form action="{{ route('menu.update', $menu->id) }}" method="POST">
				@csrf
				@method('PATCH')

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Nama Menu:</strong>
							<input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" class="form-control" placeholder="Name" >
							<span class="mandatory">*</span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Url:</strong>
							<input type="text" class="form-control"  name="url" value="{{ $menu->url }}" placeholder="" readonly>
							<span class="mandatory">*</span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Icon:</strong>
							<input type="text" class="form-control"  name="icon" value="{{ $menu->icon }}"  placeholder="" readonly>
							<span class="mandatory">*</span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Permission:</strong>
							<input type="text" class="form-control"  name="permission" value="{{ $menu->permission }}" {{  ($menu->permission == null) ? '': "readonly" }} placeholder="">
							<span class="mandatory">*</span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>No Urut:</strong>
							<input type="text" class="form-control"  name="nourut" placeholder="" value="{{ $menu->no_urut }}" >
							<span class="mandatory">*</span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group row">
							<div class="col-sm-12">
								<a href="{{ route('menu.index') }}" class="btn btn-info">Kembali</a>
								<button type="submit" id="disabled" class="btn btn-success">Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		@endforeach
	</div>
</div>
@endsection