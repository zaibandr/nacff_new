<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.widgets.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.pager.min.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.ru.min.js')}}"></script>
<script>
    $(function() {
        $('.input-daterange').datepicker({
            format: "dd.mm.yyyy",
            clearBtn: true,
            autoclose: true,
            language: 'ru'
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
                    widgets: ['zebra', 'filter'],
                    widgetOptions: {
                        filter_hideFilters:true
                    }
                })

                // initialize the pager plugin
                // ****************************
                .tablesorterPager(pagerOptions);
    });
    </script>