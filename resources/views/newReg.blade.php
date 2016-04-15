@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/ui.dynatree.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/registration.css')}}" rel="stylesheet">
    <div id="registration">
        <h1>РЕГИСТРАЦИЯ НАПРАВЛЕНИЯ</h1>
        <div id="infoFrm"></div>
        <table width="100%">
            <tr><td align="left" width="30%"><h3>Направление №: <span id="folderno"><abbr title="Номер заявки не будет присвоен, пока она не будет сохранена">N/A</abbr></span></h3></td>
                <td align="right" width="35%"><h3>Дата и время сбора: <input type="text" id="dt_catched" name="dt_catched" style="font-weight: bold; text-align:center; width:150px;" value="<?php echo date("d.m.Y H:i"); ?>" readonly /></h3></td></tr>
        </table>
        <form id="RegAll" action="#">
            <div>
                <h3>Шаг 1</h3>
                <section>
                    <pre>Введите фамилию имя и отчество пациента, через пробел.
Если пациент ранее сдавал уже анализы, то вы сможете выбрать его из выпадающего списка,
для облегчения заполнения следующих шагов</pre>
                    <label for="userName">Фамилия Имя Отчество</label>
                    <input id="userName" name="userName" type="text" class="required form-control">
                    @if($web!=='')
                        <pre style="margin-top: 20px">Выберите отделение регистрации пациента</pre>
                        <label for="otd">Отделение</label>
                        <select id="otd" name="otd" class="required form-control">
                            <option disabled selected></option>
                            @foreach($depts as $val)
                                <option value="{{$val['ID']}}">{{$val['DEPT']}}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" name="otd" id="otd" value="{{Session::get('dept')}}">
                    @endif
                    <p>(*) Обязательно к заполнению</p>
                </section>
                <h3>Шаг 2</h3>
                <section>
                    <div class="row">
                        <div class="col-md-3">
                            <input name="pid" id="pid" type="hidden" >
                            <label for="name">Имя *</label>
                            <input id="name" name="name" type="text" class="required form-control">
                            <label for="surname">Фамилия *</label>
                            <input id="surname" name="surname" type="text" class="required form-control">
                            <label for="namepatr">Отчество</label>
                            <input id="namepatr" name="namepatr" type="text" class="form-control">
                            <label for="sex">Пол *</label>
                            <select id="sex" name="sex" class="required form-control">
                                <option disabled selected>-</option>
                                <option value="M">М</option>
                                <option value="F">Ж</option>
                            </select>
                            <label for="phone">Телефон</label>
                            <input id="phone" name="phone" type="tel" class="form-control">
                            <label for="email">Эл. почта</label>
                            <input id="email" name="email" type="email" class="form-control">
                            <label for="b_d">Дата рождения *</label>
                            <input id="b_d" name="b_d" type="text" class="required datepicker form-control">
                            <label for="address">Адрес</label>
                            <input id="address" name="address" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="n_p">Номер паспорта</label>
                            <input id="n_p" name="n_p" type="text" class="form-control">
                            <label for="s_p">Серия паспорта</label>
                            <input id="s_p" name="s_p" type="text" class="form-control">
                            <label for="issued">Кем и когда выдали</label>
                            <input type="text" name="issued" id="issued" class="form-control">
                            <label for="prime">Первичные/повторные пациенты</label>
                            <select name="prime" id="prime" class="form-control">
                                <option value="Y">Первичный</option>
                                <option value="N">Повторный</option>
                            </select>
                            <label for="backref">Откуда узнали</label>
                            <select name="backref" id="backref" class="form-control">
                                <option value=""></option>
                                @foreach($backref as $val)
                                    <option value="{{$val['ID']}}">{{$val['BACK']}}</option>
                                @endforeach
                            </select>
                            <label for="weight">Вес</label>
                            <input id="weight" name="weight" type="number" class="form-control">
                            <label for="height">Рост</label>
                            <input id="height" name="height" type="number" class="form-control">

                            <div class="row form-group" style="margin-top: 15px; margin-bottom: 15px">
                                <div class="col-md-6">
                                    <label for="s_sms">Отправлять смс</label>
                                    <input type="checkbox" name="s_sms" id="s_sms">
                                </div>
                                <div class="col-md-6">
                                    <label for="s_email">Отправлять email</label>
                                    <input type="checkbox" name="s_email" id="s_email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="str">Страховая компания</label>
                            <input id="str" name="str" type="text" class="form-control">
                            <label for="polis">Полис</label>
                            <input id="polis" name="polis" type="text" class="form-control">
                            <label for="s_b">Срок беременности</label>
                            <select id="s_b" name="s_b" class="form-control">
                                <option value="">-</option>
                                <? for($i=1; $i<=40; $i++)
                                    echo "<option value='$i'>$i</option>"
                                ?>
                            </select>
                            <label for="f_c">Фаза цикла</label>
                            <select id="f_c" name="f_c" class="form-control">
                                <option value="">-</option>
                                <option value="M">Менопауза</option>
                                <option value="L">Лютеин</option>
                                <option value="O">Овуляция</option>
                                <option value="F">Фоликулин</option>
                            </select>
                            <label for="diarez">Диурез</label>
                            <input id="diarez" name="diarez" type="text" class="form-control">
                            <label for="antib">Антибиотики</label>
                            <input id="antib" name="antib" type="checkbox" onchange="toggleBio(this); return false;">
                            <br> Применялись
                            <div class="row">
                                <div class="col-sm-6">
                                    с<input id="antib_s" name="antib_s" type="text" class="datepicker form-control" disabled>
                                </div>
                                <div class="col-sm-6">
                                    по<input id="antib_e" name="antib_e" type="text" class="datepicker form-control" disabled>
                                </div>
                            </div>
                            <label for="prob">Препарат</label>
                            <input id="prob" name="prob" type="text" class="form-control" disabled>
                            <label for="diagnoz">Диагноз</label>
                            <input id="diagnoz" name="diagnoz" type="text" class="form-control">
                            <label for="doctor">Врач</label>
                            <input name="doctorName" class="form-control doctor" type="text">
                            <input name="doctorId" class="form-control" id="Rdoc" type="text" style="display: none">

                        </div>
                        <div class="col-md-3">
                            <label for="AIS">АИС ЛМК</label>
                            <input id="AIS" name="AIS" type="number" class="form-control">
                            <label for="org">Организация</label>
                            <input id="org" name="org" type="text" class="form-control">
                            <label for="cito">Срочность (CITO!)</label>
                            <select name="cito" id="cito" style="width:110px" class="form-control">
                                <option value="">Обычный</option>
                                <option value="U">Срочный</option>
                            </select><br>
                            <label for="n_k">№ скидочной карты</label>
                            <input id="n_k" name="n_k" type="number" class="form-control">
                            <label for="price">Прайслист *</label>
                            <select id="price" name="price" class="form-control" required>
                                <option value="" disabled selected>-</option>
                                @foreach($pricelist as $val)
                                    <option value='{{$val['ID']}}'>{{$val['DEPT']}}</option>
                                @endforeach
                            </select>
                            <label for="discount">Скидочная группа </label>
                            <select id="discount" name="discount2" class="form-control">
                            </select>
                            <label for="docc">Основание для скидки</label>
                            <input type="text" name="docc" id="docc" class="form-control">
                            <label for="comments">Комментарий</label>
                            <input id="comments" name="comments" type="text" class="form-control">
                            <label for="cash">Оплата*</label>
                            <select name="cash" id="cash" required class="form-control">
                                <option value="Y">Наличными</option>
                                <option value="N">Безналичными</option>
                            </select>
                        </div>
                    </div>

                    <p>(*) Обязательно к заполнению</p>
                </section>
                <h3>Шаг 3</h3>
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-5">
                                    <b>Выберите из списка необходимые панели</b>
                                    ( <abbr style="cursor: help;" title="Вводите номер панели, например, '10.110' или наименование исследования, например, 'Общий анализ крови'">поиск</abbr>:
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" tabindex="21" id="searchp" onkeyup="addPanel(event,this); return false;" class="form-control"/> ):
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <b>Выбранные панели <span>(<span id="p-cnt">0</span> шт.)</span>:</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="tree-source" class="tree-source" style="height:400px; width:99%; overflow: scroll; background: white;"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="tree-dest" class="tree-dest" style="height:400px; width:99%; overflow: scroll; background: white;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="discount"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="padding-top:35px;display:none;" id="legend2"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="cost">Общая сумма</label>
                            <input id="cost" type="number" value="0" name="fullCost" class="form-control col-md-3" readonly>
                        </div>
                    </div>
                </section>
                <h3>Шаг 4</h3>
                <section>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Rname">Имя</label>
                                <input id="Rname" type="text" class="form-control" readonly>
                                <label for="Rsurname">Фамилия</label>
                                <input id="Rsurname" type="text" class="form-control" readonly>
                                <label for="Rnamepatr">Отчество</label>
                                <input id="Rnamepatr" type="text" class="form-control" readonly>
                                <label for="Rsex">Пол</label>
                                <input type="text" id="Rsex" class="form-control" readonly>
                                <label for="Rphone">Телефон</label>
                                <input id="Rphone" type="tel" class="form-control" readonly>
                                <label for="Remail">Эл. почта</label>
                                <input id="Remail" type="email" class="form-control" readonly>
                                <label for="Rb_d">Дата рождения *</label>
                                <input id="Rb_d" type="text" class="form-control" readonly>
                                <label for="Raddress">Адрес</label>
                                <input id="Raddress" type="text" class="form-control" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="Rn_p">Номер паспорта</label>
                                <input id="Rn_p" type="text" class="form-control" readonly>
                                <label for="Rs_p">Серия паспорта</label>
                                <input id="Rs_p" type="text" class="form-control" readonly>
                                <label for="Rissued">Кем и когда выдали</label>
                                <input type="text" id="Rissued" class="form-control" readonly>
                                <label for="Rprime">Первичные/повторные пациенты</label>
                                <input type="text" id="Rprime" class="form-control" readonly>
                                <label for="Rbackref">Откуда узнали</label>
                                <input type="text" id="Rbackref" class="form-control" readonly>
                                <label for="Rweight">Вес</label>
                                <input id="Rweight" type="number" class="form-control" readonly>
                                <label for="Rheight">Рост</label>
                                <input id="Rheight" type="number" class="form-control" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="Rstr">Страховая компания</label>
                                <input id="Rstr" type="text" class="form-control" readonly>
                                <label for="Rpolis">Полис</label>
                                <input id="Rpolis" type="text" class="form-control" readonly>
                                <label for="Rs_b">Срок беременности</label>
                                <input id="Rs_b" type="text" class="form-control" readonly>
                                <label for="Rf_c">Фаза цикла</label>
                                <input id="Rf_c" type="text" class="form-control" readonly>
                                <label for="Rdiarez">Диурез</label>
                                <input id="Rdiarez" type="text" class="form-control" readonly>
                                <label for="Rprob">Препарат</label>
                                <input id="Rprob" type="text" class="form-control" readonly>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="Rantib_s">с</label>
                                        <input id="Rantib_s" type="text" class="datepicker" disabled style="width: 100%">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="Rantib_e">по</label>
                                        <input id="Rantib_e" type="text" class="datepicker" disabled style="width: 100%">
                                    </div>
                                </div>
                                <label for="Rdiagnoz">Диагноз</label>
                                <input id="Rdiagnoz" type="text" class="form-control" readonly>
                                <label for="Rdoctor">Врач</label>
                                <input class="form-control" id="Rdoctor" type="text" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="RAIS">АИС ЛМК</label>
                                <input id="RAIS" type="number" class="form-control" readonly>
                                <label for="Rorg">Организация</label>
                                <input id="Rorg" type="text" class="form-control" readonly>
                                <label for="Rcito">Срочность (CITO!)</label>
                                <input id="Rcito" class="form-control" type="text" readonly>
                                <label for="Rn_k">№ скидочной карты</label>
                                <input id="Rn_k" type="number" class="form-control" readonly>
                                <label for="Rdiscount">Скидочная группа </label>
                                <input id="Rdiscount" name="discount3" type="text" class="form-control" readonly>
                                <label for="Rdocc">Основание для скидки</label>
                                <input type="text" id="Rdocc" class="form-control" readonly>
                                <label for="Rcomments">Комментарий</label>
                                <input id="Rcomments" type="text" class="form-control" readonly>
                                <label for="Rcash">Оплата</label>
                                <input id="Rcash" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="orderP">
                                <table class="table table-striped">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <input type="hidden" id="discount" value="0" name="discount">
            <input type="hidden" id="nacppCost" value="0" name="nacpp">
        </form>
    </div>
    @include('scripts.newRegScript')
@stop