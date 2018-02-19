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
							<table id="tablaClientes" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormCliente','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdCliente', '', [
					'id'            => 'IdCliente',
					'class'         => 'form-control'])!!}
					<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control" maxlength="12" readonly />
								<label for="RUTCliente">RUT Cliente</label>
							</div>
						</div>
						<div class="col-sm-8">
	                        <div class="md-input-wrapper">
								<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control" maxlength="190" readonly />
								<label for="NombreCliente">Nombre Cliente</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="md-input-wrapper">
								<input id="DireccionCliente" name="DireccionCliente" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="DireccionCliente">Dirección Cliente</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="DiaPago" id="DiaPago" class="md-disable md-valid" disabled></select>
                                <label for="DiaPago">Dia de Pago</label>
							</div>
						</div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="CupoAutorizado" id="CupoAutorizado" class="md-disable md-valid" disabled></select>
                                <label for="CupoAutorizado">Cupo Autorizado</label>
							</div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="CupoUtilizado" id="CupoUtilizado" class="md-disable md-valid" disabled></select>
	                            <label for="CupoUtilizado">Cupo Utilizado</label>
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
	<div class="col-md-12 divDetalles" style="display:none;">
		<div class="card">
		    
		    <div class="card-block">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="clientes-edit">
		                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
		                        <li class="nav-item">
		                            <a class="nav-link active" data-toggle="tab" href="#TabDatos" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Datos Cliente
		                            </a>
		                            <div class="slide"></div>
		                        </li>
								<li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#TabMovimientos" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Movimientos
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#TabEECC" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                EECC
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                    </ul>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="TabDatos" role="tabpanel">
		                            <form class="md-float-material card-block">
										<div class="row">
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control" maxlength="14" readonly />
	                            					<label for="RUTCliente">RUT Cliente</label>
						                        </div>
											</div>
						                    <div class="col-sm-8">
						                        <div class="md-input-wrapper">
						                        	<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control" maxlength="250" readonly />
	                            					<label for="NombreCliente">Nombre del Cliente</label>
						                        </div>
						                    </div>
										</div>
										<div class="row">
											<div class="col-sm-12">
						                        <div class="md-input-wrapper">
					                                <input id="DireccionCliente" name="DireccionCliente" type="text" class="md-form-control" maxlength="250" readonly />
	                            					<label for="DireccionCliente">Dirección Cliente</label>
												</div>
						                    </div>
										</div>
										<div class="row">
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="DiaPago" name="DiaPago" type="text" class="md-form-control" maxlength="2" readonly />
	                            					<label for="DiaPago">Dia de Pago</label>
						                        </div>
											</div>
						                    <div class="col-sm-4">
						                        <div class="md-input-wrapper">
						                        	<input id="CupoAutorizado" name="CupoAutorizado" type="text" class="md-form-control" maxlength="10" readonly />
	                            					<label for="CupoAutorizado">Cupo Autorizado</label>
						                        </div>
						                    </div>
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="CupoUtilizado" name="CupoUtilizado" type="text" class="md-form-control" maxlength="10" readonly />
	                            					<label for="CupoUtilizado">Cupo Utilizado</label>
						                        </div>
											</div>
										</div>
		                            </form>
		                        </div>
		                        <div class="tab-pane" id="TabMovimientos" role="tabpanel">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		                        </div>
		                        <div class="tab-pane" id="TabEECC" role="tabpanel">
		                        	222222222222222222222222222222222222222222222222222222222222222222
		                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                        	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                        	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		                        	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		                        	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		                        	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		                        </div>
		                        <div class="text-center">
		                            <button id="btn-volver" type="button" class="btn btn-inverse-primary waves-effect waves-light m-r-10">
		                            	Volver
		                            </button>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('clientes') }}"
	var rutaA = "{{ URL::route('activarPr') }}"
	var rutaD = "{{ URL::route('detallesPr') }}"
	var rutaDes = "{{ URL::route('descontinuarPr') }}"
	var rutaB = "{{ URL::route('buscarSubfamilia') }}"
	var d = [];
	d['v_clientes'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_clientes) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_familias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_familias) }}'));
	d['v_subfamilias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_subfamilias) }}'));
	d['v_unidad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
</script>
<script src="{{ asset('js/clientes/clientes.js') }}"></script>
@endsection