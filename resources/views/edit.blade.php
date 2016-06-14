
@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/ui.dynatree.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('resources/assets/css/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
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
                        </div>
                        <div class="col-md-3">
                            <label for="name">Имя *</label>
                            <input id="name" name="name" type="text" class="required form-control" value="{{$folders[0]['NAME']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="namepatr">Отчество</label>
                            <input id="namepatr" name="namepatr" type="text" class="form-control" value="{{$folders[0]['PATRONYMIC']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="b_d">Дата рождения *</label>
                            <input id="b_d" name="b_d" type="text" class="required datepicker form-control" value="{{date('d.m.Y', strtotime($folders[0]['DATE_BIRTH']))}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sex">Пол *</label>
                            <select id="sex" name="sex" class="required form-control" >
                                <option disabled selected>-</option>
                                <option value="M" {{$folders[0]['GENDER']=='M'?'selected':''}}>М</option>
                                <option value="F" {{$folders[0]['GENDER']=='F'?'selected':''}}>Ж</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="phone">Телефон</label>
                            <input id="phone" name="phone" type="tel" class="form-control" value="{{$folders[0]['PHONE']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="email">Эл. почта</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{$folders[0]['EMAIL']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="address">Адрес</label>
                            <input id="address" name="address" type="text" class="form-control" value="{{$folders[0]['ADDRESS']}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="otd">ЛПУ</label>
                            <select name="otd" class="form-control" id="otd" onchange="selectPrice(this); return false;">
                                @foreach($depts as $val)
                                    <option value="{{$val['ID']}}" {{$val['ID']==$folders[0]['CLIENTID']?'selected':''}}>{{$val['DEPT']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="s_b">Срок беременности</label>
                            <select id="s_b" name="s_b" class="form-control">
                                <option value="">-</option>
                                @for($i=1; $i<=40; $i++)
                                    <option value='{{$i}}' {{$folders[0]['PREGNANCY']==$i?'selected':''}} >{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="f_c">Фаза цикла</label>
                            <select id="f_c" name="f_c" class="form-control">
                                <option value="">-</option>
                                <option value="M" {{$folders[0]['PREGNANCY']=='M'?'selected':''}}>Менопауза</option>
                                <option value="L" {{$folders[0]['PREGNANCY']=='L'?'selected':''}}>Лютеин</option>
                                <option value="O" {{$folders[0]['PREGNANCY']=='O'?'selected':''}}>Овуляция</option>
                                <option value="F" {{$folders[0]['PREGNANCY']=='F'?'selected':''}}>Фоликулин</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="diagnoz">Диагноз</label>
                            <input id="diagnoz" name="diagnoz" type="text" class="form-control" value="{{$folders[0]['RN2']}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="doctor">Врач</label>
                            <input name="doctorName" class="form-control doctor" type="text" value="{{$folders[0]['DOCTOR']}}">
                            <input name="doctorId" class="form-control" id="Rdoc" type="text" style="display: none" value="{{$folders[0]['DOCTOR_01']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="AIS">АИС ЛМК</label>
                            <input id="AIS" name="AIS" type="number" class="form-control" value="{{$folders[0]['AIS']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="cito">Срочность (CITO!)</label>
                            <select name="cito" id="cito" style="width:110px" class="form-control" >
                                <option value="">Обычный</option>
                                <option value="U" {{$folders[0]['CITO']=='U'?'checked':''}}>Срочный</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="comments">Комментарий</label>
                            <input id="comments" name="comments" type="text" class="form-control" value="{{$folders[0]['COMMENTS']}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="str">Страховая компания</label>
                            <input id="str" name="str" type="text" class="form-control" value="{{$folders[0]['STR']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="polis">Полис</label>
                            <input id="polis" name="polis" type="text" class="form-control" value="{{$folders[0]['POLIS']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="diarez">Диурез</label>
                            <input id="diarez" name="diarez" type="text" class="form-control" value="{{$folders[0]['RN1']}}">
                        </div>
                        <div class="col-md-3">
                            <label for="org">Организация</label>
                            <input id="org" name="org" type="text" class="form-control" value="{{$folders[0]['ORG']}}">
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
                                            <input id="n_p" name="n_p" type="text" class="form-control" value="{{$folders[0]['PASSPORT_NUMBER']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="s_p">Серия паспорта</label>
                                            <input id="s_p" name="s_p" type="text" class="form-control" value="{{$folders[0]['PASSPORT_SERIES']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="issued">Кем и когда выдали</label>
                                            <input type="text" name="issued" id="issued" class="form-control" value="{{$folders[0]['ISSUED']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="prime">Первичные/повторные пациенты</label>
                                            <select name="prime" id="prime" class="form-control">
                                                <option value="Y" {{$folders[0]['PRIME']=='Y'?'selected':''}}>Первичный</option>
                                                <option value="N" {{$folders[0]['PRIME']=='N'?'selected':''}}>Повторный</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="weight">Вес</label>
                                            <input id="weight" name="weight" type="number" class="form-control" value="{{$folders[0]['WEIGHT']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="height">Рост</label>
                                            <input id="height" name="height" type="number" class="form-control"  value="{{$folders[0]['HEIGHT']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="backref">Откуда узнали</label>
                                            <select name="backref" id="backref" class="form-control">
                                                <option value=""></option>
                                                @foreach($backref as $val)
                                                    <option value="{{$val['ID']}}" {{$folders[0]['BACKREF']==$val['ID']?'selected':''}}>{{$val['BACK']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="cash">Оплата*</label>
                                            <select name="cash" id="cash" required class="form-control">
                                                <option value="Y" {{$folders[0]['CASH']=='Y'?'selected':''}}>Наличными</option>
                                                <option value="N" {{$folders[0]['CASH']=='N'?'selected':''}}>Безналичными</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="n_k">№ скидочной карты</label>
                                            <input id="n_k" name="n_k" type="number" class="form-control" value="{{$folders[0]['CARDNO']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="discount">Скидочная группа </label>
                                            <select id="discount" name="discount2" class="form-control" >
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="docc">Основание для скидки</label>
                                            <input type="text" name="docc" id="docc" class="form-control" value="{{$folders[0]['DOC']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price">Прайслист *</label>
                                            <select id="price" name="price" class="form-control" required>
                                                <option value="" disabled selected>-</option>
                                                @foreach($pricelist as $val)
                                                    <option value='{{$val['ID']}}' {{$folders[0]['PRICELISTID']==$val['ID']?'selected':''}}>{{$val['DEPT']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="kk">Код контингента</label>
                                            <select name="kk" id="kk" class="form-control">
                                                <option></option>
                                                <option value="102" {{$folders[0]['KCODE']==102?'selected':''}}>102 - больные наркоманией</option>
                                                <option value="103" {{$folders[0]['KCODE']==103?'selected':''}}>103 - гомо- бисексуалисты</option>
                                                <option value="104" {{$folders[0]['KCODE']==104?'selected':''}}>104 - больные ЗПП</option>
                                                <option value="109" {{$folders[0]['KCODE']==109?'selected':''}}>109 - беременные</option>
                                                <option value="112" {{$folders[0]['KCODE']==112?'selected':''}}>112 - лица в местах лишения свободы</option>
                                                <option value="113" {{$folders[0]['KCODE']==113?'selected':''}}>113 - обследования по клиническим показаниям</option>
                                                <option value="115" {{$folders[0]['KCODE']==115?'selected':''}}>115 - медперсонал, работающий с больными ВИЧ</option>
                                                <option value="118" {{$folders[0]['KCODE']==118?'selected':''}}>118 - прочие</option>
                                                <option value="200" {{$folders[0]['KCODE']==120?'selected':''}}>200 - иностранные граждане</option>
                                            </select>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="prob">Препарат</label>
                                                    <input id="prob" name="prob" type="text" class="form-control" disabled value="{{$folders[0]['ANTIBIOTIC']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="antib">Антибиотики</label>
                                            <input id="antib" name="antib" type="checkbox" onchange="toggleBio(this); return false;" {{$folders[0]['ANTIBIOT']=='Y'?'checked':''}} style="display: block; margin: auto; width: 20px; height: 20px;">
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
                                            <input type="checkbox" name="s_sms" id="s_sms" {{$folders[0]['S_SMS']=='Y'?'checked':''}} style="display: block; margin: auto; width: 20px; height: 20px;">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="s_email">Отправлять email</label>
                                            <input type="checkbox" name="s_email" id="s_email" {{$folders[0]['S_EMAIL']=='Y'?'checked':''}} style="display: block; margin: auto; width: 20px; height: 20px;">
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
                <h3>Finish</h3>
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
                            <input id="Rdiscount" name="discount3" type="text" class="form-control" readonly>
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
            <input type="hidden" id="oldcost" value="0" name="oldcost">
            <input type="hidden" id="otd" value="{{$folders[0]['CLIENTID']}}" name="otd" >
            <input type="hidden" name="folderno" value="<?php echo $id; ?>" />
        </form>
        @include('scripts.editScript')
    </div>
    @stop