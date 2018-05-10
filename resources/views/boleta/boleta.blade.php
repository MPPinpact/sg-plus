<!-- modal boleta             -->
<div class="modal fade" id="ModalBoletaPlantilla" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Impresión de Ticket</h4>
            </div>
            <div class="modal-body" style="height:350px;width:auto;overflow-y: scroll;overflow-x:hidden;">
            	<div id="CuerpoBoleta">
                    <center>
                        <div id="DetalleBoleta" style="height:auto;">   </div>
                        <table border="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <center>
                                        <svg id="barcode"></svg>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
	        	<button id="PrintPre" type="button" class="btn btn-default waves-effect ">Imprimir</button>
	        	<button id="PdfBoleta" type="button" class="btn btn-default waves-effect ">PDF</button>
	        	<button id="CerrarModal" type="button" class="btn btn-default waves-effect">Cerrar</button>
            </div>
        </div>
    </div>
</div>