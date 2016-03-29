<div class="col-lg-12">
    <div id="chart-div"></div>
    <?=$lava->render('DonutChart','Dep','chart-div' ) ?>
</div>
<div class="col-lg-12">
    <table class="tablesorter">
        <thead>
        <tr>
            <td>Доктор</td>
            <td>Общая сумма</td>
        </tr>
        </thead>
        <tbody>
        @foreach($pan as $k=>$v)
            <tr>
                <td>{{$k}}</td>
                <td>{{$v}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>