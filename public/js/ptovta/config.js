var manejoRefresh=limpiarLocales=limpiarCajas=limpiarDetalleCaja=errorRut=errorRut2=errorRut3=limpiarBodegas=NVenta=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var GuardarConfiguracion = function(){
    console.log("GuardarConfiguracion()");

    parametroAjax.ruta=rutaOPV;
    parametroAjax.data = $("#FormOpcionesPtoVta").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaGuardarConfiguracion(respuesta);

}

var ManejoRespuestaGuardarConfiguracion = function(respuesta){  
    if(respuesta.code==200){
        $.growl({message:"Opciones del Punto de Venta Actualizadas correctamente!!!"},{type: "success", allow_dismiss: true,});

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});

    }
}

$(window).on('load', function() {
    var $window = $(window);
    $('.loader-bar').animate({ width:$window.width()},2000);
    setTimeout(function() {
        while ($('.loader-bar').width() == $window.width()) {
            removeloader();
            break;
        }
    }, 2500);

    $('.loader-bg').fadeOut('slow');

});

$(document).ready(function(){
    
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

    $(".js-example-basic-multiple").select2({
        placeholder: "Seleccione las formas de pago"
    });

    $(document).on('click','#botonGuardarConfiguracion', GuardarConfiguracion);
    
    

});
