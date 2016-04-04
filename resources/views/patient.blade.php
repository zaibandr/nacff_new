@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/patient.css')}}" rel="stylesheet">
    <div id="patient">
        <h1 style="margin-bottom: 2%">ПЕРСОНАЛЬНЫЙ НОМЕР {{$id}}</h1>
        <div class="row">
            <div class="col-lg-2" style="margin-bottom: 5%">
                <i>Фамилия:</i><br>
                <i>Имя:</i><br>
                <i>Отчество:</i><br>
                <i>Дата рождения:</i><br>
                <i>Дата регистрации:</i><br>
                <i>Пол:</i><br>
            </div>
            <div class="col-lg-3">
                <b>{{$patient[0]['SURNAME']}}</b><br>
                <b>{{$patient[0]['NAME']}}</b><br>
                <b>{{$patient[0]['PATRONYMIC']}}</b><br>
                <b>{{date('d.m.Y', strtotime($patient[0]['DATE_BIRTH']))}}</b><br>
                <b>{{date('d.m.Y', strtotime($patient[0]['LOGDATE']))}}</b><br>
                <b>{{$patient[0]['GENDER']=='F'?'Ж':'M'}}</b><br>
            </div>
            <div class="col-lg-2">
                <i>Адрес:</i><br>
                <i>Серия паспорта:</i><br>
                <i>Номер паспорта:</i><br>
                <i>Телефон:</i><br>
                <i>Почта:</i><br>
            </div>
            <div class="col-lg-5">
                <b>{{is_null($patient[0]['ADDRESS'])?'':$patient[0]['ADDRESS']}}</b><br>
                <b>{{is_null($patient[0]['PASSPORT_SERIES'])?'':$patient[0]['PASSPORT_SERIES']}}</b><br>
                <b>{{is_null($patient[0]['PASSPORT_NUMBER'])?'':$patient[0]['PASSPORT_NUMBER']}}</b><br>
                <b>{{is_null($patient[0]['PHONE'])?'':$patient[0]['PHONE']}}</b><br>
                <b>{{is_null($patient[0]['EMAIL'])?'':$patient[0]['EMAIL']}}</b><br>
            </div>
        </div>
        <div class="row">
            <col-lg-12>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Направление</th>
                        <th>Статус</th>
                        <th>Дата регистрации</th>
                    </tr>
                    @foreach($patient as $val)
                        <tr>
                            @if($val['APPRSTS']!=='D')
                            <td><a href="{{url('request/'.$val['FOLDERNO'])}}">{{$val['FOLDERNO']}}</a></td>
                            @else
                                <td><a href="{{url('draft/'.$val['FOLDERNO'])}}">{{$val['FOLDERNO']}}</a></td>
                            @endif
                            <td>{{$val['STATUSNAME']}}</td>
                            <td>{{date('d.m.Y', strtotime($val['LOGDATE']))}}</td>
                        </tr>
                        @endforeach
                </table>
            </col-lg-12>
        </div>
    </div>
    @stop