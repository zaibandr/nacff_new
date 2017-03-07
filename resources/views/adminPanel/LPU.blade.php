@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    @include('scripts.LPU')
    <div id="lpu">
        <h1>Список ЛПУ</h1>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{route("page66.create")}}" class="btn btn-primary" style="margin: 2%">Добавить пользователя</a>
            </div>
        </div>
        <table class="tablesorter">
            <thead>
            <tr>
                <th>Логин</th>
                <th>Пароль</th>
                <th>ЛПУ</th>
                <th>Отделения</th>
                <th>Права</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($lp as $key=>$val)
                @foreach($val['role'] as $k=>$v)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$val['pass']}}</td>
                    <td>
                        @foreach($v as $vv)
                            {{$vv['number']}}<br>
                            @endforeach
                    </td>
                    <td>
                        @foreach($v as $vv)
                            {{$vv['dept']}}<br>
                        @endforeach</td>
                    <td>{{$k}}</td>
                    <td>
                        <button class="btn btn-default" data-toggle="modal" data-target="#edit" onclick="modal(this)"><i class="fa fa-edit fa-2x"></i></button>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'delete', 'url'=>'page66/'.$key, "onSubmit"=>"return isDel();"]) !!}
                        {!! Form::button('<i class="fa fa-trash-o fa-2x"></i>', ['type'=>"submit", 'class'=>'btn btn-default']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @include('modules.LPUModalEdit')
    @stop