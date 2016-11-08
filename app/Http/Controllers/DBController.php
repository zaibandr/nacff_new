<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 12.01.2016
 * Time: 9:05
 */

namespace App\Http\Controllers;


class DBController extends Controller
{
    public $db;
    protected $host="192.168.0.249:rc";
    protected $username="SYSDBA";
    protected $password="cdrecord";
    function __construct(){
        $this->db = ibase_connect($this->host, $this->username, $this->password)
        or die("Ошибка подключения к БД! ". ibase_error());
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        ibase_close($this->db);
    }

    function getUser($l, $p)
    {
        $query = "select u.fullname, u.usernam, d.deptcode, d.id, ur.roleid, u.password2 from users u ";
        $query.="left join userdept ud on ud.usernam = u.usernam ";
        $query.="left join departments d on ud.dept = d.id ";
        $query.="inner join userroles ur on ur.usernam = u.usernam ";
        $query.="where u.status='A' and u.usernam='".$l."'";
        $result = $this->queryDB($query);
        $a =  $this->getResult($result);
        $a[0]['PASSWORD2'] = hash_equals($a[0]['PASSWORD2'],$p);
        return $a;
    }

    function queryDB($query){
        $stmt = ibase_query($this->db,$query);
        return $stmt;
    }

    function getResult($res){
        $a = [];
        while($row = ibase_fetch_assoc($res))
            $a[] = $row;
        return $a;
    }

    function getPanel(){
        /*$query = "SELECT p.CODE, p.PANEL, m.ID, m.MATTYPE, g.id, g.contgroup from PANELS p ";
        $query.= "inner join PRICES pr on pr.PANEL = p.CODE ";
        $query.= "inner join PANEL_CONTAINERS pc on pc.PANEL=p.CODE ";
        $query.= "inner join PRICELISTS pl on pl.ID = pr.PRICELISTID ";
        $query.= "inner join DEPARTMENTS d on d.ID=pl.DEPT ";
        $query.= "inner join MATTYPES m on m.ID=pc.MATTYPE_ID ";
        $query.= "inner join CONTGROUPS g on g.ID=pc.CONTGROUPID ";*/
        $query = "SELECT p.CODE, p.PANEL, p.CHECKED from panels p order by p.code";
        $a = $this->getResult($this->queryDB($query));
        //dd($a);
        return $a;
    }
    function getPanel2(){
        $query = "SELECT p.CODE, p.PANEL, p.CHECKED from panels p ";
        $query.= "inner join panel_containers pc on pc.panel = p.code ";
        $query.= "where pc.SAMPLINGSRULES_ID in (25,26,27,28) or pc.SAMPLINGSRULES_ID is null order by p.code";
        $a = $this->getResult($this->queryDB($query));
        return $a;
    }
    function getMattype(){
        $query = "SELECT  m.ID, m.MATTYPE from MATTYPES m";
        $a = $this->getResult($this->queryDB($query));
        return $a;
    }
    function getPCont(){
        $query = "SELECT  g.id, g.contgroup from CONTGROUPS g";
        $a = $this->getResult($this->queryDB($query));
        return $a;
    }
    function getAnalyte(){
        $query = "select a.testcode, a.analyte, a.units from analytes a ORDER by a.sorter";
        return $this->getResult($this->queryDB($query));
    }
    function getTests($testname){
        $query = "SELECT a.id, a.testname, a.quantity from tests a where a.testname like '%$testname%' order by a.testname";
        return $this->getResult($this->queryDB($query));
    }
    function getNets(){
        $query = "select id,netname,comments from nets";
        return $this->getResult($this->queryDB($query));
    }
    function getPrices(){
        $dept = \Input::get('dept', \Session::get('dept'));
        $query = "select p.COST, p.panel, coalesce(p.MEDAN, pn.panel), p.NACPH, p.COMMENTS, p.due from PRICES p ";
        $query.= "inner join PRICELISTS pr on pr.id = p.PRICELISTID ";
        $query.= "inner join panels pn on pn.code=p.panel ";
        $query.= "where pr.status='A' and pr.dept=$dept order by p.panel";
        $stmt = ibase_query($this->db,$query);
        $a = [];
        while($row = ibase_fetch_row($stmt)){
            $a[] = $row;
        }
        return $a;
    }

