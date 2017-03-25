<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CourierController extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courier = $this->getCourier();
        $a = [];
        foreach($courier as $val){
            if(isset($a[$val['CONTGROUP']]))
                $a[$val['CONTGROUP']]++;
            else
                $a[$val['CONTGROUP']] = 1;
        }
        return view('courier',['a'=>$a]);
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
        if($request->has('send')) {
            $this->queryDB("insert into logs(log_time,theme, description) VALUES (CURRENT_TIMESTAMP ,'Передача курьеру','LPU-" . \Session::get('clientcode') . "')");
            $this->queryDB("update folders set apprsts='P' where apprsts in ('K','D') and clientid=".\Session::get('dept'));
            return redirect(route('page73.index'));
        }
        $pdf = \App::make('dompdf.wrapper');
        $courier = $this->getCourier();
        $a = [];
        foreach($courier as $val){
            if(isset($a[$val['CONTGROUP']]))
                $a[$val['CONTGROUP']]++;
            else
                $a[$val['CONTGROUP']] = 1;
        }
        $view = \View::make('pdfs.courier')->with([
            'courier' => $a
        ]);
        $pdf->loadHTML("$view");
        return $pdf->stream();
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
        //
    }
}
