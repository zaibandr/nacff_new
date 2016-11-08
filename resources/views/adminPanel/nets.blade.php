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
    <h1>Сети</h1>
    <a class="btn btn-sm btn-primary" style="margin: 2%" href="{{url('page72/create')}}">Добавить</a>
    <table class="table table-condensed table-bordered table-striped">
        <tr>
            <th>Сеть</th>
            <th>Комментарий</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($nets as $val)
        <tr>
            <td width="30%">{{$val['NETNAME']}}</td>
            <td width="50%">{{$val['COMMENTS']}}</td>
            <td width="10%"><a href="{{route('page72.edit',['id'=>$val['ID']])}}" class="btn btn-warning">Редактировать</a></td>
            <td width="10%">
                {!! Form::open(['route'=>['page72.destroy',$val['ID']]]) !!}
                {!! Form::hidden('_method','delete') !!}
                {!! Form::submit('Удалить',['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
        </tr>
            @endforeach
    </table>
</div>
    @stop