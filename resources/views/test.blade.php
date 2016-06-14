<h1>Загрузка преаналитики</h1>
{!! Form::open(['method'=>'post', 'enctype'=>"multipart/form-data"]) !!}
{!! Form::file('excel') !!}
{!! Form::submit('load') !!}
{!! Form::close() !!}
<h1>Загрузка картинок контейнеров</h1>
{!! Form::open(['method'=>'post', 'enctype'=>"multipart/form-data"]) !!}
{!! Form::file('img') !!}
{!! Form::submit('load') !!}
{!! Form::close() !!}