<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 25.03.2016
 * Time: 7:44
 */

namespace App\Http\Controllers;
use App\Http\Controllers\FuncController as Func;

class MailController extends DBController
{
    public function index($id)
    {
        $folderno   = $id;
        $c          = '';
        if(!(\Session::has('isAdmin') && \Session::get('isAdmin')==1)) {
            $res = $this->getDepts();
            //$res = ibase_fetch_row($stmt);
            if ($res === false) {
                echo "Error in executing query.<br/>";
                die(0);
            }
            $c = $res;
        } else {
            $c = $this->getDepts();
        }
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
            $from = \Input::get('from');
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

<<<<<<< HEAD
        if (\Input::has('seal')) $params['params']['seal'] = "1";
        //if (isset($_GET["signature"])) $params['params']['signature'] = "1";
        $params['params']['logo'] = "1";
        $json = Func::getJsonMainList($params);
        $obj = json_decode($json, true);
        $file = '';
        $query = "select mail_from, mail_password from departments where dept='$from'";
        $stmt = $this->getResult($this->queryDB($query));
        $mail_from = $_ENV['MAIL_USERNAME'].'@nacpp.ru';
        $mail_user = $_ENV['MAIL_USERNAME'];
        $mail_pass = $_ENV['MAIL_PASSWORD'];
        $host = $_ENV['MAIL_HOST'];
=======
        if (\Input::has('seal')) $params['params']['nacpp-seal'] = "1";
        //if (isset($_GET["signature"])) $params['params']['signature'] = "1";
        $params['params']['logo']   = "1";
        $json                       = Func::getJsonMainList($params);
        $obj                        = json_decode($json, true);
        $file                       = '';
        $query                      = "select mail_from, mail_password from departments where dept='$from'";
        $stmt                       = $this->getResult($this->queryDB($query));
        $mail_from                  = $_ENV['MAIL_USERNAME'].'@nacpp.ru';
        $mail_user                  = $_ENV['MAIL_USERNAME'];
        $mail_pass                  = $_ENV['MAIL_PASSWORD'];
        $host                       = $_ENV['MAIL_HOST'];
>>>>>>> origin/master
        if(isset($stmt[0]['MAIL_FROM'])){
            $mail_from = $stmt[0]['MAIL_FROM'];
            $mail_user = $stmt[0]['MAIL_FROM'];
            $mail_pass = $stmt[0]['MAIL_PASSWORD'];
            preg_match('/@([^.]*)/', $mail_from, $a);
            $mail = $a[1];
            switch($mail){
                case 'gmail':

                case 'yandex':
                    $host = 'ssl://smtp.yandex.ru';  // Specify main and backup SMTP servers
                    break;
                case 'rambler':
                    $host = 'ssl://smtp.rambler.ru';  // Specify main and backup SMTP servers
                    break;
                case 'med-det':
                    $host = 'ssl://smtp.yandex.ru';  // Specify main and backup SMTP servers
                    break;
                case 'eko-sodeistvie':
                    $host = 'ssl://smtp.timeweb.ru';  // Specify main and backup SMTP servers
                    break;
                default:
                    $host = 'ssl://smtp.mail.ru';  // Specify main and backup SMTP servers
                    break;
            }
        }
        config()->set('mail',[
            'driver' => 'smtp',
            'host' => $host,
            'port' => 25,
            'from' => array('address' => $mail_from, 'name' => $from),
            'encryption' => '',
            'username' => $mail_user,
            'password' => $mail_pass,
        ]);
<<<<<<< HEAD
	(new \Illuminate\Mail\MailServiceProvider(app()))->register();
=======

        (new \Illuminate\Mail\MailServiceProvider(app()))->register();
>>>>>>> origin/master

        if(isset($obj["status"]) && ($obj["status"]=='fail')) {
            if(isset($obj["error_code"])&&isset($obj["message"])) echo $obj["error_code"].": ".$obj["message"];
        } else {
            $file = base64_decode($obj["data"][0]["pdf"]);
        }
        //$r = Func::send_mail($from, $to, $theme, $body, $file, $id);
        $r = \Mail::raw($body,function($message) use ($id,$to, $mail_from, $from, $theme, $file){
            $message->to($to);
            $message->from($mail_from,$from);
            $message->subject($theme);
            $message->attachData($file,"$id.pdf");
        });

        if ($r==false) {
            echo "При отправке письма произошла ошибка!<br/><a href='".url("request/$id")."'>Вернуться назад</a>";
        } else {
            echo "Письмо было успешно отправлено!<br/><a href='".url("request/$id")."'>Вернуться назад</a>";
        }
    }
}