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

                <div class="col-md-6 col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Most selling products</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" height="150"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        @for($i=0; $i<10; $i++)
                                            <li><i class="fa fa-circle-o text-{{ $colors[$i] }}"></i> {{ $topSoldProducts[$i]->name }}</li>
                                        @endfor
                                    </ul>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                @for($i = 0; $i <5; $i++)
                                    <li><a href="#">

                                            @if($topSoldProducts[$i]->image)
                                                <img src="{{ asset('/uploads/products/'.$topSoldProducts[$i]->image) }}" alt="{{ $topSoldProducts[$i]->name }}" class="img-thumbnail" width="60px" style="margin-right:10px">
                                            @else
                                                <img src="{{ asset('/images/products_placeholder.png') }}" alt="{{ $topSoldProducts[$i]->name }}" class="img-thumbnail" width="60px" style="margin-right:10px">
                                            @endif
                                            {{ $topSoldProducts[$i]->name }}
                                            <span class="pull-right text-{{ $colors[$i] }}">{{ ceil($topSoldProducts[$i]->sales*100/$totalSale) }}</span></a></li>
                                @endfor
                            </ul>
                        </div>
                        <!-- /.footer -->
                    </div>
                    <!-- /.box -->
                </div> <!-- col-md-6 col-xs-12 -->
            </div><!-- .row -->
        </div><!-- box-body -->

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
                    {
                        y: '{{ $key }}', sales: "{{ $sumMonthlyPayments[$key] }}"
                    },
                        @endforeach
                    {
                        y: '{{ $key }}', sales: "{{ $sumMonthlyPayments[$key] }}"
                    }
                        @else
                    {
                        y: '0', sales: '0'
                    }
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

        // -------------
        // - PIE CHART -
        // -------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: 700,
                color: '#f56954',
                highlight: '#f56954',
                label: 'Chrome'
            },
            {
                value: 500,
                color: '#00a65a',
                highlight: '#00a65a',
                label: 'IE'
            },
            {
                value: 400,
                color: '#f39c12',
                highlight: '#f39c12',
                label: 'FireFox'
            },
            {
                value: 600,
                color: '#00c0ef',
                highlight: '#00c0ef',
                label: 'Safari'
            },
            {
                value: 300,
                color: '#3c8dbc',
                highlight: '#3c8dbc',
                label: 'Opera'
            },
            {
                value: 100,
                color: '#d2d6de',
                highlight: '#d2d6de',
                label: 'Navigator'
            }
        ];
        var pieOptions = {
            // Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            // String - The colour of each segment stroke
            segmentStrokeColor: '#fff',
            // Number - The width of each segment stroke
            segmentStrokeWidth: 1,
            // Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            // Number - Amount of animation steps
            animationSteps: 100,
            // String - Animation easing effect
            animationEasing: 'easeOutBounce',
            // Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            // Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            // Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            // String - A legend template
            legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%> users'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------

    </script>
@endsection