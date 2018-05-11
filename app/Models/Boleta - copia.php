<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\QueryException;
use App\Exceptions\Handler;
use Illuminate\Mail\Mailable;

use DB;
use Log;
use DateTime;
use Session;
use Exception;
use Auth;
use Empresa;


class Boleta extends Authenticatable
{

    public function verBoleta($obj,$caso){
        log::info("verBoleta(".$obj.",".$caso.")");

        $local = DB::table('v_locales')->where('IdLocal',$obj->IdLocal)->limit(1)->first();
        $empresa = DB::table('v_empresas')->where('IdEmpresa',$local->IdEmpresa)->limit(1)->first();

        if ($caso==1){ 
            $tittle= "PREVENTA"; // N° ".$obj->idPreVenta; 
            $numero = "N° ".$obj->idPreVenta;
            $id = $obj->idPreVenta;
            $detalles = DB::select("select CantidadPreVenta as Cant,NombreProducto,ValorUnitarioVenta from v_preventas_detalle where IdPreVenta = ".$obj->idPreVenta." group by NombreProducto,ValorUnitarioFinal");
           
           $pagos = DB::select("select FormaPago,MontoPagado from v_preventas_pagos where IdPreVenta =".$obj->idPreVenta);

            $DetalleFactura = '';
            $DetalleFacturaNew = '';

            $total = 0;
            foreach ($detalles as $key => $detalle) {
                $CantTotal = 0;
                $DetalleFactura .= '
                <tr>
                <td>'.$detalle->NombreProducto.'</td>
                <td>'.number_format($detalle->Cant, 2, ",", ".").'</td>
                <td align="right">'.number_format($detalle->ValorUnitarioVenta, 2, ",", ".").'</td>
                </tr>
                ';
                $CantTotal = ($detalle->Cant * $detalle->ValorUnitarioVenta);
                
                $total += $CantTotal;

                $DetalleFacturaNew .= '
                        <tr>
                          <td class="TablaDetalle" style="text-align:left">'.$detalle->NombreProducto.'</td>
                          <td class="TablaDetalle" style="text-align:right">'.number_format($detalle->Cant, 2, ",", ".").'</td>
                          <td class="TablaDetalle" style="text-align:right">'.number_format($detalle->ValorUnitarioVenta, 2, ",", ".").'</td>
                          <td class="TablaDetalle" style="text-align:right">0</td>
                          <td class="TablaDetalle" style="text-align:right">'.number_format($CantTotal, 2, ",", ".").'</td>
                        </tr>
                ';
            }

        }

        if ($caso==2){ 
            $tittle= "VENTA ";  // N° ".$obj->IdVenta; 
            $numero = "N° ".$obj->IdVenta;
            $id = $obj->IdVenta;
            $detalles = DB::select("select CantidadVenta, NombreProducto, ValorUnitarioVenta from v_ventas_detalle where IdVenta = ".$obj->IdVenta);
            $pagos = DB::select("select FormaPago,MontoPagado from v_ventas_pagos where IdVenta=".$obj->IdVenta);

            $DetalleFactura = '';
            $total = 0;
            foreach ($detalles as $key => $detalle) {
                $CantTotal = 0;
                $DetalleFactura .= '
                <tr>
                <td>'.$detalle->NombreProducto.'</td>
                <td align="center">'.number_format($detalle->CantidadVenta, 2, ",", ".").'</td>
                <td align="right">'.number_format($detalle->ValorUnitarioVenta, 2, ",", ".").'</td>
                </tr>
                ';
                $CantTotal = ($detalle->CantidadVenta * $detalle->ValorUnitarioVenta);

                $total += $CantTotal;                
            }

        }

        $FechaNow = new DateTime();
        $DetallePago = '';
        
        $totalPago = 0;
        foreach ($pagos as $key => $pago) {
            $DetallePago .= '
            <tr>
            <td colspan="2">'.$pago->FormaPago.'</td>
            <td align="right">'.number_format($pago->MontoPagado, 2, ",", ".").'</td>
            </tr>
            ';
            $totalPago += $pago->MontoPagado;
        }

        return 
        '
        <div style="font-size:7px;">
            <input type="hidden" id="NumeroBoletaModal" value="'.$id.'">
            <table border="1" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" width="100%" >
                            <tr>
                                <td style="text-align:center;">
                                    '.$local->RUTEmpresa.'
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    '.$tittle.'
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    '.$numero.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <b>'.$empresa->NombreFantasia.'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>'.$empresa->Giro.'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>'.$local->DireccionLocal.'</b>
                    </td>
                </tr>
                <tr><td>
                    <div class="TextoGrande">'.$empresa->NombreFantasia.'<br />
                    <div class="TextoGiro">
                        <b>Giro: </b>'.$empresa->Giro.'<br />
                        <b>Dirección: </b>'.$local->DireccionLocal.'<br />
                        <b>Comuna: </b>PUERTO VARAS<br />
                        <b>Ciudad: </b>PUERTO VARAS</div>
                    </div>
                </td></tr>
                <tr><td><div class="TextoGiro"> </div></td></tr>
            </table>

            <table>
                <tr>
                    <td>
                        <b>FECHA DE EMISIÓN : '.$FechaNow->format('d-m-Y').' </b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>HORA DE EMISIÓN : '.$FechaNow->format('H:i:s').' </b>
                    </td>
                </tr>                                                                            
            </table>
            <br />
            <table border="0" cellspacing="0" width="100%" style="font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr class="tableHead" style="font-weight: bold;" >
                    <td width="60%">DETALLE COMPRA</td>
                    <td width="20%">CANT</td>
                    <td width="20%"align="right">TOTAL</td>
                </tr>
            '.$DetalleFactura.'
                <tr>
                    <td colspan="2"><b>TOTAL</b></td>
                    <td align="right"><b>'.number_format($total, 2,",", ".").'</b></td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td colspan="3"  style="font-weight: bold;">DETALLE PAGO</td>
                </tr>
            '.$DetallePago.'
            </table>


            <table border="0px" cellpadding="0" cellspacing="0" class="Tabla" height="400px">
                <colgroup>
                  <col style="width:auto" />
                  <col style="width:80px" />
                  
                  <col style="width:80px;" />
                  <col style="width:80px;" />
                  <col style="width:80px;" />
                </colgroup>
                <tr>
                  <th colspan="5" class="TablaTitulo">Detalle</th>
                </tr>
                <tr>
                  <th class="TablaTitulo">Detalle</th>
                  <th class="TablaTitulo">Cantidad</th>
                  
                  <th class="TablaTitulo">Precio</th>
                  <th class="TablaTitulo">Descto</th>
                  <th class="TablaTitulo">Valor</th>
                </tr> '.$DetalleFacturaNew.'
        </div>
        ';
    }


}
