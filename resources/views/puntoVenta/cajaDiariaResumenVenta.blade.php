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
	        			Caja Diaria Actual -> Resumen de Ventas
	        		</h5>
                </center>
	        </div>
			
			{!! Form::open(['id'=>'FormCajaDiaria','autocomplete' => 'off']) !!}
				<input type="hidden" name="IdLocal" id="IdLocal">
				<input type="hidden" name="IdCaja" id="IdCaja">
				<input type="hidden" name="IdFormaPago" id="IdFormaPago">
				<input type="hidden" name="IdVenta" id="IdVenta">
			{!! Form::close() !!}	
			
			<div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
                			<a  href="{{ route('cajaDiaria') }}" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Listado de Cajas Diarias </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumen') }}" style="float:left;" name="botonCDR" id="botonCDR" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Resumen Caja Actual</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumenVenta') }}" style="float:left;" name="botonCDRV" id="botonCDRV" class="btn btn-inverse-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Resumen Venta Caja Actual</span>
							</a>
						</div>
						
						<div class="col-md-2">
                			<a  href="#" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Nueva Caja</span>
							</a>
						</div>
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaCierre') }}" style="float:left;" name="agregar" id="agregar" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Cerrar Caja Actual</span>
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
			<div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Detalle de Formas de Pago Caja Actual
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12 table-responsive">
					<table id="tablaCajaDiariaResumenVenta" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
				</div>
	        </div>
		</div>
	</div>
	<div class="col-md-5">
	    <div class="card">
			<div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Detalle de la Venta
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				
				<div class="col-md-12 table-responsive">
					<table id="tablaDetalleVenta" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
				</div>
	        </div>
		</div>
	</div>
</div>


<script Language="Javascript">
	var rutaCDDV = "{{ URL::route('detalleVenta') }}";
	var d = [];
	
	d['v_detalle_venta'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_detalle_venta) }}'));
	d['v_cajaActual'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_cajaActual) }}'));
	
</script>
<script src="{{ asset('js/ptovta/cajaDiariaResumenVenta.js') }}"></script>
@endsection
