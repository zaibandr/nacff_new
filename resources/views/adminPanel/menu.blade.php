@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>НАстройка Меню</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin: 2%">Добавить меню</button>
        <table class="table table-striped table-bordered">
            <tr>
                <th></th>
                @foreach($b as $val)
                    <th>{{$val}}</th>
                    @endforeach
            </tr>
            @foreach($menu as $key=>$val) <? $i=0 ?>
                <tr>
                <th>{{$key}}</th>
                @foreach($b as $v)
                    @if(array_key_exists($v,$val))
                        @if($val[$v]=='Y')
                            <td style="text-align: center; color: green">
                                {!! Form::open(['method'=>'get', 'url'=>'page69/'.$v.'.'.$key.'.'.$val[$v].'/edit']) !!}
                                {!! Form::button('<i class="fa fa-2x fa-check"></i>',['type'=>"submit", 'class'=>'btn']) !!}
                                {!! Form::close() !!}
                            </td>
                            @else
                            <td style="text-align: center; color: red">
                                {!! Form::open(['method'=>'get', 'url'=>'page69/'.$v.'.'.$key.'.'.$val[$v].'/edit']) !!}
                                {!! Form::button('<i class="fa fa-2x fa-times"></i>',['type'=>"submit", 'class'=>'btn']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                        @else
                        <td style="text-align: center; ">
                            {!! Form::open(['method'=>'get', 'url'=>'page69/'.$v.'.'.$key.'.D/edit']) !!}
                            {!! Form::button('<i class="fa fa-2x fa-times"></i>',['type'=>"submit", 'class'=>'btn']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
    <div class="modal fade bs-example-modal-lg" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Добавить меню</h4>
                </div>
                {!! Form::open(['method'=>'post'])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('name', 'Название') !!}
                            {!!Form::text('name', null, ['class'=>'form-control', 'required', 'style'=>'margin-bottom:2%; width:90%'])!!}
                            {!! Form::label('cat', 'Категория:') !!}
                            {!!Form::select('cat', $a, null, ['class'=>'form-control', 'required', 'style'=>'width:90%; margin-bottom:2%'])!!}
                            {!! Form::label('role', 'Роль:') !!}
                            <select name="role" id="" style="width:90%; margin-bottom:2%" class="form-control" required>
                                @foreach($b as $val)
                                    <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @stop