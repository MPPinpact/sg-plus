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
	a{
	  color: #FFF;
	}
</style>

<div class="row">
	
	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-success">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Caja Diaria</h5>
					<h6 class="f-w-100 txt-white">Módulo de Caja Diaria </h6>
					<h6 class="f-w-100 txt-white">Permite abrir y cerrar la caja diaria</h6>        
					
					<a style="float:right;" href="{{ route('cajaDiaria') }}" class="btn btn-inverse-success waves-effect waves-light " >Ir a Caja Diaria <i class="icon-action-redo"></i></a>
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>	

	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-warning">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Resumen Venta Día</h5>
					<h6 class="f-w-100 txt-white">Visualización del Resumen de las Ventas del dia</h6>
					<h6 class="f-w-100 txt-white">----</h6>                                                   
            		<a style="float:right;" href="{{ route('cajaDiariaResumen') }}" class="btn btn-inverse-warning waves-effect waves-light">Ir a Resumen Venta Diaria <i class="icon-action-redo"></i></a>
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>	
	
	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-primary">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Pre-Venta</h5>
					<h6 class="f-w-100 txt-white">Permite ingresar una Pre-Venta / Cotización</h6>
					<h6 class="f-w-100 txt-white">----</h6>                                                   
            		<a style="float:right;" href="{{ route('preventas') }}" class="btn btn-inverse-primary waves-effect waves-light">Ir a Pre-Ventas <i class="icon-action-redo"></i></a> 
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>	
	
	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-primary">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Venta</h5>
					<h6 class="f-w-100 txt-white">Permite realizar una venta rápida de productos</h6>
					<h6 class="f-w-100 txt-white">----</h6>                                                   
					<a id="botonVentaRapida" name="botonVentaRapida" style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Ventas Rápida <i class="icon-action-redo"></i></a>
					<!-- <a id="botonVentaRapida" name="botonVentaRapida" style="float:right;" href="{{ route('ventas') }}" class="btn btn-inverse-primary waves-effect waves-light">Ir a Ventas <i class="icon-action-redo"></i></a> -->
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>

	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-danger">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Consulta Límite Crédito</h5>
					<h6 class="f-w-100 txt-white">Permite consultar las condiciones créditicias de un cliente </h6>
					<h6 class="f-w-100 txt-white">Se requiere el Nro. de RUT del Cliente.</h6>                                                   
            		<a id="botonConsultaCredito" name="botonConsultaCredito" style="float:right;" href="#!" class="btn btn-inverse-danger waves-effect waves-light">Consultar Crédito Disponible <i class="icon-action-redo"></i></a>
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>		
	
	<div class="col-lg-4 grid-item">
		<div class="card">
			<div class="bg-success">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Pago Cuenta / Pago de Crédito Interno</h5>
					<h6 class="f-w-100 txt-white">Permite pagar/abonar un monto a la cuenta de un cliente</h6>
					<h6 class="f-w-100 txt-white">Se necesita el Nro. de RUT del Cliente para realizar el pago.</h6>                                                   
            		<a id="botonPagoCredito" name="botonPagoCredito" style="float:right;" href="#!" class="btn btn-inverse-success waves-effect waves-light">Pago de Cuenta <i class="icon-action-redo"></i></a>
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>	

</div>


<!--Modal Consulta Crédito Clientes  -->
<div class="modal fade" id="ModalConsultaCreditoCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalCreditoCliente" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormConsultaCredito','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdClienteConsultaCredito" id="IdClienteConsultaCredito" value="">
					
					
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
								<label for="MontoAFinanciar">Crédito Autoriizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito">Crédito Utilizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="InteresMensualCredito">Crédito Disponible</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoAFinanciar" name="MontoAFinanciar" type="text" class="md-form-control" maxlength="250" />
								<label for="MontoAFinanciar">Última Compra Realizada</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito">Último Pago Realizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="InteresMensualCredito">Último Monto Facturado</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input id="MontoPagoEfectivo" name="MontoPagoEfectivo" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="MontoPagoEfectivo">Estado Cliente</label>
							</div>
						</div>
					</div>
					
					<div class="row" id="">
						<div class="col-md-12">
							<button id="cancelarFPE" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cerrar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Pago Credito Interno Clientes -->
