<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
    *
    {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 10px;
        margin: 0;
        padding: 0;
    }
    tbody:before, tbody:after { display: none; }
    thead:before, thead:after { display: none; }
    .page-break {
        page-break-after: always;
    }
</style><? $i=0 ?>
@foreach($code as $val)
    <table style="width: 100%; height: 100px; padding-left:10px; text-align: center">
        <tr align="center" >
            <td style="padding-top: 10px"><b>{{Session::get('clientcode')}}</b></td>
            <td style="padding-top: 10px; font-size: 7px"><b>{{$val['CONTGROUP']}}</b></td>
            <td style="padding-top: 10px"><b>{{$val['CONTAINERNO']}}</b></td>
            </tr>
        <tr>
            <td colspan="3" align="center" style="padding-left: 40px;"><? echo DNS1D::getBarcodeHTML($val['CONTAINERNO'], "C128",1.4,65); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>{{$val['CONCATENATION']}}</b></td>
        </tr>
    </table>
    <? $i++ ?>
    @if(count($code)!==$i)
    <div class="page-break"></div>
    @endif
@endforeach
<script type="text/javascript">

</script>
