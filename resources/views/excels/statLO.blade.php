<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr><td colspan="4" style="text-align: center; font-size: larger;">Количество направлений по ЛО</td></tr>
        <tr></tr>
        <tr>
            <td height="20px" style="border:1px solid; font-weight: bold; ">Отделение</td>
            <td height="20px" style="border:1px solid; font-weight: bold; ">Общая сумма</td>
            <td height="20px" style="border:1px solid; font-weight: bold; ">Сумма НАКФФ</td>
            <td height="20px" style="border:1px solid; font-weight: bold; ">Дельта</td>
        </tr>
        <tbody>
        @foreach($pan as $k=>$v)
            <tr>
                <td height="20px" style="border:1px solid ">{{$k}}</td>
                <td height="20px" style="border:1px solid ">{{$v['cost']}}</td>
                <td height="20px" style="border:1px solid ">{{$v['nacpp']}}</td>
                <td height="20px" style="border:1px solid ">{{$v['cost']-$v['nacpp']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
