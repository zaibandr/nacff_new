<?
    $host="192.168.0.14:RC";
    $username="SYSDBA";
    $password="cdrecord";
    $db = ibase_pconnect($host, $username, $password)
    or die("Ошибка подключения к БД! ". ibase_error());
    if(isset($_GET['rule'])) {
        if ($_GET['dept'] == '')
            $query = "select rulename, sql, per from rules where rulename!='' and status='A' and deptid=" . $_GET['d'];
        else
            $query = "select rulename, sql, per from rules where rulename!='' and status='A' and deptid=" . $_GET['dept'];
        $stmt = ibase_query($query);
        while($row = ibase_fetch_assoc($stmt)){
            $res[] = $row;
        }
        echo json_encode($res);
    }
    if(isset($_GET['doc'])) {
        if($_GET['dept']=='')
            $query = "select DISTINCT d.id as \"id\", d.doctor as \"label\" inner JOIN folders f on f.doctor=d.id where f.clientid=".$_GET['d'];
        else
            $query = "select DISTINCT d.id as \"id\",d.doctor as \"label\"  from doctors d inner JOIN folders f on f.doctor=d.id where f.clientid=".$_GET['dept'];
        $stmt = ibase_query($query);
        $res='';
        while($row = ibase_fetch_assoc($stmt)){
            $res .= "{\"label\":\"" . addslashes($row['label']) . "\",";
            $res .= "\"id\":\"" . $row['id'] . "\"},";
        }
        $res = substr($res, 0, -1);
        $res="[$res]";
        echo ($res);
    }