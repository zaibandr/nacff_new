<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.02.2016
 * Time: 7:37
 */

namespace App\Http\Controllers;

use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Barryvdh\DomPDF\PDF;
use App\Http\Controllers\FuncController as Func;

class PrintController extends DBController
{
    public function index($id)
    {
        if (\Input::has('action')) {
            $pdf = \App::make('dompdf.wrapper');
            switch (\Input::get('action')) {
                case "label":
                    $res = $this->getLabel($id);
                    $name = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
                    $view = \View::make('pdfs.label')->with([
                        'code' => $res,
                    ]);
                    $pdf->loadHTML("$view")->setPaper(array(0, 0, 172, 100));
                    return $pdf->stream();
                    //return $view;
                    break;
                case 'act':
                    $act = $this->getAct($id);
                    $res = [];
                    foreach ($act as $val) {
                        $res['NAME'] = $val['SURNAME'] . " " . $val['NAME'] . " " . $val['PATRONYMIC'];
                        $res['GENDER'] = $val['GENDER'];
                        $res['DEPT'] = $val['DEPT'];
                        $res['LOGDATE'] = $val['LOGDATE'];
                        $res['COMMENTS'] = $val['COMMENTS'];
                        $res['DOCTOR'] = $val['DOCTOR'];
                        $res['DATE_BIRTH'] = $val['DATE_BIRTH'];
                        $res['panel'][] = $val['PANEL'];
                        $res['pname'][] = $val['MEDAN'];
                        $res['cont'][] = $val['CONTAINERNO'];
                        $res['cgroup'][] = $val['CONTGROUP'];
                        $res['due'][] = $val['DUE'];
                    }
                    $view = \View::make('pdfs.act')->with([
                        'id' => $id,
                        'act' => $res
                    ]);
                    $pdf->loadHTML("$view");
                    return $pdf->stream();
                    break;
                case 'save':
                    $folderno = htmlspecialchars($id);
                    if (isset($_GET["logo"])) $logo = "1"; else $logo = "0";
                    if (isset($_GET["signature"])) $signature = "1"; else $signature = '';
                    if (isset($_GET["seal"])) $seal = "1"; else $seal = "0";
                    if ($seal == "1") {
                        $params = array('domain' => 'https://192.168.0.17:1028/api/report.json',
                            'cookies' => 'cookies.txt',
                            'params' => array(
                                'api-key' => '5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                                'folderno' => $folderno,
                                'seal' => '1',
                                'client-id' => 11111
                            )
                        );

                    } else if ($signature == "1") {
                        $params = array('domain' => 'https://192.168.0.17:1028/api/report.json',
                            'cookies' => 'cookies.txt',
                            'params' => array(
                                'api-key' => '5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                                'folderno' => $folderno,
                                'signature' => '1',
                                'client-id' => \Session::get('clientcode')
                            )
                        );
                    } else {
                        $params = array('domain' => 'https://192.168.0.17:1028/api/report.json',
                            'cookies' => 'cookies.txt',
                            'params' => array(
                                'api-key' => '5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                                'folderno' => $folderno,
                                'client-id' => \Session::get('clientcode')
                            )
                        );

                    }
                    if (isset($_GET["seal"])) $params['params']['nacpp-seal'] = "1";

                    if (isset($_GET["logo"])) $params['params']['logo'] = "1";
                    $json = Func::getJsonMainList($params);
                    $obj = json_decode($json, true);
                    return \Response::make(base64_decode($obj["data"][0]["pdf"]), 200, [
                        'Pragma'=>'public',
                        'Expires'=> 0,
                        'Cache-Control'=> 'must-revalidate, post-check=0, pre-check=0,private=false',
                        'Content-type'=>'application/pdf',
                        'Content-Disposition'=> 'attachment; filename="report#'.$id.'.pdf"',
                        'Content-Transfer-Encoding'=> 'binary'
                    ]);
                    break;
                case 'print':
                        $folderno = htmlspecialchars($id);

                        $params = array('domain'=>'https://192.168.0.17:1028/api/report.json',
                            'cookies'=>'cookies.txt',
                            'params'=>array(
                                'api-key'=>'5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                                'folderno'=>$folderno,
                                'client-id'=>21611,
                                'block'=>1
                            )
                        );

                        //if (isset($_GET["seal"])) $params['params']['seal'] = "1";
                        //if (isset($_GET["signature"])) $params['params']['signature'] = "1";
                        if (isset($_GET["logo"])) $params['params']['logo'] = "1";
                        if (isset($_GET["a5"])) $params['params']['a5'] = "1";
                        if (isset($_GET["seal"])) $params['params']['nacpp-seal'] = "1";
                        $json = Func::getJsonMainList($params);
                        $obj = json_decode($json, true);

                    if(isset($obj["status"]) && ($obj["status"]=='fail')) {
                            if(isset($obj["error_code"])&&isset($obj["message"])) echo $obj["error_code"].": ".$obj["message"];
                        } else {
                        return \Response::make(base64_decode($obj["data"][0]["pdf"]), 200, [
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'inline; filename=report#' . $folderno .'.pdf"'
                        ]);
                        }
                    break;
                case 'massPrint':
                        $ids = explode(",", htmlspecialchars($id));
                        $params = array('domain'=>'https://192.168.0.17:1028/api/report.json',
                            'cookies'=>'cookies.txt',
                            'params'=>array(
                                'api-key'=>'5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                                'folders'=>'Array',
                                'client-id'=>11111
                            )
                        );
                        foreach ($ids as $k => $v) {
                            $params['params']["folders[$k]"] = $v;
                        }

                        if (isset($_GET["logo"])) $params['params']['logo'] = "1";
                        $json = Func::getJsonMainList($params);
                        $obj = json_decode($json, true);
                    return \Response::make(base64_decode($obj["data"][0]["pdf"]), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename=направление.pdf"'
                    ]);

                    break;
            }

        }
    }
}