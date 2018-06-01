@extends('puntoVenta.index')
@section('content')
<?php date_default_timezone_set('America/Santiago'); ?> 
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

	#tablaPagos {
	    border-collapse: collapse;
	    width: 100%;
	}

	#tablaPagos td, #tablaPagos th {
	    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	    font-size: 25px; 
	    padding: 8px;
	}

	#tablaPagos tr:nth-child(even){background-color: #f2f2f2;}

	#tablaPagos tr:hover {background-color: #ddd;}

	#tablaPagos th {display: none;}

	$("#SelectorFormaPago *").attr("disabled", "false").on("click");

</style>

<div class="row">
    <div class="col-sm-12 p-0">
        <div class="main-header">
        	<h4>Punto de Venta</h4>
    	</div>
	</div>
</div>

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
            		<a id="botonConsultaProducto" name="botonConsultaProducto"  style="float:right;" href="#!" class="btn btn-inverse-primary waves-effect waves-light">Consultar Stock <i class="icon-action-redo"></i></a> 
            		
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
					<h5 class="counter txt-white d-inline-block">Venta de Productos</h5>
					<h6 class="f-w-100 txt-white">Permite realizar una venta de productos</h6>
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
<div class="modal fade" id="ModalConsultaStockProducto" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 1030 !important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModalConsultaStockProducto" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormConsultaStockProducto','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdProductoConsultaCredito" id="IdProductoConsultaCredito">
					<div class="row" >
						<div class="col-md-9">
							<div class="md-input-wrapper">
								<input id="CodigoProductoConsultaCredito" name="CodigoProductoConsultaCredito" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="CodigoProductoConsultaCredito">Código/Nombre/Descripción del Producto</label>
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
								<h3 id="basic-forms-h-0___" tabindex="-1" class="title current"> Disponiblidad del Producto</h3>
								<span id="NombreProductoConsulta"></span>
								<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0___" class="body current" aria-hidden="false">
									<table id="listado_productos_preventa" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
								</fieldset>
							</div> 
						</div>
					</div>
					<br>
						
					<div class="row" id="">
						<div class="col-md-12">
							<button id="cancelarBPS" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
								Cerrar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!--Modal Buscar Producto -->
