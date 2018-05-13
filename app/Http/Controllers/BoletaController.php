<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Form;
use Lang;
use View;
use Redirect;
use SerializesModels;
use Log;
use Session;
use Config;
use Mail;
use Storage;
use DB;
use PDF;

use CodeItNow\BarcodeBundle\Utils\QrCode;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DNS1D;

use App\Models\Preventa;
use App\Models\Venta;
use App\Models\Boleta;

class BoletaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    protected function postBoletaVer(Request $request){
        $datos = $request->all();
 if ($datos['caso']==1){
            $preventa = Preventa::find($datos['idPreVenta']);
            if($preventa->EstadoPreVenta == 2 or $preventa->EstadoPreVenta == 3){
                $model= new Boleta();
                $result['status']['code'] = 200;
                $result['status']['des_code'] = "Procesada.!";
                $result['boleta'] = $model->verBoleta($preventa,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una preventa cerrada";
            }
        }

        if ($datos['caso']==2){
            $venta = Venta::find(isset($datos['IdVenta']) ? $datos['IdVenta'] : $datos['idPreVenta'] );

            if($venta->EstadoVenta == 2 or $venta->EstadoVenta == 3){
                $model= new Boleta();
                $result['status']['code'] = 200;
                $result['status']['des_code'] = "Procesada.!";
                $result['boleta'] = $model->verBoleta($venta,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una venta cerrada 332";
            }
        }
        return $result;
    }



    protected function postBoletaPdf(Request $request){
        $datos = $request->all();
        $model= new Boleta();

        if ($datos['caso']==1){
            PDF::SetTitle('PREVENTA');
            $codigo = $datos['idPreVenta'];
            $preventa = Preventa::find($datos['idPreVenta']);
            if($preventa->EstadoPreVenta == 2 or $preventa->EstadoPreVenta == 3){
                $model= new Boleta();
                // Cuerpo de la boleta
                $html_content = $model->verBoleta($preventa,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una preventa cerrada";
                return $result;
            }
        }

        if ($datos['caso']==2){
            PDF::SetTitle('VENTA');
            $codigo = $datos['IdVenta'];
            $venta = Venta::find(isset($datos['IdVenta']) ? $datos['IdVenta'] : $datos['idPreVenta'] );
            if($venta->EstadoVenta == 2 or $venta->EstadoVenta == 3){
                $model= new Boleta();
                // Cuerpo de la boleta
                $html_content = $model->verBoleta($venta,$datos['caso']);
            }else{
                $result['status']['code'] = 204;
                $result['status']['des_code'] = "solo se puede imprimir una venta cerrada";
                return $result;
            }
        }

        $html_content .= 
        '<table border="0" cellspacing="0" width="100%" style="text-align:center;">
            <tr>
                <td width="100%">
                    <img align=center src="data:image/png;base64,'.DNS1D::getBarcodePNG($codigo, "C39+").'" alt="barcode"/> 
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    '.$codigo.'
                </td>
            </tr>
        </table>';

        $width = 80;  
        $height = ($datos['height'] / 2.5);
        $pageLayout = array($width, $height);
        PDF::SetMargins(0, 1, 3);
        PDF::SetAutoPageBreak(TRUE, 0);
        PDF::AddPage('P',$pageLayout);
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::IncludeJS('print(true);');
        PDF::Output(uniqid().'_SamplePDF.pdf', 'I');
    }

}





