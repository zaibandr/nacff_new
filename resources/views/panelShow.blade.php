@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/price.css')}}" rel="stylesheet">
    <div id="pricePage">
        <h1>Панель {{Input::get('id','')}}</h1>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <b style="margin: 2% 0; font-size:1.2em; display: block">{{$panel[0]['COALESCE']}}</b>
                <p>{{$panel[0]['DESCRIPTION']}}</p>
                {{--<a href="javascript:history.go(-1)" class="btn btn-success">Назад</a>--}}
            </div>
        </div>
    </div>
    @stop