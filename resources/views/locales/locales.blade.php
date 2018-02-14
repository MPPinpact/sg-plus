@extends('menu.index')
@section('content')
<style type="text/css" media="screen">
	.nav-tabs .slide{
		 width: calc(100% / 2)!important;
	}
</style>
<div class="row">
	@include('menu.mantenedores')
	<div class="col-md-10 divDetalles">
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
							<table id="tablaLocales" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
						</div>
					</div>
		        </div>
				<div style="display:none;" class="col-md-12 divForm">
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::open(['id'=>'FormLocal','autocomplete' => 'off']) !!}
					{!! Form::hidden('IdLocal', '', [
					'id'            => 'IdLocal',
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
		                            <a class="nav-link active" data-toggle="tab" href="#detalles" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Detalles de Local
		                            </a>
		                            <div class="slide"></div>
		                        </li>
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#bodegas" role="tab">
		                                <div class="f-26">
		                                    <i class="icofont icofont-document-search"></i>
		                                </div>
		                                Locales Asociados
		                           	</a>
		                            <div class="slide"></div>
		                        </li>
		                    </ul>
		                    <!-- Tab panes -->
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="detalles" role="tabpanel">
		                            <form class="md-float-material card-block">
										<div class="row">
											<div class="col-sm-2"></div>
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
					                                <input id="NombreLocald" name="NombreLocald" type="text" class="md-form-control md-valid" maxlength="250" readonly />
						                            <label for="NombreLocal">Nombre Local</label>
						                        </div>
											</div>
						                    <div class="col-sm-4">
						                        <div class="md-input-wrapper">
						                        	<select name="IdEmpresad" id="IdEmpresad" class="md-disable md-valid" disabled></select>
					                                <label for="IdEmpresa">Empresa</label>
						                        </div>
						                    </div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-2"></div>
											<div class="col-sm-4">
						                        <div class="md-input-wrapper">
													<select name="IdEncargadoLocald" id="IdEncargadoLocald" class="md-disable md-valid" disabled></select>
					                                <label for="IdEncargadoLocal">Encargado</label>
												</div>
						                    </div>
						                    <div class="col-sm-4">
						                        <div class="md-input-wrapper">
													<select name="EstadoLocald" id="EstadoLocald" class="md-disable md-valid" disabled></select>
					                                <label for="EstadoLocal">Estado</label>
												</div>
						                    </div>
										</div>
		                            </form>
		                        </div>
		                        <div class="tab-pane" id="bodegas" role="tabpanel">
									<div class="row">
										<div class="col-md-12 table-responsive">
											<table id="tablaBodegas" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
										</div>
									</div>
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
	var ruta = "{{ URL::route('locales') }}"
	var rutaA = "{{ URL::route('activarL') }}"
	var rutaD = "{{ URL::route('detallesL') }}"
	var d = [];
	d['v_locales'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_locales) }}'));
	d['v_empresas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_empresas) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
</script>
<script src="{{ asset('js/locales/locales.js') }}"></script>
@endsection