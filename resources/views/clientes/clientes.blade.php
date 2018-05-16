@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 5)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Clientes Registrados
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12">
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
	        </div>
	    </div>
	</div>
	<div class="col-md-12 divDetalles" style="display:none;">
		<div class="card">
		    <div class="card-header">
	        	<center>
	        		<h5 id="spanTitulo" class="card-header-text"></h5>
                </center>
	        </div>
		    <div class="card-block">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
		                	<div class="row">
								<div id="divVolver" class="col-md-12">
									<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
								</div>
							</div>
		                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
		                        <li class="nav-item">
		                            <a id="aDetalles" class="nav-link active" data-toggle="tab" href="#TabDetalles" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Datos Cliente
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a id="aFacturacionActual" class="nav-link" data-toggle="tab" href="#TabFacturacionActual" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Facturación Actual
		                            </a>
		                            <div class="slide"></div>
		                        </li>
								<li class="nav-item">
		                            <a id="aProximaFacturacion" class="nav-link" data-toggle="tab" href="#TabProximaFacturacion" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Próxima Facturación
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a id="aMovimientos" class="nav-link" data-toggle="tab" href="#TabMovimientos" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Todos los Movimientos
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a id="aEECC" class="nav-link" data-toggle="tab" href="#TabEECC" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                EECC
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                    </ul>
		                    <!-- Tab panes -->
		                    <br><br>
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="TabDetalles" role="tabpanel">
		                            {!! Form::open(['id'=>'FormCliente','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCliente', '', [
									'id'            => 'IdCliente',
									'class'         => 'form-control'])!!}
										<div class="row">
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control md-static" maxlength="14" readonly />
	                            					<label for="RUTCliente">RUT Cliente</label>
							                        <small id="ErrorRut" class="rut-error"></small>
						                        </div>
											</div>
						                    <div class="col-sm-8">
						                        <div class="md-input-wrapper">
						                        	<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control md-static" maxlength="250" readonly />
	                            					<label for="NombreCliente">Nombre del Cliente</label>
						                        </div>
						                    </div>
										</div>
										<div class="row">
											<div class="col-sm-12">
						                        <div class="md-input-wrapper">
					                                <input id="DireccionCliente" name="DireccionCliente" type="text" class="md-form-control md-static" maxlength="250" readonly />
	                            					<label for="DireccionCliente">Dirección Cliente</label>
												</div>
						                    </div>
										</div>
										<div class="row">
						                    <div class="col-sm-6">
						                        <div class="md-input-wrapper">
						                        	<input id="CupoAutorizado" name="CupoAutorizado" type="text" class="md-form-control md-static" maxlength="10" readonly />
	                            					<label for="CupoAutorizado">Cupo Autorizado</label>
						                        </div>
						                    </div>
											<div class="col-sm-6">
						                        <div class="md-input-wrapper">
						                        	<input id="CupoUtilizado" name="CupoUtilizado" type="text" class="md-form-control md-static" maxlength="10" readonly />
	                            					<label for="CupoUtilizado">Cupo Utilizado</label>
						                        </div>
											</div>
										</div>
										<div class="row">
						                    <div class="col-sm-6">
						                        <div class="md-input-wrapper">
					                                <select name="IdCicloFacturacion" id="IdCicloFacturacion" class="md-disable md-valid" disabled></select>
													<label for="IdCicloFacturacion">Día de Pago</label>
						                        </div>
						                    </div>
											<div class="col-sm-6">
						                        <div class="md-input-wrapper">
						                        	<select name="EstadoCliente" id="EstadoCliente" class="md-disable md-valid" disabled></select>
													<label for="EstadoCliente">Estado Cliente</label>
						                        </div>
											</div>
										</div>
										<div align="center">
											<div class="pull-rigth">
												<div class="divBotones">
													<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
														Modificar
													</button>
												</div>
												<div class="divBotones" style="display:none;">
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
		                        <div class="tab-pane" id="TabFacturacionActual" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaFacturacionActual" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
		                        </div>
		                        <div class="tab-pane" id="TabProximaFacturacion" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaProximaFacturacion" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
		                        </div>
		                        <div class="tab-pane" id="TabMovimientos" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaClientesMovimientos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
		                        </div>
		                        <div class="tab-pane" id="TabEECC" role="tabpanel">
		                        	<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaClientesEECC" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
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
	var rutaA = "{{ URL::route('activarCli') }}"
	var rutaD = "{{ URL::route('detallesCli') }}"
	var d = [];
	d['v_clientes'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_clientes) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_ciclos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_ciclos) }}'));
</script>
<script src="{{ asset('js/clientes/clientes.js') }}"></script>
@endsection