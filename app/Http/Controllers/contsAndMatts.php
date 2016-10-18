<?
$host="192.168.0.249:rc";
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
    if(isset($_GET['prean'])){
        if (isset($_GET["term"]) && $_GET["term"] !== "") {
            $text = explode(',', trim($_GET["term"]));
            $query = "select description from preanalytics where description like '%$text[0]%'";
            for ($i = 1; $i < count($text); $i++)
                $query .= " and description like '%$text[$i]%'";
            $stmt = ibase_query($query);
            while ($row = ibase_fetch_assoc($stmt)) {
                $res[] = ['label' => $row['DESCRIPTION'], 'value' => $row['DESCRIPTION']];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
    }
}