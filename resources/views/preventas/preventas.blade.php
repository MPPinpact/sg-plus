@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
	.ErrorRut{
		color:#E02121;
		font-size: 10px;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Preventas Registradas
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<button style="float:left;" type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#ModalBoletaPreventa">
								Plantilla Boletas
							</button>

							<button style="float:right;" name="agregar" id="agregar" type="button" class="btn btn-primary waves-effect waves-light">
								<span>Agregar</span>
                			</button>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaPreventas" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
					<div class="col-md-12">
						<button style="float:right;" name="btn-list" id="btn-list" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Listado de Preventas</span>
            			</button>
					</div>
				</div>
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#Tabdetalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Cabecera
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="aimpuestos" class="nav-link" data-toggle="tab" href="#TabImpuestos" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
			                </div>
		                    <!-- Tab panes -->
							<br><br>
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="Tabdetalles" role="tabpanel">
									{!! Form::open(['id'=>'FormPreventas','autocomplete' => 'off']) !!}
									{!! Form::hidden('idPreVenta', '', [
									'id'            => 'idPreVenta',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<input type="hidden" name="IdVendedor" id="IdVendedor" value="1">
									<input type="hidden" name="IdLocal" id="IdLocal" value="7">
									<input type="hidden" name="IdCaja" id="IdCaja" value="1">
									<div class="row">
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaPreVenta" name="FechaPreVenta" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaPreVenta">Fecha Preventa</label>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUTCliente">RUT Cliente</label>
							                    <small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-7">
											<div class="md-input-wrapper">
												<input type="hidden" name="IdCliente" id="IdCliente">
												<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control  md-static" maxlength="250" readonly />
												<label for="NombreCliente">Nombre Cliente</label>
											</div>
										</div> 
										
									</div>
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input style="text-align:right;" id="TotalPreVenta" name="TotalPreVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<div style="float: right;">
													<label for="TotalPreVenta" style="color:#40C4FF">Total Preventa</label>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div align="center">
										<div class="pull-rigth">
											<div id="div-mod" class="divBotones">
												<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
													Modificar
												</button>
											</div>
											<div id="div-acep" class="divBotones" style="display:none;">
												<button id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
													Cancelar
												</button>
					                			<button id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
													Continuar
					                			</button>
											</div>
										</div>
									</div>
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" id="TabImpuestos" role="tabpanel">
									<div>
										<div class="col-md-12">
											<button name="agregarC" id="agregarC" style="float:right;" type="button" class="btn btn-primary btn-icon waves-effect waves-light" data-toggle="modal" data-target="#ModalDetalleCompra">
											   <i class="icofont icofont-plus"></i>
											</button>
										</div>
										<br />
										<div class="col-md-12 table-responsive">
											<table id="tablaDetalles" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
										<br />
										<div class="row">
											<div class="col-sm-3">
												<div class="pull-right">
													<div class="md-input-wrapper">
														<input id="TotalPreVentaDetalle" name="TotalPreVentaDetalle" type="text" class="md-form-control md-static" maxlength="250" readonly />
														<label for="TotalPreVentaDetalle">Total Pre-Venta</label>
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
		</div>
	</div>
</div>
<!-- Modal Proveedor -->
<div class="modal fade modal-flex" id="ModalProveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            	<h6 class="modal-title">REGISTRO PROVEEDOR</h6>
            </div>
            <div class="modal-body">
            	{!! Form::open(['id'=>'FormProveedorNew','autocomplete' => 'off']) !!}
            	<div class="row">
					<div class="col-sm-6">
						<div class="md-input-wrapper">
							<input id="RUTProveedor2" name="RUTProveedor2" type="text" class="md-form-control md-static" maxlength="250" readonly/>
							<label for="RUTProveedor2">RUT Proveedor</label>
		                    <small id="ErrorRut2" class="rut-error"></small>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="md-input-wrapper">
							<input id="NombreFantasia2" name="NombreFantasia2" type="text" class="md-form-control md-static" maxlength="250"/>
							<label for="NombreFantasia2">Nombre Fantasía</label>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelarM" class="btn btn-inverse-primary waves-effect waves-light" data-dismiss="modal">Cancelar</button>
                <button type="button" id="aceptarM" class="btn btn-primary waves-effect waves-light">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detalle Compra -->
<div class="modal fade" id="ModalDetalleCompra" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModal" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormDetalle','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdPreVenta2" id="IdPreVenta2">
					<input type="hidden" name="IdDetallePreVenta" id="IdDetallePreVenta">
					<input type="hidden" name="IdProducto" id="IdProducto">	
					<input type="hidden" id="FactorImpuesto" name="FactorImpuesto">
					<input type="hidden" id="ValorImpuestos" name="ValorImpuestos">
					<input type="hidden" id="MontoDescuento" name="MontoDescuento">
					<input type="hidden" id="ValorUnitarioFinal" name="ValorUnitarioFinal">					
					<div class="row">
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="CodigoBarra" name="CodigoBarra" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="CodigoBarra">Producto</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="NombreProducto" name="NombreProducto" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="NombreProducto">Nombre Producto</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<select name="IdUnidadMedida" id="IdUnidadMedida" class="md-disable md-valid md-static" disabled></select>
								<label for="IdUnidadMedida">Unidad de medida</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="CantidadPreVenta" name="CantidadPreVenta" type="text" class="md-form-control md-static" maxlength="10" readonly />
								<label for="CantidadPreVenta">Cantidad</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="ValorUnitarioVenta" name="ValorUnitarioVenta" type="text" class="md-form-control md-static" maxlength="10" readonly />
								<label for="ValorUnitarioVenta">Valor Unitario</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="TotalLinea" name="TotalLinea" type="text" class="md-form-control md-static" maxlength="10" readonly />
								<label for="TotalLinea">Total Linea</label>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
            </div>
            <div class="modal-footer">
				<div align="center">
					<div class="pull-rigth">
						<div id="divBotonM" style="display:none;">
							<button id="modificarC" type="button" class="btn btn-primary waves-effect waves-light">
								Modificar
							</button>
						</div>
						<div id="divBotonesAC" style="display:none;">
							<button id="cancelarC" type="button" class="btn btn-inverse-primary waves-effect waves-light">
								Cancelar
							</button>
							<button id="guardarC"  type="button" class="btn btn-primary waves-effect waves-light">
								Guardar
							</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>


<!-- modal boleta             -->
<div class="modal fade" id="ModalBoletaPreventa" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Boleta de Preventa</h4>
            </div>
            <div class="modal-body" style="font-size:10px;height:350px;width:auto;border:1px solid #ddd;background:#f1f1f1;overflow-y: scroll;overflow-x:hidden;">
            	<center>
            		<div id="CuerpoBoleta" style="height:auto;"></div>
            	</center>
            </div>
            <div class="modal-footer">
	        	<button id="PrintPre" type="button" class="btn btn-default waves-effect ">Imprimir</button>
	        	<button type="button" class="btn btn-default waves-effect ">PDF</button>
	        	<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script Language="Javascript">
	var ruta = "{{ URL::route('preventas') }}"
	var rutaBC = "{{ URL::route('preventabc') }}"
	var rutaA = "{{ URL::route('activarPre') }}"
	var rutaB = "{{ URL::route('preventab') }}"
	var rutaBPD = "{{ URL::route('preventabpd') }}"
	var rutaDC = "{{ URL::route('preventadc') }}"
	var rutaBDC = "{{ URL::route('preventabdc') }}"
	var rutaCP = "{{ URL::route('preventacp') }}"
	
	var rutaBE = "{{ URL::route('comprabe') }}"
	var rutaBB = "{{ URL::route('comprabb') }}"
	var rutaBCs = "{{ URL::route('comprabc') }}"
	var rutaCDA = "{{ URL::route('preventada') }}"
	var rutaVDB = "{{ URL::route('boletaV') }}"

	

	var d = [];
	d['v_preventas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_preventas) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_unidad_medida'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad_medida) }}'));
</script>
<script src="{{ asset('js/preventas/preventas.js') }}"></script>
@endsection
