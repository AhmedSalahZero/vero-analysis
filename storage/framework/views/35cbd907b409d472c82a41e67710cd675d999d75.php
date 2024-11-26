<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs',['active'=>'breadkdown_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
.btn-to-l{
	width: 100%;
    display: flex;
    justify-content: end;
    gap: 10px;
}
.break-down-bg-success{
		background-color:green !important;
	}
	.break-down-bg-brand{
		background-color:blue !important;
	}
	.break-down-bg-danger{
		background-color:red !important;
	}
	.break-down-color-success{
		color:green !important;
	}
	.break-down-color-brand{
		color:blue !important;
	}
	.break-down-color-danger{
		color:red !important;
	}
	
    .max-w-300 {
        max-width: 300px !important;
        width: 300px !important;
        min-width: 300px !important;
        white-space: normal !important;
    }

    table {
        white-space: nowrap;
    }

    /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

</style>

<style>
    .swal-wide {
        width: 850px;
    }

    .custom_width_classs {
        width: 600px;
    }

    .close_custom_modal {
        position: absolute;
        top: 5px;
        right: 47px;
        color: #c8c3c6;
        font-size: 1.5rem;
    }

    .datatable_modal_div {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: fixed;
        overflow-y: scroll;
        overflow-x: hidden;
        max-height: 80vh;
        width: 90%;
        z-index: 9;
        padding: 3rem 2rem;

    }

    .container__fixed {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: none;
        overflow: scroll;

    }

    .header___bg {
        background-color: #086691 !important;
        color: #fff !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php
$exportableFields = (new \App\Http\Controllers\ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');
$exportableFieldsValues = array_keys($exportableFields);
if(in_array('document_type' , $exportableFieldsValues) && in_array('document_number' , $exportableFieldsValues) )
{
$exportableFieldsValues[] = 'invoice_count';
$exportableFieldsValues[] = 'product_item_avg_count';
$exportableFieldsValues[] = 'avg_invoice_value';
}
?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title head-title text-primary font-1-5">
                <?php echo e(__('Dashboard Results')); ?>

            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo e(route('dashboard.breakdown',$company)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group row">
                <div class="col-md-5">
                    <label><?php echo e(__('Start Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date" required value="<?php echo e($start_date); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <label><?php echo e(__('End Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date" required value="<?php echo e($end_date); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label> </label>
                    <div class="kt-input-icon">
                        <button type="submit" class="btn active-style"><?php echo e(__('Submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">

    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary font-1-5">

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-xl">
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                <div class="col-md-4">
                    <!--begin::Total Profit-->
                    <div class="kt-widget24 text-center">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info w-100">
                                <h4 class="kt-widget24__title font-size justify-content-between">

                                    <span class="text-nowrap"><?php echo e(__('Top') . ' ' .  __(ucwords(str_replace('_',' ',$type)))); ?></span>
                                    <p class="btn-to-l">

                                         <button type="button" class="btn btn-small text-white break-down-bg-<?php echo e($color); ?>" data-toggle="modal" data-target="#modal_for_<?php echo e(convertStringToClass($type)); ?>">
                                            <?php echo e(__('Take Away')); ?>

                                        </button>
										<button type="button" class="btn btn-small text-white break-down-bg-<?php echo e($color); ?>" data-toggle="modal" data-target="#forecast-<?php echo e(convertStringToClass($type)); ?>">
                                            <?php echo e(__('Forecast')); ?>

                                        </button>
										
										<?php echo $__env->make('client_view.home_dashboard._forecast-modal',[], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




                                        
                                    </p>
                                </h4>
                            </div>
                        </div>


                        <div class="modal fade bd-example-modal-lg modal__class_top_bottom" id="modal_for_<?php echo e(convertStringToClass($type)); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-left" id="exampleModalLabel " style="line-height: 2"><?php echo e(ucwords(str_replace('_',' ',$type)) . ' - ' . __('Take Aways')); ?> <br>
                                            <?php echo e(__('From:') . ' ' .  \Carbon\Carbon::make($start_date)->format('d-M-Y')  .' ' . __('To:') . ' ' . \Carbon\Carbon::make($end_date)->format('d-M-Y')); ?>


                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $businessSectors = getTypeFor($type,$company->id,false);
                                        ?>
                                        <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
                                        <input type="hidden" name="type" value="<?php echo e($type); ?>">
                                        <label class="text-left font-weight-bold  w-100 mb-3 text-black"><?php echo e(__('Please Select')); ?> <?php echo e(ucwords(str_replace('_',' ',$type))); ?></label>
                                        <select id="business_sector_select_<?php echo e(convertStringToClass($type)); ?>" data-live-search="true" data-actions-box="true" name="selected_type" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select">
                                            <?php $__currentLoopData = $businessSectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businesSector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($businesSector); ?>"> <?php echo e(__($businesSector)); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <table class="table table-bordered mt-5 datatable" id="" style="table-layout: fixed">
                                            <tr class="text-white" style="background-color:#086691">
                                                <th> <?php echo e(__('Item')); ?> </th>
                                                <th> <?php echo e(__('Value')); ?> </th>
                                            </tr>






                                            <tr>
                                                <td class="text-left"><?php echo e(__(ucwords(str_replace('_',' ',$type))) . ' ' . __('Name')); ?> </td>
                                                <td id="selected_type_name"><?php echo e(__('Value')); ?></td>
                                            </tr>


                                            <tr>
                                                <td class="text-left"><?php echo e(__('Sales Value')); ?> </td>
                                                <td id="total_sales_value"><?php echo e(__('Value')); ?></td>
                                            </tr>

                                            <?php $__currentLoopData = getFieldsForTakeawayForType($type); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(in_array($id , $exportableFieldsValues)): ?>
                                            <tr>
                                                <td class="text-left"><?php echo e(__($item)); ?>

                                                    <?php if(hasTopAndBottom($id)): ?>

                                                    <div class="" style="float:right;">
                                                        <button style="background-color:#086691 ; color:#fff" class="btn  btn-sm ml-5 mr-1 ranged-button-ajax" data-direction="top" data-type="<?php echo e($type); ?>" data-column="<?php echo e($id); ?>"><?php echo e(__('Top 50')); ?></button>
                                                        <button style="background-color:#086691 ; color:#fff" class="btn  btn-sm text-white ranged-button-ajax" data-direction="bottom" data-type="<?php echo e($type); ?>" data-column="<?php echo e($id); ?>"><?php echo e(__('Bottom 50')); ?></button>
                                                    </div>
                                                    <?php endif; ?>
                                               


                                                </td>
                                                <td id="<?php echo e($id); ?>">-</td>
                                            </tr>
                                            <?php endif; ?>




                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </table>
                                        <div class="row ">
                                           
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                
                            </div>
                        </div>
                    </div>
                </div>




                <div class="kt-widget24__details">
                    <span class="kt-widget24__stats break-down-color-<?php echo e($color); ?>" style="font-size:1.4rem">
                        <?php echo e(__( '[ ' .($top_data[$type]['item'] ?? ' - ')) .' ]  ' .number_format(($top_data[$type]['Sales Value']??0))); ?>

                </div>
                <input type="hidden" id="top_for_<?php echo e($type); ?>" value="<?php echo e($top_data[$type]['item'] ?? ''); ?>">
                <input type="hidden" id="value_for_<?php echo e($type); ?>" value="<?php echo e(number_format(($top_data[$type]['Sales Value']??0))); ?>">
               <div class="progress progress--sm">
                    <div class="progress-bar break-down-bg-<?php echo e($color); ?>" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="kt-widget24__action">
                    <span class="kt-widget24__change">

                    </span>
                    <span class="kt-widget24__number">

                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
</div>

<?php $__currentLoopData = $reports_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $report_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-sm-12 col-lg-6">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary font-1-5">
                    <?php echo e(__(ucwords(str_replace('_',' ',$type)).' Breakdown Analysis')); ?>

                </h3>
            </div>
        </div>
    </div>

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1_<?php echo e($type); ?>" role="tab">
                            <i class="flaticon-line-graph"></i> &nbsp; Charts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_2_<?php echo e($type); ?>" role="tab">
                            <i class="flaticon2-checking"></i>Reports Table
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content  kt-margin-t-20">

                <div class="tab-pane active" id="kt_apps_contacts_view_tab_1_<?php echo e($type); ?>" role="tabpanel">

                    
                    <div class="col-xl-12">
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__body kt-portlet__body--fluid">
                                <div class="kt-widget12">
                                    <div class="kt-widget12__chart">
                                        <!-- HTML -->
                                        <h4> <?php echo e(__('Sales Values')); ?> </h4>
                                        <div id="chartdiv_<?php echo e($type); ?>" class="chartDiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="kt_apps_contacts_view_tab_2_<?php echo e($type); ?>" role="tabpanel">
                    <div class="col-md-12">
                        <div class="kt-portlet kt-portlet--mobile">
                            
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <?php
                                                if ($type == 'service_provider_birth_year' || $type == 'service_provider_type') {
                                                    $report_count_data = $report_data['report_count_data'];
                                                    $total_count = ( count($report_count_data) > 0) ? array_sum(array_column($report_count_data,'Count')) : 0;
                                                    $report_data = $report_data['report_view_data']  ;

                                                }
                                                $total = array_sum(array_column(($report_data??[]),'Sales Value'));$key=0;
                                            ?>

                         <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                
                                <th class="text-center max-w-300"><?php echo e(__(ucwords(str_replace('_',' ',$type)))); ?></th>
                                <th class="text-center"><?php echo e(__('Sales Values')); ?></th>
                                <th class="text-center"><?php echo e(__('%')); ?></th>
                                <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                <th class="text-center"><?php echo e(__('Count')); ?></th>
                                <th class="text-center"><?php echo e(__('Count %')); ?></th>
                                <?php endif; ?>
                            </tr>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('table_body'); ?>



                            <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                
                                <td class=" max-w-300"><?php echo e($item['item']?? '-'); ?></td>
                                <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                                <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($item['Sales Value']/$total)*100) , 1) . ' %'); ?></td>
                                <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                <td class="text-center"><?php echo e($report_count_data[$key]['Count']); ?></td>
                                <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($report_count_data[$key]['Count'] /$total_count)*100) , 1) . ' %'); ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <tr class="table-active text-center">
                                <td><?php echo e(__('Total')); ?></td>
                                
                                <td><?php echo e(number_format($total)); ?></td>
                                <td>100 %</td>
                                <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                <td><?php echo e($total_count); ?></td>
                                <td>100 %</td>
                                <?php endif; ?>
                            </tr>
                            <?php $__env->endSlot(); ?>
                         <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
            <input type="hidden" id="total_<?php echo e($type); ?>" data-total="<?php echo e(json_encode($report_data)); ?>">
        </div>
    </div>
</div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="container__fixed custom_modal_parent">
    <div class="datatable_modal_div kt-portlet kt-portlet--mobile">
        <div class="" id="datatable_modal_div">

        </div>
        <a class="close_custom_modal" href="#"><i class="fas fa-times"></i></a>

    </div>

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
<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv_" + "<?php echo e($type); ?>", am4charts.PieChart);

        // Add data
        chart.data = $('#total_' + "<?php echo e($type); ?>").data('total');

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "Sales Value";
        pieSeries.dataFields.category = "item";
        pieSeries.innerRadius = am4core.percent(50);
        // arrow
        pieSeries.ticks.template.disabled = true;
        //number
        pieSeries.labels.template.disabled = true;

        var rgm = new am4core.RadialGradientModifier();
        rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
        pieSeries.slices.template.fillModifier = rgm;
        pieSeries.slices.template.strokeModifier = rgm;
        pieSeries.slices.template.strokeOpacity = 0.4;
        pieSeries.slices.template.strokeWidth = 0;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "right";
        chart.legend.scrollable = true;

    }); // end am4core.ready()

