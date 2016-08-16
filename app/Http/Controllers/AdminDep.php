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
        //
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
