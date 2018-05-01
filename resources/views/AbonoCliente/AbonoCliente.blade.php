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
	        		<h5 class="card-header-text">
	        			Abono Cliente
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
						<div class="col-md-2"></div>
						<div class="col-md-8 table-responsive">
							<table id="TablaAbonoCliente" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
						<div class="col-md-2"></div>
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
							<!-- <div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="adetalles" class="nav-link active" data-toggle="tab" href="#detalles" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Detalles de Proveedor
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
							</div> -->
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <!-- <div class="tab-pane active" id="detalles" role="tabpanel"> -->
									<br><br>
									{!! Form::open(['id'=>'FormAbonoCliente','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdAbono', '', ['id'=> 'IdAbono'])!!}
									{!! Form::hidden('IdClienteAbono', '', ['id'=> 'IdClienteAbono'])!!}

									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<input type="hidden" name="IdCaja" id="IdCaja">
									<input type="hidden" name="IdLocal" id="IdLocal">
									
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-sm-3">
					                        <div class="md-input-wrapper">
												<input id="RUTClienteAbono" name="RUTClienteAbono" type="text" class="md-form-control md-static" maxlength="250" readonly />
												<label for="RUTCliente">RUT Cliente</label>
							                    <small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
					                    <div class="col-sm-5">
					                        <div class="md-input-wrapper">
												<input id="NombreClienteAbono" name="NombreClienteAbono" type="text" class="md-form-control md-static" maxlength="250" readonly />
				                                <label for="EstadoAbono">Nombre Cliente</label>
											</div>
					                    </div>
										<div class="col-md-2"></div>
									</div>									
									<br>

									<div class="row">
										<div class="col-md-2"></div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="IdFormaPago" id="IdFormaPago" class="md-disable md-valid" disabled></select>
				                                <label for="IdFormaPago">Forma de Pago</label>
											</div>
					                    </div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="MontoAbono" name="MontoAbono" type="text" class="md-form-control md-static" maxlength="250" readonly />
					                            <label for="MontoAbono">Monto a abonar</label>
					                        </div>
										</div>
										<div class="col-md-2"></div>
									</div>									
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
		                        <!-- </div> -->
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('AbonoCliente') }}"
	var rutaA = "{{ URL::route('AbonoClienteAtc') }}"
	var rutaD = "{{ URL::route('AbonoClienteDet') }}"
	var rutaBC = "{{ URL::route('AbonoClienteBC') }}"
	var rutaCD = "{{ URL::route('infoCD') }}"
	 var d = [];
	 d['v_abono_cliente'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_abono_cliente) }}'));
	 d['v_formas_pago'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_formas_pago) }}'));
</script>
<script src="{{ asset('js/abonocliente/abonocliente.js') }}"></script>
@endsection