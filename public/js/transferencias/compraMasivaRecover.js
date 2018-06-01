var manejoRefresh=limpiarTablaResultadoCompraMasiva=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var BotonRecuperarCM = function(){
	console.log("BotonRecuperarCM");
	
	cargarTablaResultadoBusqueda(null);
	
	$("#ModalRecoverCompraMasiva").modal();
	
	$('#ModalRecoverCompraMasiva').on('shown.bs.modal', function() {
		$('#NroCompraMasiva').focus().select();
	});
	
}

var cargarTablaResultadoBusqueda = function(data){
    
    if(limpiarTablaResultadoCompraMasiva==1){
		destruirTabla('#tableResultadoComprasMasivas');
		$('#tableResultadoComprasMasivas thead').empty();
	}
		
	$("#tableResultadoComprasMasivas").dataTable({
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
                        <a href="#" onclick="Recuperar(`+data+`);" class="text-muted" data-toggle="tooltip" data-placement="top" title="Recuperar Compra Masiva" data-original-title="Recover">
                            <i class="icofont icofont-recovery"></i>
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
	limpiarTablaResultadoCompraMasiva=1;
};

$(document).ready(function(){

    //cargarTablaResultadoBusqueda(d.v_compras_masiva);
    
	$(document).on('click','#botonRecuperarCompraMasiva', BotonRecuperarCM);

});