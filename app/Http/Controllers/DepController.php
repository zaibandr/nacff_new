<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\DBController;

class DepController extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        foreach($this->getDeptPrice() as $val)
            $a[$val['ID']]=$val['DEPT'];
        return View::make('departments')->with([
            'a' => $a,
            'depts' => $this->getDepts()

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
        $name = trim($request->get('name'));
        $desc = trim($request->get('desc'));
        $price = $request->get('price');
        $stmt = $this->queryDB("insert into departments(deptcode, dept, description) VALUES ('".\Session::get('clientcode')."', '".$name."', '".$desc."') returning id");
        $res = $this->getResult($stmt);
        $deprID = $res[0]['ID'];
        $stmt = $this->queryDB("insert into pricelists(apprdate, status, by_user, datebegin, dept) VALUES ('".date('Y-m-d')."', 'A', '".\Session::get('login')."', '".date('Y-m-d', strtotime('+1 days'))."',". $deprID.") returning id");
        $res = $this->getResult($stmt);
        $priceID = $res[0]['ID'];
        $this->queryDB("insert into prices(medan, pricelistid, cost, panel, comments, nacph, marga, due, conttypes, pcat, pgrp) SELECT medan, ".$priceID.", a.COST, a.PANEL, a.COMMENTS, a.NACPH, a.MARGA, a.DUE, a.CONTTYPES, a.PCAT, a.PGRP FROM PRICES a where a.PRICELISTID = ".$price);
        return Redirect('page20');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $res = $this->getResult($this->queryDB("delete from pricelists where dept=".$id." returning id"));
        $this->queryDB("delete from departments where id=".$id);
        $this->queryDB("delete from prices where pricelistid=".$res[0]['ID']);

            return Redirect('page20');
    }
}
