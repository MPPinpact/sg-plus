@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 3)!important;
	}
	.ErrorRut{
		color:#E02121;
		font-size: 10px;
	}	
</style>


<div class="row">
	<div class="col-md-12 divCajasDiaras">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Cajas Diarias del Local
	        		</h5>
                </center>
	        </div>
			<div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
                			<a  href="#" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Nueva Caja</span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="#" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Cerrar Caja Actual</span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumen') }}" style="float:left;" name="botonCDR" id="botonCDR" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Resumen Caja </span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaDetalle') }}" style="float:left;" name="botonCDD" id="botonCDD" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Detalle Caja </span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumenVenta') }}" style="float:left;" name="botonCDRV" id="botonCDRV" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Resumen Venta</span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaDetalleVenta') }}" style="float:left;" name="botonCDDV" id="botonCDDV" class="btn btn-inverse-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Detalle Venta</span>
							</a>
						</div>
					</div>
					<br />
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="row">
	<div class="col-md-7">
	    <div class="card">
	        <div class="card-block">
				<div class="col-md-12 table-responsive">
					<table id="tablaCajaDiariaResumen" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
				</div>
	        </div>
		</div>
	</div>
</div>

<div class="row">
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
							<span>Listado de Ventas</span>
            			</button>
					</div>
				</div>
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="aCabecera" class="nav-link active" data-toggle="tab" href="#TabCabecera" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Cabecera
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="aDetalles" class="nav-link" data-toggle="tab" href="#TabDetalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalle de la Venta
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
									<li class="nav-item">
			                            <a id="aPagos" class="nav-link" data-toggle="tab" href="#TabPagos" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Información de Pago
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
			                </div>
		                    <!-- Tab panes -->
							<br /><br />
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="TabCabecera" role="tabpanel">
									{!! Form::open(['id'=>'FormVentas','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdVenta', '', [
									'id'            => 'IdVenta',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<input type="hidden" name="IdVendedor" id="IdVendedor" value="1">
									<input type="hidden" name="IdLocal" id="IdLocal" value="7">
									<input type="hidden" name="IdCaja" id="IdCaja" value="1">
									<input type="hidden" name="IdEstadoVenta" id="IdEstadoVenta" value="0">
									<div class="row">
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaVenta" name="FechaVenta" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaVenta">Fecha Venta</label>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUTCliente">RUT Cliente</label>
							                    <small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="md-input-wrapper">
												<input type="hidden" name="IdCliente" id="IdCliente">
												<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control  md-static" maxlength="250" readonly />
												<label for="NombreCliente">Nombre Cliente</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="TotalVenta" name="TotalVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="TotalVenta">Total Venta</label>
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
		                        <div class="tab-pane" id="TabDetalles" role="tabpanel">
									<div>
										<div class="col-md-12">
											<button name="agregarC" id="agregarC" style="float:right;" type="button" class="btn btn-primary btn-icon waves-effect waves-light" data-toggle="modal" data-target="#ModalDetalleVenta">
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
													<div class="md-input-wrapper" >
														<input id="TotalVentaDetalle" name="TotalVentaDetalle" type="text" class="md-form-control md-static" maxlength="250" readonly />
														<label for="TotalVentaDetalle">Total Venta</label>
													</div>
												</div>
											</div>
										</div>
									</div>
		                        </div>
								<div class="tab-pane" id="TabPagos" role="tabpanel">
									<div class="row">
										<div class="col-sm-5">
											<div class="row">
												<div class="col-sm-6">
													<button name="pagoEfectivo" id="pagoEfectivo" class="btn-xlg waves-effect waves-light btn-primary btn-block"><i class="icofont icofont-cur-dollar"></i> Efectivo / Cash </button>
												</div>
												<div class="col-sm-6">
													<button name="botonPagoCredito" id="botonPagoCredito" class="btn-xlg waves-effect waves-light btn-primary btn-block"><i class="icofont icofont-ebook">	   </i> Crédito Interno</button>	
												</div>
											</div>
											<br />
											<div class="row">
												<div class="col-sm-6">
													<button name="botonPagoTD" id="botonPagoTD" class="btn-xlg waves-effect waves-light btn-warning btn-block"><i class="icofont icofont-credit-card"></i> Tarjeta  Debito</button>
												</div>
												<div class="col-sm-6">
													<button name="botonPagoTC" id="botonPagoTC" class="btn-xlg waves-effect waves-light btn-info btn-block"><i class="icofont icofont-mastercard">    </i> Tarjeta Crédito</button>
												</div>
											</div>
											
											<br /><br /><br /><br />
											
											<div class="row">
												<div class="col-sm-6">
													<button name="botonCancelarVenta" id="botonCancelarVenta" class="btn-xlg waves-effect waves-light btn-danger btn-block"><i class="icofont icofont-ui-close"> </i> Cancelar Venta</button>
												</div>
												<div class="col-sm-6">
													<button name="botonFinalizarVenta" id="botonFinalizarVenta" class="btn-xlg waves-effect waves-light btn-success btn-block"><i class="icofont icofont-ui-check"></i> Finalizar Venta</button>
												</div>
											</div>
										</div>
										<div class="col-sm-1">
										
										</div>
										<div class="col-sm-6">
											<table id="tablaPagos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
											
											<div class="row">
												<div class="col-sm-4">
													<div class="md-input-wrapper" >
														<input id="TotalPagado" name="TotalPagado" type="text" class="md-form-control md-static" maxlength="250" />
														<label for="TotalPagado">Total Pagado</label>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="md-input-wrapper" >
														<input id="TotalVentaPago" name="TotalVentaPago" type="text" class="md-form-control md-static" maxlength="250" />
														<label for="TotalVentaPago">Total Venta</label>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="md-input-wrapper" >
														<input id="SaldoPago" name="SaldoPago" type="text" class="md-form-control md-static" maxlength="250"  />
														<label for="SaldoPago">Saldo x Pagar</label>
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


<!-- Modal Detalle Compra -->
<div class="modal fade" id="ModalDetalleVenta" tabindex="-1" role="dialog">
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
					<input type="hidden" name="IdVenta2" id="IdVenta2">
					<input type="hidden" name="IdDetalleVenta" id="IdDetalleVenta">
					<input type="hidden" name="IdProducto" id="IdProducto">	
					<input type="hidden" id="FactorImpuesto" name="FactorImpuesto">
					<input type="hidden" id="ValorImpuestos" name="ValorImpuestos">
					<input type="hidden" id="MontoDescuento" name="MontoDescuento">
					<input type="hidden" id="ValorUnitarioFinal" name="ValorUnitarioFinal">					
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
								<input id="CantidadVenta" name="CantidadVenta" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="CantidadVenta">Cantidad</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="ValorUnitarioVenta" name="ValorUnitarioVenta" type="text" class="md-form-control" maxlength="10" readonly />
								<label for="ValorUnitarioVenta">Valor Unitario</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="TotalLinea" name="TotalLinea" type="text" class="md-form-control" maxlength="10" readonly />
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

<!-- Modal Agregar Pre-Venta -->
<div class="modal fade" id="ModalAgregarPreVenta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalAgregRPreVenta" class="modal-title">Agregar PreVenta</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormPreVenta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPreVenta" id="IdVentaPreVenta" value="0">
					
					<div class="row" id="InfoPreVenta">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input id="NumeroPreVenta" name="NumeroPreVenta" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroPreVenta">Número Pre-Venta</label>
							</div>
						</div>
					</div>
					
					<div class="row" >
						<div class="col-md-6">
							<button id="botonAgregarPreVenta_OK" name="botonAgregarPreVenta_OK"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								Agregar Productos
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonCancelarPreVenta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cancelar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle Pago Efectivo -->
<div class="modal fade" id="ModalDetallePagoEfectivo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalPagoEfectivo" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormFPE','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPago" id="IdVentaPago" value="">
					<input type="hidden" name="IdDetallePago" id="IdDetallePago" value="">
					<input type="hidden" name="IdFormaPago" id="IdFormaPago" value="0">
					<input type="hidden" name="IdClienteVC" id="IdClienteVC" value="0">
					
					<div class="row" id="InfoAddTC">
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="NumeroTransaccionTarjeta" name="NumeroTransaccionTarjeta" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroTransaccionTarjeta">Número Transacción</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="CodigoAprobacionTarjeta" name="CodigoAprobacionTarjeta" type="text" class="md-form-control" maxlength="250" />
								<label for="CodigoAprobacionTarjeta">Código Aprobación</label>
							</div>
						</div>
					</div>
					<div id="InfoAddCredito">
						<div class="row" >
							<div class="col-md-3">
								<div class="md-input-wrapper">
									<input id="RUTClienteCredito" name="RUTClienteCredito" type="text" class="md-form-control" maxlength="250" />
									<label for="RUTClienteCredito">RUT Cliente</label>
									<small id="ErrorRutCredito" class="rut-error"></small>
								</div>
							</div>
							<div class="col-md-9">
								<div class="md-input-wrapper">
									<input id="NombreClienteCredito" name="NombreClienteCredito" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="NombreClienteCredito">Nombre Cliente</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoAFinanciar" name="MontoAFinanciar" type="text" class="md-form-control" maxlength="250" />
									<label for="MontoAFinanciar">Monto A Financiar</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control" maxlength="250" />
									<label for="NumeroCuotasCredito">Nro de Cuotas</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="InteresMensualCredito">Interes Mensual</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="FechaPrimeraCuota" name="FechaPrimeraCuota" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="FechaPrimeraCuota">Primera Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoCuotaCredito" name="MontoCuotaCredito" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="MontoCuotaCredito">Monto Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoFinalCredito" name="MontoFinalCredito" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="MontoFinalCredito">Monto Final Crédito</label>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input id="MontoPagoEfectivo" name="MontoPagoEfectivo" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="MontoPagoEfectivo">Monto Pagado</label>
							</div>
						</div>
					</div>
					
					<div class="row" id="divBotonM_FPE" style="display:none;">						
						<div class="col-md-12">
							<button id="modificaFPE" type="button" class="btn btn-primary waves-effect waves-light btn-block">
								Modificar
							</button>
						</div>
					</div>
					<div class="row" id="divBotonAC_FPE" style="display:none;">
						<div class="col-md-6">
							<button id="guardarFPE"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								Guardar
							</button>
						</div>
						<div class="col-md-6">
							<button id="cancelarFPE" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cancelar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Cierre Venta -->
<div class="modal fade" id="ModalFinalizarVenta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-body">
				{!! Form::open(['id'=>'FormCierreVenta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPago" id="IdVentaPago" value="">
					
					<div class="row">
						<div class="col-md-12">
							<h2>¿Esta seguro que desea finalizar esta venta?</h2>
						</div>
						
					</div>
					
					<div class="row" id="divBotonAC_FV" style="display:none;">
						<div class="col-md-6">
							<button id="botonFinalizarVenta_Cancel" name="botonFinalizarVenta_Cancel" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-close"></i> 
								Cancelar Acción
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonFinalizarVenta_OK" name="botonFinalizarVenta_OK" type="button" class="btn-xlg btn-success waves-effect waves-light btn-block" >
								<i class="icofont icofont-ui-check"></i> 
								Finalizar Venta
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        
		</div>
    </div>
</div>

<!-- Modal Cancelar Venta -->
<div class="modal fade" id="ModalCancelarVenta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-body">
				{!! Form::open(['id'=>'FormCierreVenta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPago" id="IdVentaPago" value="">
					
					<div class="row">
						<div class="col-md-12">
							<h2>¿Esta seguro que desea cancelar esta venta?</h2>
						</div>
						
					</div>
					
					<div class="row" id="divBotonAC_CV" style="display:none;">
						<div class="col-md-6">
							<button id="botonCancelarVenta_Cancel" name="botonCancelarVenta_Cancel" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-close"></i> 
								Cancelar Acción
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonCancelarVenta_OK" name="botonCancelarVenta_OK" type="button" class="btn-xlg btn-warning waves-effect waves-light btn-block" >
								<i class="icofont icofont-ui-check"></i> 
								Cancelar Venta
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        
		</div>
    </div>
</div>

<script Language="Javascript">
	var rutaCD = "{{ URL::route('cajaDiariaResumen') }}";
	var d = [];
	
	d['v_cajas_diarias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_cajas_diarias) }}'));
	
</script>
<script src="{{ asset('js/ptovta/cajaDiaria.js') }}"></script>
@endsection
