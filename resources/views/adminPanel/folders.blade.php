@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/requests.css')}}" rel="stylesheet">
    @include('scripts.requestScript')
    <div id="requests">
        <h1>СПИСОК НАПРАВЛЕНИЙ</h1>
        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <form action="" method="post" class="form-inline">
                    {{csrf_field()}}
                    <div class="input-daterange input-group datepicker" >
                        <span class="input-group-addon">за период с </span>
                        <input type="text" class="form-control" name="date_st" value="{{Input::get('date_st',date('d.m.Y',strtotime("-3 days")))}}"/>
                        <span class="input-group-addon">по</span>
                        <input type="text" class="form-control" name="date_en" value="{{Input::get('date_en',date('d.m.Y'))}}"/>
                    </div>
                    <label for="client">Отделение</label>
                    <input type="text" name="client" class="form-control" value="{{Input::get('client','')}}">
                    <label for="lpu">ЛПУ</label>
                    <input type="number" name="lpu" class="form-control" value="{{Input::get('lpu','')}}">
                    <button type="submit" class="btn btn-primary">Обновить</button>
                    <div class="row" style="margin: 2% 0">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="positive"> Фильтр по результатам</label>
                                <select name="positive" id="positive" class="form-control">
                                    <option selected></option>
                                    <option value="O" {{(Input::get('positive')=='O')?"selected":''}}>с патологией</option>
                                    <option value="E" {{(Input::get('positive')=='E')?"selected":''}}> в норме</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="status">Фильтр по статусу выполнения</label>
                                <select name="status" id="status" class="form-control">
                                    <option disabled selected></option>
                                    <option value="T" @if(Input::has('status') && Input::get('status')=='T') {{'selected'}} @endif>Выполнен</option>
                                    <option value="L" @if(Input::has('status') && Input::get('status')=='L') {{'selected'}} @endif>Зарегистрирован</option>
                                    <option value="D" @if(Input::has('status') && Input::get('status')=='D') {{'selected'}} @endif>Черновик</option>
                                    <option value="D" @if(Input::has('status') && Input::get('status')=='D') {{'selected'}} @endif>Отменен</option>
                                    <option value="K" @if(Input::has('status') && Input::get('status')=='K') {{'selected'}} @endif>Курьер</option>
                                    <option value="A" @if(Input::has('status') && Input::get('status')=='A') {{'selected'}} @endif>Выполняется</option>
                                    <option value="P" @if(Input::has('status') && Input::get('status')=='P') {{'selected'}} @endif>Отправлен</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(isset($error)) <b style="color: red">Error</b> @endif
        @if(isset($folders))
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
        <table class="tablesorter bootstrap-popup">
            <thead>
            <tr>
                <th data-priority="critical">Статус</th>
                <th data-priority="critical">Направление</th>
                <th data-priority="critical">ФИО</th>
                <th data-priority="5">Пол</th>
                <th data-priority="critical">Дата регистрации</th>
                <th data-priority="5">Дата рождения</th>
                <th data-priority="4">ЛПУ</th>
                <th data-priority="1">Комментарий</th>
                <th data-priority="1">Цена по прайсу</th>
                <th data-priority="1">Цена с учетом скидки</th>
                <th data-priority="1">Скидка</th>
                <th data-priority="critical" class="filter-false"><span id='printAll' class='glyphicon glyphicon-print' onclick="printSel(); return false;"></span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($folders as $val)
                <tr>
                    <td style="color:{{$val['STATUSCOLOR']}}; font-weight: bold;">{{$val['STATUSNAME']}}</td>
                    <td><a href='{{$val['STATUSNAME']=='Черновик' ? url('draft/'.$val['FOLDERNO']) : url('request/'.$val['FOLDERNO'])}}'>{{$val['FOLDERNO']}}</a></td>
                    <td>{{$val['SURNAME']." ".$val['NAME']." ".$val['PATRONYMIC']}}</td>
                    <td>{{$val['GENDER']=='F' ? 'Ж' : 'М'}}</td>
                    <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
                    <td>{{date('d.m.Y',strtotime($val['DATE_BIRTH']))}}</td>
                    <td>{{$val['DEPT']}}</td>
                    <td>{{$val['COMMENTS']}}</td>
                    <td>{{$val['PRICE']}}</td>
                    <td>{{$val['COST']}}</td>
                    <td>{{$val['DISCOUNT']}}</td>
                    <td><input type='checkbox' id='{{$val['FOLDERNO']}}' class='prn-cbox' /></td>
                </tr>
            @endforeach
            </tbody>
        </table>
            @endif
    </div>
    @stop