</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


<script>
    $(function() {

        $(document).on('show.bs.modal', '#modal_for_' + "<?php echo e(convertStringToClass($type)); ?>", function(e) {
            let company_id = $(this).find('input[type="hidden"][name="company_id"]').val();
            let type = $(this).find('input[name="type"][type="hidden"]').val();
            if (!$(this).data('target')) {
                let topTypeName = $('#top_for_' + type).val();
                let topTypeSalesValue = $('#value_for_' + type).val();


                $(this).find('#selected_type_name').html(topTypeName);

                $(this).find('#total_sales_value').html(topTypeSalesValue);

                $(this).find('option[value="' + topTypeName + '"]').prop('selected', true);
            }

            let selectedType = $(this).find('select[name="selected_type"]').val();
            $(this).data('target', 1);
            $.ajax({
                type: 'post'
                , url: "<?php echo e(route('get.net.sales.modal.for.type')); ?>"
                , data: {
                    "company_id": company_id
                    , "selectedType": selectedType
                    , "start_date": "<?php echo e($start_date); ?>"
                    , "end_date": "<?php echo e($end_date); ?>"
                    , "type": type
                    , "modal_id": 'modal_for_' + "<?php echo e(convertStringToClass($type)); ?>"
                }
                , success: function(result) {
                    if (result.data) {
                        let modal_id = result.data[0].modal_id;

                        for (index in result.data[0]) {

                            if (index != modal_id) {
                                $('#' + modal_id).find('#' + index).html(result.data[0][index]).attr('data-value', result.data[0][index]);
                            }
                        }
                    }
                }
                , error: function(reject) {}
            });


        })


    });

