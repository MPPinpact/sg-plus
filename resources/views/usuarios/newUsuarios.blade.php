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
	        			Listado de Usuarios Registrados
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
							<table id="tablaUsuarios" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
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
			    	<h5 id="spanTituloUsuarios" class="card-header-text"></h5>
		    	</center>
		    </div>
		    <div class="card-block">
	        	<div class="row">
					<div class="col-md-12">
						<button style="float:right;" name="botonVolverListado" id="botonVolverListado" type="button" class="btn btn-primary waves-effect waves-light">
							<span>Listado de Usuarios</span>
            			</button>
					</div>
				</div>
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="product-edit">
							<div id="divTabs">
			                    <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
			                        <li class="nav-item">
			                            <a id="tUsuario" class="nav-link active" data-toggle="tab" href="#TabUsuario" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Información de Usuario
			                            </a>
			                            <div class="slide"></div>
			                        </li>
			                        <li class="nav-item">
			                            <a id="tLocales" class="nav-link" data-toggle="tab" href="#TabLocales" role="tab">
			                                <div class="f-26">
			                                    <i class="icofont icofont-document-search"></i>
			                                </div>
			                                Locales
			                           	</a>
			                            <div class="slide"></div>
			                        </li>
			                    </ul>
			                </div>
		                    <!-- Tab panes -->
							<br><br>
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="TabUsuario" role="tabpanel">
									{!! Form::open(['id'=>'FormUsuario','autocomplete' => 'off']) !!}
									{!! Form::hidden('idUser', '', [
									'id'            => 'idUser',
									'class'         => 'form-control'])!!}
									<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
									
									<div class="row">
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="usrUserName" name="usrUserName" type="text" class="md-form-control md-static" maxlength="12" readonly />
												<label>Login</label>
												<small id="ErrorRut" class="rut-error"></small>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="usrNombreFull" name="usrNombreFull" type="text" class="md-form-control md-static" maxlength="50" readonly />
												<label>Nombres</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="usrNickName" name="usrNickName" type="text" class="md-form-control md-static" maxlength="50" readonly />
												<label>Nick Name</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="md-input-wrapper">
												<input id="usrEmail" name="usrEmail" type="text" class="md-form-control md-static" maxlength="50" readonly />
												<label for="usrEmail">Email:</label>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-4" id="divSpanPerfiles">
											<div class="md-input-wrapper">
												<input id="usrUltimaVisita" name="usrUltimaVisita" type="text" class="md-form-control md-valid md-static" maxlength="50" readonly />
												<label for="usrUltimaVisita">Última visita:</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="idPerfil" id="idPerfil" class="md-disable md-valid" disabled></select>
												<label for="idPerfil">Perfíl</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="md-input-wrapper">
												<select name="usrEstado" id="usrEstado" class="md-disable md-valid" disabled></select>
												<label for="">Estado</label>
											</div>
										</div>
									</div>
									<br>
									<div id="divConsulta" style="display:none;">
										<div class="row">
											<div class="col-md-3">
												<div class="md-input-wrapper">
													<input id="auCreadoEl" name="auCreadoEl" type="text" class="md-form-control md-valid md-static" maxlength="50" readonly />
													<label for="auCreadoEl">Creado el:</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="md-input-wrapper">
													<input id="creador" name="creador" type="text" class="md-form-control md-valid md-static" maxlength="50" readonly />
													<label for="creador">Creado por:</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="md-input-wrapper">
													<input id="auModificadoEl" name="auModificadoEl" type="text" class="md-form-control md-valid md-static" maxlength="50" readonly />
													<label for="auModificadoEl">Modificado el:</label>
												</div>
											</div>
											<div class="col-md-3">
												<div class="md-input-wrapper">
													<input id="modificador" name="modificador" type="text" class="md-form-control md-valid md-static" maxlength="50" readonly />
													<label for="modificador">Modificado por:</label>
												</div>
											</div>
										</div>
									</div>
									<br />
									<div align="center">
										<div class="pull-rigth">
											<div id="divBtnModificar" class="divBotones">
												<button id="botonModificar" name="botonModificar" type="button" class="btn btn-primary waves-effect waves-light">
													Modificar
												</button>
											</div>
											<div id="divBtnAceptar" class="divBotones" style="display:none;">
												<button id="botonCancelar" name="botonCancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
													Cancelar
												</button>
					                			<button id="botonGuardar" name="botonGuardar" type="button" class="btn btn-primary waves-effect waves-light">
													Continuar
					                			</button>
											</div>
										</div>
									</div>
									{!! Form::close() !!}
		                        </div>
		                        <div class="tab-pane" 		 id="TabLocales" role="tabpanel">
									<div class="row">
										<div class="col-md-6">
											<div class="col-md-12 table-responsive">
												<table id="tablaLocales" class="table table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
											</div>
										</div>
										<div class="col-md-6">
											Hola
										</div>
									</div>
									<br />
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>

<!--Modal Consulta Stock Producto -->
<div class="modal fade" id="ModalAsociarLocalUsuario" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 1030 !important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 id="spanTituloModal" class="modal-title">Asociar Local al Usuario</h6>
            </div>
            <div class="modal-body">
				{!! Form::open(['id'=>'FormAsociarLocal','autocomplete' => 'off']) !!}
					<input type="hidden" name="IdUsuarioLocal" id="IdUsuarioLocal">
					<div class="row" >
						<div class="col-md-12">
							<div class="md-input-wrapper">
								<select name="IdLocal" id="IdLocal" class="md-valid"></select>
								<label for="IdLocal">Seleccione Local</label>
							</div>
						</div>
					</div>
						
					<div class="row" id="">
						<div class="col-md-6">
							<button id="cancelarBPS" type="button" class="btn-xlg btn-danger waves-effect waves-light btn-block" data-dismiss="modal">
								Cerrar
							</button>
						</div>
						<div class="col-md-6">
							<button id="botonAsociarLocal" name="botonAsociarLocal" type="button" class="btn-xlg btn-success waves-effect waves-light btn-block ">
								<i class="icon-check"></i>  Asociar Local
							</button>
						</div>
					</div>	
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script Language="Javascript">
	var ruta = "{{ URL::route('usuarios') }}"
	var rutaUB = "{{ URL::route('buscarUsuario') }}"
	
	var rutaR = "{{ URL::route('reiniciar') }}"
	var rutaA = "{{ URL::route('activar') }}"
	var rutaP = "{{ URL::route('perfiles') }}"
	var rutaAP = "{{ URL::route('activarP') }}"
	var rutaDC = "{{ URL::route('desbloquearC') }}"
	var rutaBL = "{{ URL::route('buscarLocales') }}"
	var rutaALU = "{{ URL::route('agregarLocalUsuario') }}"
	var rutaTLU = "{{ URL::route('agregarTodosLocalUsuario') }}"
	
	var rutaELU = "{{ URL::route('eliminarLocalUsuario') }}"
	
	var d = [];
	d['v_usuarios'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_usuarios) }}'));
	d['v_perfiles'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_perfiles) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_perfil'] = JSON.parse(rhtmlspecialchars('{{ $v_perfil }}'));
</script>
<script src="{{ asset('js/usuarios/newUsuario.js') }}"></script>
@endsection
