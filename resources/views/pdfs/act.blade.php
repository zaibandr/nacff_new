<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
    *
    {
        font-family: "DejaVu Serif", serif;
        font-size: 9px;
        margin: 0;
        padding: 0;
        padding-top: 0;
    }
    .tab
    {
        border-bottom: 2px black solid;
        border-top: 2px black solid;
        margin-left: 40px;
        margin-right: 40px;
        table-layout: fixed;
        border-collapse: collapse
    }
    .tab tr:last-child td
    {
        padding-bottom: 10px;
    }
    .tab tr:first-child th
    {
        border-bottom: 1pt solid black;
    }
</style>
<table style="padding: 40px; padding-top: 80px;">
    <tr>
        <td colspan="1"><img src="{{secure_asset('images/03.png')}}" alt="" width="250"></td>
        <td colspan="3" align="center"><b>НАЦИОНАЛЬНОЕ АГЕНТСТВО КЛИНИЧЕСКОЙ ФАРМАКОЛОГИИ И ФАРМАЦИИ<br>
                РОССИЯ, 109099, МОСКВА, УЛ. УГРЕШСКАЯ, Д.2, СТР.8<br>
                ТЕЛ.: +7-(495)-933-96-96, WWW.NACPP.RU</b></td>
    </tr>
</table>
<pre style="margin-top: 20px; margin-bottom: 20px; margin-left:40px; line-height: 16px; font-size: 11px">
    Заказчик:  {{$pdata['DEPT']}}
    Пациент:  {{$pdata['SURNAME'].' '.$pdata['NAME'].' '.$pdata['PATRONYMIC']}}
    Дата рождения:  {{date('d.m.Y', strtotime($pdata['DATE_BIRTH']))}}   Пол:  {{$pdata['GENDER']=='F'?'ЖЕН':'МУЖ'}}   Дата взятия биоматериала: {{date('d.m.Y', strtotime($pdata['LOGDATE']))}}
    Комментарий:  {{$pdata['COMMENTS']}}
    Врач:  {{$pdata['DOCTOR']}}
</pre>
<table class="tab" width="100%" cellpadding="5px">
    <tr>
        <th width="10%">Номер образца</th>
        <th width="30%">Тип контейнера</th>
        <th width="10%">Панель</th>
        <th width="40%">Название панели</th>
        <th width="10%">Срок выполнения (дни)</th>
    </tr>
    @foreach($act as $val)
        <tr>
        <td width="10%">{{$val['CONTAINERNO']}}</td>
        <td width="30%">{{$val['CONTGROUP']}}</td>
        <td width="10%">{{$val['CODE']}}</td>
        <td width="40%">{{$val['PANEL']}}</td>
        <td width="10%">{{$val['DUE']}}</td>
        </tr>
        @endforeach
</table>
<pre style="margin-top: 40px; margin-left:40px; line-height: 24px; font-size: 11px">
    Настоящим подтверждаю правильность указанных в настоящем бланке-заказе данных:

    Подпись:  __________________     /_______________/
    Дата:     __________________
</pre>
