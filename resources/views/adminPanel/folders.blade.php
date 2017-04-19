@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/requests.css')}}" rel="stylesheet">
    @include('scripts.requestScript')
    <div id="requests">
        <h1 style="margin-bottom: 2%">СПИСОК НАПРАВЛЕНИЙ</h1>
                <form action="" method="post" class="form-inline">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-12" style="margin-top: 3%">
                            <div class="row">
                                {{ csrf_field() }}
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label for="input-date-start">Период: </label>
                                        <input id="input-date-start" name="date_st" type="text" class="form-control datepicker" value="{{ $request->input('date_st',date('d.m.Y',strtotime('-3 days'))) }}">
                                        <label for="input-date-end">-</label>
                                        <input id="input-date-end" name="date_en" type="text" class="form-control datepicker" value="{{ $request->input('date_en',date('d.m.Y')) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group" style="margin-left: 5%">
                                        <label for="lpu">ЛПУ</label>
                                        <input type="number" name="lpu" class="form-control" value="{{Input::get('lpu','')}}">
                                    </div>
                                </div>
                                <div class="col-md-12 pull-right">
                                    <button type="submit" class="btn btn-default">Применить</button>
                                    <button type="button" class="btn btn-danger" onclick="formReset()">Сброс</button>
                                </div>
                            </div>
                        </div>
                        @if(isset($folders))
                        <div class="col-lg-6 col-lg-offset-3">
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
                        </div>
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
                                });
                            </script>
                            @endif
                    </div>
                </form>
            </div>
        @if(isset($error)) <b style="color: red">Error</b> @endif
        @if(isset($folders))
        <table class="table table-striped">
            <thead>
            <tr>
                <th >Статус</th>
                <th >Направление</th>
                <th >ФИО</th>
                <th >Пол</th>
                <th >Дата регистрации</th>
                <th >Дата рождения</th>
                <th >ЛПУ</th>
                <th >Комментарий</th>
                <th >Цена по прайсу</th>
                <th >Цена с учетом скидки</th>
                <th >Скидка</th>
                <th class="filter-false"><span id='printAll' class='glyphicon glyphicon-print' onclick="printSel(); return false;"></span></th>
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
    @stop