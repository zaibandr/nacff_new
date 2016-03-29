@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/procedure.css')}}" rel="stylesheet">
    <div id="procedure">
        <h1>ПРОЦЕДУРНЫЙ КАБИНЕТ</h1>
        @foreach($proc as $key=>$val)
        <div class="procs">
            <p>Пациент: <b>{{$val['NAME']}}</b></p>
            <table width="100%" class="table">
                <tr class="success">
                    <th width="60%">Панель</th>
                    <th width="10%">Номер контейнера</th>
                    <th width="10%">Тип контейнера</th>
                    <th width="10%">Биоматериал</th>
                </tr>
                @for($i=0; $i<count($val['PANEL']); $i++)
                    <tr>
                        <td width="60%">{{$val['PANEL'][$i]}}</td>
                        <td width="10%">{{$val['CONT'][$i]}}</td>
                        <td width="10%">{{$val['CONTG'][$i]}}</td>
                        <td width="10%">{{$val['MAT'][$i]}}</td>
                    </tr>
                    @endfor
            </table>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-8" style="margin-top: 20px">
                    <a href="{{url("print/$key?action=label")}}" ><button class="btn btn-primary">Штрих_код</button></a>
                    <a href="{{url("print/$key?action=act")}}" ><button class="btn btn-primary">  Акт</button></a>
                    <a href="{{url("page0022?folderno=$key")}}" ><button class="btn btn-info"> Анализы взяты!</button></a>
                </div>
            </div>
        </div>
            @endforeach
    </div>
    @stop