@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/tablesorter.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/theme.dropbox.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/service.css')}}" rel="stylesheet">
    @include('scripts.serviceScript')
    <div id="pricePage">
        <h1>УСЛУГИ ЛПУ</h1>
        <div class="row">
         <div class="col-md-10">
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
         </div>
            @if(Input::has('dept'))
            <div class="col-md-2" style="padding-top: 2%;">
                 <button data-target="#serviceAdd" data-toggle="modal" class="btn btn-primary">Добавить</button>
             </div>

            <div class="col-md-12">
                @if(isset($error) && $error!=='')
                    <b style="color: #a94442">{{$error}}</b>
                @endif
            </div>
            <div class="col-md-12">

                    <table class="tablesorter">
                        <thead>
                        <tr>
                            <td data-placeholder="#">Код панели</td>
                            <td data-placeholder="#">Название панели</td>
                            <td>Статус</td>
                            <td data-placeholder="#">Цена</td>
                            <td class="filter-false"></td>
                            <td class="filter-false"></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $val)
                            <tr>
                                <td>{{$val['CODE']}}</td>
                                <td>{{$val['NAME']}}</td>
                                <td style="color: {{$val['STATUS']=='A'?'green':'red'}}">{{$val['STATUS']=='A'?'Активный':'Отключен'}}</td>
                                <td>{{$val['PRICE']}}</td>
                                <td><i class="fa fa-edit" data-toggle="modal" data-target="#edit" onclick="modal(this, '{{$val['CODE']}}')"></i></td>
                                <td><i class="fa fa-times" onclick="del(this, '{{$val['CODE']}}')"></i></td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    @if(Input::has('dept'))
    @include('modules.serviceEdit')
    @include('modules.serviceAdd')
    @endif
@stop