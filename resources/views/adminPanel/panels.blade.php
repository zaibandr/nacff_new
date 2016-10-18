@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/price.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <div id="pricePage">
        <h1>НАСТРОЙКА ПАНЕЛЕЙ</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin: 2%">Добавить панель</button>
        <table class="tablesorter">
            <thead>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Готовность</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($panels as $val)
                <tr>
                    <td>{{$val['CODE']}}</td>
                    <td>{{$val['PANEL']}}</td>
                    <td><i style="color: {{trim($val['CHECKED'])!=''?'green':'red'}};">{{trim($val['CHECKED'])!=''?'Готово':'Не готово'}}</i></td>
                    <td><button class="btn btn-primary" data-toggle="modal" data-target="#browse" onclick="loadPanel('{{$val['CODE']}}','{{$val['CHECKED']}}')">Обзор</button></td>
                    <td>
                        {!! Form::open(['action'=>['PanelSettings@destroy','code'=>$val['CODE']], 'onsubmit'=>' return confirm("Вы действительно хотите удалить панель?")']) !!}
                        {!! Form::hidden('_method','delete') !!}
                        {!! Form::submit('Удалить',['class'=>'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade bs-example-modal-lg" id="browse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать панель</h4>
                </div>
                {!! Form::open(['method'=>'post'])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" style="margin-bottom: 2%">
                            {!! Form::label('code', 'Код') !!}
                            {!!Form::text('code', null, ['class'=>'form-control', 'id'=>'code', 'readonly', 'style'=>'margin-bottom:2%; width:90%'])!!}
                        </div>
                        <div class="col-lg-6" style="margin-bottom: 2%">
                            {!! Form::label('name', 'Название') !!}
                            {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'readonly', 'style'=>'margin-bottom:2%; width:90%'])!!}
                        </div>
                            <div id="panelContainer">

                            </div>
                    </div>
                    <hr>
                    {!! Form::label('checked', 'Проверено?  ') !!}
                    {!! Form::checkbox('checked','yes', null, ['class'=>'checked']) !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><div class="modal fade bs-example-modal-lg" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Добавить меню</h4>
                </div>
                {!! Form::open(['method'=>'get', 'url'=>route('page70.create')])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" style="margin-bottom: 2%">
                            {!! Form::label('code', 'Код') !!}
                            {!!Form::text('code', null, ['class'=>'form-control', 'id'=>'code', 'required', 'style'=>'margin-bottom:2%; width:90%'])!!}
                        </div>
                        <div class="col-lg-6" style="margin-bottom: 2%">
                            {!! Form::label('name', 'Название') !!}
                            {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'required', 'style'=>'margin-bottom:2%; width:90%'])!!}
                        </div>
                        <div id="panelContainer">
                            <div class="panel">
                                <div class="col-lg-5 form-group"><label for="cont1">Контейнер</label><input type="text" class="form-control cont" name="cont1" required /></div>
                                <div class="col-lg-4 form-group"><label for="matt1">Биоматериал</label><input type="text" class="form-control matt" name="matt1" required /></div>
                                <div class="col-lg-2 form-group"><label for="count1">Количество</label><input type="text" class="form-control" name="count1" value="1" required/></div>
                                <div class="col-lg-1"><i class="fa fa-times-circle fa-2x" style="color:red; cursor:pointer" onclick="delRow(this)"></i></div>
                                <div class="col-lg-1"><i class="fa fa-plus-circle fa-2x" style="color:green; cursor:pointer" onclick="addRow(this)"></i></div>
                            </div>
                            <div class="col-lg-12 form-group"><label for="prean">Преаналитика</label><textarea class="form-control" name="prean"></textarea></div>
                            <div class="col-lg-12 form-group"><label for="samp">Группа забора</label><input type="text" class="form-control samp" name="samp" /></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@include('scripts.adminPanels')
    @stop