<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr><td colspan="2" style="text-align: center; font-size: larger;">Откуда узнали</td></tr>
    <tr></tr>
    <tr>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Источник</td>
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