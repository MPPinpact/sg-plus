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
                			<a  href="{{ route('transferenciaList') }}" style="float:left;" name="botonListadoTransferencia" id="botonListadoTransferencia" class="btn btn-primary waves-effect waves-light btn-block" role="button">
								<span>Listado Transferencias </span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="{{ route('transferenciaNew') }}" style="float:left;" name="botonNewTransferencia" id="botonNewTransferencia" class="btn btn-inverse-primary waves-effect waves-light btn-block" role="button">
								<span>Nueva Transferencia </span>
							</a>
						</div>

					</div>
				</div>
				<br />
			</div>
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 divDetalles">
		<div class="card">
			 <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Registro de Transferencia
	        		</h5>
                </center>
	        </div>
			 <div class="card-block">
				<div class="col-md-12">
					{!! Form::open(['id'=>'FormDetalleTransferencia','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdTransferencia" id="IdTransferencia">
					<input type="hidden" name="IdDetalleTransferencia" id="IdDetalleTransferencia">
					<input type="hidden" name="IdEstadoTransferencia" id="IdEstadoTransferencia">
					
					<!-- <div class="row" id="frameIngresoCompra"> -->
					<div class="row" id="frameIngresoTransferencia">
						<div class="col-md-3">
							<div class="input-group">
								<input id="NombreProducto" name="NombreProducto" type="text" aria-describedby="btn-addon1" class="md-form-control md-static" placeholder="Buscar Producto...">
								<span class="input-group-addon" id="botonBuscarProducto"><i class="icofont icofont-search"></i></span>
							</div>
						</div>
						<div class="col-md-2">
							<div class="input-group">
								<input type="hidden" name="IdProducto" id="IdProducto">
								<input id="CodigoBarra" name="CodigoBarra" type="text" class="md-form-control md-static" maxlength="20" placeholder="Código..." />
								<span class="input-group-addon" id="botonBuscarCodigo"><i class="icofont icofont-search"></i></span>
							</div>
						</div>
						<div class="col-md-1">
							<div class="md-input-wrapper">
								<input id="CantidadProducto" name="CantidadProducto" type="text" class="md-form-control md-static text-center " maxlength="250"  />
								<label for="CantidadProducto">Cantidad</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<input id="IdOrigen" name="IdOrigen" type="hidden" class="md-form-control md-static" maxlength="250"  />
								
								<label for="IdLocalOrigen">Origen</label>
								<select name="IdLocalOrigen" id="IdLocalOrigen" class="md-form-control md-static"></select>
								<select name="IdBodegaOrigen" id="IdBodegaOrigen" class="md-form-control md-static"></select>
								
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<input id="IdDestino" name="IdDestino" type="hidden" class="md-form-control md-static" maxlength="250"  />

								<label for="IdLocalDestino">Destino</label>
								<select name="IdLocalDestino" id="IdLocalDestino" class="md-form-control md-static"></select>
								<select name="IdBodegaDestino" id="IdBodegaDestino" class="md-static"></select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<button id="botonIngresarTransferencia" name="botonIngresarTransferencia" type="button" class="btn btn-success waves-effect waves-light btn-block"><i class="icofont icofont-ui-check"></i> Ingresar</button>

								<button id="botonFinalizarTransferencia" name="botonFinalizarTransferencia" type="button" class="btn btn-primary waves-effect waves-light btn-block"><i class="icofont icofont-save"></i> Finalizar</button>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaDetalleTransferencia" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
				</div>
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
							<div class="content clearfix">
								<h3 id="basic-forms-h-0___" tabindex="-1" class="title current"> Productos Similares</h3>
								<span id="NombreProductoConsulta"></span>
								<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0___" class="body current" aria-hidden="false">
									<table id="tablaResultadoBusquedaProducto" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
	
	var rutaBPM = "{{ URL::route('compraBPM') }}"
	var rutaRDCM = "{{ URL::route('compraRDCM') }}"
	var rutaRBD = "{{ URL::route('compraRBD') }}"
	var rutaBD = "{{ URL::route('compraBD') }}"
	var rutaEBD = "{{ URL::route('compraEBD') }}"
	var rutaCSP = "{{ URL::route('compraCSP') }}"
	var rutaCDC = "{{ URL::route('compraCDC') }}"
	var rutaFCM = "{{ URL::route('compraFDC') }}"
	
		
	var rutaDC = "{{ URL::route('comprardc') }}"
	var rutaBDC = "{{ URL::route('comprarbdc') }}"
	var rutaCDA = "{{ URL::route('comprada') }}"
	var d = [];
	d['v_locales'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_locales) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
	d['v_tipo_dte'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_dte) }}'));
	d['v_unidad_medida'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad_medida) }}'));

	d['IdTransferencia'] = JSON.parse(rhtmlspecialchars('{{ json_encode($IdTransferencia) }}'));

</script>
<script src="{{ asset('js/transferencias/transferenciaNew.js') }}"></script>
@endsection