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

    // Handle whether or not the edit button should be disabled
    $('.milypos-table').on('check.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.milypos-table').on('check-all.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.milypos-table').on('uncheck.bs.table', function () {
        if ($('.milypos-table').bootstrapTable('getSelections').length == 0) {
            $('#bulkEdit').attr('disabled', 'disabled');
        }
    });

    $('.milypos-table').on('uncheck-all.bs.table', function (e, row) {
        $('#bulkEdit').attr('disabled', 'disabled');
    });

    // This only works for model index pages because it uses the row's model ID
    function genericRowLinkFormatter(destination) {
        return function (value, row) {
            if(value) {
                return '<a href="{{ url('/') }}/'+destination+'/' + row.id +'">'+value+'</a>';
            }
        };
    }

    // Make the edit delete button
    function genericActionsFormatter(destination) {
        return function (value, row) {

            var actions = '<span style="white-space: nowrap;">';

            if((row.available_actions) && (row.available_actions.view === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '" '
                    + 'class="btn btn-sm btn-primary" data-tooltip="true" '
                    + 'title="{{ __('general.view') }}">'
                    +'<i class="fa fa-eye"></i></a>&nbsp';
            }

            if((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/clone" '
                                + 'class="btn btn-sm btn-info" data-tooltip="true" '
                                + 'title="{{ __('general.clone') }}">'
                                +'<i class="fa fa-copy"></i></a>&nbsp';
            }

            if((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/edit" '
                    + 'class="btn btn-sm btn-warning" data-tooltip="true" '
                    + 'title="{{ __('general.edit') }}">'
                    +'<i class="fa fa-pencil"></i></a>&nbsp';
            }


            if((row.available_actions) && (row.available_actions.delete === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '" '
                    + ' class="btn btn-danger btn-sm delete-asset"  data-tooltip="true"  '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fa fa-trash"></i></a>&nbsp;';
            } else {
                actions += '<a href="#" class="btn btn-sm btn-danger disabled" onClick="return false;">'
                    +'<i class="fa fa-trash"></i></a>&nbsp';
            }

            if((row.available_actions) && (row.available_actions.restore === true)) {
                actions += '<a href="{{ url('/') }}/'
                                + destination + '/' +row.id + '/restore" '
                                + 'class="btn btn-sm btn-warning" '
                                + 'data-tooltip="true" title="{{ __('general.restore') }}">'
                                + '<i class="fa fa-retweet"></i></a>&nbsp';
            }
            actions += '</span>';
            return actions;
        };

    }

    // This handles the icons and display of polymorphic entries
    function polymorphicItemFormatter(value) {
        var item_destination = '';
        var item_icon = '';

        if((value) && (value.type)) {
            if(value.type == 'user') {
                item_destination = 'users';
                item_icon = 'fa-user';
            }

            return '<span style="white-space: nowrap;">'
                + '<a href="{{ url('/') }}/'+ item_destination + '/' + value.id +'" '
                + 'data-tooltip="true" title="title">'
                + '<i class="fa fa-users text-blue"></i>' + value.name + '</a>'
                +'</span>';
        } else {
            return '';
        }
    }

    // this just prints out the items type in activity report
    function itemTypeFormatter(value, row) {
        if((row) && (row.item) && (row.item.type)) {
            return row.item.type;
        }
    }

    // Convert line break to <br>
    function notesFormatter(value) {
        if(value) {
            return value.replace(/(?:\r\n|\r|\n)/g, '<br />');;
        }
    }

    var formatters = [
        'users',
        'categories'
    ];

    for (var i in formatters) {
        window[formatters[i] + 'LinkFormatter'] = genericRowLinkFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatter'] = genericActionsFormatter(formatters[i]);
    }


    function createdAtFormatter(value) {
        if((value) && (value.date)) {
            return value.date;
        }
    }

    // Create a linked phone number in the table list
    function phoneFormatter(value) {
        if(value) {
            return '<a href="tel:' + value + '">' + value + '</a>';
        }
    }

    function trueFalseFormatter(value) {
        if((value) && ((value == 'true') || (value == 1))) {
            return '<i class="fa fa-check text-success"></i>';
        } else {
            return '<i class="fa fa-times text-danger"></i>';
        }
    }

    function dateDisplayFormatter(value) {
        if(value) {
            return  value.formatted;
        }
    }

    function iconFormatter(value) {
        if(value) {
            return '<i class="' + value +' icon-med"></i>';
        }
    }

    function emailFormatter(value) {
        if(value) {
            return '<a href="mailto:' + value + '">' + value + '</a>'
        }
    }

    function websiteLinkFormatter(value) {
        if(value) {
            if(!value.match(/^http([s]?):\/\/.*/)) {
                return '<a href="https://' + value + '" target="_blank">' + value + '</a>';
            } else {
                return '<a href="' + value + '" target="_blank">' + value + '</a>';
            }
        }

    }

    function imageFormatter(value) {
        if (value) {
            return '<a href="' + value + '" data-toggle="lightbox" data-type="image"><img src="' + value + '" style="max-height: {{ $milyPosSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>';
        }
    }

    function sexFormatter(value) {
        if(value) {
            return value;
        }
    }

    $(function () {
        $('#bulkEdit').on('click', function () {
            var selectedIds = $('.milypos-table').bootstrapTable('getSelections');
            $.each(selectedIds, function (key, value) {
                $('#bulkForm').append($('<input type="hidden" name="ids[' + value.id +']" value="' + value.id + '">'));
            });
        });
    });


    // This is necessary to make the bootstrap tooltip work inside the
    // wenzhixin/bootstrap-table formatters
    $(function () {
        $('.milypos-table').on('post-body.bs.table', function () {
            $('[data-tooltip="true"]').tooltip({
                container: 'body'
            });
        });
    });

</script>