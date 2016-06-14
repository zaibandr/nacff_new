<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 11.01.2016
 * Time: 11:43
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\DBController;

class Test extends DBController
{
    public function index(){
        if(Input::hasFile('excel')){
            $excel = [];
            $e = Excel::load(Input::file('excel'), function($reader) use ($excel) {});
            $objExcel = $e->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $a = [];
            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++)
            {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $excel = $rowData[0];
                if (!empty($excel[4]) && !empty($excel[0])) {
                    $panel = trim(str_replace(",",".",$excel[0]));
                    if(!in_array(trim($excel[4]),$a)) {
                        $query = "insert into preanalytics(description) VALUES ('".trim($excel[4])."') returning id";
                        $res = $this->getResult($this->queryDB($query));
                        //dd($res);
                        $query = "update panel_containers set preanalitic_id=" . $res[0]['ID'] . " where panel='$panel'";
                        $res2 = $this->queryDB($query);
                        $a[$res[0]['ID']] = trim($excel[4]);
                    } else {
                        $b = array_search(trim($excel[4]),$a);
                        //dd($a,$b);
                        $query = "update panel_containers set preanalitic_id=" .$b . " where panel='$panel'";
                        $res2 = $this->queryDB($query);
                    }

                }
            }
        }
        if(Input::hasFile('img')){
            $img = [];
            $e = Excel::load(Input::file('img'), function($reader) use ($img) {});
            $objExcel = $e->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $a = [];
            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++)
            {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $img = $rowData[0];
                if (!empty($img[0])) {
                    $panel = trim(str_replace(",",".",$img[0]));
                    while(strlen($panel)!==6){
                        $panel.="0";
                    }
                    //dd($panel);
                    $query = "update panels set img='".trim($img[1])."' where code = '$panel'";
                    $this->queryDB($query);
                }
            }
        }
        return \View::make('test')->with([

        ]);
    }
}
