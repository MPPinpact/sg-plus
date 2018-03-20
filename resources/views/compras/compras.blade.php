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
	        			Listado de Compras Registrados
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
							<table id="tablaCompras" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
									{!! Form::open(['id'=>'FormCompras','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCompra', '', [
									'id'            => 'IdCompra',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="IdOrdenCompra" name="IdOrdenCompra" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="IdOrdenCompra">Nro OC</label>
											</div>
										</div>
										<div class="col-sm-3">
											<input type="hidden" name="IdProveedor" id="IdProveedor">
											<div class="md-input-wrapper">
												<input id="RUTProveedor" name="RUTProveedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUTProveedor">RUT Proveedor</label>
							                    <small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="md-input-wrapper">
												<input id="NombreFantasia" name="NombreFantasia" type="text" class="md-form-control  md-static" maxlength="250" readonly />
												<label for="NombreFantasia">Nombre Proveedor</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<input type="hidden" name="idEmpresa" id="idEmpresa">
											<div class="md-input-wrapper">
												<input id="RUT" name="RUT" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUT">RUT Comprador</label>
							                    <small id="ErrorRut3" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="md-input-wrapper">
												<input id="NombreFantasiaE" name="NombreFantasiaE" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="NombreFantasiaE">Nombre Comprador</label>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<select name="IdLocal" id="IdLocal" class="md-disable md-valid" disabled></select>
												<label for="IdLocal">Locales</label>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<select name="IdBodega" id="IdBodega" class="md-disable md-valid" disabled></select>
												<label for="IdBodega">Bodega</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<select name="TipoDTE" id="TipoDTE" class="md-disable md-valid" disabled></select>
												<label for="TipoDTE">Tipo DTE</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="FolioDTE" name="FolioDTE" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="FolioDTE">Folio DTE</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaDTE" name="FechaDTE" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaDTE">Fecha DTE</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaVencimiento" name="FechaVencimiento" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaVencimiento">Fecha Vencimiento</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaPago" name="FechaPago" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaPago">Fecha Pago</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalNeto" name="TotalNeto" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="TotalNeto">Total Neto</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalDescuentos" name="TotalDescuentos" type="text" class="md-form-control md-static" maxlength="20" readonly />
												<label for="TotalDescuentos">Total Descuentos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalImpuestos" name="TotalImpuestos" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="TotalImpuestos">Total Impuestos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalCompra" name="TotalCompra" type="text" class="md-form-control md-static" maxlength="20" readonly />
												<label for="TotalCompra">Total Compra</label>
											</div>
										</div>
									</div>
									<diw class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="EstadoCompra" id="EstadoCompra" class="md-disable md-valid" disabled></select>
												<label for="EstadoCompra">Estado Compra</label>
											</div>
										</div>
										<div class="col-sm-4"></div>
									</diw>
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
							<input id="NombreFantasia2" name="NombreFantasia2" type="text" class="md-form-control" maxlength="250"/>
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
					<input type="hidden" name="IdDetalleCompra" id="IdDetalleCompra" value="1">
					<input type="hidden" name="IdCompra2" id="IdCompra2" value="1">
					<input type="hidden" name="IdProducto" id="IdProducto" value="1">
					
					<div class="row">
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="CodigoBarra" name="CodigoBarra" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="CodigoBarra">Producto</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="NombreProducto" name="NombreProducto" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="NombreProducto">Nombre Producto</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<select name="IdUnidadMedida" id="IdUnidadMedida" class="md-disable md-valid" disabled></select>
								<label for="IdUnidadMedida">Unidad de medida</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="CantidadComprada" name="CantidadComprada" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="CantidadComprada">Cantidad</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="ValorUnitario" name="ValorUnitario" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="ValorUnitario">Valor Unitario</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="FactorImpuesto" name="FactorImpuesto" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="FactorImpuesto">Factor Impuesto</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="ValorImpuestos" name="ValorImpuestos" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="ValorImpuestos">Valor Impuestos</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoDescuento" name="MontoDescuento" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="MontoDescuento">Monto Descuento</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="ValorUnitarioFinal" name="ValorUnitarioFinal" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="ValorUnitarioFinal">Valor Unitario Final</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="TotalLinea" name="TotalLinea" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="TotalLinea">Total Linea</label>
							</div>
						</div>
						<input type="hidden" id="EstadoDetalleCompra" name="EstadoDetalleCompra" value="1">						
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

<script Language="Javascript">
	var ruta = "{{ URL::route('compras') }}"
	var rutaA = "{{ URL::route('activarCom') }}"
	var rutaB = "{{ URL::route('comprab') }}"
	var rutaBP = "{{ URL::route('comprabp') }}"
	var rutaPR = "{{ URL::route('comprapr') }}"
	var rutaBE = "{{ URL::route('comprabe') }}"
	var rutaBB = "{{ URL::route('comprabb') }}"
	var rutaBC = "{{ URL::route('comprabc') }}"
	var rutaBPD = "{{ URL::route('comprabpd') }}"
	var rutaDC = "{{ URL::route('comprardc') }}"
	var rutaBDC = "{{ URL::route('comprarbdc') }}"
	var rutaCDA = "{{ URL::route('comprada') }}"
	var d = [];
	d['v_compras'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_compras) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
	d['v_tipo_dte'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_dte) }}'));
	d['v_unidad_medida'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad_medida) }}'));
</script>
<script src="{{ asset('js/compras/compras.js') }}"></script>
@endsection