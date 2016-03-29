<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 25.03.2016
 * Time: 7:44
 */

namespace App\Http\Controllers;
use App\Http\Controllers\DBController;
use App\Http\Controllers\FuncController as Func;

class MailController extends DBController
{
    public function index($id)
    {
        $folderno = $id;
        $dept = \Session::get('dept');
        $tsql = "select dept from departments d WHERE d.id = $dept";
        $stmt = $this->queryDB($tsql);
        $res = ibase_fetch_row($stmt);
        if( $res === false ) {
            echo "Error in executing query.<br/>"; die(0);
        }
        $c = $res[0];
        $query = "select p.surname, p.name, p.patronymic, p.date_birth from patient p inner join folders f on f.pid=p.pid where f.folderno='$folderno'";
        $stmt = $this->getResult($this->queryDB($query));
        if( $stmt===false) {
            echo "Error in executing query.<br/>"; die(0);
        }
        return \View::make('mail')->with([
            'row'=>$stmt,
            'c'=>$c,
            'folderno'=>$folderno
        ]);
    }
    public function indexPost($id){
        if(\Input::has('from'))
            $from = str_replace("\"", "'", \Input::get('from'));
        if(\Input::has('to'))
            $to = htmlspecialchars(\Input::get('to'));
        if(\Input::has('theme'))
            $theme = str_replace("\"", "'", \Input::get('theme'));
        if(\Input::has('body'))
            $body = str_replace("\"", "'", \Input::get('body'));

        $params = array('domain'=>'https://192.168.0.17:1028/api/report.json',
            'cookies'=>'cookies.txt',
            'params'=>array(
                'api-key'=>'5b2e6d61-1bea-4c8f-811e-b95a946a7e46',
                'folderno'=>$id,
                'client-id'=>\Session::get('clientcode')
            )
        );

        //if (isset($_GET["seal"])) $params['params']['seal'] = "1";
        //if (isset($_GET["signature"])) $params['params']['signature'] = "1";
        $params['params']['logo'] = "1";
        $json = Func::getJsonMainList($params);
        $obj = json_decode($json, true);
        $file = '';
        if(isset($obj["status"]) && ($obj["status"]=='fail')) {
            if(isset($obj["error_code"])&&isset($obj["message"])) echo $obj["error_code"].": ".$obj["message"];
        } else {
            $file .= 'Content-Disposition: filename=report#' . $id . ".pdf \n";
            $file .= 'Content-Type: application/pdf';
            $file .= base64_decode($obj["data"][0]["pdf"]);
        }
        $r = Func::send_mail($from, $to, $theme, $body, $file, $id);

        if ($r==false) {
            echo "При отправке письма произошла ошибка!<br/><a href='".url("request/$id")."'>Вернуться назад</a>";
        } else {
            echo "Письмо было успешно отправлено!<br/><a href='".url("request/$id")."'>Вернуться назад</a>";
        }
    }
}