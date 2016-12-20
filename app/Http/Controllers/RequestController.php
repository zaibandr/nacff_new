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
            if(!$ord['STATUS']=='O' || !strpos($ord['TESTNAME'],'HIV')) {
                $a[$ord['CODE']]['TESTNAME'][$ord['TESTNAME']]['FINALRESULT'][] = $ord['FINALRESULT'];
                $a[$ord['CODE']]['TESTNAME'][$ord['TESTNAME']]['CHARLIMITS'][] = $ord['CHARLIMITS'];
                $a[$ord['CODE']]['TESTNAME'][$ord['TESTNAME']]['UNIT'][] = $ord['UNIT'];
                $a[$ord['CODE']]['TESTNAME'][$ord['TESTNAME']]['STATUS'][] = $ord['STATUS'];
                $a[$ord['CODE']]['TESTNAME'][$ord['TESTNAME']]['ANALYTE'][] = $ord['ANALYTE'];
            }
        }
        return \View::make('request')->with([
            'folder'=>$folder,
            'ordtask'=>$a,
            'id'=>$id
        ]);
    }

}
