<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.widgets.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.pager.min.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/widget-columnSelector.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.ru.min.js')}}"></script>
<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            format: 'dd.mm.yyyy',
            language: 'ru',
            autoclose: true,
            clearBtn: true
        });
           var pagerOptions = {
            // target the pager markup - see the HTML block below
            container: $(".pager"),
            // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
            output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
            // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
            // table row set to a height to compensate; default is false
            fixedHeight: true,
            // remove rows from the table to speed up the sort of large tables.
            // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
            removeRows: false,
            // go to page selector - select dropdown that sets the current page
            cssGoto: '.gotoPage'
        };

        // Initialize tablesorter
        // ***********************
        $(".tablesorter")
                .tablesorter({
                    theme: 'dropbox',
                    headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
                    widthFixed: true,
                    dateFormat: 'dd.mm.yy',
                    headers: { 4: { sorter: 'shortDate'} },
                    widgets: ['filter', 'columnSelector'],
                    widgetOptions: {
                        // target the column selector markup
                        columnSelector_container : $('#popover-target'),
                        // column status, true = display, false = hide
                        // disable = do not display on list
                        columnSelector_columns : {
                            0: 'disable' /* set to disabled; not allowed to unselect it */
                        },
                        // remember selected columns (requires $.tablesorter.storage)
                        columnSelector_saveColumns: true,

                        // container layout
                        columnSelector_layout : '<label><input type="checkbox">{name}</label><br>',
                        // data attribute containing column name to use in the selector container
                        columnSelector_name  : 'data-selector-name',

                        /* Responsive Media Query settings */
                        // enable/disable mediaquery breakpoints
                        columnSelector_mediaquery: true,
                        // toggle checkbox name
                        columnSelector_mediaqueryName: 'Все: ',
                        // breakpoints checkbox initial setting
                        columnSelector_mediaqueryState: true,
                        // hide columnSelector false columns while in auto mode
                        columnSelector_mediaqueryHidden: true,
                        // responsive table hides columns with priority 1-6 at these breakpoints
                        // see http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/#Applyingapresetbreakpoint
                        // *** set to false to disable ***
                        columnSelector_breakpoints : [ '20em', '30em', '40em', '50em', '60em', '70em' ],
                        // data attribute containing column priority
                        // duplicates how jQuery mobile uses priorities:
                        // http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/
                        columnSelector_priority : 'data-priority',

                        // class name added to checked checkboxes - this fixes an issue with Chrome not updating FontAwesome
                        // applied icons; use this class name (input.checked) instead of input:checked
                        columnSelector_cssChecked : 'checked',
                        filter_hideFilters:false
                    }
                })

                // initialize the pager plugin
                // ****************************
                .tablesorterPager(pagerOptions);
        $('#popover')
                .popover({
                    placement: 'left',
                    html: true, // required if content has HTML
                    content: $('#popover-target')
                });
    });
    function formReset(){
        var now = new Date();
        var last = new Date(now.getTime()-3*3600*24*1000);
        var day = ("0" + (last.getDate())).slice(-2);
        var day2 = ("0" + (now.getDate())).slice(-2);
        var month = ("0" + (last.getMonth() + 1)).slice(-2);
        var month2 = ("0" + (now.getMonth() + 1)).slice(-2);
        var yesterday = day+'.'+month+'.'+last.getFullYear();
        var today = day2+'.'+month2+'.'+now.getFullYear();

        $('#date_st').val(yesterday);
        $('#date_en').val(today);
        $('#positive').val('');
        $('#status').val('');
    }
    function printSel() {
        if ($('.prn-cbox:checkbox:checked').length<1)
        //alert('Вы не выбрали ни одного направления!');
            selectAll(300);
        else deselectAll(300);
    }

    function printAll(){
        if ($('.prn-cbox:checkbox:checked').length<1)
            alert('Вы не выбрали ни одного направления!');
        else {
            var i = "";
            $(".prn-cbox").each(function () {
                if (this.checked) i += this.id + ",";
            });
            window.open("print/" + i.substr(0, i.length - 1) + "?action=massPrint&logo=1");
        }
    }
    function selectAll(_max) {
        var i=0;
        $(".prn-cbox").each(function() {
            if(i>=_max) return;
            this.checked = true;
            i++;
        });
    }
    function deselectAll(_max) {
        var i=0;
        $(".prn-cbox").each(function() {
            if(i>=_max) return;
            this.checked = false;
            i++;
        });
    }
</script>
