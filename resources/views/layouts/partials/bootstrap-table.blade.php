<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('js/extensions/export/jquery.base64.js') }}"></script>
<script src="{{ asset('js/FileSaver.min.js') }}"></script>
<script src="{{ asset('js/xlsx.core.min.js') }}"></script>
<script src="{{ asset('js/jspdf.min.js') }}"></script>
<script src="{{ asset('js/jspdf.plugin.autotable.js') }}"></script>
<script src="{{ asset('js/extensions/export/tableExport.min.js') }}"></script>


@if (!isset($simple_view))
    <script src="{{ asset('js/extensions/toolbar/bootstrap-table-toolbar.js') }}"></script>
    <script src="{{ asset('js/extensions/sticky-header/bootstrap-table-sticky-header.js') }}"></script>
@endif

<script src="{{ asset('js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>

<script>
    $(function () {
        var stickyHeaderOffsetY = 0;

        if($('.navbar-fixed-top').css('height')) {
            stickyHeaderOffsetY += $('.navbar-fixed-top').css('height').replace('px','');
        }

        if($('.navbar-fixed-top').css('margin-bottom')) {
            stickyHeaderOffsetY += +$('.navbar-fixed-top').css('margin-bottom').replace('px','');
        }

        $('.milypos-table').bootstrapTable('destroy').bootstrapTable({
            classes: 'table table-responsive table-no-bordered',
            ajaxOptions: {
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            },
            stickyHeader: true,
            stickyHeaderOffsetY : stickyHeaderOffsetY + 'px',

            undefinedText: '',
            iconsPrefix: 'fa',
            cookie: true,
            cookieExpire: '2y',
            cookieIdTable: '{{ Route::currentRouteName() }}',
            mobileResponsive: true,
            maintainSelected: true,
            trimOnSearch: true,
            paginationFirstText: "{{ __('general.first') }}",
            paginationLastText: "{{ __('general.last') }}",
            paginationPreText: "{{ __('general.previous') }}",
            paginationNextText: "{{ __('general.next') }}",
            pageList: ['10', '20', '30', '40', '50', '100', '150', '200', '500'],
            pageSize: {{ (($milyPosSettings->per_page != '') && ($milyPosSettings->per_page > 0)) ? $milyPosSettings->per_page : 20 }},
            paginationVAlign: 'both',
            formatLoadingMessage: function () {
                return '<h4><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading... Please wait...</h4>'
            },
            icons: {
                advancedSearchIcon: 'fa fa-search-plus',
                paginationSwitchDown: 'fa-caret-square-o-down',
                paginationSwitchUp: 'fa-caret-square-o-up',
                columns: 'fa-columns',
                refresh: 'fa-refresh'
            },
            exportTypes: ['csv', 'excel', 'doc', 'txt', 'json', 'xml', 'pdf'],
        });
    });
</script>