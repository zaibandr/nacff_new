@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/stat.css')}}" rel="stylesheet">
    @include('scripts.statScript')
    <div id="stat">
        <h1>СТАТИСТИКА</h1>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 2%">
                <form action="" class="form-inline" method="POST">
                    <div class="form-group" style="float: left">
                        <label for="stat">Отчет</label>
                        <select name="stat" id="sel" class="form-control">
                            <option value="" selected disabled>Выберите отчет</option>
                            <option value="0" {{Input::get('stat')==0?'selected':''}}>Статистика по исследованиям</option>
                            <option value="1" {{Input::get('stat')==1?'selected':''}}>Первичные/повторные пациенты</option>
                            <option value="2" {{Input::get('stat')==2?'selected':''}}>Количество направлений по ЛО</option>
                            <option value="3" {{Input::get('stat')==3?'selected':''}}>По врачам</option>
                            <option value="4" {{Input::get('stat')==4?'selected':''}}>Количество проб по дням</option>
                            <option value="5" {{Input::get('stat')==5?'selected':''}}>Откуда узнали</option>
                        </select>
                    </div>
                    <div class="input-daterange input-group" id="datepicker" style="margin-left: 1%">
                        <span class="input-group-addon">за период с </span>
                        <input type="text" class="form-control" name="date_st" value="{{Input::get('date_st',date('d.m.Y',strtotime("-3 days")))}}"/>
                        <span class="input-group-addon">по</span>
                        <input type="text" class="form-control" name="date_en" value="{{Input::get('date_en',date('d.m.Y'))}}"/>
                    </div>
                    <div class="form-group">
                        <label for="dept">Отделение</label>
                        <select name="dept" class="form-control">
                            <option value="all">Все</option>
                            @foreach($depts as $val)
                                <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                @endforeach
                        </select>
                    </div>
                    <br>
                    <br>
                    <div class="form-group" style="float: right">
                        <input type="hidden" name="excel" id="excel" value="0">
                        <button type="submit" class="btn btn-primary " onclick="$('#excel').val(1)"><span class="glyphicon glyphicon-file"></span>Excel </button>
                        <button type="submit" class="btn btn-primary " onclick="$('#excel').val(0)"> <span class="glyphicon glyphicon-refresh"></span>Обновить</button>
                    </div>

                    {{csrf_field()}}
                </form>
            </div>
            @if(Input::has('stat') && Input::get('stat')!=='')
                @if(Input::get('stat')==0)
                    @include('parts.stat0')
                @elseif(Input::get('stat')==1)
                    @include('parts.stat1')
                @elseif(Input::get('stat')==2)
                    @include('parts.stat2')
                @elseif(Input::get('stat')==3)
                    @include('parts.stat3')
                @elseif(Input::get('stat')==4)
                    @include('parts.stat4')
                @elseif(Input::get('stat')==5)
                    @include('parts.stat5')
                    @endif
                @endif
        </div>
    </div>
    @stop