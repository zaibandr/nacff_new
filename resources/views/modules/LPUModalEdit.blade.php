<div class="modal fade bs-example-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать пользователя</h4>
            </div>
            <form action="page66/{page66}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="put" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Логин</label>
                        <input type="text" id='name' name="name" readonly class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="text" name="password" id='password' class="form-control" required>
                    </div>
                    <div class="lpu-group">
                        <div class="form-group">
                            <label for="lpu">Номер ЛПУ</label><i class="fa fa-close" style='color: red' onclick="delInput(0)"></i>
                            <input type="text" name="lpu" class="form-control lpuItem0" required onblur="addDeps(0,this.value)">
                        </div>
                        <div class="form-group" id="deps0"></div>
                    </div>
                    <hr>
                    <i id="moreLpu" class="fa fa-plus-circle" style="margin: 5% 0" onclick="addLPU()">Добавить еще ЛПУ</i>
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