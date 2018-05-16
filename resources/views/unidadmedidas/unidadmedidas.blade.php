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
							<table id="tablaUnidades" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormUnidad','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdUnidadMedida', '', [
					'id'            => 'IdUnidadMedida',
					'class'         => 'form-control'])!!}
					<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
                                <input id="NombreUnidadMedida" name="NombreUnidadMedida" type="text" class="md-form-control md-static" maxlength="250" readonly />
	                            <label for="NombreUnidadMedida">Nombre Unidad Medida</label>
	                        </div>
						</div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="EstadoUnidadMedida" id="EstadoUnidadMedida" class="md-disable md-valid" disabled></select>
	                            <label for="EstadoUnidadMedida">Estado</label>
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
	var ruta = "{{ URL::route('umedidas') }}"
	var rutaA = "{{ URL::route('activarUm') }}"
	var rutaB = "{{ URL::route('umedidasb') }}"
	var d = [];
	d['v_unidades'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidades) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
</script>
<script src="{{ asset('js/unidadmedidas/unidadmedidas.js') }}"></script>
@endsection