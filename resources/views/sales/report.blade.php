@extends('layouts.default')
@section('title')
    {{ __('general.sales_report') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.sales_report') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <button type="button" class="btn btn-default daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Date range picker
                    </span>
                <i class="fa fa-caret-down"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-solid bg-teal-gradient">
                        <div class="box-header">

                            <i class="fa fa-th"></i>

                            <h3 class="box-title">Sales Graph</h3>

                        </div>

                        <div class="box-body border-radius-none sales-graph">

                            <div class="chart" id="sales-line-chart" style="height: 250px;"></div>

                        </div>
                    </div><!-- box box-solid bg-teal-gradien -->
                </div><!-- col-xs-12 -->
            </div><!-- .row -->
        </div><!-- box-body -->

        <div class="box-footer">
            wow
        </div>
    </div><!-- .box -->
@endsection

@section('page_scripts')
    <script>
        $(document).ready(function () {

            if (localStorage.getItem('captureRange') != null) {
                $('.daterange-btn span').html(localStorage.getItem('captureRange'));
            } else {
                $(".daterange-btn span").html('<i class="fa fa-calendar"></i> Date Range')
            }

            /*==================================
             DATE RANGE
             ==================================*/

            $('.daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment(),
                    endDate: moment()
                },
                function (start, end) {
                    $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    var startDate = start.format('YYYY-MM-DD');
                    var endDate = end.format('YYYY-MM-DD');
                    var dateRange = $(".daterange-btn span").html();

                    localStorage.setItem("captureRange", dateRange);

                    window.location = "{{ route('sales.report') }}?startdate=" + startDate + "&enddate=" + endDate;
                }
            );

            /*=============================
            CLEAR DATE RANGE
            ==============================*/
            $('.daterangepicker.opensright .range_inputs .cancelBtn').on('click', function () {
                localStorage.removeItem('captureRange');
                localStorage.clear();
                window.location = "{{ route('sales.report') }}";
            });

            /*===================================
            CAPTURE TODAY
            ====================================*/
            $('.daterangepicker.opensright .ranges li').on('click', function () {
                var textTody = $(this).attr("data-range-key");

                if (textTody === 'Today') {
                    var d = new Date();
                    var day = d.getDate();
                    var month = d.getMonth() + 1;
                    var year = d.getFullYear();

                    if (month < 10) {
                        var startDate = year + "-0" + month + "-" + day;
                        var endDate = year + "-0" + month + "-" + day;
                    } else if (day < 10) {
                        var startDate = year + "-" + month + "-0" + day;
                        var endDate = year + "-" + month + "-0" + day;
                    } else if (month < 10 && day < 10) {
                        var startDate = year + "-0" + month + "-0" + day;
                        var endDate = year + "-0" + month + "-0" + day;
                    } else {
                        var startDate = year + "-" + month + "-" + day;
                        var endDate = year + "-" + month + "-" + day;
                    }

                    localStorage.setItem('captureRange', 'Today');
                    window.location = "{{ route('sales.report') }}?startdate=" + startDate + "&enddate=" + endDate;
                }
            });


            var line = new Morris.Line({
                element: 'sales-line-chart',
                resize: true,
                data: [
                    @if($uniqueDates != null)
                        @forEach($uniqueDates as $key)
                            {y: '{{ $key }}', sales: "{{ $sumMonthlyPayments[$key] }}"},
                        @endforeach
                            {y: '{{ $key }}', sales: "{{ $sumMonthlyPayments[$key] }}" }
                    @else
                        { y: '0', sales: '0'}
                    @endif
                ],
                xkey: 'y',
                ykeys: ['sales'],
                labels: ['Sales'],
                lineColors: ['#efefef'],
                lineWidth: 2,
                hideHover: 'auto',
                gridTextColor: '#fff',
                gridStrokeWidth: 0.4,
                pointSize: 4,
                pointStrokeColors: ['#efefef'],
                gridLineColor: '#efefef',
                gridTextFamily: 'Open Sans',
                preUnits: '$',
                gridTextSize: 10
            });
        });
    </script>
@endsection