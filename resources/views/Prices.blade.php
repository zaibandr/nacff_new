@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{secure_asset('resources/assets/css/price.css')}}" rel="stylesheet">
    @include('scripts.priceScript')

    <div id="pricePage">
        <h1>ПРАЙС-ЛИСТЫ</h1>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" class="form-inline" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <span>Выберите ЛПУ:</span><select name="dept" class="form-control">
                        <option value="" selected disabled></option>
                @foreach($depts as $key=>$val)
                    <option value='{{$val['ID']}}' {{Input::get('dept')==$val['ID']?"selected ":""}}>{{$val['DEPT']}}</option>
                    @endforeach
                    </select>
                    {!! Form::file('excel') !!}
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </form>
                @if(Input::has('dept'))
                <table class="tablesorter">
                    <thead>
                        <tr>
                            <td data-placeholder="#">Код панели</td>
                            <td data-placeholder="#">Название панели</td>
                            <td data-placeholder="#">Комментарии</td>
                            <td data-placeholder="#">Цена</td>
                            <td data-placeholder="#">Цена НАКФФ</td>
                            <td data-placeholder="#">Срок выполнения (дни)</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $val)
                        <tr><td>{{$val[1]}}</td>
                            <td>{{$val[2]}}</td>
                            <td>{{$val[4]}}</td>
                            <td>{{$val[0]}}</td>
                            <td>{{$val[3]}}</td>
                            <td>{{$val[5]}}</td>
                            <td><i class="fa fa-edit" data-toggle="modal" data-target="#edit" onclick="modal(this, '{{$val[1]}}')" style="cursor: pointer"></i>
                                <a href="{{route('page50.show',['dept'=>Input::get('dept',''),'id'=>$val[1]])}}" target="_blank" aria-label="Преаналитика"><i class="fa fa-search" ></i></a></td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                    @endif
            </div>
        </div>
    </div>
    @include('modules.priceEdit')
    @stop