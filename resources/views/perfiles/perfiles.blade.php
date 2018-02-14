@extends('menu.index')
@section('content')
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 id="spanTitulo" class="card-header-text">Actualización de datos</h5>
            </div>
            <div class="card-block">
                {!! Form::open(['id'=>'FormDatos','autocomplete' => 'off']) !!}
                {!! Form::hidden('idUser', '', [
                'id'            => 'idUser',
                'class'         => 'form-control'])!!}
                <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <div class="row form-group">
                            <div class="md-input-wrapper">
                                <input id="usrUserName" name="usrUserName" type="text" class="md-form-control md-valid" maxlength="50" readonly />
                                <label for="usrUserName">Login</label>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <div class="md-input-wrapper">
                                <input id="usrNombreFull" name="usrNombreFull" type="text" class="md-form-control md-valid" maxlength="50" readonly />
                                <label for="usrNombreFull">Nombres</label>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <div class="md-input-wrapper">
                                <input id="usrEmail" name="usrEmail" type="text" class="md-form-control md-valid" maxlength="50" readonly />
                                <label for="usrEmail">Email</label>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <div class="md-input-wrapper">
                                <input id="usrUltimaVisita" name="usrUltimaVisita" type="text" class="md-form-control md-valid" maxlength="50" readonly />
                                <label for="usrUltimaVisita">Última visita</label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="md-input-wrapper">
                                <input id="auCreadoEl" name="auCreadoEl" type="text" class="md-form-control md-valid" maxlength="50" readonly />
                                <label for="auCreadoEl">Fecha de creación</label>
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <div class="pull-rigth">
                                <div class="divBotonera">
                                     <button name="modificar" id="modificar"  type="button" class="btn btn-primary waves-effect waves-light">
                                        Modificar
                                    </button>
                                </div>
                                <div class="divBotonera" style="display:none;">
                                    <button name="cancelar" id="cancelar" type="button" class="btn btn-inverse-primary waves-effect waves-light">
                                        Cancelar
                                    </button>
                                    <button name="guardar" id="guardar"  type="button" class="btn btn-primary waves-effect waves-light">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div>
                            <center>
                                <a href="#">
                                    <br>
                                    @if ($avatar = 'default.jpg') @endif
                                    <input type="hidden" id="usrUrlimage" name="usrUrlimage">
                                    <div>
                                        <img name="foto-perfil" id="foto-perfil" class="gavatar rounded-circle" alt="" src='{!! asset("img/$avatar") !!}'>
                                    </div>
                                </a>
                                <br>
                                <label>Cargar o cambiar foto de perfil</label>
                                <br>
                                <div>
                                    <input type="file" name="foto" id="foto">
                                </div>
                                <br>
                                <label class="help-block">Archivo png o jpg no mayor a 2  megabytes (MB)</label>
                                <br>
                                <div>
                                    <button name="eliminar" id="eliminar" type="button" class="btn btn-default btn-icon waves-effect waves-light">
                                        <i class="icofont icofont-ui-close"></i>
                                    </button>
                                    <button name="cargar" id="cargar" type="button" class="btn btn-primary btn-icon waves-effect waves-light">
                                        <i class="icofont icofont-ui-check"></i>
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div> 
                {!! Form::close() !!} 
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    var ruta = "{{ URL::route('perfil') }}"
    var rutaE = "{{ URL::route('fotoe') }}"
    var rutaC = "{{ URL::route('fotoc') }}"
    var d = [];
    d['v_datos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_datos) }}'));
</script>
<script src="/js/perfiles/perfiles.js"></script>
@endsection