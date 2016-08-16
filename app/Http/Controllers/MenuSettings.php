<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuSettings extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = $this->getMenu();
        $b = [];
        foreach($menu as $val){
            $a[$val['CAPTION']][$val['ROLENAME']] = $val['AVAILABLE'];
            if(!in_array($val['ROLENAME'],$b))
                $b[] = $val['ROLENAME'];
        }
        foreach($this->getMenuCategory() as $val)
            $cat[$val['ID']] = $val['MENU'];
        //dd($a);
        return \View::make('adminPanel.menu')->with([
            'menu' => $a,
            'b' => $b,
            'a' => $cat
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
        $name = trim($request->get('name'));
        $query = "insert into modules(menuid,caption) VALUES (".$request->get('cat').", '$name') returning id";
        $id = $this->getResult($this->queryDB($query));
        $query = "insert into modulerole(moduleid,roleid,available) VALUES (".$id[0]['ID'].",(select id from roles where rolename='".$request->get('role')."'), 'Y')";
        $this->queryDB($query);
        return \Redirect::route('page69.index');
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
    public function edit($id)
    {
        //dd($id);
        $request = explode('.',$id);
        switch($request[2]){
            case 'Y':
                $query = "update modulerole md set md.available='N' where md.roleid=(select r.id from roles r where r.rolename='".$request[0]."') and md.moduleid=(select m.id from modules m where m.caption='".$request[1]."')";
                $this->queryDB($query);
                break;
            case 'N':
                $query = "update modulerole md set md.available='Y' where md.roleid=(select r.id from roles r where r.rolename='".$request[0]."') and md.moduleid=(select m.id from modules m where m.caption='".$request[1]."')";
                $this->queryDB($query);
                break;
            case 'D':
                $query = "insert into modulerole(roleid,moduleid,available) values((select r.id from roles r where r.rolename='".$request[0]."'),(select m.id from modules m where m.caption='".$request[1]."'),'Y')";
                $this->queryDB($query);
                break;
        }
        return \Redirect::route('page69.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
