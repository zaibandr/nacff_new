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
            <div class="col-lg-12">
                <div class="btn-group">
                    <button class="btn btn-default btn-lg" data-toggle="modal" data-target="#filter"><span class="glyphicon glyphicon-cog" style="margin-right: 5px"></span>Фильтр</button>
                    <button class="btn btn-default btn-lg" id="print" onclick="printAll()"><span class="glyphicon glyphicon-print" style="margin-right: 5px"></span>Печать</button>
                    <button class="btn btn-default btn-lg" data-toggle="modal" data-target="#excel"><span class="glyphicon glyphicon-floppy-save" style="margin-right: 5px"></span>Скачать</button>
                    <button class="btn btn-default btn-lg" id="popover" type="button"><i class="fa fa-filter"></i>Фильтр столбцов</button>

                    <div class="hidden">
                        <div id="popover-target"></div>
                    </div>
                </div>
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
                        <th data-priority="3">Организация</th>
                        <th data-priority="2">Доктор</th>
                        <th data-priority="2">Страховая компания</th>
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
                            <td><a target="_blank" href='{{$val['STATUSNAME']=='Черновик' ? url('draft/'.$val['FOLDERNO']) : url('request/'.$val['FOLDERNO'])}}'>{{$val['FOLDERNO']}}</a></td>
                            <td>{{$val['SURNAME']." ".$val['NAME']." ".$val['PATRONYMIC']}}</td>
                            <td>{{$val['GENDER']=='F' ? 'Ж' : 'М'}}</td>
                            <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
                            <td>{{date('d.m.Y',strtotime($val['DATE_BIRTH']))}}</td>
                            <td>{{$val['DEPT']}}</td>
                            <td>{{$val['ORG']}}</td>
                            <td>{{$val['DOCTOR']}}</td>
                            <td>{{$val['STR']}}</td>
                            <td>{{$val['COMMENTS']}}</td>
                            <td>{{$val['PRICE']}}</td>
                            <td>{{$val['COST']}}</td>
                            <td>{{$val['DISCOUNT']}}</td>
                            <td><input type='checkbox' id='{{$val['FOLDERNO']}}' class='prn-cbox' /></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg" id="filter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Фильтр</h4>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <div id="table-filter">
                                    <p>Фильтр по дате регистрации:</p>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_st">за период с</label>
                                                    <input type="text" name="date_st" id="date_st" class="datepicker form-control" value="<?php echo Input::get('date_st',date('d.m.Y',strtotime("-3 days")));?>"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_en">по</label>
                                                    <input type="text" name="date_en" id="date_en" class="datepicker form-control" value="<?php echo Input::get('date_en',date('d.m.Y'));?>"/>
                                                </div>
                                            </div>
                                        </div>
                                <div class="row">
                                    @if(count($depts)>1)
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="client">Фильтр по центрам:</label>
                                                <select name="client" id="client" class="form-control">
                                                    <option value="all"{{Input::get('client')=="all"?"selected":""}}>-- Все центры --</option>
                                                    <option value="{{Session::get('dept')}}"{{(!Input::has('client') || Input::get('client')==Session::get('dept'))?" selected":""}}>(Текущий центр)</option>
                                                    @foreach ($depts as $val)
                                                        @if ($val['ID']!==Session::get('dept'))
                                                        <option value="{{$val['ID']}}"{{(Input::get('client')==$val['ID'])?"selected":""}}>{{$val['DEPT']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    <button type="button" class="btn btn-danger" onclick="formReset()">Сброс</button>
                                    <button type="submit" class="btn btn-primary"> Применить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('modules.folderExcel')
    @stop