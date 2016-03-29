<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\View;

class UserController extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->getUsers();
        $a = [];
        $b = [];
        foreach($users as $val) {
            if(!in_array($val['DEPT'],$a)){
                $a[] = $val['DEPT'];
            }
        }
        foreach($users as $val) {
            if(!isset($b['USERNAM'])) {
                $b[$val['USERNAM']]['name'] = $val['FULLNAME'];
                $b[$val['USERNAM']]['password'] = $val['PASSWORD3'];
            }
            foreach($a as $v) {
                if (!isset($b[$val['USERNAM']][$v]) || $b[$val['USERNAM']][$v]!==1) {
                    if ($v == $val['DEPT'])
                        $b[$val['USERNAM']][$v] = 1;
                    else
                        $b[$val['USERNAM']][$v] = 0;
                }
            }
            $b[$val['USERNAM']]['status'] = $val['STATUS'];
            if($val['ROLEID']==7)
                $b[$val['USERNAM']]['show'] = 0;
        }

        return View::make('users')->with([
            'a' => $a,
            'b' => $b,
            'depts' => $this->getDepts()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $login = trim(mb_strtoupper($request->get('login'),'UTF-8'));
        $name = trim($request->get('name'));
        $password = md5(trim($request->get('password')));
        $password2 = (trim($request->get('password')));
        $this->queryDB("insert into users(usernam, fullname, password2, password3) VALUES ('".$login."','".$name."', '".$password."', '".$password2."')");
        $this->queryDB("insert into userroles(usernam, roleid) VALUES ('".$login."', 15)");
        foreach($request->all() as $k=>$v){
            if(isset($key) and $key=='password'){
                $this->queryDB("insert into userdept(usernam, dept) VALUES ('".$login."', $k)");
            }
            $key = $k;
        }
        return Redirect('page6');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $this->queryDB("update users set status='".$request->get('status')."' where usernam='$id'");
        return Redirect('page6');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $login = trim(mb_strtoupper($request->get('login'),'UTF-8'));
        $name = trim($request->get('name'));
        $password = md5(trim($request->get('password')));
        $password2 = (trim($request->get('password')));
        $this->queryDB("update users set fullname='$name', password2='$password', password3='$password2' where usernam='$login'");
        $this->queryDB("delete from userdept where usernam='$login'");
        foreach($request->all() as $k=>$v){
            if(isset($key) and $key=='password'){
                $this->queryDB("insert into userdept(usernam, dept) VALUES ('".$login."', $k)");
            } else {
                $key = $k;
            }
        }
        return Redirect('page6');
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
        return Redirect('page6');
    }
}
