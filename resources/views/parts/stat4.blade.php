<div class="col-lg-12 hidden-sm hidden-xs">
    <div id="chart-div"></div>
    <?=$lava->render('AreaChart','Dep','chart-div' ) ?>
</div>
<div class="col-lg-12">
    <table class="tablesorter">
        <thead>
        <tr>
            <td>Дата</td>
        @foreach($dept as $v)
                <td>{{$v}}</td>
        @endforeach
            <td>Общее количество</td>
        </tr>
        </thead>
        <tbody>
        @foreach($pan as $k=>$v)
            <tr>
                <td>{{$k}}</td>
                @foreach($dept as $vv)
                    <td>{{$v[$vv]}}</td>
                @endforeach
                <td>{{$v['count']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>