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
					<h5 class="counter txt-white d-inline-block">Consulta Stock Producto</h5>
					<h6 class="f-w-100 txt-white">Permite consultar el stock de un producto</h6>
					<h6 class="f-w-100 txt-white">----</h6>                                                   
            		<a id="botonConsultaStock" name="botonConsultaStock"  style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Consultar Stock <i class="icon-action-redo"></i></a> 
					<br />
				</div>
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
            		<a id="botonPreVenta" name="botonPreVenta"  style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Ir a Pre-Ventas <i class="icon-action-redo"></i></a> 
					<!-- <a style="float:right;" href="{{ route('preventas') }}" class="btn btn-inverse-primary waves-effect waves-light">Ir a Pre-Ventas <i class="icon-action-redo"></i></a>  -->
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
					<h5 class="counter txt-white d-inline-block">Venta x Pre-Venta</h5>
					<h6 class="f-w-100 txt-white">Permite realizar una venta utilizando Pre-Ventas realizadas</h6>
					<h6 class="f-w-100 txt-white">por vendedores.</h6>                                                   
					<a id="botonVentaPreVenta" name="botonVentaPreVenta" style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Ventas x Pre-Venta <i class="icon-action-redo"></i></a>
					<!-- <a id="botonVentaRapida" name="botonVentaRapida" style="float:right;" href="{{ route('ventas') }}" class="btn btn-inverse-primary waves-effect waves-light">Ir a Ventas <i class="icon-action-redo"></i></a> -->
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
					<h5 class="counter txt-white d-inline-block">Venta Directa</h5>
					<h6 class="f-w-100 txt-white">Permite realizar una venta directa de productos</h6>
					<h6 class="f-w-100 txt-white">----</h6>                                                   
					<a id="botonVentaDirecta" name="botonVentaDirecta" style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Ventas Directa <i class="icon-action-redo"></i></a>
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
			<div class="bg-danger">
				<div class="card-block">
					<h5 class="counter txt-white d-inline-block">Pago Cuenta / Pago de Crédito Interno</h5>
					<h6 class="f-w-100 txt-white">Permite pagar/abonar un monto a la cuenta de un cliente</h6>
					<h6 class="f-w-100 txt-white">Se necesita el Nro. de RUT del Cliente para realizar el pago.</h6>                                                   
            		<a id="botonPagoCredito" name="botonPagoCredito" style="float:right;" href="#!" class="btn btn-inverse-danger waves-effect waves-light">Pago de Cuenta <i class="icon-action-redo"></i></a>
					<br />
				</div>
				<!-- <div class="card-block"></div>	 -->
			</div>	
		</div>	
	</div>	

</div>

<!--Modal Consulta Stock Producto -->
<div class="modal fade" id="ModalConsultaStockProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalConsultaStockProducto" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormConsultaStockProducto','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdProductoConsultaCredito_" id="IdProductoConsultaCredito_">
					
					
					<div class="row" >
						<div class="col-md-9">
							<div class="md-input-wrapper">
								<input id="IdProductoConsultaCredito_" name="IdProductoConsultaCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="IdProductoConsultaCredito_">Códido Producto</label>
							</div>
						</div>
						<div class="col-md-3">
							<button id="botonConsultarStockProducto" name="botonConsultarStockProducto" type="button" class="btn btn-success waves-effect waves-light btn-block">
								<i class="icon-check"></i>  Consultar Stock
							</button>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="content clearfix">
								<!-- Shopping cart field et start -->
								<h3 id="basic-forms-h-0" tabindex="-1" class="title current"> Disponiblidad del Producto</h3>
								<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0" class="body current" aria-hidden="false">
									<table id="listado_productos_preventa" class="table table-striped table-responsive nowrap dataTable no-footer dtr-inline cart-page" role="grid" style="width: 100%;">
										<thead>
											<tr>
												<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 800px; text-align:left; ">Producto</th>
												<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px; text-align:center;">Stock</th>
												<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 200px; text-align:center;">Precio</th>
											 </tr>
										  </thead>
										<tbody>
											<tr class="odd">
												<td class="pro-name">
													<h6> Local 1 - Bodega Venta</h6>
												</td>
												<td class="text-center"><h6> 1</h6></td>
												<td class="text-right"><h6> $456</h6></td>
											</tr>
											<tr class="even">
												<td class="pro-name">
													<h6> Local 1 - Bodega General</h6>
												</td>
												<td class="text-center"><h6>1</h6></td>
												<td class="text-right"><h6>$689</h6></td>
											</tr>
											<tr class="odd">
												<td class="pro-name">
													<h6>  Local 2 - Bodega General</h6>
												</td>
												<td class="text-center"><h6>1</h6></td>
												<td class="text-right"><h6>$755</h6></td>
											</tr>
										</tbody>
									</table>
								</fieldset>                               <!-- Shopping cart fieldset end -->
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
<<<<<<< HEAD
								<input id="RUTClienteCredito_" name="RUTClienteCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="RUTClienteCredito_">RUT Cliente</label>
								<small id="ErrorRutCredito" class="rut-error"></small>
