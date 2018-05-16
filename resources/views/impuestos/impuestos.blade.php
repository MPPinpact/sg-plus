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
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaImpuesto" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
				</div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormImpuestos','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdImpuesto', '', [
					'id'            => 'IdImpuesto',
					'class'         => 'form-control'])!!}
					<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="NombreImpuesto" name="NombreImpuesto" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="NombreImpuesto">Nombre Impuesto</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="ValorImpuesto" name="ValorImpuesto" type="text" class="md-form-control md-static" maxlength="20" readonly />
								<label for="ValorImpuesto">Valor Impuesto</label>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="EstadoImpuesto" id="EstadoImpuesto" class="md-disable md-valid" disabled></select>
								<label for="EstadoImpuesto">Estado</label>
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
	var ruta = "{{ URL::route('impuestos') }}"
	var rutaA = "{{ URL::route('activarI') }}"
	var rutaB = "{{ URL::route('impuestob') }}"
	var d = [];
	d['v_impuestos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_impuestos) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
</script>
<script src="{{ asset('js/impuestos/impuestos.js') }}"></script>
@endsection