    public function serviceGroup()
    {
        $query = "select s.name, s.id from services s where s.price is NULL and s.status='A' and s.deptid =".\Input::get('dept');
        return $this->getResult($this->queryDB($query));
    }
    function getServices(){
        $query = "select s.NAME, s.CODE, s.PRICE, s.status from SERVICES s ";
        $query.= "inner join DEPARTMENTS d on d.id = s.DEPTID ";
        if(\Input::has('dept'))
            $query.= "where s.price is not null and d.id='".\Input::get('dept')."'";
        else
            $query.= "where s.price is not null and d.DEPTCODE='".\Session::get('clientcode')."'";
        //dd($query);
        $query.= " order by s.code";
        $stmt = ibase_query($this->db,$query);
        $a = $this->getResult($stmt);
        return $a;
    }
    function getPatient(){
        $query = "SELECT distinct a.LOGDATE, a.SURNAME, a.NAME, a.PATRONYMIC, a.GENDER, a.DATE_BIRTH, a.ADDRESS, a.PASSPORT_SERIES, a.PASSPORT_NUMBER, a.PHONE, a.EMAIL, a.pid ";
        $query .= "FROM PATIENT a ";
        $query .= "inner join FOLDERS f on f.PID=a.PID ";
        $query .= "inner join DEPARTMENTS d on d.ID = f.CLIENTID ";
        $query .= "inner join userdept u on u.dept = d.id ";
        $query .= "where u.usernam='".\Session::get('login')."' order by a.surname";
        $res = $this->queryDB($query);
        //dd($this->getResult($res));
        return $this->getResult($res);
    }
    function getPatientInfo($id){
        $query = "SELECT distinct a.LOGDATE, a.SURNAME, a.NAME, a.PATRONYMIC, a.GENDER, a.DATE_BIRTH, a.ADDRESS, a.PASSPORT_SERIES, a.PASSPORT_NUMBER, a.PHONE, a.EMAIL, f.logdate, s.statusname, f.folderno, f.apprsts ";
        $query .= "FROM PATIENT a ";
        $query .= "inner join FOLDERS f on f.PID=a.PID ";
        $query .= "inner join statuses s on f.apprsts=s.status ";
        $query .= "where f.apprsts!='R' and a.pid=$id";
        $res = $this->queryDB($query);
        //dd($this->getResult($res));
        return $this->getResult($res);
    }
    function getTree(){
        $query="select distinct p.PANEL, p.COST, pc.PCAT, pan.PANEL, pg.PGRP from PRICES p ";
        $query .= "inner join PANEL_CATEGORIES pc on pc.ID=p.PCAT ";
        $query .= "inner join PANEL_GROUPS pg on pg.ID = p.PGRP ";
        $query .= "inner join PRICELISTS pr on pr.id=p.PRICELISTID ";
        $query .= "inner join DEPARTMENTS d on d.ID=pr.DEPT ";
        $query .= "inner join PANELS pan on pan.CODE=p.PANEL ";
        $query .= "inner join PANEL_CONTAINERS p_c on p_c.PANEL=pan.CODE ";
        $query .= "inner join MATTYPES m on m.ID=p_c.MATTYPE_ID ";
        $query .= "inner join CONTGROUPS c on c.ID=p_c.CONTGROUPID ";
        $query .= "where d.";
        $stmt = ibase_query($this->db,$query);
        while($row = ibase_fetch_assoc($stmt)) {
            $a[$row['PCAT']][$row['PGRP']][]['PANEL'] = $row['PANEL'];
            $a[$row['PCAT']][$row['PGRP']][]['PANEL_01'] = $row['PANEL_01'];
            $a[$row['PCAT']][$row['PGRP']][]['COST'] = $row['COST'];
        }
        return (json_encode($a, JSON_UNESCAPED_UNICODE ));
    }
    function getFolders(){
        if (\Input::has('status'))
            $apprsts = \Input::get('status');
        else $apprsts = '';
        if (\Input::has('positive'))
            $positive = \Input::get('positive');
        else $positive = '';
        if (\Input::has('date_st'))
            $date_st = \Input::get('date_st');
        else $date_st = date('Y-m-d', strtotime("-3 days"));
        if (\Input::has('date_en'))
            $date_en = date('Y-m-d 23:59:59', strtotime(\Input::get('date_en')));
        else $date_en = date('Y-m-d 23:59:59');
        if(\Input::has('client') && \Input::get('client')!=='' && \Input::get('client')!=='all'){
            $query = "select f.folderno, a.STATUSNAME, a.STATUSCOLOR, d.dept, f.LOGDATE, f.SURNAME, f.NAME, f.PATRONYMIC, f.DATE_BIRTH, f.PHONE, f.org, f.str,  f.EMAIL, f.GENDER, doc.DOCTOR, f.COMMENTS, f.APPRSTS, f.clientid, f.loguser, f.price, f.cash, f.cito, f.discount, f.cost from folders f ";
            $query.= "left join doctors doc on doc.id=f.doctor ";
            $query.= "inner join departments d on d.id=f.clientid ";
            $query.= "inner join statuses a on a.status=f.apprsts ";
            $query.= "where f.apprsts!='R' and f.clientid=".\Input::get('client');
        }

    else{
            $query = "select f.folderno, a.STATUSNAME, a.STATUSCOLOR, d.dept, f.LOGDATE, f.SURNAME, f.NAME, f.PATRONYMIC, f.DATE_BIRTH, f.PHONE, f.org, f.str, f.EMAIL, f.GENDER, doc.DOCTOR, f.COMMENTS, f.APPRSTS, f.clientid, f.loguser, f.price, f.cito, f.cash, f.discount, f.cost from folders f ";
            $query.= "left join doctors doc on doc.id=f.doctor ";
            $query.= "inner join departments d on d.id=f.clientid ";
            $query.= "inner join statuses a on a.status=f.apprsts ";
            $query.= "inner join userdept u on u.dept = d.id ";
            $query.= "where u.usernam='".\Session::get('login')."' and f.apprsts!='R'";
        }
        $query.= " and f.logdate >= '".$date_st."' and f.logdate <= '".$date_en."'";
        if($positive!='')
            $query.=" and f.status='".$positive."'";
        if($apprsts!='')
            $query.=" and f.apprsts='".$apprsts."'";
        //dd($query);
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;

    }

