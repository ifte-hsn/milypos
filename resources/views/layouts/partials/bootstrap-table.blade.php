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
        $('.milypos-table').bootstrapTable();
    })
</script>