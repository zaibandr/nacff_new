<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminDep extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('adminPanel.dep')->with([
            'depts' => $this->getDeptsAdmin(),
            'nets'  => $this->getNets()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $price = $this->getDeptPrice();
        $nets = $this->getNets();
        return \View::make('adminPanel.newDept')->with([
            'prices'=>$price,
            'nets' => $nets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $db = ibase_connect("192.168.0.8:lims","sysdba","cdrecord");
        $lpus = explode(',',trim($request->lpu));
        foreach($lpus as $lpu) {
            while (strlen($lpu) < 4)
                $lpu = '0' . $lpu;
            if (isset($request->lims)) {
                $query = "select a.manager, a.contact, a.email, a.phone, c.medname, c.clientname from n_users a ";
                $query .= "inner join clients c on c.id=a.clientid where c.clientcode='$lpu'";
                $stmt = ibase_query($db, $query);
                $row = ibase_fetch_assoc($stmt);
                if(strlen(trim($row['CLIENTNAME']))>30){
                    $desc = addslashes(trim($row['CLIENTNAME']));
                    $name = addslashes(trim($row['MEDNAME']));
                } else {
                    $name = addslashes(trim($row['CLIENTNAME']));
                    $desc = addslashes(trim($row['MEDNAME']));
                }
                $contact = trim($row['CONTACT']);
                $email = trim($row['EMAIL']);
                $phone = trim($row['PHONE']);
                $manager = trim($row['MANAGER']);
                //dd($row);
            } else {
                $name = mb_strtoupper(trim($request->name));
                $desc = addslashes(trim($request->desc));
                $contact = addslashes(trim($request->contact));
                $phone = addslashes(trim($request->phone));
                $email = addslashes(trim($request->email));
                $manager = addslashes(trim($request->manager));
            }
            $priceId = $request->price;
            $netId = isset($request->net) ? $request->net : 'null';
            $query = "insert into departments(deptcode,dept,description,status,net_id,email,phone,manager,contact) VALUES ('$lpu','$name','$desc','A', $netId,'$email','$phone','$manager','$contact') returning id";
            $deptId = $this->getResult($this->queryDB($query));
            $deptId = $deptId[0]['ID'];
            if (isset($request->dateend))
                $dateend = date('Y-m-d', strtotime($request->dateend));
            else $dateend = date('Y-m-d', time() + 3600 * 24 * 365);
            if (isset($request->datestart))
                $datestart = date('Y-m-d', strtotime($request->datestart));
            else $datestart = date('Y-m-d');
            $query = "insert into pricelists(status,datebegin,dateend,by_user,dept) VALUES ('A','$datestart','$dateend','ADMIN',$deptId) returning id";
            $newPriceId = $this->getResult($this->queryDB($query));
            $newPriceId = $newPriceId[0]['ID'];

            $query = "select p.code, pr.cost from prices pr inner join pricelists ps on ps.id=pr.pricelistid ";
            $query .= "inner join panels p on p.id=pr.panelid ";
            $query .= "inner join clients c on c.id=ps.clientid where ps.status='A' and c.clientcode='$lpu'";
            $stmt = ibase_query($db, $query);
            while ($res = ibase_fetch_assoc($stmt)) {
                $cost = ($res['COST']) ? $res['COST'] : 0;
                $query = "INSERT INTO PRICES (PRICELISTID, COST, PANEL, COMMENTS, NACPH, MARGA, DUE, CONTTYPES,MEDAN) ";
                $query .= "select $newPriceId,COST, PANEL, COMMENTS," . $cost . ", MARGA, DUE, CONTTYPES, MEDAN from prices ";
                $query .= "where PRICELISTID=$priceId and panel='" . $res['CODE'] . "'";
                $this->queryDB($query);
            }
        }
        return \Redirect::route('page68.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \View::make('adminPanel.pricelist')->with([
            'price' => $this->getPriceAdmin($id),
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Input::has('del')){
            $query = "delete from prices where panel='".\Input::get('del')."' and pricelistid = (select id from pricelists where dept=$id)";
            $this->queryDB($query);
        }
        if(\Input::has('code')){
            $due = (int)\Input::get('due',1);
            $name = trim(\Input::get('panel'));
            $query = "update prices set cost=".\Input::get('cost').", nacph=".\Input::get('costn');
            $query.= ", medan = '$name', due = $due";
            $query.= " where panel='".\Input::get('code')."' and ";
            $query.= "pricelistid = (select id from pricelists where dept=$id)";
            //dd($query);
            $this->queryDB($query);
        }
        if(\Input::has('update')){
            $lpu = $this->getResult($this->queryDB("select deptcode from departments where id=$id"));
            $lpu = $lpu[0]['DEPTCODE'];
            $priceid = $this->getResult($this->queryDB("select id from pricelists where dept=$id"));
            $priceid = $priceid[0]['ID'];
            $db = ibase_connect("192.168.0.8:lims","sysdba","cdrecord");
            $query = "select p.code, pr.cost from prices pr inner join pricelists ps on ps.id=pr.pricelistid ";
            $query.= "inner join panels p on p.id=pr.panelid ";
            $query.= "inner join clients c on c.id=ps.clientid where ps.status='A' and c.clientcode='$lpu'";
            $stmt = ibase_query($db,$query);
            while($res = ibase_fetch_assoc($stmt)){
                $check = $this->getResult($this->queryDB("select panel from prices where pricelistid=$priceid and panel='".$res['CODE']."'"));
                if(isset($check[0])){
                    $this->queryDB("update prices set nacph=".$res['COST']." where pricelistid=$priceid and panel='".$res['CODE']."'");
                } else {
                    $this->queryDB("insert into prices(pricelistid, panel, nacph) VALUES ($priceid,".$res['CODE'].",".$res['COST'].")");
                }
            }

        }
        return \Redirect::route('page68.show', [$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = (trim($request->name));
        $desc = (trim($request->desc));
        $net = $request->get('net',null);
        $query  = "update departments set dept='$name', description='$desc'";
        if($net)
            $query .= ", net_id=$net";
        if($request->email_send)
            $query .= ", email_sender='Y'";
        else
            $query .= ", email_sender='N'";
        $query .= " where id=$id";
        $this->queryDB($query);
        return \Redirect::route('page68.index');
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
