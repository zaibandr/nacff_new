@extends('default')
@section('content')
    <style type="text/css">
        #nets
        {
            padding: 2%;
            background: rgba(233, 237, 240, 0.42);
        }
    </style>
    <div id="nets">
        <h1>Редактировать сеть</h1>
        {!! Form::open(['url'=>'page72']) !!}
        {!! Form::label('name','Название') !!}
        {!! Form::text('name',$net[0]['NETNAME'],['class'=>'form-control']) !!}
        {!! Form::label('comment','Комментарий') !!}
        {!! Form::text('comment',$net[0]['COMMENTS'],['class'=>'form-control']) !!}
        {!! Form::submit('Сохранить', ['class'=>'btn btn-sm btn-success', 'style'=>'margin-top:2%']) !!}
        {!! Form::close() !!}
    </div>
@stop