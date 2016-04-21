<?php
if(isset($_GET['dept']) && $_GET['clientcode'])
{
    $host="192.168.0.14:RC";
    $username="SYSDBA";
    $password="cdrecord";
    $db = ibase_pconnect($host, $username, $password)
    or die("Ошибка подключения к БД! ". ibase_error());
    if(isset($_GET['t'])) {
        if (isset($_GET['p']) && isset($_GET['g'])) {
            if($_GET['g']=='a'){
                $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where s.status='A' and p.status='A' and s.parent=".$_GET['p']." and p.id=".$_GET['dept'];
                $stmt = ibase_query($db,$query);
                while ($row = ibase_fetch_assoc($stmt)){
                    $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                    $a[] = ['bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row['CODE'] . ']  ' . $row['NAME'] . '  (' . $row['PRICE'] . ')' , 'id' => $row['SORTER'], 'code' => $row['CODE'], 'cost' => $row['PRICE']];
                }
            } else {
                $query = "select distinct p.panel, p.COST, p.nacph, COALESCE (p.medan,pan.PANEL), pan.mats from PRICES p ";
                $query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
                $query .= "inner join PANEL_CATEGORIES pc on pc.ID = p.PCAT  ";
                $query .= "inner join PANELS pan on pan.CODE=p.PANEL ";
                $query .= "inner join PRICELISTS pl on pl.id=p.pricelistid ";
                $query .= "where pl.status='A' and pg.pgrp='" . $_GET['p'] . "' and pc.pcat='" . $_GET['g'] . "' and p.pricelistid=" . $_GET['dept'];
                //echo $query; die();
                $stmt = ibase_query($db, $query);
                while ($row = ibase_fetch_row($stmt)) {
                    $row[3] = str_replace('  ',' ',$row[3]);
                    $mats = '';
                    $id = str_replace('.', '', $row[0]);
                    if ($row[4] != null) {
                        $mat = "<span id='additional%s' style='margin-left:35px; display:none'>" .
                            "<table class='bio'>" .
                            "<tr><td colspan='2'>БИОМАТЕРИАЛ:<br/>%s </td></tr>" .
                            "</table>" .
                            "</span>";
                        $mat1 = "<select disabled='disabled' style='width:300px;' id='m" . $id . "' name='" . $row[0] . "' onchange='setBio( this.value , " . $id . " )' >";
                        $mat1 .= "<option value='70'></option>";
                        $arr = explode(";", $row[4]);
                        $string = "'" . $arr[0] . "'";
                        for ($j = 1; $j < count($arr); $j++)
                            $string .= ",'" . $arr[$j] . "'";
                        $rs2 = ibase_query($db, "SELECT ID, MATTYPE FROM MATTYPES WHERE ID IN (" . $string . ")");
                        while ($row2 = ibase_fetch_assoc($rs2)) {
                            $mat1 .= "<option value='" . $row2["ID"] . "'>" . $row2["MATTYPE"] . "</option>";
                        }
                        $mat1 .= "</select>";
                        $mats = sprintf($mat, $id, $mat1);
                    }
                    $a[] = ['bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row[0] . ']  ' . $row[3] . '  (' . $row[1] . ')' . $mats, 'id' => $id, 'code' => $row[0], 'cost' => $row[1], 'ncost'=>$row[2]];
                }
            }
        } else {
            $query = "select distinct pc.PCAT, pg.PGRP from PRICES p ";
            $query .= "inner join PANEL_CATEGORIES pc on pc.ID=p.PCAT ";
            $query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
            $query .= "inner join PRICELISTS pr on pr.id=p.PRICELISTID ";
            $query .= "where pr.status = 'A' and pr.id=".$_GET['dept'];
            $stmt = ibase_query($db, $query);
            $s = 'Группы панелей';
            $a = [['id' => 0, 'parent' => '', 'title' => 'Группы панелей', 'isLazy' => true, 'isFolder' => true, 'children' => []],
                  ['id' => 'a', 'parent' => '', 'title' => 'Услуги центра', 'isLazy' => true, 'isFolder' => true, 'children' => []]];
            while ($row = ibase_fetch_assoc($stmt)) {
                if (!empty($a[0]['children'])) {
                    $k = 0;
                    for ($i = 1; $i <= count($a[0]['children']); $i++) {
                        if ($a[0]['children'][$i - 1]['id'] == $row['PCAT'])
                            $k = 1;
                    }
                    //echo $k;
                    if ($k == 0) {
                        $a[0]['children'][] = ['id' => $row['PCAT'], 'parent' => '0', 'title' => $row['PCAT'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
                        $a[0]['children'][count($a[0]['children']) - 1]['children'][] = ['id' => $row['PGRP'], 'parent' => $row['PCAT'], 'title' => $row['PGRP'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
                    } else {
                        $d = 0;
                        for ($j = 1; $j <= count($a[0]['children'][count($a[0]['children']) - 1]['children']); $j++)
                            if ($a[0]['children'][count($a[0]['children']) - 1]['children'][$j - 1]['id'] == $row['PGRP'])
                                $d = 1;
                        if ($d == 0)
                            $a[0]['children'][count($a[0]['children']) - 1]['children'][] = ['id' => $row['PGRP'], 'parent' => $row['PCAT'], 'title' => $row['PGRP'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
                    }
                } else {
                    $a[0]['children'][] = ['id' => $row['PCAT'], 'parent' => '0', 'title' => $row['PCAT'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
                    $a[0]['children'][count($a[0]['children']) - 1]['children'][] = ['id' => $row['PGRP'], 'parent' => $row['PCAT'], 'title' => $row['PGRP'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
                }
            }
            $query = "select s.name, s.parent, s.id from services s inner join pricelists p on p.dept = s.deptid where s.price is NULL and p.status='A' and p.id =".$_GET['dept'];
            $stmt = ibase_query($db, $query);
            while($res = ibase_fetch_assoc($stmt))
            {
                    $a[1]['children'][] = ['id' => $res['ID'], 'parent' => 'a', 'title' => $res['NAME'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
            }
            if(count($a[1]['children'])==0)
                $a[1]['children'][] = [ "icon"=> "false", "title"=> "<i>Нет данных | N/A</i>", "id"=> 'none'];
            //print_r($a);
        }
        echo(json_encode($a, JSON_UNESCAPED_UNICODE));
    }
    if(isset($_GET['s'])) {
        if (isset($_GET['term'])) {
            $query = "select distinct p.panel,p.nacph, p.COST, COALESCE (p.medan, pan.PANEL), pan.mats from PRICES p ";
            $query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
            $query .= "inner join PANEL_CATEGORIES pc on pc.ID = p.PCAT  ";
            $query .= "inner join PANELS pan on pan.CODE=p.PANEL ";
            $query .= "inner join pricelists pl on p.pricelistid=pl.id and pl.status='A' and pl.id=".$_GET['dept']." ";
            $query .= "where p.panel like '%".$_GET['term']."%' or COALESCE (p.medan, pan.PANEL) like '%".$_GET['term']."%'";
            $stmt = ibase_query($db, $query);
            while ($row = ibase_fetch_row($stmt)) {
                $row[3] = str_replace('  ',' ',$row[3]);
                $mats = '';
                $id = str_replace('.', '', $row[0]);
                if ($row[4] !== null) {
                    $mat = "<span id='additional%s' style='margin-left:35px; display:none'>" .
                        "<table class='bio'>" .
                        "<tr><td colspan='2'>БИОМАТЕРИАЛ:<br/>%s </td></tr>" .
                        "</table>" .
                        "</span>";
                    $mat1 = "<select disabled='disabled' style='width:300px;' id='m" . $id . "' name='" . $row[0] . "' onchange='setBio( this.value , " . $id . " )' >";
                    $mat1 .= "<option value='70'></option>";
                    $arr = explode(";", $row[4]);
                    $string = "'" . $arr[0] . "'";
                    for ($j = 1; $j < count($arr); $j++)
                        $string .= ",'" . $arr[$j] . "'";
                    $rs2 = ibase_query($db, "SELECT ID, MATTYPE FROM MATTYPES WHERE ID IN (" . $string . ")");
                    while ($row2 = ibase_fetch_assoc($rs2)) {
                        $mat1 .= "<option value='" . $row2["ID"] . "'>" . $row2["MATTYPE"] . "</option>";
                    }
                    $mat1 .= "</select>";
                    $mats = sprintf($mat, $id, $mat1);
                }
                $a[] = ['color'=>'','cost' => $row[2], 'bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row[0] . ']  ' . $row[3] . $mats, 'id' => $id, 'value' => '['.$row[0].'] '.$row[3], 'code' => $row[0], 'ncost'=>$row[1] ];
            }
            $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where p.status='A' and s.status='A' and p.id=".$_GET['dept']." and s.code like '%".$_GET['term']."%'";
            $stmt = ibase_query($db,$query);
            while ($row = ibase_fetch_assoc($stmt)){
                $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                $a[] = ['color'=>'','cost' => $row['PRICE'], 'bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row['CODE'] . ']  ' . $row['NAME'], 'id' => $row['SORTER'], 'value' => '['.$row['CODE'].']'.$row['NAME'], 'code' => $row['CODE'] ];
            }
            //print_r($a);
            echo(json_encode($a));
        }
    }
    if(isset($_GET['a'])) {
        if (isset($_GET['term'])) {
            $query = "select distinct pan.CODE, p.COST,p.nacph, COALESCE (p.medan, pan.PANEL), pan.mats from PRICES p ";
            $query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
            $query .= "inner join PANEL_CATEGORIES pc on pc.ID = p.PCAT  ";
            $query .= "inner join PANELS pan on pan.CODE=p.PANEL ";
            $query .= "where p.panel ='".$_GET['term']."' and p.pricelistid=".$_GET['dept'];
            $stmt = ibase_query($db, $query);
            while ($row = ibase_fetch_row($stmt)) {
                $row[3] = str_replace('  ',' ',$row[3]);
                $mats = '';
                $id = str_replace('.', '', $row[0]);
                if ($row[4] != null) {
                    $mat = "<span id='additional%s' style='margin-left:35px; display:none'>" .
                        "<table class='bio'>" .
                        "<tr><td colspan='2'>БИОМАТЕРИАЛ:<br/>%s </td></tr>" .
                        "</table>" .
                        "</span>";
                    $mat1 = "<select disabled='disabled' style='width:300px;' id='m" . $id . "' name='" . $row[0] . "' onchange='setBio( this.value , " . $id . " )' >";
                    $mat1 .= "<option value='70'></option>";
                    $arr = explode(";", $row[4]);
                    $string = "'" . $arr[0] . "'";
                    for ($j = 1; $j < count($arr); $j++)
                        $string .= ",'" . $arr[$j] . "'";
                    $rs2 = ibase_query($db, "SELECT ID, MATTYPE FROM MATTYPES WHERE ID IN (" . $string . ")");
                    while ($row2 = ibase_fetch_assoc($rs2)) {
                        $mat1 .= "<option value='" . $row2["ID"] . "'>" . $row2["MATTYPE"] . "</option>";
                    }
                    $mat1 .= "</select>";
                    $mats = sprintf($mat, $id, $mat1);
                }
                $a = ['color'=>'','cost' => $row[1], 'ncost'=>$row[2], 'bioset' => '', 'biodef' => '', 'icon' => '', 'label' => '  [' . $row[0] . ']  ' . $row[3] .'  ('.$row[1].')'. $mats, 'id' => $id, 'value' => $row[0], 'code' => $row[0]];
            }
            if(empty($a)) {
                $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where s.status='A' and p.status='A' and p.id=".$_GET['dept']." and s.code ='".$_GET['term']."'";
                $stmt = ibase_query($db, $query);
                while ($row = ibase_fetch_assoc($stmt)) {
                    $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                    $a = ['color' => '', 'cost' => $row['PRICE'], 'bioset' => '', 'biodef' => '', 'icon' => '', 'label' => '  [' . $row['CODE'] . ']  ' . $row['NAME'], 'id' => $row['SORTER'], 'value' => $row['CODE'], 'code' => $row['CODE']];
                }
            }
            //print_r($a);
            echo(json_encode($a));
        }
    }
} else echo"Ошибка авторизации!";