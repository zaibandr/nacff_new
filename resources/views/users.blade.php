@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/user.css')}}" rel="stylesheet">
    <div id="user">
        <H1>АДМИНИСТРИРОВАНИЕ ПОЛЬЗОВАТЕЛЕЙ</H1>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 10px">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#userAdd" style="float: right;">Зарегистрировать пользователя</button>
            </div>
            <col-lg-12>
                <table class="table table-striped">
                    <tr>
                        <th>Логин</th>
                        <th>Пользователь</th>
                        <th>Пароль</th>
                        @foreach($a as $val)
                            <th>{{$val}}</th>
                            @endforeach
                        <th>Статус</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($b as $k=>$v)
                        @if(!isset($v['show']) || $v['show']!==0)
                        <tr>
                            <td>{{$k}}</td>
                        @foreach($v as $vv)
                            @if($vv==1)
                                <td style="color: green"><i class="fa fa-check"></i></td>
                            @elseif($vv===0)
                                <td style="color: red"><i class="fa fa-close"></i></td>
                            @elseif($vv=='A')
                                <td>
                                    {!! Form::open(['method'=>'get', 'url'=>'page6/'.$k.'/edit']) !!}
                                    {!! Form::text('status','R',['hidden']) !!}
                                    {!! Form::submit('Активный', ['class'=>"btn btn-success fa fa-refresh"]) !!}
                                    {!! Form::close() !!}
                                </td>
                                @elseif($vv=='R')
                                    <td>
                                        {!! Form::open(['method'=>'get', 'url'=>'page6/'.$k.'/edit']) !!}
                                        {!! Form::text('status','A',['hidden']) !!}
                                        {!! Form::submit('Отключен', ['class'=>"btn btn-danger fa fa-refresh"]) !!}
                                        {!! Form::close() !!}
                                    </td>
                            @else
                                <td>{{$vv}}</td>
                            @endif
                            @endforeach
                            <td><button class="btn btn-default" data-toggle="modal" data-target="#userEdit" onclick="modal(this, '{{$k}}')">Редактировать</button></td>
                            <td>
                                {!! Form::open(['method'=>'delete', 'url'=>'page6/'.$k, "onSubmit"=>"return isDel();"]) !!}
                                {!! Form::submit('Удалить', ['class'=>"btn btn-danger fa fa-times"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                </table>
            </col-lg-12>
        </div>
    </div>
    @include('modules.userAdd')
    @include('scripts.userScript')
    @stop