=======
								<input id="RUTClienteConsultaCredito" name="RUTClienteConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="RUTClienteConsultaCredito">RUT Cliente</label>
								<small id="ErrorRutConsultaCredito" class="rut-error"></small>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-9">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="NombreClienteCredito_" name="NombreClienteCredito_" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="NombreClienteCredito_">Nombre Cliente</label>
=======
								<input id="NombreClienteConsultaCredito" name="NombreClienteConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="NombreClienteConsultaCredito">Nombre Cliente</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="MontoAFinanciar_" name="MontoAFinanciar_" type="text" class="md-form-control" maxlength="250" />
								<label for="MontoAFinanciar_">Crédito Autoriizado</label>
=======
								<input id="CreditoAutorizadoConsultaCredito" name="CreditoAutorizadoConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="CreditoAutorizadoConsultaCredito">Crédito Autorizado</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="NumeroCuotasCredito_" name="NumeroCuotasCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito_">Crédito Utilizado</label>
=======
								<input id="CreditoUtilizadoConsultaCredito" name="CreditoUtilizadoConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="CreditoUtilizadoConsultaCredito">Crédito Utilizado</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="InteresMensualCredito_" name="InteresMensualCredito_" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="InteresMensualCredito_">Crédito Disponible</label>
=======
								<input id="CreditoDisponibleConsultaCredito" name="CreditoDisponibleConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="CreditoDisponibleConsultaCredito">Crédito Disponible</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="MontoAFinanciar_" name="MontoAFinanciar_" type="text" class="md-form-control" maxlength="250" />
								<label for="MontoAFinanciar_">Última Compra Realizada</label>
=======
								<input id="UltimaCompraConsultaCredito" name="UltimaCompraConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="UltimaCompraConsultaCredito">Última Compra Realizada</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="NumeroCuotasCredito_" name="NumeroCuotasCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito_">Último Pago Realizado</label>
=======
								<input id="UltimoPagoConsultaCredito" name="UltimoPagoConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="UltimoPagoConsultaCredito">Último Pago Realizado</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="InteresMensualCredito_" name="InteresMensualCredito_" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="InteresMensualCredito_">Último Monto Facturado</label>
=======
								<input id="UltimoMontoFacturadoConsultaCredito" name="UltimoMontoFacturadoConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="UltimoMontoFacturadoConsultaCredito">Último Monto Facturado</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="MontoPagoEfectivo_" name="MontoPagoEfectivo_" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="MontoPagoEfectivo_">Estado Cliente</label>
=======
								<input id="EstadoClienteConsultaCredito" name="EstadoClienteConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="EstadoClienteConsultaCredito">Estado Cliente</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
					<div class="row" id="">
						<div class="col-md-12">
							<button id="cancelarFPE" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
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
<<<<<<< HEAD
								<input id="RUTClienteCredito_" name="RUTClienteCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="RUTClienteCredito_">RUT Cliente</label>
								<small id="ErrorRutCredito" class="rut-error"></small>
