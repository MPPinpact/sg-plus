@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Vendedores Registrados
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
							<table id="tablaVendedor" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#detalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles de Proveedor
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="acompras" class="nav-link" data-toggle="tab" href="#compras" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Metas Registradas
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
							</div>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
									<br><br>
									{!! Form::open(['id'=>'FormVendedor','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdVendedor', '', [
									'id'            => 'IdVendedor',
									'class'         => 'form-control'])!!}
									{!! Form::hidden('IdUser', '', [
									'id'            => 'IdUser',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="RUTVendedor" name="RUTVendedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
					                            <label for="RUTVendedor">RUT</label>
		                        				<small id="ErrorRut" class="rut-error"></small>
					                        </div>
										</div>
										<div class="col-sm-6">
											<div class="md-input-wrapper">
				                                <input id="NombreVendedor" name="NombreVendedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
					                            <label for="NombreVendedor">Nombre</label>
					                        </div>
										</div>
					                    <div class="col-sm-2">
					                        <div class="md-input-wrapper">
				                                <input id="ComisionVendedor" name="ComisionVendedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
					                            <label for="ComisionVendedor">Comisión</label>
					                        </div>
					                    </div>
									</div>
									<br>
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
		                        <div class="tab-pane" id="compras" role="tabpanel">
									<br />
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-6">
											<div class="table-responsive">
												<table id="tablaMetas" class="table compact table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
											</div>
										</div>
										<div class="col-md-3">
											<button style="float:right;" name="agregarM" id="agregarM" type="button" class="btn btn-primary waves-effect waves-light">
												<span>Agregar</span>
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
	</div>
</div>

<!-- Modal Metas -->
<div class="modal fade modal-flex" id="ModalMetas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            	<h6 class="modal-title">REGISTRO DE METAS</h6>
            </div>
            <div class="modal-body">
            	{!! Form::open(['id'=>'FormMetas','autocomplete' => 'off']) !!}
            	<input type="text" name="IdMeta" id="IdMeta">
            	<input type="text" name="IdVendedor2" id="IdVendedor2">
            	<div class="row">
					<div class="col-sm-4">
						<div class="md-input-wrapper">
							<input id="PeriodoVentaInicio" name="PeriodoVentaInicio" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
							<label for="PeriodoVentaInicio">Fecha Inicio</label>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="md-input-wrapper">
							<input id="PeriodoVentaFin" name="PeriodoVentaFin" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
							<label for="PeriodoVentaFin">Fecha Fin</label>
						</div>
					</div>
				<div class="col-sm-4">
						<div class="md-input-wrapper">
							<input id="MetaPeriodo" name="MetaPeriodo" type="text" class="md-form-control md-static" maxlength="250"/>
							<label for="MetaPeriodo">Monto Meta</label>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
            </div>
            <div class="modal-footer">
            	<div id="divModificarM">
                	<button type="button" id="modificarM" class="btn btn-primary waves-effect waves-light">Modificar</button>
            	</div>
            	<div id="divAceptarM" style="display:none;">
                	<button type="button" id="cancelarM" class="btn btn-inverse-primary waves-effect waves-light" data-dismiss="modal">Cancelar</button>
                	<button type="button" id="guardarM" class="btn btn-primary waves-effect waves-light">Guardar</button>
            	</div>
            </div>
        </div>
    </div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('vendedores') }}"
	var rutaA = "{{ URL::route('activarVen') }}"
	var rutaB = "{{ URL::route('buscarVen') }}"
	var rutaD = "{{ URL::route('detallesVen') }}"
	var rutaM = "{{ URL::route('metas') }}"
	var rutaE = "{{ URL::route('metasE') }}"
	var rutaDM = "{{ URL::route('metasD') }}"
	var d = [];
	d['v_vendedores'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_vendedores) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
</script>
<script src="{{ asset('js/vendedores/vendedores.js') }}"></script>
@endsection