@extends('default')
@section('content')
    <div id="pretence">
        <h1>Претензии</h1>
        @foreach ($posts as $post)
            {{ $post->id }}
        @endforeach
        {!! $posts->render() !!}
    </div>
    <style>
        #pretence
        {
            padding: 2%;
            background: rgba(233, 237, 240, 0.42);
            line-height: 2.2em;
        }
    </style>
    @stop