=======
								<input id="RUTClientePagoCredito" name="RUTClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" />
								<label for="RUTClientePagoCredito">RUT Cliente</label>
								<small id="ErrorRutPagoCredito" class="rut-error"></small>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
						<div class="col-md-9">
							<div class="md-input-wrapper">
<<<<<<< HEAD
								<input id="NombreClienteCredito_" name="NombreClienteCredito_" type="text" class="md-form-control" maxlength="250" readonly />
								<label for="NombreClienteCredito_">Nombre Cliente</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoAFinanciar_" name="MontoAFinanciar_" type="text" class="md-form-control" maxlength="250" />
								<label for="MontoAFinanciar_">Monto Facturado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito_" name="NumeroCuotasCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito_">Fecha de Vencimiento</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NumeroCuotasCredito_" name="NumeroCuotasCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="NumeroCuotasCredito_">Deuda Total</label>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito_" name="InteresMensualCredito_" type="text" class="md-form-control" maxlength="250" />
								<label for="InteresMensualCredito_">Monto a Pagar</label>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="InteresMensualCredito_" name="InteresMensualCredito_" type="check" class="md-form-control"  />
								<label for="InteresMensualCredito_">Forma de Pago</label>
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

<!--Modal Asignar Vendedor a la Pre-Venta -->
<div class="modal fade" id="ModalAsignarVendedor" role="document" style="z-index: 1060; display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6 id="spanTituloModalModalVendedor" class="modal-title">Asignar Vendedor a la Pre-Venta</h6>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'FormVendedor','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVendedor" id="IdVendedor">
					
					<div class="row" >
						<div class="col-md-8">
							<div class="md-input-wrapper">
								<input id="CodigoVendedor" name="CodigoVendedor" type="text" class="md-form-control form-control-lg  text-center" maxlength="250" />
								<label for="CodigoVendedor">Vendedor</label>
							</div>
						</div>
						<div class="col-md-4">
							<button id="botonConsultarVendedor" name="botonConsultarVendedor" type="button" class="btn btn-success waves-effect waves-light btn-block">
								<i class="icon-check"></i>  Consultar Vendedor
							</button>
						</div>
					</div>
					
					<div class="row"><br /><br /><br /></div>
					
					<div class="row" >
						<div class="col-md-12">
								<h1 class="display-4 text-center" id="NombreVendedor_DIV">¡Vendedor No Identificado!</h1>
						</div>
					</div>
					
					<div class="row"><br /><br /><br /><br /></div>
					
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCancelarAsignarVendedor" name="botonCancelarAsignarVendedor" href="#!"  type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cerrar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonAsignarVendedor" name="botonAsignarVendedor" type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-check"></i>  Asignar Vendedor
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<!--Modal Asignar Cliente a la Pre-Venta -->
<div class="modal fade" id="ModalAsignarCliente" role="document" style="z-index: 1060; display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6 id="spanTituloModalCliente" class="modal-title">Asignar Cliente a la Pre-Venta</h6>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'FormCliente','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdCliente" id="IdCliente">
					
					<div class="row" >
						<div class="col-md-8">
							<div class="md-input-wrapper">
								<input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control form-control-lg  text-center" maxlength="250" />
								<label for="RUTCliente">Cliente</label>
							</div>
						</div>
						<div class="col-md-4">
							<button id="botonConsultarCliente" name="botonConsultarCliente" type="button" class="btn btn-success waves-effect waves-light btn-block">
								<i class="icon-check"></i>  Consultar Cliente
							</button>
						</div>
					</div>
					
					<div class="row"><br /><br /><br /></div>
					
					<div class="row" >
						<div class="col-md-12">
								<h1 class="display-4 text-center" id="NombreCliente_DIV">Cliente Contado</h1>
								<h1 class="text-center" id="InfoCliente_DIV"></h1>
								<h1 class="text-center" id="InfoCliente2_DIV"></h1>
								<h1 class="text-center" id="InfoCliente3_DIV"></h1>
						</div>
					</div>
					
					<div class="row"><br /><br /><br /><br /></div>
					
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCancelarAsignarCliente" name="botonCancelarAsignarCliente" href="#!"  type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cerrar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonAsignarCliente" name="botonAsignarCliente" type="button" href="#!"  class="btn-xlg btn-success waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-check"></i>  Asignar Cliente
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<!--Modal Asignar Forma de Pago a la Pre-Venta -->
<div class="modal fade" id="ModalAsignarFP" role="document" style="z-index: 1060; display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6 id="spanTituloModalFP" class="modal-title">Asignar Forma de Pago a la Pre-Venta</h6>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'FormFormaPago','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdFormaPago" id="IdFormaPago">
										
					<div class="row">
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-6">
									<button name="botonPagoEfectivo" id="botonPagoEfectivo" class="btn-xlg waves-effect waves-light btn-primary btn-block">
										<i class="icofont icofont-cur-dollar"></i> Efectivo / Cash 
									</button>
								</div>
								<div class="col-sm-6">
									<button name="botonPagoCreditoPreVenta" id="botonPagoCreditoPreVenta"  href="!#" class="btn-xlg waves-effect waves-light btn-primary btn-block">
										<i class="icofont icofont-ebook"></i> Crédito Interno
									</button>	
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<button name="botonPagoTD" id="botonPagoTD"  href="!#" class="btn-xlg waves-effect waves-light btn-warning btn-block">
										<i class="icofont icofont-credit-card"></i> Tarjeta  Debito
									</button>
								</div>
								<div class="col-sm-6">
									<button name="botonPagoTC" id="botonPagoTC"  href="!#" class="btn-xlg waves-effect waves-light btn-info btn-block">
										<i class="icofont icofont-mastercard">    </i> Tarjeta Crédito
									</button>
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
										<input style="text-align:right;" id="TotalPagadoPreVenta" value="0" name="TotalPagadoPreVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label style="color:#40C4FF" for="TotalPagadoPreVenta">Total Pagado</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="md-input-wrapper" >
										<input style="text-align:right;" id="TotalPreVentaFP" name="TotalPreVentaFP" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label style="color:#40C4FF" for="TotalPreVentaFP">Total Venta</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="md-input-wrapper" >
										<input style="text-align:right;" id="SaldoPagoPreVenta" name="SaldoPagoPreVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label style="color:#40C4FF" for="SaldoPagoPreVenta">Saldo x Pagar</label>
										</div>
									</div>
								</div>
							</div>
						</div>										
					</div>
					
					<div class="row"><br /></div>
					
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCancelarFormaPagoPreVenta" name="botonCancelarFormaPagoPreVenta" href="#!"  type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-close"></i> Cerrar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonConfirmarFormaPagoPreVenta" name="botonConfirmarFormaPagoPreVenta" type="button" href="#!"  class="btn-xlg btn-success waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-check"></i>  Confirmar Forma de Pago
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<!-- Modal Ingreso Diferentes Formas de Pago -->
<div class="modal fade" id="ModalIngresoPago" role="document" style="z-index: 1070; display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalFormaPago" class="modal-title">Ingresar Pago</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormIngresoFP','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdPreVentaPago" id="IdPreVentaPago">
					<input type="hidden" name="IdDetallePago" id="IdDetallePago" value="">
					<input type="hidden" name="IdFormaPagoPreVenta" id="IdFormaPagoPreVenta" value="0">
					<input type="hidden" name="IdClienteVC" id="IdClienteVC" value="0">
					
					<div class="row" id="InfoAddTC">
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="NumeroTransaccionTarjeta" name="NumeroTransaccionTarjeta" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="NumeroTransaccionTarjeta">Número Transacción</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="CodigoAprobacionTarjeta" name="CodigoAprobacionTarjeta" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="CodigoAprobacionTarjeta">Código Aprobación</label>
							</div>
						</div>
					</div>
					<div id="InfoAddCredito">
						<div class="row" >
							<div class="col-md-3">
								<div class="md-input-wrapper">
									<input id="RUTClienteCredito" name="RUTClienteCredito" type="text" class="md-form-control md-static" maxlength="250" />
									<label for="RUTClienteCredito">RUT Cliente</label>
									<small id="ErrorRutCredito" class="rut-error"></small>
								</div>
							</div>
							<div class="col-md-9">
								<div class="md-input-wrapper">
									<input id="NombreClienteCredito" name="NombreClienteCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
									<label for="NombreClienteCredito">Nombre Cliente</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoAFinanciar" name="MontoAFinanciar" type="text" class="md-form-control md-static" maxlength="250" />
									<label for="MontoAFinanciar">Monto A Financiar</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control md-static" maxlength="250" />
									<label for="NumeroCuotasCredito">Nro de Cuotas</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
									<label for="InteresMensualCredito">Interes Mensual</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="FechaPrimeraCuota" name="FechaPrimeraCuota" type="text" class="md-form-control md-static" maxlength="250" readonly />
									<label for="FechaPrimeraCuota">Primera Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoCuotaCredito" name="MontoCuotaCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
									<label for="MontoCuotaCredito">Monto Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoFinalCredito" name="MontoFinalCredito" type="text" class="md-form-control md-static" maxlength="250" readonly />
									<label for="MontoFinalCredito">Monto Final Crédito</label>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input style="text-align:right;" id="MontoPagoEfectivo" name="MontoPagoEfectivo" type="text" class="md-form-control md-static" maxlength="250" />
								<div style="float: right;">
									<label for="MontoPagoEfectivo">Monto Pagado</label>
								</div>
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
							<button id="botonGuardarFormaPago"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								Guardar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonCancelarFormaPago" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
								Cancelar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Pre-Venta -->
