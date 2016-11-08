@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>Добавить Отделение</h1>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <form action="{{route('page68.store')}}" method="post" id="formUserAdd" onsubmit="return validateNumber()">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="lpu">Номер ЛПУ</label>
                            <input type="number" name="lpu" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Отделение</label>
                            <input type="text" id='name' name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="desc">Описание</label>
                            <input type="text" id='desc' name="desc" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Использовать прайс</label>
                            <select name="price" class="form-control" required>
                                <option value="" selected disabled>Выберите прайс</option>
                                @foreach($prices as $val)
                                    <option value="{{$val['ID']}}">{{$val['DEPT']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="net">Сети</label>
                            <select name="net" class="form-control" >
                                <option value="" selected disabled></option>
                                @foreach($nets as $val)
                                    <option value="{{$val['ID']}}">{{$val['NETNAME']}}</option>
                                    @endforeach
                            </select>
                            <p><a href="{{route('page72.create')}}" target="_blank"></a></p>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:history.go(-1)" class="btn btn-default" >Отмена</a>
                            <button type="submit" class="btn btn-primary"> Сохранить </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop