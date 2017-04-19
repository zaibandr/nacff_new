@extends('default')
@section('content')
    <link href="{{secure_asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/requests.css')}}" rel="stylesheet">
    @include('scripts.requestScript')
    <div id="requests">
        <div class="row">
            <div class="col-lg-4">
                <h1>СПИСОК НАПРАВЛЕНИЙ</h1>
            </div>
            <form role="form" method="post">
                <div class="col-lg-12" style="margin-top: 3%">
                    <div class="panel-group" id="accordion" role="tablist">
                        <div class="panel panel-default" style="border-color: #f6f7f9;">
                            <div class="panel-heading" role="tab" id="headingOne" style="background:linear-gradient(to top,rgba(119, 119, 119, 0.17) 0%, rgba(194, 225, 230, 0.23) 50%,rgba(119, 119, 119, 0.17) 100%); border-color: #49b1c2;">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 1.1em; color: dimgrey;">
                                        <i class="fa fa-filter"></i>
                                        Фильтр: период с <u>{{ $request->input('date_st',date('d.m.Y',strtotime('-3 days'))) }}</u> по <u>{{ $request->input('date_en',date('d.m.Y')) }}</u>,&nbsp;
                                        со статусом <u>
                                            @if ($request->input('status','NONE') == 'T')Завершен
                                            @elseif($request->input('status','NONE') == 'L')Зарегистрирован
                                            @elseif($request->input('status','NONE') == 'D')Черновик
                                            @elseif($request->input('status','NONE') == 'K')Курьер
                                            @elseif($request->input('status','NONE') == 'A')Выполняется
                                            @elseif($request->input('status','NONE') == 'P')Отправлен
                                        @else все
                                        @endif
                                        </u>&nbsp;
                                        @if($request->has('search'))
                                            ,по фразе: &laquo;<u>{{ $request->input('search','NONE') }}</u>&raquo;&nbsp;
                                        @endif
                                        @if($request->has('panel'))
                                            ,с панелью: &laquo;<u>{{ $request->input('panel','NONE') }}</u>&raquo;&nbsp;
                                        @endif
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row">
                                    {{ csrf_field() }}
                                        <div class="col-md-6">
                                            <div class="form-inline">
                                                <label for="input-date-start">Период: </label>
                                                <input id="input-date-start" name="date_st" type="text" class="form-control datepicker" value="{{ $request->input('date_st',date('d.m.Y',strtotime('-3 days'))) }}">
                                                <label for="input-date-end">-</label>
                                                <input id="input-date-end" name="date_en" type="text" class="form-control datepicker" value="{{ $request->input('date_en',date('d.m.Y')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-inline">
                                                <label for="status">Статус направления:</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option selected></option>
                                                    <option value="T" {{ $request->input('status','NONE')=='T'?'selected':'' }}>Завершен</option>
                                                    <option value="L" {{ $request->input('status','NONE')=='L'?'selected':'' }}>Зарегистрирован</option>
                                                    <option value="D" {{ $request->input('status','NONE')=='D'?'selected':'' }}>Черновик</option>
                                                    <option value="K" {{ $request->input('status','NONE')=='K'?'selected':'' }}>Курьер</option>
                                                    <option value="A" {{ $request->input('status','NONE')=='A'?'selected':'' }}>Выполняется</option>
                                                    <option value="P" {{ $request->input('status','NONE')=='P'?'selected':'' }}>Отправлен</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-inline">
                                                <label for="search">Запрос:</label>
                                                <input id="search" name="search" type="text" class="form-control" value="{{ $request->input('search','') }}" placeholder="ФИО, номер направления, и т.д.">
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin: 1% 0">
                                            <div class="form-group">
                                                <label for="positive"> Фильтр по результатам</label>
                                                <select name="positive" id="positive" class="form-control">
                                                    <option selected></option>
                                                    <option value="O" {{(Input::get('positive')=='O')?"selected":''}}>с патологией</option>
                                                    <option value="E" {{(Input::get('positive')=='E')?"selected":''}}> в норме</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin: 1% 0">
                                            <div class="form-group">
                                                <label for="panel">С панелью</label>
                                                <input type="text" name="panel" class="form-control" value="{{Input::get('panel','')}}">
                                            </div>
                                        </div>
                                        @if(count($depts)>1)
                                            <div class="col-md-4" style="margin: 1% 0">
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
                                        <div class="col-md-12 pull-right">
                                            <button type="submit" class="btn btn-default">Применить</button>
                                            <button type="button" class="btn btn-danger" onclick="formReset()">Сброс</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" style="text-align: left">
                    <button type="button" class="btn btn-default btn-lg" id="print" onclick="printAll()"><span class="glyphicon glyphicon-print" style="margin-right: 5px"></span>Печать</button>
                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#excel"><span class="glyphicon glyphicon-floppy-save" style="margin-right: 5px"></span>Скачать в Excel</button>
                    <button type="button" class="btn btn-default btn-lg" id="popover" data-toggle="popover">
                        <i class="glyphicon glyphicon-cogs" style="margin-right: 5px"></i>Фильтр столбцов
                    </button>
                </div>
                <div class="col-lg-12 form-inline" style="text-align: center">
                    @if(isset($folders))
                            <div class="pager2">
                                <select class="form-control" name="step" id="step">
                                    @for($i=0;$i*(int)Input::get('step_length',10)<$count;$i++)
                                        <option value="{{$i}}" {{Input::get('step',0)==$i?'selected':''}}>Страниц {{$i+1}}</option>
                                    @endfor
                                </select>
                                <span class="first glyphicon glyphicon-step-backward" alt="First" title="First page" ></span>
                                <span class="prev glyphicon glyphicon-chevron-left" alt="Prev" title="Previous page" ></span>
                                <span class="pagedisplay">{{Input::get('step',0)*Input::get('step_length',10) + 1}} - {{((Input::get('step',0)+1)*Input::get('step_length',10))>$count?$count:(Input::get('step',0)+1)*Input::get('step_length',10)}}/{{$count}}</span> <!-- this can be any element, including an input -->
                                <span class="next glyphicon glyphicon-chevron-right" alt="Next" title="Next page" ></span>
                                <span class="last glyphicon glyphicon-step-forward" alt="Last" title= "Последняя страница" ></span>
                                <select class="form-control" name="step_length" id="step_length">
                                    @for($i=10;40>=$i;$i+=10)
                                        <option value="{{$i}}" {{Input::get('step_length',10)==$i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        @endif
                </div>
            </form>
            <div class="col-lg-12" style="float: left">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th class="sortable">Статус</th>
                        <th class="sortable">Направление</th>
                        <th class="sortable">ФИО</th>
                        <th>Пол</th>
                        <th class="sortable">Дата регистрации</th>
                        <th style="display: {{ (!isset($_COOKIE["birth_column"       ]) || $_COOKIE["birth_column"       ]==1)?'table-cell':'none' }}" class="birth_column"          >Дата рождения</th>
                        <th style="display: {{ (!isset($_COOKIE["sortable lpu_column"]) || $_COOKIE["sortable lpu_column"]==1)?'table-cell':'none' }}" class="sortable lpu_column"   >ЛПУ</th>
                        <th style="display: {{ (!isset($_COOKIE["org_column"         ]) || $_COOKIE["org_column"         ]==1)?'table-cell':'none' }}" class="org_column"            >Организация</th>
                        <th style="display: {{ (!isset($_COOKIE["doctor_column"      ]) || $_COOKIE["doctor_column"      ]==1)?'table-cell':'none' }}" class="doctor_column"         >Доктор</th>
                        <th style="display: {{ (!isset($_COOKIE["policy_column"      ]) || $_COOKIE["policy_column"      ]==1)?'table-cell':'none' }}" class="policy_column"         >Страховая компания</th>
                        <th style="display: {{ (!isset($_COOKIE["comment_column"     ]) || $_COOKIE["comment_column"     ]==1)?'table-cell':'none' }}" class="comment_column"        >Комментарий</th>
                        <th style="display: {{ (!isset($_COOKIE["price_column"       ]) || $_COOKIE["price_column"       ]==1)?'table-cell':'none' }}" class="price_column"          >Цена по прайсу</th>
                        <th style="display: {{ (!isset($_COOKIE["cost_column"        ]) || $_COOKIE["cost_column"        ]==1)?'table-cell':'none' }}" class="cost_column"           >Цена с учетом скидки</th>
                        <th style="display: {{ (!isset($_COOKIE["procent_column"     ]) || $_COOKIE["procent_column"     ]==1)?'table-cell':'none' }}" class="procent_column"        >Скидка</th>
                        <th><span id='printAll' class='glyphicon glyphicon-print' onclick="printSel(); return false;"></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($folders as $val)
                        <tr>
                            <td style="color:{{$val['STATUSCOLOR']}}; font-weight: bold;">{{$val['STATUSNAME']}}</td>
                            <td><a target="_blank" href='{{in_array($val['STATUSNAME'],['Черновик','Курьер'])? secure_url('draft/'.$val['FOLDERNO']) : secure_url('request/'.$val['FOLDERNO'])}}'>{{$val['FOLDERNO']}}</a></td>
                            <td>{{$val['SURNAME']." ".$val['NAME']." ".$val['PATRONYMIC']}}</td>
                            <td>{{$val['GENDER']=='F' ? 'Ж' : 'М'}}</td>
                            <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
                            <td style="display: {{ (!isset($_COOKIE["birth_column"       ]) || $_COOKIE["birth_column"       ]==1)?'table-cell':'none' }}" >{{date('d.m.Y',strtotime($val['DATE_BIRTH']))}}</td>
                            <td style="display: {{ (!isset($_COOKIE["sortable lpu_column"]) || $_COOKIE["sortable lpu_column"]==1)?'table-cell':'none' }}" >{{stripslashes($val['DEPT'])}}</td>
                            <td style="display: {{ (!isset($_COOKIE["org_column"         ]) || $_COOKIE["org_column"         ]==1)?'table-cell':'none' }}" >{{$val['ORG']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["doctor_column"      ]) || $_COOKIE["doctor_column"      ]==1)?'table-cell':'none' }}" >{{$val['DOCTOR']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["policy_column"      ]) || $_COOKIE["policy_column"      ]==1)?'table-cell':'none' }}" >{{$val['STR']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["comment_column"     ]) || $_COOKIE["comment_column"     ]==1)?'table-cell':'none' }}" >{{$val['COMMENTS']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["price_column"       ]) || $_COOKIE["price_column"       ]==1)?'table-cell':'none' }}" >{{$val['PRICE']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["cost_column"        ]) || $_COOKIE["cost_column"        ]==1)?'table-cell':'none' }}" >{{$val['COST']}}</td>
                            <td style="display: {{ (!isset($_COOKIE["procent_column"     ]) || $_COOKIE["procent_column"     ]==1)?'table-cell':'none' }}" >{{$val['DISCOUNT']}}</td>
                            <td><input type='checkbox' id='{{$val['FOLDERNO']}}' class='prn-cbox' /></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .tablesorter-icon{
            display: block !important;
        }
    </style>
    @include('modules.folderExcel')
    @stop
    @section('script')
        @if(isset($folders))
            <script>
                $(function(){
                    $('.first').click(function(){
                        $('#step').val(0);
                        $(this).closest('form').submit();
                    });
                    $('.last').click(function(){
                        $('#step').val({{floor($count/Input::get('step_length',10))}});
                        $(this).closest('form').submit();
                    });
                    @if(Input::get('step',0)!=(floor($count/Input::get('step_length',10))))
                    $('.next').click(function(){
                                $('#step').val(parseInt($('#step').val())+1);
                                $(this).closest('form').submit();
                            });
                    @endif
                    @if(Input::has('step') && Input::get('step')!=0)
                    $('.prev').click(function(){
                                $('#step').val(parseInt($('#step').val())-1);
                                $(this).closest('form').submit();
                            });
                    @endif
                    var f_sl = 1;
                    $(".sortable").click(function(){
                        f_sl *= -1;
                        if($(this).find('i.fa.fa-caret-up').length){
                            $(this).find('i').remove();
                            $(this).append('<i class="fa fa-caret-down" aria-hidden="true"></i>')
                        }
                        else if($(this).find('i.fa.fa-caret-down').length){
                            $(this).find('i').remove();
                            $(this).append('<i class="fa fa-caret-up" aria-hidden="true"></i>')
                        } else {
                            $(this).append('<i class="fa fa-caret-down" aria-hidden="true"></i>');
                            $(this).siblings().find('i.fa.fa-caret-up').remove();
                            $(this).siblings().find('i.fa.fa-caret-down').remove();
                        }
                        var n = $(this).prevAll().length;
                        sortTable(f_sl,n);
                    });
                });
                function sortTable(f,n){
                    var rows = $('.table tbody  tr').get();

                    rows.sort(function(a, b) {

                        var A = getVal(a);
                        var B = getVal(b);

                        if(A < B) {
                            return -1*f;
                        }
                        if(A > B) {
                            return 1*f;
                        }

                        return 0;
                    });

                    function getVal(elm){
                        var v = $(elm).children('td').eq(n).text().toUpperCase();
                        if($.isNumeric(v)){
                            v = parseInt(v,10);
                        }
                        return v;
                    }

                    $.each(rows, function(index, row) {
                        $('.table').children('tbody').append(row);
                    });
                }
            </script>
        @endif
        @stop
