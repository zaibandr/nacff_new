@extends('default')
@section('content')

    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/detal.css')}}" rel="stylesheet">
    <div id="detal">
        <h1>Детальный отчет</h1>
        <div class="row">
            <div class="col-lg-12">
                <form action="" method="post" class="form-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon">за период с </span>
                        <input type="text" class="form-control" name="date_st" value="{{Input::get('date_st',date('d.m.Y',strtotime("-3 days")))}}"/>
                        <span class="input-group-addon">по</span>
                        <input type="text" class="form-control" name="date_en" value="{{Input::get('date_en',date('d.m.Y'))}}"/>
                    </div>
                    <select name="client" id="client" class="form-control">
                            <option value="all"{{!Input::has('client') || Input::get('client')=="all"?"selected":""}}>-- Все центры --</option>
                            @foreach ($depts as $val)

                                    <option value="{{$val['ID']}}"{{(Input::get('client')==$val['ID'])?"selected":""}}>{{$val['DEPT']}}</option>

                            @endforeach
                        </select>
                    <select name="type" id="type" class="form-control">
                        <option selected></option>
                        <option value="n" {{Input::has('type') && Input::get('type')=="n"?"selected":""}}>Лабораторные услуги</option>
                        <option value="s" {{Input::has('type') && Input::get('type')=="s"?"selected":""}}>Собственные услуги</option>
                    </select>
                    <input type="hidden" name="excel" id="excel" value="0">
                    <button type="submit" class="btn btn-primary" onclick="$('#excel').val(0)">Обновить</button>
                    <button onclick="$('#excel').val(1)" class="btn btn-primary" type="submit">Скачать в Excel</button>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="tablesorter">
                    <thead>
                    <tr>
                        <td>Дата</td>
                        <td>Отделение</td>
                        <td>Направление</td>
                        <td>Фамилия</td>
                        <td>Имя</td>
                        <td>Отчество</td>
                        <td>Код услуги</td>
                        <td>Услуга</td>
                        <td>Цена без скидки</td>
                        <td>Скидка</td>
                        <td>Цена со скидкой</td>
                        <td>Цена НАКФФ</td>
                        <td>Дельта</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($table as $val)
                            <tr>
                                <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
                                <td>{{$val['DEPT']}}</td>
                                <td>{{$val['FOLDERNO']}}</td>
                                <td>{{$val['SURNAME']}}</td>
                                <td>{{$val['NAME']}}</td>
                                <td>{{$val['PATRONYMIC']}}</td>
                                <td>{{isset($val['CODE'])?$val['CODE']:$val['CODE_01']}}</td>
                                <td>{{isset($val['PANEL'])?$val['PANEL']:$val['NAME_01']}}</td>
                                <td>{{$val['PRICE']}}</td>
                                <td>{{$val['DISCOUNT']}}</td>
                                <td>{{$val['COST']}}</td>
                                <td>{{$val['NACPH']}}</td>
                                <td>{{$val['COST'] - $val['NACPH']}}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12">
                <div class="pager">
                    Страница: <select class="gotoPage"></select>
                    <span class="first glyphicon glyphicon-step-backward" alt="First" title="First page" ></span>
                    <span class="prev glyphicon glyphicon-chevron-left" alt="Prev" title="Previous page" ></span>
                    <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                    <span class="next glyphicon glyphicon-chevron-right" alt="Next" title="Next page" ></span>
                    <span class="last glyphicon glyphicon-step-forward" alt="Last" title= "Last page" ></span>
                    <select class="pagesize">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    @include('scripts.detalScript')
@stop