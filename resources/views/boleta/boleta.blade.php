<style>
.TextoGrande {
  font-family :arial;
  font-size   : 12.5pt;
  font-weight :bold;
}

/* ESTILO TEXTO GIRO EMPRESA */
.TextoGiro {
  font-family :arial;
  font-size   :12pt;
}

/* TITULO DE TABLAS */
.TablaTitulo
{
  background:#D8D8D8;
  font-family: verdana;
  font-size:10pt;
  text-align:left;
  border-bottom:2px solid black;
}

/* TITULO DE TABLAS */
.TablaDetalle
{
  /* background:#D8D8D8; */
  font-family: verdana;
  font-size:10pt;
  text-align:left;
}
</style>
<!-- modal boleta             -->
<div class="modal fade" id="ModalBoletaPlantilla" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Impresión de Ticket</h4>
      </div>
      <div class="modal-body" style="height:450px;width:auto;overflow-y: scroll;overflow-x:hidden;">
        <input type="hidden" id="NumeroBoletaModal">
        <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">        
        <center>
          <div id="CuerpoBoleta" style="width:303px;">
            <div id="DetalleBoleta"></div>
            <table border="0" cellspacing="0" width="100%">
              <tr>
                <td>
                  <center>
                    <svg id="barcode"></svg>
                  </center>
                </td>
              </tr>
            </table>
          </div>
        </center>
      </div>
    </center>
    <div class="modal-footer">
      <button id="PrintPre" type="button" class="btn btn-default waves-effect ">Imprimir</button>
      <button id="PdfBoleta" type="button" class="btn btn-default waves-effect ">PDF</button>
      <button id="CerrarModal" type="button" class="btn btn-default waves-effect">Cerrar</button>
    </div>
  </div>
</div>
