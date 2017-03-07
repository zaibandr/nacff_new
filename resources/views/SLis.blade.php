@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/slis.css')}}" rel="stylesheet">
    @include('scripts.tablesorterScriptTab')
<div id="tabs">
    <h1>СПРАВОЧНИКИ ЛИС</h1>
    {!! Form::open(['class'=>'form-inline', 'style'=>'margin-top:2%; margin-bottom:2%']) !!}
    {!! Form::label('type', 'Выберите справочник:') !!}
    {!! Form::select('type',['panel'=>'Панели Испытаний','test'=>'Испытания(тесты)', 'bio'=>'Биоматериалы', 'cont'=>'Типы контейнеров'],Input::get('type'), ['class'=>'form-control']) !!}
    {!! Form::submit('Обновить',['class'=>'btn btn-default']) !!}
    {!! Form::close() !!}
    @if(Input::get('type')=='panel')
        <table class="tablesorter">
            <thead>
            <tr>
                <th>Код панели</th>
                <th>Название панели</th>
            </tr>
            </thead>
            <tbody>
            @foreach($panels as $val)
                <tr><td>{{$val['CODE']}}</td><td>{{$val['PANEL']}}</td></tr>
            @endforeach
            </tbody>
        </table>
    @elseif(Input::get('type')=='test')
        <div style="height: 400px; overflow: auto">
            <table class="tablesorter" id="testsTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название теста</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tests as $key=>$val)
                    <tr><td>{{$val['ID']}}</td><td>{{$val['TESTNAME']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <table id="analyteTable" class="table" style="margin-top: 3%; background: white;">
            <thead>
            <tr>
                <th>Название аналита</th>
                <th>Единица измерения</th>
            </tr>
            </thead>
            @foreach($a as $key=>$val)
                @foreach($val as $v)
                    <tr  class="{{$key}}" style="display: none"><td>{{$v[1]}}</td><td>{{$v[0]}}</td></tr>
                @endforeach
            @endforeach
        </table>
    @elseif(Input::get('type')=='bio')
        <table class="tablesorter">
            <thead>
            <tr>
                <th></th>
                <th>Тип биоматериала</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mattypes as $val)
                <tr><td>{{$val['ID']}}</td><td>{{$val['MATTYPE']}}</td></tr>
            @endforeach
            </tbody>
        </table>
    @elseif(Input::get('type')=='cont')
        <table class="tablesorter">
            <thead>
            <tr>
                <th>#</th>
                <th>Название теста</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pconts as $val)
                <tr><td>{{$val['ID']}}</td><td>{{$val['CONTGROUP']}}</td></tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

    @stop