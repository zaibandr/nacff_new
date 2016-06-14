<?php
$host="192.168.0.14:RC";
$username="SYSDBA";
$password="cdrecord";
$db = ibase_pconnect($host, $username, $password)
or die("Ошибка подключения к БД! ". ibase_error());
if(isset($_GET['lpu'])){
    $lpu = $_GET['lpu'];
    $query = "select DISTINCT dept from departments where deptcode='$lpu'";
    $stmt = ibase_query($query);
    while ($res = ibase_fetch_assoc($stmt))
        $a[]=$res;
    echo json_encode($a);
}