<!-- modal boleta             -->
<div class="modal fade" id="ModalBoletaPlantilla" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Boleta de Preventa</h4>
            </div>
            <div class="modal-body" style="font-size:10px;height:350px;width:auto;border:1px solid #ddd;background:#f1f1f1;overflow-y: scroll;overflow-x:hidden;">
            	<center>
            		<div id="CuerpoBoleta" style="height:auto;"></div>
            	</center>
            </div>
            <div class="modal-footer">
	        	<button id="PrintPre" type="button" class="btn btn-default waves-effect ">Imprimir</button>
	        	<button id="PdfBoleta" type="button" class="btn btn-default waves-effect ">PDF</button>
	        	<button id="CerrarModal" type="button" class="btn btn-default waves-effect">Cerrar</button>
            </div>
        </div>
    </div>
</div>