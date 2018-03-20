@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 5)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Productos Registrados
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
							<table id="tablaProductos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
		            <div class="col-sm-12">
		                <div class="product-edit">
							<div class="row">
								<div id="divVolver" class="col-md-12">
									<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
								</div>
							</div>
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#Tabdetalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="areceta" class="nav-link" data-toggle="tab" href="#Tabreceta" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Receta
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="aimpuestos" class="nav-link" data-toggle="tab" href="#TabImpuestos" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Impuestos
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="astock" class="nav-link" data-toggle="tab" href="#TabStock" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Stock
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="akardex" class="nav-link" data-toggle="tab" href="#TabKardex" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Kardex
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
			                </div>
		                    <!-- Tab panes -->
							<br><br>
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="Tabdetalles" role="tabpanel">
									{!! Form::open(['id'=>'FormProducto','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdProducto', '', [
									'id'            => 'IdProducto',
									'class'         => 'form-control'])!!}
									{!! Form::hidden('IdUltimoProveedor', '', [
									'id'            => 'IdUltimoProveedor',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="CodigoBarra" name="CodigoBarra" type="text" class="md-form-control" maxlength="20" readonly />
												<label for="CodigoBarra">Código Barra</label>
											</div>
										</div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<input id="CodigoProveedor" name="CodigoProveedor" type="text" class="md-form-control" maxlength="20" readonly />
												<label for="CodigoProveedor">Código Proveedor</label>
											</div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<input id="NombreProducto" name="NombreProducto" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="NombreProducto">Nombre Producto</label>
											</div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="DescripcionProducto" name="DescripcionProducto" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="DescripcionProducto">Descripción Producto</label>
											</div>
										</div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	 <div class="md-input-wrapper">
					                                <input id="RUTProveedor" name="RUTProveedor" type="text" class="md-form-control" maxlength="14" />
	                            					<label for="RUTProveedor">Rut Último proveedor</label>
							                        <small id="ErrorRut" class="rut-error"></small>
						                        </div>               
											</div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	<input id="NombreProveedor" name="NombreProveedor" type="text" class="md-form-control md-static" maxlength="250" readonly />
				                                <label for="NombreProveedor">Nombre del Último Proveedor</label>
					                        </div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-check">
							                 	<label class="form-check-label">
							                    	<input name="SeVende" id="SeVende" type="checkbox" class="form-check-input"> Se Vende
							                    </label>
						                    </div>
										</div>
										<div class="col-sm-3">
					                        	<label class="form-check-label">
							                    	<input name="EsProductoCombo" id="EsProductoCombo" type="checkbox" class="form-check-input" > Es Combo
							                    </label>
					                    </div>
					                    <div class="col-sm-3">
												<label class="form-check-label">
							                    	<input name="Descontinuado" id="Descontinuado" type="checkbox" class="form-check-input"> Producto Descontinuado
							                    </label>
					                    </div>
					                    <div class="col-sm-3">
												<label class="form-check-label">
							                    	<input name="SeCompra" id="SeCompra" type="checkbox" class="form-check-input"> Se compra
							                    </label>
					                    </div>
									</div>
									<br>
									<div class="row">
										  <div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="IdFamilia" id="IdFamilia" class="md-disable md-valid" disabled></select>
				                                <label for="IdFamilia">Familia</label>
											</div>
					                    </div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="IdSubFamilia" id="IdSubFamilia" class="md-disable md-valid" disabled></select>
				                                <label for="IdSubFamilia">Subfamilia</label>
											</div>
										</div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="IdUnidadMedida" id="IdUnidadMedida" class="md-disable md-valid" disabled></select>
				                                <label for="IdUnidadMedida">Unidad Medida</label>
											</div>
					                    </div>
					                
									</div>
									<br>
									<div class="row">
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="StockMinimo" name="StockMinimo" type="text" class="md-form-control" maxlength="5" readonly />
												<label for="StockMinimo">Stock Minimo</label>
											</div>
										</div>
										<div class="col-sm-2">
					                        <div class="md-input-wrapper">
												<input id="StockMaximo" name="StockMaximo" type="text" class="md-form-control" maxlength="5" readonly />
												<label for="StockMaximo">Stock Maximo</label>
											</div>
					                    </div>
					                    <div class="col-sm-2">
					                        <div class="md-input-wrapper">
												<input id="StockRecomendado" name="StockRecomendado" type="text" class="md-form-control" maxlength="5" readonly />
												<label for="StockRecomendado">Stock Recomendado</label>
											</div>
					                    </div>
					                    <div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="PrecioVentaSugerido" name="PrecioVentaSugerido" type="text" class="md-form-control" maxlength="15" readonly />
												<label for="PrecioVentaSugerido">Precio Venta Sugerido</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="PrecioUltimaCompra" name="PrecioUltimaCompra" type="text" class="md-form-control" maxlength="15" readonly />
												<label for="PrecioUltimaCompra">Precio Ultima Compra</label>
											</div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="EstadoProducto" id="EstadoProducto" class="md-disable md-valid" disabled></select>
				                                <label for="EstadoProducto">Estado Producto</label>
											</div>
					                    </div>
										<div class="col-sm-4"></div>
									</div>
									<br>
									<div align="center">
										<div class="divBotones">
											<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
												Modificar
											</button>
										</div>
										<div class="divBotones" style="display:none;">
											<button id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
												Cancelar
											</button>
				                			<button id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
												Guardar
				                			</button>
										</div>
									</div>
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" id="TabImpuestos" role="tabpanel">
									{!! Form::open(['id'=>'FormImpuesto','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdProducto2', '', [
									'id'            => 'IdProducto2',
									'class'         => 'form-control'])!!}
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-8">
												<div class="md-input-wrapper">
													<select name="IdImpuesto" id="IdImpuesto" class="md-valid"></select>
					                                <label for="IdImpuesto">Impuesto</label>
												</div>
						                    </div>
						                    <div class="col-sm-4">
												<button id="guardarI"  type="button" class="btn btn-primary waves-effect waves-light">
													Guardar
					                			</button>
						                    </div>
										</div>
										</div>
										<div class="col-sm-2"></div>
									</div>
									{!! Form::close() !!}
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<table id="tablaImpuestos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
										<div class="col-md-2"></div>
									</div>
		                        </div>
		                        
		                        <div class="tab-pane" id="Tabreceta" role="tabpanel">
		                        	<h1>
		                        		Receta
		                        	</h1>
		                        </div>
		                        <div class="tab-pane" id="TabStock" role="tabpanel">
		                        	<h1>
		                        		Stock
		                        	</h1>
		                        </div>
		                        <div class="tab-pane" id="TabKardex" role="tabpanel">
		                        	<h1>
		                        		Kardex
		                        	</h1>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('productos') }}"
	var rutaA = "{{ URL::route('activarPr') }}"
	var rutaD = "{{ URL::route('detallesPr') }}"
	var rutaDes = "{{ URL::route('descontinuarPr') }}"
	var rutaB = "{{ URL::route('buscarSubfamilia') }}"
	var rutaPI = "{{ URL::route('procesarIm') }}"
	var rutaAI = "{{ URL::route('activarIm') }}"
	var rutaPP = "{{ URL::route('buscarProveedor') }}"

	var d = [];
	d['v_productos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_productos) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_familias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_familias) }}'));
	d['v_subfamilias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_subfamilias) }}'));
	d['v_unidad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
	d['v_impuestos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_impuestos) }}'));
</script>
<script src="{{ asset('js/productos/productos.js') }}"></script>
@endsection