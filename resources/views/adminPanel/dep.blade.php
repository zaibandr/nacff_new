@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    @include('scripts.deptAdminScript')
    <div id="lpu">
        <h1>Отделения</h1>
        <div class="col-lg-12">
            <a href="{{route("page68.create")}}" class="btn btn-primary" style="margin: 2%">Добавить пользователя</a>
        </div>
        <table class="tablesorter">
            <thead>
            <tr>
                <th>ЛПУ</th>
                <th>Название</th>
                <th>Описание</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($depts as $val)
                <tr>
                    <td>{{$val['DEPTCODE']}}</td>
                    <td>{{$val['DEPT']}}</td>
                    <td>{{$val['DESCRIPTION']}}</td>
                    <td><a href="{{url('page68/'.$val['ID'])}}">Прайс</a></td>
                    <td><a href="{{url('page68/'.$val['ID'])}}">Редактировать</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @stop