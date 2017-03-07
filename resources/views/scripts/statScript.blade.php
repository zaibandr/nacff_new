<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.js')}}"></script>
<script src="{{secure_asset('resources/assets/scripts/jquery.tablesorter.widgets.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.js')}}"></script>
<script src="{{secure_asset('public/js/bootstrap-datepicker.ru.min.js')}}"></script>
<script>
    $(function(){
        $('.input-daterange').datepicker({
            format: "dd.mm.yyyy",
            clearBtn: true,
            autoclose: true,
            language: 'ru'
        });
        $('.tablesorter').tablesorter({
            // Add a theme - try 'blackice', 'blue', 'dark', 'default'
            theme: 'dropbox',
            showProcessing: true,
            headerTemplate : '{content} {icon}',
            // fix the column widths
            widthFixed: false,

            // include zebra and any other widgets, options:
            // 'columns', 'filter', 'stickyHeaders' & 'resizable'
            // 'uitheme' is another widget, but requires loading
            // a different skin and a jQuery UI theme.
            widgets: [ 'zebra', 'filter'],
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

                saveSort: true
            }
        });
        var filters = [],
                $t = $(this),
                col = $t.data('filter-column'), // zero-based index
                txt = $t.data('filter-text') || $t.text(); // text to add to filter

        filters[col] = txt;
        // using "table.hasFilters" here to make sure we aren't targetting a sticky header
        $.tablesorter.setFilters( $('.tablesorter'), filters, true ); // new v2.9

    });
</script>