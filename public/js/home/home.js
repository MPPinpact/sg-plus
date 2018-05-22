var meses = ['', 'Enero','Febrero','Marzo','Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiempre','Octubre','Noviembre','Diciembre'];
var imgProgreso = '<img alt="" src="/img/giphy.gif" height="50" width="50"/>';
var stopRead = 0;
var limpiarTablaResutadoBusqueda=limpiarTablaStockProducto=0;

var cambiarSalir = function(){
	v_salir = 1;
}

var parametroAjaxGET = {
    'token': $('input[name=_token]').val(),
    'tipo': 'GET',
    'data': {},
    'ruta': '',
    'async': false
};

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

// Maximizar ventana de chat
var ShowMessage = function(){
	$("#divChatMin").stop();
	$("#divChatMin").hide("slow");
	$("#divChat").show("fast");
	$('#message').focus();
	cambiarStatusMessage();
}

// Minimizar ventana de chat
var HideMessage = function(){
	$("#divChat").hide("fast");
	$("#divChatMin").show("slow");
}

var cargarPanelesVenta = function(){
	//console.log("cargarPaneles()");
	
    parametroAjax.ruta=rutaHome;
    respuesta=procesarajax(parametroAjax);

    ventaAgno = respuesta.respuesta.ventaAgno;
    ventaMes = respuesta.respuesta.ventaMes;
    ventaSemana = respuesta.respuesta.ventaSemana;
    ventaDia = respuesta.respuesta.ventaDia;
    vendedores = respuesta.respuesta.vendedores;

	var ventaLocal="";
	var totalLocales=0;
    var totalTRX=0;

    for(i=0; i < ventaDia.length; i++){
    	ventaLocal = ventaLocal + ventaDia[i].NombreLocal + ': $ ' + parseFloat(ventaDia[i].TotalVenta).toLocaleString('cl') + ' ['+parseFloat(ventaDia[i].CantidadVentas).toLocaleString('cl')+'] <br>';
    	
        totalLocales = parseFloat(totalLocales) + parseFloat(ventaDia[i].TotalVenta);
        totalTRX = parseFloat(totalTRX) + parseFloat(ventaDia[i].CantidadVentas);
    }

    textTotalLocales = parseFloat(totalLocales).toLocaleString('cl') + ' ['+parseFloat(totalTRX).toLocaleString('cl')+' Ventas]';

    $("#VentaDiaLocal").html(ventaLocal);
    $("#totalVentaDia").html(textTotalLocales);

	var ventaLocal="";
	var totalLocales=0;
    var totalTRX=0;

    for(i=0; i < ventaSemana.length; i++){
    	ventaLocal = ventaLocal + ventaSemana[i].NombreLocal + ': $ ' + parseFloat(ventaSemana[i].TotalVenta).toLocaleString('cl') + ' ['+parseFloat(ventaSemana[i].CantidadVentas).toLocaleString('cl')+'] <br>';
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaSemana[i].TotalVenta);
        totalTRX = parseFloat(totalTRX) + parseFloat(ventaSemana[i].CantidadVentas);
    }

    textTotalLocales = parseFloat(totalLocales).toLocaleString('cl') + ' ['+parseFloat(totalTRX).toLocaleString('cl')+' Ventas]';


    $("#VentaSemanaLocal").html(ventaLocal);
    $("#totalVentaSemana").html(textTotalLocales);

    var ventaLocal="";
	var totalLocales=0;
    var totalTRX=0;

    for(i=0; i < ventaMes.length; i++){
    	ventaLocal = ventaLocal + ventaMes[i].NombreLocal + ': $ ' + parseFloat(ventaMes[i].TotalVenta).toLocaleString('cl') + ' ['+parseFloat(ventaMes[i].CantidadVentas).toLocaleString('cl')+'] <br>';
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaMes[i].TotalVenta);
        totalTRX = parseFloat(totalTRX) + parseFloat(ventaMes[i].CantidadVentas);
    }

    textTotalLocales = parseFloat(totalLocales).toLocaleString('cl') + ' ['+parseFloat(totalTRX).toLocaleString('cl')+' Ventas]';

    $("#VentaMesLocal").html(ventaLocal);
	$("#totalVentaMes").html(textTotalLocales);
	$("#totalMes").html("Venta acumulada en " + meses[ventaMes[0].Mes]);


	var ventaLocal="";
	var totalLocales=0;
    var totalTRX=0;

    for(i=0; i < ventaAgno.length; i++){
    	ventaLocal = ventaLocal + ventaAgno[i].NombreLocal + ': $ ' + parseFloat(ventaAgno[i].TotalVenta).toLocaleString('cl') + ' ['+parseFloat(ventaAgno[i].CantidadVentas).toLocaleString('cl')+'] <br>';
    	totalLocales = parseFloat(totalLocales) + parseFloat(ventaAgno[i].TotalVenta);
        totalTRX = parseFloat(totalTRX) + parseFloat(ventaAgno[i].CantidadVentas);
    }

    textTotalLocales = parseFloat(totalLocales).toLocaleString('cl') + ' ['+parseFloat(totalTRX).toLocaleString('cl')+' Ventas]';

    $("#VentaAgnoLocal").html(ventaLocal);
	$("#totalVentaAgno").html(textTotalLocales);
	$("#totalAgno").html("Venta acumulado el " + ventaAgno[0].Agno);

    //Score Venta 
    $("#tablaScoreVendedoresBody").empty();

    for(i=0; i < vendedores.length; i++){
        var avance = 0;
        if(vendedores[i].AcumuladoPeriodo>0){
            avance = (parseFloat(vendedores[i].AcumuladoPeriodo) / parseFloat(vendedores[i].MetaPeriodo) * 100).toLocaleString('cl');
        }else{
            vendedores[i].AcumuladoPeriodo = 0;
        }
        $('#tablaScoreVendedores tr:last').after('<tr><th><img class="img-fluid rounded-circle" src="'+vendedores[i].FotoVendedor+'" alt="User"></th><td>'+vendedores[i].NombreVendedor+'<p><i class="icofont icofont-sale-discount"></i>Comisión: '+parseFloat(vendedores[i].ComisionVendedor).toLocaleString('cl')+'</p></td><td>$'+ parseFloat(vendedores[i].MetaPeriodo).toLocaleString('cl')+'</td><td>$'+parseFloat(vendedores[i].AcumuladoPeriodo).toLocaleString('cl')+'</td><td class="chart">'+avance+'% <span class="pie" style="display: none;">180,180</span></td></tr>');
    }   
}

