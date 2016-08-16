@extends('default')
@section('content')
<div id="test" style="padding: 2%; background: rgba(233, 237, 240, 0.42);">
    <h1 style="margin-bottom:2% ">Исследования</h1>
    <table class="table table-striped">
        <tr>
            <td>Название</td>
            <td>Необходимое количество, мл</td>
            <td></td>
        </tr>
        @foreach($tests as $val)
        <tr>
            <td>{{$val['TESTNAME']}}</td>
            {!! Form::open(['method'=>'get', 'url'=>url('page71/'.$val['ID'].'/edit')]) !!}
            <td>{!! Form::text('quantity', $val['QUANTITY']?$val['QUANTITY']:'') !!}</td>
            <td>{!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}</td>
            {!! Form::close() !!}
        </tr>
            @endforeach
    </table>
</div>
    @stop