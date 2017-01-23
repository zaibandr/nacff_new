<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\DBController;

class LPU extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lpu = [];
        //dd($this->getLPU());
        foreach($this->getLPU() as $val){
            $lpu[$val['USERNAM']]['pass'] = $val['PASS'];
            if($val['ROLEID']==7) {
                $lpu[$val['USERNAM']]['role']['Гл.врач'][] = ['dept'=>$val['DEPT'], 'number'=>$val['DEPTCODE']];
            }
            elseif($val['ROLEID']==15){
                $lpu[$val['USERNAM']]['role']['Медсестра'][] = ['dept'=>$val['DEPT'], 'number'=>$val['DEPTCODE']];
            }
            else {
                $lpu[$val['USERNAM']]['role']['Админ'][] = ['dept'=>$val['DEPT'], 'number'=>$val['DEPTCODE']];
            }
        }
        //dd($lpu);
        return \View::make('adminPanel.LPU')->with([
            'lp' => $lpu
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \View::make('adminPanel.newUser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        if(isset($request->lims)){
            $db = ibase_connect("192.168.0.8:lims","sysdba","cdrecord");
            $query = "select a.usernam, a.passtext from n_users inner join clients c on c.id=a.clientid where c.clientcode = ";
        }
        $login = trim(mb_strtoupper($request->login));
        $password = trim($request->password);
        $this->queryDB("insert into users(usernam,fullname,password2) VALUES ('$login', '$request->name','".crypt($password,'$1$nacffnew')."')");
        $this->queryDB("insert into userroles(usernam,roleid) values('$login',$request->role)");
        $this->queryDB("insert into userpass(usernam,pass) VALUES ('$login','$password')");
        foreach($request->all() as $key=>$val){
            if(strpos($key,'dept') || strpos($key,'dept')===0){
                $this->queryDB("insert into userdept(dept,usernam) VALUES ((select id from departments d where d.dept='$val'), '$login')");
            }
        }
        $this->queryDB("insert into logs(log_time,theme,description) VALUES (CURRENT_TIMESTAMP ,'Новый пользователь','login-$login,role-$request->role')");
        return redirect()->action('LPU@index');
    }

    public function update(Request $request, $id)
    {
         $a = []; $c = [];
        foreach($request->all() as $key=>$val){
            if(strpos($key,'dept') || strpos($key,'dept')===0){
                if(!in_array($val, $a))
                    $a[] = $val;
            }
        }
        //dd($a);
        $password = trim($request->password);
        $this->queryDB("update users set password2='".crypt($password,'$1$nacffnew')."' where usernam='$request->name'");
        $this->queryDB("update userpass set pass='$password' where usernam='$request->name'");
        $query = "select d.dept from departments d inner join userdept ud on d.id=ud.dept where ud.usernam='$request->name'";
        $b = $this->getResult($this->queryDB($query));
        if(!empty($b)) {
        foreach($b as $val){
            $c[] = $val['DEPT'];
        }
        if(!empty(array_diff($c,$a))){
            foreach(array_diff($c,$a) as $val)
                $this->queryDB("delete from userdept ud where ud.usernam='$request->name' and ud.dept=(select d.id from departments d where d.dept='$val')");
        }
        if(!empty(array_diff($a,$c))){
            foreach(array_diff($a,$c) as $val)
                $this->queryDB("insert into userdept(dept,usernam) VALUES ((select d.id from departments d where d.dept='$val'), '$request->name')");
        }
     } else {
            foreach ($a as $val) {
                $this->queryDB("insert into userdept(dept,usernam) VALUES ((select d.id from departments d where d.dept='$val'), '$request->name')");
            }
        }
        $role = ($request->role=='M')?7:15;
        $this->queryDB("update userroles set roleid=$role where usernam = '$request->name'");
        return redirect()->action('LPU@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->queryDB("delete from userdept where usernam='$id'");
        $this->queryDB("delete from userroles where usernam='$id'");
        $this->queryDB("delete from users where usernam='$id'");
        return Redirect('page66');
    }
}