var cargarScoreVendedores = function(){
    //console.log("cargarScoreVendedores()");

}

var goShortcut = function(shortcut){
     window.location.assign("http://sg-plus.int/"+shortcut);
}

var BotonBuscarProducto = function(){
    console.log("BotonBuscarProducto");
    
    cargarResultadoBusquedaProducto(null);
    
    $("#spanTituloModalBusquedaProducto").text("Busqueda de Producto...");
    $("#InfoProducto").val($.trim($("#NombreProductoBusquedaRapida").val()));
    $("#ModalBuscarProducto").modal();
    
    $('#ModalBuscarProducto').on('shown.bs.modal', function() {
        $('#InfoProducto').focus().select();
    });
    
    var largoTXT = $.trim($("#InfoProducto").val());
    
    if(largoTXT.length > 0) BuscarProducto();
}

var BuscarProducto = function(){

    var largoTXT = $.trim($("#InfoProducto").val());
    
    if(largoTXT.length >= 4){   
        parametroAjax.ruta=rutaBPM;
        parametroAjax.data = {InfoProducto:$("#InfoProducto").val()};
        respuesta=procesarajax(parametroAjax);
        console.log("procesarajax()");
        
        ManejoRespuestaBuscarProductoPTOVTA(respuesta);
        
    }else{
        $.growl({message:"Debe ingresar al menos 3 caracteres para realizar la busqueda de un Producto!!!"},{type: "warning", allow_dismiss: true});
        
    }
}

var ManejoRespuestaBuscarProductoPTOVTA = function(respuesta){
    console.log(respuesta);
    console.log(respuesta.respuesta);
    if(respuesta.code==200){
        if(respuesta.respuesta!=null){
            if(respuesta.respuesta.productos){
                cargarResultadoBusquedaProducto(respuesta.respuesta.productos);
            }    
        }else{
            $.growl({message:"Producto no encontrado"},{type: "warning", allow_dismiss: true});
        }
    }
}

