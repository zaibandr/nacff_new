<div class="col-lg-12">
    <div id="chart-div"></div>
    <?=$lava->render('DonutChart','Dep','chart-div' ) ?>
</div>
<div class="col-lg-12">
    <table class="tablesorter">
        <thead>
        <tr>
            <td>Отделение</td>
            <td>Общая сумма (с учетом скидки)</td>
            <td>Сумма НАКФФ</td>
            <td>Дельта</td>
        </tr>
        </thead>
        <tbody>
        @foreach($pan as $k=>$v)
            <tr>
                <td>{{$k}}</td>
                <td>{{$v['cost']}}</td>
                <td>{{$v['nacpp']}}</td>
                <td>{{$v['cost']-$v['nacpp']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>