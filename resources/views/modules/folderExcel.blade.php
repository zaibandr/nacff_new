<div class="modal fade bs-example-modal" id="excel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Скачать список направлений в Excel</h4>
            </div>
            <form action="" method="post">
            {{csrf_field()}}
            <div class="modal-body">
                <div id="table-filter">
                    <p>Фильтр по дате регистрации:</p>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="date_st">за период с</label>
                                <input type="text" name="date_st" id="date_st" class="datepicker form-control" value="<?php echo Input::get('date_st',date('d.m.Y',strtotime("-3 days")));?>"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="date_en">по</label>
                                <input type="text" name="date_en" id="date_en" class="datepicker form-control" value="<?php echo Input::get('date_en',date('d.m.Y'));?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($depts)>1)
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="client">Фильтр по центрам:</label>
                                    <select name="client" id="client" class="form-control">
                                        <option value="all"{{Input::get('client')=="all"?"selected":""}}>-- Все центры --</option>
                                        <option value="{{Session::get('dept')}}"{{(!Input::has('client') || Input::get('client')==Session::get('dept'))?" selected":""}}>(Текущий центр)</option>
                                        @foreach ($depts as $val)
                                            @if ($val['ID']!==Session::get('dept'))
                                                <option value="{{$val['ID']}}"{{(Input::get('client')==$val['ID'])?"selected":""}}>{{$val['DEPT']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="positive"> Фильтр по результатам</label>
                                <select name="positive" id="positive" class="form-control">
                                    <option selected></option>
                                    <option value="O" {{(Input::get('positive')=='O')?"selected":''}}>с патологией</option>
                                    <option value="E" {{(Input::get('positive')=='E')?"selected":''}}> в норме</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="status">Фильтр по статусу выполнения</label>
                                <select name="status" id="status" class="form-control">
                                    <option disabled selected></option>
                                    <option value="T" @if(Input::has('status') && Input::get('status')=='T') {{'selected'}} @endif>Выполнен</option>
                                    <option value="L" @if(Input::has('status') && Input::get('status')=='L') {{'selected'}} @endif>Зарегистрирован</option>
                                    <option value="D" @if(Input::has('status') && Input::get('status')=='D') {{'selected'}} @endif>Черновик</option>
                                    <option value="D" @if(Input::has('status') && Input::get('status')=='D') {{'selected'}} @endif>Отменен</option>
                                    <option value="K" @if(Input::has('status') && Input::get('status')=='K') {{'selected'}} @endif>Курьер</option>
                                    <option value="A" @if(Input::has('status') && Input::get('status')=='A') {{'selected'}} @endif>Выполняется</option>
                                    <option value="P" @if(Input::has('status') && Input::get('status')=='P') {{'selected'}} @endif>Отправлен</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="excel" value="1">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-danger" onclick="formReset()">Сброс</button>
                        <button type="submit" class="btn btn-primary"> Скачать </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>