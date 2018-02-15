@extends('menu.index')
@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-header">
	        	<center>
	        		<h5 id="spanTitulo" class="card-header-text"></h5>
                </center>
	        </div>
	        <div class="card-block">
				<div class="col-md-12 divForm">
			        <div class="divPerfiles">	
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
					<div class="divPerfiles" style="display:none;">
						<br>
						<div class="row">
							<div class="col-md-12">
						        <button style="float:right;" id="volverPerfiles" type="button" class="btn btn-inverse-primary waves-effect waves-light">
									Volver
								</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-7">
										<form id="FormPerfil" method="POST">
											<input type="hidden" id="idUser2">
											<!-- <select class="comboclear form-control m-select2" id="idPerfil" name="idPerfil" style="width:100%;">
												<option value="">Seleccione..</option>
											</select> -->
										</form>
									</div>
									
									<div class="col-md-3">
			                			<button name="agregarP" id="agregarP" type="button" class="btn btn-primary waves-effect waves-light">
											Agregar
			                			</button>
									</div>
									<div class="col-md-1"></div>
								</div>
								<div class="table-responsive" id="divTablaPerfiles" style="display:none;">
									<table id="tablaPerfiles" class="table compact table-striped dt-responsive nowrap table-hover" cellspacing="0" width="100%"></table>
								</div>
							</div>
							<div class="col-md-2"></div>
						</div>
					</div>
		        </div>
				<div style="display:none;" class="col-md-12 divForm">
					{!! Form::open(['id'=>'FormUsuario','autocomplete' => 'off']) !!}
					<div class="row">
						<div id="divVolver" class="col-md-12">
							<a style="float:right;" id="volverAct" href="#"><u>volver</u></a>
						</div>
					</div>
					{!! Form::hidden('idUser', '', [
					'id'            => 'idUser',
					'class'         => 'form-control'])!!}
					<input type="hidden" name="idProveedor" id="idProveedor" value="0">
					<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
					<div class="row">
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
                                <input id="usrUserName" name="usrUserName" type="text" class="md-form-control" maxlength="12" readonly />
	                            <label>Login</label>
		                        <small id="ErrorRut" class="rut-error"></small>
	                        </div>
						</div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
	                        	<input id="usrNombreFull" name="usrNombreFull" type="text" class="md-form-control vtNombrelmayall" maxlength="50" readonly />
	                            <label>Nombres</label>
	                        </div>
	                    </div>
	                    <div class="col-sm-4">
	                        <div class="md-input-wrapper">
								<input id="usrEmail" name="usrEmail" type="text" class="md-form-control" maxlength="50" readonly />
								<label for="usrEmail">Email:</label>
							</div>
	                    </div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<div class="md-input-wrapper">
                                <select name="usrEstado" id="usrEstado" class="md-disable md-valid" disabled></select>
                                <label for="">Estado</label>
                            </div>
						</div>
						<div class="col-sm-4">
	                        <div class="md-input-wrapper">
	                         	<select name="idPerfil" id="idPerfil" class="md-disable md-valid" disabled></select>
                                <label for="idPerfil">Perfíl</label>
							</div>
						</div>
					</div>
					<br>
					<div id="divConsulta" style="display:none;">
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-4" id="divSpanPerfiles" style="display:none;">
								<div class="md-input-wrapper">
									<input id="usrUltimaVisita" name="usrUltimaVisita" type="text" class="md-form-control md-valid" maxlength="50" readonly />
									<label for="usrUltimaVisita">Última visita:</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="auCreadoEl" name="auCreadoEl" type="text" class="md-form-control md-valid" maxlength="50" readonly />
									<label for="auCreadoEl">Creado el:</label>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="creador" name="creador" type="text" class="md-form-control md-valid" maxlength="50" readonly />
									<label for="creador">Creado por:</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="auModificadoEl" name="auModificadoEl" type="text" class="md-form-control md-valid" maxlength="50" readonly />
									<label for="auModificadoEl">modificado el:</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="md-input-wrapper">
									<input id="modificador" name="modificador" type="text" class="md-form-control md-valid" maxlength="50" readonly />
									<label for="modificador">modificado por:</label>
								</div>
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
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('usuarios') }}"
	var rutaR = "{{ URL::route('reiniciar') }}"
	var rutaA = "{{ URL::route('activar') }}"
	var rutaP = "{{ URL::route('perfiles') }}"
	var rutaAP = "{{ URL::route('activarP') }}"
	var rutaDC = "{{ URL::route('desbloquearC') }}"
	var d = [];
	d['v_usuarios'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_usuarios) }}'));
	d['v_perfiles'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_perfiles) }}'));
	d['v_estados'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_estados) }}'));
	d['v_perfil'] = JSON.parse(rhtmlspecialchars('{{ $v_perfil }}'));
</script>
<script src="{{ asset('js/usuarios/usuarios.js') }}"></script>
@endsection