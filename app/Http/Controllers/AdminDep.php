<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminDep extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('adminPanel.dep')->with([
            'depts' => $this->getDeptsAdmin()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $price = $this->getDeptPrice();
        $nets = $this->getNets();
        return \View::make('adminPanel.newDept')->with([
            'prices'=>$price,
            'nets' => $nets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(\Input::all());
        $lpu = (int)trim($request->lpu);
        $name = mb_strtoupper(trim($request->name));
        $desc = addslashes(trim($request->desc));
        $priceId = $request->price;
        $netId = isset($request->net)?$request->net:'null';
        $query = "insert into departments(deptcode,dept,description,status,net_id) VALUES ('$lpu','$name','$desc','A', $netId) returning id";
        $deptId = $this->getResult($this->queryDB($query));
        $deptId = $deptId[0]['ID'];
        if(isset($request->dateend))
            $dateend = date('Y-m-d',strtotime($request->dateend));
        else $dateend = date('Y-m-d',strtotime(time()+3600*24*365));
        if(isset($request->datestart))
            $datestart = date('Y-m-d',strtotime($request->datestart));
        else $datestart = date('Y-m-d');
        $query = "insert into pricelists(status,datebegin,dateend,by_user,dept) VALUES ('A','$datestart','$dateend','ADMIN',$deptId) returning id";
        $newPriceId = $this->getResult($this->queryDB($query));
        $newPriceId = $newPriceId[0]['ID'];
        $query = "INSERT INTO PRICES (PRICELISTID, COST, PANEL, COMMENTS, NACPH, MARGA, DUE, CONTTYPES, PCAT, PGRP, MEDAN) ";
        $query.= "select $newPriceId,COST, PANEL, COMMENTS, NACPH, MARGA, DUE, CONTTYPES, PCAT, PGRP, MEDAN from prices where PRICELISTID=$priceId";
        if($this->queryDB($query))
            return \Redirect::route('page68.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \View::make('adminPanel.pricelist')->with([
            'price' => $this->getPriceAdmin($id),
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Input::has('del')){
            $query = "delete from prices where panel='".\Input::get('del')."' and pricelistid = (select id from pricelists where dept=$id)";
            $this->queryDB($query);
        }
        if(\Input::has('code')){
            $due = (int)\Input::get('due',1);
            $name = trim(\Input::get('panel'));
            $query = "update prices set cost=".\Input::get('cost').", nacph=".\Input::get('costn');
            $query.= ", medan = '$name', due = $due";
            $query.= " where panel='".\Input::get('code')."' and ";
            $query.= "pricelistid = (select id from pricelists where dept=$id)";
            //dd($query);
            $this->queryDB($query);
        }
        return \Redirect::route('page68.show', [$id]);
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
