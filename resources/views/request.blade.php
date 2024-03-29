@extends('default')
@section('content')
    <link href="{{secure_asset('resources/assets/css/request.css')}}" rel="stylesheet">
<div id="request">
            <h1>Информация по заявке: {{$id}}</h1>
    <div class="row" style="background: #49B1C2; margin-top: 2%; margin-bottom: 2%">
        <div class="col-lg-3"><p style="text-align:center; font-size: 1.2em; padding: 3px; color:white; margin: 0; font-weight: bold;">Общее</p></div>
        <div class="col-lg-9"><p style="text-align:center; font-size: 1.2em; padding: 3px; color:white; margin: 0; font-weight: bold;">Результаты анализов</p></div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <table id="a" class="table">
                <tr>
                    <td>PID</td>
                    <td><a href="{{url("pid/".$folder['PID'])}}"><b>{{$folder['PID']}}</b></a></td>
                </tr>
                <tr>
                    <td>Дата и время сбора</td>
                    <td><b>{{date('d.m.Y H:i',strtotime($folder['LOGDATE']))}}</b></td>
                </tr>
                <tr>
                    <td>Фамилия</td>
                    <td><b>{{$folder['SURNAME']}}</b></td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><b>{{$folder['NAME']}}</b></td>
                </tr>
                <tr>
                    <td>Отчество</td>
                    <td><b>{{$folder['PATRONYMIC']}}</b></td>
                </tr>
                <tr>
                    <td>Дата рождения</td>
                    <td><b>{{date('d.m.Y', strtotime($folder['DATE_BIRTH']))}}</b></td>
                </tr>
                <tr>
                    <td>Врач</td>
                    <td><b>{{$folder['DOCTOR']}}</b></td>
                </tr>
                <tr>
                    <td>ЛПУ</td>
                    <td><b>{{$folder['DEPT']}}</b></td>
                </tr>
            </table>
            <br>
            <a href="{{secure_url("print/$id?action=save&logo=1")}}" class="lnk" target="_blank"><span class="fa fa-file-pdf-o"></span> Сохранить в <b>PDF</b><br></a>
            <a href="{{secure_url("print/$id?action=print&logo=1")}}" class="lnk" target="_blank"><span class="fa fa-print"></span> Распечатать<br></a>
            <a href="{{secure_url("print/$id?action=print&logo=1&a5=1")}}" class="lnk" target="_blank"><span class="fa fa-print"> </span>Распечатать в формате А5<br></a>
            <a href="{{secure_url("mail/$id?logo=1")}}" ><span class="fa fa-envelope-o" target="_blank"> </span>Отправить по почте<br></a>
            <input type="checkbox" id="sign"> С печатью НАКФФ<br>
            <input type="checkbox" id="signature"> С подписью врача<br>
            <input type="checkbox" id="person_blank"> На индивидуальном бланке<br>
        </div>
        <div class="col-lg-9">
            <table width="100%">
                @foreach($ordtask as $key=>$val)
                    <tr>
                        <td style="padding-bottom: 2%">
                            <a href="#" onclick="showinfo('{{str_replace('.','',$key)}}'); return false;"><span class="glyphicon glyphicon-minus {{str_replace('.','',$key)}}" ></span><b style="font-size: 1.3em; margin-left: 10px;">{{$key}} - {{$val['PANEL']}}</b></a>
                            <sup style="color: {{$val['STATUSCOLOR']}}">{{$val['STATUSNAME']}}</sup>
                        </td>
                    </tr>
                        @if(isset($val['TESTNAME']) && count($val['TESTNAME'])<1))
                            <tr><td>Результатов еще нет</td></tr>
                    @elseif(isset($val['TESTNAME']))
                        @foreach($val['TESTNAME'] as $k=>$v)
                            <tr>
                                <td colspan="4" ><div class="{{str_replace('.','',$key)}}" style="font-weight: bold; font-size: 1.1em">{{$k}}</div></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom:2%; margin-left: 10%; margin-top:1%; line-height: 25px; " class="{{str_replace('.','',$key)}}">
                                        <table width="100%" id="b" class="table-bordered">
                                            <tr>
                                                <th width="70%" style="padding-left: 2%">Исследование</th>
                                                <th width="10%" style="padding-left: 2%; padding-right: 2%">Результат</th>
                                                <th width="10%" style="padding-left: 2%; padding-right: 2%">Предельные значения</th>
                                                <th width="10%" style="padding-left: 2%; padding-right: 2%">Ед. изм.</th>
                                            </tr>
                                            @for($i=0; $i<count($v['ANALYTE']);$i++)
                                                <tr style="background: @if($v['STATUS'][$i]=='O') rgba(204, 115, 87, 0.28); @endif">
                                                    <td style="padding-left: 2%">{{$v['ANALYTE'][$i]}}</td>
                                                    <td style="padding-left: 2%; padding-right: 2%">{{$v['FINALRESULT'][$i]}}</td>
                                                    <td style="padding-left: 2%; padding-right: 2%">{{$v['CHARLIMITS'][$i]}}</td>
                                                    <td style="padding-left: 2%; padding-right: 2%">{{$v['UNIT'][$i]}}</td>
                                                </tr>
                                            @endfor
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                    @endforeach
            </table>
        </div>
    </div>
</div>
    <script>
        $(function(){
            $('input#sign').on('click', function() {
                if( $(this).is(':checked') ) {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.concat('&seal=1'));
                    });
                } else {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.replace(/&?seal=\d+/, ''));
                    });
                }
            });
            $('input#signature').on('click', function() {
                if( $(this).is(':checked') ) {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.concat('&signature=1'));
                    });
                } else {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.replace(/&?signature=\d+/, ''));
                    });
                }
            });
            $('input#person_blank').on('click', function() {
                if( $(this).is(':checked') ) {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.concat('&person_blank=1'));
                    });
                } else {
                    $('a.lnk').each(function() {
                        href = $(this).attr('href');
                        $(this).attr('href', href.replace(/&?person_blank=\d+/, ''));
                    });
                }
            })
        });
        function showinfo(id){
            if ( $("div."+id).css("display") == "none" ) {
                $("span."+id).switchClass("glyphicon-plus","glyphicon-minus",0);
                $("div."+id).css('display','block');
            } else {
                $("span."+id).switchClass("glyphicon-minus","glyphicon-plus",0);
                $("div."+id).css('display','none');
            }
        }
    </script>
    @stop