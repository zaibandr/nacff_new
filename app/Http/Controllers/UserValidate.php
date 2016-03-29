<?php
$host="192.168.0.14:RC";
$username="SYSDBA";
$password="cdrecord";
$db = ibase_pconnect($host, $username, $password)
or die("Ошибка подключения к БД! ". ibase_error());
if(isset($_GET['login'])){
    $login = trim(mb_strtoupper($_GET['login'],'UTF-8'));
    $query = "select count(ALL usernam) from users where usernam='$login'";
    $stmt = ibase_query($query);
    $res = ibase_fetch_assoc($stmt);
    echo json_encode($res);
}
