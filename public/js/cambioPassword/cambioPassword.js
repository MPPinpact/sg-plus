var RegistroUsuario = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuesta = function(respuesta){
    if (respuesta.code=!'200'){
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
        return 0;
    }else{
            if (respuesta.respuesta.code!='200'){
                $.growl({message:respuesta.respuesta.des_code},{type: "warning", allow_dismiss: true,});
                return 0;
            }else{
                $.growl({message:respuesta.respuesta.des_code},{type: "success", allow_dismiss: true,});
                Boton_cancelar();
                return 0;
            }
    }
};
var Boton_cancelar = function(){
     $('#Formclave')[0].reset();
}
var cambiarClave = function(){
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#Formclave").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuesta(respuesta);
};
var validador = function(){
 $('#Formclave').formValidation('validate');
};
var boton_cancelar = function(){
    $(".inputClear").val("");
};

$(document).ready(function(){
    $(document).on('click','#aceptar',validador);
    $(document).on('click','#cancelar',boton_cancelar);
    $('#Formclave').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'password_old': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'password': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'password_confirmation': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        cambiarClave();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});