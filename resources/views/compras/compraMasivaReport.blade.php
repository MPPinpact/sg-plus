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
			<div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
                			<a  href="{{ route('compras') }}" style="float:left;" name="botonListadoCompras" id="botonListadoCompras" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Compras Realizadas </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="botonCDR" id="agregar" name="agregar" class="btn btn-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Ingresar Compra </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="botonAgregarCompraMasiva" id="botonAgregarCompraMasiva" class="btn btn-inverse-warning waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Compras Masivas</span>
							</a>
						</div>
						
						<div class="col-md-2">
                			<a  href="#!" style="float:left;" name="botonGenerarListadoCompra" id="botonGenerarListadoCompra" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>Generar Listado Compras</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="" id="" class="btn btn-primary waves-effect waves-light btn-block" href="#primary" role="button">
								<span>--</span>
							</a>
						</div>
					</div>
				</div>
				<br />
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2">
							<a  href="{{ route('compraMasivaList') }}" style="float:left;" name="" id="" class="btn btn-success waves-effect waves-light btn-block" role="button">
								<span>Listado Compras Masivas</span>
							</a>
						</div>
						
						<div class="col-md-2">
                			<a  href="{{ route('compraMasivaNew') }}" style="float:left;" name="botonListadoCompras" id="botonListadoCompras" class="btn btn-success waves-effect waves-light btn-block" role="button">
								<span>Nueva Compra Masiva </span>
							</a>
						</div>
						
						<div class="col-md-2">
                			<a  href="{{ route('compraMasivaReport') }}" style="float:left;" name="botonGenerarListadoCompra" id="botonGenerarListadoCompra" class="btn btn-inverse-success waves-effect waves-light btn-block" role="button">
								<span>Reporte Compra Masiva</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="botonAgregarCompraMasiva" id="botonAgregarCompraMasiva" class="btn btn-success waves-effect waves-light btn-block"  role="button">
								<span>Finalizar Compra Masiva</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="" id="" class="btn btn-success waves-effect waves-light btn-block" role="button">
								<span>--</span>
							</a>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 divDetalles">
		<div class="card">
		   <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text" id="tituloReporteCompraMasica" >
	        			
	        		</h5>
                </center>
	        </div>
		    <div class="card-block">
	        	<div class="row">
					<div class="col-md-12">
						<table id="tablaResumenCompraMasiva" ></table>
					</div>
				</div>
		    </div>
		</div>
	</div>
</div>

<script Language="Javascript">
	var rutaRC = "{{ URL::route('compraRC') }}"

	var d = [];
	d['IdCompra'] = JSON.parse(rhtmlspecialchars('{{ json_encode($IdCompra) }}'));

	
</script>
<script src="{{ asset('js/compras/compraMasivaReport.js') }}"></script>
@endsection