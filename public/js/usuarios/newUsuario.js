var manejoRefresh=limpiarUsuarios=limpiarLocales=errorRut=errorRut2=errorRut3=limpiarBodegas=NPreventa=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaVerInfoUsuario = function(respuesta){
	console.log("ManejoRespuestaVerInfoUsuario() --> Code: " + respuesta.code);
	
	/* Detalle de usuario */
    if(respuesta.code==200){
        //NPreventa=respuesta.respuesta.v_usuario[0].idPreVenta;
        bloquearInputs();
        $("#divBtnModificar").show();
        $("#divBtnAceptar").hide();
        $(".divDetalles").toggle();
        $("#divTabs").show();

        pintarDatosActualizar(respuesta.respuesta.v_usuario[0]);
        cargarTablaLocales(respuesta.respuesta.v_localesUsuario);
        crearselect(respuesta.respuesta.v_localesDisponibles,"IdLocal");

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaAsociarLocal = function(respuesta){
    console.log("ManejoRespuestaAsociarLocal() --> Code: " + respuesta.code);
    
    if(respuesta.code==200){
        pintarDatosActualizar(respuesta.respuesta.v_usuario[0]);
        cargarTablaLocales(respuesta.respuesta.v_localesUsuario);
        crearselect(respuesta.respuesta.v_localesDisponibles,"IdLocal");

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var desbloquearCuenta = function(idUser){
    parametroAjax.ruta=rutaDC;
    parametroAjax.data = {idUser:idUser};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaDesbloquearCuenta(respuesta);
}

var ManejoRespuestaDesbloquearCuenta = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.v_desbloqueo);
        if(res.code==200){
            $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
            cargarTablaUsuarios(respuesta.respuesta.v_usuarios);
        }else{
            $.growl({message:"Ocurrio un error al tratar de desbloquear la cuenta."},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var cambiarEstatusUsuario = function(idUser){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {idUser:idUser};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaCambiarEstatusUsuario(respuesta);
}

var ManejoRespuestaCambiarEstatusUsuario = function(respuesta){
    if(respuesta.code==200){
        switch(respuesta.respuesta.activar){
            case 1:
                if(respuesta.respuesta.v_preventas.length>0){
                    $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                    cargarTablaUsuarios(respuesta.respuesta.v_preventas);
                }
            break;
            case 204:
                $.growl({message:"Esta preventa la esta cerrada o finalizada"},{type: "warning", allow_dismiss: true,});
            break;
            default:
                $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var cargarTablaUsuarios = function(data){
    if(limpiarUsuarios==1){
        destruirTabla('#tablaUsuarios');
        $('#tablaUsuarios thead').empty();
    }
       
   $("#tablaUsuarios").dataTable({
        responsive:false,
        "aLengthMenu": DataTableLengthMenu,
        "pagingType": "full_numbers",
		"pageLength": 50, 
        "language": LenguajeTabla,
        "columnDefs": [
            {"targets": [ 1 ],"searchable": true},
            {"sWidth": "1px", "aTargets": [3]}
        ],
        "data": data,
        "columns":
		[
            {"title": "",
                "data": "idUser",
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="verDetallesUsuario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles Usuario" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
					<a href="#!" onclick="reiniciarClave(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Reiniciar Contraseña" data-original-title="Delete">
						<i class="icon-reload"></i>
					</a>
					<a href="#!" onclick="cambiarEstatusUsuario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
						<i class="icon-refresh"></i>
					</a>
					<a href="#!" onclick="desbloquearCuenta(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Desbloquear Cuenta" data-original-title="Delete">
						<i class="icon-lock-open"></i>
					</a>
                    </center>`;
                    return result;
                }
            },
			{"title": "Id","data": "idUser",visible:0},
			{"title": "Login de Acceso",
                "data": "usrUserName",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = formateaRut(data, true)
                    }
                    return data;
                }
            },
            {"title": "Nombre del Usuario","data": "usrNombreFull"},
			
			{"title": "Perfíl","data": "des_Perfil"},
			{"title": "Última Acceso", 
				"data": "usrUltimaVisita",
				"render": function(data, type, row, meta){
					if(type === 'display'){
                        if( moment(data, moment.ISO_8601).isValid() ){
						     data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
                        }else{
                            data = "Sin ingreso al Sistema...";
                        }
					}
					return data;
				}
			},
			{"title": "Estado de Bloqueo","data": "DescripcionBloqueo"},
			{"title": "Estado de Usuario","data": "des_estado"}, 
			{"title": "Creado por","data": "creador"},
			{"title": "Creado el", 
				"data": "auCreadoEl",
				"render": function(data, type, row, meta){
					if(type === 'display'){
						data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
					}
					return data;
				}
			},          
		],
    });
    limpiarUsuarios=1;
};

var cargarTablaLocales = function(data){
    if(limpiarLocales==1){
		destruirTabla('#tablaLocales');
		$('#tablaLocales thead').empty();
	}

	$("#tablaLocales").dataTable({
		responsive:true,
		"bSort": false,
		"scrollCollapse": false,
		"paging": false,
		"searching": false,
		"info":false,			
		"pageLength": 50, 
		
		"data": data,
		"columns":[
			{"title": "",
				"data": "IdUsuarioLocal",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="eliminarLocalUsuario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Eliminar Local Usuario" data-original-title="Delete">
						<i class="icofont icofont-ui-delete"></i>
					</a>
					</center>`;
					return result;
				}
			},
			{"title": "IdUsuarioLocal","data": "IdUsuarioLocal",visible:0},
            {"title": "Id Usuario","data": "IdUsuario",visible:0},
			{"title": "Id Local","data": "IdLocal",visible:0},
			{"title": "Usuario","data": "usrNombreFull"},
			{"title": "Nombre Local","data": "NombreLocal"},
			{"title": "Nombre Empresa","data": "NombreFantasia"}
		],
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Asociar Local',
                className: 'btn btn-inverse-warning AsociarLocal',
            },
            {
                text: 'Asociar Todos los Local',
                className: 'btn btn-inverse-warning AsociarTodosLocal',
            },
        ],
	});

	limpiarLocales=1;
};

var AsociarLocal = function(){
    console.log("AsociarLocal()...");

    $("#IdUsuarioLocal").val($("#idUser").val());

    $("#spanTituloModal").text("Asocial Local al Usuario "+$("#usrNombreFull").val());
    $("#ModalAsociarLocalUsuario").modal();
    
    $('#ModalAsociarLocalUsuario').on('shown.bs.modal', function() {
        $('#IdLocal').focus().select();
    });

}

var pintarDatosActualizar= function(data){
	console.log("pintarDatosActualizar()...");
	
    $("#spanTituloUsuarios").text("Detalle De Usuario");

    $("#perfiles").val("N/A o Inactivo")

    $('#divConsulta').show();
    $('#divSpanPerfiles').show();

    $("#idUser").val(data.idUser);
    $("#usrUserName").val(data.usrUserName);
    $("#usrNickName").val(data.usrNickName);
    $("#usrEmail").val(data.usrEmail);
    $("#usrNombreFull").val(data.usrNombreFull);
    $("#usrEstado").val(data.usrEstado).trigger("change");
    $("#idPerfil").val(data.idPerfil).trigger("change");

    if(data.usrUltimaVisita!=null){$("#usrUltimaVisita").val(data.usrUltimaVisita);}
    if(data.auCreadoEl!=null){$("#auCreadoEl").val(data.auCreadoEl);}
    if(data.creador!=null){$("#creador").val(data.creador);}
    if(data.auModificadoEl!=null){$("#auModificadoEl").val(data.auModificadoEl);}
    if(data.modificador!=null){$("#modificador").val(data.modificador);}
}

var BotonAgregar = function(){
    $("#spanTituloUsuarios").text("Registrar Nuevo Usuario");
    desbloquearInputs();

    $(".divDetalles").toggle();

    $('#FormUsuario')[0].reset();
    $("#idUser").val("");
    s
    $("#divTabs").hide();
    $("#divBtnModificar").hide();
    $("#divBtnAceptar").show();

    $("#usrEstado").val("1");

    $("#usrUserName").prop('readonly', false);
    //$("#usrUserName").prop('disabled', false);
    $('#usrUserName').focus().select();
}

var BotonCancelar = function(){
    $("#spanTituloUsuarios").text("");

    $(".divDetalles").toggle();
    $(".divBotones").toggle();

    $("#divBtnModificar").show();
    $("#divBtnAceptar").hide();
    
    $('#FormUsuario')[0].reset();

    $("#divTabs").show();
    
    $("#tLocales").removeClass("active");
    $("#TabLocales").removeClass("active");

    $("#TabUsuario").addClass("active");
    $("#tUsuario").addClass("active");
    
    bloquearInputs();

}

var validador = function(){
    $('#FormUsuario').formValidation('validate');
};

var verDetallesUsuario = function(IdUsuario){
    parametroAjax.ruta=rutaUB;
    parametroAjax.data = {IdUsuario:IdUsuario};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaVerInfoUsuario(respuesta);
}

var bloquearInputs = function(){
	$("#usrUserName").prop('readonly', true);
    $("#usrNombreFull").prop('readonly', true);
    $("#usrNickName").prop('readonly', true);
    $("#usrEmail").prop('readonly', true);

    $("#usrEstado").prop('disabled', true);
    $("#idPerfil").prop('disabled', true);
}


var desbloquearInputs = function(){
    $("#usrUserName").prop('readonly', true);
    //$("#usrUserName").prop('disabled', true);

    $("#usrNombreFull").prop('readonly', false);
    $("#usrNombreFull").prop('disabled', false);

    $("#usrNickName").prop('readonly', false);
    $("#usrNickName").prop('disabled', false);

    $("#usrEmail").prop('readonly', false);
    $("#usrEmail").prop('disabled', false);    

    $("#usrEstado").prop('disabled', false);
    $("#idPerfil").prop('disabled', false);

    $("#usrNombreFull").sele
}

var ModificarUsuario = function(){
    console.log("ModificarUsuario()...");

    $("#spanTituloUsuarios").text("Editar Usuario");
	$("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInputs();

    $('#usrNombreFull').focus().select();
}

var crearAllSelect = function(data){
    crearselect(data.v_perfiles,"idPerfil");
    crearselect(data.v_estados,"usrEstado");
}

var verificarRut = function(control,caso){
    var res = Valida_Rut(control);
    var format = formateaRut(control.val(), res);
    if (format != false){
        errorRut = 0;
        errorRut2 = 0;
        if (caso==1){buscarCliente(format);$("#ErrorRut").text("");}
        if (caso==2){$("#ErrorRut2").text("");}
        if (caso==3){buscarEmpresa(format);$("#ErrorRut3").text("");}
        return format;
    }else{
        if (caso==1){errorRut = 1;$("#ErrorRut").text("Rut invalido");}
        if (caso==2){errorRut2 = 1;$("#ErrorRut2").text("Rut invalido");}
        if (caso==3){errorRut3 = 1;$("#ErrorRut3").text("Rut invalido");}
        return control.val();
    }
}

var ProcesarUsuario = function(){
    if (errorRut==0){
        var camposNuevo = {'usrEstado': $('#usrEstado').val(), 'idPerfil': $('#idPerfil').val()}
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormUsuario").serialize() + '&' + $.param(camposNuevo);
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesarUsuario(respuesta);
    }
};

var ProcesarAsociarLocal = function(){
    parametroAjax.ruta=rutaALU;
    parametroAjax.data = $("#FormAsociarLocal").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaAsociarLocal(respuesta);

    $("#ModalAsociarLocalUsuario").modal("hide");
};

var ProcesarAsociarTodosLocal = function(){
    parametroAjax.ruta=rutaTLU;
     var camposNuevo = {'IdUsuario': $('#idUser').val()};
    parametroAjax.data = $.param(camposNuevo);
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaAsociarLocal(respuesta);

    $("#ModalAsociarLocalUsuario").modal("hide");
};

var eliminarLocalUsuario = function(IdUsuarioLocal){
    parametroAjax.ruta=rutaELU;
    var camposNuevo = {'IdUsuario': $('#idUser').val(), 'IdUsuarioLocal': IdUsuarioLocal};
    parametroAjax.data = $.param(camposNuevo);
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaAsociarLocal(respuesta);
}

var ManejoRespuestaProcesarUsuario = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro.f_registro_usuario);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                cargarTablaUsuarios(respuesta.respuesta.v_usuarios);
                BotonCancelar();
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

$(document).ready(function(){
    cargarTablaUsuarios(d.v_usuarios);
    crearAllSelect(d);

    $(document).on('click','#botonGuardar',validador);
    $(document).on('click','#botonCancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#botonModificar',ModificarUsuario);
    $(document).on('click','#botonVolverListado',BotonCancelar);

    $(document).on('click','.AsociarLocal',AsociarLocal);
    $(document).on('click','#botonAsociarLocal',ProcesarAsociarLocal);
    $(document).on('click','.AsociarTodosLocal',ProcesarAsociarTodosLocal);

    

    $("#usrUserName").focusout(function() {
        var valid = $("#usrUserName").val();
        if (valid.length > 0){
            var res = verificarRut($("#usrUserName"));
            $("#usrUserName").val(res);
        }else{$("#ErrorRut").text("");}
    });

    $('#FormUsuario').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'usrUserName': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'usrNombreFull': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'usrEmail': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                    emailAddress: {
                        message: 'Ingrese una dirección de correo valida'
                    }
                }
            },
            'usrEstado': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'idPerfil': {
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
        ProcesarUsuario();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});