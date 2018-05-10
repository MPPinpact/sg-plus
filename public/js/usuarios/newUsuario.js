var manejoRefresh=limpiarLocales=limpiarImpuestos=errorRut=errorRut2=errorRut3=limpiarBodegas=NPreventa=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var calcularMontos = function(CantidadPreVenta,ValorUnitarioVenta,FactorImpuesto,MontoDescuento){
    var ValorImpuesto = (CantidadPreVenta * ValorUnitarioVenta * FactorImpuesto / 100)
    $("#ValorImpuestos").val(ValorImpuesto);
    var TotalLinea = ((CantidadPreVenta * ValorUnitarioVenta) - MontoDescuento);
    $("#TotalLinea").val(TotalLinea);
    var ValorUnitarioFinal = (TotalLinea / CantidadPreVenta);
    $("#ValorUnitarioFinal").val(ValorUnitarioFinal);
}

var ManejoRespuestaBuscarProducto = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(parseInt(respuesta.respuesta.producto.IdProducto)==0){
                $.growl({message:respuesta.respuesta.producto.desProducto},{type: "warning", allow_dismiss: true});
            }else{
                $("#IdProducto").val(respuesta.respuesta.producto.IdProducto);
                $("#NombreProducto").val(respuesta.respuesta.producto.NombreProducto);
                $("#ValorUnitarioVenta").val(respuesta.respuesta.producto.PrecioVentaSugerido);
                $("#CantidadPreVenta").val(1);
                $("#FactorImpuesto").val(respuesta.respuesta.impuesto);
                $("#MontoDescuento").val(0);
                $("#IdUnidadMedida").val(respuesta.respuesta.producto.IdUnidadMedida).trigger("change");
                calcularMontos($("#CantidadPreVenta").val(),$("#ValorUnitarioVenta").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
            } 
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
    }
}

