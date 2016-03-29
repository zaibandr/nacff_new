<script src="{{asset('resources/assets/scripts/jquery.tablesorter.js')}}"></script>
<script src="{{asset('resources/assets/scripts/jquery.tablesorter.widgets.js')}}"></script>
<script src="{{asset('resources/assets/scripts/widget-scroller.js')}}"></script>
<script>
    $(function(){
        var tablesorterOptions = {
            theme: 'dropbox',
            widthFixed: true,
            showProcessing: true,
            headerTemplate : '{content} {icon}',
            widgets: [ 'zebra'],
            widgetOptions : {
            }
        };

        $("#tabs").tabs({
            create: function (event, ui) {
                var $t = ui.panel.find('table');
                if ($t.length) {
                    $t.tablesorter(tablesorterOptions);
                }
            },
            activate: function (event, ui) {
                var $t = ui.newPanel.find('.tablesorter');
                if ($t.length) {
                    if ($t[0].config) {
                        $t.trigger('applyWidgets');
                    } else {
                        $t.tablesorter(tablesorterOptions);
                    }
                }
            }
        });
        $('tr.analyte').css('display','none');
        $("tr.test").on('click', function(){
            $('#analyteTable tr.analyte').remove();
            var $ntr = this.nextSibling;
            while ($ntr.style.getPropertyValue('display')=='none'){
                var $tr = $ntr.cloneNode(true);
                $tr.style.display='block';
                $('#analyteTable').append($tr);
                $('#analyteTable tr').removeAttr('class');
                $('#analyteTable tr').removeAttr('style');
                $ntr = $ntr.nextSibling;
            }
        })
    });
</script>