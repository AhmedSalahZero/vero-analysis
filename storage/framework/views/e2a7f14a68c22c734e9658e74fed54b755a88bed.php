<?php
use App\Helpers\HArr;
use App\Helpers\HMath;
use MathPHP\Statistics\Correlation ;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('dash_nav'); ?>
<style>
    .max-column-th-class {
        width: 30% !important;
        min-width: 30% !important;
        max-width: 30% !important;
    }

    .three-dots-parent {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .b-bottom {
        border-bottom: 1px solid green !important;
    }

    .expandable-amount-input {
        max-width: 90px !important;
        min-width: 90px !important;
        width: 90px !important;
    }

    table:not(.table-condensed) thead th,
    table:not(.table-condensed) tbody td {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    input {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    .chartdiv_two_lines {
        width: 100%;
        height: 500px;
    }

    .chartDiv {
        max-height: 500px !important;
    }

    .margin__left {
        border-left: 2px solid #366cf3;
    }

    .sky-border {
        border-bottom: 1.5px solid #CCE2FD !important;
    }

    .kt-widget24__title {
        color: black !important;
    }

</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

    /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="kt-portlet">


</div>

<div class="tab-content  kt-margin-t-20">
    <?php
    $index = 0 ;
    ?>


    <div class="tab-pane  active " id="kt_apps_contacts_view_tab_main" role="tabpanel">











        <div class="kt-portlet">

            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">



                    



</div>
</div>
</div>



<div class="row">



    <div class="col-md-12">
        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__body pt-0">


                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Income Statement Summary')); ?> <?php echo e(__('Fig In Million')); ?> </h3>
                            </div>
                            <div class="col-md-8 mb-3">
                                <?php
                                $currentModalId = 'spread-rate-sensitivity';
                                $currentModalTitle = __('Spread Rate Sensitivity');
                                $spreadRates = [];
                                ?>
                                <button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>"><?php echo e($currentModalTitle); ?></button>
								<?php if($withSensitivity): ?>
                                <a href="<?php echo e(route('view.results.dashboard',['company'=>$company,'study'=>$study->id])); ?>" class="btn btn-sm btn-brand btn-elevate btn-pill text-white" ><?php echo e(__('Reset Sensitivity')); ?></a>
								<?php endif; ?> 
                                
                                <?php echo $__env->make('non_banking_services.dashboard._spread-rate-sensitivity-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
		

                            <?php echo $__env->make('non_banking_services.dashboard._income-statement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php if($withSensitivity): ?>
							
                            <?php echo $__env->make('non_banking_services.dashboard._income-statement',['formattedResult'=>$sensitivityFormattedResult], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php endif; ?> 
							




                            <?php echo $__env->make('non_banking_services.dashboard._income-statement-percentage-of',['formattedResult'=>$formattedResult], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php if($withSensitivity): ?>
                            <?php echo $__env->make('non_banking_services.dashboard._income-statement-percentage-of',['formattedResult'=>$sensitivityFormattedResult], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endif; ?> 






                        </div>

                    </div>


                </div>
            </div>
        </div>


    </div>
	<?php if(!$withSensitivity): ?>
    <div class="col-md-6 max-card-height">
        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__body pt-0">


                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">

				
                        <div class="row">


                            <div class="col-md-12 ">

                                <div class="row mb-3 ml-4 b-bottom">
                                    <div class="col-6">
                                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Choose Revenue Stream')); ?> </h3>
                                    </div>
                                    <div class="col-md-6 ">
                                        <select js-refresh-three-line-chart class="form-control">
                                            <?php $__currentLoopData = $lineChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $arr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"> <?php echo e($titlesMapping[$id]); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>



                                </div>
                                <div class="chartdiv_two_lines" id="three-line-chart-id-chart"></div>
                                <?php $__currentLoopData = $lineChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $currentChartData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" class="three-line-chart-data-class" data-chart-name="<?php echo e($chartName); ?>" data-chart-data="<?php echo e(json_encode($currentChartData)); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 max-card-height">
        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__body pt-0">


                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                        <div class="row">






                            <div class="col-md-12 ">

                                <div class="row mb-3 ml-4 b-bottom">
                                    <div class="col-6">
                                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Revenue Stream Breakdown')); ?> </h3>
                                    </div>




                                </div>
                                <div id="bar-chart-id" class="chartdashboard"></div>
                                
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
	<?php endif; ?>	

    <div class="col-md-12">
        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__body pt-0">


                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Cost And Expense Summary')); ?> </h3>
                            </div>

                       <?php echo $__env->make('non_banking_services.dashboard._expenses',['formattedExpenses'=>$formattedExpenses], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					   <?php if($withSensitivity): ?>
                       <?php echo $__env->make('non_banking_services.dashboard._expenses',['formattedExpenses'=>$sensitivityFormattedExpenses], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					   
					   <?php endif; ?> 

                       <?php echo $__env->make('non_banking_services.dashboard._expenses-percentage-of',['formattedExpenses'=>$formattedExpenses], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					   <?php if($withSensitivity): ?>
                       <?php echo $__env->make('non_banking_services.dashboard._expenses-percentage-of',['formattedExpenses'=>$sensitivityFormattedExpenses], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					   <?php endif; ?> 


                            







                        </div>

                    </div>


                </div>
            </div>
        </div>


    </div>





</div>



<!--end:: Widgets/Stats-->


</div>





</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>








<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("three-line-chart-id-chart", am4charts.XYChart);
        var data = [];
        //
        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = data;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.dateFormats.setKey("year", "yyyy");
        dateAxis.periodChangeDateFormats.setKey("year", "yyyy");
        dateAxis.tooltipDateFormat = "yyyy";
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

        createAxisAndSeries("revenue_value", "<?php echo e(__('Revenues Value ')); ?>", false, "circle");
        createAxisAndSeries("growth_rate", "<?php echo e(__('Growth Rate %')); ?>", true, "triangle");
        //   createAxisAndSeries("revenue_percentage", "<?php echo e(__('Revenue %')); ?>", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()



    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("bar-chart-id");
        root.numberFormatter.set("numberFormat", "#,###.##");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false
            , panY: false
            , wheelX: "panX"
            , wheelY: ""
            , layout: root.verticalLayout
        }));

        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));
        var chartData = <?php echo json_encode($barChart, 15, 512) ?>;

        var data = chartData;





        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {});
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "year"
            , renderer: xRenderer
            , tooltip: am5.Tooltip.new(root, {}),

        }));

        xRenderer.grid.template.setAll({
            location: 1
        })

        xAxis.data.setAll(data);

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: 0
            , renderer: am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            })
        }));


        // Add legend
        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50
            , x: am5.p50
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        function makeSeries(name, fieldName) {
            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: name
                , stacked: true
                , xAxis: xAxis
                , yAxis: yAxis
                , valueYField: fieldName
                , categoryXField: "year"
            }));

            series.columns.template.setAll({
                tooltipText: "{name}, {categoryX}: {valueY}"
                , tooltipY: am5.percent(10)
            });
            series.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear();

            series.bullets.push(function() {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: "{valueY}"
                        , fill: root.interfaceColors.get("alternativeText")
                        , centerY: am5.p50
                        , centerX: am5.p50
                        , populateText: true
                    })
                });
            });

            legend.data.push(series);
        }

        makeSeries("Leasing", "leasing");
        makeSeries("Direct Factoring", "direct-factoring");
        makeSeries("Reverse Factoring", "reverse-factoring");
        makeSeries("Portfolio Mortgage", "portfolio-mortgage");
        makeSeries("Microfinance", "microfinance");


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);

    }); // end am5.ready()


    //three lines chart

</script>

<script>
    $(function() {
        $(document).on('change', 'select[js-refresh-three-line-chart]', function(e) {
            let chartId = $(this).val();
            var chartDataArr = $('.three-line-chart-data-class[data-chart-name="' + chartId + '"]').attr('data-chart-data');
            if (chartDataArr) {
                chartDataArr = JSON.parse(chartDataArr);
            } else {
                chartDataArr = {};
            }
            let currentChartId = 'three-line-chart-id-chart';
            am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = chartDataArr
        })

    })

</script>
<script>
    $(function() {
        $('select[js-refresh-three-line-chart]').trigger('change')
    })

</script>



<!--end::Page Scripts -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/dashboard.blade.php ENDPATH**/ ?>