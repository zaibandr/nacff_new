<div class="modal fade bs-example-modal-lg" id="userEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать пользователя</h4>
            </div>
            {!! Form::open(['method'=>'put', 'onSubmit'=>'return validateFormEdit()', 'id'=>'formUserEdit']) !!}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('login', 'Логин') !!}
                            {!!Form::text('login', null, ['class'=>'form-control', 'id'=>'login', 'placeholder'=>'Введите логин', 'readonly', 'required'])!!}
                            {!! Form::label('name', 'Имя') !!}
                            {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Введите имя', 'required'])!!}
                            {!! Form::label('password', 'Пароль') !!}
                            {!!Form::text('password', null, ['class'=>'form-control', 'id'=>'password', 'placeholder'=>'Введите пароль', 'required'])!!}
                        </div>
                        <div class="col-lg-12" style="padding-top: 15px">
                            <table class="table table-striped">
                                <tr>
                                    @foreach($depts as $v)
                                        <td><b>{{$v['DEPT']}}</b></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($depts as $v)
                                        <td>{!! Form::checkbox($v['ID'], 1, null) !!}</td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="userAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Создать пользователя</h4>
            </div>
            {!! Form::open(['method'=>'post', 'onSubmit'=>'return validateForm()', 'id'=>'formUserAdd'])!!}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('login', 'Логин') !!}
                            {!!Form::text('login', null, ['class'=>'form-control', 'id'=>'login', 'placeholder'=>'Введите логин', 'required'])!!}
                            {!! Form::label('name', 'Имя') !!}
                            {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Введите имя', 'required'])!!}
                            {!! Form::label('password', 'Пароль') !!}
                            {!!Form::text('password', null, ['class'=>'form-control', 'id'=>'password', 'placeholder'=>'Введите пароль', 'required'])!!}
                        </div>
                        <div class="col-lg-12" style="padding-top: 15px">
                            <table class="table table-striped">
                                <tr>
                                @foreach($depts as $v)
                                    <td><b>{{$v['DEPT']}}</b></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($depts as $v)
                                        <td>{!! Form::checkbox($v['ID'], 1, null) !!}</td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>