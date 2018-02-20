<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row" style="margin-top: 15%">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="sign-in-up">
                <div class="sign-in-up-left">
                    <div class="clear">
                        <i class="icofont icofont-users f-64" aria-hidden="true"></i>
                        <p></p>
                        <b>
                            SG PLUS DEV
                        </b>
                    </div>
                </div>
                <div class="sign-in-up-right">
                    <div class="row divLogin">
                        <div>
                            <center>
                                <p id="InicioSesion" class="SpanTitulo">
                                    Inicio de sesión
                                </p>
                            </center>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <form id="FormLogin" class="form-horizontal" novalidate>
                                <div class="md-input-wrapper form-group">
                                    <input type="text" class="md-form-control md-static" name="usrUserName" id="usrUserName"/>
                                    <label>Login</label>
                                    <small id="ErrorRut" class="rut-error"></small>
                                </div>
                                <div class="md-input-wrapper form-group">
                                    <input type="password" class="md-form-control md-static" name="usrPassword" id="usrPassword"/>
                                    <label>Password</label>
                                </div>
                                <div class="md-float-group b-none m-b-20">
                                    <div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
                                        <label class="input-checkbox checkbox-primary">
                                            <input type="checkbox" id="checkbox1">
                                            <span class="checkbox"></span>
                                        </label>
                                        <label for="checkbox" class="captions">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center m-b-20">
                                    <button id="EnviarLogin" type="button" class="btn btn-primary waves-effect">
                                        Iniciar Sesión
                                    </button>
                                </div>
                            </form>

                            <div class="text-center">
                                <p>
                                    <a href="#" id="LinkForgot">
                                        Olvido su contraseña?
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row divLogin" style="display:none;">
                        <div>
                            <form id="FormPasswd" class="form-horizontal" novalidate>
                                <div class="md-input-wrapper form-group">
                                    <input type="email" name="usrEmail" id="usrEmail" class="md-form-control md-static" />
                                    <label>Email</label>
                                </div>
                                <div class="text-center m-b-20">
                                    <button type="button" id="VolverLogin" class="btn btn-default waves-effect">Cancelar</button>
                                    <button type="button" id="EnviarPasswd" class="btn btn-primary waves-effect">Enviar</button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo e(asset('js/login/login.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>