var RegistroLocales  = '';
var manejoRefresh=limpiarPreferencias=errorRut=limpiarBodegas=0;

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
        $("#divVolver").show();
        bloquearInuts();
        // pintarDatosActualizar(respuesta.respuesta.v_detalles[0]);
        // cargarTablaBodegas(respuesta.respuesta.v_bodegas);
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});       
    }

}
// Manejo Activar / Desactivar empresa
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.activar>0){
            if(respuesta.respuesta.v_credito_preferencias.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaPreferencia(respuesta.respuesta.v_credito_preferencias);
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
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_local);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divDetalles").toggle();
                $(".divBotones").toggle();
                $('#FormCredito')[0].reset();
                $('#IdLocal').val("");
                cargarTablaPreferencia(respuesta.respuesta.v_credito_preferencias);
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

var cargarTablaPreferencia = function(data){
    if(limpiarPreferencias==1){destruirTabla('#tablaPreferencias');$('#tablaPreferencias thead').empty();}
        $("#tablaPreferencias").dataTable({ 
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
                    "title": " ", 
                    "data": "IdCreditoPreferencia",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesVenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Preferencia" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusLocal(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result; 
                    }
                },
                {"title": "Id Preferencia","data": "IdCreditoPreferencia",visible:0},
                {"title": "Fecha de Inicio","data": "FechaInicio"},
                {"title": "Fecha de Fin","data": "FechaFin"},
				{"title": "Interes Mensual","data": "InteresMensual"},
				{"title": "Max de Cuotas","data": "NumeroMaxCuotas"},
				{"title": "Primera Cuota","data": "TolenranciaDiasPrimeraCuota"},
				{"title": "Deuda Vencida","data": "AdvertenciaDeudaVencida"},
				{"title": "Monto Mantención","data": "MontoMantencionCuenta"}, 
				{"title": "Estado","data": "DetalleEstadoPreferencia"},
				
                {"title": "Fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0}
                
            ],
        });
        limpiarPreferencias=1;
    if (data.length>0){seleccionartablaPreferencias();}
};

var seleccionartablaPreferencias = function(data){
    var tableB = $('#tablaPreferencias').dataTable();
    $('#tablaPreferencias tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroLocales = TablaTraerCampo('tablaPreferencias',this);
    });
    // $('#tablaPreferencias tbody').on('dblclick', 'tr', function () {
    //     bloquearInuts();
    //     $("#divVolver").show();
    //     $("#divBtnModificar").show();
    //     $("#divBtnAceptar").hide();  
    //     cargarFormulario();
    //     pintarDatosActualizar(RegistroLocales);
    // }); 
}

var cargarTablaBodegas = function(data){
    if(limpiarBodegas==1){destruirTabla('#tablaBodegas');}
        $("#tablaBodegas").dataTable({ 
             responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "language": LenguajeTabla,
            "columnDefs": [
            {
                "targets": [ 1 ],
                "searchable": false
            }],
            "data": data,
            "columns":[
            {"title": "Id","data": "IdBodega",visible:0},
            {"title": "Nombre","data": "NombreBodega"},
            {"title": "Descripción","data": "DescripcionBodega"},
            {"title": "Estado","data": "desEstadoBodega"},
            ],
        });
        limpiarBodegas=1; 
};

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Preferencias");
    $("#IdLocal").val(data.IdLocal);
    $("#NombreLocal").val(data.NombreLocal);
    $("#IdEmpresa").val(data.IdEmpresa).trigger("change");
    $("#IdEncargadoLocal").val(data.IdEncargadoLocal).trigger("change");
    $("#EstadoLocal").val(data.EstadoLocal).trigger("change");
}

var pintarDatosDetalles = function(data){
    $("#IdLocald").val(data.IdLocal);
    $("#NombreLocald").val(data.NombreLocal);
    $("#IdEmpresad").val(data.IdEmpresa).trigger("change");
    $("#IdEncargadoLocald").val(data.IdEncargadoLocal).trigger("change");
    $("#EstadoLocald").val(data.EstadoLocal).trigger("change");
}

var BotonCancelar = function(){
    $("#divTabs").show();
    $(".divDetalles").toggle();   
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Locales registrados");
    $(".divForm").toggle();    
    $('#divConsulta').hide();
    $('#FormCredito')[0].reset();
    $("#idUser").val("");
    $('#divSpanPerfiles').hide();
    $(".divBotones").toggle();    
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Local");
    $("#divConsulta").hide();
    $("#divSpanPerfiles").hide();
    $("#idUser").val("");
    $(".comboclear").val('').trigger("change");
    $('#FormCredito')[0].reset();
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarCreditoVenta = function(){
    if (errorRut==0){  
        var camposNuevo = {
            'IdCreditoVenta': $('#IdCreditoVenta').val(), 
            'EstadoCreditoVenta': $('#EstadoCreditoVenta').val()
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormCreditoVenta").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormCredito').formValidation('validate');
};

var cambiarEstatusPreferencia = function(IdCreditoVenta){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdCreditoVenta:IdCreditoVenta};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesVenta = function(IdCreditoVenta){
    parametroAjax.ruta=rutaD;
    parametroAjax.data = {IdCreditoPreferencia:IdCreditoPreferencia};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);    
}


var bloquearInuts = function(){
    $("#NombreLocal").prop('readonly', true);
    $("#IdEmpresa").prop('disabled', true);
    $("#IdEncargadoLocal").prop('disabled', true);
    $("#EstadoLocal").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreLocal").prop('readonly', false);
    $("#IdEmpresa").prop('disabled', false);
    $("#IdEncargadoLocal").prop('disabled', false);
    $("#EstadoLocal").prop('disabled', false);
}

var modificarPreferencia = function(){
    $("#divVolver").hide();
    $(".divBotones").toggle();
    desbloquearInuts();    
}

var volverTabs = function(){
    $(".divDetalles").toggle();          
    $("#adetalles").addClass("active");
    $("#detalles").addClass("active");
    $("#bodegas").removeClass("active");
    $("#abodegas").removeClass("active");
}

var crearAllSelect = function(data){
    var encargado =[{"id":"1","text":"Encargado 1"},{"id":"2","text":"Encargado 2"}];
    // crearselect(encargado,"IdEncargadoLocal");
    // crearselect(encargado,"IdEncargadoLocald");
    // crearselect(data.v_empresas,"IdEmpresa");
    // crearselect(data.v_estados,"EstadoLocal");
    // crearselect(data.v_empresas,"IdEmpresad");
    // crearselect(data.v_estados,"EstadoLocald");
}

$(document).ready(function(){
    $("#spanTitulo").text("Venta a Crédito Registradas");
    cargarTablaPreferencia(d.v_credito_preferencias);
    crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('cick','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarLocal);
    $(document).on('click','#volverAct',volverTabs); 
    $('#FormCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreLocal': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }, 
            'IdEmpresa': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },            
            'IdEncargadoLocal': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    }
                }
            },
            'EstadoLocal': {
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
        ProcesarCreditoVenta();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});