<div class="modal fade bs-example-modal-lg" id="matAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить материал</h4>
            </div>
            {!! Form::open(['method'=>'post']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name','Выбор типа материала') !!}
                            <select name="name" class="form-control" required>
                                @foreach($mat as $val)
                                    <option value="{{$val['ID']}}">{{$val['MATERIAL']}}</option>
                                    @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('col','Количество пачет') !!}
                            {!! Form::input('number','col', null, ['class'=>'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('colA','Количество единиц в пачке') !!}
                            {!! Form::input('number','colA', null, ['class'=>'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Adept"> Отделение: </label>
                            <select name="Adept" class="form-control" id="dept" required>
                                @foreach($depts as $val)
                                    <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('type', 'Тип операции') !!}
                        {!! Form::select('type', ['p'=>'Добавить', 'm'=>'Вычесть'], null, ['class'=>'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="dept" value="{{Input::get('dept','')}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary"> Сохранить </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>