@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/patients.css')}}" rel="stylesheet">
    @include('scripts.LPU')
    <div id="patients">
        <h1>Список ЛПУ</h1>
        <table class="tablesorter">
            <thead>
            <tr>
                <th>Логин</th>
                <th>Пароль</th>
                <th>ЛПУ</th>
                <th>Отделение</th>
                <th>Описание</th>
                <th>Права</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($lp as $val)
                <tr>
                    <td>{{$val['USERNAM']}}</td>
                    <td>{{$val['PASSWORD3']}}</td>
                    <td>{{$val['DEPTCODE']}}</td>
                    <td>{{$val['DEPT']}}</td>
                    <td>{{$val['DESCRIPTION']}}</td>
                    <td>
                        @if($val['ROLEID']==7)
                            {{"Гл.врач"}}
                            @elseif($val['ROLEID']==15)
                        {{"Медсестра"}}
                            @endif
                    </td>
                    <td><i class="fa fa-edit" data-toggle="modal" data-target="#edit" onclick="modal(this)"></i>
                        <i class="fa fa-trash-o" style="margin-left: 20%"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('modules.LPUModalEdit')
    @stop