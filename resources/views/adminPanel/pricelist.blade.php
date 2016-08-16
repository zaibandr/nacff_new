@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    @include('scripts.deptAdminScript')
    <div id="lpu">
        <h1>Прайс-лист #{{$id}}</h1>
        <table class="tablesorter">
            <thead>
            <tr>
                <td>Код</td>
                <td>Название</td>
                <td>Цена</td>
                <td>Цена НАКФФ</td>
                <td>Длительность</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($price as $val)
                <tr>
                    <td>{{$val['CODE']}}</td>
                    <td>{{$val['COALESCE']}}</td>
                    <td>{{$val['COST']}}</td>
                    <td>{{$val['NACPH']}}</td>
                    <td>{{$val['DUE']}}</td>
                    <td>
                        <i class="fa fa-cog fa-2x" data-target="#edit" data-toggle="modal" onclick="modal(this)"></i>
                        {!! Form::open(['method'=>'get', 'url'=>'page68/'.$id.'/edit', "onSubmit"=>"return isDel();"]) !!}
                        <i class="fa fa-trash-o fa-2x" onclick="$(this).closest('form').submit()"></i>
                        {!! Form::hidden('del', $val['CODE']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="modal fade bs-example-modal" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать панель</h4>
                </div>
                <form action="{{url('page68/'.$id.'/edit')}}" method="get">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <label for="code">Код</label>
                                    <input type="text" name="code" id="code" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <label for="panel">Название</label>
                                    <input type="text" name="panel" id="panel">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <label for="cost">Цена</label>
                                    <input type="text" name="cost" id="cost">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <label for="costn">Цена НАКФФ</label>
                                    <input type="text" name="costn" id="costn">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <label for="due">Длительность</label>
                                    <input type="text" name="due" id="due">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary"> Сохранить </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        @stop