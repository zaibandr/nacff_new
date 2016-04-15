<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 12.01.2016
 * Time: 9:00
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;
use App\Http\Controllers\DBController as DB;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    function check(){
        $username = trim(strtoupper(Input::get('login')));
        $password = md5(Input::get('password'));
        $con = new DB;
        $a = $con->getUser($username, $password);
        //dd($a);
        if(count($a)==0){
            $error = 'Ошибка авторизации';
            return \View::make('auth')->with([
               'error'=>$error
            ]);
/*        } elseif(!captcha_check(Input::get('captcha'))){
            $error = 'Введите код с картинки корректно';
            return \View::make('auth')->with([
                'error'=>$error
            ]);*/
        } else {
            \Session::put('userCheck',1);
            \Session::put('login',$a[0]['USERNAM']);
            \Session::put('name',$a[0]['FULLNAME']);
            \Session::put('clientcode',$a[0]['DEPTCODE']);
            \Session::put('dept',$a[0]['ID']);
            if($a[0]['ROLEID']==7)
                \Session::put('isAdmin',1);
            $query = "SELECT DISTINCT mc.MENU, m.id, m.CAPTION FROM MENUCATEGORY mc ";
            $query.= "inner join MODULES m on mc.ID=m.MENUID ";
            $query.= "inner join MODULEROLE mr on mr.MODULEID=m.ID ";
            $query.= "inner join ROLES r on r.ID=mr.ROLEID ";
            $query.= "inner join USERROLES u on r.ID=u.ROLEID ";
            $query.= "where mr.available='Y' and u.USERNAM='".$a[0]['USERNAM']."' order by mc.sorter";
            $res =$con->queryDB($query);
            $a = [];
            while($row=ibase_fetch_row($res)){
                $a[$row[0]][$row[2]] = $row[1];
            }
            \Session::put('menu',$a);
            return \Redirect::route('main');
        }
    }
}