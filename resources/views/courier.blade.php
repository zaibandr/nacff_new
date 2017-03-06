@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/LPU.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>Курьер</h1>
        <div class="row" style="margin: 2% 0">
            <div class="col-lg-2">
                {!! Form::open(['method'=>'post', 'url'=>route('page73.store'), 'target'=>'_blank']) !!}
                {!! Form::submit('Сформировать Акт', ['class'=>"btn btn-warning"]) !!}
                {!! Form::close() !!}
            </div>
            <div class="col-lg-2">
                {!! Form::open(['method'=>'post', 'url'=>route('page73.store')]) !!}
                {!! Form::hidden('send',1) !!}
                {!! Form::submit('Отправлено', ['class'=>"btn btn-success"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <table class="table table-striped">
            <tr>
                <th>Тип контейнера</th>
                <th>Количество</th>
            </tr>
            @if(count($a)<1)
                <tr><td colspan="2"><i>Контейнеров к отгрузке нет</i></td></tr>
                @endif
            @foreach($a as $key=>$val)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$val}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@stop