@extends('default')
@section('content')
    <div id="infoBlock">
        <div class="row">
            <div class="col-lg-12">
                <h2 style="margin-bottom: 20px; color: #49B1C2; font-size:1.7em">ИНФОРМАЦИЯ</h2>

                {!! Form::open(['method'=>'get', 'class'=>'form-inline']) !!}
                {!! Form::label('search', 'Поиск по раннее опубликованной информации', ['style'=>'font-size: 1.2em;']) !!}
                {!! Form::text('search', null, ['placeholder'=>'Введите текст', 'class'=>'form-control search']) !!}
                {!! Form::submit('Поиск',['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
            @if(isset($error))
                @foreach($res as $val)
            <div class="col-lg-12" style="margin-bottom: 15px;margin-top: 25px">
                <pre>Дата публикации:  <b>{{date('d.m.Y', strtotime($val['LOGDATE']))}}</b>         Автор: <b>{{$val['USERNAME']}}</b>       Тема: <b>{{$val['CAPTION']}}</b></pre>
            </div>
            <div class="col-lg-12" style="border-bottom: 1px #49B1C2 dashed; padding-bottom: 30px;">
                <? echo $val['BODY'] ?>
            </div>
                @endforeach
            @else
                <div class="col-lg-12">
                    <pre>
                        <b style="color: #2b669a">{{$error}}</b>
                    </pre>
                </div>
                @endif
        </div>
    </div>
    @stop