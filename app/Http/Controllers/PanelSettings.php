<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PanelSettings extends DBController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('adminPanel.panels')->with([
            'panels' => $this->getPanel()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cont = 'cont1';
        dd($request->all);
        $panel = trim(str_replace(',','.',$request['code']));
        $name = trim($request['name']);
        $query = "delete from panel_containers where panel='".$request['code']."'";
        $this->queryDB($query);
        $prean = trim($request['prean']);
        $samp = trim($request['samp']);
        $query = "select id from preanalytics where description='$prean'";
        $id = $this->getResult($this->queryDB($query));
        if (empty($id)) {
            $query = "insert into preanalytics(description) VALUES ('$prean') returning id";
            $id = $this->getResult($this->queryDB($query));
        }
        $query = "select id from samplingrules where samplingrule='$samp'";
        $Sid = $this->getResult($this->queryDB($query));
        if (empty($Sid)) {
            $query = "insert into samplingrules(samplingrule) VALUES ('$samp') returning id";
            $Sid = $this->getResult($this->queryDB($query));
        }
        $j=1;
        while($request->has($cont)){
            $container = (trim($request[$cont]));
            $mattype = mb_strtoupper(trim($request[str_replace('cont1','matt1',$cont)]));
            $counter = (int) trim($request[str_replace('cont1','count1',$cont)]);
            for($i=1; $i<=$counter; $i++){
                $query = "insert into panel_containers(panel,containerno, mattype_id, contgroupid, preanalitic_id, samplingsrules_id) ";
                $query.= "values('".$request['code']."', $j, (select coalesce(m.id,null) from mattypes m where m.mattype='".$mattype."'), ";
                $query.= "(select coalesce(c.id,null) from contgroups c where c.contgroup='".$container."'),". $id[0]['ID'].", ".$Sid[0]['ID'].")";
                $this->queryDB($query);
                $j++;
            }
            $cont.='1';
        }
        return \Redirect::route('page70.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1.Проверяет сущуствуют ли данные преаналитика и группы забора
     * 2.Удаляет все записи с таблицы panel_containers
     * 3.Добавляет заново в эту таблицу записи с учетом преаналитики и г з
     * 4.Сохраняет пользователя проверевшего достоверность
     */
    public function store(Request $request)
    {
        $cont = 'cont1';
        //dd($request['samp']);
        $panel = trim(str_replace(',','.',$request['code']));
        $name = trim($request['name']);
        $query = "delete from panel_containers where panel='$panel'";
        $this->queryDB($query);
        $prean = trim($request['prean']);
        $samp = trim($request['samp']);
        $query = "select id from preanalytics where description='$prean'";
        $id = $this->getResult($this->queryDB($query));
        if (!isset($id[0])) {
            $query = "insert into preanalytics(description) VALUES ('$prean') returning id";
            $id = $this->getResult($this->queryDB($query));
        }
        $query = "select id from samplingrules where samplingrule='$samp'";
        $Sid = $this->getResult($this->queryDB($query));
        if (!isset($Sid[0])) {
            $query = "insert into samplingrules(samplingrule) VALUES ('$samp') returning id";
            $Sid = $this->getResult($this->queryDB($query));
        }
        $j=1;
        while($j<10){
            if($request->has('cont'.$j)) {
                $container = (trim($request['cont'.$j]));
                $mattype = mb_strtoupper(trim($request['matt'.$j]));
                $counter = trim($request['count'.$j]);
                $query = "select id from contgroups where contgroup='$container'";
                $Contid = $this->getResult($this->queryDB($query));
                if (!isset($Contid[0])) {
                    $query = "insert into contgroups(contgroup) VALUES ('$container') returning id";
                    $Contid = $this->getResult($this->queryDB($query));
                }
                $query = "select id from mattypes where mattype='$mattype'";
                $Matid = $this->getResult($this->queryDB($query));
                if (!isset($Matid[0])) {
                    $query = "insert into mattypes(mattype) VALUES ('$mattype') returning id";
                    $Matid = $this->getResult($this->queryDB($query));
                }
                for ($i = 0; $i < $counter; $i++) {
                    $query = "insert into panel_containers(panel,containerno, mattype_id, contgroupid, preanalitic_id, samplingsrules_id) ";
                    $query .= "values('$panel', $i," . $Matid[0]['ID'] . "," . $Contid[0]['ID'] . " ," . $id[0]['ID'] . ", " . $Sid[0]['ID'] . ")";
                    $this->queryDB($query);
                }
            }
            $j++;
        }
        if($request->get('checked')=='yes')
            $this->queryDB("update panels set checked='".\Session::get('login')."' where code='$panel'");
        return \Redirect::route('page70.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = "delete from panel_containers where panel='$id'";
        $this->queryDB($query);
        $query = "delete from panels where code='$id'";
        $this->queryDB($query);
        $query = "insert into logs(log_time, theme, description) VALUES (CURRENT_TIMESTAMP ,'Panel delete','Deleting panel=$id')";
        $this->queryDB($query);
        return \Redirect::route('page70.index');
    }
}
