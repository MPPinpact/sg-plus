@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 class="card-header-text">
	        			Listado de Compras Registrados
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
							<table id="tablaCompras" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
									{!! Form::hidden('IdCompra', '', [
									'id'            => 'IdCompra',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="IdOrdenCompra" name="IdOrdenCompra" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="IdOrdenCompra">Orden de Compra</label>
											</div>
										</div>
										<div class="col-sm-3">
											<input type="hidden" name="IdProveedor" id="IdProveedor" value="1">
											<div class="md-input-wrapper">
												<input id="RUTProveedor" name="RUTProveedor" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="RUTProveedor">RUT Proveedor</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<select name="IdBodega" id="IdBodega" class="md-disable md-valid" disabled></select>
												<label for="IdBodega">Bodega</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<select name="TipoDTE" id="TipoDTE" class="md-disable md-valid" disabled></select>
												<label for="TipoDTE">Tipo DTE</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="md-input-wrapper">
												<input id="FolioDTE" name="FolioDTE" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="FolioDTE">Folio DTE</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="FechaDTE" name="FechaDTE" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="FechaDTE">Fecha DTE</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="FechaVencimiento" name="FechaVencimiento" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="FechaVencimiento">Fecha Vencimiento</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<input id="FechaPago" name="FechaPago" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="FechaPago">Fecha Pago</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalNeto" name="TotalNeto" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="TotalNeto">Total Neto</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalDescuentos" name="TotalDescuentos" type="text" class="md-form-control" maxlength="20" readonly />
												<label for="TotalDescuentos">Total Descuentos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalImpuestos" name="TotalImpuestos" type="text" class="md-form-control" maxlength="250" readonly />
												<label for="TotalImpuestos">Total Impuestos</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="TotalCompra" name="TotalCompra" type="text" class="md-form-control" maxlength="20" readonly />
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
									</div>
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" id="TabImpuestos" role="tabpanel">
									{!! Form::open(['id'=>'FormCabecera','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCompra2', '', [
									'id'            => 'IdCompra2',
									'class'         => 'form-control'])!!}
									<!--div class="row">
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
									</div -->
									{!! Form::close() !!}
									<div class="row">
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
<script Language="Javascript">
	var ruta = "{{ URL::route('compras') }}"
	var rutaA = "{{ URL::route('activarCom') }}"
	var rutaB = "{{ URL::route('comprab') }}"
	var d = [];
	d['v_compras'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_compras) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_bodegas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_bodegas) }}'));
</script>
<script src="{{ asset('js/compras/compras.js') }}"></script>
@endsection