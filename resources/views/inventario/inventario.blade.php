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
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Inventarios Registradas
	        		</h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<button style="float:right;" name="agregar" id="agregar" type="button" class="btn btn-primary waves-effect waves-light">
								<span>Agregar</span>
                			</button>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table id="tablaInventario" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-12 divDetalles" style="display:none;">
		<div class="card">
		    <div class="card-header">
		    	<center>
			    	<h5 id="spanTitulo" class="card-header-text"></h5>
		    	</center>
		    </div>
		    <div class="card-block">
	        	<div class="row">
					<div id="divBotonesSec" class="col-md-8" style="display:none;">
						<button id="btn-sol-inv" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Solicitar Inventario</span>
            			</button>
            			<button id="btn-cer-inv" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Cerrar Inventario</span>
            			</button>
            			<button id="btn-aju-inv" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Ajustar Inventario</span>
            			</button>
					</div>
					<div class="col-md-4">
						<button style="float:right;" name="btn-list" id="btn-list" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Listado de Inventario</span>
            			</button>
					</div>
				</div>
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
							<!-- <div class="row">
								<div id="divVolver" class="col-md-12">
									<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
								</div>
							</div> -->
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
									{!! Form::open(['id'=>'FormInventario','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdInventario', '', [
									'id'            => 'IdInventario',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="FechaInventario" name="FechaInventario" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaInventario">Fecha Inventario</label>
											</div>
										</div>
										
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="FechaTomaInventario" name="FechaTomaInventario" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaTomaInventario">Fecha Toma</label>
											</div>
										</div>
										<div id="divAjusteInventario" class="col-sm-4" style="display:none;">
											<div class="md-input-wrapper">
												<input id="FechaAjusteInventario" name="FechaAjusteInventario" type="text" class="md-form-control md-static" maxlength="250" data-mask="99-99-9999" readonly />
												<label for="FechaAjusteInventario">Fecha Ajuste</label>
											</div>
										</div> 
										
									</div>
									<br>
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="Comentario" name="Comentario" type="text" class="md-form-control md-static" maxlength="250"readonly />
												<label for="Comentario">Comentario</label>
											</div>
										</div>
										
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="TipoInventario" id="TipoInventario" class="md-disable md-valid md-static" disabled></select>
												<label for="TipoInventario">Tipo Inventario</label>
											</div>
										</div>
										<div id="divAjusteInventario" class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="IdBodega" id="IdBodega" class="md-disable md-valid md-static" disabled></select>
												<label for="IdBodega">Bodega</label>
											</div>
										</div> 
									</div>
									<br>
									<div align="center">
										<div class="pull-rigth">
											<div id="div-mod">
												<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
													Modificar
												</button>
											</div>
											<div id="div-acep" style="display:none;">
												<button id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
													Cancelar
												</button>
					                			<button id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
													Continuar
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
										<!-- <br />
										<div class="row">
											<div class="col-sm-3">
												<div class="pull-right">
													<div class="md-input-wrapper">
														<input id="TotalPreVentaDetalle" name="TotalPreVentaDetalle" type="text" class="md-form-control md-static" maxlength="250" readonly />
														<label for="TotalPreVentaDetalle">Total Pre-Venta</label>
													</div>
												</div>
											</div>
										</div> -->
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

<!-- Modal Inventario -->
<div class="modal fade modal-flex" id="ModalInventario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            	<h6 class="modal-title">TOMA DE INVENTARIO</h6>
            </div>
            <div class="modal-body">
            	{!! Form::open(['id'=>'FormProveedorNew','autocomplete' => 'off']) !!}
				<div class="row">
					<div class="col-md-12 table-responsive">
						<table id="tablaTomaInventario" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
					</div>
				</div>
				{!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelarM" class="btn btn-inverse-primary waves-effect waves-light" data-dismiss="modal">Cancelar</button>
                <button type="button" id="aceptarM" class="btn btn-primary waves-effect waves-light">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle Compra -->
<div class="modal fade" id="ModalDetalleCompra" tabindex="-1" role="dialog">
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
					<input type="hidden" name="IdInventario2" id="IdInventario2">
					<input type="hidden" name="IdInventarioDetalle" id="IdInventarioDetalle">
					<input type="hidden" name="IdProducto" id="IdProducto">	
					<input type="hidden" name="StockSistema" id="StockSistema">
					<input type="hidden" name="Diferencia" id="Diferencia">
					<input type="hidden" name="AjusteRealizado" id="AjusteRealizado">
					<br>
					<div class="row">
						<div class="col-md-3">
							<input id="CodigoBarra" name="CodigoBarra" type="text" class="md-form-control md-static" maxlength="250" readonly />
							<label for="CodigoBarra">Codigo Producto</label>
						</div>
						<div class="col-md-5">
							<input id="NombreProducto" name="NombreProducto" type="text" class="md-form-control md-static" maxlength="250" readonly />
							<label for="NombreProducto">Nombre Producto</label>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<input id="StockFisico" name="StockFisico" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="StockFisico">Stock Fisico</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="md-input-wrapper">
								<input id="PrecioVentaSugerido" name="PrecioVentaSugerido" type="text" class="md-form-control md-static" maxlength="250" readonly />
								<label for="PrecioVentaSugerido">Precio Venta</label>
							</div>
						</div>
					</div>
					<br>
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

<script Language="Javascript">
	var ruta = "{{ URL::route('inventario') }}"
	var rutaA = "{{ URL::route('inventarioa') }}"
	var rutaB = "{{ URL::route('inventariob') }}"
	var rutaBDC = "{{ URL::route('inventariobdc') }}"
	var rutaDC = "{{ URL::route('inventariodc') }}"
	var rutaBPD = "{{ URL::route('inventariobpd') }}"
	
	var rutaBB = "{{ URL::route('inventariobb') }}"
	var rutaCI = "{{ URL::route('inventarioci') }}"
	
	var rutaBC = "{{ URL::route('preventabc') }}"
	var rutaCP = "{{ URL::route('preventacp') }}"
	
	var rutaBE = "{{ URL::route('comprabe') }}"
	var rutaBCs = "{{ URL::route('comprabc') }}"
	var rutaCDA = "{{ URL::route('preventada') }}"
	var d = [];
	d['v_inventario'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_inventario) }}'));
	d['v_tipo_inventario'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_inventario) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
</script>
<script src="{{ asset('js/inventario/inventario.js') }}"></script>
@endsection