</script>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<script>
    $(document).on('change', '#business_sector_select_<?php echo e(convertStringToClass($type)); ?>', function(e) {
        e.preventDefault();
        $('#modal_for_' + "<?php echo e(convertStringToClass($type)); ?>").trigger('show.bs.modal')
    })

</script>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
    $(document).on('click', '.ranged-button-ajax', function(e) {
        e.preventDefault();
        let type = $(this).data('type');
        let column = $(this).data('column');
        let direction = $(this).data('direction');
        $.ajax({
            url: "<?php echo e(route('getTopAndBottomsForDashboard')); ?>"
            , data: {
                "type": type
                , "column": column
                , "direction": direction
                , 'company_id': "<?php echo e($company->id); ?>"
                , 'date_from': "<?php echo e($start_date); ?>"
                , 'date_to': "<?php echo e($end_date); ?>"
                , 'modal_id': $(this).closest('.modal__class_top_bottom').attr('id')
                , 'selected_type': $(this).closest('.modal__class_top_bottom').find('select[name="selected_type"]').val()
            }
            , "type": "post"
            , success: function(result) {
                let total_sales_values = $('#' + result.modal_id).find('#total_sales_value').attr('data-value');
                total_sales_values = parseFloat(total_sales_values.replaceAll(/,/g, ''));
                if (result.data.length) {
                    let table = "<table id='appended_table_for_view' class='appended_table_for_view datatable table-bordered table-hover table-checkable table'> <thead class='header___bg'><tr class='header___bg'><th class='header___bg'>#</th> <th class='header___bg'><?php echo e(__('Customer Name')); ?></th> <th class='header___bg text-center'><?php echo e(__('Value')); ?></th> <th class='header___bg text-center'><?php echo e(__('Percentage')); ?></th>  </tr></thead> <tbody>"
                    let order = 1;
                    let sumOfFifty = 0;
                    let salesValue = 0;
                    let percentage = 0;
                    let totalPercentage = 0;
                    for (index in result.data)

                    {
                        sumOfFifty += parseFloat(result.data[index].total_sales_value);
                        salesValue = result.data[index].total_sales_value;
                        percentage = salesValue / total_sales_values * 100;
                        totalPercentage += percentage

                        table += `<tr> <td>${order}</td> <td>${result.data[index].customer_name}</td><td class="text-center">${number_format( salesValue , 0) }</td> <td> ${number_format(percentage , 2) } % </td> </tr>`
                        order += 1;
                    }
                    table += ('<tr class="header___bg"><td class="header___bg">-</td> <td class="header___bg"><?php echo e(__("Total")); ?></td> <td class="text-center header___bg">  ' + number_format(sumOfFifty) + '</td> <td class="header___bg">' + number_format(totalPercentage, 2) + ' % </td> </tr>')
                    table += '</tbody> </table>';
                    $('#datatable_modal_div').empty().append(table);
                    $('#appended_table_for_view').DataTable({
                        paging: false
                        , ordering: false
                        , info: false
                        , searching: false
                        , dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                        buttons: [
                            'print'
                            , 'copyHtml5'
                            , 'excelHtml5'
                            , 'csvHtml5'
                            , 'pdfHtml5'
                        , ]

                    });

                    document.querySelectorAll('.close').forEach(function(modalItemCloser) {
                        $(modalItemCloser).trigger('click');
                    });
                    $('.container__fixed').css('display', 'block');
                }
            }
        });
    })

</script>
<script>
    $(document).on('click', function(e) {
        let targetElement = e.target;
        let x = $(targetElement).closest('.container__fixed').length;
        if (!x || targetElement.className.includes('container__fixed')) {
            $('.container__fixed').css('display', 'none');
        }
    })

</script>

<script>
    $(document).on('click', '.close_custom_modal', function(e) {
        e.preventDefault();
        $('.custom_modal_parent').fadeOut(300);
    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/client_view/home_dashboard/dashboard_breakdown.blade.php ENDPATH**/ ?>