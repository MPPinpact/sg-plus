var manejoRefresh=limpiarTablaCompraMasiva=0;

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

var cargarTablaCompraMasiva = function(data){
    if(limpiarTablaCompraMasiva==1){
		destruirTabla('#tablaDetalleCompra');
		$('#tablaDetalleCompra thead').empty();
	}
		
	$("#tablaComprasMasivas").dataTable({
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
                {"title": "Total Compra","data": "TotalCompra", width:200, className: "text-right"},
                {"title": "Estado Compra","data": "DesEstadoCompra", width:200, className: "text-center"}
            ],
	});
	limpiarTablaCompraMasiva=1;
};

$(document).ready(function(){

    cargarTablaCompraMasiva(d.v_compras_masiva);



});