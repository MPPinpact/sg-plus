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
                			<a  href="{{ URL::route('compraPurchaseList') }}" style="float:left;" name="botonListadoCompra" id="botonListadoCompra" class="btn btn-primary waves-effect waves-light btn-block" role="button">
								<span>Listados de Compra</span>
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
                			<a  href="{{ route('compraMasivaNew') }}" style="float:left;" name="botonContinuarIngresoCM" id="botonContinuarIngresoCM" class="btn btn-success waves-effect waves-light btn-block" role="button">
								<span>Continuar Ingreso CM</span>
							</a>
						</div>
						
						<div class="col-md-2">
                			<a  href="{{ route('compraMasivaReport') }}" style="float:left;" name="botonGenerarListadoCompra" id="botonGenerarListadoCompra" class="btn btn-inverse-success waves-effect waves-light btn-block" role="button">
								<span>Reporte Compra Masiva</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="botonFinalizarCompraMasiva" id="botonFinalizarCompraMasiva" class="btn btn-success waves-effect waves-light btn-block"  role="button">
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
	        		<h5 class="card-header-text" id="tituloReporteCompraMasiva" >
	        			
	        		</h5>
                </center>
	        </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
			<div class="card-header">
	        	<center>
	        		<h5 class="card-header-text" id="tituloRCMB">
	        			Resumen de Compra Masiva Bodega
	        		</h5>
	            </center>
	        </div>
			 <div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaResumenCompraMasivaBodega" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%">
								<tfoot>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
	        	<center>
	        		<h5 class="card-header-text" id="tituloRCML">
	        			Resumen de Compra Masiva Local
	        		</h5>
	            </center>
	        </div>
			 <div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaResumenCompraMasivaLocal" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%">
								<tfoot>
								</tfoot>
							</table>
						</div>
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