@extends('menu.index')
@section('content')

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
                			<a  href="{{ route('cajaDiaria') }}" style="float:left;" name="agregar" id="agregar" class="btn btn-inverse-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Listado de Cajas Diarias </span>
							</a>
						</div>
						
						
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumen') }}" style="float:left;" name="botonCDR" id="botonCDR" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Resumen Caja Actual </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="{{ URL::route('cajaDiariaResumenVenta') }}" style="float:left;" name="botonCDRV" id="botonCDRV" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
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
	        <div class="card-block">
				<div class="col-md-12 table-responsive">
					<table id="tablaCajaDiaria" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
				</div>
	        </div>
		</div>
	</div>
	<div class="col-md-5">
	    <div class="card">
	        <div class="card-block">
				<div class="col-md-12 table-responsive">
					<table id="tablaDetalleCajaDiaria" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
				</div>
	        </div>
		</div>
	</div>
</div>

<script Language="Javascript">
	var rutaCD = "{{ URL::route('cajaDiaria') }}";
	var rutaB = "{{ URL::route('cajaDiariaResumen') }}";
	var d = [];
	
	d['v_cajas_diarias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_cajas_diarias) }}'));
	
</script>
<script src="{{ asset('js/ptovta/cajaDiaria.js') }}"></script>
@endsection
