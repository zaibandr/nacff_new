@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/price.css')}}" rel="stylesheet">
    @include('scripts.priceScript')
    <div id="pricePage">
        <h1>УСЛУГИ ЛПУ</h1>
        <div class="row">
         <div class="col-md-12">
                <form action="" method="post" class="form-inline">
                    {{csrf_field()}}
                    <span>Выберите отделение:</span><select name="dept" class="form-control">
                        <option value="" selected disabled></option>
                        @foreach($depts as $val){
                            <option value='{{$val['ID']}}' {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </form>
                @if(Input::has('dept'))
                    <table class="tablesorter">
                        <thead>
                        <tr>
                            <td data-placeholder="#">Код панели</td>
                            <td data-placeholder="#">Название панели</td>
                            <td data-placeholder="#">Цена</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $val)
                            <tr>
                                <td>{{$val['CODE']}}</td>
                                <td>{{$val['NAME']}}</td>
                                <td>{{$val['PRICE']}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

@stop