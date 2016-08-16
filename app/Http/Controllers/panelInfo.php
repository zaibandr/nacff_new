<?
$host="192.168.0.14:RC";
$username="SYSDBA";
$password="cdrecord";
$db = ibase_connect($host, $username, $password)
or die("Ошибка подключения к БД! ". ibase_error());
if(isset($_GET['code'])){
    $query = "select p.code, p.panel, m.mattype, c.contgroup, s.samplingrule, pr.description, count(*) from panels p ";
    $query.= "left join panel_containers pc on p.code=pc.panel ";
    $query.= "left join mattypes m on m.id=pc.mattype_id ";
    $query.= "left join contgroups c on c.id=pc.contgroupid ";
    $query.= "left join preanalytics pr on pr.id=pc.preanalitic_id ";
    $query.= "left join samplingrules s on s.id=pc.samplingsrules_id ";
    $query.= "where pc.panel = '".$_GET['code']."'";
    $query.= "group by p.code, p.panel, m.mattype, c.contgroup, s.samplingrule, pr.description";
    $stmt = ibase_query($query);
    while($row = ibase_fetch_assoc($stmt)){
        $res[] = $row;
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
}