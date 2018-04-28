@extends('accesos.index')
@section('content')
<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header"><h5 class="card-header-text">Locales del Usuario</h5></div>
			<div class="card-block">
				<div class="data_table_main">
					<div class="project-table">
                     <table id="tablaLocalesUsuario" class="table compact table-striped dt-responsive nowrap table-hover" width="100%" cellspacing="0">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header"><h5 class="card-header-text">Perfiles del Usuario</h5></div>
			<div class="card-block">
				<div class="data_table_main">
					<div class="project-table">
                     	<table id="tablaAccesos" class="table compact table-striped dt-responsive nowrap table-hover" width="100%" cellspacing="0">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script Language="Javascript">
	var ruta = "{{ URL::route('accesos') }}"
	var RutaSalir = "{{ URL::route('logout') }}";
	var d = [];
	d['v_accesos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_accesos) }}'));
	d['v_lcoales_usuario'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_lcoales_usuario) }}'));
</script>
<script src="{{ asset('js/accesos/accesos.js') }}"></script>
@endsection	