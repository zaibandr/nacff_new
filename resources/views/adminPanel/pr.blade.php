@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/price.css')}}" rel="stylesheet">
    @include('scripts.PRScript')
<div id="pricePage">
    <h1>Панели без преаналитики</h1>
    <table class="tablesorter">
        <thead>
        <tr>
            <td>Панель</td>
            <td>Код</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($panels as $val)
            <tr>
                <td>{{$val['CODE']}}</td>
                <td>{{$val['PANEL']}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit" class="btn-primary btn" onclick="edit('{{$val['CODE']}}','{{$val['PANEL']}}')">Редактировать</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <div class="modal fade bs-example-modal-lg" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать панель</h4>
                </div>
                {!! Form::open(['method'=>'post'])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('code', 'Панель') !!}
                            {!! Form::text('code', null, ['class'=>'form-control', 'id'=>'code','required', 'style'=>'margin-bottom:2%', 'readonly'])!!}
                            {!! Form::label('name', 'Название') !!}
                            {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name','required', 'style'=>'margin-bottom:2%', 'readonly'])!!}
                            <div class="row">

                                <div class="col-md-6">
                                    {!! Form::label('mod1', 'Использовать преаналитику панели') !!}
                                    {!! Form::radio('mod','mod2',true) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('mod2', 'Ввести новую') !!}
                                    {!! Form::radio('mod','mod1',false) !!}
                                </div>
                            </div>
                            {!! Form::label('panel', 'Код панели') !!}
                            {!! Form::text('panel',null,['class'=>'form-control', 'id'=>'panel', 'style'=>'margin-bottom:2%', 'placeholder'=>'Введите панель','required']) !!}
                            {!! Form::label('desc', 'Описание') !!}
                            {!! Form::textarea('desc', null, ['class'=>'form-control', 'id'=>'desc', 'style'=>'margin-bottom:2%', 'readonly', 'required'])!!}

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