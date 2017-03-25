@extends('default')
@section('content')
    <div id="pretence">
        <h1 style="margin-bottom: 4%">Журнал ошибок</h1>
        @if(count($posts))
        {!! $posts->render() !!}
        <table class="table table-bordered">
            <tr>
                <th>Дата</th>
                <th>Номер направления</th>
                <th>ФИО</th>
                <th>Ошибка</th>
            </tr>
        @foreach ($posts as $post)
            <tr>
                <td>{{date('d-m-Y', strtotime($post->dt))}}</td>
                <td><a href="{{route('request.show',$post->folderno)}}">{{$post->folderno}}</a></td>
                <td>{{$post->fio}}</td>
                <td>{{$post->mistake}}</td>
            </tr>
        @endforeach
        </table>
            @else
            <i>Никаких ошибок не выявлено</i>
        @endif
    </div>
    <style>
        #pretence
        {
            padding: 2%;
            background: rgba(233, 237, 240, 0.42);
            line-height: 2.2em;
            text-align: center;
        }
        td
        {
            text-align: left;
        }
        table tr:nth-child(odd)
        {
            background: rgba(246, 231, 233, 0.62);
        }
        table tr:nth-child(even)
        {
            background: rgba(247, 129, 129, 0.14);
        }
        table tr th
        {
            background: whitesmoke;
        }
    </style>
@stop