<?
$host="192.168.0.14:RC";
$username="SYSDBA";
$password="cdrecord";
$db = ibase_connect($host, $username, $password)
or die("Ошибка подключения к БД! ". ibase_error());
if(isset($_GET['checker']) && $_GET['checker']=='password'){
    if(isset($_GET['cont'])){
        $query = " select contgroup from contgroups";
        $stmt = ibase_query($query);
        while($row = ibase_fetch_assoc($stmt)){
            $res[] = ['label'=>$row['CONTGROUP'],'value'=>$row['CONTGROUP']];
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    if(isset($_GET['matt'])){
        $query = " select mattype from mattypes";
        $stmt = ibase_query($query);
        while($row = ibase_fetch_assoc($stmt)){
            $res[] = ['label'=>$row['MATTYPE'],'value'=>$row['MATTYPE']];
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    if(isset($_GET['samp'])){
        $query = " select samplingrule from samplingrules";
        $stmt = ibase_query($query);
        while($row = ibase_fetch_assoc($stmt)){
            $res[] = ['label'=>$row['SAMPLINGRULE'],'value'=>$row['SAMPLINGRULE']];
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }
}