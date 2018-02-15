@extends('menu.index')
@section('content')
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 id="spanTitulo" class="card-header-text"></h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12 divForm">
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
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormProducto','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdProducto', '', [
					'id'            => 'IdProducto',
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
								<select name="IdUltimoProveedor" id="IdUltimoProveedor" class="md-disable md-valid" disabled></select>
                                <label for="IdUltimoProveedor">Último proveedor</label>
							</div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="IdFamilia" id="IdFamilia" class="md-disable md-valid" disabled></select>
                                <label for="IdFamilia">Familia</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
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
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="SeCompra" id="SeCompra" class="md-disable md-valid" disabled></select>
	                            <label for="SeCompra">Se compra</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<select name="SeVende" id="SeVende" class="md-disable md-valid" disabled></select>
	                            <label for="SeVende">Se Vende</label>
							</div>
						</div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="EsProductoCombo" id="EsProductoCombo" class="md-disable md-valid" disabled></select>
                                <label for="EsProductoCombo">Es combo</label>
							</div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="Descontinuado" id="Descontinuado" class="md-disable md-valid" disabled></select>
                                <label for="Descontinuado">Producto Descontinuado</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="StockMinimo" name="StockMinimo" type="text" class="md-form-control" maxlength="5" readonly />
								<label for="StockMinimo">Stock Minimo</label>
							</div>
						</div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<input id="StockMaximo" name="StockMaximo" type="text" class="md-form-control" maxlength="5" readonly />
								<label for="StockMaximo">Stock Maximo</label>
							</div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<input id="StockRecomendado" name="StockRecomendado" type="text" class="md-form-control" maxlength="5" readonly />
								<label for="StockRecomendado">Stock Recomendado</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-4">
							<div class="md-input-wrapper">
								<input id="PrecioUltimaCompra" name="PrecioUltimaCompra" type="text" class="md-form-control" maxlength="15" readonly />
								<label for="PrecioUltimaCompra">Precio Ultima Compra</label>
							</div>
						</div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<input id="PrecioVentaSugerido" name="PrecioVentaSugerido" type="text" class="md-form-control" maxlength="15" readonly />
								<label for="PrecioVentaSugerido">Precio Venta Sugerido</label>
							</div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<select name="IdBodega" id="IdBodega" class="md-disable md-valid" disabled></select>
                                <label for="IdBodega">Bodega</label>
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
					</div>
					<br>
					<div align="center">
						<div class="pull-rigth">
							<div id="divBtnModificar">
								<button id="modificar" type="button" class="btn btn-primary waves-effect waves-light">
									Modificar
								</button>
							</div>
							<div id="divBtnAceptar">
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
	        </div>
	    </div>
	</div>
	<div class="col-md-10 divDetalles" style="display:none;">
		<div class="card">
		    <div class="card-header">
		    	<center>
			    	<h5 class="card-header-text">Cartola</h5>
		    	</center>
		    </div>
		    <div class="card-block">
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
		                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
		                        <li class="nav-item">
		                            <a class="nav-link active" data-toggle="tab" href="#TabReceta" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Receta
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#TabImpuestos" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Impuestos
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#TabStock" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Stock
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#TabKardex" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Kardex
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                    </ul>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="TabReceta" role="tabpanel">
		                            <form class="md-float-material card-block">
										<div class="row">
											<div class="col-sm-2"></div>
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="NombreBodegad" name="NombreBodegad" type="text" class="md-form-control" maxlength="250" readonly />
	                            					<label for="NombreBodega">Nombre Bodega</label>
						                        </div>
											</div>
						                    <div class="col-sm-4">
						                        <div class="md-input-wrapper">
						                        	<input id="DescripcionBodegad" name="DescripcionBodegad" type="text" class="md-form-control" maxlength="250" readonly />
	                            					<label for="DescripcionBodega">Descripción Bodega</label>
						                        </div>
						                    </div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-2"></div>
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
													<select name="IdLocald" id="IdLocald" class="md-disable md-valid" disabled></select>
                                					<label for="IdLocald">Local</label>
												</div>
						                    </div>
						                    <div class="col-sm-4">
						                        <div class="md-input-wrapper">
													<select name="EstadoBodegad" id="EstadoBodegad" class="md-disable md-valid" disabled></select>
                                					<label for="EstadoBodegad">Estado</label>
												</div>
						                    </div>
										</div>
		                            </form>
		                        </div>
		                        <div class="tab-pane" id="TabImpuestos" role="tabpanel">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		                        </div>
		                        <div class="tab-pane" id="TabStock" role="tabpanel">
		                        	222222222222222222222222222222222222222222222222222222222222222222
		                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                        	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                        	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		                        	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		                        	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		                        	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		                        </div>
		                        <div class="tab-pane" id="TabKardex" role="tabpanel">
		                        	333333333333333333333333333333333333333333333333333333333333333333333
		                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                        	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                        	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		                        	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		                        	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		                        	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		                        </div>
		                        <div class="text-center">
		                            <button id="btn-volver" type="button" class="btn btn-inverse-primary waves-effect waves-light m-r-10">
		                            	Volver
		                            </button>
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
	var d = [];
	d['v_productos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_productos) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_familias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_familias) }}'));
	d['v_subfamilias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_subfamilias) }}'));
	d['v_unidad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_unidad) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
</script>
<script src="{{ asset('js/productos/productos.js') }}"></script>
@endsection