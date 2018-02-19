// var RegistroLocales  = '';
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
            if(respuesta.respuesta.v_credito_venta.length>0){
                $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                cargarTablaVentaCredito(respuesta.respuesta.v_credito_venta);
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
                $('#FormVentaCredito')[0].reset();
                $('#IdVentaCredito').val("");
                cargarTablaVentaCredito(respuesta.respuesta.v_credito_venta);
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

var cargarTablaVentaCredito = function(data){
    if(limpiarPreferencias==1){destruirTabla('#tablaVentasCredito');$('#tablaVentasCredito thead').empty();}
        $("#tablaVentasCredito").dataTable({ 
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
                    "data": "IdVentaCredito",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetalleVentaCredito(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Venta Crédito" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusLocal(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result; 
                    }
                },
                {"title": "Id Venta Crédito","data": "IdVentaCredito",visible:0},
                {"title": "Fecha Venta","data": "FechaVentaCredito"},
                {"title": "Monto Crédito","data": "MontoCredito"},
				{"title": "Nro. Cuotas","data": "NumeroCuotas"},
				{"title": "Monto Cuota","data": "MontoCuota"},
				{"title": "Primera Cuota","data": "PrimeraCuota"},
				
                {"title": "Fecha de creacion","data": "auFechaCreacion",visible:0},
                {"title": "Usuario creacion","data": "auUsuarioCreacion",visible:0},
                {"title": "auModificadoPor","data": "auUsuarioModificacion",visible:0},
                {"title": "auUsuarioModificacion","data": "auFechaModificacion",visible:0}
                
            ],
        });
        limpiarPreferencias=1;
    if (data.length>0){seleccionartablaVentasCredito();}
};

var seleccionartablaVentasCredito = function(data){
    var tableB = $('#tablaVentasCredito').dataTable();
    $('#tablaVentasCredito tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        // RegistroLocales = TablaTraerCampo('tablaVentasCredito',this);
    });
    // $('#tablaVentasCredito tbody').on('dblclick', 'tr', function () {
    //     bloquearInuts();
    //     $("#divVolver").show();
    //     $("#divBtnModificar").show();
    //     $("#divBtnAceptar").hide();  
    //     cargarFormulario();
    //     pintarDatosActualizar(RegistroLocales);
    // }); 
}

var pintarDatosActualizar= function(data){
    $(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Venta a Crédito");
    $("#IdVentaCredito").val(data.IdVentaCredito);
    // $("#NombreLocal").val(data.NombreLocal);
    // $("#IdEmpresa").val(data.IdEmpresa).trigger("change");
    // $("#IdEncargadoLocal").val(data.IdEncargadoLocal).trigger("change");
    // $("#EstadoLocal").val(data.EstadoLocal).trigger("change");
}

var pintarDatosDetalles = function(data){
    $("#IdVentaCredito").val(data.IdVentaCredito);
    // $("#NombreLocald").val(data.NombreLocal);
    // $("#IdEmpresad").val(data.IdEmpresa).trigger("change");
    // $("#IdEncargadoLocald").val(data.IdEncargadoLocal).trigger("change");
    // $("#EstadoLocald").val(data.EstadoLocal).trigger("change");
}

var BotonCancelar = function(){
    $("#divTabs").show();
    $(".divDetalles").toggle();   
    $(".md-form-control").removeClass("md-valid");
    $("#spanTitulo").text("Ventas a Crédito Registrados");
    $(".divForm").toggle();    
    $('#divConsulta').hide();
    $('#FormVentaCredito')[0].reset();
    $("#idUser").val("");
    $('#divSpanPerfiles').hide();
    $(".divBotones").toggle();    
    bloquearInuts();
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Venta a Crédito");
    $("#divConsulta").hide();
    $('#FormVentaCredito')[0].reset();
    $("#divTabs").hide();
    $("#divVolver").hide();
    $(".divDetalles").toggle();
    $(".divBotones").toggle();
    desbloquearInuts();
}

var ProcesarVentaCredito = function(){
    if (errorRut==0){  
        var camposNuevo = {
            'IdVentaCredito': $('#IdVentaCredito').val() 
        }
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormVentaCredito").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var validador = function(){
    $('#FormVentaCredito').formValidation('validate');
};

var verDetalleVentaCredito = function(IdVentaCredito){
    parametroAjax.ruta=ruta;
    parametroAjax.data = {IdVentaCredito:IdVentaCredito};
	alert(ruta +  " - " + IdVentaCredito);
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);    
}


var bloquearInuts = function(){
    $("#NombreCliente").prop('readonly', true);
    // $("#IdEmpresa").prop('disabled', true);
    // $("#IdEncargadoLocal").prop('disabled', true);
    // $("#EstadoLocal").prop('disabled', true);
}

var desbloquearInuts = function(){
    $("#NombreCliente").prop('readonly', false);
    // $("#IdEmpresa").prop('disabled', false);
    // $("#IdEncargadoLocal").prop('disabled', false);
    // $("#EstadoLocal").prop('disabled', false);
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
    $("#spanTitulo").text("Ventas a Crédito Registradas");
    cargarTablaVentaCredito(d.v_credito_venta);
    // crearAllSelect(d);
    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('cick','#agregar',BotonAgregar);
    // $(document).on('click','#modificar',modificarLocal);
    $(document).on('click','#volverAct',volverTabs); 
    $('#FormVentaCredito').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'NombreCliente': {
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
        ProcesarVentaCredito();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});