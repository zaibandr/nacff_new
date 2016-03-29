<div class="col-lg-12">
    <div id="chart-div"></div>
    <?=$lava->render('DonutChart','Dep','chart-div' ) ?>
</div>
<div class="col-lg-12">
    <table class="tablesorter">
        <thead>
        <tr>
            <td>Панель</td>
            <td>Код</td>
            <td>Количество</td>
            <td>Общая сумма (с учетом скидки)</td>
            <td>Скидка</td>
            <td>Сумма НАКФФ</td>
            <td>Дельта</td>
        </tr>
        </thead>
        <tbody>
        @foreach($pan as $k=>$v)
            <tr>
                <td>{{$k}}</td>
                <td>{{$v['panel']}}</td>
                <td>{{$v['count']}}</td>
                <td>{{$v['cost']}}</td>
                <td>{{$v['dis']}}</td>
                <td>{{$v['nacff']}}</td>
                <td>{{$v['cost']-$v['nacff']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>