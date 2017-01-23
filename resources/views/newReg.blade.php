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
                    <div class="row">
                        <div class="col-md-3">
                            <input name="pid" id="pid" type="hidden" >
                            <label for="surname">Фамилия *</label>
                            <input id="surname" name="surname" type="text" class="required form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="name">Имя *</label>
                            <input id="name" name="name" type="text" class="required form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="namepatr">Отчество</label>
                            <input id="namepatr" name="namepatr" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="b_d">Дата рождения *</label>
                            <input id="b_d" name="b_d" type="text" class="required datepicker form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sex">Пол *</label>
                            <select id="sex" name="sex" class="required form-control">
                                <option disabled selected>-</option>
                                <option value="M">М</option>
                                <option value="F">Ж</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="phone">Телефон</label>
                            <input id="phone" name="phone" type="tel" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="email">Эл. почта</label>
                            <input id="email" name="email" type="email" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="address">Адрес</label>
                            <input id="address" name="address" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="otd">Отделение</label>
                            <select name="otd" class="form-control" id="otd" onchange="selectPrice(this); return false;" required>
                                @foreach($depts as $val)
                                    <option value="{{$val['ID']}}">{{$val['DEPT']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="s_b">Срок беременности</label>
                            <select id="s_b" name="s_b" class="form-control">
                                <option value="">-</option>
                                <? for($i=1; $i<=40; $i++)
                                    echo "<option value='$i'>$i</option>"
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="f_c">Фаза цикла</label>
                            <select id="f_c" name="f_c" class="form-control">
                                <option value="">-</option>
                                <option value="M">Менопауза</option>
                                <option value="L">Лютеиновая фаза</option>
                                <option value="O">Овуляция</option>
                                <option value="F">Фоликулиновая фаза</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="diagnoz">Диагноз</label>
                            <input id="diagnoz" name="diagnoz" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="doctor">Врач</label>
                            <input name="doctorName" class="form-control doctor" type="text">
                            <input name="doctorId" class="form-control" id="Rdoc" type="text" style="display: none">
                        </div>
                        <div class="col-md-3">
                            <label for="AIS">АИС ЛМК</label>
                            <input id="AIS" name="AIS" type="number" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="cito">Срочность (CITO!)</label>
                            <select name="cito" id="cito" style="width:110px" class="form-control">
                                <option value="">Обычный</option>
                                <option value="U">Срочный</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="comments">Комментарий</label>
                            <input id="comments" name="comments" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="str">Страховая компания</label>
                            <input id="str" name="str" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="polis">Полис</label>
                            <input id="polis" name="polis" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="diarez">Диурез</label>
                            <input id="diarez" name="diarez" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="org">Организация</label>
                            <input id="org" name="org" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="panel-group" id="accordion" style="margin-top: 3%">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        Дополнительная информация <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="n_p">Номер паспорта</label>
                                            <input id="n_p" name="n_p" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="s_p">Серия паспорта</label>
                                            <input id="s_p" name="s_p" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="issued">Кем и когда выдан</label>
                                            <input type="text" name="issued" id="issued" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="prime">Первичные/повторные пациенты</label>
                                            <select name="prime" id="prime" class="form-control">
                                                <option value="Y">Первичный</option>
                                                <option value="N">Повторный</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="weight">Вес</label>
                                            <input id="weight" name="weight" type="number" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="height">Рост</label>
                                            <input id="height" name="height" type="number" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="backref">Откуда узнали</label>
                                            <select name="backref" id="backref" class="form-control">
                                                <option value=""></option>
                                                @foreach($backref as $val)
                                                    <option value="{{$val['ID']}}">{{$val['BACK']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="cash">Оплата*</label>
                                            <select name="cash" id="cash" required class="form-control">
                                                <option value="Y">Наличными</option>
                                                <option value="N">Безналичными</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="n_k">№ скидочной карты</label>
                                            <input id="n_k" name="n_k" type="number" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="discount">Скидочная группа </label>
                                            <select id="discount" name="discount2" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="docc">Основание для скидки</label>
                                            <input type="text" name="docc" id="docc" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price">Прайслист *</label>
                                            <select id="price" name="price" class="form-control" required>
                                                @foreach($pricelist as $val)
                                                    <option value='{{$val['ID']}}'>{{$val['DEPT']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="kk">Код контингента</label>
                                            <select name="kk" id="kk" class="form-control">
                                                <option></option>
                                                <option value="102">102 - больные наркоманией</option>
                                                <option value="103">103 - гомо- бисексуалисты</option>
                                                <option value="104">104 - больные ЗПП</option>
                                                <option value="109">109 - беременные</option>
                                                <option value="112">112 - лица в местах лишения свободы</option>
                                                <option value="113">113 - обследования по клиническим показаниям</option>
                                                <option value="115">115 - медперсонал, работающий с больными ВИЧ</option>
                                                <option value="118">118 - прочие</option>
                                                <option value="200">200 - иностранные граждане</option>
                                            </select>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="prob">Препарат</label>
                                                    <input id="prob" name="prob" type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="antib">Лекарственный препарат</label>
                                            <input id="antib" name="antib" type="checkbox" onchange="toggleBio(this); return false;" style="display: block; margin: auto; width: 20px; height: 20px;">
                                            <br> Применялись
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    с<input id="antib_s" name="antib_s" type="text" class="datepicker form-control" disabled>
                                                </div>
                                                <div class="col-sm-6">
                                                    по<input id="antib_e" name="antib_e" type="text" class="datepicker form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="s_sms">Отправлять смс</label>
                                            <input type="checkbox" name="s_sms" id="s_sms" style="display: block; margin: auto; width: 20px; height: 20px;">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="s_email">Отправлять email</label>
                                            <input type="checkbox" name="s_email" id="s_email" style="display: block; margin: auto; width: 20px; height: 20px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <div class="row">
                        <div class="col-md-12 description" style="padding: 2%">

                        </div>
                    </div>
                </section>
                <h3>Шаг 3</h3>
                <section>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rsurname">Фамилия</label>
                            <input id="Rsurname" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rname">Имя</label>
                            <input id="Rname" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rnamepatr">Отчество</label>
                            <input id="Rnamepatr" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rb_d">Дата рождения *</label>
                            <input id="Rb_d" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rsex">Пол</label>
                            <input type="text" id="Rsex" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rphone">Телефон</label>
                            <input id="Rphone" type="tel" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Remail">Эл. почта</label>
                            <input id="Remail" type="email" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Raddress">Адрес</label>
                            <input id="Raddress" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <label for="Rs_b">Срок беременности</label>
                            <input id="Rs_b" type="text" class="form-control" readonly>
                        </div><div class="col-md-3">
                            <label for="Rf_c">Фаза цикла</label>
                            <input id="Rf_c" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rdiagnoz">Диагноз</label>
                            <input id="Rdiagnoz" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rdoctor">Врач</label>
                            <input class="form-control" id="Rdoctor" type="text" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="RAIS">АИС ЛМК</label>
                            <input id="RAIS" type="number" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rcito">Срочность (CITO!)</label>
                            <input id="Rcito" class="form-control" type="text" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rcomments">Комментарий</label>
                            <input id="Rcomments" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rstr">Страховая компания</label>
                            <input id="Rstr" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rpolis">Полис</label>
                            <input id="Rpolis" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rdiarez">Диурез</label>
                            <input id="Rdiarez" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rorg">Организация</label>
                            <input id="Rorg" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rs_p">Серия паспорта</label>
                            <input id="Rs_p" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rn_p">Номер паспорта</label>
                            <input id="Rn_p" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rissued">Кем и когда выдали</label>
                            <input type="text" id="Rissued" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rprime">Первичные/повторные пациенты</label>
                            <input type="text" id="Rprime" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rweight">Вес</label>
                            <input id="Rweight" type="number" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rheight">Рост</label>
                            <input id="Rheight" type="number" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rbackref">Откуда узнали</label>
                            <input type="text" id="Rbackref" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rcash">Оплата</label>
                            <input id="Rcash" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Rn_k">№ скидочной карты</label>
                            <input id="Rn_k" type="number" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rdiscount">Скидочная группа </label>
                            <input id="Rdiscount" name="discount2" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="Rprob">Препарат</label>
                            <input id="Rprob" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
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
                        </div>
                    </div>
                    <div class="row">
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