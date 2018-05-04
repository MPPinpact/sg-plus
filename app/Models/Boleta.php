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
            $tittle= "PREVENTA <br> N° ".$obj->idPreVenta; 
            $tabla = "v_preventas_detalle";
            $campo = "IdPreVenta";
            $id = $obj->idPreVenta;
            $detalles = DB::select("select count(1) as Cant,NombreProducto,ValorUnitarioFinal from v_preventas_detalle where IdPreVenta = ".$obj->idPreVenta." group by NombreProducto,ValorUnitarioFinal");
            $pagos = DB::select("select FormaPago,MontoPagado from v_preventas_pagos where IdPreVenta =".$obj->idPreVenta);
        }

        if ($caso==2){ 
            $tittle= "VENTA N° xxx"; 
            $tabla = "v_ventas_detalle";
            $campo = "IdVenta";
            $id = $obj->idVenta;
        }


        $DetalleFactura = '';
        $total = 0;
        foreach ($detalles as $key => $detalle) {
            $CantTotal = 0;
            $DetalleFactura .= '
                <tr>
                    <td>'.$detalle->NombreProducto.'</td>
                    <td>'.$detalle->Cant.'</td>
                    <td align="right">'.$detalle->ValorUnitarioFinal.'</td>
                </tr>
            ';
            $CantTotal = ($detalle->Cant * $detalle->ValorUnitarioFinal);
            
            $total += $CantTotal;
        }

        $DetallePago = '';
        $totalPago = 0;
        foreach ($pagos as $key => $pago) {
            $DetallePago .= '
                <tr>
                    <td>'.$pago->FormaPago.'</td>
                    <td align="right">'.$pago->MontoPagado.'</td>
                </tr>
            ';
            $totalPago += $pago->MontoPagado;
        }

        return 
                '
                <input type="hidden" id="NumeroBoletaModal" value="'.$id.'">
                <table border="1" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <center>
                                '.$empresa[0]->RUT.'<br>
                                '.$tittle.' <br>
                            </center>
                        </td>
                    </tr>
                </table>

                <br>

                <table border="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <b>'.$empresa[0]->NombreFantasia.'</b><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>'.$empresa[0]->Giro.'</b><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CASA MATRIZ </b> GENERAL L ASTRA 688 SANTIAGO <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>GENERAL L ASTRA 688 SANTIAGO </b><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>FECHA DE EMISIÓN : 08-04-2018 </b><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Vale N° 00000130831 Ejec. CBM - hora 10:51 <br>
                        </td>
                    </tr>                                                                             
                </table>

                <br>

                <table border="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="80%">DETALLE</td>
                        <td width="80%">CANT</td>
                        <td align="right">TOTAL</td>
                    </tr>
                    '.$DetalleFactura.'
                    <tr>
                        <td width="80%" colspan="2"><b>TOTAL</b></td>
                        <td align="right"><b>'.$total.'.00</b></td>
                    </tr>
                </table>

                <br>

                <table border="0" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2">
                            <b>FORMAS DE PAGO<b>
                        </td>
                    </tr>

                    <tr>
                        <td width="80%">DETALLE</td>
                        <td width="20%" align="right">CANT</td>
                    </tr>
                    '.$DetallePago.'
                    <tr>
                        <td width="80%"> <b> TOTAL PAGADO </b> </td>
                        <td width="20%" align="right"> <b> '.$totalPago.'.00 </b> </td>
                    </tr>

                </table>

                <br>

                <table border="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <center>
                                <svg id="barcode"></svg>
                            </center>
                        </td>
                    </tr>
                </table>';
    }


}