<div class="modal fade" id="ModalBuscarProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModalBusquedaProducto" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormBusquedaProducto','autocomplete' => 'off']) !!}
					
					<div class="row" >
						<div class="col-md-9">
							<div class="md-input-wrapper">
								<input id="InfoProducto" name="InfoProducto" type="text" class="md-form-control md-static" maxlength="250" />
								<label for="InfoProducto">Código/Nombre/Descripción del Producto</label>
							</div>
						</div>
						<div class="col-md-3">
							<button id="botonBuscar" name="botonBuscar" type="button" class="btn btn-success waves-effect waves-light btn-block">
								Buscar Producto  <i class="icofont icofont-search"></i>
							</button>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="clearfix">
								<h3 tabindex="-1" class="title"> Productos Similares</h3>

								<table id="tablaResultadoBusquedaProducto" class="table table-striped table-hover" cellspacing="0" width="100%"></table>
								
							</div> 
						</div>
					</div>
					<br />
						
					<div class="row" id="">
						<div class="col-md-12">
							<button id="cancelarBPS" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
								Cerrar
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!--Modal STOCK Producto -->
<div class="modal fade" id="ModalStockProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-body">
				{!! Form::open(['id'=>'FormStockProducto','autocomplete' => 'off']) !!}
				<input type="hidden" name="IdProductoStock" id="IdProductoStock">
									
				<div class="row">
					<div class="col-md-12">
						<center>
							<h3 id="NombreProductoStock" tabindex="-1" class="title current"> Stock del Producto</h3>
						</center>
						<!-- <span id="NombreProductoStock"></span> -->
						<table id="tablaStockProducto" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
					</div> 
				</div>
				
				<br>
					
				<div class="row" id="">
					<div class="col-md-4">
						<button id="cerrarBodegaDestino" name="cerrarBodegaDestino" type="button" class="btn-lg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
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
<div class="modal fade" id="ModalConsultaCreditoCliente" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 1030 !important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModalCreditoCliente" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormConsultaCredito','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdClienteConsultaCredito" id="IdClienteConsultaCredito" class="ConsultaCreditoCliente">
					<div class="row" >
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="RUTClienteConsultaCredito" name="RUTClienteConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" />
								<label for="RUTClienteConsultaCredito">RUT Cliente</label>
								<small id="ErrorRutConsultaCredito" class="rut-error"></small>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="NombreClienteConsultaCredito" name="NombreClienteConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" readonly />
								<label for="NombreClienteConsultaCredito">Nombre Cliente</label>
							</div>
						</div>
						<div class="col-md-5">
							<div class="md-input-wrapper">
								<button id="bontonEstadoCliente" class="btn btn-danger waves-effect waves-light js-dynamic-disable btn-block" style="display: none;" >--------</button>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="CreditoAutorizadoConsultaCredito" name="CreditoAutorizadoConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" />
								<label for="CreditoAutorizadoConsultaCredito">Crédito Autorizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="CreditoUtilizadoConsultaCredito" name="CreditoUtilizadoConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" />
								<label for="CreditoUtilizadoConsultaCredito">Crédito Utilizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="CreditoDisponibleConsultaCredito" name="CreditoDisponibleConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" readonly />
								<label for="CreditoDisponibleConsultaCredito">Crédito Disponible</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="UltimaCompraConsultaCredito" name="UltimaCompraConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" />
								<label for="UltimaCompraConsultaCredito">Última Compra Realizada</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="UltimoPagoConsultaCredito" name="UltimoPagoConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" />
								<label for="UltimoPagoConsultaCredito">Último Pago Realizado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="UltimoMontoFacturadoConsultaCredito" name="UltimoMontoFacturadoConsultaCredito" type="text" class="md-form-control md-static ConsultaCreditoCliente" maxlength="250" readonly />
								<label for="UltimoMontoFacturadoConsultaCredito">Último Monto Facturado</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input id="EstadoClienteConsultaCredito" name="EstadoClienteConsultaCredito" type="text" class="md-form-control md-form-control-lg md-static ConsultaCreditoCliente" maxlength="250" readonly />
								<label for="EstadoClienteConsultaCredito">Estado Cliente</label>
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
<div class="modal fade" id="ModalPagoCreditoCliente" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 1030 !important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModalPagoCredito" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormPagoCredito','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdClientePagoCredito" id="IdClientePagoCredito" class="PagoCreditoM">
					<input type="hidden" name="IdCajaPC" id="IdCajaPC" class="PagoCreditoM">
					
					<div class="row" >
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<input id="RUTClientePagoCredito" name="RUTClientePagoCredito" type="text" class="md-form-control md-valid md-static PagoCreditoM" maxlength="250" />
								<label for="RUTClientePagoCredito">RUT Cliente</label>
								<small id="ErrorRutPagoCredito" class="rut-error"></small>
							</div>
						</div>
						<div class="col-md-9">
							<div class="md-input-wrapper">
								<input id="NombreClientePagoCredito" name="NombreClientePagoCredito" type="text" class="md-form-control md-static PagoCreditoM" maxlength="250" readonly />
								<label for="NombreClientePagoCredito">Nombre Cliente</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoFacturadoPagoCredito" name="MontoFacturadoPagoCredito" type="text" class="md-form-control md-static PagoCreditoM" maxlength="250" />
								<label for="MontoFacturadoPagoCredito">Monto Facturado</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="FechaVencimientoPagoCredito" name="FechaVencimientoPagoCredito" type="text" class="md-form-control md-static PagoCreditoM" maxlength="250" />
								<label for="FechaVencimientoPagoCredito">Fecha de Vencimiento</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="DeudaTotalPagoCredito" name="DeudaTotalPagoCredito" type="text" class="md-form-control md-static PagoCreditoM" maxlength="250" />
								<label for="DeudaTotalPagoCredito">Deuda Total</label>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<input id="MontoAPagarPagoCredito" name="MontoAPagarPagoCredito" type="text" class="InputMoneda md-form-control md-static PagoCreditoM" maxlength="250" />
								<label for="MontoAPagarPagoCredito">Monto a Pagar</label>
							</div>
						</div>
						
						<div class="col-md-8">
							<div class="md-input-wrapper">
								<select name="IdFormaPagoCredito" id="IdFormaPagoCredito" class="md-disable md-valid"></select>
								<label for="FormaPagoCredito">Forma de Pago</label>
							</div>
						</div>
						
					</div>
					
					<div class="row" id="">
						<div class="col-md-6">
							<button id="botonCanelarPago" name="botonCanelarPago" type="button" class="btn-xlg btn-danger waves-effect waves-light  btn-block" data-dismiss="modal">
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
<div class="modal fade" id="ModalAsignarVendedor"  data-keyboard="false" data-backdrop="static" role="document" style="z-index: 1031; display: none;">
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
								<i class="icon-check"></i>  Consultar/Asignar Vendedor
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
					
					<div class="row"  style="display: none;">
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
<div class="modal fade" id="ModalAsignarCliente" role="document"  data-keyboard="false" data-backdrop="static" style="z-index: 1031; display: none;">
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
<div class="modal fade" id="ModalAsignarFP" role="document"  data-keyboard="false" data-backdrop="static"  style="z-index: 1031; display: none;">
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
							<table id="tablaPagos_" class="table table-striped table-hover" cellspacing="0" width="100%"></table>
							
							<div class="row">
								<div class="col-sm-4">
									<div class="md-input-wrapper" >
										<input style="text-align:right;" id="TotalPagadoPreVenta_" value="0" name="TotalPagadoPreVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label style="color:#40C4FF" for="TotalPagadoPreVenta">Total Pagado</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="md-input-wrapper" >
										<input style="text-align:right;" id="TotalPreVentaFP" name="TotalPreVentaFP" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label id="lblTotalVenta" style="color:#40C4FF" for="TotalPreVentaFP">Total Venta</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="md-input-wrapper" >
										<input style="text-align:right;" id="SaldoPagoPreVenta_" name="SaldoPagoPreVenta_" type="text" class="md-form-control md-static" maxlength="250" readonly />
										<div style="float: right;">
											<label style="color:#40C4FF" for="SaldoPagoPreVenta_">Saldo x Pagar</label>
										</div>
									</div>
								</div>
							</div>
						</div>										
					</div>
					
					<div class="row"><br /><br /><br /><br /></div>
					
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
<div class="modal fade" id="ModalIngresoPago"  data-keyboard="false" data-backdrop="static" role="document" style="z-index: 1031; display: none;">
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
					<input type="hidden" name="IdFormaPagoPreVenta" id="IdFormaPagoPreVenta">
					<input type="hidden" name="IdClienteVC" id="IdClienteVC" value="0">
					
					<div class="row" id="InfoAddTC">
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="NumeroTransaccionTarjeta" name="NumeroTransaccionTarjeta" type="text" class="md-form-control md-static"   style="text-align: right; font-size: 30px; font-weight: bold;" maxlength="250" />
								<label for="NumeroTransaccionTarjeta" style="font-size: 20px; font-weight: bold;">Número Transacción</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="md-input-wrapper">
								<input id="CodigoAprobacionTarjeta" name="CodigoAprobacionTarjeta" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" />
								<label for="CodigoAprobacionTarjeta" style="font-size: 20px; font-weight: bold;">Código Aprobación</label>
							</div>
						</div>
					</div>
					<div id="InfoAddCredito">
						<div class="row" >
							<div class="col-md-3">
								<div class="md-input-wrapper">
									<input id="RUTClienteCredito" name="RUTClienteCredito" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 25px; font-weight: bold;"  maxlength="250" />
									<label for="RUTClienteCredito" style="font-size: 20px; font-weight: bold;">RUT Cliente</label>
									<small id="ErrorRutCredito" class="rut-error"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NombreClienteCredito" name="NombreClienteCredito" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 25px; font-weight: bold;"  maxlength="250" readonly />
									<label for="NombreClienteCredito" style="font-size: 20px; font-weight: bold;">Nombre Cliente</label>
								</div>
							</div>
							<div class="col-md-5">
								<div class="md-input-wrapper">
									<button id="bontonEstadoClienteVC" class="btn btn-danger waves-effect waves-light js-dynamic-disable btn-block" style="display: none;" disabled="true" >--------</button>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoAFinanciar" name="MontoAFinanciar" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" />
									<label for="MontoAFinanciar" style="font-size: 20px; font-weight: bold;">Monto A Financiar</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NumeroCuotasCredito" name="NumeroCuotasCredito" type="text" class="md-form-control md-static"   style="text-align: right; font-size: 30px; font-weight: bold;" maxlength="250" />
									<label for="NumeroCuotasCredito" style="font-size: 20px; font-weight: bold;">Nro de Cuotas</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="InteresMensualCredito" name="InteresMensualCredito" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" readonly />
									<label for="InteresMensualCredito" style="font-size: 20px; font-weight: bold;">Interes Mensual</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="FechaPrimeraCuota" name="FechaPrimeraCuota" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" readonly />
									<label for="FechaPrimeraCuota" style="font-size: 20px; font-weight: bold;">Primera Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoCuotaCredito" name="MontoCuotaCredito" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" readonly />
									<label for="MontoCuotaCredito" style="font-size: 20px; font-weight: bold;">Monto Cuota</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="MontoFinalCredito" name="MontoFinalCredito" type="text" class="md-form-control md-static"  style="text-align: right; font-size: 30px; font-weight: bold;"  maxlength="250" readonly />
									<label for="MontoFinalCredito" style="font-size: 20px; font-weight: bold;">Monto Final Crédito</label>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<input id="MontoPagoEfectivo" name="MontoPagoEfectivo" type="text" class="md-form-control  form-control-lg md-static"  style="text-align: right; font-size: 30px; font-weight: bold;" maxlength="250" />
								<label for="MontoPagoEfectivo" style="text-align: right; font-size: 20px; font-weight: bold;">Monto Pagado</label>
								<div style="float: right;">
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="row"><br /><br /><br /><br /></div>

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

