<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr><td colspan="7" style="text-align: center; font-size: larger;">По врачам</td></tr>
    <tr></tr>
    <tr>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Панель</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Код</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Количество</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Общая сумма (с учетом скидки)</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Скидка</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Сумма НАКФФ</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Дельта</td>
    </tr>
    <tbody>
    @foreach($pan as $k=>$v)
        <tr>
            <td height="20px" style="border:1px solid ">{{$k}}</td>
            <td height="20px" style="border:1px solid ">{{$v['panel']}}</td>
            <td height="20px" style="border:1px solid ">{{$v['count']}}</td>
            <td height="20px" style="border:1px solid ">{{$v['cost']}}</td>
            <td height="20px" style="border:1px solid ">{{$v['dis']}}</td>
            <td height="20px" style="border:1px solid ">{{$v['nacff']}}</td>
            <td height="20px" style="border:1px solid ">{{$v['cost']-$v['nacff']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>