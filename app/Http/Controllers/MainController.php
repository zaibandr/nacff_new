<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 12.01.2016
 * Time: 11:17
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\DBController as DB;
use App\Http\Controllers\FuncController as Func;
use Maatwebsite\Excel\Facades\Excel;
use Khill\Lavacharts\Lavacharts;
use sngrl\SphinxSearch\SphinxSearch;


class MainController extends DB
{
    public function index(){
        //dd($a);
        return View::make('main');
    }
    //  Справочники ЛИС
    public function page55(){
        $panels = $this->getPanel();
        $mattypes = $this->getMattype();
        $pconts = $this->getPCont();
        return View::make('SLis')->with([
            'panels'=>$panels,
            'mattypes'=>$mattypes,
            'pconts'=>$pconts,
            'tests'=>$this->getTests()
        ]);
    }

    public function page61(){
        $error = '';
        if(Input::has('search')) {
            $sphinx = new SphinxSearch();
            $string = "'*" . trim(Input::get('search')) . "*'";
            $result = $sphinx->search($string)->get();
            $error = "Результат поиска пуст";
            $b = [];
            if (isset($result['matches'])) {
                foreach ($result['matches'] as $k => $v) {
                    $res = $this->queryDB("select logdate, username, caption, body from letters where flag=1 and id=$k");
                    $row = $this->getResult($res);
                    if (count($row) > 0) {
                        $b[] = $row[0];
                        $b[count($b) - 1]['BODY'] = strip_tags($row[0]['BODY'], '<ul><b><i>');
                        $error = '';
                    }
                }
            }
        } else {
            $res = $this->queryDB("select logdate, username, caption, body from letters where flag=1 order by logdate");
            while($row=ibase_fetch_assoc($res)) {
                $row['BODY'] = strip_tags($row['BODY'], '<ul><b><i>');
                $b[] = $row;
            }
        }
        return View::make('info')->with([
           'error' => $error,
           'res' => $b
        ]);
    }
    //  Прайс-листы
    public function page50(){
        if(Input::has('code')){
            $id = $this->getResult($this->queryDB("select id from pricelists where status='A' and dept=".Input::get('dept')));
            $this->queryDB("update prices p set p.medan='".Input::get('panel')."', p.cost=".Input::get('cost')." where p.pricelistid=".$id[0]['ID']." and p.panel='".Input::get('code')."'");

        }
        if(Input::hasFile('excel')){
            $excel = [];
            $e = Excel::load(Input::file('excel'), function($reader) use ($excel) {});
            $objExcel = $e->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++)
            {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $excel = $rowData[0];
                if(!empty($excel[0])) {
                    $query = "update prices p set p.medan='" . $excel[1] . "', p.cost=" . $excel[2] . " where p.pricelistid=(select pr.id from pricelists pr where pr.status='A' and pr.dept=" . Input::get('price') . ") and p.panel='" . $excel[0] . "'";
                    //dd($query);
                    $this->queryDB($query);
                }
            }
        }
        return View::make('Prices')->with([
            'prices'=>$this->getPrices(),
            'depts'=>$this->getDepts()
        ]);
    }
    //  Список пациентов
    public function page51(){
        //dd($this->getPatient());
        return View::make('Patients')->with([
            'patients'=>$this->getPatient()
        ]);
    }
    //  Услуни ЛПУ
    public function page53()
    {
        return View::make('services')->with([
           'services'=>$this->getServices() ,
            'depts'=>$this->getDepts()
        ]);
    }
    //  Направления
    public function page43(){
        $folders = $this->getFolders();
        $depts = $this->getDepts();
        if(Input::has('excel') && Input::get('excel')==1) {
            Excel::create('newFile', function ($excel) use ($folders) {
                $excel->sheet('firstSheet', function ($sheet) use ($folders) {
                    $sheet->loadView('excels.folders')->with([
                        'folders' => $folders
                    ]);
                });
            })->export('xls');
            Input::merge(['excel'=>0]);
        }
        return View::make('Requests')->with([
            'folders' => $folders,
            'depts' => $depts,
            'browser' => Func::getBrowser()
        ]);
    }
    //  Регистратура
    public function page45(){
        if(Input::has('save')) {
            //dd(Input::all());
            if (Input::has("panels")) $panels = Func::m_quotes(substr(Input::get('panels'), 0, -1));
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
            if (Input::has("doctor")) $doctor = (int)(Input::get("doctor")); else $doctor = 'null';
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
            if (Input::has("dt_catched")) $dt_take = Func::m_quotes(date("Y/n/j G:i", strtotime(Input::get("dt_catched")))); else $dt_take = '';
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
            if (Input::has("p_s")) $passport_series = Func::m_quotes(Input::get("p_s")); else $passport_series = '';
            if (Input::has("p_n")) $passport_number = Func::m_quotes(Input::get("p_n")); else $passport_number = '';
            if (Input::has("email")) $email = Func::m_quotes(Input::get("email")); else $email = '';
            if (Input::has("s_email")) $s_email = 'Y'; else $s_email = 'N';
            if (Input::has("s_sms")) $s_sms = 'Y'; else $s_sms = 'N';
            if (Input::has("prime")) $prime = Func::m_quotes(Input::get("prime"));
            if (Input::has("AIS")) $ais = Func::m_quotes(Input::get("AIS")); else $ais = 'null';
            if (Input::has("otd")) $department = Func::m_quotes(Input::get("otd")); else $department = 'null';
            if (Input::has("org")) $org = Func::m_quotes(Input::get("org")); else $org = '';
            if (Input::has("address")) $address = Func::m_quotes(Input::get("address")); else $address = '';
            if (Input::has("weight")) $weight = Func::m_quotes(Input::get("weight")); else $weight = 'null';
            if (Input::has("height")) $height = Func::m_quotes(Input::get("height"));else $height = 'null';
            if (Input::has("backref")) $backref = Func::m_quotes(Input::get("backref"));else $backref = 'null';
            if (Input::has("issued")) $issued = Func::m_quotes(Input::get("issued"));else $issued = '';
            if (Input::has("docc")) $docc = Func::m_quotes(Input::get("docc"));else $docc = '';
            if (Input::has("n_k")) $card = Func::m_quotes(Input::get("n_k")); else $card = '';
            if (Input::has("fullCost")) $cost =(int) Func::m_quotes(Input::get("fullCost")); else $cost = 'null';
            if (Input::has("price")) $priceid = (int)Func::m_quotes(Input::get("price")); else $priceid= '';
            if (Input::has("discount")) $dis = (int)Func::m_quotes(Input::get("discount")); else $dis= 'null';
            if (Input::has("discount2")) $dis2 = (int)Func::m_quotes(Input::get("discount2")); else $dis2= 0;
            if (Input::has("nacpp")) $ncost =(int) Func::m_quotes(Input::get("nacpp")); else $ncost= 'null';
            if (Input::has("cash")) $cash = (int) Input::get("cash");
            if (Input::has("panels")) $panels = explode(",",substr(Input::get("panels"),0,-1)); else $panels= 'null';
            $age = Func::age($dt_bday); $fullcost = $cost + $dis;
            $pid = Input::get('pid','');
         /*   if (Input::has('pid') && Input::get('pid')!='')
            {
                $pid = Input::get('pid');
                $query = "update patient set surname='".$surname."' , name='".$name."' , patronymic='".$namepatr."' ";
                $query.= ", gender='".$gender."' , DATE_BIRTH='".$dt_bday."' , ADDRESS='".$address."' , ";
                $query.= "PASSPORT_SERIES='".$passport_series."' , PASSPORT_NUMBER='".$passport_number."' , PHONE='";
                $query.= $phone."' , EMAIL='".$email."' , LOGUSER='".mb_strtoupper(\Session::get('login'))."' , bill=bill+".$cost." where pid='".$pid."'";
                $stmt = $this->queryDB($query);
                if($stmt===false)
                    return 'Ошибка сохранения пациента';
            } else {
                $query = "INSERT INTO PATIENT (SURNAME, NAME, PATRONYMIC, GENDER, DATE_BIRTH, ADDRESS, PASSPORT_SERIES, PASSPORT_NUMBER, PHONE, EMAIL, LOGUSER, BILL) ";
                $query.= "VALUES('$surname', '$name', '$namepatr', '$gender', '$dt_bday', '$address', '$passport_series', '$passport_series', '$phone', '$email','".\Session::get('login')."', $cost)";
                $stmt = $this->queryDB($query);
                if($stmt===false)
                    return 'Ошибка сохранения пациента';
                $query = "select first 1 pid from PATIENT order by logdate desc";
                $stmt = $this->queryDB($query);
                if($stmt===false)
                    return 'Ошибка сохранения пациента';
                $res = $this->getResult($stmt);
                $pid = $res[0]['PID'];
            }*/
            $query = "delete from pool rows 1 returning folderno ";
            $stmt = ibase_query($query);
            $res = ibase_fetch_assoc($stmt);
            $folderno = $res['FOLDERNO'];
            $query = "INSERT INTO FOLDERS (FOLDERNO, LOGUSER, PID, SURNAME, NAME, PATRONYMIC, DATE_BIRTH, ";
            $query.= "ADDRESS, PASSPORT_SERIES, PASSPORT_NUMBER, PHONE, EMAIL, GENDER, CLIENTID, DOCTOR, COMMENTS, ";
            $query.= "PREGNANCY, AGE, PRICELISTID, S_SMS, S_EMAIL, COST, PRIME,NACPH, PRICE, DISCOUNT, CASH, DOC, ";
            $query.= "ISSUED, CARDNO, BACKREF, rn1, rn2, rn3, AIS, ORG, STR, CITO, HEIGHT, WEIGHT, POLIS, ANTIBIOT, ANTIBIOTIC, BIOSTART, BIOEND)";
            $query.= " VALUES ('$folderno','".\Session::get('login')."', '$pid', '$surname', '$name', '$namepatr', ";
            $query.= "'$dt_bday', '$address', '$passport_series', '$passport_number', '$phone', '$email', '$gender', ";
            $query.= "$department, $doctor, '$comments', $pregnancy, $age, $priceid,'$s_sms', '$s_email', $cost, '$prime', ";
            $query.= "$ncost, $fullcost, $dis2, '$cash', '$docc', '$issued', '$card', $backref, '$diuresis', '$diagnosis', ";
            $query.= "'$phase', $ais, '$org', '$insurer', '$cito',  $weight, $height, $policy, '$antibiot', '$antibiotics', $dt_biostart,$dt_bioend)";
            $stmt = $this->queryDB($query);
            if ($stmt === false) echo "Error in executing query.</br>"; else {

                foreach($panels as $value){
                    $query = "select p.panel from prices p inner join pricelists pr on pr.id=p.pricelistid where pr.status='A' and p.panel='$value' and pr.id=".$priceid;
                    $res = $this->getResult($this->queryDB($query));
                    if(count($res)>0) {
                        $query = "select comments from ADD_PANEL('$folderno','$value','" . \Session::get('login') . "',$dis2)";
                        $stmt = $this->queryDB($query);
                        while ($row = ibase_fetch_assoc($stmt))
                            $c = $row['COMMENTS'];
                    } else {
                        $res = $this->getResult($this->queryDB("select id, price from services where code='$value' and deptid=$department"));
                        $costA = $res[0]['PRICE']*(100-$dis2)/100;
                        $query = "insert into orders(discount, loguser, folderno, serviceid, price, cost) VALUES ($dis2,'".\Session::get('login')."', '$folderno', ".$res[0]['ID'].",".$res[0]['PRICE'].", $costA )";
                        $res = $this->queryDB($query);

                    }
                }
                if(isset($c) && $c=='OK'){
                    echo "<script>$('#folderno').html('" . $folderno . "');</script>";
                    echo "<img style=\"vertical-align: inherit; margin:0px; border:0\" src=\"images/ok.jpg\" /><b>Заявка была успешно сохранена под номером #" . $folderno . "</b>";
                }
            }
        } else {
            $p = $this->getPatient();
            $pat = '';
            $pricelist = $this->getPricelist();
            foreach ($p as $val) {
                $pat .= "{\"logdate\":\"" . substr($val['LOGDATE'], 0, 10) . "\",";
                $pat .= "\"name\":\"" . $val['SURNAME'] . " " . $val['NAME'] . " " . $val['PATRONYMIC'] . "\",";
                $pat .= "\"label\":\"" . $val['SURNAME'] . "\",";
                $pat .= "\"value\":\"" . $val['SURNAME'] . "\",";
                $pat .= "\"gender\":\"" . $val['GENDER'] . "\",";
                $pat .= "\"dept\":\"" . $val['DEPT'] . "\",";
                $pat .= "\"bd\":\"" . date('d.m.Y', strtotime($val['DATE_BIRTH'])) . "\",";
                $pat .= "\"address\":\"" . $val['ADDRESS'] . "\",";
                $pat .= "\"passport\":\"" . $val['PASSPORT_SERIES'] . " " . $val['PASSPORT_NUMBER'] . "\",";
                $pat .= "\"phone\":\"" . $val['PHONE'] . "\",";
                $pat .= "\"email\":\"" . $val['EMAIL'] . "\",";
                $pat .= "\"pid\":\"" . $val['PID'] . "\"},";
            }
            $pat = substr($pat, 0, -1);
            //dd($pat);
            $depts = $this->getDepts();
            if (count($depts) > 1)
                $web = 1;
            else $web = '';
            //dd($pricelist);
            return View::make('Registration')->with([
                'patients' => $pat,
                'pricelist' => $pricelist,
                'web' => $web,
                'depts' => $depts,
                'backref' => $this->getBackref()
            ]);
        }
    }
    //  Процелурный кабинет
    public function page49()
    {
        if(Input::has('folderno')){
            $this->queryDB("update folders set apprsts='L' where folderno='".Input::get('folderno')."'");
        }
        $proc = $this->getProc();
        $a = [];
        foreach($proc as $val)
        {
            $a[$val['FOLDERNO']]['NAME'] = $val['SURNAME']." ".$val['NAME']." ".$val['PATRONYMIC'];
            if(isset($val['PANEL']))
                $a[$val['FOLDERNO']]['PANEL'][] = $val['CODE_01']." - ".$val['PANEL'];
            else
                $a[$val['FOLDERNO']]['PANEL'][] = $val['CODE']." - ".$val['NAME_01'];
            $a[$val['FOLDERNO']]['CONT'][] = $val['CONTAINERNO'];
            $a[$val['FOLDERNO']]['CONTG'][] = $val['CONTGROUP'];
            $a[$val['FOLDERNO']]['MAT'][] = $val['MATTYPE'];
        }
        return View::make('procedur')->with([
           'proc' => $a
        ]);
    }
    //  Статистика
    public function page59()
    {
        $a = [];
        $pan = [];
        $sum = 0;
        if(Input::has('stat')) {
                switch (Input::get('stat')){
                    case 0:
                        $b = [];
                        $a = $this->getStatistic(0);
                        $b['all'] = 0;
                        foreach ($a as $val) {
                            $key = isset($val['CODE']) ? $val['CODE'] : $val['CODE_01'];
                            if (!array_key_exists($key, $pan)) {
                                //$cost = isset($val['PRICE_01']) ? $val['PRICE_01'] : $val['PRICE'];
                                $cost = $val['COST'];
                                $b[$key] = $cost * (100 - $val['DISCOUNT']) / 100;
                                $b['all'] += $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$key]['panel'] = isset($val['PANEL']) ? $val['PANEL'] : $val['NAME'];
                                $pan[$key]['cost'] = $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$key]['nacff'] = $val['NACPH'];
                                $pan[$key]['dis'] = $cost * ($val['DISCOUNT']) / 100;
                                $pan[$key]['count'] = 1;
                            } else {
                                //$cost = isset($val['PRICE_01']) ? $val['PRICE_01'] : $val['PRICE'];
                                $cost = $val['COST'];
                                $b[$key] += $cost * (100 - $val['DISCOUNT']) / 100;
                                $b['all'] += $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$key]['nacff'] += $val['NACPH'];
                                $pan[$key]['cost'] += $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$key]['dis'] += $cost * ($val['DISCOUNT']) / 100;
                                $pan[$key]['count'] ++;
                            }
                        }
                        arsort($b);
                        $i=0;
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable();
                        $reasons->addStringColumn('Панель')
                            ->addNumberColumn('Сумма');
                        foreach($b as $k=>$v)
                        {
                            if($i<9 && $k!=='all'){
                                $b['all']-=$v;
                                $reasons->addRow(["$k", $v]);
                                $i++;
                            }
                        }
                        $reasons->addRow(["Остальные", $b['all']]);
                        $lava->DonutChart('Dep', $reasons, [
                            'title' => 'Статистика по исследованиям',
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan, $lava){
                                $excel->sheet('firstSheet', function ($sheet) use ($pan, $lava) {
                                    $sheet->loadView('excels.statPan')->with([
                                        'pan'=>$pan,
                                        'lava'=>$lava,
                                    ]);
                                });
                            })->export('xls');
                        }
                    break;
                    case 1:
                        $a = $this->getStatistic(1);
                        $pan['Первичные пациенты'] = 0;
                        $pan['Повторные пациенты'] = 0;
                        foreach ($a as $val) {
                            if($val['PRIME']='Y')
                                $pan['Первичные пациенты']++;
                            else
                                $pan['Повторные пациенты']++;
                        }
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable();
                        $reasons->addStringColumn('Обращение')
                            ->addNumberColumn('Количество');
                        foreach($pan as $k=>$v)
                            $reasons->addRow(["$k", $v]);
                        $lava->DonutChart('Dep', $reasons, [
                            'title' => 'Первичные/повторные пациенты',
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan) {
                                $excel->sheet('firstSheet', function ($sheet) use ($pan) {
                                    $sheet->loadView('excels.statPat')->with([
                                        'pan' => $pan,
                                    ]);
                                });
                            })->export('xls');
                        }
                        break;
                    case 2:
                        $a = $this->getStatistic(2);
                        foreach ($a as $val) {
                            //$cost = isset($val['PRICE_01']) ? $val['PRICE_01'] : $val['PRICE'];
                            $cost = $val['COST'];
                            if(isset($pan[$val['DEPT']])) {
                                $pan[$val['DEPT']]['cost'] += $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$val['DEPT']]['nacpp'] += $val['NACPH'];
                            }
                            else {
                                $pan[$val['DEPT']]['cost'] = $cost * (100 - $val['DISCOUNT']) / 100;
                                $pan[$val['DEPT']]['nacpp'] = $val['NACPH'];
                            }
                            $sum+=$cost * (100 - $val['DISCOUNT']) / 100;
                        }
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable();
                        $reasons->addStringColumn('Отделение')
                            ->addNumberColumn('Сумма');
                        foreach($pan as $k=>$v)
                            $reasons->addRow(["$k", $v['cost']]);
                        $lava->DonutChart('Dep', $reasons, [
                            'title' => 'Количество направлений по ЛО',
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan, $lava){
                                $excel->sheet('firstSheet', function ($sheet) use ($pan, $lava) {
                                    $sheet->loadView('excels.statLO')->with([
                                        'pan'=>$pan,
                                        'lava'=>$lava,
                                    ]);
                                });
                            })->export('xls');
                        }
                    break;
                    case 3:
                        $a = $this->getStatistic(3);
                        foreach ($a as $val) {
                            $cost = isset($val['COST']) ? $val['COST'] : $val['PRICE'];
                            if(isset($val['DOCTOR']))
                                if(isset($pan[$val['DOCTOR']])>0){
                                    $pan[$val['DOCTOR']]+=$cost;
                                } else
                                    $pan[$val['DOCTOR']] =$cost;
                        }
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable();
                        $reasons->addStringColumn('Доктор')
                            ->addNumberColumn('Сумма');
                        foreach($pan as $k=>$v)
                            $reasons->addRow(["$k", $v]);
                        $lava->DonutChart('Dep', $reasons, [
                            'title' => 'Количество направлений по ЛО',
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan, $lava){
                                $excel->sheet('firstSheet', function ($sheet) use ($pan, $lava) {
                                    $sheet->loadView('excels.statDoc')->with([
                                        'pan'=>$pan,
                                        'lava'=>$lava,
                                    ]);
                                });
                            })->export('xls');
                        }
                        break;
                    case 4:
                        $depts = [];
                        $a = $this->getStatistic(4);
                        foreach ($a as $val) {
                            if(!in_array($val['DEPT'], $depts))
                                $depts[] = $val['DEPT'];
                        }
                        foreach ($a as $val) {
                            if(isset($pan[date('d.m.Y',strtotime($val['LOGDATE']))])) {
                                $pan[date('d.m.Y',strtotime($val['LOGDATE']))]['count']++;
                                foreach($depts as $v){
                                    if(isset($pan[date('d.m.Y',strtotime($val['LOGDATE']))][$v]))
                                        if($v==$val['DEPT'])
                                            $pan[date('d.m.Y',strtotime($val['LOGDATE']))][$v]++;
                                }

                            }
                            else {
                                foreach($depts as $v)
                                    $pan[date('d.m.Y',strtotime($val['LOGDATE']))][$v] = 0;
                                $pan[date('d.m.Y',strtotime($val['LOGDATE']))]['count'] = 0;
                            }
                        }
                        //dd($pan);
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable()
                            ->addDateTimeColumn('Дата');
                        foreach($depts as $val)
                            $reasons->addNumberColumn("$val");
                        $reasons->addNumberColumn('Всего');
                        foreach($pan as $k=>$v)
                        {
                            array_unshift($v,$k);
                            unset($a);
                            foreach($v as $val)
                                $a[]=$val;
                            $reasons->addRow($a);
                        }
                        $lava->AreaChart('Dep', $reasons, [
                            'title' => 'Количество проб по дням',
                            'legend' => [
                                'position' => 'in'
                            ],
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan,$depts){
                                $excel->sheet('firstSheet', function ($sheet) use ($pan,$depts) {
                                    $sheet->loadView('excels.statDay')->with([
                                        'pan'=>$pan,
                                        'depts'=>$depts
                                    ]);
                                });
                            })->export('xls');
                        }
                        return View::make('stats')->with([
                            'pan'=>$pan,
                            'lava'=>$lava,
                            'dept'=>$depts,
                            'browser'=>Func::getBrowser(),
                            'depts' => $this->getDepts()
                        ]);
                        break;
                    case 5:
                        $a = $this->getStatistic(5);
                        foreach ($a as $val) {
                            if(isset($val['BACK']))
                                if(isset($pan[$val['BACK']])>0){
                                    $pan[$val['BACK']]++;
                                } else
                                    $pan[$val['BACK']] =0;
                        }
                        $lava = new Lavacharts();
                        $reasons = $lava->DataTable();
                        $reasons->addStringColumn('Источник')
                            ->addNumberColumn('Количество');
                        foreach($pan as $k=>$v)
                            $reasons->addRow(["$k", $v]);
                        $lava->DonutChart('Dep', $reasons, [
                            'title' => 'Откуда узнали',
                            'width' => 800,
                            'height' => 400,
                            'titleTextStyle' => [
                                'fontName' => 'Arial',
                                'color' => 'black',
                            ],
                        ]);
                        if(Input::has('excel') && Input::get('excel')==1) {
                            Excel::create('newFile', function ($excel) use ($pan){
                                $excel->sheet('firstSheet', function ($sheet) use ($pan) {
                                    $sheet->loadView('excels.statBack')->with([
                                        'pan'=>$pan,
                                    ]);
                                });
                            })->export('xls');
                        }
                        break;
                }
            //dd($dep);
            return View::make('stats')->with([
                'pan'=>$pan,
                'lava'=>$lava,
                'browser'=>Func::getBrowser(),
                'depts' => $this->getDepts()
            ]);
        }
        return View::make('stats')->with([
            'browser'=>Func::getBrowser(),
            'depts' => $this->getDepts()
        ]);
    }
    //  Кассовый отчет
    public function page56()
    {
        $folders = $this->getFolders();
        $sum=0; $sum1 = 0;
        foreach($folders as $val){
            if($val['CASH']=='Y')
                $sum+=$val['COST'];
            else
                $sum1+=$val['COST'];
        }
        $depts = $this->getDepts();
        return View::make('Accounting')->with([
           'folders'=>$folders,
            'depts' => $depts,
            'browser'=>Func::getBrowser(),
            's'=>$sum,
            's1'=>$sum1
        ]);
    }
    //  Детальный отчет
    public function page57()
    {
        $table = $this->detal();
        $depts = $this->getDepts();
        //dd($table);
        if(Input::has('excel') && Input::get('excel')==1) {
            Excel::create('newFile', function ($excel) use ($table) {
                $excel->sheet('firstSheet', function ($sheet) use ($table) {
                    $sheet->loadView('excels.detal')->with([
                        'table' => $table
                    ]);
                });
            })->export('xls');
        }
        return View::make('Detal')->with([
            'browser'=>Func::getBrowser(),
            'table'=>$table,
            'depts' => $depts,
        ]);

    }
    //Материалы
    public function page63()
    {
        if(Input::has('name'))
        {
            $query = $this->getResult($this->queryDB("select matid from Materialdept where matid=".Input::get('name')." and deptid=".Input::get('Adept')));
            if(!empty($query)){
                if(Input::get('type')=='p') {
                    $colA = Input::get('col') * Input::get('colA');
                    $res = $this->queryDB("update Materialdept set unit = unit+$colA, unitpack =unitpack + " . Input::get('col') . " where matid=" . Input::get('name') . " and deptid=" . Input::get('Adept'));
                } elseif(Input::get('type')=='m') {
                    $colA = Input::get('col') * Input::get('colA');
                    $res = $this->queryDB("update Materialdept set unit = unit-$colA, unitpack =unitpack - " . Input::get('col') . " where matid=" . Input::get('name') . " and deptid=" . Input::get('Adept')." returning unit, unitpack");
                    $result = $this->getResult($res);
                    if($result[0]['UNIT']<0 or $result[0]['UNITPACK']<0)
                        $this->queryDB("update Materialdept set unit = 0, unitpack =0 where matid=" . Input::get('name') . " and deptid=" . Input::get('Adept'));
                }
            } else {
                $colA = Input::get('col')*Input::get('colA');
                $res = $this->queryDB("insert into Materialdept(deptid, matid, unit, unitpack) values(".Input::get('Adept').", ".Input::get('name').", $colA, ".Input::get('col').")");
            }
        }
        $mat = $this->getMaterials();
        $matdept = $this->getMatDept();
        return View::make('materials')->with([
            'mat' => $mat,
            'matdept' => $matdept,
            'depts' => $this->getDepts()
        ]);
    }

}