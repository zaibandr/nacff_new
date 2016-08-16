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
        //dd($request->all);
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
        while($request->has($cont)){
            $container = (trim($request[$cont]));
            $mattype = mb_strtoupper(trim($request[str_replace('cont1','matt1',$cont)]));
            $counter = trim($request[str_replace('cont1','count1',$cont)]);
            for($i=0; $i<$counter; $i++) {
                $query = "insert into panel_containers(panel,containerno, mattype_id, contgroupid, preanalitic_id, samplingsrules_id) ";
                $query .= "values('$panel', $i, (select coalesce(m.id,null) from mattypes m where m.mattype='" . $mattype . "'), ";
                $query .= "(select coalesce(c.id,null) from contgroups c where c.contgroup='" . $container . "')," . $id[0]['ID'] . ", " . $Sid[0]['ID'] . ")";
                $this->queryDB($query);
            }
            $cont.='1';
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
        //
    }
}
