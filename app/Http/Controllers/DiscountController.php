<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\Input;

class DiscountController extends DBController
{

    public function index()
    {
        $rules = $this->getRulesTwo(Input::get('dept',''));
        return View::make('discount')->with([
            'depts'=> $this->getDepts(),
            'rules'=> $rules
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $name = trim($request->get('name'));
        $rep = (int)$request->get('per');
        if($request->has('type'))
            switch ($request->get('type')){
                case 1:
                    $sql ="privilege == \"".$request->get('name')."\"";
                    //dd($sql);
                    break;
                case 2:
                    $sql ="day.getDay() == ".$request->get('xxx');
                    break;
            }
        $this->queryDB("insert into rules(rulename, loguser, sql, per, deptid) VALUES ('".$name."','".\Session::get('login')."', '".$sql."', ".$rep.", ".$request->get('dept').")");
        $rules = $this->getRulesTwo($request->get('dept',''));

        return Redirect('page47');
    }


    public function show($id)
    {
        //
    }


    public function edit($id, Request $request)
    {
        $this->queryDB("update rules set status='".$request->get('status')."' where id=$id");
        return Redirect('page47');
    }


    public function update(Request $request, $id)
    {
        $name = trim($request->get('name'));
        $rep = (int)$request->get('per');
        switch ($request->get('type')){
            case 1:
                $sql ="privilege == \"".$request->get('name')."\"";
                //dd($sql);
                break;
            case 2:
                $sql ="day.getDay() == ".$request->get('xxx');
                break;
        }
        $this->queryDB("update rules set rulename='".$name."', per=".$rep.", sql ='$sql', deptid=".$request->get('dept')." where id=$id");
        //dd("update rules set rulename='".$name."', per=".$rep.", sql ='$sql', deptid=".$request->get('dept')." where id=$id");
        return Redirect('page47');
    }


    public function destroy($id)
    {
        $this->queryDB("delete from rules where id=$id");
        return Redirect('page47');
    }
}