<div class="modal fade" id="ModalPreVenta" role="dialog" style="z-index: 1050; display: none;" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalPreVenta" class="modal-title">Pre-Venta</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormPreVenta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdPreVenta" id="IdPreVenta">
					<input type="hidden" name="IdProductoPreVenta" id="IdProductoPreVenta">	
					<input type="hidden" name="TotalLineaPreVenta" id="TotalLineaPreVenta">	
					<input type="hidden" name="FechaPreVenta" id="FechaPreVenta" value="<?php echo date("Y-m-d"); ?>">	
					<input type="hidden" name="IdVendedorPreVenta" id="IdVendedorPreVenta">
					<input type="hidden" name="NombreVendedorPreVenta" id="NombreVendedorPreVenta">
					<input type="hidden" name="IdClientePreVenta" id="IdClientePreVenta">
					<input type="hidden" name="NombreClientePreVenta" id="NombreClientePreVenta">
					<input type="hidden" name="CA_ClientePreVenta" id="CA_ClientePreVenta">
					<input type="hidden" name="CU_ClientePreVenta" id="CU_ClientePreVenta">
					<input type="hidden" name="CD_ClientePreVenta" id="CD_ClientePreVenta">
					<input type="hidden" name="EstadoClientePreVenta" id="EstadoClientePreVenta">
					<input type="hidden" name="PC_ClientePreVenta" id="PC_ClientePreVenta">
					<input type="hidden" name="IdLocalPreVenta" id="IdLocalPreVenta">
					<input type="hidden" name="IdCajaPreVenta" id="IdCajaPreVenta">
					<input type="hidden" name="IdDetallePreVenta" id="IdDetallePreVenta">
					
					<div id="PreVentaStep_1" style="display: none;">
						<div class="row">
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="CodigoProductoPreVenta" name="CodigoProductoPreVenta" type="text" class="md-form-control" maxlength="250" />
									<label for="CodigoProductoPreVenta">Código</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NombreProductoPreVenta" name="NombreProductoPreVenta" type="text" class="md-form-control" maxlength="250" readonly  />
									<label for="NombreProductoPreVenta">Producto</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="PrecioProductoPreVenta" name="PrecioProductoPreVenta" type="text" class="md-form-control" maxlength="250" readonly />
									<label for="PrecioProductoPreVenta">Precio</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="CantidadProductoPreVenta" name="CantidadProductoPreVenta" type="text" class="md-form-control" maxlength="250" />
									<label for="CantidadProductoPreVenta">Cant</label>
								</div>
							</div>
							<div class="col-md-2">
								<button id="botonAgregarProductoPreVenta" name="botonAgregarProductoPreVenta" type="button" class="btn btn-success waves-effect waves-light btn-block">
									<i class="icon-check"></i>  Agregar
								</button>
							</div>
						</div>	
						
						<div class="row"> <br /> </div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="content clearfix">
									<!-- Shopping cart field et start -->
									<h3 id="basic-forms-h-0" tabindex="-1" class="title current"> Productos Pre-Venta </h3>
									<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0" class="body current" aria-hidden="false">
										<div class="col-md-12 table-responsive">
											<table id="tablaDetalles" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
											<br />
											<div class="md-input-wrapper">
												<input style="text-align:right;" id="TotalPreVenta_" name="TotalPreVenta_" type="text" class="md-form-control text-right form-control-lg" maxlength="250" readonly />
												<label for="TotalPreVenta_">Total Pre-Venta</label>
											</div>
										</div>
										
										
									</fieldset><!-- Shopping cart fieldset end -->
								</div> 
							</div>
						</div>
						
						<div class="row"> <br /><br /><br /></div>
						
						<div class="row" >
							<div class="col-md-6">
								<button id="botonCancelarPreVenta" name="botonCancelarPreVenta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonContinuarPreVenta" name="botonContinuarPreVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-circled-right"> </i> Continuar Pre-Venta
								</button>
								
