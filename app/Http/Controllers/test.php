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
                if (!empty($excel[0])) {
                    $panel = trim(str_replace(",", ".", $excel[0]));
                    if(!empty($excel[4]))
                        \Session::put('prean',$excel[4]);
                    else
                        \Session::put('prean','Дополнительное исследование или уже не используется');
                    $query = "select id from preanalytics where description='" . trim(\Session::get('prean')) . "'";
                    $id = $this->getResult($this->queryDB($query));
                    if (empty($id)) {
                        $query = "insert into preanalytics(description) VALUES ('" . trim(\Session::get('prean')) . "') returning id";
                        $id = $this->getResult($this->queryDB($query));
                    }
                    $query = "select id from samplingrules where samplingrule='MICRO'";
                    $Sid = $this->getResult($this->queryDB($query));
                    if (empty($Sid)) {
                        $query = "insert into samplingrules(samplingrule) VALUES ('MICRO') returning id";
                        $Sid = $this->getResult($this->queryDB($query));
                    }
                    $query = "update panel_containers set preanalitic_id=" . $id[0]['ID'] . ",samplingsrules_id=".$Sid[0]['ID']." where panel='$panel'";
                    $res2 = $this->queryDB($query);
                    $a[$id[0]['ID']] = trim(\Session::get('prean'));
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
        if(Input::hasFile('preanPlusRules')){
/*            $e = Excel::load(Input::file('preanPlusRules'), function($reader) use ($excel) {
                $reader->each(function($sheet){
                    $sheet->each(function($row){
                        dd($row->get());
                    });
                });
            });*/
            Excel::selectSheetsByIndex(9)->load(Input::file('preanPlusRules')
                , function($sheet) {
                    $sheet->each(function($row){
                        $columns = $row->all();
                        //dd($columns);
                        if(isset($columns['kod_paneli'])) {
                            if (isset($columns['otobrazhaemoe_opisanie_preanalitiki']))
                                \Session::put('prean', trim($columns['otobrazhaemoe_opisanie_preanalitiki']));

                                \Session::put('zab', 'Мазок');
                            //dd($columns);

                            $panels = explode('-', $columns['kod_paneli']);
                            if (isset($panels[1])) {
                                $query = "select code from panels where code>='" . trim($panels[0]) . "' and code<='" . trim($panels[1]) . "'";
                                $panel = $this->getResult($this->queryDB($query));
                            } else
                                $panel = $panels;
                            foreach ($panel as $val) {
                                if (is_array($val))
                                    $val = trim(str_replace(',', '.', $val['CODE']));
                                $val = trim(str_replace(',', '.', $val));
                                while (strlen($val) < 6)
                                    $val .= '0';
                                $query = "select id from preanalytics where description='" . trim(\Session::get('prean')) . "'";
                                $id = $this->getResult($this->queryDB($query));
                                if (empty($id)) {
                                    $query = "insert into preanalytics(description) VALUES ('" . trim(\Session::get('prean')) . "') returning id";
                                    $id = $this->getResult($this->queryDB($query));
                                }
                                $query = "select id from samplingrules where samplingrule='KDL-" . trim(\Session::get('zab')) . "'";
                                $Sid = $this->getResult($this->queryDB($query));
                                if (empty($Sid)) {
                                    $query = "insert into samplingrules(samplingrule) VALUES ('KDL-" . trim(\Session::get('zab')) . "') returning id";
                                    $Sid = $this->getResult($this->queryDB($query));
                                }
                                $query = "update panel_containers set preanalitic_id=" . $id[0]['ID'] . ",samplingsrules_id=" . $Sid[0]['ID'] . " where panel='$val'";
                                $res2 = $this->queryDB($query);
                            }
                        }
                    });
                });
        }
        return \View::make('test')->with([

        ]);
    }
}
