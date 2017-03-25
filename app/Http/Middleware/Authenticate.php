<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\DBController as DB;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has('userCheck') && \Session::get('userCheck')==1) {
            return $next($request);
        }
        $login = trim(strtoupper($request->get('login')));
        $password = trim($request->get('password'));
        if (empty($request->all()) || !$this->basic_validate($login, $password)) {
            return redirect('/');
        }
        return $next($request);
    }
    private function basic_validate($login, $password)
    {
        $con = new DB();
        $password = crypt($password,'$1$nacffnew');
        $a = $con->getUser($login, $password);
        if($a[0]['PASSWORD2']===false){
            return false;
        } else {
            \Session::put('userCheck',1);
            \Session::put('login',$a[0]['USERNAM']);
            \Session::put('name',$a[0]['FULLNAME']);
            \Session::put('clientcode',$a[0]['DEPTCODE']);
            \Session::put('dept',$a[0]['ID']);
            \Session::put('email',$a[0]['EMAIL_SENDER']);
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
                $a[$row[0]][] = $row[1];
            }
            \Session::put('menu',$a);
            return true;
        }
    }
}
