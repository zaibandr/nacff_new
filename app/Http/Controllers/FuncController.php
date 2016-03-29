<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 25.01.2016
 * Time: 8:20
 */

namespace App\Http\Controllers;


class FuncController extends Controller
{
    static function m_quotes($data){

            //$data = str_replace("'", "", $data);
            //$data = str_replace("\"", "", $data);

            $data = str_replace("\\'","'",$data);
            $data = str_replace("'","",$data);
            $data = str_replace("\"","",$data);
            $data = str_replace("\\\\","",$data);
            $data = str_replace("\\","",$data);


            //if (!get_magic_quotes_gpc()) {
            //	$data = addslashes($data);
            //}
            return trim($data);
    }
    static function send_mail($from, $to, $thm, $html, $fp, $folderno) {
        //echo "<!-- ".$path." -->";
        //$fp = getCurlData($path);
        $boundary = "--".md5(uniqid(time())); // генерируем разделитель
        $headers = "MIME-Version: 1.0\n";
        $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
        $multipart = "--$boundary\n";
        $kod = 'UTF-8';
        $multipart .= "Content-Type: text/plain; charset=$kod\n";
        $headers .= "From: ".$from."\n";
        $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";

        $multipart .= "$html\n\n";

        $message_part = "--$boundary\n";
        $message_part .= "Content-Type: application/octet-stream\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        $message_part .= "Content-Disposition: attachment; filename = \"report".$folderno.".pdf\"\n\n";
        $message_part .= chunk_split(base64_encode($fp))."\n";
        $multipart .= $message_part."--$boundary--\n";

        if(!mail($to, $thm, $multipart, $headers)) {
            echo "К сожалению, письмо не отправлено";
            return false;
            exit();
        }
        return true;
    }
    static function getBrowser() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/MSIE/i',$agent) && !preg_match('/Opera/i',$agent)) { $browser = 'Internet Explorer'; }
        elseif(preg_match('/Firefox/i',$agent)) { $browser = 'Mozilla Firefox'; }
        elseif(preg_match('/Chrome/i',$agent)) { $browser = 'Google Chrome'; }
        elseif(preg_match('/Safari/i',$agent)) { $browser = 'Apple Safari'; }
        elseif(preg_match('/Opera/i',$agent)) { $browser = 'Opera'; }
        elseif(preg_match('/Opera Mini/i',$agent)) { $browser = 'Opera Mini'; }
        elseif(preg_match('/Netscape/i',$agent)) { $browser = 'Netscape'; }
        else { $browser = 'Неизвестно'; }
        return $browser;
    }

    public static function age($time)
    {
        $date = date('Y') - date('Y',strtotime($time));
        return $date;
    }
    public static function getJsonMainList($params) {
        $ch = curl_init(); $paramstr = "?";
        foreach ($params as $value)
            if (is_array($value))
                foreach ($value as $key=>$val) {
                    if (is_array($val)) {
                        foreach($val as $k=>$v) {
                            if ($paramstr=="?")
                                $paramstr .= $key."[".$k."]=".$v;
                            else
                                $paramstr .= "&".$key."[".$k."]=".$v;
                        }
                    }
                    if ($paramstr=="?")
                        $paramstr .= $key."=".$val;
                    else
                        $paramstr .= "&".$key."=".$val;
                }
        curl_setopt($ch, CURLOPT_URL, $params["domain"].$paramstr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, '');
        curl_setopt($ch, CURLOPT_REFERER, $params["domain"]);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $params["cookies"]);
        curl_setopt($ch, CURLOPT_COOKIEJAR,  $params["cookies"]);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        $html = curl_exec($ch);
        return $html;

    }
}