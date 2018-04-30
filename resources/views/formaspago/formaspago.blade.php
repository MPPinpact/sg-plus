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
	        			Formas de Pago
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
							<table id="tablaFormaPago" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
									{!! Form::open(['id'=>'FormRegFormaPago','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdFormaPago', '', [
									'id'            => 'IdFormaPago',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="NombreFormaPago" name="NombreFormaPago" type="text" class="md-form-control md-static" maxlength="250" readonly />
					                            <label for="NombreFormaPago">Forma de Pago</label>
					                        </div>
										</div>
										<div class="col-md-4"></div>
									</div>									
									<br>
									<div class="row">
										<div class="col-sm-4"></div>
					                    <div class="col-sm-4">
												<label class="form-check-label">
							                    	<input name="PermitePagoCredito" id="PermitePagoCredito" type="checkbox" class="form-check-input"> Permite Pago de Credito Interno
							                    </label>
					                    </div>
					                    <div class="col-sm-4"></div>
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
	var ruta = "{{ URL::route('FormaPago') }}"
	var rutaA = "{{ URL::route('FormaPagoAtc') }}"
	var rutaD = "{{ URL::route('FormaPagoDet') }}"
	var d = [];
	d['v_formas_de_pago'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_formas_de_pago) }}'));
</script>
<script src="{{ asset('js/formaspago/formaspago.js') }}"></script>
@endsection