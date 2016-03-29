@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/slis.css')}}" rel="stylesheet">
    @include('scripts.tablesorterScriptTab')
<div id="tabs">
    <h1>СПРАВОЧНИКИ ЛИС</h1>
    <ul>
        <li><a href="#tabs-1">Панели Испытаний</a></li>
        <li><a href="#tabs-2">Испытания(тесты)</a></li>
        <li><a href="#tabs-3">Биоматериалы</a></li>
        <li><a href="#tabs-4">Типы контейнеров</a></li>
    </ul>
        <div id="tabs-1">
            <table class="tablesorter">
                <thead>
                <tr>
                    <th></th>
                    <th>Код панели</th>
                    <th>Название панели</th>
                </tr>
                </thead>
                <tbody>

                    <?
                    for($i=0; $i<count($panels['code']); $i++)
                        echo "<tr><td>".($i+1)."</td><td>".$panels['code'][$i]."</td><td>".$panels['panel'][$i]."</td></tr>";
                ?>

                </tbody>
            </table>
            <!--div id="pager" class="pager">
                <form>
                    <button type="button" class="btn btn-default btn-sm first"><span class="glyphicon glyphicon-step-backward"></span></button>
                    <button type="button" class="btn btn-default btn-sm prev"><span class="glyphicon glyphicon-backward"></span></button>
                    <input type="text" class="pagedisplay"/>
                    <button type="button" class="btn btn-default btn-sm nextt"><span class="glyphicon glyphicon-forward"></span></button>
                    <button type="button" class="btn btn-default btn-sm last"><span class="glyphicon glyphicon-step-forward"></span></button>
                    <select class="pagesize">
                        <option selected="selected"  value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option  value="40">40</option>
                    </select>
                </form>
            </div-->

        </div>
        <div id="tabs-2">
            <div style="height: 400px; overflow: auto">
                <table class="tablesorter" id="testsTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Название теста</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $i=0;
                    foreach($tests as $key=>$val){
                        echo "<tr class='test'><td>".($i+1)."</td><td>".$val['testcode']."</td><td>".$key."</td></tr>";
                        for($j=0; $j<count($val['id']); $j++)
                            echo "<tr class='analyte' style='display: none'><td>".($j+1)."</td><td>".$val['id'][$j]."</td><td>".$val['analyte'][$j]."</td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <table id="analyteTable" class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Название аналита</th>
                </tr>
                </thead>

            </table>
        </div>
        <div id="tabs-3">
            <table class="tablesorter">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Тип биоматериала</th>
                </tr>
                </thead>
                <tbody>
                <?
                for($i=0; $i<count($mattypes['id']); $i++)
                    echo "<tr><td>".($i+1)."</td><td>".$mattypes['id'][$i]."</td><td>".$mattypes['mattype'][$i]."</td></tr>";
                ?>
                </tbody>
            </table>

        </div>
        <div id="tabs-4">
            <table class="tablesorter">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Название теста</th>
                </tr>
                </thead>
                <tbody>
                <?
                for($i=0; $i<count($pconts['id']); $i++)
                    echo "<tr><td>".($i+1)."</td><td>".$pconts['id'][$i]."</td><td>".$pconts['contgroup'][$i]."</td></tr>";
                ?>
                </tbody>
            </table>
        </div>
</div>

    @stop