=======
								<input id="NombreClientePagoCredito" name="NombreClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" readonly />
								<label for="NombreClientePagoCredito">Nombre Cliente</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
<<<<<<< HEAD
					<div id="PreVentaStep_2" style="display: none;" >
						<div class="row">
							<div class="col-md-12">
								<div class="md-input-wrapper">
									<input id="TotalPreVenta" name="TotalPreVenta" type="text" class="md-form-control text-right form-control-lg" maxlength="250" readonly />
									
									<label for="TotalVentaVR">Total Pre-Venta</label>
								</div>
							</div>
						</div>
						
						<div class="row"> <br /> </div>	
						
						<div class="row">
							<div class="col-md-4">
								<label for="botonVendedorPreVenta"> Ingrese Vendedor <i class="icofont icofont-business-man"> </i></label>
								<button id="botonVendedorPreVenta" name="botonVendedorPreVenta"  href="#!"   type="button" data-toggle="modal" data-target="#meta-Modal" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-business-man"> </i>  Vendedor
								</button>
							</div>
							<div class="col-md-4">
								<label for="botonClientePreVenta"> Seleccione Cliente <i class="icofont icofont-ui-user"> </i></label>
								<button id="botonClientePreVenta" name="botonClientePreVenta" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-user"> </i> Cliente Contado
								</button>
							</div>
							<div class="col-md-4">
								<label for="botonFormaPagoPreVenta"> Forma de Pago <i class="icofont icofont-coins"> </i></label>
								<button id="botonFormaPagoPreVenta" name="botonFormaPagoPreVenta" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-coins"> </i> Contado
								</button>
							</div>
						</div>
						
						<div class="row"> <br /> <br /> <br /> </div>						
						
						<div class="row" >
							<div class="col-md-4">
								<button id="botonVolverPreVenta" name="botonVolverPreVenta" type="button" class="btn-xlg btn-warning waves-effect waves-light btn-block">
									<i class="icofont icofont-circled-left"> </i> Volver
								</button>
							</div>
							<div class="col-md-4">
								<button id="botonCancelarPreVenta" name="botonCancelarPreVenta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-4">
								<button id="botonFinalizarPreVenta" name="botonFinalizarPreVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-check"></i> Finalizar 
								</button>