<!-- Modal Selección TipoDTE -->
<div class="modal fade" id="ModalTipoDTE" role="document"  data-keyboard="false" data-backdrop="static"  style="z-index: 1031; display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6 id="spanTituloModalTipoDTE" class="modal-title">-----</h6>
			</div>
			<div class="modal-body">
				<div class="row"><br /><br /><br /><br /></div>
				<div class="row"><br /><br /><br /><br /></div>

				{!! Form::open(['id'=>'FormTipoDTE','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdTipoDTE" id="IdTipoDTE">
										
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-3">
									<button name="botonBoleta" id="botonBoleta" href="#!" class="btn-xlg waves-effect waves-light btn-primary btn-block">
										<i class="icofont icofont-ebook"></i><br>Boleta  
									</button>
								</div>
								<div class="col-sm-3">
									<button name="botonFactura" id="botonFactura" class="btn-xlg waves-effect waves-light btn-primary btn-block">
										<i class="icofont icofont-ebook"></i><br>Factura
									</button>	
								</div>
							
								<div class="col-sm-3">
									<button name="botonCI" id="botonCI" class="btn-xlg waves-effect waves-light btn-primary btn-block">
										<i class="icofont icofont-ebook"></i><br>C.I.
									</button>
								</div>
								<div class="col-sm-3">
									<button name="boton----" id="boton----" class="btn-xlg waves-effect waves-light btn-primary btn-block" disabled="true">
										<i class="icofont icofont-ebook"></i><br>------
									</button>
								</div>
							</div>
						</div>															
					</div>
					
					<div class="row"><br /><br /><br /><br /></div>
					<div class="row"><br /><br /><br /><br /></div>

					<div class="row" >
						<div class="col-md-6">
							<button id="botonCancelarTippDTE" name="botonCancelarTippDTE" href="#!"  type="button" class="btn-xlg btn-warning waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-close"></i> Volver
							</button>
						</div>
						<div class="col-md-6" style="display: none;">
							<button id="botonConfirmarTipoDTE" name="botonConfirmarTipoDTE" type="button" href="#!"  class="btn-xlg btn-success waves-effect waves-light btn-block">
								<i class="icofont icofont-ui-check"></i>  Confirmar DTE
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<!-- Modal Pre-Venta -->
<div class="modal fade" id="ModalPreVenta" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index: 1030; display: none;" >
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
					<input type="hidden" name="IdPreVentaPreVenta" id="IdPreVentaPreVenta">
					<input type="hidden" name="EstadoPreVenta" id="EstadoPreVenta">
					<input type="hidden" name="IdProductoPreVenta" id="IdProductoPreVenta">	
					<input type="hidden" name="TotalLineaPreVenta" id="TotalLineaPreVenta">	
					<input type="hidden" name="FechaPreVenta" id="FechaPreVenta" value="<?php echo date('Y-m-d'); ?>">	
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
					<input type="hidden" name="IdTipoDTEPreVenta" id="IdTipoDTEPreVenta">					
					<div id="PreVentaStep_1" style="display: none;">
						<div class="row" id="frameProductos">
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="CodigoProductoPreVenta" name="CodigoProductoPreVenta" type="text" class="md-form-control md-static" maxlength="15" />
									<label for="CodigoProductoPreVenta">Código</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="NombreProductoPreVenta" name="NombreProductoPreVenta" type="text" class="md-form-control md-static" maxlength="50" readonly  />
									<label for="NombreProductoPreVenta">Producto</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="PrecioProductoPreVenta" name="PrecioProductoPreVenta" type="text" class="md-form-control md-static" maxlength="12" readonly />
									<label for="PrecioProductoPreVenta">Precio</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="md-input-wrapper">
									<input id="CantidadProductoPreVenta" name="CantidadProductoPreVenta" type="text" class="md-form-control md-static" maxlength="6" />
									<label for="CantidadProductoPreVenta">Cant</label>
								</div>
							</div>
							<div class="col-md-2">
								<button id="botonAgregarProductoPreVenta" name="botonAgregarProductoPreVenta" type="button" class="btn btn-success waves-effect waves-light btn-block">
									<i class="icon-check"></i>  Agregar
								</button>
							</div>
						</div>

						<div class="row" id="frameNroPreVenta" style="display: none;">
							<div class="col-md-8">
								<div class="md-input-wrapper">
									<input id="NroPreVenta" name="NroPreVenta" type="text" class="md-form-control form-control-lg  md-static" maxlength="6" />
									<label id="lblNroPreVenta" for="NroPreVenta">Nro. Pre-Venta</label>
								</div>
							</div>
							<div class="col-md-4">
								<button id="botonAgregarPreVentaPV" name="botonAgregarPreVentaPV" type="button" class="btn btn-success waves-effect waves-light btn-block">
									<i class="icon-check"></i>  Recuperar Pre-Venta
								</button>
							</div>
						</div>						
						
						<div class="row"> <br /> </div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="content clearfix">
									<!-- Shopping cart field et start -->
									<div class="row">
										<div class="col-md-6">
											<h3 id="basic-forms-h-0" tabindex="-1" class="title current"> 
												Productos Pre-Venta 
											</h3>
										</div>
										<div class="col-md-6">	
											<button style="float:right;"  id="botonRecuperarPreVenta" name="botonRecuperarPreVenta" type="button" class="btn btn-inverse-danger waves-effect waves-light">
												<i class="icofont icofont-listine-dots"> </i>  Recuperar Pre-Venta
											</button>
											<button style="float:right; display:none;"  id="botonAgregarProductos" name="botonAgregarProductos" type="button" class="btn btn-inverse-danger waves-effect waves-light">
												<i class="icofont icofont-listine-dots"> </i>  Agregar Productos
											</button>
										</div>
									</div>
									
									<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0" class="body current" aria-hidden="false">
										<div class="col-md-12 table-responsive" style="max-height: 300px">
											<table id="tablaDetalles" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>											
										</div>
									</fieldset><!-- Shopping cart fieldset end -->
								</div> 
							</div>
						</div>
						
						<div class="row"> 
							<br /><br />
							<div class="col-md-12">
								<div class="md-input-wrapper">
									<input style="text-align:right;" id="TotalPreVenta_" name="TotalPreVenta_" type="text" class="md-form-control text-right form-control-lg" maxlength="250" readonly />
									<label id="lblTotalVenta_" for="TotalPreVenta_">Total Venta</label>
								</div>
							</div>
						</div>
						
						<div class="row" >
							<div class="col-md-6">
								<button id="botonCancelarPreVenta_1" name="botonCancelarPreVenta_1" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-6">
								<button id="botonContinuarPreVenta" name="botonContinuarPreVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-circled-right"> </i> Continuar Pre-Venta
								</button>
							</div>
						</div>
					</div>
					
					<div id="PreVentaStep_2" style="display: none;" >
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="TotalPreVenta" name="TotalPreVenta" type="text" class="md-form-control text-center form-control-lg md-static" style="font-size: 30px; font-weight: bold;" maxlength="250" readonly />
									
									<label  id="lblTotalVentaVR" for="TotalVentaVR" style="font-size: 15px; font-weight: bold;">Total Venta</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="TotalPagadoPreVenta" name="TotalPagadoPreVenta" type="text" class="md-form-control text-center form-control-lg md-static" style="font-size: 30px; font-weight: bold;" maxlength="250" readonly />
									
									<label  id="lblTotalPagadoPreVenta" for="TotalPagadoPreVenta" style="font-size: 15px; font-weight: bold;">Total Pagado</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="SaldoPagoPreVenta" name="SaldoPagoPreVenta" type="text" class="md-form-control text-center form-control-lg md-static" style="font-size: 30px; font-weight: bold;" maxlength="250" readonly />
									
									<label  id="lblSaldoPorPagarPreVenta" for="SaldoPagoPreVenta" style="font-size: 15px; font-weight: bold;">Saldo x Pagar</label>
								</div>
							</div>
						</div>
						<!-- Nuevas Formas de Pago -->
						<div class="row"> <br /> </div>	
						
						<div class="row" >
							<div class="col-sm-6" id="SelectorFormaPago">
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
							<div class="col-sm-6">
								<div class="col-sm-12">
									<table id="tablaPagos" class="table no-header no-footer table-striped table-hover" cellspacing="0" width="100%"></table>
								</div>	
							</div>
						</div>

						<div class="row"> <br /> <br /> </div>	

						<!-- botones de VEndedor, Clietne, Forma de Pago, TipoDTE -->
						<div class="row" style="display: none;">
							<div class="col-md-4" style="display: none; ">
								<label for="botonVendedorPreVenta"> Ingrese Vendedor <i class="icofont icofont-business-man"> </i></label>
								<button id="botonVendedorPreVenta" name="botonVendedorPreVenta"  href="#!"   type="button" data-toggle="modal" data-target="#meta-Modal" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-business-man"> </i>  Vendedor
								</button>
							</div>
							<div class="col-md-4" style="display: none; ">
								<label for="botonClientePreVenta"> Seleccione Cliente <i class="icofont icofont-ui-user"> </i></label>
								<button id="botonClientePreVenta" name="botonClientePreVenta" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-user"> </i> Cliente Contado
								</button>
							</div>
							<div class="col-md-4"  style="display: none; ">
								<label for="botonFormaPagoPreVenta"> Forma de Pago <i class="icofont icofont-coins"> </i></label>
								<button id="botonFormaPagoPreVenta" name="botonFormaPagoPreVenta" type="button" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-coins"> </i> Contado
								</button>
							</div>
						</div>

						<div class="row"> <br /> </div>

						<!-- TipoDTE -->
						<div class="row" style="display: none;">
							<div class="col-md-4" style="display: none; ">
								<label for="botonTipoDTE"> Seleccione Tipo DTE <i class="icofont icofont-copy-alt"> </i></label>
								<button id="botonTipoDTE" name="botonTipoDTE" href="#!" type="button" data-toggle="modal" data-target="#meta-Modal" class="btn-xlg btn-primary waves-effect waves-light btn-block">
									<i class="icofont icofont-copy-alt"> </i> Tipo DTE
								</button>
							</div>
							<div class="col-md-4">
								
							</div>
							<div class="col-md-4">
								
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
								<button id="botonCancelarPreVenta_2" name="botonCancelarPreVenta_2" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-close"> </i> Cancelar
								</button>
							</div>
							<div class="col-md-4">
								<button id="botonFinalizarPreVenta" name="botonFinalizarPreVenta"  type="button" class="btn-xlg btn-success waves-effect waves-light btn-block">
									<i class="icofont icofont-ui-check"></i> Imprimir Ticket 
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
<div class="modal fade" id="ModalFinalizarVenta"  data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 1031 !important;">
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
<div class="modal fade" id="ModalCancelarVenta"  data-keyboard="false" data-backdrop="static"  tabindex="-1" role="dialog" style="z-index: 1031 !important;">
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
@include('boleta.boleta')
<script Language="Javascript">
	var rutaPVBP = "{{ URL::route('preventabpd') }}"
	var rutaPVAP = "{{ URL::route('addProductPV') }}"
	var rutaRPV = "{{ URL::route('addPreVentaPV') }}"
	var rutaPVBV = "{{ URL::route('buscarVen') }}"
	var rutaPVAV = "{{ URL::route('asginarVen') }}"
	var rutaPVAC = "{{ URL::route('asginarCli') }}"
	var rutaPVDTE = "{{ URL::route('asginarDTE') }}"
	var rutaPVBC = "{{ URL::route('preventabc') }}"
	var rutaFP = "{{ URL::route('preventaRP')  }}"
	var rutaEP = "{{ URL::route('preventaEP') }}"
	var rutaPVCP = "{{ URL::route('preventacp') }}"
	var rutaPVC = "{{ URL::route('ventasPVC')  }}"
	var rutaBCC = "{{ URL::route('ventasBCC')  }}"
	var rutaBC = "{{ URL::route('buscarCDC') }}"
	var rutaPC = "{{ URL::route('pagarCuenta') }}"
	var rutaBP = "{{ URL::route('PtoBuscarP') }}"
	
	/* Formulario Venta */
	var rutaVAP = "{{ URL::route('addProductV') }}"
	var rutaVAV = "{{ URL::route('asignarVenVen') }}"
	var rutaVAC = "{{ URL::route('asignarCliVen') }}"
	var rutaVFP = "{{ URL::route('ventaRP')  }}"
	var rutaVEP = "{{ URL::route('ventaEP') }}"
	var rutaVCP = "{{ URL::route('ventaVCV') }}"
	var rutaRV = "{{ URL::route('addPreVentaV') }}"
	var rutaVDTE = "{{ URL::route('asginarDTEVen') }}"

	var rutaVDPV = "{{ URL::route('boletaV') }}"
	var rutaVDV = "{{ URL::route('boletaV') }}"
	
	/* Caja Diaria */
	var rutaCD = "{{ URL::route('infoCD') }}"
	//Ruta para imprimir pdf
	var rutaPDF = "{{ URL::route('boletaPDF') }}"
    var rutaBPN = "{{ URL::route('compraBPM') }}"

    var rutaBPM = "{{ URL::route('compraBPM') }}"
    var rutaCSP = "{{ URL::route('compraCSP') }}"

    var rutaRboPgo = "{{ URL::route('reciboPago') }}"

    
	
	var d = [];
	d['v_formas_pago'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_formas_pago) }}'));
	
</script>
<script src="{{ asset('js/ptovta/ptovta.js') }}"></script>
<script src="{{ asset('js/ptovta/ventaRapida.js') }}"></script>
@endsection