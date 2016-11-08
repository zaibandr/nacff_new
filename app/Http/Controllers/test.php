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
/*        if(Input::hasFile('excel')){
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
                if (!empty($excel[0])) {
                    //dd($rowData);
                    $panel = trim(str_replace(",", ".", $excel[0]));
                    if(!empty($excel[4]))
                        $prean = trim($excel[4]);

                    $query = "select id from preanalytics where description='$prean'";
                    $id = $this->getResult($this->queryDB($query));
                    if (empty($id)) {
                        $query = "insert into preanalytics(description) VALUES ('$prean') returning id";
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
*/
       /*if(Input::hasFile('preanPlusRules')){
            $lims = ibase_connect('192.168.0.8:lims','sysdba','cdrecord');
           $a = '';
            $query = "select p.CODE,pc.ID, pc.CONTAINERTYPE_ID, pc.MATTYPE_ID, pc.CONTAINERNO from PANELS p inner join PANEL_CONTAINERS pc on pc.PANEL_ID=p.ID where p.status='A' and p.code='49.132'";
            $stmt = ibase_query($lims,$query); $panel = '';
            while($row = ibase_fetch_assoc($stmt)){
                if($panel!=$row['CODE']) {
                    $panel = $row['CODE'];
                    //$query = "delete from panel_containers where panel='$panel'";
                    //$this->queryDB($query);
                }
                $query = "select code from panels where code='$panel'";
                $res = $this->getResult($this->queryDB($query));
                if(!isset($res[0]['CODE'])){
                    $a.= ",".$panel;
                    $query = "select p.panelcatid, p.due2, p.mat_types, p.img_src, p.panel, p.id from panels p where p.code='$panel'";
                    $stmt2 = ibase_query($lims,$query);
                    while($row2 = ibase_fetch_assoc($stmt2)){
                        $this->queryDB("insert into panels(mats,img,panel,code,modify_time) VALUES ('".$row2['MAT_TYPES']."','".$row2['IMG_SRC']."','".$row2['PANEL']."','$panel', current_timestamp)");
                        $this->queryDB("insert into prices(pricelistid, panel, pgrp) VALUES (49,'$panel',".$row2['PANELCATID'].")");
                        $stmt3 = ibase_query($lims,"select pc.id,pc.mattype_id,pc.containertype_id,pc.containerno,t.test_id from panel_containers pc inner join panel_tests t on t.container_id=pc.id where pc.panel_id='".$row['ID']."'");
                        while($row3 = ibase_fetch_assoc($stmt3)){
                            $this->queryDB("insert into panel_containers(id,MATTYPE_ID, CONTGROUPID, PANEL, CONTAINERNO) VALUES (" . $row3['ID'] . "," . $row3['MATTYPE_ID'] . "," . $row3['CONTAINERTYPE_ID'] . ",'" . $row['CODE'] . "'," . $row3['CONTAINERNO'] . ")");
                            $this->queryDB("insert into panel_tests(testcode, containerid) values(".$row3['TEST_ID'].",".$row3['ID'].")");
                        }
                    }
                }
                else {
                    //$query = "insert into panel_containers(ID, MATTYPE_ID, CONTGROUPID, PANEL, CONTAINERNO) values (" . $row['ID'] . "," . $row['MATTYPE_ID'] . "," . $row['CONTAINERTYPE_ID'] . ",'" . $row['CODE'] . "'," . $row['CONTAINERNO'] . ")";
                    //$this->queryDB($query);
                }
            }
            //Excel::selectSheetsByIndex(0)->load(Input::file('preanPlusRules')
            //    , function($sheet) {
            //        $sheet->each(function($row){
            //            $columns = $row->all();
            //            $prean = ($columns['prean']!='[null]')?$columns['prean']:260;
            //            $samp = ($columns['samp']!='[null]')?$columns['samp']:28;
            //            $query = "update panel_containers set PREANALITIC_ID=$prean, SAMPLINGSRULES_ID=$samp where panel='".$columns['panel']."'";
            //            $this->queryDB($query);
            //        });
            //    });
        }*/
        /*
        if(Input::hasFile('groups')){
            Excel::load(Input::file('groups'), function($reader) {
                foreach($reader->all() as $sheet) {
                    foreach ($sheet as $row) {
                        $items = $row->all();
                        //dd($items);
                        if($items['img'])
                            $img = "'".$items['img']."'";
                        else $img = null;
                        if($items['mat'])
                            $mat = "'".$items['mat']."'";
                        else $mat=null;
                        $query = "select code from panels where code = '".$items['code']."'";
                        $id = $this->getResult($this->queryDB($query));
                        if (empty($id)) {
                            $query = "insert into panels(code,panel,mats,img) VALUES ('".$items['code']."','" . $items['panel'] . "',".$mat.",".$img.")";
                            $this->queryDB($query);
                        } else {
                            $query = "update panels set mats=".$mat.", img=".$img." where code = '".$items['code']."'";
                            $this->queryDB($query);
                        }
                    }
                }
            });
        }
        if(Input::hasFile('panels')){
            Excel::load(Input::file('panels'), function($reader) {
                foreach($reader->all() as $sheet) {
                    foreach ($sheet as $row) {
                        $items = $row->all();
                        //dd($items);
                        $code = $items['code'];
                        while(strlen($code)<6)
                            $code.='0';
                        $query = "select code from panels where code = '".$code."'";
                        $id = $this->getResult($this->queryDB($query));
                        if(empty($id)){
                            $query = "insert into panels(code,panel,mats,img) ";
                            $query.= "VALUES ('$code','".trim($items['panel'])."', '".$items['mattypes']."', '".$items['img']."')";
                            $this->queryDB($query);
                        }
                        $query = "select pc.panel from panel_containers pc where ";
                        $query.= "pc.panel='$code' and pc.contgroupid=".$items['cont']." and pc.mattype_id=".$items['matt']." and pc.containerno=".$items['no'];
                        $id = $this->getResult($this->queryDB($query));
                        if(empty($id)){
                            $query = "insert into panel_containers(panel,mattype_id,contgroupid,containerno) values";
                            $query.= "('$code',".trim($items['matt']).", ".$items['cont'].", ".$items['no'].")";
                            $this->queryDB($query);
                        }
                        $query = "select panel from prices where panel='$code' and pricelistid=49";
                        $id = $this->getResult($this->queryDB($query));
                        if(empty($id)) {
                            if ($items['catid'] == '[null]') {
                                $query = "insert into prices(pricelistid, panel, due, pgrp) VALUES ";
                                $query .= "(49, '$code'," . $items['dur'] . ", 1)";
                            } else {
                                $query = "insert into prices(pricelistid, panel, due, pgrp) VALUES ";
                                $query .= "(49, '$code'," . $items['dur'] . "," . $items['catid'] . ")";
                            }
                            $this->queryDB($query);
                        }
                    }
                }
            });
        }*/
        /**
         * Восстановление связей в P_C с таблицы LOGS
         */
        /*        $query = "select description from logs where LOG_TIME>'2016-10-11 11:52:58.801' and LOG_TIME<'2016-10-11 11:52:58.803' and theme='DELETE pc'";
        $rows = $this->getResult($this->queryDB($query));
        $contno = 1;
        foreach($rows as $val){
            if($val['DESCRIPTION']){
                if(isset($panel) && $panel==substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'panel=')+6,6))
                    $contno++;
                else $contno = 1;
                $panel = substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'panel=')+6,6);
                $cid = (int)substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'c_id=')+5,3);
                $mid = (int)substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'m_id=')+5,3);
                $sid = (int)substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'s_id=')+5,3);
                $pid = (int)substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'p_id=')+5,3);
                $pid = ($pid==0)?'null':$pid;
                $sid = ($sid==0)?'null':$sid;
                //$query = "update panel_containers set mattype_id=$mid,contgroupid=$cid,preanalitic_id=$pid,samplingsrules_id=$sid where panel='$panel'";
                $query = "insert into panel_containers(containerno,mattype_id,contgroupid,preanalitic_id,samplingsrules_id,panel) values ($contno,$mid,$cid,$pid,$sid,'$panel')";
                $this->queryDB($query);
            }
        }*/
        /**
         * Восстановление контейнеров в P_C
         */
        /*$query = "select description, theme from logs where log_time > '2016-09-15 15:55' and log_time < '2016-10-01 15:55'";
        $rows = $this->getResult($this->queryDB($query));
        $panel = '';
        $del = 0;
        $ins = 0;
        $a = [];
        foreach($rows as $val){
            if($panel==substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'panel=')+6,6)){
                if($val['THEME']=='DELETE pc')
                    $del++;
                elseif($val['THEME']=='insert pc')
                    $ins++;
            } else {
                if($val['THEME']=='DELETE pc' && $panel!='')
                    $del++;
                elseif($val['THEME']=='insert pc' && $panel!='')
                    $ins++;
                if($del!=$ins)
                    $a[$panel] = ['del'=>$del,'ins'=>$ins];
                $panel = substr($val['DESCRIPTION'],strpos($val['DESCRIPTION'],'panel=')+6,6);
                $del = 0;
                $ins = 0;
            }
        }
        //
        foreach($a as $k=>$val){
            $query = "select PREANALITIC_ID, SAMPLINGSRULES_ID from panel_containers where panel='$k'";
            $res = $this->getResult($this->queryDB($query));
            if(isset($res[0])) {
                $p = ($res[0]);
                $pId = $p['PREANALITIC_ID'];
                $sId = $p['SAMPLINGSRULES_ID'];
            }
            $query = "delete from panel_containers where panel='$k'";
            $this->queryDB($query);
            $query = "select description,theme from logs where description like '%$k%'";
            $rows = $this->getResult($this->queryDB($query));
            $i = 1;
            foreach ($rows as $row) {
                if($row['THEME']=='DELETE pc'){
                    $cid = (int)substr($row['DESCRIPTION'],strpos($row['DESCRIPTION'],'c_id=')+5,3);
                    $mid = (int)substr($row['DESCRIPTION'],strpos($row['DESCRIPTION'],'m_id=')+5,3);
                    if(!isset($pId)){
                        $sId = (int)substr($row['DESCRIPTION'],strpos($row['DESCRIPTION'],'s_id=')+5,3);
                        $pId = (int)substr($row['DESCRIPTION'],strpos($row['DESCRIPTION'],'p_id=')+5,3);
                    }
                    $query = "insert into panel_containers(MATTYPE_ID, CONTGROUPID, PANEL, CONTAINERNO, PREANALITIC_ID, SAMPLINGSRULES_ID) values($mid,$cid,'$k',$i,$pId,$sId)";
                    $this->queryDB($query);
                    $i++;
                } elseif($row['THEME']=='insert pc') {
                    $i = 1;
                    break;
                }
            }
            ibase_commit();
        }*/
        /**
         * Вывод тестов в excel
         */
/*                Excel::create('tests', function ($excel){
           $excel->sheet('first', function ($sheet){
               $tests = $this->getResult($this->queryDB("SELECT a.id, a.testname, a.quantity from tests a where a.outsource='Y' order by a.testname"));
               $sheet->setOrientation('landscape');
               $sheet->setPageMargin(0.25);
               $sheet->setWidth(['A'=>20,'B'=>150]);
               $sheet->row(1,['ID','Название','Количество, мкл']);
               $sheet->rows($tests);
           });
        })->export('xls');*/
        /**
         * Копирование колонки аутсорс из lims.tests -> rc.tests
         */
        /*  $lims = ibase_connect('192.168.0.8:lims','sysdba','cdrecord');
        $query = "select id,outsource from tests";
        $stmt = ibase_query($lims,$query);
        while($row = ibase_fetch_assoc($stmt)){
            $query = "update tests set outsource='".$row['OUTSOURCE']."' where id =".$row['ID'];
            $this->queryDB($query);
        }*/
        return \View::make('test')->with([

        ]);
    }
}