var cargarResultadoBusquedaProducto = function(data){
    if(limpiarTablaResutadoBusqueda==1){
        destruirTabla('#tablaResultadoBusquedaProducto');
        $('#tablaResultadoBusquedaProducto thead').empty();
    }
    
    var columnReport = [[1],[2]];
    
    $("#tablaResultadoBusquedaProducto").dataTable({
        responsive:true,
        "aLengthMenu": [[5],[5]],
        "pagingType": "full_numbers",
        "searching": false,
        "scrollCollapse": false,
        "lengthChange": false, 
        "language": LenguajeTabla,
        "bFilter": false,
        "data": data,
        "columns":[
            {"title": "Id","data": "IdProducto",visible:0},
            {"title": "Código","data": "CodigoBarra"},
            {"title": "Producto","data": "NombreProducto"},
            {"title": "Precio Venta","data": "PrecioVentaSugerido",
                        render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                        className: "text-right"},
            {"title": "Stock Total","data": "StockActual",
                        render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                        className: "text-right"},
            {"title": "Ver Stock",
                "data": null,
                "render": function(data, type, row, meta){
                    var result = `
                    <center>
                    <a href="#" onclick="StockProducto(`+data.IdProducto+`,'`+data.NombreProducto+`');" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Stock Producto" data-original-title="Delete">
                        <i class="icofont icofont-search"></i>
                    </a>
                    
                    </center>`;
                    return result;
                }
            },
        ],
    });
    limpiarTablaResutadoBusqueda=1;
};

var StockProducto = function(IdProducto,NombreProducto){
    console.log("Estoy 1111");
    console.log("StockProducto");

    parametroAjax.ruta=rutaCSP;
    parametroAjax.data = {IdProducto:IdProducto};
    respuesta=procesarajax(parametroAjax);
    cargarTablaStockProducto(respuesta.respuesta.v_stock);
    
    $("#NombreProductoStock").text("Stock del Producto: "+NombreProducto);
    $("#ModalStockProducto").modal();   
}

var cargarTablaStockProducto = function(data){
    
    if(limpiarTablaStockProducto==1){
        destruirTabla('#tablaStockProducto');
        $('#tablaStockProducto thead').empty();
    }
        
    $("#tablaStockProducto").dataTable({
        responsive:false,
        "aLengthMenu": [[5],[5]],
        "pagingType": "full_numbers",
        "language": LenguajeTabla,
        "lengthChange": false, 
        "bFilter": false,
        "scrollCollapse": false,
        
        "data": data,
        "columns":[
            {"title": "IdSotck","data": "IdStock",visible:0},
            {"title": "Local","data": "NombreLocal"},
            {"title": "Bodega","data": "NombreBodega",},
            {"title": "Cantidad","data": "Stock" ,
                        render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                        className: "text-right"},
        ],
    });
    limpiarTablaStockProducto=1;
};

$(document).ready(function() {
	// moment en idioma español
	// moment.locale('es');
	//Datos de usuario para cargar el contenido dependiendo del perfil
	v['v_perfil'] = $("#idPerfiltext").val();
	v['idUser'] = $("#idUsertext").val();
	//Cierre de sesion despues de 20 min de inactividad
	setTimeout(function(){Salir();},1200000);
	// Cierre de session por manupulacion de url o cierre del navegador
	window.onbeforeunload = function (e) {if (v_salir == 0){Salir();}v_salir = 0;}
    // $(document).on('click','.btn',cambiarSalir);
    $(document).on('click','.settings-menu',cambiarSalir);
    $(document).on('click','.waves-effect',cambiarSalir);
    $(document).on('click','.logo',cambiarSalir);
    $(document).on('click','.download-icon',cambiarSalir);
    //$(document).on('click','.text-muted',cambiarSalir);
    
    $(document).on('click','#botonBuscar',BotonBuscarProducto);
    

    $(document).on('click','#btn-logout',Salir);
	$(document.body).on("keydown", this, function (event) {
	    if (event.keyCode == 116) {
	        cambiarSalir();
	    }
	});

	cargarPanelesVenta();
    cargarScoreVendedores();

    $('.goShortcut').click(function() {
          goShortcut($(this).data('datac'));
    });

    $('#NombreProductoBusquedaRapida').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            console.log("Enter " + e.target.name + " | e.type:" + e.type + " - e.which: " + e.which+ " - e.keyCode: " + e.keyCode + "...");
            e.preventDefault();

            BotonBuscarProducto();
            return false;
        }
    });

});