=======
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoFacturadoClientePagoCredito" name="MontoFacturadoClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" readonly/>
								<label for="MontoFacturadoClientePagoCredito">Monto Facturado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="FechaVencimientoClientePagoCredito" name="FechaVencimientoClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" readonly/>
								<label for="FechaVencimientoClientePagoCredito">Fecha de Vencimiento</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="DeudaTotalClientePagoCredito" name="DeudaTotalClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" readonly />
								<label for="DeudaTotalClientePagoCredito">Deuda Total</label>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoClientePagoCredito" name="MontoClientePagoCredito" type="text" class="md-form-control md-valid" maxlength="250" />
								<label for="MontoClientePagoCredito">Monto a Pagar</label>
							</div>
						</div>
						
						<div class="col-md-8">
							<div class="md-input-wrapper">
								<select name="IdFormaPagoCredito" id="IdFormaPagoCredito" class="md-disable md-valid"></select>
								<label for="InteresMensualCredito">Forma de Pago</label>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
							</div>
						</div>
					</div>
					
<<<<<<< HEAD
=======
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCanelarPago" name="botonCanelarPago" type="button" data-dismiss="modal" class="btn-xlg btn-danger waves-effect waves-light  btn-block">
								Cancelar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonPagarCuenta" name="botonPagarCuenta" type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
								Pagar
							</button>
						</div>
					</div>	
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal Venta Directa -->
<div class="modal fade" id="ModalVentaDirecta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalVentaDirecta" class="modal-title">Venta Directa</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormVentaDirecta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaDirecta" id="IdVentaPreVenta" value="0">
					
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
													<table id="listado_productos_venta_directa" class="table table-striped table-responsive nowrap dataTable no-footer dtr-inline cart-page" role="grid" style="width: 100%;">
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
								<button id="botonCancelarVentaDirecta" name="botonCancelarVentaDirecta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonContinuarVentaDirecta" name="botonContinuarVentaDirecta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
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

