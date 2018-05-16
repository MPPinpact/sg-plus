@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 1)!important;
	}
</style>
<div class="row">
	<div class="col-md-12 divDetalles">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 id="spanTitulo" class="card-header-text"></h5>
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
							<table id="tablaCicloFacturacion" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>           
	        </div>
	    </div>
	</div>
	<div class="col-md-12 divDetalles" style="display:none;">
		<div class="card">
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
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#detalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles del Ciclo de Facturación
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
							</div>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
									<br>
									{!! Form::open(['id'=>'FormCicloFacturacion','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCicloFacturacion', '', [
									'id'            => 'IdCicloFacturacion',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="DiaCorte" name="DiaCorte" type="text" class="md-form-control md-static" maxlength="2" readonly />
					                            <label for="DiaCorte">Dia de Pago</label>
					                        </div>
										</div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	<input id="DiaFacturacion" name="DiaFacturacion" type="text" class="md-form-control md-static" maxlength="2" readonly />
					                            <label for="DiaFacturacion">Dia de Facturación</label>
					                        </div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	<select name="EstadoCiclo" id="EstadoCiclo" class="md-disable md-valid" disabled></select>
                                				<label for="EstadoCiclo">Estado</label>
					                        </div>
					                    </div>
									</div>

									<div class="row">
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="InicioUltimaFacturacion" name="InicioUltimaFacturacion" type="text" class="md-form-control md-static" maxlength="2" readonly />
					                            <label for="InicioUltimaFacturacion">Fecha Inicio Última Facturación</label>
					                        </div>
										</div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	<input id="FinUltimaFacturacion" name="FinUltimaFacturacion" type="text" class="md-form-control md-static" maxlength="2" readonly />
					                            <label for="FinUltimaFacturacion">Fecha Fin Última Facturación</label>
					                        </div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	
					                        </div>
					                    </div>
									</div>
									
									<div align="center">
										<div class="pull-rigth">
											<div class="divBotones">
												<button id="generacionEECC" name="generacionEECC" type="button" class="btn btn-primary waves-effect waves-light">
													Generar EECC
												</button>
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
									
									{!! Form::open(['id'=>'FormGeneracionEECC','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCicloFacturacion', '', [
									'id'            => 'IdCicloFacturacion',
									'class'         => 'form-control'])!!}
									
									<input type="hidden" name="IdCicloFacturacionEECC" id="IdCicloFacturacionEECC" value="">
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" id="productos" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaProductos" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
	var ruta = "{{ URL::route('cicloFacturacion') }}"
	var rutaA = "{{ URL::route('activarCF') }}"
	var rutaD = "{{ URL::route('detallesCF') }}"
	var rutaGCF = "{{ URL::route('generarEECC') }}"
	
	var d = [];
	d['v_ciclos_facturacion'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_ciclos_facturacion) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
</script>
<script src="{{ asset('js/ciclo_facturacion/ciclo_facturacion.js') }}"></script>
@endsection