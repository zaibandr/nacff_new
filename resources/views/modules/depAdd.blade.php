<div class="modal fade bs-example-modal-lg" id="depAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Создать пользователя</h4>
            </div>
            {!! Form::open(['method'=>'post'])!!}
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('name', 'Название') !!}
                        {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Введите имя', 'required', 'style'=>'margin-bottom:2%'])!!}
                        {!! Form::label('desc', 'Описание') !!}
                        {!!Form::text('desc', null, ['class'=>'form-control', 'id'=>'desc', 'required', 'style'=>'margin-bottom:2%'])!!}
                        {!! Form::label('price', 'Выберите прайс:') !!}
                        {!!Form::select('price', $a, null, ['class'=>'form-control', 'id'=>'password', 'placeholder'=>'Введите пароль', 'required'])!!}
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
<div class="modal fade bs-example-modal-lg" id="deptEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Создать пользователя</h4>
            </div>
            {!! Form::open(['method'=>'put'])!!}
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('name', 'Название') !!}
                        {!!Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Введите имя', 'required', 'style'=>'margin-bottom:2%'])!!}
                        {!! Form::label('desc', 'Описание') !!}
                        {!!Form::text('desc', null, ['class'=>'form-control', 'id'=>'desc', 'required', 'style'=>'margin-bottom:2%'])!!}
                        {!! Form::label('price', 'Выберите прайс:') !!}
                        {!!Form::select('price', $a, null, ['class'=>'form-control', 'id'=>'password', 'placeholder'=>'Введите пароль', 'required'])!!}
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