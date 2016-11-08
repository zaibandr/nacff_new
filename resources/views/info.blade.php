@extends('default')
@section('content')
    <div id="infoBlock">
        <div class="row">
            <div class="col-lg-12">
                <h2 style="margin-bottom: 20px; color: #49B1C2; font-size:1.7em">ИНФОРМАЦИЯ</h2>

                {!! Form::open(['method'=>'get', 'class'=>'form-inline']) !!}
                {!! Form::label('search', 'Поиск по раннее опубликованной информации', ['style'=>'font-size: 1.2em;']) !!}
                {!! Form::text('search', Input::get('search',''), ['placeholder'=>'Введите текст', 'class'=>'form-control search']) !!}
                {!! Form::submit('Поиск',['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-lg-12" style="text-align: center; margin-top: 1%;">
                {!! $res->render() !!}
            </div>
            @if(isset($error))
                @foreach($res as $val)
                    <div class="col-lg-12">
                        <div class="row" style="padding:1%; border: 1px solid grey; border-radius: 15px; background: rgba(168, 218, 226, 0.45);">
                            <div class="col-lg-3">Дата публикации:  <b>{{date('d.m.Y', strtotime($val->LOGDATE))}}</b></div>
                            <div class="col-lg-4">Автор: <b>{{preg_replace('/\n\r/','',$val->USERNAME)}}</b>     </div>
                            <div class="col-lg-5">Тема: <b>{{$val->CAPTION}}</b></div>
                        </div>
                    </div>
            <div class="col-lg-12" style="border-bottom: 1px #49B1C2 dashed; padding-bottom: 30px;">
                {!! strip_tags(preg_replace($re,'',$val->BODY),'<p><li><ul><b><i>') !!}
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