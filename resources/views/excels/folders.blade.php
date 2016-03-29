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
        <td colspan="14" align="center">Список направлений за период с  <?php echo Input::get('date_st',date('Y-m-d',strtotime("-3 days")));?> по <?php echo Input::get('date_en',date('Y-m-d'));?></td>
    </tr>
    <tr></tr>
    <tr>
        <th >Статус</th>
        <th >Направление</th>
        <th >ФИО</th>
        <th >Пол</th>
        <th >Дата регистрации</th>
        <th >Дата рождения</th>
        <th >Отделение</th>
        <th >Организация</th>
        <th >Доктор</th>
        <th >Страховая компания</th>
        <th >Комментарий</th>
        <th >Цена по прайсу</th>
        <th >Цена с учетом скидки</th>
        <th >Скидка</th>
    </tr>
    </thead>
    <tbody>
    @foreach($folders as $val)
        <tr>
            <td style="color:{{$val['STATUSCOLOR']}}; font-weight: bold;">{{$val['STATUSNAME']}}</td>
            <td><a href='{{$val['STATUSNAME']=='Черновик' ? url('draft/'.$val['FOLDERNO']) : url('request/'.$val['FOLDERNO'])}}'>{{$val['FOLDERNO']}}</a></td>
            <td>{{$val['SURNAME']." ".$val['NAME']." ".$val['PATRONYMIC']}}</td>
            <td>{{$val['GENDER']=='F' ? 'Ж' : 'М'}}</td>
            <td>{{date('d.m.Y',strtotime($val['LOGDATE']))}}</td>
            <td>{{date('d.m.Y',strtotime($val['DATE_BIRTH']))}}</td>
            <td>{{$val['DEPT']}}</td>
            <td>{{$val['ORG']}}</td>
            <td>{{$val['DOCTOR']}}</td>
            <td>{{$val['STR']}}</td>
            <td>{{$val['COMMENTS']}}</td>
            <td>{{$val['PRICE']}}</td>
            <td>{{$val['COST']}}</td>
            <td>{{$val['DISCOUNT']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>