@extends('default')
@section('content')

    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/accounting.css')}}" rel="stylesheet">
    <div id="accounting">
        <h1 style="margin-bottom: 2%;">КАССОВЫЙ ОТЧЕТ</h1>
        <div class="row">
            <div class="col-lg-offset-2 col-lg-10">
                <form action="" method="post" class="form-inline">
                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon">за период с </span>
                        <input type="text" class="form-control" name="date_st" value="{{Input::get('date_st',date('d.m.Y',strtotime("-3 days")))}}"/>
                        <span class="input-group-addon">по</span>
                        <input type="text" class="form-control" name="date_en" value="{{Input::get('date_en',date('d.m.Y'))}}"/>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <select name="client" id="client" class="form-control" style="margin-right: 2%;">
                        <option value="all"{{!Input::has('client') || Input::get('client')=="all"?"selected":""}}>-- Все центры --</option>
                        <option value="{{Session::get('dept')}}"{{(Input::get('client')==Session::get('dept'))?" selected":""}}>(Текущий центр)</option>
                        @foreach ($depts as $val)
                            @if ($val['ID']!==Session::get('dept'))
                                <option value="{{$val['ID']}}"{{(Input::get('client')==$val['ID'])?"selected":""}}>{{$val['DEPT']}}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="tablesorter" style="margin-top: 2%;">
                    <thead>
                    <tr>
                        <td>Дата</td>
                        <td>ЛПУ</td>
                        <td>Направление</td>
                        <td>Фамилия</td>
                        <td>Имя</td>
                        <td>Отчество</td>
                        <td>Сумма <br>без скидки</td>
                        <td>Скидка</td>
                        <td>Оплата <br> наличные</td>
                        <td>Оплата <br> безналичные</td>
                        <td>Зарегистрировал</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($folders as $val)
                        @if($val['APPRSTS']!=='D' && $val['APPRSTS']!=='R')
                    <tr>
                        <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
                        <td>
                            @foreach($depts as $d)
                                @if($d['ID']==$val['CLIENTID'])
                                    {{$d['DEPT']}}
                                    @endif
                                @endforeach
                        </td>
                        <td>{{$val['FOLDERNO']}}</td>
                        <td>{{$val['SURNAME']}}</td>
                        <td>{{$val['NAME']}}</td>
                        <td>{{$val['PATRONYMIC']}}</td>
                        <td>{{$val['PRICE']}}</td>
                        <td>{{$val['DISCOUNT']}}</td>
                        <td>{{$val['CASH']=='Y'?$val['COST']:''}}</td>
                        <td>{{$val['CASH']=='N'?$val['COST']:''}}</td>
                        <td>{{$val['LOGUSER']}}</td>
                    </tr>
                    @endif
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
        <div class="row">
            <div class="col-lg-12">
                <pre>Итого: наличные ( {{$s}} ), безналичные ( {{$s1}} )</pre>
            </div>
        </div>
    </div>
    @include('scripts.accScript')
    @stop