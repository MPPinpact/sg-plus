var RegistroEmpresas  = '';
var manejoRefresh=limpiarLocales=errorRut=limpiarBodegas=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        $(".divDetalles").toggle();
        bloquearInuts();
        $("#divVolver").show();
        pintarDatosActualizar(respuesta.respuesta);
        //cargarTablaProductos(respuesta.respuesta.v_productos);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});       
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_ciclos_facturacion.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargartablaCicloFacturacions(respuesta.respuesta.v_ciclos_facturacion);
            }
        }else{
            $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion de empresa
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormCicloFacturacion')[0].reset();
                $('#IdCicloFacturacion').val("");
                cargartablaCicloFacturacions(respuesta.respuesta.v_ciclos_facturacion);
                break;
            case '-2':
                $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
                break;
            default:
                $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
                break;
        } 
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
};

var cargartablaCicloFacturacions = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaCicloFacturacion');$('#tablaCicloFacturacion thead').empty();}
        $("#tablaCicloFacturacion").dataTable({ 
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [8]}
            ],
            "data": data,
            "columns":[
                {
                    "title": "", 
                    "data": "IdCicloFacturacion",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetalleCicloFacturacion(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Ciclo de Facturación" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusCicloFacturacion(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result; 
                    }
                },
                {"title": "IdCicloFacturacion","data": "IdCicloFacturacion",visible:0},
                {"title": "Dia de Pago","data": "DiaPago"},
                {"title": "Dia de Facturación","data": "DiaFacturacion"},
                {"title": "Estado Ciclo","data": "DetalleEstadoCiclo"},
				
                {"title": "fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0}
            ],
        });
        limpiarLocales=1;
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Ciclo de Facturación");
    $("#IdCicloFacturacion").val(data.IdCicloFacturacion);
    $("#DiaCorte").val(data.DiaPago);
    $("#DiaFacturacion").val(data.DiaFacturacion);
    $("#EstadoCiclo").val(data.EstadoCiclo).trigger("change");
}

var BotonCancelar = function(){
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Ciclos de Facturación Registrados");
    $('#divConsulta').hide();
    $('#FormCicloFacturacion')[0].reset();
    $("#IdCicloFacturacion").val("");
    $("#divTabs").show();
    $(".divDetalles").toggle();   
    $(".md-form-control").removeClass("md-valid");
    $('#divConsulta').hide();
    $(".divBotones").toggle();    
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Ciclo de Facturación");
    $("#divBtnModificar").hide();
    $("#divVolver").hide();
    $("#divBtnAceptar").show();
    $("#divConsulta").hide();
    $("#IdCicloFacturacion").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCicloFacturacion')[0].reset();
    $("#divTabs").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarCicloFacturacion = function(){
    if (errorRut==0){  
        var camposNuevo = {
            'EstadoCiclo': $('#EstadoCiclo').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCicloFacturacion").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
}

var validador = function(){
    $('#FormCicloFacturacion').formValidation('validate');
}

var cambiarEstatusCicloFacturacion = function(IdCicloFacturacion){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCicloFacturacion:IdCicloFacturacion};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetalleCicloFacturacion = function(IdCicloFacturacion){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdCicloFacturacion:IdCicloFacturacion};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);    
}

var bloquearInuts = function(){
    $("#DiaCorte").prop('readonly', true);
    $("#DiaFacturacion").prop('readonly', true);
    $("#EstadoCiclo").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#DiaCorte").prop('readonly', false);
    $("#DiaFacturacion").prop('readonly', false);
    $("#EstadoCiclo").prop('disabled', false);
}

var modificarCiclo = function(){
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();    
}

var volverTabs = function(){
    $(".divDetalles").toggle(); 
    $("#detalles").addClass("active");
    $("#adetalles").addClass("active");
    $("#productos").removeClass("active");
    $("#aproductos").removeClass("active");  
}

var crearAllSelect = function(data){
    crearselect(data.v_estados,"EstadoCiclo");
}

$(document).ready(function(){
    $("#spanTitulo").text("Ciclos de Facturación Registrados");
    cargartablaCicloFacturacions(d.v_ciclos_facturacion);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarCiclo);
    $(document).on('click','#volverAct',volverTabs); 

    $('#FormCicloFacturacion').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'DiaCorte': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }, 
            'DiaFacturacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },            
            'EstadoCiclo': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarCicloFacturacion();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});