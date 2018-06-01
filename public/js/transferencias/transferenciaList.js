var manejoRefresh=limpiarTablaTransferencia=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var verTransferencia = function(IdTransferencia){
    
    $("#IdTransferencia").val(IdTransferencia);
    //window.location.href = "/compraMasivaView?id="+IdCompra;
    //$("#FormTransferenciaView").submit();
    document.getElementById("FormTransferenciaView").submit();

}

var cargarTablaTransferencia = function(data){
    if(limpiarTablaTransferencia==1){
		destruirTabla('#tablaTransferencia');
		$('#tablaTransferencia thead').empty();
	}
		
	$("#tablaTransferencia").dataTable({
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
                    "data": "IdTransferencia",  width:100, className: "text-center", 
                    "render": function(data, type, row, meta){
                        var result = `
                        <center>
                        <a href="#" onclick="verTransferencia(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Ver Detalles" data-original-title="Delete">
                            <i class="icofont icofont-search"></i>
                        </a>
                        </center>`;
                        return result;
                    }
                },
                {"title": "Nro. Transferencia","data": "IdTransferencia", width:100, className: "text-center"},
                {"title": "Fecha Transferencia", width:150, className: "text-center",
                    "data": "FechaTransferencia",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = moment(data, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY HH:mm");
                        }
                        return data;
                    }
                },
                {"title": "Local Origen","data": "NombreLocalOrigen", width:150, className: "text-center"},
                {"title": "Bodega Origen","data": "NombreBodegaOrigen", width:150, className: "text-center"},
                {"title": "Local Destino","data": "NombreLocalDestino", width:150, className: "text-center"},
                {"title": "Bodega Destino","data": "NombreBodegaDestino", width:150, className: "text-center"},
                {"title": "Total","data": "TotalTransferencia", width:100, 
                            render: $.fn.dataTable.render.number( '.', ',', 2 ),
                            className: "text-right"},
                {"title": "Estado","data": "EstadoTransferencia", width:200, className: "text-center"}
            ],
	});
	limpiarTablaTransferencia=1;
};

$(document).ready(function(){

    cargarTablaTransferencia(d.v_transferencia);



});