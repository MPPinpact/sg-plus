var RegistroAcceso = '';
var RegistroAccesoLocal = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaSeleccionarLocal = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.code==200){
            window.location.href = respuesta.respuesta.des_code;
        }else{
            toastr.warning(respuesta.respuesta.des_code, "Info!");
        }
    }else{
        toastr.error("Contacte al personal informatico", "Error!");
    }
}



var seleccionarLocal = function(IdLocal){
    $('#IdLocal').val(IdLocal);
    
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#FormSelectLocal").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaSeleccionarLocal(respuesta);
}


$(document).ready(function(){

    $(document).on('click','#btn-logout',Salir);

    $('.goAccess').click(function() {
          seleccionarLocal($(this).data('datac'));
    });

});
