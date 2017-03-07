@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/patients.css')}}" rel="stylesheet">
    @include('scripts.patientScript')
    <div id="patients">
        <h1>Список пациентов</h1>
        <table class="tablesorter" style="margin-top: 2%;">
            <thead>
            <tr>
                <th>PID</th>
                <th>Дата регистрации</th>
                <th>ФИО</th>
                <th class="filter-false">Пол</th>
                <th>Дата рождения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($patients as $val)
                <tr><td><a href="{{secure_url('pid/'.$val['PID'])}}">{{$val['PID']}}</a></td>
                <td>{{date('d.m.Y', strtotime($val['LOGDATE']))}}</td>
                <td>{{$val['SURNAME'].' '.$val['NAME'].' '.$val['PATRONYMIC']}}</td>
                <td>{{$val['GENDER']=='F' ?'Жен' : 'Муж'}}</td>
                <td>{{date('d.m.Y', strtotime($val['DATE_BIRTH']))}}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @stop