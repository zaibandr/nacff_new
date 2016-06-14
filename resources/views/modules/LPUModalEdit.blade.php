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
                        <label for="name">Логин</label>
                        <input type="text" id='name' name="name" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="text" name="password" id='password' class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lpu">Номер ЛПУ</label>
                        <select name="lpu" id="lpu" class="form-control">
                            @foreach($numbers as $val)
                            <option value="{{$val['DEPTCODE']}}">{{$val['DEPTCODE']}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group" id="deps"></div>
                    <div class="form-group">
                        <label for="roleD">Гл.врач</label>
                        <input type="radio" name="role" id="roleM" value="M">
                        <label for="roleM">Медсестра</label>
                        <input type="radio" name="role" id="roleD" value="D">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>