<div class="modal fade" id="ModalPagoCreditoCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalPagoCredito" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormPagoCredito','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdClientePagoCredito" id="IdClientePagoCredito" value="">
					
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
								<label for="MontoAFinanciar">Monto Facturado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito">Fecha de Vencimiento</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito">Deuda Total</label>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control" maxlength="250" />
								<label for="InteresMensualCredito">Monto a Pagar</label>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito" name="InteresMensualCredito" type="check" class="md-form-control"  />
								<label for="InteresMensualCredito">Forma de Pago</label>
							</div>
						</div>
						
					</div>
					
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCanelarPago" name="botonCanelarPago" type="button" class="btn-xlg btn-danger waves-effect waves-light  btn-block">
								Cancelar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonPagarCuenta" name="botonPagarCuenta" type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								Pagar
							</button>
						</div>
					</div>	
					
				{!! Form::close() !!}
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Venta Rápida -->
<div class="modal fade" id="ModalVentaRapida" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalVentaRapida" class="modal-title">Venta Rádipa</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormVentaRapida','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPreVenta" id="IdVentaPreVenta" value="0">
					
					<div id="VentaRapidaStep_1" style="display: none;">
						<div class="row">
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="CodigoProducto" name="CodigoProducto" type="text" class="md-form-control" maxlength="250" />
									<label for="NumeroPreVenta">Código</label>
								</div>
							</div>
							<div class="col-md-5">
								<div class="md-input-wrapper">
									<input id="CodigoProducto" name="CodigoProducto" type="text" class="md-form-control" maxlength="250" />
									<label for="NumeroPreVenta">Producto</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="md-input-wrapper">
									<input id="CodigoProducto" name="CodigoProducto" type="text" class="md-form-control" maxlength="250" />
									<label for="NumeroPreVenta">Precio</label>
								</div>
							</div>
							<div class="col-md-2">
								<button id="botonAgregarProducto" name="botonAgregarProducto" type="button" class="btn btn-success waves-effect waves-light btn-block">
									Agregar<i class="icon-check"></i> 
								</button>
							</div>
						</div>	
						
						<div class="row">
							<div class="col-md-12">
								<div id="wizard">
									<section>	
										<form class="wizard-form wizard clearfix" id="basic-forms" action="#" role="application">
											<div class="content clearfix">
												<!-- Shopping cart field et start -->
												<h3 id="basic-forms-h-0" tabindex="-1" class="title current"> Listado de Compras </h3>
												<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0" class="body current" aria-hidden="false">
													<table id="e-product-list" class="table table-striped table-responsive nowrap dataTable no-footer dtr-inline cart-page" role="grid" style="width: 100%;">
														<thead>
															<tr>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 1023px;">Producto</th>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 153px;">Precio</th>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Cantidad</th>
																<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 134px;text-align:center">Action</th>
															 </tr>
														  </thead>
														<tbody>
															<tr class="odd">
																<td class="pro-name">
																	<h6>Man's cloth</h6>
																	<span>Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
																</td>
																<td>$456</td>
																<td class="text-center">1</td>
																<td class="action-icon text-center">
																	<a href="#!" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="icofont icofont-delete-alt"></i></a>
																</td>
															</tr>
															<tr class="even">
																<td class="pro-name">
																	<h6> Cosmetic </h6>
																	<span>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens</span>
																</td>
																<td>$689</td>
																<td class="text-center">1</td>
																<td class="action-icon text-center">
																	<a href="#!" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="icofont icofont-delete-alt"></i></a>
																</td>
															</tr>
															<tr class="odd">
																<td class="pro-name">
																	<h6> Jacket man </h6>
																	<span>Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
																</td>
																<td>$755</td>
																<td class="text-center">1</td>
																<td class="action-icon text-center">
																	<a href="#!" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="icofont icofont-delete-alt"></i></a>
																</td>
															</tr>
															<tr class="even">
																<td class="pro-name">
																	<h6> Footwear Man </h6>
																	<span>Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</span>
																</td>
																<td>$989</td>
																<td class="text-center">2</td>
																<td class="action-icon text-center">
																	<a href="#!" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="icofont icofont-delete-alt"></i></a>
																</td>
															</tr>
														</tbody>
													</table>
												</fieldset>                               <!-- Shopping cart fieldset end -->
											</div> 
										</form>
									</section>
								</div>
							</div>
						</div>
						
						<div class="row" >
							<div class="col-md-6">
								<button id="botonCancelarPreVenta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonContinuarVenta" name="botonContinuarVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-play"> </i> Continuar Venta
								</button>
								
							</div>
						</div>
					</div>
					
					<div id="VentaRapidaStep_2" style="display: none;" >
						<div class="row">
							<div class="col-md-12">
								<div class="md-input-wrapper">
									<input id="TotalVentaVR" name="TotalVentaVR" type="text" class="md-form-control text-right form-control-lg" maxlength="250" />
									
									<label for="TotalVentaVR">Total Venta</label>
								</div>
							</div>
						</div>
						
						<div class="row"> <br /> </div>	
						
						<div class="row">
							<div class="col-md-4">
								<label for="botonVendedor"> Ingrese Vendedor <i class="icofont icofont-business-man"> </i></label>
								<button id="botonVendedor" name="botonVendedor" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-business-man"> </i>  Vendedor
								</button>
							</div>
							<div class="col-md-4">
								<label for="botonCliente"> Seleccione Cliente <i class="icofont icofont-ui-user"> </i></label>
								<button id="botonCliente" name="botonCliente" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-user"> </i> Cliente
								</button>
							</div>
							<div class="col-md-4">
								<label for="botonCliente"> Forma de Pago <i class="icofont icofont-coins"> </i></label>
								<button id="botonCliente" name="botonCliente" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-coins"> </i> Forma de Pago
								</button>
							</div>
						</div>
						
						<div class="row"> <br /> <br /> <br /> </div>						
						
						<div class="row" >
							<div class="col-md-6">
								<button id="botonCancelarVenta_2" name="botonCancelarVenta_2" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonFinalizarVenta" name="botonFinalizarVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-check"></i> Finalizar Venta
								</button>
							</div>
						</div>
					</div>
					
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle Pago Efectivo -->
<div class="modal fade" id="ModalConsultaCreditoCliente" tabindex="-1" role="dialog">
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

<script src="{{ asset('js/ptovta/ptovta.js') }}"></script>
<script src="{{ asset('js/ptovta/ventaRapida.js') }}"></script>
@endsection
