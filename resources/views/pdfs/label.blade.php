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
</style><? $i=1 ?>
@foreach($code as $val)
    <? $cont = (int)Input::get($val['CONTAINERNO']) ?>
    @while($cont>=1)
        @if($i!==1)
            <div class="page-break"></div>
        @endif
    <table style="width: 100%; height: 100px; padding-left:10px; text-align: center">
        <tr align="center" >
            <td style="padding-top: 10px"><b>{{Session::get('clientcode')}}</b></td>
            <td style="padding-top: 10px; font-size: 7px"><b>{{substr($val['CONTGROUP'],0,20)}}</b></td>
            <td style="padding-top: 10px"><b>{{substr($val['CONTAINERNO'],0,10)}}</b></td>
            </tr>
        <tr>
            <td colspan="3" align="center" style="padding-left: 40px;"><? echo DNS1D::getBarcodeHTML($val['CONTAINERNO'], "C128",1.4,65); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>{{substr($val['CONCATENATION'],0,40)}}</b></td>
        </tr>
    </table>
    <? $cont-- ?>
    <? $i++ ?>
            @endwhile
@endforeach
<script type="text/javascript">
    var pp = this.getPrintParams();
    pp.interactive = pp.constants.interactionLevel.silent;
    pp.printerName = "NAKFF";
    this.print(pp);
</script>