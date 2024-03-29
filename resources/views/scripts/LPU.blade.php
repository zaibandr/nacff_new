<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.widgets.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/widgets/widget-scroller.js')}}"></script>
<script>
    var clpu = 0;
    $(function(){
        $('.tablesorter').tablesorter({
            // Add a theme - try 'blackice', 'blue', 'dark', 'default'
            theme: 'dropbox',
            showProcessing: true,
            headerTemplate : '{content} {icon}',
            // fix the column widths
            widthFixed: true,

            // include zebra and any other widgets, options:
            // 'columns', 'filter', 'stickyHeaders' & 'resizable'
            // 'uitheme' is another widget, but requires loading
            // a different skin and a jQuery UI theme.
            widgets: [ 'zebra', 'filter', 'stickyHeaders'],
            widgetOptions : {
                // uitheme widget: * Updated! in tablesorter v2.4 **
                // Instead of the array of icon class names, this option now
                // contains the name of the theme. Currently jQuery UI ("jui")
                // and Bootstrap ("bootstrap") themes are supported. To modify
                // the class names used, extend from the themes variable
                // look for the "$.extend($.tablesorter.themes.jui" code below
                uitheme: 'jui',

                // columns widget: change the default column class names
                // primary is the 1st column sorted, secondary is the 2nd, etc
                columns: [
                    "primary",
                    "secondary",
                    "tertiary"
                ],
                // columns widget: If true, the class names from the columns
                // option will also be added to the table tfoot.
                columns_tfoot: true,
                // columns widget: If true, the class names from the columns
                // option will also be added to the table thead.
                columns_thead: true,
                // filter widget: If true, a filter will be added to the top of
                // each table column.
                filter_columnFilters: true,

                // filter widget: css class applied to the table row containing the
                // filters & the inputs within that row
                filter_cssFilter: "tablesorter-filter",

                // filter widget: Customize the filter widget by adding a select
                // dropdown with content, custom options or custom filter functions
                // see http://goo.gl/HQQLW for more details
                filter_functions: null,

                // filter widget: Set this option to true to hide the filter row
                // initially. The rows is revealed by hovering over the filter
                // row or giving any filter input/select focus.
                filter_hideFilters: true,

                // filter widget: Set this option to false to keep the searches
                // case sensitive
                filter_ignoreCase: true,

                // filter widget: jQuery selector string of an element used to
                // reset the filters.
                filter_reset: null,

                // Delay in milliseconds before the filter widget starts searching;
                // This option prevents searching for every character while typing
                // and should make searching large tables faster.
                filter_searchDelay: 300,

                // filter widget: Set this option to true to use the filter to find
                // text from the start of the column. So typing in "a" will find
                // "albert" but not "frank", both have a's; default is false
                filter_startsWith: false,

                // filter widget: If true, ALL filter searches will only use parsed
                // data. To only use parsed data in specific columns, set this option
                // to false and add class name "filter-parsed" to the header
                filter_useParsedData: false,

                // Resizable widget: If this option is set to false, resized column
                // widths will not be saved. Previous saved values will be restored
                // on page reload
                resizable: true,

                // saveSort widget: If this option is set to false, new sorts will
                // not be saved. Any previous saved sort will be restored on page
                // reload.
                saveSort: true,

                // stickyHeaders widget: css class name applied to the sticky header
                stickyHeaders: "tablesorter-stickyHeader",
                scroller_height : 500,
                // scroll tbody to top after sorting
                scroller_upAfterSort: true,
                // pop table header into view while scrolling up the page
                scroller_jumpToHeader: true,
                // In tablesorter v2.19.0 the scroll bar width is auto-detected
                // add a value here to override the auto-detected setting
                scroller_barWidth : null
                // scroll_idPrefix was removed in v2.18.0
                // scroller_idPrefix : 's_'
            }
        });
        var filters = [],
                $t = $(this),
                col = $t.data('filter-column'), // zero-based index
                txt = $t.data('filter-text') || $t.text(); // text to add to filter
        filters[col] = txt;
        // using "table.hasFilters" here to make sure we aren't targetting a sticky header
        $.tablesorter.setFilters( $('.tablesorter'), filters, true ); // new v2.9

        //$("#moreLpu").click(addLPU(clpu));

    });
    function addLPU(){
        clpu++;
        $(".lpu-group").append("<div class=\"form-group\"><label for=\"lpu"+clpu+"\">Номер ЛПУ</label><i class=\"fa fa-close\" style=\'color: red\' onclick=\'delInput("+clpu+")\'></i><input type=\"text\" name=\"lpu"+clpu+"\" class=\"form-control lpuItem"+clpu+"\" onblur=\"addDeps("+clpu+",this.value)\"></div><div class=\"form-group\" id=\"deps"+clpu+"\"></div>");
    }
    function addDeps(a,lpu){
            v = $.get("app/Http/Controllers/LPUDeps.php", {
                        'lpu': lpu
                    },
                    function (data) {
                        $("#deps"+a).empty();
                        $.each(data,function(i,item){
                            $("#deps"+a).append("<label for='"+item.DEPT+"'>"+item.DEPT+"</label>");
                            $("#deps"+a).append("<input type='checkbox' name='dept"+i+clpu+"' value='"+item.DEPT+"' />");
                            //console.log(item);
                        });

                    }, 'json');
    }
    function modal(a, b){
        for(var i=clpu;i>0;i--){
            //console.log(i);
            delInput(i);
        }
        clpu=0;

        tr = a.closest('tr');
        $('#name').val(tr.cells[0].innerHTML);
        $('#password').val(tr.cells[1].innerHTML);
        $('.lpuItem').val(tr.cells[2].innerHTML);
        lus = tr.cells[2].innerHTML.split("<br>");
        des = tr.cells[3].innerHTML.split("<br>");

        a = {};
        for(i=0;i<lus.length-1; i++){
            if(lus[i].trim() in a){
                a[lus[i].trim()] = a[lus[i].trim()]+','+des[i].trim();
            } else
            a[lus[i].trim()] = des[i].trim();
        }
            //console.log(a);
        j=0;
        jQuery.each(a,function(i,v){
            if(j==0){
                $(".lpuItem"+clpu).val(i);
                addDeps(j,i);
                checkboxes =  $("#deps"+clpu+" input:checkbox");
                    checkboxes.prop('checked',true);
                console.log(checkboxes.val());
            } else {
                addLPU();
                $(".lpuItem"+clpu).val(i);
                addDeps(j,i);
            }
            j++;
        });
        if($.trim(tr.cells[4].innerHTML)=='Медсестра') {
            $('#roleD').prop('checked',true);
            $('#roleM').prop('checked',false);
        }
        else
        {
            $('#roleM').prop('checked',true);
            $('#roleD').prop('checked',false);
        }
    }
    function isDel(){
        return confirm('Вы действительно хотите удалить?');
    }
    function delInput(i){
        $(".form-group label[for='lpu"+i+"']").closest('.form-group').remove();
        $("#deps"+i).remove();
    }
</script>