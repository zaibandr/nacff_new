<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr><td colspan="4" style="text-align: center; font-size: larger;">Количество проб по дням</td></tr>
    <tr></tr>
    <tr>
        <td height="20px" style="border:1px solid; font-weight: bold; ">Дата</td>
        @foreach($depts as $v)
            <td height="20px" style="border:1px solid; font-weight: bold; ">{{$v}}</td>
        @endforeach
        <td height="20px" style="border:1px solid; font-weight: bold; ">Общее количество</td>
    </tr>
    <tbody>
    @foreach($pan as $k=>$v)
        <tr>
            <td height="20px" style="border:1px solid ">{{$k}}</td>
            @foreach($depts as $vv)
                <td height="20px" style="border:1px solid ">{{$v[$vv]}}</td>
            @endforeach
            <td height="20px" style="border:1px solid ">{{$v['count']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>