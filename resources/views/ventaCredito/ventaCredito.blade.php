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
							<table id="tablaVentasCredito" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-12 divDetalles" style="display:;">
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

		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
                   					<br><br>
                   					{!! Form::open(['id'=>'FormVentaCredito','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdVentaCredito', '', [
									'id'            => 'IdVentaCredito',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-2">
					                        <div class="md-input-wrapper">
				                                <input id="IdVenta" name="IdVenta" type="text" class="md-form-control" maxlength="11" readonly />
					                            <label for="NombreLocal">Nro. Venta</label>
					                        </div>
										</div>

										 <div class="col-sm-2">
					                        <div class="md-input-wrapper">
					                        	<input id="RUTCliente" name="RUTCliente" type="text" class="md-form-control" maxlength="12" readonly />
				                                <label for="RUTCliente">RUT Cliente</label>
					                        </div>
					                    </div>

					                    <div class="col-sm-8">
					                        <div class="md-input-wrapper">
					                        	<input id="NombreCliente" name="NombreCliente" type="text" class="md-form-control" maxlength="250" readonly />
				                                <label for="NombreCliente">Cliente</label>
					                        </div>
					                    </div>
									</div>

									<div class="row">
										<div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="MontoCredito" name="MontoCredito" type="text" class="md-form-control" maxlength="13" readonly />
				                                <label for="MontoCredito">Monto a Financiar</label>
											</div>
					                    </div>
					                    <div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="NumeroCuotas" name="NumeroCuotas" type="text" class="md-form-control" maxlength="3" readonly />
				                                <label for="EstadoLocal">Nro. Cuotas</label>
											</div>
					                    </div>
										<div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="InteresMensual" name="InteresMensual" type="text" class="md-form-control" maxlength="5" readonly />
				                                <label for="EstadoLocal">Interes Mensual</label>
											</div>
					                    </div>
										<div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="MontoFinal" name="MontoFinal" type="text" class="md-form-control" maxlength="13" readonly />
				                                <label for="MontoFinal">Monto Final Crédito</label>
											</div>
					                    </div>
									</div>

									<div class="row">
										<div class="col-sm-6">
					                        <div class="md-input-wrapper">
												<input id="MontoCuota" name="MontoCuota" type="text" class="md-form-control" maxlength="13" readonly />
				                                <label for="MontoCuota">Monto Cuota</label>
											</div>
					                    </div>
					                    <div class="col-sm-6">
					                        <div class="md-input-wrapper">
												<input id="PrimeraCuota" name="PrimeraCuota" type="text" class="md-form-control" maxlength="20" readonly />
				                                <label for="PrimeraCuota">Fecha Primera Cuota</label>
											</div>
					                    </div>
									</div>

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
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('ventaCredito') }}"
	var d = [];
	d['v_credito_venta'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_credito_venta) }}'));

</script>
<script src="{{ asset('js/credito_venta/credito_venta.js') }}"></script>
@endsection