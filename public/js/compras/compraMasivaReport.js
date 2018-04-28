var manejoRefresh=limpiarTablaResumenCompraMasiva=limpiarTablaResumenCompraMasivaLocal=limpiarTablaResumenCompraMasivaBodega=0;

var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var CargarResumenCompraMasiva = function(IdCompra){
    console.log("CargarResumenCompraMasiva("+IdCompra+")");
    $("#tituloReporteCompraMasiva").text("Reporte de la Compra Masiva Nro. " + d.IdCompra);
    $("#tituloRCMB").text("Resumen x Bodega de la Compra Masiva Nro. " + d.IdCompra);
    $("#tituloRCML").text("Resumen x Local de la Compra Masiva Nro. " + d.IdCompra);
    
    parametroAjax.ruta=rutaRC;
    parametroAjax.data = {IdCompra:IdCompra};
    respuesta=procesarajax(parametroAjax);

    cargarTablaResumenCompraMasivaBodega(respuesta.respuesta.v_resumen_compra_bodega);
    cargarTablaResumenCompraMasivaLocal(respuesta.respuesta.v_resumen_compra_local);
    
}

var cargarTablaResumenCompraMasivaBodega = function(data){
    
    if(limpiarTablaResumenCompraMasiva==1){
        destruirTabla('#tablaResumenCompraMasivaBodega');
        $('#tablaResumenCompraMasivaBodega thead').empty();
    }
        
    $("#tablaResumenCompraMasivaBodega").dataTable({
        "footerCallback": function ( row, data, start, end, display ){
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i){
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            totalCosto = api
                .column(2)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalVenta = api
                .column(3)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
        },
        responsive:false,
        "aLengthMenu": DataTableLengthMenu,
        "language": LenguajeTabla,
        "paging":   false,
        "bFilter": false,
        "data": data,
        "columns":[
                {"title": "Lcoal","data": "NombreLocal", width:100, className: "text-left"},
                {"title": "Bodega","data": "NombreBodega", width:100, className: "text-left"},
                {"title": "Costo Compra","data": "CostoCompra", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
                {"title": "Valorizado Venta","data": "ValorizadoVenta", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
                {"title": "Margen","data": "Margen", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
            ],
    });
    console.log("totalCosto: " + totalCosto);
    console.log("totalVenta: " + totalVenta);
    //$("#tablaResumenCompraMasivaBodega").append('<tfoot style="float:right;"><th colspan="2"></th><th>Totales</th><th >'+totalCosto+'</th><th>'+totalVenta+'</th><th></th></tfoot>')
    limpiarTablaResumenCompraMasiva=1;
};

var cargarTablaResumenCompraMasivaLocal = function(data){
    
    if(limpiarTablaResumenCompraMasivaLocal==1){
        destruirTabla('#tablaResumenCompraMasivaLocal');
        $('#tablaResumenCompraMasivaLocal thead').empty();
    }
        
    $("#tablaResumenCompraMasivaLocal").dataTable({
        "footerCallback": function (tfoot, data, start, end, display ){
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i){
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            totalCosto = api
                .column(1)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalVenta = api
                .column(2)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
        },
        responsive:false,
        "aLengthMenu": DataTableLengthMenu,
        "language": LenguajeTabla,
        "paging":   false,
        "bFilter": false,
        "data": data,
        "columns":[
                {"title": "Lcoal","data": "NombreLocal", width:100, className: "text-left"},
                {"title": "Costo","data": "TotalCostoCompra", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
                {"title": "Valorizado","data": "TotalValorizadoVenta", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
                {"title": "Margen","data": "Margen", 
                                render: $.fn.dataTable.render.number( '.', ',', 2 ), 
                                width:50, className: "text-right"},
                
            ],
    });
    

    console.log("totalCosto: "+ totalCosto);
    console.log("totalVenta: "+ totalVenta);
    limpiarTablaResumenCompraMasivaLocal=1;
};

$(document).ready(function(){
    console.log("IdCompra: " + d.IdCompra);

    if(d.IdCompra){
        CargarResumenCompraMasiva(d.IdCompra);
    }


});