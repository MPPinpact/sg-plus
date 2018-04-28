var manejoRefresh=limpiarTablaListadosCompra=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var verCompraMasiva = function(IdCompra){
    
    $("#IdCompra").val(IdCompra);
    window.location.href = "/compraMasivaView";

}

var cargarTablaListadosCompra = function(data){
    if(limpiarTablaListadosCompra==1){
		destruirTabla('#tablaListadosCompra');
		$('#tablaListadosCompra thead').empty();
	}
		
	$("#tablaListadosCompra").dataTable({
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
                    "data": "IdListadoCompra",  width:100, className: "text-center", 
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verListadoCompra(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Nro. Listado","data": "IdListadoCompra", width:100, className: "text-center"},
                {"title": "Fecha Ingreso", width:150, className: "text-center",
                            "data": "FechaListadoCompra",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MMM-YYYY");
                                }
                                return data;
                            }
                },
                {"title": "Fecha Estimada Compra", width:150, className: "text-center",
                            "data": "FechaEstimadaCompra",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = moment(data, 'YYYY-MM-DD',true).format("DD-MMM-YYYY");
                                }
                                return data;
                            }
                },
                {"title": "Empresa","data": "NombreFantasia", width:200, className: "text-left"},
                {"title": "Local","data": "NombreLocal", width:200, className: "text-left"},
                {"title": "Bodega","data": "NombreBodega", width:200, className: "text-left"},
            ],
	});
	limpiarTablaListadosCompra=1;
};

$(document).ready(function(){

    cargarTablaListadosCompra(d.v_compras_listado_compra);



});