@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/materials.css')}}" rel="stylesheet">
    <div id="materials">
        <h1>МАТЕРИАЛЫ</h1>
        <div class="row">
            <div class="col-lg-5">
                {!! Form::open(['method'=>'post', 'class'=>'form-inline', 'style'=>'margin:2%']) !!}
                {!! Form::label('dept', 'Выбор отделения', ['style'=>'font-size:1.2em']) !!}
                <select name="dept" class="form-control">
                    <option value="">Все</option>
                    @foreach($depts as $val)
                        <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                        @endforeach
                </select>
                {!! Form::submit('Обновить', ['class'=>'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-lg-6">
                <div class="btn-group" style="margin: 2%">
                    <button class="btn btn-default" data-toggle="modal" data-target="#matAdd"> Добавить материал</button>
                </div>
            </div>
            <div class="col-lg-12">
                <ul>
                    <li><span style="font-size: 1.3em;"><i class="glyphicon glyphicon-minus"></i>Корневой элемент</span>
                        <ul>
                            <li><span style="font-size: 1.2em;"><i class="glyphicon glyphicon-minus"></i>Лабораторные</span>
                                <ul>
                                    <li>
                                        <table class="table table-striped" id="lab">
                                            <tr>
                                                <th>Название</th>
                                                <th>Количество единиц</th>
                                                <th>Количество упаковок</th>
                                                <th>ЛПУ</th>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>
                            </li>
                            <li><span style="font-size: 1.2em;"><i class="glyphicon glyphicon-minus"></i>Уличные</span>
                                <ul>
                                    <li>
                                        <table class="table table-striped" id="lec">
                                            <tr>
                                                <th>Название</th>
                                                <th>Количество единиц</th>
                                                <th>Количество пачет</th>
                                                <th>Отделение</th>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('modules.mat')
    @include('scripts.materials')
    @stop