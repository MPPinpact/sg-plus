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

        $empresa = DB::table('v_empresas')->where('EstadoEmpresa',1) ->limit(1)->get();
        
        if ($caso==1){ 
            $tittle= "PREVENTA ".$obj->idPreVenta; 
            $numero = "N° ".$obj->idPreVenta;
            $id = $obj->idPreVenta;
            $detalles = DB::select("select count(1) as Cant,NombreProducto,ValorUnitarioVenta from v_preventas_detalle where IdPreVenta = ".$obj->idPreVenta." group by NombreProducto,ValorUnitarioFinal");
            $pagos = DB::select("select FormaPago,MontoPagado from v_preventas_pagos where IdPreVenta =".$obj->idPreVenta);

            $DetalleFactura = '';
            $total = 0;
            foreach ($detalles as $key => $detalle) {
                $CantTotal = 0;
                $DetalleFactura .= '
                <tr>
                <td>'.$detalle->NombreProducto.'</td>
                <td>'.$detalle->Cant.'</td>
                <td align="right">'.$detalle->ValorUnitarioVenta.'</td>
                </tr>
                ';
                $CantTotal = ($detalle->Cant * $detalle->ValorUnitarioVenta);
                
                $total += $CantTotal;
            }

        }

        // log::info($obj);

        if ($caso==2){ 
            $tittle= "VENTA ".$obj->IdVenta; 
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
                <td>'.$detalle->CantidadVenta.'</td>
                <td align="right">'.$detalle->ValorUnitarioVenta.'</td>
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
            <td align="right">'.$pago->MontoPagado.'</td>
            </tr>
            ';
            $totalPago += $pago->MontoPagado;
        }

        return 
        '
        <div style="font-size:07px;">
            <input type="hidden" id="NumeroBoletaModal" value="'.$id.'">
            <table border="1" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:center;">
                                    '.$empresa[0]->RUT.'
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
                        <b>'.$empresa[0]->NombreFantasia.'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>'.$empresa[0]->Giro.'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>CASA MATRIZ </b> GENERAL L ASTRA 688 SANTIAGO
                    </td>
                </tr>
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
                <tr>
                    <td>
                        Vale N° 00000130831 Ejec. CBM - hora 10:51
                    </td>
                </tr>                                                                             
            </table>
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td width="60%">DETALLE COMPRA</td>
                    <td width="20%">CANT</td>
                    <td width="20%"align="right">TOTAL</td>
                </tr>
            '.$DetalleFactura.'
                <tr>
                    <td colspan="2"><b>TOTAL</b></td>
                    <td align="right"><b>'.$total.'.00</b></td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td colspan="2"><b>DETALLE PAGO</b></td>
                    <td align="right"></td>
                </tr>
            '.$DetallePago.'
            </table>
        </div>
        ';
    }


}
