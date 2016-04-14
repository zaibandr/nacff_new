@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/draft.css')}}" rel="stylesheet">
<div id="draft">
    <h1>Информация по заявке  {{$folder['FOLDERNO']}}</h1>
    <div class="row" style="background: #49B1C2">
        <div class="col-lg-3"><p style="text-align:center; font-size: 1.2em; padding: 3px; color:white; margin: 0; font-weight: bold;">Общее</p></div>
        <div class="col-lg-9"><p style="text-align:center; font-size: 1.2em; padding: 3px; color:white; margin: 0; font-weight: bold;">Панели</p></div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <table id="a" class="table">
                <tr>
                    <td class="grey">PID</td>
                    <td><b><a href="{{url('pid/'.$folder['PID'])}}">{{$folder['PID']}}</a></b></td>
                </tr>
                <tr>
                    <td class="grey">Фамилия</td>
                    <td><b>{{$folder['SURNAME']}}</b></td>
                </tr>
                <tr>
                    <td class="grey">Имя</td>
                    <td><b>{{$folder['NAME']}}</b></td>
                </tr>
                <tr>
                    <td class="grey">Отчество</td>
                    <td><b>{{$folder['PATRONYMIC']}}</b></td>
                </tr>
                <tr>
                    <td class="grey">Дата рождения</td>
                    <td><b>{{date('d.m.Y',strtotime($folder['DATE_BIRTH']))}}</b></td>
                </tr>
                <tr>
                    <td class="grey">Лечащий врач</td>
                    <td><b>{{$folder['DOCTOR']}}</b></td>
                </tr>
                <tr>
                    <td class="grey">Отделение</td>
                    <td><b>{{$folder['DEPT']}}</b></td>
                </tr>
            </table>
        </div>
        <div class="col-lg-9">
            <table class="table" id="c">
                <tr>
                    <td><a href="" data-target="#label" data-toggle="modal"><i class="fa fa-barcode">&nbsp;Штрих-код</i></a></td>
                    <td><a href="{{url("print/$id?action=act")}}" ><i class="fa fa-file-pdf-o">&nbsp;Акт</i></a></td>
                    <td><a href="{{url("edit/$id")}}" ><i class="fa fa-pencil-square-o">&nbsp;Редактировать</i></a></td>
                    <td><a href="{{url("delete/$id")}}" ><i class="fa fa-trash-o">&nbsp;Удалить</i></a></td>
                    <td><a href="{{url("new/$id")}}" ><i class="fa fa-copy">&nbsp;Копировать</i></a></td>
                </tr>
            </table>
            <table id="b">
                <tr>
                    <th style="width: 20%;">Номер контейнера</th>
                    <th style="width: 40%;">Панель</th>
                    <th style="width: 20%;">Биоматериал</th>
                    <th style="width: 20%;">Тип пробирки</th>
                </tr>
                    @foreach($order as $val)
                        @if(isset($val['CODE']))
                    <tr>
                        <td style="width: 20%;">{{$val['CONTAINERNO']}}</td>
                        <td style="width: 40%;">{{$val['CODE']}} - {{$val['PANEL']}}</td>
                        <td style="width: 20%;">{{$val['MATTYPE']}}</td>
                        <td style="width: 20%;">{{$val['CONTGROUP']}}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 40%;">{{$val['CODE_01']}} - {{$val['NAME']}}</td>
                            <td style="width: 20%;"></td>
                            <td style="width: 20%;"></td>
                        </tr>
                    @endif
                        @endforeach
            </table>
        </div>
    </div>
</div>
    @include('modules.label')
    @stop