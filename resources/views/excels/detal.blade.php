<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<br>
<br>
<br>
<style type="text/css">
    td
    {
        border:1px solid;
        height: 20px;
    }
</style>
<table border="1px solid">
    <thead>
    <tr>
        <td colspan="13" align="center">Детальный отчет за период с  <?php echo Input::get('date_st',date('Y-m-d',strtotime("-3 days")));?> по <?php echo Input::get('date_en',date('Y-m-d'));?></td>
    </tr>
    <tr></tr>
    <tr>
        <td>Дата</td>
        <td>Отделение</td>
        <td>Направление</td>
        <td>Фамилия</td>
        <td>Имя</td>
        <td>Отчество</td>
        <td>Код услуги</td>
        <td>Услуга</td>
        <td>Цена без скидки</td>
        <td>Скидка</td>
        <td>Цена со скидкой</td>
        <td>Цена НАКФФ</td>
        <td>Дельта</td>
    </tr>
    </thead>
    <tbody>
    @foreach($table as $val)
        <tr>
            <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
            <td>{{$val['DEPT']}}</td>
            <td>{{$val['FOLDERNO']}}</td>
            <td>{{$val['SURNAME']}}</td>
            <td>{{$val['NAME']}}</td>
            <td>{{$val['PATRONYMIC']}}</td>
            <td>{{isset($val['CODE'])?$val['CODE']:$val['CODE_01']}}</td>
            <td width="90px">{{isset($val['PANEL'])?$val['PANEL']:$val['NAME_01']}}</td>
            <td>{{$val['PRICE']}}</td>
            <td>{{$val['DISCOUNT']}}</td>
            <td>{{$val['COST']}}</td>
            <td>{{$val['NACPH']}}</td>
            <td>{{$val['COST'] - $val['NACPH']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>