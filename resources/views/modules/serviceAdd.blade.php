<div class="modal fade bs-example-modal" id="serviceAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать панель</h4>
            </div>
            <form action="{{url('page53')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-body">
                    <div id="addPanel">
                        <input type="radio" value="0" name="point" checked> <b>Добавить панель</b>
                        <div id="addOne">
                            <div class="form-group">
                                <label for="code">Код панели</label>
                                <input type="text" id='codeNew' name="codeNew" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="panel">Название панели</label>
                                <input type="text" name="panelNew" id='panelNew' class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="cpst">Цена</label>
                                <input type="text" name="costNew" id="costNew" class="form-control" required>
                            </div>
                        </div>
                        <input type="radio" value="1" name="point"><b>Загрузить из файла</b>
                        <div id="addGroup">
                            <div class="form-group">
                                {!! Form::file('excel', ['required', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cpst">Выбрать группу</label>
                                    <select type="text" name="group" id="gr" class="form-control" required>
                                        @foreach($groups as $val){
                                        <option value='{{$val['ID']}}'>{{$val['NAME']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <button class="btn btn-primary" style="margin-top: 10%" onclick="addSer(this); return false;">Добавить группу</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                            <div id="group" style="display: none">
                                <div class="form-group">
                                    <label for="newGroup">Название группы</label>
                                    <input type="text" name="newGroup" id='newGroup' class="form-control" disabled required>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <input type="hidden" name="dept" value="{{Input::get('dept')}}">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>