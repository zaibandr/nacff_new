<?php
$host="192.168.0.14:RC";
$username="SYSDBA";
$password="cdrecord";
$db = ibase_pconnect($host, $username, $password)
or die("Ошибка подключения к БД! ". ibase_error());
if(isset($_GET['panel'])){
    $panel = trim(str_replace(',','.',$_GET['panel']));
    $query = "select pr.description from preanalytics pr inner join panel_containers p on p.preanalitic_id=pr.id where p.panel='$panel'";
    $stmt = ibase_query($query);
    $res = ibase_fetch_assoc($stmt);
    echo json_encode($res);
}