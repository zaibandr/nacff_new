<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends DBController
{

    public function index()
    {
        //
    }

    public function show($id)
    {
        $folder = $this->getDraft($id);
        $ordtask = $this->getOrdtask($id);
        $a=[];
        foreach($ordtask as $ord){
            $a[$ord['CODE']]['PANEL'] = $ord['PANEL'];
            $a[$ord['CODE']]['APPRSTS'] = $ord['APPRSTS'];
            $a[$ord['CODE']]['STATUSCOLOR'] = $ord['STATUSCOLOR'];
            $a[$ord['CODE']]['STATUSNAME'] = $ord['STATUSNAME'];
            $a[$ord['CODE']]['FINALRESULT'][] = $ord['FINALRESULT'];
            $a[$ord['CODE']]['CHARLIMITS'][] = $ord['CHARLIMITS'];
            $a[$ord['CODE']]['UNIT'][] = $ord['UNIT'];
            $a[$ord['CODE']]['STATUS'][] = $ord['STATUS'];
            $a[$ord['CODE']]['ANALYTE'][] = $ord['ANALYTE'];

        }
        return \View::make('request')->with([
            'folder'=>$folder,
            'ordtask'=>$a,
            'id'=>$id
        ]);
    }

}
