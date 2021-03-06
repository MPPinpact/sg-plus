@extends('menu.index')
@section('content')
<div class="row">
	<div class="col-md-12 divDetalles">
		<div class="card">
			<div class="card-header">
				<center>
					<h5 id="spanTitulo" class="card-header-text"></h5>
				</center>
			</div>
			<div class="card-block">
				<div class="col-md-12 divForm">
					<div class="row">
						<div class="col-md-12">
							<button style="float:right;" name="agregar" id="agregar" type="button" class="btn btn-primary waves-effect waves-light">
								<span>Agregar</span>
							</button>
							<button style="float:right;" name="botonTodas" id="botonTodas" type="button" class="btn btn-primary waves-effect waves-light">
								<span>Todas las SubFamilias</span>
							</button>
							<button style="float:right;" name="botonActivas" id="botonActivas" type="button" class="btn btn-primary waves-effect waves-light">
								<span>SubFamilias Activas</span>
							</button>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaSubfamilias" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
				</div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormSubfamilia','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdSubFamilia', '', [
					'id'            => 'IdSubFamilia',
					'class'         => 'form-control'])!!}
					<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="NombreSubFamilia" name="NombreSubFamilia" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="NombreSubFamilia">Nombre Subfamilia</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="IdFamilia" id="IdFamilia" class="md-valid"></select>
								<label for="IdFamilia">Familia</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
						<div class="md-input-wrapper">
								<select name="IdUnidadMedida" id="IdUnidadMedida" class="md-valid"></select>
								<label for="IdUnidadMedida">Unidad de Medida</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="EstadoSubFamilia" id="EstadoSubFamilia" class="md-valid"></select>
								<label for="EstadoSubFamilia">Estado</label>
							</div>
						</div>
					</div>
					<br>
					<div align="center">
						<div class="pull-rigth">
							<div id="divBtnModificar">
								<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
									Modificar
								</button>
							</div>
							<div id="divBtnAceptar">
								<button id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
									Cancelar
								</button> 
								<button id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
									Guardar
								</button>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>            
			</div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('subfamilias') }}"
	var rutaA = "{{ URL::route('activarSf') }}"
	var rutaB = "{{ URL::route('subfamiliab') }}"
	var rutaSA = "{{ URL::route('subfamiliasActivas') }}"
	var rutaTS = "{{ URL::route('subfamiliasTodas') }}"

	var d = [];
	d['v_subfamilias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_subfamilias) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_unidadmedida'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidadmedida) }}'));
	d['v_familia'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_familia) }}'));
</script>
<script src="{{ asset('js/subfamilias/subfamilias.js') }}"></script>
@endsection