<div class="modal fade bs-example-modal-lg" id="dis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Создать правило</h4>
            </div>
            <form method="post" action="page47">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Название</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="per">Процент</label>
                                <input type="number" name="per" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dept"> Отделение: </label>
                                <select name="dept" class="form-control" id="dept">
                                    @foreach($depts as $val)
                                        <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Тип скидки</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="1">Общая</option>
                                    <option value="2">По дням недели</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="xxx"></label>
                                <select name="xxx" id="xxx" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="dis2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать правило</h4>
            </div>
            {!! Form::open(['method'=>'put']) !!}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name','Название') !!}
                                {!! Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('per','Процент') !!}
                                {!! Form::input('number','per', null, ['id'=>'per', 'class'=>'form-control', 'required']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dept"> Отделение: </label>
                                <select name="dept" class="form-control" id="dept">
                                    @foreach($depts as $val)
                                        <option value="{{$val['ID']}}" {{Input::get('dept')==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Тип скидки</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="1">Общая</option>
                                    <option value="2">По дням недели</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="xxx"></label>
                                <select name="xxx" id="xxx" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary"> Сохранить </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#type').change(function(){
            if($('#type').val()==1){
                $('select#xxx').empty();
                $('label[for="xxx"]').text('');
            }
            if($('#type').val()==2){
                week = ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'];
                $.each(week, function(key, val){
                    $('select#xxx').append($("<option></option>").val(key).html(val));
                    $('label[for="xxx"]').text('Дни недели');
                });
            }
        })
    });
    function modal(a, b){
        tr = a.closest('tr');
        $('#name').val(tr.cells[0].innerHTML);
        $('#per').val(tr.cells[1].innerHTML);
        $('#dis2 form').attr('action','page47/'+b);
    }
</script>