var ManejoRespuestaBuscarCliente = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.IdCliente==0){
                // var rut = $("#RUTProveedor").val();
                // $("#RUTProveedor2").val(rut);
                // $("#ModalProveedor").modal();
            }else{
                $("#IdCliente").val(respuesta.respuesta.IdCliente);
                $("#NombreCliente").val(respuesta.respuesta.NombreCliente);
            }    
        }else{
            $.growl({message:"Cliente no encontrado"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaBuscarEmpresa = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            crearselect(respuesta.respuesta.v_locales,"IdLocal");
            if(respuesta.respuesta.busqueda.IdEmpresa==0){
                $("#idEmpresa").val("");
                $("#NombreFantasiaE").val("");
                $.growl({message:"Empresa no encontrada"},{type: "warning", allow_dismiss: true,});
            }else{
                $("#idEmpresa").val(respuesta.respuesta.busqueda.IdEmpresa);
                $("#NombreFantasiaE").val(respuesta.respuesta.busqueda.NombreFantasia);
            }    
        }else{
            $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarCompraD = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            $("#ModalDetalleCompra").modal();
            $("#spanTituloModal").text("Detalle Usuario");
            $("#divBotonM").show();
            $("#divBotonesAC").hide();
            bloquearInputsDetalles();
            pintarDatosActualizarDetalles(respuesta.respuesta[0]);
        }else{
            $.growl({message:"Contacte al personal informatico"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarCD = function(respuesta){
    if(respuesta.code==200){
        switch(respuesta.respuesta.activar){
            case 1:
                if(respuesta.respuesta.v_detalles.length>0){
                    $.growl({message:"Procesado"},{type: "success", allow_dismiss: true,});
                    cargarTablaDetalles(respuesta.respuesta.v_detalles);
                }
            break;
            case 204:
                $.growl({message:"Esta Pre-venta la esta cerrada o finalizada"},{type: "warning", allow_dismiss: true,});
            break;
            default:
                $.growl({message:"Debe seleccionar un registro"},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaVerInfoUsuario = function(respuesta){
	console.log("Code: " + respuesta.code);
	
	/* Detalle de usuario */
    if(respuesta.code==200){
        //NPreventa=respuesta.respuesta.v_usuario[0].idPreVenta;
        bloquearInputs();
        $("#div-mod").show();
        $("#div-acep").hide();
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#divTabs").show();
        $("#spanTitulo").text("Detalle Usuario");
        pintarDatosActualizar(respuesta.respuesta.v_usuario[0]);
        cargarTablaLocales(respuesta.respuesta.v_locales);
        // if(parseInt(respuesta.respuesta.v_cabecera[0].EstadoPreVenta)>1){
            // $(".CerrarPreventa").hide();
            // $("#agregarC").hide();
        // }else{
            // $(".CerrarPreventa").show();
            // $("#agregarC").show();
        // }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar compra
var ManejoRespuestaProcesarI = function(respuesta){
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

// Manejo Registro de proveedor
var ManejoRespuestaProcesarProveedor = function(respuesta,nombre){
    if(respuesta.code==200){
        if(respuesta.respuesta>0){
            $("#IdProveedor").val(respuesta.respuesta);
            $("#NombreFantasia").val(nombre);
            $("#ModalProveedor").modal("hide");
        }else{
            $.growl({message:"ocurrió un error mientras se registraba el proveedor"},{type: "warning", allow_dismiss: true,}); 
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
};

// Manejo Registro o actualizacion de cabecera de compra
var ManejoRespuestaProcesar = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        if(res.code=="200"){ 
            $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
            NPreventa = res.IdPreVenta;
            $("#idPreVenta").val(res.IdPreVenta);
            $("#IdPreVenta2").val(res.IdPreVenta);
            $("#div-mod").hide();
            $("#div-acep").hide();
			
            $("#aimpuestos").addClass("active");
            $("#TabLocales").addClass("active");
			
            $("#TabUsuario").removeClass("active");
            $("#adetalles").removeClass("active");
			
            $("#divTabs").show();
            $("#divVolver").show();               
        }
        if (res.code=="-2"){
            $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
};

var ManejoRespuestaProcesarDetalles = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                $(".divBotonesC").toggle();
                $("#ModalDetalleCompra").modal("hide");
                $('#IdDetalleCompra').val("");
                $('#FormDetalle')[0].reset();
                cargarTablaDetalles(respuesta.respuesta.v_detalles);
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

}

var cargarTablaUsuarios = function(data){
    if(limpiarLocales==1){destruirTabla('#tablaPreventas');$('#tablaPreventas thead').empty();}
       
	   $("#tablaUsuarios").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
			"pageLength": 50, 
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [8]}
            ],
            "data": data,
            "columns":
			[
                {"title": "",
                    "data": "idUser",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesPreventa(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
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
				{"title": "Nombres","data": "usrNombreFull"},
				{"title": "Login",
					"data": "usrUserName",
					"render": function(data, type, row, meta){
						if(type === 'display'){
							data = formateaRut(data, true)
						}
						return data;
					}
				},
				{"title": "Perfíl","data": "des_Perfil"},
				{"title": "Última visita", 
					"data": "usrUltimaVisita",
					"render": function(data, type, row, meta){
						if(type === 'display'){
							data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
						}
						return data;
					}
				},
				{"title": "Estado de Bloqueo","data": "DescripcionBloqueo"},
				{"title": "Estado","data": "des_estado"}, 
				{"title": "Creado por","data": "creador"},
				{"title": "Fecha de Creación", 
					"data": "auCreadoEl",
					"render": function(data, type, row, meta){
						if(type === 'display'){
							data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm:ss");
						}
						return data;
					}
				}, 
				{"title": "Creado id","data": "auCreadoPor",visible:0},
				{"title": "Modificado id","data": "auModificadoPor",visible:0},
				{"title": "Modificado por","data": "modificador",visible:0},            
			],
        });
        limpiarLocales=1;
};

var cargarTablaLocales = function(data){
    if(limpiarImpuestos==1){
		destruirTabla('#tablaLocales');
		$('#tablaLocales thead').empty();
	}
        
	var columnReport = [[5],[6],[7],[12]];       
	
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
				"data": "IdLocal",
				"render": function(data, type, row, meta){
					var result = `
					<center>
					<a href="#" onclick="cambiarEstatusPreventaD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Eliminar Local" data-original-title="Delete">
						<i class="icofont icofont-ui-delete"></i>
					</a>
					</center>`;
					return result;
				}
			},
			{"title": "Id Usuario","data": "IdUsuario",visible:0},
			{"title": "Id Local","data": "IdLocal",visible:0},
			{"title": "Usuario","data": "usrNombreFull"},
			{"title": "Nombre Local","data": "NombreLocal"},
			{"title": "Nombre Empresa","data": "NombreFantasia"}
		],   
	});

	limpiarImpuestos=1;
};

var pintarDatosActualizar= function(data){
	console.log("Pintando datos...");
	
	$(".md-form-control").addClass("md-valid");
    $("#spanTitulo").text("Editar Usuario");
    $("#perfiles").val("N/A o Inactivo")
    $('#divConsulta').show();
    $('#divSpanPerfiles').show();
    $("#idUser").val(data.idUser);
    $("#usrUserName").val(data.usrUserName);
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

var pintarDatosActualizarDetalles = function(data){
    $("#IdPreVenta2").val(data.IdPreVenta);
    $("#IdDetallePreVenta").val(data.IdDetallePreVenta);
    $("#IdProducto").val(data.IdProducto);
    $("#CodigoBarra").val(data.CodigoBarra);
    $("#NombreProducto").val(data.NombreProducto);
    $("#IdUnidadMedida").val(data.IdUnidadMedida).trigger("change");
    $("#CantidadPreVenta").val(data.CantidadPreVenta);
    $("#ValorUnitarioVenta").val(data.ValorUnitarioVenta);
    $("#FactorImpuesto").val(data.FactorImpuesto);
    $("#ValorImpuestos").val(data.ValorImpuestos);
    $("#MontoDescuento").val(data.MontoDescuento);
    $("#ValorUnitarioFinal").val(data.ValorUnitarioFinal);
    $("#TotalLinea").val(data.TotalLinea);
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Usuario");
    desbloquearInputs();
    $(".divDetalles").toggle();
    $("#divVolver").hide();
    $("#idPreVenta").val("");
    $('#FormPreventas')[0].reset();
    $("#divTabs").hide();
    $("#div-mod").hide();
    $("#div-acep").show();
    var now = moment().format('DD-MM-YYYY')
    $("#FechaPreVenta").val(now);
}

var BotonCancelar = function(){
    $("#spanTitulo").text("");
    $(".md-form-control").removeClass("md-valid");
    $('#FormPreventas')[0].reset();
    $("#idPreVenta").val("");
    $("#divTabs").show();
    $("#div-mod").hide();
    $("#div-acep").hide();
    // $(".divBotones").toggle();
    $(".divDetalles").toggle();
    bloquearInputs();
    $("#PrecioUltimaCompra").prop('readonly', true);
    NPreventa=0;
}

var volverListado = function(){
    location.reload();
    NPreventa=0;
    // $(".CerrarPreventa").show();
    // $("#agregarC").show();
    // $(".divDetalles").toggle();
    // $('#FormPreventas')[0].reset();
    // $('#FormProveedorNew')[0].reset();
    // $('#FormDetalle')[0].reset();
    // $("#idPreVenta").val("");
    // $("#RUTProveedor2").val("");
    // $("#IdDetalleCompra").val("");
    // $("#idPreVenta2").val("");
    // $("#IdProducto").val("");
    $("#aimpuestos").removeClass("active");
    $("#TabLocales").removeClass("active");
    $("#TabUsuario").addClass("active");
    $("#adetalles").addClass("active");
}

var BotonAgregarDetalle = function (){
    $("#spanTituloModal").text("Registrar Usuario");
	$("#guardar").text("Continuar");
    $("#divBotonM").hide();
    $("#divBotonesAC").show();
    // $('#FormDetalle')[0].reset();
    $("#IdDetallePreVenta").val("");
    $("#IdProducto").val("");
    $("#CodigoBarra").val("");
    $("#NombreProducto").val("");
    $("#CantidadPreVenta").val("");
    $("#ValorUnitarioVenta").val("");
    $("#FactorImpuesto").val("");
    $("#ValorImpuestos").val("");
    $("#MontoDescuento").val("");
    $("#ValorUnitarioFinal").val("");
    $("#TotalLinea").val("");
    $(".comboclear").val('').trigger("change");
    //desbloquearInputsDetalles();
}

var BotonCancelarDetalle = function(){
    $("#ModalDetalleCompra").modal("hide");
    $("#divBotonM").hide();
    $("#divBotonesAC").hide();
    $('#FormDetalle')[0].reset();
    $("#IdDetalleCompra").val("");
    $("#IdProducto").val("");
    $(".comboclear").val('').trigger("change");
    bloquearInputsDetalles();
}

var ProcesarProveedor = function(){
    var nombre = $("#NombreFantasia2").val();
    parametroAjax.ruta=rutaPR;
    parametroAjax.data = $("#FormProveedorNew").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarProveedor(respuesta,nombre);
};

var ProcesarPreventa = function(){
    if(errorRut == 0){
        parametroAjax.ruta=ruta;
        parametroAjax.data = $("#FormPreventas").serialize();
        respuesta=procesarajax(parametroAjax);
        ManejoRespuestaProcesar(respuesta);
    }
};

var ProcesarDetalleCompra = function(){
    parametroAjax.ruta=rutaDC;
    parametroAjax.data = $("#FormDetalle").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalles(respuesta);
};

var validador = function(){
    $('#FormPreventas').formValidation('validate');
};

var validadorP = function(){
    $('#FormProveedorNew').formValidation('validate');
};

var validadorI = function(){
    $('#FormImpuesto').formValidation('validate');
}

var validadorD = function(){
    $('#FormDetalle').formValidation('validate');
};

var cambiarEstatusPreventa = function(idPreVenta){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {idPreVenta:idPreVenta};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesPreventa = function(IdUsuario){
    parametroAjax.ruta=rutaUB;
    parametroAjax.data = {IdUsuario:IdUsuario};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaVerInfoUsuario(respuesta);
}

var verDetallesPreventaD = function(IdDetallePreVenta){
    parametroAjax.ruta=rutaBDC;
    parametroAjax.data = {IdDetallePreVenta:IdDetallePreVenta};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarCompraD(respuesta);
}

var cambiarEstatusPreventaD = function(IdDetallePreVenta){
    parametroAjax.ruta=rutaCDA;
    parametroAjax.data = {IdDetallePreVenta:IdDetallePreVenta};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarCD(respuesta);
}

var bloquearInputs = function(){
	$("#usrUserName").prop('readonly', true);
    $("#usrNombreFull").prop('readonly', true);
    $("#usrEmail").prop('readonly', true);
    $("#usrEstado").prop('disabled', true);
    $("#idPerfil").prop('disabled', true);
}


var desbloquearInputs = function(){
    $("#usrUserName").prop('readonly', false);
    $("#usrNombreFull").prop('readonly', false);
    $("#usrEmail").prop('readonly', false);
    $("#usrEstado").prop('disabled', false);
    $("#idPerfil").prop('disabled', false);
}

var bloquearInputsDetalles = function(){
    $("#CodigoBarra").prop('readonly', true);
    // $("#NombreProducto").prop('readonly', true);
    $("#CantidadPreVenta").prop('readonly', true);
    $("#ValorUnitario").prop('readonly', true);
    // $("#FactorImpuesto").prop('readonly', true);
    // $("#ValorImpuestos").prop('readonly', true);
    $("#MontoDescuento").prop('readonly', true);
    // $("#ValorUnitarioFinal").prop('readonly', true);
    // $("#TotalLinea").prop('readonly', true);
    $("#IdUnidadMedida").prop('disabled', true);
}

var modificarCabeceras = function(){
    $("#spanTituloUsuarios").text("Editar Usuario");
	$("#divBtnModificar").hide();
    $("#divBtnAceptar").show();
    desbloquearInputs();
}

var volverTabs = function(){
    $("#spanTituloUsuarios").text("");
    $(".divDetalles").toggle();
    
    //$("#astock").removeClass("active");
    //$("#akardex").removeClass("active");
	//$("#TabStock").removeClass("active");
    //$("#TabKardex").removeClass("active");
	
    $("#aimpuestos").removeClass("active");
    $("#TabLocales").removeClass("active");
	
    $("#TabUsuario").addClass("active");
    $("#adetalles").addClass("active");
}

var crearAllSelect = function(data){
    // crearselect(data.v_tipo_dte,"TipoDTE");
    // crearselect(data.v_estados,"EstadoCompra");
    // crearselect(data.v_estados,"EstadoDetalleCompra");
    // crearselect(data.v_unidad_medida,"IdUnidadMedida");
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

var buscarCombos = function(IdLocal,IdBodega){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {IdLocal:IdLocal,IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    if(respuesta.code==200){var res = respuesta.respuesta;}
    else{ var res= 0; }
    return res;
}

var buscarProducto = function(CodigoBarra){
    parametroAjax.ruta=rutaBPD;
    parametroAjax.data = {CodigoBarra:CodigoBarra};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProducto(respuesta);
}

var buscarCliente = function(RUTCliente){
    parametroAjax.ruta=rutaBC;
    parametroAjax.data = {RUTCliente:RUTCliente};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarCliente(respuesta);
}

var buscarEmpresa = function(RUTEmpresa){
    parametroAjax.ruta=rutaBE;
    parametroAjax.data = {RUTEmpresa:RUTEmpresa};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarEmpresa(respuesta);
}

var buscarBodegas = function(IdLocal){
    parametroAjax.ruta=rutaBB;
    parametroAjax.data = {IdLocal:IdLocal};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        crearselect(respuesta.respuesta,"IdBodega");
    }
}

var calcularFechaPago = function (fecha){
    var FechaDTE = moment(fecha, 'DD-MM-YYYY',true).format("YYYY-MM-DD");
    var FechaSuma = moment(FechaDTE).add(1, 'month').format("YYYY-MM-DD");
    var FechaVencimiento = moment(FechaSuma, 'YYYY-MM-DD',true).format("DD-MM-YYYY");
    $("#FechaVencimiento").val(FechaVencimiento);
    $("#FechaPago").val(FechaVencimiento);
    $("#FechaVencimiento").focus();
    $("#FechaPago").focus();
    $("#TotalNeto").focus();
}

var CerrarPreventa = function (){
    parametroAjax.ruta=rutaCP;
    parametroAjax.data = {IdPreVenta:NPreventa};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        if (respuesta.respuesta==1){
            $(".CerrarPreventa").hide();
            $("#agregarC").hide();
        }
    }
}

var limpiarFormDetalle = function(){
    $("#NombreProducto").val("");  
    $("#CantidadPreVenta").val("");  
    $("#ValorUnitarioVenta").val("");  
    $("#TotalLinea").val("");
    $("#IdProducto").val("");  
    $("#FactorImpuesto").val("");  
    $("#ValorImpuestos").val("");  
    $("#MontoDescuento").val("");  
    $("#ValorUnitarioFinal").val("");  
    $("#IdUnidadMedida").val('').trigger("change");
}

$(document).ready(function(){
    $("#FechaPreVenta").inputmask({ mask: "99-99-9999"});
    // $("#NombreCliente").val(now);
    cargarTablaUsuarios(d.v_usuarios);
    crearAllSelect(d);
    // $("#IdLocal").change(function() {
    //     buscarBodegas($("#IdLocal").val());
    // });
    // $("#RUTCliente").focusout(function() {
        // var valid = $("#RUTCliente").val();
        // if (valid.length > 0){
            // var res = verificarRut($("#RUTCliente"),1);
            // $("#RUTCliente").val(res);
        // }else{$("#ErrorRut").text("");}
    // });
    // $("#RUTProveedor2").focusout(function() {
    //     var valid = $("#RUTProveedor2").val();
    //     if (valid.length > 0){
    //         var res = verificarRut($("#RUTProveedor2"),2);
    //         $("#RUTProveedor2").val(res);
    //     }else{$("#ErrorRut2").text("");}
    // });
    // $("#RUT").focusout(function() {
    //     var valid = $("#RUT").val();
    //     if (valid.length > 0){
    //         var res = verificarRut($("#RUT"),3);
    //         $("#RUT").val(res);
    //     }else{$("#ErrorRut3").text("");}
    // });
    // $("#FechaDTE").focusout(function() {
    //     calcularFechaPago($("#FechaDTE").val());
    // });

    // $("#CodigoBarra").focusout(function() {
        // limpiarFormDetalle();
        // buscarProducto($("#CodigoBarra").val());
    // });

    // $("#CantidadPreVenta").focusout(function() {
        // calcularMontos($("#CantidadPreVenta").val(),$("#ValorUnitarioVenta").val(),$("#FactorImpuesto").val(),$("#MontoDescuento").val());
    // });

    // Botones de cabecera de compra
    $(document).on('click','#guardar',validador);
    $(document).on('click','#guardarI',validadorI);
    $(document).on('click','#aceptarM',validadorP);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarCabeceras);
    $(document).on('click','#volverAct',volverTabs);
    // Botones de detalles de compra
    $(document).on('click','#agregarC',BotonAgregarDetalle);
    $(document).on('click','#guardarC',validadorD);
    $(document).on('click','#cancelarC',BotonCancelarDetalle);
    $(document).on('click','#closeModal',BotonCancelarDetalle);
    $(document).on('click','#modificarC',modificarDetalles);
    $(document).on('click','#btn-list',volverListado);
    $(document).on('click','.CerrarPreventa',CerrarPreventa);


});