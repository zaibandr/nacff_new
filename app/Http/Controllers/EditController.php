<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FuncController as Func;
use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\Input;

class EditController extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = true;
        //dd(Input::all());
        if (Input::has("surname")) {
            $surname = mb_strtoupper(Func::m_quotes(Input::get("surname")));
            //$surname = preg_replace("/([\s\x{0}\x{0B}]+)/i", " ", trim($surname));
        }
        if (Input::has("name")) {
            $name = mb_strtoupper(Func::m_quotes(Input::get("name")));
            // $name = preg_replace("/([\s\x{0}\x{0B}]+)/i", " ", trim($name));
        }
        if (Input::has("namepatr")) {
            $namepatr = mb_strtoupper(Func::m_quotes(Input::get("namepatr")));
            // $namepatr = preg_replace("/([\s\x{0}\x{0B})+)/i", " ", trim($namepatr));
        } else $namepatr = '';
        if (Input::has("doctorId")) $doctor = (int)(Input::get("doctorId")); else $doctor = 'null';
        if (Input::get("doctorId")=='' && Input::get('doctorName')!==''){
            $e = $this->getResult($this->queryDB("insert into doctors(doctor) VALUES ('".Input::get("doctorName")."') returning id"));
            $doctor = $e[0]['ID'];
        }
        if (Input::has("polis")) $policy = mb_strtoupper(Func::m_quotes(Input::get("polis"))); else $policy = 'null';
        if (Input::has("str")) $insurer = mb_strtoupper(Func::m_quotes(Input::get("str"))); else $insurer = "N/A";
        if (Input::has("sex")) $gender = Func::m_quotes(Input::get("sex"));
        if (Input::has("cito")) $cito = Func::m_quotes(Input::get("cito")); else $cito = '';
        if (Input::has("s_b")) $pregnancy = Func::m_quotes(Input::get("s_b")); else $pregnancy = 'null';
        switch ($pregnancy) {
            case -1:
                $pregnancy = 'null';
                break;
        }
        if (Input::has("f_c")) {
            $phase = Func::m_quotes(Input::get("f_c"));
            switch ($phase) {
                case "-1":
                    $phase = "";
                    break;
            }
        } else $phase = '';
        if (Input::has("b_d")) $dt_bday = Func::m_quotes(date("Y/n/j", strtotime(Input::get("b_d")))); else $dt_bday = '';
        if (Input::has("comments")) $comments = Func::m_quotes(Input::get("comments")); else $comments = '';
        $dt_take =date("Y/n/j G:i");
        if (Input::has("diagnoz")) $diagnosis = Func::m_quotes(Input::get("diagnoz")); else $diagnosis = '';
        if (Input::has("phone")) $phone = Func::m_quotes(Input::get("phone")); else $phone = '';
        if (Input::has("diarez")) $diuresis = Func::m_quotes(trim(Input::get("diarez")) * 1.0); else $diuresis = '';
        if (Input::has("antib")) {
            $antibiot = "Y";
            if (Input::has("prob")) $antibiotics = Func::m_quotes(Input::get("prob")); else $antibiotics = '';
            if (Input::has("antib_s")) $dt_biostart = "'".Func::m_quotes(date("Y/n/j", strtotime(Input::get("antib_s"))))."'"; else $dt_biostart = 'null';
            if (Input::has("antib_e")) $dt_bioend = "'".Func::m_quotes(date("Y/n/j", strtotime(Input::get("antib_e"))))."'"; else $dt_bioend = 'null';
        } else {
            $antibiot = '';
            $antibiotics = '';
            $dt_biostart = 'null';
            $dt_bioend = 'null';
        }
        if (Input::has("s_p")) $passport_series = Func::m_quotes(Input::get("s_p")); else $passport_series = '';
        if (Input::has("n_p")) $passport_number = Func::m_quotes(Input::get("n_p")); else $passport_number = '';
        if (Input::has("email")) $email = Func::m_quotes(Input::get("email")); else $email = '';
        if (Input::has("s_email")) $s_email = 'Y'; else $s_email = 'N';
        if (Input::has("s_sms")) $s_sms = 'Y'; else $s_sms = 'N';
        if (Input::has("prime")) $prime = Func::m_quotes(Input::get("prime"));
        if (Input::has("AIS")) $ais = Func::m_quotes(Input::get("AIS")); else $ais = 'null';
        if (Input::has("org")) $org = Func::m_quotes(Input::get("org")); else $org = '';
        if (Input::has("address")) $address = Func::m_quotes(Input::get("address")); else $address = '';
        if (Input::has("weight")) $weight = Func::m_quotes(Input::get("weight")); else $weight = 'null';
        if (Input::has("height")) $height = Func::m_quotes(Input::get("height"));else $height = 'null';
        if (Input::has("backref")) $backref = Func::m_quotes(Input::get("backref"));else $backref = 'null';
        if (Input::has("issued")) $issued = Func::m_quotes(Input::get("issued"));else $issued = '';
        if (Input::has("docc")) $docc = Func::m_quotes(Input::get("docc"));else $docc = '';
        if (Input::has("otd")) $department = Func::m_quotes(Input::get("otd"));
        if (Input::has("n_k")) $card = Func::m_quotes(Input::get("n_k")); else $card = '';
        if (Input::has("fullCost")) $cost =(int) Func::m_quotes(Input::get("fullCost")); else $cost = 'null';
        if (Input::has("price")) $priceid = (int)Func::m_quotes(Input::get("price")); else $priceid= '';
        if (Input::has("discount")) $dis = (int)Func::m_quotes(Input::get("discount")); else $dis= 'null';
        if (Input::has("discount2")) $dis2 = (int)Func::m_quotes(Input::get("discount2")); else $dis2= 0;
        if (Input::has("nacpp")) $ncost =(int) Func::m_quotes(Input::get("nacpp")); else $ncost= 'null';
        if (Input::has("cash")) $cash = Input::get("cash");
        if (Input::has("kk")) $kk = (int)Input::get("kk"); else $kk = 'null';
        if (Input::has("panels")) $panels = explode(",",substr(Input::get("panels"),0,-1)); else $panels= 'null';

        $age = Func::age($dt_bday); $fullcost = $cost + $dis;
        if (Input::has("oldcost")) $oldcost =(int) Func::m_quotes(Input::get("oldcost")); else $oldcost= 0;
        if (Input::has('pid')) $pid = Func::m_quotes(Input::get("pid"));
        if (Input::has('folderno')) $folderno = Func::m_quotes(Input::get("folderno"));
        $query = "update patient set surname='".$surname."' , name='".$name."' , patronymic='".$namepatr."' ";
        $query.= ", gender='".$gender."' , DATE_BIRTH='".$dt_bday."' , ADDRESS='".$address."' , ";
        $query.= "PASSPORT_SERIES='".$passport_series."' , PASSPORT_NUMBER='".$passport_number."' , PHONE='";
        $query.= $phone."' , EMAIL='".$email."' , LOGUSER='".mb_strtoupper(\Session::get('login'))."' , bill=bill+".$cost."-".$oldcost." where pid='".$pid."'";
        $a = $this->queryDB($query) or die(ibase_errmsg());
        $query = "update FOLDERS set LOGUSER='".\Session::get('login')."', SURNAME='".$surname."', NAME='".$name."', PATRONYMIC='".$namepatr."', DATE_BIRTH='".$dt_bday."', ADDRESS='".$address;
        $query.= "', S_SMS='".$s_sms."', S_EMAIL='".$s_email."', PRIME='".$prime."', AIS=".$ais.", ORG='".$org;
        $query.= "', BACKREF=".$backref.", ISSUED='".$issued."', DOC='".$docc."', CARDNO='".$card."', CASH='".$cash;
        $query.= "', LOGDATE='".$dt_take."', POLIS=".$policy.", CITO='".$cito."', STR='".$insurer."', ANTIBIOT='".$antibiot;
        $query.= "', ANTIBIOTIC='".$antibiotics."', BIOSTART=".$dt_biostart.", BIOEND=".$dt_bioend.", HEIGHT=".$height.", WEIGHT=".$weight;
        $query.= ", PASSPORT_SERIES='".$passport_series."', PASSPORT_NUMBER='".$passport_number."', PHONE='".$phone."', EMAIL='".$email."', GENDER='".$gender;
        $query.= "', DOCTOR=".$doctor.", COMMENTS='".$comments."', PREGNANCY=".$pregnancy.", AGE=".$age.", PRICELISTID=".$priceid.", COST=".$cost.", NACPH=".$ncost.", PRICE=".$fullcost;
        $query.= ", DISCOUNT=".$dis2.", rn1='".$diuresis."', rn2='".$diagnosis."', rn3='".$phase."', KCODE=".$kk." where folderno='$folderno'";
        $stmt = $this->queryDB($query) or die(ibase_errmsg());
        $query = "select panel from orders where apprsts!='R' and folderno='$folderno'";
        $stmt = $this->getResult($this->queryDB($query));
        foreach($stmt as $val)
            $oldPanels[] = $val['PANEL'];
        $arr = array_diff($panels, $oldPanels);
        if(count($arr)>0) {
            foreach ($arr as $value) {
                $query = "select p.panel from prices p inner join pricelists pr on pr.id=p.pricelistid where pr.status='A' and p.panel='$value' and pr.id=" . $priceid;
                $res = $this->getResult($this->queryDB($query));
                if (count($res) > 0) {
                    $query = "select comments from ADD_PANEL('$folderno','$value','" . \Session::get('login') . "',$dis2)";
                    $stmt = $this->queryDB($query);
                    while ($row = ibase_fetch_assoc($stmt))
                        $c = $row['COMMENTS'];
                    if(Input::has(str_replace('.','_',$value)))
                    {
                        $res = $this->getResult($this->queryDB("select o.containerid from ordtask o inner join orders ord on ord.id=o.ordersid where ord.folderno='$folderno' and ord.panel='$value'"));
                        $this->queryDB("update foldercontainers set mattypeid=".Input::get(str_replace('.','_',$value))." where id=".$res[0]['CONTAINERID']);
                    }
                } else {
                    $res = $this->getResult($this->queryDB("select id, price from services where code='$value' and deptid=$department"));
                    $costA = $res[0]['PRICE'] * (100 - $dis2) / 100;
                    $query = "insert into orders(discount, loguser, folderno, serviceid, price, cost) VALUES ($dis2,'" . \Session::get('login') . "', '$folderno', " . $res[0]['ID'] . "," . $res[0]['PRICE'] . ", $costA )";
                    $res = $this->queryDB($query);
                }
            }
            if ($res !== 'OK')
                $c = false;
        } else {
           foreach($panels as $value){
               if(Input::has(str_replace('.','_',$value)))
               {
                   $res = $this->getResult($this->queryDB("select o.containerid from ordtask o inner join orders ord on ord.id=o.ordersid where ord.folderno='$folderno' and ord.panel='$value'"));
                   $this->queryDB("update foldercontainers set mattypeid=".Input::get(str_replace('.','_',$value))." where id=".$res[0]['CONTAINERID']);
               }
           }
        }
        $arr = array_diff($oldPanels, $panels);
        if(count($arr)>0) {
            foreach ($arr as $value) {
                $query = "update orders set apprsts='R' where folderno='$folderno' and panel='$value'";
                if (!$this->queryDB($query))
                    $c = false;
            }
        }
        if($c!==false) {
            echo "<script>$('#folderno').html('" . $folderno . "');</script>";
            echo "<img style=\"vertical-align: inherit; margin:0px; border:0\" src=\"images/ok.jpg\" /><b>Заявка была успешно сохранена под номером #" . $folderno . "</b>";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $folders = $this->editReg($id);
        $panels = $this->editPanels($id);
        //dd($panels);
        foreach($panels as $val)
        {
            if(isset($val['PANEL'])) {
                $mats = '';
                $code = str_replace('.', '', $val['CODE']);
                if (!is_null($val['MATS'])) {
                    $mat = "<span id='additional%s' style='margin-left:35px; display:block'>" .
                        "<table class='bio'>" .
                        "<tr><td colspan='2'>БИОМАТЕРИАЛ:<br/>%s </td></tr>" .
                        "</table>" .
                        "</span>";
                    $mat1 = "<select disabled='disabled' style='width:300px;' id='m" . $code . "' name='" . $val["CODE"] . "' onchange='setBio( this.value , " . $code . " )' >";
                    $mat1 .= "<option value='70'></option>";
                    $arr = explode(";", $val["MATS"]);
                    $string = "'" . $arr[0] . "'";
                    for ($j = 1; $j < count($arr); $j++)
                        $string .= ",'" . $arr[$j] . "'";
                    $rs2 = $this->queryDB("SELECT ID, MATTYPE FROM MATTYPES WHERE ID IN (" . $string . ")");
                    while ($row2 = ibase_fetch_assoc($rs2)) {
                        $mat1 .= "<option value='" . $row2["ID"] . "'>" . $row2["MATTYPE"] . "</option>";
                    }
                    $mat1 .= "</select>";
                    $mats = sprintf($mat, $id, $mat1);
                }
                $str = ['color' => '', 'cost' => $val['PRICE'], 'ncost' => $val['NACPH'], 'bioset' => $val['MATTYPEID'], 'biodef' => '', 'icon' => '', 'title' => '  [' . $val['CODE'] . ']  ' . $val['PANEL'] . '  (' . $val['PRICE'] . ')' . $mats, 'id' => $code, 'value' => $val['CODE'], 'code' => $val['CODE']];
                $a[] = json_encode($str);
            } else {
                $code = str_replace('.', '', $val['CODE_01']);
                $str = ['color' => '', 'cost' => $val['PRICE'], 'ncost' => 0, 'bioset' => '', 'biodef' => '', 'icon' => '', 'title' => '  [' . $val['CODE_01'] . ']  ' . $val['NAME'] . '  (' . $val['PRICE'] . ')' , 'id' => $code, 'value' => $val['CODE_01'], 'code' => $val['CODE_01']];
                $a[] = json_encode($str);
            }
        }
        //dd($a);
        $pricelist = $this->getPricelist();
        return \View::make('edit')->with([
            'id'=>$id,
            'folders'=>$folders,
            'pricelist'=>$pricelist,
            'panels'=>$a,
            'backref' => $this->getBackref(),
            'depts' => $this->getDepts(),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
