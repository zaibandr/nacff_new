
@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/ui.dynatree.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/edit.css')}}" rel="stylesheet">
    <div id="edit">
        <h1>РЕДАКТИРОВАНИЕ НАПРАВЛЕНИЯ</h1>
        <div id="infoFrm"></div>
        <table width="100%">
            <tr><td align="left" width="30%"><h3>Направление №: <span id="folderno">{{$id}}</span></h3></td>
                <td align="right" width="35%"><h3>Дата и время сбора: <input type="text" id="dt_catched" name="dt_catched" style="font-weight: bold; text-align:center; width:150px;" value="<?php echo date("d.m.Y H:i"); ?>" readonly /></h3></td></tr>
        </table>
        <form id="RegAll" action="#">
            <div>
                <h3>Шаг 1</h3>
                <section>
                    <div class="row">
                        <div class="col-md-3">
                            <input name="pid" id="pid" type="hidden" value="{{$folders[0]['PID']}}">
                            <label for="surname">Фамилия *</label>
                            <input id="surname" name="surname" type="text" class="required form-control" value="{{$folders[0]['SURNAME']}}">
                            <label for="name">Имя *</label>
                            <input id="name" name="name" type="text" class="required form-control" value="{{$folders[0]['NAME']}}">
                            <label for="namepatr">Отчество</label>
                            <input id="namepatr" name="namepatr" type="text" class="form-control" value="{{$folders[0]['PATRONYMIC']}}">
                            <label for="sex">Пол *</label>
                            <select id="sex" name="sex" class="required form-control" >
                                <option disabled selected>-</option>
                                <option value="M" {{$folders[0]['GENDER']=='M'?'selected':''}}>М</option>
                                <option value="F" {{$folders[0]['GENDER']=='F'?'selected':''}}>Ж</option>
                            </select>
                            <label for="phone">Телефон</label>
                            <input id="phone" name="phone" type="tel" class="form-control" value="{{$folders[0]['PHONE']}}">
                            <label for="email">Эл. почта</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{$folders[0]['EMAIL']}}">
                            <label for="b_d">Дата рождения *</label>
                            <input id="b_d" name="b_d" type="text" class="required form-control datepicker" value="{{$folders[0]['DATE_BIRTH']}}">
                            <label for="address">Адрес</label>
                            <input id="address" name="address" type="text" class="form-control" value="{{$folders[0]['ADDRESS']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="n_p">Номер паспорта</label>
                            <input id="n_p" name="n_p" type="text" class="form-control" value="{{$folders[0]['PASSPORT_NUMBER']}}">
                            <label for="s_p">Серия паспорта</label>
                            <input id="s_p" name="s_p" type="text" class="form-control" value="{{$folders[0]['PASSPORT_SERIES']}}">
                            <label for="issued">Кем и когда выдали</label>
                            <input type="text" name="issued" id="issued" class="form-control" value="{{$folders[0]['ISSUED']}}">
                            <label for="prime">Первичные/повторные пациенты</label>
                            <select name="prime" id="prime" class="form-control">
                                <option value="Y" {{$folders[0]['PRIME']=='Y'?'selected':''}}>Первичный</option>
                                <option value="N" {{$folders[0]['PRIME']=='N'?'selected':''}}>Повторный</option>
                            </select>
                            <label for="backref">Откуда узнали</label>
                            <select name="backref" id="backref" class="form-control">
                                <option value=""></option>
                                @foreach($backref as $val)
                                    <option value="{{$val['ID']}}" {{$folders[0]['BACKREF']==$val['ID']?'selected':''}}>{{$val['BACK']}}</option>
                                @endforeach
                            </select>
                            <label for="weight">Вес</label>
                            <input id="weight" name="weight" type="number" class="form-control" value="{{$folders[0]['WEIGHT']}}">
                            <label for="height">Рост</label>
                            <input id="height" name="height" type="number" class="form-control"  value="{{$folders[0]['HEIGHT']}}">

                            <div class="row form-group" style="margin-top: 15px; margin-bottom: 15px">
                                <div class="col-md-6">
                                    <label for="s_sms">Отправлять смс</label>
                                    <input type="checkbox" name="s_sms" id="s_sms" {{$folders[0]['S_SMS']=='Y'?'checked':''}}>
                                </div>
                                <div class="col-md-6">
                                    <label for="s_email">Отправлять email</label>
                                    <input type="checkbox" name="s_email" id="s_email" {{$folders[0]['S_EMAIL']=='Y'?'checked':''}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="str">Страховая компания</label>
                            <input id="str" name="str" type="text" class="form-control" value="{{$folders[0]['STR']}}">
                            <label for="polis">Полис</label>
                            <input id="polis" name="polis" type="text" class="form-control" value="{{$folders[0]['POLIS']}}">
                            <label for="s_b">Срок беременности</label>
                            <select id="s_b" name="s_b" class="form-control">
                                <option value="">-</option>
                                @for($i=1; $i<=40; $i++)
                                    <option value='{{$i}}' {{$folders[0]['PREGNANCY']==$i?'selected':''}} >{{$i}}</option>
                                @endfor
                            </select>
                            <label for="f_c">Фаза цикла</label>
                            <select id="f_c" name="f_c" class="form-control">
                                <option value="">-</option>
                                <option value="M" {{$folders[0]['PREGNANCY']=='M'?'selected':''}}>Менопауза</option>
                                <option value="L" {{$folders[0]['PREGNANCY']=='L'?'selected':''}}>Лютеин</option>
                                <option value="O" {{$folders[0]['PREGNANCY']=='O'?'selected':''}}>Овуляция</option>
                                <option value="F" {{$folders[0]['PREGNANCY']=='F'?'selected':''}}>Фоликулин</option>
                            </select>
                            <label for="diarez">Диурез</label>
                            <input id="diarez" name="diarez" type="text" class="form-control" value="{{$folders[0]['RN1']}}">
                            <label for="antib">Антибиотики</label>
                            <input id="antib" name="antib" type="checkbox" onchange="toggleBio(this); return false;" {{$folders[0]['ANTIBIOT']=='Y'?'checked':''}}>
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
                            <input id="prob" name="prob" type="text" class="form-control" disabled value="{{$folders[0]['ANTIBIOTIC']}}">
                            <label for="diagnoz">Диагноз</label>
                            <input id="diagnoz" name="diagnoz" type="text" class="form-control" value="{{$folders[0]['RN2']}}">
                            <label for="doctor">Врач</label>
                            <input name="doctor" class="form-control doctor" type="text" value="{{$folders[0]['DOCTOR']}}">
                            <input name="doctor" class="form-control" id="Rdoc" type="text" style="display: none" value="{{$folders[0]['DOCTOR_01']}}">

                        </div>
                        <div class="col-md-3">
                            <label for="AIS">АИС ЛМК</label>
                            <input id="AIS" name="AIS" type="number" class="form-control" value="{{$folders[0]['AIS']}}">
                            <label for="org">Организация</label>
                            <input id="org" name="org" type="text" class="form-control" value="{{$folders[0]['ORG']}}">
                            <label for="cito">Срочность (CITO!)</label>
                            <select name="cito" id="cito" style="width:110px" class="form-control" >
                                <option value="">Обычный</option>
                                <option value="U" {{$folders[0]['CITO']=='U'?'checked':''}}>Срочный</option>
                            </select><br>
                            <label for="n_k">№ скидочной карты</label>
                            <input id="n_k" name="n_k" type="number" class="form-control" value="{{$folders[0]['CARDNO']}}">
                            <label for="price">Прайслист *</label>
                            <select id="price" name="price" class="form-control" required>
                                <option value="" disabled selected>-</option>
                                @foreach($pricelist as $val)
                                    <option value='{{$val['ID']}}' {{$folders[0]['PRICELISTID']==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                @endforeach
                            </select>
                            <label for="discount">Скидочная группа </label>
                            <select id="discount" name="discount2" class="form-control" >
                            </select>
                            <label for="docc">Основание для скидки</label>
                            <input type="text" name="docc" id="docc" class="form-control" value="{{$folders[0]['DOC']}}">
                            <label for="comments">Комментарий</label>
                            <input id="comments" name="comments" type="text" class="form-control" value="{{$folders[0]['COMMENTS']}}">
                            <label for="cash">Оплата*</label>
                            <select name="cash" id="cash" required class="form-control">
                                <option value="Y" {{$folders[0]['CASH']=='Y'?'selected':''}}>Наличными</option>
                                <option value="N" {{$folders[0]['CASH']=='N'?'selected':''}}>Безналичными</option>
                            </select>
                        </div>
                    </div>

                    <p>(*) Обязательно к заполнению</p>
                </section>
                <h3>Шаг 2</h3>
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
                <h3>Finish</h3>
                <section>
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
                            <input id="Rb_d" type="date" class="form-control" readonly>
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
                                    <label for="Rantib_s">Применялись с</label><input id="Rantib_s" type="date" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="Rantib_e">по</label><input id="Rantib_e" type="date" readonly>
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
                </section>
            </div>
            <input type="hidden" id="discount" value="0" name="discount">
            <input type="hidden" id="nacppCost" value="0" name="nacpp">
            <input type="hidden" id="oldcost" value="0" name="oldcost">
            <input type="hidden" id="otd" value="{{$folders[0]['CLIENTID']}}" name="otd" >
            <input type="hidden" name="folderno" value="<?php echo $id; ?>" />
        </form>
        @include('scripts.editScript')
    </div>
    @stop