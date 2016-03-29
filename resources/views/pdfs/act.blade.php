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
        <td colspan="1"><img src="{{asset('images/03.png')}}" alt="" width="250"></td>
        <td colspan="3" align="center"><b>НАЦИОНАЛЬНОЕ АГЕНТСТВО КЛИНИЧЕСКОЙ ФАРМАКОЛОГИИ И ФАРМАЦИИ<br>
                РОССИЯ, 109099, МОСКВА, УЛ. УГРЕШСКАЯ, Д.2, СТР.8<br>
                ТЕЛ.: +7-(495)-933-96-96, WWW.NACPP.RU</b></td>
    </tr>
</table>
<pre style="margin-top: 20px; margin-bottom: 20px; margin-left:40px; line-height: 16px; font-size: 11px">
    Заказчик:  {{$act['DEPT']}}
    Пациент:  {{$act['NAME']}}
    Дата рождения:  {{date('d.m.Y', strtotime($act['DATE_BIRTH']))}}   Пол:  <? echo $act['GENDER']=='F'?'ЖЕН':'МУЖ'; ?>   Дата взятия биоматериала: {{date('d.m.Y', strtotime($act['LOGDATE']))}}
    Комментарий:  {{$act['COMMENTS']}}
    Врач:  {{$act['DOCTOR']}}
</pre>
<table class="tab" width="100%" cellpadding="5px">
    <tr>
        <th width="10%">Номер образца</th>
        <th width="30%">Тип контейнера</th>
        <th width="10%">Панель</th>
        <th width="40%">Название панели</th>
        <th width="10%">Срок выполнения (дни)</th>
    </tr>
    @for($i=0; $i<count($act['panel']); $i++)
        <tr>
        <td width="10%">{{$act['cont'][$i]}}</td>
        <td width="30%">{{$act['cgroup'][$i]}}</td>
        <td width="10%">{{$act['panel'][$i]}}</td>
        <td width="40%">{{$act['pname'][$i]}}</td>
        <td width="10%">{{$act['due'][$i]}}</td>
        </tr>
        @endfor
</table>
<pre style="margin-top: 40px; margin-left:40px; line-height: 24px; font-size: 11px">
    Настоящим подтверждаю правильность указанных в настоящем бланке-заказе данных:

    Подпись:  __________________     /_______________/
    Дата:     __________________
</pre>
