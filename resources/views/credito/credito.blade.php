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
							<table id="tablaPreferencias" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
			                                Datos Preferencia
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
							</div>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
                   					<br><br>
                   					{!! Form::open(['id'=>'FormCredito','autocomplete' => 'off']) !!}
									{!! Form::hidden('IdCreditoPreferencia', '', [
									'id'            => 'IdCreditoPreferencia',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									<div class="row">
										<div class="col-sm-2"></div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
				                                <input id="NombreLocal" name="NombreLocal" type="text" class="md-form-control" maxlength="250" readonly />
					                            <label for="NombreLocal">Nombre Local</label>
					                        </div>
										</div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
					                        	<select name="IdEmpresa" id="IdEmpresa" class="md-disable md-valid" disabled></select>
				                                <label for="IdEmpresa">Empresa</label>
					                        </div>
					                    </div>
									</div>
									<br>
									<div class="row">
										<div class="col-sm-2"></div>
										<div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="IdEncargadoLocal" id="IdEncargadoLocal" class="md-disable md-valid" disabled></select>
				                                <label for="IdEncargadoLocal">Encargado</label>
											</div>
					                    </div>
					                    <div class="col-sm-4">
					                        <div class="md-input-wrapper">
												<select name="EstadoLocal" id="EstadoLocal" class="md-disable md-valid" disabled></select>
				                                <label for="EstadoLocal">Estado</label>
											</div>
					                    </div>
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
		                        </div>
		                        <div class="tab-pane" id="bodegas" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaBodegas" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
	var ruta = "{{ URL::route('credito') }}"
	var d = [];
	d['v_credito_preferencias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_credito_preferencias) }}'));
	
</script>
<script src="{{ asset('js/credito/credito.js') }}"></script>
@endsection