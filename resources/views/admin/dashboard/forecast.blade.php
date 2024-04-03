@extends('layouts.dashboard')
@section('dash_nav')
<style>
    .chartdiv {
        width: 100%;
        height: 250px;
    }

    .chartdivdonut {
        width: 100%;
        height: 500px;
    }

    .chartdivchart {
        width: 100%;
        height: 500px;
    }

</style>

@endsection
@section('css')
<link href="{{ url('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

</style>
@endsection
@section('content')

{{-- Title --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{ __('Cash Inflow/Outflow Forecast') }}
                </h3>





            </div>

        </div>
        <div class="kt-portlet__body">
            <form action="">
                <div class="row form-group">
                    <div class="col-md-3 mb-4">
                        <label>{{ __('Start Date') }} <span class="multi_selection"></span> </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input required type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label>{{ __('End Date') }} <span class="multi_selection"></span> </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input required type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                            </div>
                        </div>
                    </div>
                    <x-submitting />
                </div>
            </form>

        </div>
    </div>
</div>

{{-- Multi Line Chart --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{ __('Monthly Cash Flow') }}
                </h3>
            </div>
            <div class="kt-portlet__head-label ">
                <div class="kt-align-right">
                    <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-12">
                    <div class="chartdivchart" id="chartdivmulti"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Single Line Chart --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{ __('Monthly Accumulated Cash Flow') }}
                </h3>
            </div>
            <div class="kt-portlet__head-label ">
                <div class="kt-align-right">
                    <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            {{-- Chart --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="chartdivchart" id="chartdivline1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Title --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{ __("Receivables & Payables Aging ") }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- Customers Invoices Aging --}}

@foreach($invoiceTypesModels as $modelType)
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{$modelType. __(' Aging') }}
                </h3>
            </div>
            <div class="kt-portlet__head-label ">
                <div class="kt-align-right">
                    <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            {{-- Chart --}}
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-sm table-striped table-head-bg-brand ">
                        <thead class="thead-inverse">
                            <tr>
                                <th>{{ __('Invoices Aging') }}</th>
                                <th class="text-center">{{ __('Invoices Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0 ;
                            @endphp
                            @foreach ($dashboardResult['invoices_aging'][$modelType]['table'] ?? [] as $dueType => $dueWithValue)
                            @foreach($dueWithValue as $daysInternal => $totalForDaysInterval)
                            <tr>
                                <td>{{ camelizeWithSpace($dueType,'_') }} {{ $daysInternal }} {{ __('Days') }} </td>
                                <td class="text-center">{{ number_format($totalForDaysInterval,0) }}</td>
                            </tr>
                            @php
                            $total += $totalForDaysInterval ;
                            @endphp
                            @endforeach
                            @endforeach

                            <tr>
                                <td>{{ __('Total') }}</td>
                                <td class="text-center">{{ number_format($total,0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <div class="chartdivchart" id="chartdiv3_{{ $modelType }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Customers Cheques Aging --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
					@if($modelType == 'CustomerInvoice')
                    {{ __('Customers Cheques Aging') }}
					@else
                    {{ __('Suppliers Cheques Aging') }}
					@endif 
                </h3>
            </div>
            <div class="kt-portlet__head-label ">
                <div class="kt-align-right">
                    <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    <button type="button" class="btn btn-sm btn-pill color-rose"><i class="fa fa-chart-line"></i> {{ __('Rejected Cheques Report') }} </button>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            {{-- Chart --}}
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-sm table-striped table-head-bg-brand ">
                        <thead class="thead-inverse">
                            <tr>
                                <th>{{ __('Cheques Aging') }}</th>
                                <th class="text-center">{{ __('Cheques Amount') }}</th>

                            </tr>
                        </thead>
                        <tbody>
							@php
								$total = 0 ;
							@endphp
				
                            @foreach ($dashboardResult['cheques_aging'][$modelType]['table'] ?? [] as $dueType => $dueWithValue)
                            @if($dueType == 'coming_due')
                            @foreach($dueWithValue as $daysInternal => $totalForDaysInterval)
                            <tr>
                            <td>{{ camelizeWithSpace($dueType,'_') }} {{ $daysInternal }} {{ __('Days') }} </td>
                                <td class="text-center">{{ number_format($totalForDaysInterval,0) }}</td>
                            </tr>
							 @php
                            $total += $totalForDaysInterval ;
                            @endphp
                            @endforeach
                            @endif
                            @endforeach
                            <tr>
                                <td>{{ __('Total') }}</td>
                                <td class="text-center">{{ number_format($total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <div class="chartdivchart" id="chartdivline2_{{ $modelType }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach














{{-- Title --}}
<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{ __("Long & Short Term Facilities Comming Dues ") }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Short Term Facilities Comming Dues --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Short Term Facilities Comming Dues') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label ">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-head-bg-brand ">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th class="text-center">{{ __('Amount') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date 1</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 2</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 3</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 4</td>
                                            <td class="text-center">600,000</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="chartdivchart" id="chartdivline4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Long Term Facilities Comming Dues --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Long Term Facilities Comming Dues') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label ">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{-- Chart --}}
                <div class="row">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-head-bg-brand ">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th class="text-center">{{ __('Amount') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date 1</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 2</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 3</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 4</td>
                                            <td class="text-center">600,000</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="chartdivchart" id="chartdivline5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Leasing Facilities Comming Dues --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Leasing Facilities Comming Dues') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label ">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{-- Chart --}}
                <div class="row">


                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-head-bg-brand ">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th class="text-center">{{ __('Amount') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date 1</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 2</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 3</td>
                                            <td class="text-center">600,000</td>
                                        </tr>
                                        <tr>
                                            <td>Date 4</td>
                                            <td class="text-center">600,000</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="chartdivchart" id="chartdivline6"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
    var ammount_array = [{
        "date": "2012-07-27"
        , "value": 13
    }, {
        "date": "2012-07-28"
        , "value": 11
    }, {
        "date": "2012-07-29"
        , "value": 15
    }, {
        "date": "2012-07-30"
        , "value": 16
    }, {
        "date": "2012-07-31"
        , "value": 18
    }, {
        "date": "2012-08-01"
        , "value": 13
    }, {
        "date": "2012-08-02"
        , "value": 22
    }, {
        "date": "2012-08-03"
        , "value": 23
    }, {
        "date": "2012-08-04"
        , "value": 20
    }, {
        "date": "2012-08-05"
        , "value": 17
    }, {
        "date": "2012-08-06"
        , "value": 16
    }, {
        "date": "2012-08-07"
        , "value": 18
    }, {
        "date": "2012-08-08"
        , "value": 21
    }, {
        "date": "2012-08-09"
        , "value": 26
    }, {
        "date": "2012-08-10"
        , "value": 24
    }, {
        "date": "2012-08-11"
        , "value": 29
    }, {
        "date": "2012-08-12"
        , "value": 32
    }, {
        "date": "2012-08-13"
        , "value": 18
    }, {
        "date": "2012-08-14"
        , "value": 24
    }, {
        "date": "2012-08-15"
        , "value": 22
    }, {
        "date": "2012-08-16"
        , "value": 18
    }, {
        "date": "2012-08-17"
        , "value": 19
    }, {
        "date": "2012-08-18"
        , "value": 14
    }, {
        "date": "2012-08-19"
        , "value": 15
    }, {
        "date": "2012-08-20"
        , "value": 12
    }, {
        "date": "2012-08-21"
        , "value": 8
    }, {
        "date": "2012-08-22"
        , "value": 9
    }, {
        "date": "2012-08-23"
        , "value": 8
    }, {
        "date": "2012-08-24"
        , "value": 7
    }, {
        "date": "2012-08-25"
        , "value": 5
    }, {
        "date": "2012-08-26"
        , "value": 11
    }];

</script>

@foreach($invoiceTypesModels as $modelType)
<!-- Chart code -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv3_{{ $modelType }}", am4charts.XYChart);

        // Add data

        chartData = @json(($dashboardResult['invoices_aging'][$modelType]['chart'] ?? []));
        chartData = chartData.reverse()
        chart.data = chartData;

        // Create axes
        var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        yAxis.dataFields.category = "state";
        yAxis.renderer.grid.template.location = 0;
        yAxis.renderer.labels.template.fontSize = 10;
        yAxis.renderer.minGridDistance = 10;

        var xAxis = chart.xAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueX = "sales";
        series.dataFields.categoryY = "state";
        series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
        series.columns.template.strokeWidth = 0;
        series.columns.template.adapter.add("fill", function(fill, target) {
            if (target.dataItem) {
                switch (target.dataItem.dataContext.region) {
                    case "Past Due":
                        return "#C70039";
                        break;
                    case "Coming Due":
                        return "#1D9D23";
                        break;
                    case "Current Due":
                        return "#000";
                        break;
                }
            }
            return fill;
        });

        var axisBreaks = {};
        var legendData = [];

        // Add ranges
        function addRange(label, start, end, color) {
            var range = yAxis.axisRanges.create();
            range.category = start;
            range.endCategory = end;
            range.label.text = label;
            range.label.disabled = false;
            range.label.fill = color;
            range.label.location = 0;
            range.label.dx = -100;
            range.label.dy = 5;
            range.label.fontWeight = "bold";
            range.label.fontSize = 12;
            range.label.horizontalCenter = "left"
            range.label.inside = true;

            range.grid.stroke = am4core.color("#396478");
            range.grid.strokeOpacity = 1;
            range.tick.length = 200;
            range.tick.disabled = false;
            range.tick.strokeOpacity = 1;
            range.tick.stroke = am4core.color("#396478");
            range.tick.location = 0;

            range.locations.category = 1;
            var axisBreak = yAxis.axisBreaks.create();
            axisBreak.startCategory = start;
            axisBreak.endCategory = end;
            axisBreak.breakSize = 1;
            axisBreak.fillShape.disabled = true;
            axisBreak.startLine.disabled = true;
            axisBreak.endLine.disabled = true;
            axisBreaks[label] = axisBreak;

            legendData.push({
                name: label
                , fill: color
            });
        }
        let groups = [];
        for (i = 0; i < chartData.length; i++) {
            var currentCategory = chartData[i].region;
            var currentState = chartData[i].state;

            var currentCategoryExist = groups.find(element => {
                if (element.name == currentCategory) {
                    return true;
                }
            })


            if (currentCategoryExist) {
                var index = groups.findIndex(obj => obj.name == currentCategory)
                groups[index].last_due = currentState
            } else {
                if (currentCategory == 'Coming Due') {
                    currentState = '46-60 Days';
                }
                if (currentCategory == 'Past Due') {

                    currentState = '-1-7 Days';
                }
                groups.push({
                    name: currentCategory
                    , first_due: currentState
                    , last_due: currentState
                })
            }
        }
        for (var i = 0; i < groups.length; i++) {
            var color = '#000';
            if (i == 1) {
                color = '#1D9D23';
            }
            if (i == 2) {
                color = '#C70039'
            }

            addRange(groups[i].name, groups[i].first_due, groups[i].last_due, color);

        }
        chart.cursor = new am4charts.XYCursor();
        var legend = new am4charts.Legend();
        legend.position = "bottom";
        legend.scrollable = true;
        legend.valign = "top";
        legend.reverseOrder = true;

        chart.legend = legend;
        legend.data = legendData;

        legend.itemContainers.template.events.on("toggled", function(event) {
            var name = event.target.dataItem.dataContext.name;
            var axisBreak = axisBreaks[name];
            if (event.target.isActive) {
                axisBreak.animate({
                    property: "breakSize"
                    , to: 0
                }, 1000, am4core.ease.cubicOut);
                yAxis.dataItems.each(function(dataItem) {
                    if (dataItem.dataContext.region == name) {
                        dataItem.hide(1000, 500);
                    }
                })
                series.dataItems.each(function(dataItem) {
                    if (dataItem.dataContext.region == name) {
                        dataItem.hide(1000, 0, 0, ["valueX"]);
                    }
                })
            } else {
                axisBreak.animate({
                    property: "breakSize"
                    , to: 1
                }, 1000, am4core.ease.cubicOut);
                yAxis.dataItems.each(function(dataItem) {
                    if (dataItem.dataContext.region == name) {
                        dataItem.show(1000);
                    }
                })

                series.dataItems.each(function(dataItem) {
                    if (dataItem.dataContext.region == name) {
                        dataItem.show(1000, 0, ["valueX"]);
                    }
                })
            }
        })

    }); // end am4core.ready()

</script>
<!-- Chart code -->

<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline2_{{ $modelType }}", am4charts.XYChart);

        // Add data
        
		   var chartData = @json(($dashboardResult['cheques_aging'][$modelType]['chart'] ?? []));
            chart.data = chartData;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>

<!-- Single Chart code 1 -->


@endforeach
<!-- Single Chart code 2  -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline1", am4charts.XYChart);
     
        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline4", am4charts.XYChart);

        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>
<!-- Single Chart code 5  -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline5", am4charts.XYChart);

        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>
<!-- Single Chart code 6  -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline6", am4charts.XYChart);

        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>






<!-- Multi Chart code -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivmulti", am4charts.XYChart);

        //

        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = generateChartData();

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        // Create series
        function createAxisAndSeries(field, name, opposite, bullet) {
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            if (chart.yAxes.indexOf(valueAxis) != 0) {
                valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            }

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            series.dataFields.dateX = "date";
            series.strokeWidth = 2;
            series.yAxis = valueAxis;
            series.name = name;
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            series.tensionX = 0.8;
            series.showOnInit = true;

            var interfaceColors = new am4core.InterfaceColorSet();

            switch (bullet) {
                case "triangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 12;
                    bullet.height = 12;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var triangle = bullet.createChild(am4core.Triangle);
                    triangle.stroke = interfaceColors.getFor("background");
                    triangle.strokeWidth = 2;
                    triangle.direction = "top";
                    triangle.width = 12;
                    triangle.height = 12;
                    break;
                case "rectangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 10;
                    bullet.height = 10;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var rectangle = bullet.createChild(am4core.Rectangle);
                    rectangle.stroke = interfaceColors.getFor("background");
                    rectangle.strokeWidth = 2;
                    rectangle.width = 10;
                    rectangle.height = 10;
                    break;
                default:
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.stroke = interfaceColors.getFor("background");
                    bullet.circle.strokeWidth = 2;
                    break;
            }

            valueAxis.renderer.line.strokeOpacity = 1;
            valueAxis.renderer.line.strokeWidth = 2;
            valueAxis.renderer.line.stroke = series.stroke;
            valueAxis.renderer.labels.template.fill = series.stroke;
            valueAxis.renderer.opposite = opposite;
        }

        createAxisAndSeries("visits", "Cash Inflow", false, "circle");
        createAxisAndSeries("views", "Cash Outflow", true, "circle");
        // createAxisAndSeries("hits", "Hits", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();

        // generate some random data, quite different range
        function generateChartData() {
            var chartData = [];
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 100);
            firstDate.setHours(0, 0, 0, 0);

            var visits = 1600;
            var hits = 2900;
            var views = 8700;

            for (var i = 0; i < 15; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                hits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                views += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                chartData.push({
                    date: newDate
                    , visits: visits
                    , hits: hits
                    , views: views
                });
            }
            return chartData;
        }

    }); // end am4core.ready()

</script>




@endsection
