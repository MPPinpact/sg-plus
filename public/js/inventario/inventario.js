var limpiarInventario=limpiarDetalles=NInventario=NBodega=limpiarTomaInventario=IdEstadoInventario=0;
var errorRut=errorRut2=errorRut3=0;
var nombre_bodega = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaBuscarProducto = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.length > 0){
            $("#IdProducto").val(respuesta.respuesta[0].IdProducto);
            $("#NombreProducto").val(respuesta.respuesta[0].NombreProducto);
            $("#PrecioVentaSugerido").val(respuesta.respuesta[0].PrecioVentaSugerido);
            $("#StockSistema").val(respuesta.respuesta[0].Stock);
        }else{
            $.growl({message:"Producto no encontrado, verifique"},{type: "warning", allow_dismiss: true});
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true});
    }
}

var ManejoRespuestaBuscarInventario = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta.length > 0){
            cargarTablaTomaInventario(respuesta.respuesta);
        }else{
            $.growl({message:"Bodega sin Inventario"},{type: "warning", allow_dismiss: true,});
        }

    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

var ManejoRespuestaProcesarDetalleInventario = function(respuesta){
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            $("#ModalDetalleCompra").modal();
            $("#spanTituloModal").text("Detalle Inventario");
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

var ManejoRespuestaProcesarID = function(respuesta){
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

var ManejoRespuestaProcesarD = function(respuesta){
    if(respuesta.code==200){
        NInventario=respuesta.respuesta.v_cabecera[0].IdInventario;
        NBodega = respuesta.respuesta.v_cabecera[0].IdBodega;
        nombre_bodega = respuesta.respuesta.v_cabecera[0].NombreBodega;
        bloquearInputs();
        $("#divAjusteInventario").show();
        $("#div-mod").show();
        $("#div-acep").hide();
        $(".divDetalles").toggle();
        $("#divVolver").show();
        $("#divBotonesSec").show();
        $("#divTabs").show();
        $("#spanTitulo").text("Detalle Inventario");
        crearselect(respuesta.respuesta.v_familias,"IdFamiliaToma");
        pintarDatosActualizar(respuesta.respuesta.v_cabecera[0]);
        cargarTablaDetalles(respuesta.respuesta.v_detalles);
        if(parseInt(respuesta.respuesta.v_cabecera[0].EstadoPreVenta)>1){
            $(".CerrarPreventa").hide();
            $("#agregarC").hide();
        }else{
            $(".CerrarPreventa").show();
            $("#agregarC").show();
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Activar / Desactivar compra
var ManejoRespuestaProcesarI = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(parseInt(res.code)){
            case 200:
                $("#spanEstadoInventario").text(res.des_code);
                $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
                if (res.des_code == "Inventario Cerrado"){IdEstadoInventario = 1;}
                if (res.des_code == "Inventario Ajustado"){IdEstadoInventario = 3;}
                if(respuesta.respuesta.v_detalles){cargarTablaDetalles(respuesta.respuesta.v_detalles);}
                if(respuesta.respuesta.v_inventario){cargarTablaInventario(respuesta.respuesta.v_inventario);}
            break;
            case 204:
                $.growl({message:res.des_code},{type: "warning", allow_dismiss: true,});
            break;
        }
    }else{
        $.growl({message:"Contacte al personal informatico"},{type: "danger", allow_dismiss: true,});
    }
}

// Manejo Registro o actualizacion de cabecera de compra
var ManejoRespuestaProcesarInventario = function(respuesta){
    if(respuesta.code==200){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        if(res.code=="200"){ 
            $.growl({message:res.des_code},{type: "success", allow_dismiss: true,});
            NInventario = res.IdInventario;
            NBodega = respuesta.respuesta.IdBodega;
            $("#IdInventario").val(res.IdInventario);
            $("#IdInventario2").val(res.IdInventario);
            $("#div-mod").hide();
            $("#div-acep").hide();
            $("#aimpuestos").addClass("active");
            $("#TabImpuestos").addClass("active");
            $("#Tabdetalles").removeClass("active");
            $("#adetalles").removeClass("active");
            $("#divTabs").show();
            $("#divVolver").show(); 
            $("#divBotonesSec").show();               
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

var cargarTablaTomaInventario = function(data){
    if(limpiarTomaInventario==1){destruirTabla('#tablaTomaInventario');$('#tablaTomaInventario thead').empty();}
        var columnReport = [[0],[1],[2],[3]];       
        $("#tablaTomaInventario").dataTable({
            responsive:false,
            "bSort": false,
            "scrollCollapse": false,
            "paging": false,
            "searching": false,
            "info":false,           
            "pageLength": 50, 
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
            ],
            "data": data,
            "columns":[
                {"title": "Codigo","data": "CodigoBarra"},
                {"title": "Producto","data": "NombreProducto"},
                {"title": "Precio Venta","data": "PrecioVentaSugerido"},
                {
                 "title": "Cantidad",
                 "data": null,
                    "render": function(data, type, row, meta){
                        var result = `___________`;
                        return result;
                    }
                }
            ],   
            dom: 'Bfrtip',
            buttons: [
                 {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-primary waves-effect waves-light',
                    orientation:'landscape',
                    pageSize:'A4',
                    title:'Detalle Inventario Bodega '+nombre_bodega,                    
                    exportOptions: {
                        columns: columnReport,
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size','11px');
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Descargar',
                    className: 'btn btn-primary waves-effect waves-light',
                    // orientation:'landscape',  //Hoja Horizontal
                    pageSize:'A4',
                    title:'Detalle Inventario Bodega '+nombre_bodega,
                    filename:'DetalleInventario_'+nombre_bodega+"_"+Date.now(),
                    exportOptions: {columns: columnReport, modifier: {page: 'all', } }, 
                    customize : function(doc){
                        doc.defaultStyle.fontSize = 8; 
                        doc.pageMargins = [40, 40, 40,0];
                        var colCount = new Array();   
                        $($("#tablaTomaInventario").dataTable()).find('tbody tr:first-child td').each(function(){
                            if($(this).attr('colspan')){
                                for(var i=1;i<=$(this).attr('colspan');$i++){
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                }
            ]
        });
    limpiarTomaInventario=1;
};

var cargarTablaInventario = function(data){
    if(limpiarInventario==1){destruirTabla('#tablaInventario');$('#tablaInventario thead').empty();}
        $("#tablaInventario").dataTable({
            responsive:false,
            "aLengthMenu": DataTableLengthMenu,
            "pagingType": "full_numbers",
            "pageLength": 50, 
            "language": LenguajeTabla,
            "columnDefs": [
                {"targets": [ 1 ],"searchable": true},
                {"sWidth": "1px", "aTargets": [6]}
            ],
            "data": data,
            "columns":[
                {
                    "title": "",
                    "data": "IdInventario",
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verDetallesInventario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="cambiarEstatusInventario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                            <i class="icofont icofont-ui-delete"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Local","data": "NombreLocal", className: "text-center"},
                {"title": "Bodega","data": "NombreBodega", className: "text-center"},
                {"title": "Tipo Inventario","data": "DesTipoInventario"},
                {"title": "Fecha Inventario", "data": "FechaInventario", className: "text-center", 
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Fecha Toma", "data": "FechaTomaInventario", className: "text-center", 
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Fecha Cierre", "data": "FechaCierreInventario", className: "text-center", 
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            if (data != null){
                                data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                            }
                        }
                        return data;
                    }
                },
                {"title": "Fecha Ajuste", "data": "FechaAjusteInventario", className: "text-center", 
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            if (data != null){
                                data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                            }
                            
                        }
                        return data;
                    }
                },
                {"title": "Estado","data": "DesEstadoInventario", className: "text-center"}
            ],
        });
        limpiarInventario=1;
};



var cargarTablaDetalles = function(data){
    if(limpiarDetalles==1){destruirTabla('#tablaDetalles');$('#tablaDetalles thead').empty();}
        switch(parseInt(IdEstadoInventario)) {
            case 0:
                cargarTablaInventarioAbierto(data);
                break;
            case 1:
                cargarTablaInventarioCerrado(data);
                break;
            case 3:
                cargarTablaInventarioAjustado(data);
                break;
        }
    limpiarDetalles=1;
};

var cargarTablaInventarioAbierto = function(data){
    var columnReport = [[0],[1],[2],[3]];       
    $("#tablaDetalles").dataTable({
        responsive:false,
        "bSort": false,
        "scrollCollapse": false,
        "paging": false,
        "searching": false,
        "info":false,           
        "pageLength": 50, 
        "columnDefs": [
            {"targets": [ 1 ],"searchable": true},
        ],
        "data": data,
        "columns":[
            {
                "title": "",
                "data": "IdInventarioDetalle",
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="verDetallesInventarioD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
                    <a href="#" onclick="cambiarEstatusDetalleInventario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                        <i class="icofont icofont-ui-delete"></i>
                    </a>
                    </center>`;
                    return result;
                }
            },
            {"title": "Id","data": "IdInventarioDetalle",visible:0},
            {"title": "IdProducto","data": "IdProducto",visible:0},
            {"title": "Nombre Producto","data": "NombreProducto"},
            {"title": "Precio Venta","data": "PrecioVentaSugerido", className: "text-right"},
            {"title": "Stock Fisico","data": "StockFisico",className: "text-right"},
        ],   
        dom: 'Bfrtip',
        buttons: [
             {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-primary waves-effect waves-light',
                orientation:'landscape',
                pageSize:'A4',
                title:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega,                
                exportOptions: {
                    columns: columnReport,
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function (win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size','11px');
                }
            },
            {
                extend: 'pdf',
                text: 'Descargar',
                className: 'btn btn-primary waves-effect waves-light',
                // orientation:'landscape',  //Hoja Horizontal
                pageSize:'A4',
                title:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega,
                filename:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega+Date.now(),
                exportOptions: {columns: columnReport, modifier: {page: 'all', } }, 
                customize : function(doc){
                    doc.defaultStyle.fontSize = 8; 
                    doc.pageMargins = [40, 40, 40,0];
                    var colCount = new Array();   
                    $($("#tablaDetalles").dataTable()).find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }else{ colCount.push('*'); }
                    });
                    doc.content[1].table.widths = colCount;
                }
            }
        ]
    });
}
var cargarTablaInventarioCerrado = function(data){
    var columnReport = [[0],[1],[2],[3]];       
    $("#tablaDetalles").dataTable({
        responsive:false,
        "bSort": false,
        "scrollCollapse": false,
        "paging": false,
        "searching": false,
        "info":false,           
        "pageLength": 50, 
        "columnDefs": [
            {"targets": [ 1 ],"searchable": true},
        ],
        "data": data,
        "columns":[
            {
                "title": "",
                "data": "IdInventarioDetalle",
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="verDetallesInventarioD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
                    <a href="#" onclick="cambiarEstatusDetalleInventario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                        <i class="icofont icofont-ui-delete"></i>
                    </a>
                    </center>`;
                    return result;
                }
            },
            {"title": "Id","data": "IdInventarioDetalle",visible:0},
            {"title": "IdProducto","data": "IdProducto",visible:0},
            {"title": "Nombre Producto","data": "NombreProducto"},
            {"title": "Precio Venta","data": "PrecioVentaSugerido"},
            {"title": "Fecha Cierre", "data": "FechaCierreInventario", className: "text-center", 
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        if (data != null){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                    }
                    return data;
                }
            },
            {"title": "Stock Fisico","data": "StockFisico"},
            {"title": "Stock Sistema","data": "StockSistema"},
            {"title": "Diferencia","data": "Diferencia"}
        ],   
        dom: 'Bfrtip',
        buttons: [
             {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-primary waves-effect waves-light',
                orientation:'landscape',
                pageSize:'A4',
                title:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega,                                                  
                exportOptions: {
                    columns: columnReport,
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function (win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size','11px');
                }
            },
            {
                extend: 'pdf',
                text: 'Descargar',
                className: 'btn btn-primary waves-effect waves-light',
                // orientation:'landscape',  //Hoja Horizontal
                pageSize:'A4',
                title:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega,
                filename:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega+Date.now(),
                exportOptions: {columns: columnReport, modifier: {page: 'all', } }, 
                customize : function(doc){
                    doc.defaultStyle.fontSize = 8; 
                    doc.pageMargins = [40, 40, 40,0];
                    var colCount = new Array();   
                    $($("#tablaDetalles").dataTable()).find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }else{ colCount.push('*'); }
                    });
                    doc.content[1].table.widths = colCount;
                }
            }
        ]
    });
}
var cargarTablaInventarioAjustado = function(data){
    var columnReport = [[0],[1],[2],[3]];       
    $("#tablaDetalles").dataTable({
        responsive:false,
        "bSort": false,
        "scrollCollapse": false,
        "paging": false,
        "searching": false,
        "info":false,           
        "pageLength": 50, 
        "columnDefs": [
            {"targets": [ 1 ],"searchable": true},
        ],
        "data": data,
        "columns":[
            {
                "title": "",
                "data": "IdInventarioDetalle",
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="verDetallesInventarioD(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
                    <a href="#" onclick="cambiarEstatusDetalleInventario(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Activar / Desactivar" data-original-title="Delete">
                        <i class="icofont icofont-ui-delete"></i>
                    </a>
                    </center>`;
                    return result;
                }
            },
            {"title": "Id","data": "IdInventarioDetalle",visible:0},
            {"title": "IdProducto","data": "IdProducto",visible:0},
            {"title": "Nombre Producto","data": "NombreProducto"},
            {"title": "Precio Venta","data": "PrecioVentaSugerido"},
            {"title": "Fecha Cierre", "data": "FechaCierreInventario", className: "text-center", 
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        if (data != null){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                    }
                    return data;
                }
            },
            {"title": "Fecha Ajuste", "data": "FechaAjusteInventario", className: "text-center", 
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        if (data != null){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                    }
                    return data;
                }
            },
            {"title": "Ajuste Realizado","data": "DesAjusteRealizado"},
            {"title": "Stock Fisico","data": "StockFisico"},
            {"title": "Stock Sistema","data": "StockSistema"},
            {"title": "Diferencia","data": "Diferencia"}
        ],   
        dom: 'Bfrtip',
        buttons: [
             {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-primary waves-effect waves-light',
                orientation:'landscape',
                pageSize:'A4',
                title:'Detalle Inventario Bodega '+nombre_bodega,  
                exportOptions: {
                    columns: columnReport,
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function (win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size','11px');
                }
            },
            {
                extend: 'pdf',
                text: 'Descargar',
                className: 'btn btn-primary waves-effect waves-light',
                // orientation:'landscape',  //Hoja Horizontal
                pageSize:'A4',
                title:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega,
                filename:'Listado de Inventario N° '+NInventario+' de Bodega '+nombre_bodega+Date.now(),
                exportOptions: {columns: columnReport, modifier: {page: 'all', } }, 
                customize : function(doc){
                    doc.defaultStyle.fontSize = 8; 
                    doc.pageMargins = [40, 40, 40,0];
                    var colCount = new Array();   
                    $($("#tablaDetalles").dataTable()).find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }else{ colCount.push('*'); }
                    });
                    doc.content[1].table.widths = colCount;
                }
            }
        ]
    }); 
}


var pintarDatosActualizar= function(data){
    IdEstadoInventario = data.EstadoInventario;
    $("#spanEstadoInventario").text("Inventario "+data.DesEstadoInventario);
    $(".md-form-control").addClass("md-valid");
    $("#IdInventario").val(data.IdInventario);
    $("#IdInventario2").val(data.IdInventario);
    $("#FechaInventario").val(moment(data.FechaInventario, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    $("#FechaTomaInventario").val(moment(data.FechaTomaInventario, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    if (data.FechaAjusteInventario != null){
        $("#FechaAjusteInventario").val(moment(data.FechaAjusteInventario, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY"));
    }
    $("#Comentario").val(data.Comentario);
    $("#TipoInventario").val(data.TipoInventario).trigger("change");
    $("#IdLocal").val(data.IdLocal).trigger("change");    
    $("#IdBodega").val(data.IdBodega).trigger("change");    
}

var pintarDatosActualizarDetalles = function(data){
    $("#IdInventario2").val(data.IdInventario);
    $("#IdInventarioDetalle").val(data.IdInventarioDetalle);
    $("#IdProducto").val(data.IdProducto);
    $("#CodigoBarra").val(data.CodigoBarra);
    $("#NombreProducto").val(data.NombreProducto);
    $("#StockFisico").val(data.StockFisico);
    $("#StockSistema").val(data.StockSistema);
    $("#Diferencia").val(data.Diferencia).trigger("change");
    $("#AjusteRealizado").val(data.AjusteRealizado);
}

var BotonAgregar = function(){
    $("#spanTitulo").text("Registrar Inventario");
    $("#spanEstadoInventario").text("");
    desbloquearInputs();
    $("#divBotonesSec").hide();
    $(".divDetalles").toggle();
    $("#divVolver").hide();
    $("divAjusteInventario").hide();
    $("#IdInventario").val("");
    $('#FormInventario')[0].reset();
    $("#divTabs").hide();
    $("#div-mod").hide();
    $("#div-acep").show();
    var NowDate = moment().format('DD-MM-YYYY')
    $("#FechaInventario").val(NowDate);
    $("#FechaTomaInventario").val(NowDate);    
}

var BotonCancelar = function(){
    $("#spanTitulo").text("");
    $(".md-form-control").removeClass("md-valid");
    $('#FormInventario')[0].reset();
    $("#IdInventario").val("");
    $("#divTabs").show();
    $("#div-mod").hide();
    $("#div-acep").hide();
    $(".divDetalles").toggle();
    bloquearInputs();
    $("#PrecioUltimaCompra").prop('readonly', true);
    NInventario=0;
    NBodega = 0;
    nombre_bodega = '';
}

var volverListado = function(){
    location.reload();
    NInventario=0;
    NBodega = 0;
    nombre_bodega = '';
}

var BotonAgregarDetalle = function (){
    $("#spanTituloModal").text("Registrar Detalle");
    $("#guardar").text("Continuar");
    $("#divBotonM").hide();
    $("#divBotonesAC").show();
    $("#IdInventarioDetalle").val("");
    $("#IdProducto").val("");
    $("#CodigoBarra").val("");
    $("#NombreProducto").val("");
    $("#StockFisico").val("");
    $("#StockSistema").val("");
    $("#Diferencia").val("");
    $("#AjusteRealizado").val("");
    desbloquearInputsDetalles();
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

var ProcesarInventario = function(){
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#FormInventario").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarInventario(respuesta);
};

var ProcesarDetalleInventario = function(){
    parametroAjax.ruta=rutaDC;
    parametroAjax.data = $("#FormDetalle").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalles(respuesta);
};

var validador = function(){
    $('#FormInventario').formValidation('validate');
};

var validadorD = function(){
    $('#FormDetalle').formValidation('validate');
};

var cambiarEstatusInventario = function(IdInventario){
    parametroAjax.ruta=rutaA;
    parametroAjax.data = {IdInventario:IdInventario};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

var verDetallesInventario = function(IdInventario){
    parametroAjax.ruta=rutaB;
    parametroAjax.data = {IdInventario:IdInventario};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarD(respuesta);
}

var cambiarEstatusDetalleInventario = function(IdInventarioDetalle){
    parametroAjax.ruta=rutaCDA;
    parametroAjax.data = {IdInventarioDetalle:IdInventarioDetalle};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarID(respuesta);
}

var verDetallesInventarioD = function(IdInventarioDetalle){
    parametroAjax.ruta=rutaBDC;
    parametroAjax.data = {IdInventarioDetalle:IdInventarioDetalle};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarDetalleInventario(respuesta);
}

var bloquearInputs = function(){
    $("#FechaInventario").prop('readonly', true);
    $("#FechaTomaInventario").prop('readonly', true);
    $("#Comentario").prop('readonly', true);
    $("#TipoInventario").prop('disabled', true);
    $("#IdLocal").prop('disabled', true);
    $("#IdBodega").prop('disabled', true);
    
}

var desbloquearInputs = function(){
    $("#FechaInventario").prop('readonly', false);
    $("#FechaTomaInventario").prop('readonly', false);
    $("#Comentario").prop('readonly', false);
    $("#TipoInventario").prop('disabled', false);
    $("#IdLocal").prop('disabled', false);
    $("#IdBodega").prop('disabled', false);
}

var bloquearInputsDetalles = function(){
    $("#CodigoBarra").prop('readonly', true);
    $("#StockFisico").prop('readonly', true);
}

var desbloquearInputsDetalles = function(){
    $("#CodigoBarra").prop('readonly', false);
    $("#StockFisico").prop('readonly', false);
}

var modificarCabeceras = function(){
    $("#spanTitulo").text("Editar Inventario");
    $("#guardar").text("Guardar");
    $("#divVolver").hide();
    $("#div-mod").hide();
    $("#div-acep").show();
    desbloquearInputs();
}

var modificarDetalles = function(){
    $("#spanTituloModal").text("Editar Detalle");
    $("#divBotonM").hide();
    $("#divBotonesAC").show();
    desbloquearInputsDetalles();
}

var crearAllSelect = function(data){
    crearselect(data.v_locales,"IdLocal");
    crearselect(data.v_tipo_inventario,"TipoInventario");
}

var buscarProducto = function(CodigoBarra){
    parametroAjax.ruta=rutaBPD;
    parametroAjax.data = {CodigoBarra:CodigoBarra,IdBodega:$("#IdBodega").val()};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarProducto(respuesta);
}

var BuscarInventarioTotal = function(IdBodega){
    parametroAjax.ruta=rutaBB;
    parametroAjax.data = {IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarInventario(respuesta);
}

var BuscarInventarioTotalFamilia = function(IdFamilia,IdBodega){
    parametroAjax.ruta=rutaBF;
    parametroAjax.data = {IdFamilia:IdFamilia,IdBodega:IdBodega};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarInventario(respuesta);
}

var BuscarInventarioBodega = function(IdLocal){
    parametroAjax.ruta=rutaIBB;
    parametroAjax.data = {IdLocal:IdLocal};
    respuesta=procesarajax(parametroAjax);
    if (respuesta.code==200){
        crearselect(respuesta.respuesta,"IdBodega");
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

var solicitarInventario = function (){
    $("#ModalInventario").modal();
    BuscarInventarioTotal(NBodega)
}

var ManejoInventario = function(Caso){
    console.log(Caso);
    parametroAjax.ruta=rutaCI;
    parametroAjax.data = {IdInventario:NInventario,IdBodega:NBodega,Caso:Caso};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarI(respuesta);
}

// var cerrarInventario = function (){
//     parametroAjax.ruta=rutaCI;
//     parametroAjax.data = {IdInventario:NInventario,IdBodega:NBodega,caso:1};
//     respuesta=procesarajax(parametroAjax);
//     ManejoRespuestaProcesarI(respuesta);
// }

// var ajustarInventario = function (){
//     parametroAjax.ruta=rutaCI;
//     parametroAjax.data = {IdInventario:NInventario,caso:2};
//     respuesta=procesarajax(parametroAjax);
//     ManejoRespuestaProcesarI(respuesta);
// }




$(document).ready(function(){
    $("#FechaInventario").inputmask({ mask: "99-99-9999"});
    $("#FechaTomaInventario").inputmask({ mask: "99-99-9999"});
    $("#FechaAjusteInventario").inputmask({ mask: "99-99-9999"});
    cargarTablaInventario(d.v_inventario);
    crearAllSelect(d);

    $("#CodigoBarra").focusout(function() {
        var codigo = $("#CodigoBarra").val();
        if (codigo.length > 2){
            limpiarFormDetalle();
            buscarProducto($("#CodigoBarra").val());
        }
    });
    $('#IdFamiliaToma').on('change', function(e) {
        BuscarInventarioTotalFamilia($('#IdFamiliaToma').val(),NBodega)
    });

    $('#IdLocal').on('change', function(e) {
        BuscarInventarioBodega($('#IdLocal').val())
    });


    $('#FormDetalle').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    $(document).on('click','#guardar',validador);
    $(document).on('click','#cancelar',BotonCancelar);
    $(document).on('click','#agregar',BotonAgregar);
    $(document).on('click','#modificar',modificarCabeceras);
    $(document).on('click','#agregarC',BotonAgregarDetalle);
    $(document).on('click','#guardarC',validadorD);
    $(document).on('click','#cancelarC',BotonCancelarDetalle);
    $(document).on('click','#closeModal',BotonCancelarDetalle);
    $(document).on('click','#modificarC',modificarDetalles);
    $(document).on('click','#btn-list',volverListado);
    $(document).on('click','#btn-sol-inv',solicitarInventario);
    // $(document).on('click','#btn-cer-inv',cerrarInventario);
    // $(document).on('click','#btn-aju-inv',ajustarInventario);

    // caso cerrar inventario
    $('#btn-cer-inv').on('click', function(e) {
        ManejoInventario(1);
    });

    // caso ajustar inventario
    $('#btn-aju-inv').on('click', function(e) {
        ManejoInventario(2);
    });
    
    $('#FormInventario').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'FechaInventario': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'FechaTomaInventario': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'Comentario': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'TipoInventario': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'IdBodega': {
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
        ProcesarInventario();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });


    $('#FormDetalle').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'CodigoBarra': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'StockFisico': {
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
        ProcesarDetalleInventario();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});