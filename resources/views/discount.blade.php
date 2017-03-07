@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/discount.css')}}" rel="stylesheet">
    <div id="discount">
        <h1>ПРОГРАММЫ СКИДОК</h1>
        <div class="row">
            <div class="col-lg-12">
                <form action="" class="form-inline" method="get">
                    <div class="form-group">
                        <label for="dept"> Отделение: </label>
                        <select name="dept" class="form-control" id="dept" style="margin-left: 10px; margin-right: 10px">
                            @foreach($depts as $val)
                                <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit"><span class=""></span>Обновить</button>
                    </div>

                    {{csrf_field()}}
                </form>
                <button class="btn btn-primary" data-toggle="modal" data-target="#dis" style="float: right;">Создать правило</button>
                <div class="col-lg-12">
                    <table class="table table-striped" style="margin-top: 20px">
                        <tr>
                            <th>Название скидки</th>
                            <th>Процент, %</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($rules as $val)
                            <tr style="background: {{$val['STATUS']=='A'?'':'rgba(195, 61, 30, 0.31)'}}">
                                <td>
                                    {{$val['RULENAME']}}
                                </td>
                                <td>{{$val['PER']}}</td>
                                <td><button class="btn btn-primary fa fa-pencil " data-toggle="modal" data-target="#dis2" onclick="modal(this, {{$val['ID']}})"> Редактировать</button></td>
                                <td>
                                    {!! Form::open(['method'=>'get', 'url'=>'page47/'.$val['ID'].'/edit']) !!}
                                    {!! Form::text('status',$val['STATUS']=='A'?'R':'A',['hidden']) !!}
                                    {!! Form::submit($val['STATUS']=='A'?'Отключить':'Включить', ['class'=>"btn btn-warning fa fa-refresh"]) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                        {!! Form::open(['method'=>'delete', 'url'=>'page47/'.$val['ID']]) !!}
                                        {!! Form::submit('Удалить', ['class'=>"btn btn-danger fa fa-times"]) !!}
                                        {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('modules.discount')
    @stop