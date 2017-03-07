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
        margin-top: 20px;
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
<p style="text-align: center; font-size: 2em">Акт приема и передачи проб биологического материала </p>
<table class="tab" width="100%" cellpadding="5px" border="1">
    <tr>
        <th width="25%">Дата:</th>
        <td width="25%">{{date('d.m.Y')}}</td>
        <th width="25%">Время:</th>
        <td width="25%">{{date('H:i')}}</td>
    </tr>
    <tr>
        <th width="25%">Сдал</th>
        <td width="25%"></td>
        <th width="25%">Подпись</th>
        <td width="25%"></td>
    </tr>
    <tr>
        <th width="25%">Принял</th>
        <td width="25%"></td>
        <th width="25%">Подпись</th>
        <td width="25%"></td>
    </tr>
    <tr>
        <td colspan="4">
            <p style="font-size: 1.5em; margin-top: 10px;  margin-left: 40px;"> Список контейнеров:</p>
        </td>
    </tr>
    <tr>
        <th width="40%">Тип контейнера</th>
        <th width="20%" style="border: 1px solid black">Количеств проб с биоматериалом (штук)</th>
        <th width="20%" style="border: 1px solid black">Проверено на герметичность (подпись)</th>
        <th width="20%">Принято отделом регистрации НАКФФ:</th>
    </tr>
    @foreach($courier as $key=>$val)
        <tr>
            <td>{{$key}}</td>
            <td style="text-align: center; border: 1px solid black">{{$val}}</td>
            <td style="border: 1px solid black"></td>
            <td></td>
        </tr>
        @endforeach

</table>

