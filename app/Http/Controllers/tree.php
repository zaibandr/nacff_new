<?php
require '/var/www/html/site/vendor/predis/predis/autoload.php';

try {
    $redis = new Predis\Client();
} catch (Exception $e){
    die($e->getMessage());
}
function tree(array &$a, array $b){

    foreach($a as &$val){
        if($val['id']==$b['PARENT']){
            $val['children'][] = ['id'=>$b['ID'], 'parent'=>$b['PARENT'], 'title' => $b['PGRP'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
        }
        else {
            if(!empty($val['children'])){
                tree($val['children'],$b);
            }
        }
        unset($val);
    }
}
if(isset($_GET['dept']) && $_GET['clientcode'])
{
    $host="192.168.0.249:rc";
    $username="SYSDBA";
    $password="cdrecord";
    $db = ibase_pconnect($host, $username, $password)
    or die("Ошибка подключения к БД! ". ibase_error());
    if(isset($_GET['t'])) {
        if (isset($_GET['p']) && isset($_GET['g'])) {
            $a = '[';
        if($_GET['g']=='a'){
                $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where s.status='A' and p.status='A' and s.parent=".$_GET['p']." and p.id=".$_GET['dept'];
                $stmt = ibase_query($db,$query);
                while ($row = ibase_fetch_assoc($stmt)){
                    $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                    $a .= json_encode(['bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row['CODE'] . ']  ' . $row['NAME'] . '  (' . $row['PRICE'] . ')' , 'id' => $row['SORTER'], 'code' => $row['CODE'], 'cost' => $row['PRICE']],JSON_UNESCAPED_UNICODE).',';
                }
            } else {
                $keys   = $redis->keys('*group:'.$_GET['p'].'*');
                foreach($keys as $key){
                    $panel = substr($key,6,6);
                    if($redis->hexists('pricelists:'.$_GET['dept'], $panel)){
                        $cost = $redis->hget('pricelists:'.$_GET['dept'],$panel);
                        $cost = $cost==''?0:$cost;
                        $a .= substr($redis->get($key),0,-1).',"cost":"'.$cost.'"},';
                        //$a .= $redis->get($key).',';
                    }
                }
            }
    if($a=='[')
        echo "<i>Нет панелей</i>";
    else
        echo substr($a,0,-1).']';
        } else {
           //$query = "select distinct pc.PCAT, pg.PGRP from PRICES p ";
           //$query .= "inner join PANEL_CATEGORIES pc on pc.ID=p.PCAT ";
           //$query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
           //$query .= "inner join PRICELISTS pr on pr.id=p.PRICELISTID ";
           //$query .= "where pr.status = 'A' and pr.id=".$_GET['dept'];
            $query = "select distinct pc.PCAT, pc.id from PANEL_CATEGORIES pc order by pc.id";
            $stmt = ibase_query($query);
            $s = 'Группы панелей';
            $a = [['id' => 0, 'parent' => '', 'title' => 'Группы панелей', 'isLazy' => true, 'isFolder' => true, 'children' => []],
                  ['id' => 'a', 'parent' => '', 'title' => 'Услуги центра', 'isLazy' => true, 'isFolder' => true, 'children' => []]];
            while ($row = ibase_fetch_assoc($stmt)) {
                $a[0]['children'][] = ['id'=>$row['ID'], 'parent'=>0, 'title' => $row['PCAT'], 'isLazy' => true, 'isFolder' => true, 'children' => []];
            }
            $query = "select pgrp, parent, id from panel_groups order by sorter";
            $stmt = ibase_query($query);
            while ($row = ibase_fetch_assoc($stmt)){
                tree($a, $row);
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
        echo(json_encode($a, JSON_UNESCAPED_UNICODE));

        }
    }
    if(isset($_GET['s'])) {
        if (isset($_GET['term'])) {
        $a = '[';
        $keys   = array_merge($redis->keys('panel:'.$_GET['term'].'*'),$redis->keys('*name:*'.mb_strtoupper($_GET['term'].'*')));
        foreach($keys as $key){
            $panel = substr($key,6,6);
            if($redis->hexists('pricelists:'.$_GET['dept'],$panel)){
                $cost = $redis->hget('pricelists:'.$_GET['dept'],$panel);
                $cost = $cost==''?0:$cost;
                $a .= substr($redis->get($key),0,-1).',"cost":"'.$cost.'"},';
                //$a .= $redis->get($key).',';
            }
             }
            $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where p.status='A' and s.status='A' and p.id=".$_GET['dept']." and s.code like '%".$_GET['term']."%'";
            $stmt = ibase_query($db,$query);
            while ($row = ibase_fetch_assoc($stmt)){
                $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                $a.= json_encode(['color'=>'','cost' => $row['PRICE'], 'bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row['CODE'] . ']  ' . $row['NAME'], 'id' => $row['SORTER'], 'value' => '['.$row['CODE'].']'.$row['NAME'], 'code' => $row['CODE'] ],JSON_UNESCAPED_UNICODE).',';
            }
            //print_r($a);
            echo substr($a,0,-1).']';
         }
    }
    if(isset($_GET['a'])) {
        if (isset($_GET['term'])) {
        $a = '[';
        $keys   = $redis->keys('panel:'.$_GET['term'].'*');
        foreach($keys as $key){
            $panel = substr($key,6,6);
            if($redis->hexists('pricelists:'.$_GET['dept'],$panel)){
                $cost = $redis->hget('pricelists:'.$_GET['dept'],$panel);
                $cost = $cost==''?0:$cost;
                $a .= substr($redis->get($key),0,-1).',"cost":"'.$cost.'"},';
                //$a .= $redis->get($key).',';
            }
             }
            if($a=='[') {
                $query = "select s.price, s.code, s.name, s.sorter from services s inner join pricelists p on p.dept=s.deptid where s.status='A' and p.status='A' and p.id=".$_GET['dept']." and s.code ='".$_GET['term']."'";
                $stmt = ibase_query($db, $query);
                while ($row = ibase_fetch_assoc($stmt)) {
                    $row['NAME'] = str_replace('  ',' ',$row['NAME']);
                    $a = json_encode(['color' => '', 'cost' => $row['PRICE'], 'bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $row['CODE'] . ']  ' . $row['NAME'], 'id' => $row['SORTER'], 'value' => $row['CODE'], 'code' => $row['CODE']],JSON_UNESCAPED_UNICODE);
                }
        echo $a;
            } else {
            echo substr($a,0,-1).']';
        }
        }
    }
} else echo"Ошибка авторизации!";