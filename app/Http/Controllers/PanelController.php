<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class PanelController extends DBController
{

    public function index()
    {
        return View::make('Prices')->with([
            'prices'=>$this->getPrices(),
            'depts'=>$this->getDepts()
        ]);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        if(Input::has('code')){
            $id = $this->getResult($this->queryDB("select id from pricelists where status='A' and dept=".Input::get('dept')));
            $this->queryDB("update prices p set p.medan='".Input::get('panel')."', p.cost=".Input::get('cost')." where p.pricelistid=".$id[0]['ID']." and p.panel='".Input::get('code')."'");
        }
        if(Input::hasFile('excel')){
            $excel = [];
            $e = Excel::load(Input::file('excel'), function($reader) use ($excel) {});
            $objExcel = $e->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++)
            {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $excel = $rowData[0];
                if(!empty($excel[0])) {
                    $query = "update prices p set p.medan='" . $excel[1] . "', p.cost=" . $excel[2] . " where p.pricelistid=(select pr.id from pricelists pr where pr.status='A' and pr.dept=" . Input::get('price') . ") and p.panel='" . $excel[0] . "'";
                    //dd($query);
                    $this->queryDB($query);
                }
            }
        }
        return View::make('Prices')->with([
            'prices'=>$this->getPrices(),
            'depts'=>$this->getDepts()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dept)
    {
        $panel = $this->getPanel2($dept);
        //dd($panel);
        return view('panelShow',[
            'panel'=>$panel
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
