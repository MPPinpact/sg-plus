var manejoRefresh=limpiarTablaResumenCompraMasiva=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var CargarResumenCompraMasiva = function(IdCompra){
    console.log("CargarResumenCompraMasiva("+IdCompra+")");
    $("#tituloReporteCompraMasica").text("Reporte de la Compra Masiva Nro. " + d.IdCompra);

    parametroAjax.ruta=rutaRC;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);

    cargarTablaResumenCompraMasiva(respuesta.respuesta.v_resumen_compra);
    
}

var cargarTablaResumenCompraMasiva = function(data){
    
    if(limpiarTablaResumenCompraMasiva==1){
		destruirTabla('#tablaResumenCompraMasiva');
		$('#tablaResumenCompraMasiva thead').empty();
	}
		
	$("#tablaResumenCompraMasiva").dataTable({
		responsive:true,
		"aLengthMenu": DataTableLengthMenu,
		"pagingType": "full_numbers",
		"language": LenguajeTabla,
		"paging":   true,
		"bFilter": true,
		"info":false,			
		"pageLength": 25, 
		"data": data,
		"columns":[
                {"title": "",
                    "data": "IdCompra",  width:100, className: "text-center", 
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verCompraMasiva(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        <a href="#" onclick="VerReporteCompra(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Reporte Compra" data-original-title="Print">
                            <i class="icofont icofont-print	"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Nro. Compra","data": "IdCompra", width:100, className: "text-center"},
                {"title": "Fecha Ingreso", width:150, className: "text-center",
                    "data": "FechaDTE",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
                        }
                        return data;
                    }
                },
                {"title": "Lcoal","data": "NombreLocal", width:200, className: "text-left"},
                {"title": "Bodega","data": "NombreBodega", width:200, className: "text-left"},
                {"title": "Costo Compra","data": "CostoCompra", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:200, className: "text-right"},
                {"title": "Valorizado Venta","data": "ValorizadoVenta", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:200, className: "text-right"},
                
            ],
	});
	limpiarTablaResumenCompraMasiva=1;
};

$(document).ready(function(){

    if(d.IdCompra){
        CargarResumenCompraMasiva(d.IdCompra);

        



    }


});