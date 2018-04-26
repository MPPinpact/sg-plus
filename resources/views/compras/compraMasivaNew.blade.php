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
                			<a  href="{{ route('compraMasivaNew') }}" style="float:left;" name="botonListadoCompras" id="botonListadoCompras" class="btn btn-inverse-success waves-effect waves-light btn-block" role="button">
								<span>Nueva Compra Masiva </span>
							</a>
						</div>
						

						<div class="col-md-2">
                			<a  href="{{ route('compraMasivaReport') }}" style="float:left;" name="botonGenerarListadoCompra" id="botonGenerarListadoCompra" class="btn btn-success waves-effect waves-light btn-block" role="button">
								<span>Reporte Compra Masiva</span>
							</a>
						</div>
						
						<div class="col-md-2">
							<a  href="#!" style="float:left;" name="botonAgregarCompraMasiva" id="botonAgregarCompraMasiva" class="btn btn-success waves-effect waves-light btn-block"  role="button">
								<span>Finalizar Compra Masiva</span>
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
	        		<h5 class="card-header-text">
	        			Registro de Compra Masiva
	        		</h5>
                </center>
	        </div>
			 <div class="card-block">
				<div class="col-md-12">
					{!! Form::open(['id'=>'FormDetalleCompra','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdCompra" id="IdCompra">
					<input type="hidden" name="IdLocalDC" id="IdLocalDC">
					<input type="hidden" name="IdDetalleCompra" id="IdDetalleCompra">
					
					<div class="row">		
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
								<input id="CantidadProducto" name="CantidadProducto" type="text" class="md-form-control md-static" maxlength="250"  />
								<label for="CantidadProducto">Cantidad</label>
							</div>
						</div>
						<div class="col-md-1">
							<div class="md-input-wrapper">
								<input id="PrecioCosto" name="PrecioCosto" type="text" class="md-form-control md-static" maxlength="250"  />
								<label for="PrecioCosto">Costo</label>
							</div>
						</div>
						<div class="col-md-1">
							<div class="md-input-wrapper">
								<input id="PrecioVenta" name="PrecioVenta" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="PrecioVenta">Venta</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<button id="botonBodegaDestino" name="botonBodegaDestino" type="button" class="btn-lg btn-success waves-effect waves-light btn-block">Bodega Destino  <i class="icofont icofont-home-search"></i></button>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaDetalleCompra" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
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
	        		<h5 class="card-header-text">
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
							<span>Listado de Compras</span>
            			</button>
					</div>
				</div>
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#Tabdetalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Cabecera
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="aimpuestos" class="nav-link" data-toggle="tab" href="#TabImpuestos" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
			                </div>
		                    <!-- Tab panes -->
							<br><br>
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="Tabdetalles" role="tabpanel">
									{!! Form::open(['id'=>'FormCompras','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCompra_', '', [
									'id'            => 'IdCompra_',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="IdOrdenCompra" name="IdOrdenCompra" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="IdOrdenCompra">Nro OC</label>
											</div>
										</div>
										<div class="col-sm-3">
											<input type="hidden" name="IdProveedor" id="IdProveedor">
											<div class="md-input-wrapper">
												<input id="RUTProveedor" name="RUTProveedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUTProveedor">RUT Proveedor</label>
							                    <small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="md-input-wrapper">
												<input id="NombreFantasia" name="NombreFantasia" type="text" class="md-form-control  md-static" maxlength="250" readonly />
												<label for="NombreFantasia">Nombre Proveedor</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<input type="hidden" name="idEmpresa" id="idEmpresa">
											<div class="md-input-wrapper">
												<input id="RUT" name="RUT" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUT">RUT Comprador</label>
							                    <small id="ErrorRut3" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="md-input-wrapper">
												<input id="NombreFantasiaE" name="NombreFantasiaE" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="NombreFantasiaE">Nombre Comprador</label>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<select name="IdLocal_" id="IdLocal_" class="md-disable md-valid" disabled></select>
												<label for="IdLocal_">Locales</label>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<select name="IdBodega" id="IdBodega" class="md-disable md-valid" disabled></select>
												<label for="IdBodega">Bodega</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<select name="TipoDTE" id="TipoDTE" class="md-disable md-valid" disabled></select>
												<label for="TipoDTE">Tipo DTE</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="FolioDTE" name="FolioDTE" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="FolioDTE">Folio DTE</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaDTE" name="FechaDTE" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaDTE">Fecha DTE</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaVencimiento" name="FechaVencimiento" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaVencimiento">Fecha Vencimiento</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FechaPago" name="FechaPago" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaPago">Fecha Pago</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalNeto" name="TotalNeto" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="TotalNeto">Total Neto</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalDescuentos" name="TotalDescuentos" type="text" class="md-form-control md-static" maxlength="20" readonly />
												<label for="TotalDescuentos">Total Descuentos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalImpuestos" name="TotalImpuestos" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="TotalImpuestos">Total Impuestos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalCompra" name="TotalCompra" type="text" class="md-form-control md-static" maxlength="20" readonly />
												<label for="TotalCompra">Total Compra</label>
											</div>
										</div>
									</div>
									<diw class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="EstadoCompra" id="EstadoCompra" class="md-disable md-valid" disabled></select>
												<label for="EstadoCompra">Estado Compra</label>
											</div>
										</div>
										<div class="col-sm-4"></div>
									</diw>
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
													Guardar
					                			</button>
											</div>
										</div>
									</div>
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" id="TabImpuestos" role="tabpanel">
									<div>
										<div class="col-md-12">
											<button name="agregarC" id="agregarC" style="float:right;" type="button" class="btn btn-primary btn-icon waves-effect waves-light" data-toggle="modal" data-target="#ModalDetalleCompra">
											   <i class="icofont icofont-plus"></i>
											</button>
										</div>
										<br />
										<div class="col-md-12 table-responsive">
											<table id="tablaDetalles" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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

<!--Modal Asignar Bodega Destino al Producto -->
<div class="modal fade" id="ModalBodegaDestino" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModalBodegaDestino" class="modal-title"></h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormAsignarBodega','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdDetalleCompraBD" id="IdDetalleCompraBD">
					<input type="hidden" name="IdCompraBD" id="IdCompraBD">
					<input type="hidden" name="IdProductoBD" id="IdProductoBD">
					
					<div class="row" >
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<select name="IdLocal" id="IdLocal" class="md-static"></select>
								<label for="IdLocal">Locales</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="md-input-wrapper">
								<select name="IdBodega" id="IdBodega" class="md-static"></select>
								<label for="IdBodega">Bodegas</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<input id="CantidadBD" name="CantidadBD" type="hidden" />
								<input id="CantidadAsignada" name="CantidadAsignada" type="text" class="md-form-control md-static" maxlength="5" />
								<label for="CantidadAsignada">Cantidad</label>
							</div>
						</div>
						<div class="col-md-3">
							<button id="botonAsignarProducto" name="botonAsignarProducto" type="button" class="btn btn-success waves-effect waves-light btn-block">
								Asignar  <i class="icofont icofont-bubble-right"></i>
							</button>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="content clearfix">
								<h3 id="basic-forms-h-0___" tabindex="-1" class="title current"> Bodegas de Destino</h3>
								<span id="NombreProductoConsulta"></span>
								<fieldset id="basic-forms-p-0" role="tabpanel" aria-labelledby="basic-forms-h-0___" class="body current" aria-hidden="false">
									<table id="tablaBodegaDestino" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
								</fieldset>
							</div> 
						</div>
					</div>
					<br>
						
					<div class="row" id="">
						<div class="col-md-4">
							<button id="cerrarBodegaDestino" name="cerrarBodegaDestino" type="button" class="btn-lg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
								Cerrar
							</button>
						</div>
						
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<button id="botonRegistrarCompra" name="botonRegistrarCompra" type="button" class="btn-lg btn-primary waves-effect waves-light btn-block">Registrar  <i class="icofont icofont-bubble-right"></i></button>
							</div>
						</div>
												
						<div class="col-md-4">
							<div class="md-input-wrapper">
								<button id="botonImprimirEtiqueta" name="botonImprimirEtiqueta" type="button" class="btn-lg btn btn-block" disabled >Imprimir Etiquetas <i class="icofont icofont-barcode"></i></button>
							</div>
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
						
							<h3 id="NombreProductoStock" tabindex="-1" class="title current"> Stock del Producto</h3>
							<span id="NombreProductoStock">Pan con Queso</span>
							
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
	
		
	var rutaDC = "{{ URL::route('comprardc') }}"
	var rutaBDC = "{{ URL::route('comprarbdc') }}"
	var rutaCDA = "{{ URL::route('comprada') }}"
	var d = [];
	d['v_locales'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_locales) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_tipo_dte'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_dte) }}'));
	d['v_unidad_medida'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad_medida) }}'));

	d['IdCompra'] = JSON.parse(rhtmlspecialchars('{{ json_encode($IdCompra) }}'));

</script>
<script src="{{ asset('js/compras/compraMasiva.js') }}"></script>
@endsection