<!-- Modal Venta Pre-Venta -->
<div class="modal fade" id="ModalVentaPreVenta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
            	</button>
            	<h6 id="spanTituloModalVentaPreVenta" class="modal-title">Venta x PreVenta</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormVentaPre-Venta','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdVentaPreVenta" id="IdVentaPreVenta" value="0">
					
					<div id="VentaPreVentaStep_1" style="display: none;">
						<div class="row">
							<div class="col-md-9">
								<div class="md-input-wrapper">
									<input id="IdPreVentaVenta" name="IdPreVentaVenta" type="text" class="md-form-control" maxlength="250" />
									<label for="IdPreVentaVenta">Nro. Pre-Venta</label>
								</div>
							</div>
							<div class="col-md-3">
								<button id="botonAgregarPreVenta" name="botonAgregarPreVenta" type="button" class="btn btn-success waves-effect waves-light btn-block">
									<i class="icon-check"></i>  Agregar PreVenta 
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
								<button id="botonCancelarVentaPreVenta" name="botonCancelarVentaPreVenta" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonContinuarVentaPreVenta" name="botonContinuarVentaPreVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-play"> </i> Continuar Venta
								</button>
								
							</div>
						</div>
					</div>
					
					<div id="VentaPreVentaStep_2" style="display: none;" >
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
<<<<<<< HEAD

<script Language="Javascript">
var rutaBPD = "{{ URL::route('preventabpd') }}"
var rutaPV = "{{ URL::route('addProductPV') }}"
var rutaBV = "{{ URL::route('buscarVen') }}"
var rutaBC = "{{ URL::route('preventabc') }}"
var rutaFP = "{{ URL::route('preventaRP')  }}"
var rutaEP = "{{ URL::route('preventaEP') }}"
var rutaPVC = "{{ URL::route('ventasPVC')  }}"
var rutaBCC = "{{ URL::route('ventasBCC')  }}"
</script>

=======
<script Language="Javascript">
	var rutaBC = "{{ URL::route('buscarCDC') }}"
	var rutaPC = "{{ URL::route('pagarCuenta') }}"
	var d = [];
	d['v_formas_pago'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_formas_pago) }}'));
	console.log(d);
</script>
>>>>>>> a3dc6e8faab70b548b92309d5599afc072b194ac
<script src="{{ asset('js/ptovta/ptovta.js') }}"></script>
<script src="{{ asset('js/ptovta/ventaRapida.js') }}"></script>
@endsection