    public function getFoldersAdmin(){
        if (\Input::has('date_st'))
            $date_st = \Input::get('date_st');
        else $date_st = date('Y-m-d', strtotime("-1 days"));
        if (\Input::has('date_en'))
            $date_en = date('Y-m-d 23:59:59', strtotime(\Input::get('date_en')));
        else $date_en = date('Y-m-d 23:59:59');
        $query = "select f.folderno, a.STATUSNAME, a.STATUSCOLOR, d.dept, f.LOGDATE, f.SURNAME, f.NAME, f.PATRONYMIC, f.DATE_BIRTH, f.PHONE, f.EMAIL, f.GENDER, f.COMMENTS, f.APPRSTS, f.clientid, f.loguser, f.price, f.cito, f.cash, f.discount, f.cost from folders f ";
        $query.= "inner join departments d on d.id=f.clientid ";
        $query.= "inner join statuses a on a.status=f.apprsts ";
        $query.= "where f.apprsts!='R'";
        $query.= " and f.logdate >= '".$date_st."' and f.logdate <= '".$date_en."'";
        if (\Input::has('status'))
            $query.=" and f.apprsts='".\Input::get('status')."'";
        if (\Input::has('positive'))
            $query.=" and f.status='".\Input::get('positive')."'";
        if (\Input::has('lpu'))
            $query.= " and d.deptcode=".\Input::get('lpu');
        if (\Input::has('client'))
            $query.=" and d.dept like '%".trim(\Input::get('client'))."%'";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getMaterials()
    {
        $query = "select m.id, m.material from materials m where m.parent is not NULL";
        return $this->getResult($this->queryDB($query));
    }
    public function getMatDept()
    {
        $query = "select m.MATERIAL, md.UNIT, md.UNITPACK, d.dept, m.parent ";
        $query.= "from Materialdept md ";
        $query.= "inner join MATERIALS m on m.ID=md.MATID ";
        $query.= "inner join DEPARTMENTS d on d.ID=md.DEPTID ";
        if(\Input::has('dept') && \Input::get('dept')!=='')
            $query.= "where md.UNIT!=0 and md.UNITPACK!=0 and d.id =".\Input::get('dept');
        else {
            $query.= "inner join userdept u on u.dept = d.id ";
            $query.= "where md.UNIT!=0 and md.UNITPACK!=0 and u.usernam='".\Session::get('login')."'";
        }
        return $this->getResult($this->queryDB($query));
    }
    public function getDeptsAdmin()
    {
        $query = "select d.id, d.dept, d.deptcode, d.description from departments d";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }
    public function getDepts()
    {
        if(\Session::has('isAdmin') && \Session::get('isAdmin'))
            $query = "select d.id, d.dept from departments d order by d.dept";
        else
            $query = "select d.id, d.dept from departments d inner join userdept u on u.dept = d.id where u.usernam='".\Session::get('login')."'";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }
    public function getDeptPrice()
    {
        $query = "select d.dept, p.id from departments d inner join pricelists p on p.dept=d.id where p.status='A' and deptcode='".\Session::get('clientcode')."'";
        if(\Session::has('isAdmin') && \Session::get('isAdmin')==1)
            $query = "select d.dept, p.id from departments d inner join pricelists p on p.dept=d.id where p.status='A'";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getPriceAdmin($id)
    {
        $query = "select pan.code, p.cost, p.nacph, p.due, coalesce(p.medan, pan.panel) from prices p ";
        $query.= "inner join panels pan on pan.code=p.panel ";
        $query.= "inner join pricelists pr on p.pricelistid=pr.id ";
        $query.= "where pr.dept=$id order by pan.code";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getRules($id='')
    {
        if($id=='')
            $query = "select rulename, sql, per from rules where status='A' and deptid=".\Session::get('dept');
        else
            $query = "select rulename, sql, per from rules where status='A' and deptid=".$id;
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }
    public function getRulesTwo($id='')
    {
        if($id=='')
            $query = "select status, id, rulename, sql, per from rules where deptid=".\Session::get('dept');
        else
            $query = "select status, id, rulename, sql, per from rules where deptid=".$id;
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getDoctor($id='')
    {
        if($id=='')
            $query = "select d.id, d.doctor from doctors inner JOIN folders f on f.doctor=d.id where f.clientid=".\Session::get('dept');
        else
            $query = "select d.id, d.doctor from doctors inner JOIN folders f on f.doctor=d.id where f.clientid=".$id;
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getPricelist()
    {
        $query = "select DISTINCT p.id, d.dept from pricelists p inner join departments d on p.dept=d.id inner join userdept u on u.dept = d.id where p.status='A' and u.usernam='".\Session::get('login')."'";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getDraft($folderno)
    {
        $query = "SELECT a.FOLDERNO, a.LOGDATE, a.LOGUSER, a.PID, a.SURNAME, a.NAME, a.PATRONYMIC, a.DATE_BIRTH, d.DOCTOR, dep.dept, a.COST, a.DISCOUNT FROM FOLDERS a left join doctors d on d.id=a.doctor inner join departments dep on dep.id = a.clientid where folderno='".$folderno."'";
        $stmt = $this->queryDB($query);
        $rw = ibase_fetch_assoc($stmt);
        return $rw;
    }

    public function getOrder($folderno)
    {
        $query = "SELECT distinct fc.CONTAINERNO, p.CODE, p.PANEL, m.MATTYPE, cg.CONTGROUP, s.CODE, s.NAME ";
        $query.= "FROM folders f ";
        $query.= "inner join orders o on o.FOLDERNO = f.FOLDERNO ";
        $query.= "left join ordtask ot on ot.ORDERSID=o.ID ";
        $query.= "left join foldercontainers fc on fc.ID=ot.CONTAINERID ";
        $query.= "left join PANELS p on p.CODE=o.PANEL ";
        $query.= "left join MATTYPES m on m.ID=fc.MATTYPEID ";
        $query.= "left join CONTGROUPS cg on cg.ID=fc.CONTAINERTYPEID ";
        $query.= "left join SERVICES s on s.ID=o.SERVICEID and s.DEPTID=f.CLIENTID ";
        $query.= "where o.apprsts!='R' and f.FOLDERNO='$folderno' ";
        $res = $this->getResult($this->queryDB($query));
        return $res;
    }

    public function getLabel($id)
    {
       $query = " select distinct fc.containerno, cg.contgroup, f.surname || coalesce(' ' || f.name, '') || coalesce(' ' || f.patronymic, '') ";
       $query.= " from foldercontainers fc  ";
       $query.= " inner join contgroups cg on cg.id = fc.containertypeid ";
       $query.= " inner join folders f on f.folderno = fc.folderno ";
       $query.= " inner join ordtask ot on ot.CONTAINERID=fc.ID";
       $query.= " inner join orders o on o.id = ot.ORDERSID";
       $query.= " where o.apprsts!='R' and fc.folderno='$id'";
        //dd($query);
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getAct($id)
    {
        $query = " select distinct f.SURNAME, f.NAME, f.PATRONYMIC, d.DEPT, p.MEDAN, p.PANEL, p.DUE, fc.CONTAINERNO, cg.CONTGROUP, f.LOGDATE, f.DATE_BIRTH, f.COMMENTS, doc.DOCTOR, f.gender";
        $query.= " from folders f";
        $query.= " inner join foldercontainers fc on fc.FOLDERNO=f.FOLDERNO";
        $query.= " inner join ordtask ot on ot.CONTAINERID=fc.ID";
        $query.= " inner join orders o on o.id = ot.ORDERSID";
        $query.= " inner join PRICES p on p.PANEL = o.PANEL and p.pricelistid=f.pricelistid";
        $query.= " left join doctors doc on doc.id=f.doctor";
        $query.= " inner join CONTGROUPS cg on cg.ID = fc.CONTAINERTYPEID";
        $query.= " inner join DEPARTMENTS d on d.id = f.CLIENTID";
        $query.= " where o.apprsts!='R' and f.folderno = '".$id."'";
        $stmt = $this->queryDB($query);
        $res = $this->getResult($stmt);
        return $res;
    }

    public function getProc()
    {
        $query = "select distinct f.folderno, f.SURNAME, f.NAME, f.PATRONYMIC, s.CODE, s.NAME, p.CODE, p.PANEL, fc.CONTAINERNO, c.CONTGROUP, m.MATTYPE ";
        $query.= "from FOLDERS f ";
        $query.= "inner join ORDERS o on o.FOLDERNO=f.FOLDERNO ";
        $query.= "left join SERVICES s on s.ID=o.SERVICEID and s.DEPTID=f.CLIENTID ";
        $query.= "left join ORDTASK ord on ord.ORDERSID=o.ID ";
        $query.= "left join FOLDERCONTAINERS fc on fc.ID=ord.CONTAINERID ";
        $query.= "left join MATTYPES m on m.ID=fc.MATTYPEID ";
        $query.= "left join CONTGROUPS c on c.ID=fc.CONTAINERTYPEID ";
        $query.= "left join PANELS p on p.CODE=o.PANEL ";
        $query.= "where o.STATUS!='R' and f.apprsts='D' and f.clientid=".\Session::get('dept');
        $query.= "order by p.panel";
        return $this->getResult($this->queryDB($query));
    }

    public function editReg($id)
    {
        $query = "select f.surname, f.kcode, f.name, f.patronymic, f.pid, f.date_birth, f.clientid, f.address, f.passport_number,";
        $query.= "f.passport_series, f.phone, f.email, f.gender, d.doctor, f.comments, f.pregnancy, f.pricelistid, f.discount, ";
        $query.= "f.s_sms, f.s_email, f.prime, f.doc, f.cash, f.issued, f.cardno, f.backref, f.ais, f.org, f.str, f.cito, ";
        $query.= "f.cost, f. nacph, f.price, rn1, rn2, rn3, f.doctor, f.height, f.weight, f.polis, f.antibiot, f.antibiotic, f.biostart, f.bioend";
        $query.= " from folders f";
        $query.= " left join doctors d on d.id = f.doctor";
        $query.= " where f.folderno='$id'";
        $res = $this->getResult($this->queryDB($query));
        return $res;
    }

    public function editPanels($id)
    {
        $query  = "select distinct p.CODE, p.PANEL, p.MATS, o.PRICE, o.NACPH, s.CODE, s.NAME, f.mattypeid ";
        $query .= "from ORDERS o ";
        $query .= "left join PANELS p on o.panel=p.code ";
        $query .= "left join ORDTASK od on od.ordersid=o.id ";
        $query .= "left join FOLDERCONTAINERS f on f.id=od.containerid ";
        $query .= "left join SERVICES s on o.SERVICEID=s.ID ";
        $query .= "where o.apprsts!='R' and o.folderno = '$id'";
        return $this->getResult($this->queryDB($query));
    }

    public function detal()
    {
        if (\Input::has('date_st'))
            $date_st = \Input::get('date_st');
        else $date_st = date('Y-m-d', strtotime("-3 days"));
        if (\Input::has('date_en'))
            $date_en = \Input::get('date_en');
        else $date_en = date('Y-m-d');
        if (\Input::has('client'))
            $client = \Input::get('client');
        else $client = '';
        $query = 'select f.logdate, d.dept, f.folderno, f.surname, f.name, f.patronymic, f.discount, p.code, p.panel, o.nacph, o.price, o.cost, s.name, s.code';
        $query.= ' from folders f';
        $query.= ' inner join departments d on d.id=f.clientid';
        $query.= ' inner join orders o on f.folderno=o.folderno';
        if(\Input::has('type') && \Input::get('type')=='s')
            $query.= ' inner join services s on s.id=o.serviceid';
        else
            $query.= ' left join services s on s.id=o.serviceid';
        if(\Input::has('type') && \Input::get('type')=='n')
            $query.= ' inner join panels p on p.code=o.panel';
        else
            $query.= ' left join panels p on p.code=o.panel';
        if($client!=='' && $client!=='all')
            $query.= " where d.id=".$client;
        else {
            $query.= " inner join userdept u on u.dept = d.id";
            $query.= " where u.usernam='".\Session::get('login')."'";
        }
        $query.= " and f.apprsts!='R' and f.apprsts!='D' and f.logdate >= '".$date_st."' and f.logdate <= '".$date_en."'";
        return $this->getResult($this->queryDB($query));
    }

    public function getOrdtask($id)
    {
        $query = "SELECT distinct r.FINALRESULT,r.CHARLIMITS,r.UNIT,r.STATUS, p.PANEL, p.CODE, ord.APPRSTS, a.ANALYTE, s.STATUSCOLOR, s.STATUSNAME, t.testname ";
        $query.= "from ORDERS ord ";
        $query.= "inner join ORDTASK o on ord.ID=o.ORDERSID ";
        $query.= "left join RESULTS r on o.ID=r.ORDTASKID ";
        $query.= "inner join PANELS p on p.CODE=ord.PANEL ";
        $query.= "left join tests t on t.id=o.testcode and r.testid=t.id ";
        $query.= "left join ANALYTES a on a.testcode=t.id and a.id=r.analyteid ";
        $query.= "inner join STATUSES s on s.STATUS=ord.APPRSTS ";
        $query.= "where ord.apprsts!='R' and ord.FOLDERNO='$id' ";
        $query.= "order by a.ANALYTE ";
        return $this->getResult($this->queryDB($query));
    }

    public function getStatistic($id)
    {
        if (\Input::has('date_st'))
            $date_st = \Input::get('date_st');
        else $date_st = date('Y-m-d', strtotime("-3 days"));
        if (\Input::has('date_en'))
            $date_en = \Input::get('date_en');
        else $date_en = date('Y-m-d');
        switch ($id){
            case 0:
                $query = "SELECT distinct p.CODE, p.PANEL, s.CODE, s.NAME, s.PRICE, a.COST, a.LOGDATE, a.FOLDERNO , a.NACPH, a.DISCOUNT, d.DEPT ";
                $query.= "FROM ORDERS a ";
                $query.= "inner join FOLDERS f on f.FOLDERNO=a.FOLDERNO ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                $query.= "left join panels p on p.CODE=a.PANEL  ";
                $query.= "left join SERVICES s on s.id = a.SERVICEID and s.DEPTID=d.id ";
                break;
            case 1:
                $query = "select distinct d.DEPT, f.PRIME ";
                $query.= "from folders f ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                break;
            case 2:
                $query = "select distinct s.PRICE, o.PRICE, o.COST, o.NACPH, o.DISCOUNT, d.DEPT ";
                $query.= "from folders f ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                $query.= "inner join ORDERS o on o.FOLDERNO=f.FOLDERNO ";
                $query.= "left join SERVICES s on s.id = o.SERVICEID and s.deptid=f.clientid ";
                break;
            case 3:
                $query = "select distinct s.PRICE, o.COST, dc.DOCTOR ";
                $query.= "from folders f ";
                $query.= "left join DOCTORS dc on f.DOCTOR=dc.ID ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                $query.= "inner join ORDERS o on o.FOLDERNO=f.FOLDERNO ";
                $query.= "left join SERVICES s on s.id = o.SERVICEID and s.deptid=d.id ";
                break;
            case 4:
                $query = "select distinct d.DEPT, f.LOGDATE ";
                $query.= "from folders f ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                break;
            case 5:
                $query = "select distinct b.BACK ";
                $query.= "from folders f ";
                $query.= "left join BACKREF b on b.ID=f.BACKREF ";
                $query.= "inner join DEPARTMENTS d on d.ID=f.CLIENTID ";
                break;
        }
        if(\Input::has('dept')){
            if(\Input::get('dept')=='all') {
                $query.= "inner join userdept u on u.dept = d.id ";
                $query .= "where f.APPRSTS!='R' and f.APPRSTS!='D' and f.logdate >= '" . $date_st . "' and f.logdate <= '" . $date_en . "' and u.usernam='".\Session::get('login')."'";
            } else
                $query.= "where f.APPRSTS!='R' and f.APPRSTS!='D' and f.logdate >= '".$date_st."' and f.logdate <= '".$date_en."' and d.id='".\Input::get('dept')."'";
            return $this->getResult($this->queryDB($query));
        }
    }

    public function getBackref()
    {
        $query = "select id, back from backref";
        return $this->getResult($this->queryDB($query));
    }

    public function getUsers()
    {
        $query = "select u.usernam, ur.roleid, u.fullname, u.status, u.password3, d.dept from users u ";
        $query.= "inner join userdept ud on ud.usernam=u.usernam ";
        $query.= "inner join userroles ur on ur.usernam=u.usernam ";
        $query.= "inner join departments d on ud.dept=d.id ";
        $query.= "where d.id in (select udp.dept from userdept udp where udp.usernam='".\Session::get('login')."')";
        return $this->getResult($this->queryDB($query));
    }

    public function getLPU()
    {
        $query = "select d.dept, d.deptcode, ur.roleid, us.usernam, us.password3 from users us ";
        $query.= "left join userdept u on us.usernam=u.usernam ";
        $query.= "left join departments d on u.dept=d.id ";
        $query.= "inner join userroles ur on us.usernam=ur.usernam ";
        $query.= "where us.status='A' order by d.deptcode";
        return $this->getResult($this->queryDB($query));
    }

    public function getLPUNumbers()
    {
        $query = "select distinct deptcode from departments where status='Y'";
        return $this->getResult($this->queryDB($query));
    }

    public function getContainers()
    {
        $query = "select id,contgroup from contgroups";
        return $this->getResult($this->queryDB($query));

    }

    protected function getPR()
    {
        $query = "select DISTINCT p.panel, p.code, m.mattype, c.contgroup,pc.preanalitic_id, s.samplingrule from panels p ";
        $query.= "inner join panel_containers pc on pc.panel=p.code ";
        $query.= "left join mattypes m on pc.mattype_id=m.id ";
        $query.= "left join contgroups c on pc.contgroupid=c.id ";
        $query.= "left join samplingrules s on pc.samplingsrules_id=s.id ";
        $query.= "where pc.preanalitic_id is null or pc.mattype_id is null or pc.contgroupid is null order by p.code";
        return $this->getResult($this->queryDB($query));
    }

    protected function getMenu(){
        $query = "select r.rolename, m.caption, mr.available from modules m ";
        $query.= "inner join modulerole mr on m.id=mr.moduleid ";
        $query.= "inner join roles r on mr.roleid=r.id order by m.caption";
        return $this->getResult($this->queryDB($query));
    }
    protected function getMenuCategory() {
        $query = "select menu,id from menucategory";
        return $this->getResult($this->queryDB($query));
    }
}