<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr><td colspan="2" style="text-align: center; font-size: larger;">Первичные/повторные пациенты</td></tr>
    <tr></tr>
    <tr>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Пациенты</td>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Количество</td>
    </tr>
    <tbody>
    @foreach($pan as $k=>$v)
        <tr>
            <td height="20px" style="border:1px solid ">{{$k}}</td>
            <td height="20px" style="border:1px solid ">{{$v}}</td>
        </tr>
    @endforeach
    </tbody>
</table>