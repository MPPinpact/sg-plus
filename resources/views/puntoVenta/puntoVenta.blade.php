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
	<div class="col-xl-4 col-md-6">
		<div class="card social-card bg-c-red">
			<div class="card-block">                                 
				<div class="row align-items-center">                                 
					<div class="col-auto">                                 
						<i class="feather icon-mail f-34 text-c-red social-icon"></i>                                 
					</div>                                 
					<div class="col">                                 
						<h6 class="m-b-0">Caja Diaria</h6>                                 
						<p>231.2w downloads</p>                                 
						<p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                 
					</div>                                 
				</div>                                 
			</div>                                 
			<a href="{{ route('cajaDiaria') }}" class="download-icon">Ir<i class="feather icon-arrow-"></i></a>                                 
		</div>                                 
	</div>
	
	<div class="col-xl-4 col-md-6">
	    <div class="card social-card bg-c-green">										
            <div class="card-block">                                        
                <div class="row align-items-center">                                        
                    <div class="col-auto">                                        
                        <i class="feather icon-instagram f-34 text-c-green social-icon"></i>                                        
                    </div>                                        
                    <div class="col">                                        
                        <h6 class="m-b-0">Resumen Venta Día</h6>                                        
                        <p>231.2w downloads</p>                                        
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                        
                    </div>                                        
                </div>                                        
            </div>                                        
            <a href="#!" class="download-icon"><i class="feather icon-arrow-down"></i></a>                                        
        </div>                                        
    </div>
	
	<div class="col-xl-4 col-md-6">
	    <div class="card social-card bg-c-blue">										
            <div class="card-block">                                        
                <div class="row align-items-center">                                        
                    <div class="col-auto">                                        
                        <i class="feather icon-twitter f-34 text-c-blue social-icon"></i>                                        
                    </div>                                        
                    <div class="col">                                        
                        <h6 class="m-b-0">Pre-Venta</h6>                                        
                        <p>231.2w downloads</p>                                        
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                        
                    </div>                                        
                </div>                                        
            </div>                                        
            <a href="#!" class="download-icon"><i class="feather icon-arrow-down"></i></a>                                        
        </div>                                        
    </div>	
	
	<div class="col-xl-4 col-md-6">
	    <div class="card social-card bg-c-green">										
            <div class="card-block">                                        
                <div class="row align-items-center">                                        
                    <div class="col-auto">                                        
                        <i class="feather icon-instagram f-34 text-c-green social-icon"></i>                                        
                    </div>                                        
                    <div class="col">                                        
                        <h6 class="m-b-0">Venta</h6>                                        
                        <p>231.2w downloads</p>                                        
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                        
                    </div>                                        
                </div>                                        
            </div>                                        
            <a href="#!" class="download-icon"><i class="feather icon-arrow-down"></i></a>                                        
        </div>                                        
    </div>
	
	
	<div class="col-xl-4 col-md-6">
	    <div class="card social-card bg-c-green">										
            <div class="card-block">                                        
                <div class="row align-items-center">                                        
                    <div class="col-auto">                                        
                        <i class="feather icon-instagram f-34 text-c-green social-icon"></i>                                        
                    </div>                                        
                    <div class="col">                                        
                        <h6 class="m-b-0">Consulta Límite Crédito</h6>                                        
                        <p>231.2w downloads</p>                                        
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                        
                    </div>                                        
                </div>                                        
            </div>                                        
            <a href="#!" class="download-icon"><i class="feather icon-arrow-down"></i></a>                                        
        </div>                                        
    </div>
	
	<div class="col-xl-4 col-md-6">
	    <div class="card social-card bg-c-green">										
            <div class="card-block">                                        
                <div class="row align-items-center">                                        
                    <div class="col-auto">                                        
                        <i class="feather icon-instagram f-34 text-c-green social-icon"></i>                                        
                    </div>                                        
                    <div class="col">                                        
                        <h6 class="m-b-0">Pago Cuenta</h6>                                        
                        <p>231.2w downloads</p>                                        
                        <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>                                        
                    </div>                                        
                </div>                                        
            </div>                                        
            <a href="#!" class="download-icon"><i class="feather icon-arrow-down"></i></a>                                        
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
	var ruta = "{{ URL::route('ventas') }}"
	var rutaB = "{{ URL::route('ventab') }}"
	var rutaDV = "{{ URL::route('ventadv') }}"
	var rutaBDC = "{{ URL::route('ventabdc') }}"
	var rutaFV = "{{ URL::route('ventasFin') }}"
	
	var rutaCV = "{{ URL::route('ventaCerrar') }}"
	var rutaAV = "{{ URL::route('ventaActivar') }}"
	
	var rutaBC = "{{ URL::route('preventabc') }}"
	var rutaBPD = "{{ URL::route('preventabpd') }}"
	
	var rutaEP = "{{ URL::route('ventasEP') }}"
	var rutaFP = "{{ URL::route('ventasRP')  }}"
	var rutaPVC = "{{ URL::route('ventasPVC')  }}"
	var rutaBCC = "{{ URL::route('ventasBCC')  }}"
	
	
	var rutaBE = "{{ URL::route('comprabe') }}"
	var rutaBB = "{{ URL::route('comprabb') }}"
	var rutaBCs = "{{ URL::route('comprabc') }}"
	var rutaCDA = "{{ URL::route('comprada') }}"
	var d = [];
	
</script>
<script src="{{ asset('js/ventas/ventas.js') }}"></script>
@endsection
