@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/departments.css')}}" rel="stylesheet">
    <div id="departments">
        <h1>ОТДЕЛЕНИЯ ЦЕНТРА</h1>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 10px">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#depAdd" style="float: right;">Добавить отделение</button>
            </div>
            <div class="col-lg-12">
                <table class="table table-striped" style="margin-top: 2%">
                    <tr>
                        <th style="font-size: 1.2em">Название</th>
                        <th></th>
                        
                    </tr>
                @foreach($depts as $val)
                    <tr>
                        <td>{{$val['DEPT']}}</td>
                        <!--td><button class="btn btn-default" data-toggle="modal" data-target="#deptEdit">Редактировать</button></td-->
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=>'page20/'.$val['ID']]) !!}
                            {!! Form::submit('Удалить', ['class'=>"btn btn-danger fa fa-times"]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @include('modules.depAdd')
    @stop