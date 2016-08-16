<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15.07.2016
 * Time: 8:41
 */

namespace App\Http\Controllers;


class PR extends DBController
{
    public function index()
    {
        $panels = $this->getPR();
        foreach($panels as $val){
            $a[$val['CODE']]['panel'] = $val['PANEL'];
            $a[$val['CODE']]['mattype'][] = $val['MATTYPE'];
            $a[$val['CODE']]['cont'][] = $val['CONTGROUP'];
            $a[$val['CODE']]['prean'] = $val['PREANALITIC_ID'];
            $a[$val['CODE']]['samp'] = $val['SAMPLINGRULE'];
        }
        if(\Input::has('name')){
            dd(\Input::all());
            $desc = trim(\Input::get('desc'));
            $code = \Input::get('code');
            $query = "select id from preanalytics where description='$desc'";
            $id = $this->getResult($this->queryDB($query));
            if(empty($id)){
                $query = "insert into preanalytics(description) VALUES ('$desc') returning id";
                $id = $this->getResult($this->queryDB($query));
            }
            $query = "update panel_containers set preanalitic_id=" . $id[0]['ID'] . " where panel='$code'";
            $this->queryDB($query);
        }
        return \View::make('adminPanel.pr')->with([
            'panels'=>$a
        ]);
    }
}