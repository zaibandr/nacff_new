<div class="modal fade bs-example-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать панель</h4>
            </div>
            <form action="" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="code">Код панели</label>
                        <input type="text" id='code' name="code" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="panel">Название панели</label>
                        <input type="text" name="panel" id='panel' class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cost">Цена</label>
                        <input type="text" name="cost" id="cost" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="active">Статус</label>
                        <select name="active" id="active" class="form-control">
                            <option value="Активный">Активный</option>
                            <option value="Отключен">Отключен</option>
                        </select>
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