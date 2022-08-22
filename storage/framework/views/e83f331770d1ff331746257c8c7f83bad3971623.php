<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet"
        type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(session()->has('message')): ?>
        <div class="row">

            <div class="col-1"></div>
            <div class="col-10">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text"><?php echo e(__(' Please .. refill the fields according to the new dates  ')); ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('sales.forecast.save', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Forecast')); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label><?php echo e(__('Choose Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" name="start_date" required value="<?php echo e($sales_forecast['start_date']); ?>"
                                    class="form-control" placeholder="Select date" aria-describedby="emailHelp" />
                            </div>
                            <span class="input-note text-muted kt-font-primary kt-font-bold"> <i
                                    class="flaticon-warning note-icon"> </i>
                                <?php echo e(__('Kindly take note incase you changed the dates the info you filled will be deleted ')); ?>

                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo e(__('End Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" name="end_date" disabled value="<?php echo e($sales_forecast['end_date']); ?>"
                                    class="form-control" placeholder="Select date" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin:: Widgets/Stats-->

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Results')); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">

                    
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Pervious Year Sales (year' . $sales_forecast['previous_year'] . ' )')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success">
                                    <?php echo e($previous_year_sales =  number_format($sales_forecast['previous_1_year_sales'] ?? 0)); ?>


                                    <?php
                                        $previous_year_sales = 0;
                                    ?>
                                </span>
                                <input type="hidden" name="previous_1_year_sales"
                                    value="<?php echo e($sales_forecast['previous_1_year_sales'] ?? 0); ?>">
                                <input type="hidden" name="previous_year" value="<?php echo e($sales_forecast['previous_year']); ?>">
                            </div>
                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-success" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="kt-widget24__action">

                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>
                    
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--begin::Total Profit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Year ' . $sales_forecast['previous_year'] . ' Gr Rate %')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                    <?php echo e(number_format($sales_forecast['previous_year_gr'] ?? 0, 2) . ' % '); ?>

                                </span>
                                <input type="hidden" name="previous_year_gr"
                                    value="<?php echo e($sales_forecast['previous_year_gr'] ?? 0); ?>">
                            </div>

                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="kt-widget24__action">
                                <span class="kt-widget24__change">

                                </span>
                                <span class="kt-widget24__number">

                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Last 3 Years Average Sales')); ?>

                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning">
                                    <?php echo e(number_format($sales_forecast['average_last_3_years'] ?? 0)); ?>

                                </span>
                                <input type="hidden" name="average_last_3_years"
                                    value="<?php echo e($sales_forecast['average_last_3_years'] ?? 0); ?>">
                            </div>
                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="kt-widget24__action">
                                <span class="kt-widget24__change">

                                </span>
                                <span class="kt-widget24__number">

                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Stats-->






        
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile">

                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Previous Year Seasonality'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__env->slot('table_header'); ?>
                                <tr class="table-active text-center">
                                    <th><?php echo e(__('Dates')); ?></th>
                                    <?php $__currentLoopData = $sales_forecast['previous_year_seasonality'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $seasonality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('table_body'); ?>
                                <tr>
                                    <th class="text-center"><?php echo e(__('Seasonality')); ?></th>
                                    <?php $__currentLoopData = $sales_forecast['previous_year_seasonality'] ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $seasonality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">

                                            <?php echo e(number_format($seasonality, 2) . ' %'); ?>

                                        </td>
                                        <input type="hidden" name="previous_year_seasonality[<?php echo e($date); ?>]"
                                            value="<?php echo e($seasonality ?? 0); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>


                    </div>
                </div>
            </div>
        </div>









        
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Last 3 Years Seasonality'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__env->slot('table_header'); ?>
                                <tr class="table-active text-center">
                                    <th><?php echo e(__('Dates')); ?></th>
                                    <?php $__currentLoopData = $sales_forecast['last_3_years_seasonality'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $seasonality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($month); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('table_body'); ?>
                                <tr>
                                    <th class="text-center"><?php echo e(__('Seasonality')); ?></th>
                                    <?php $sum_totals = array_sum($sales_forecast['last_3_years_seasonality'] ?? []); ?>
                                    <?php $__currentLoopData = $sales_forecast['last_3_years_seasonality'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <?php echo e(number_format(($total / $sum_totals) * 100 ?? 0, 2) . ' %'); ?>

                                        </td>
                                        <input type="hidden" name="last_3_years_seasonality[<?php echo e($month); ?>]"
                                            value="<?php echo e(($total / $sum_totals) * 100 ?? 0); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php $__env->endSlot(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>


                    </div>
                </div>
            </div>
        </div>






        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <?php $sales_forecast_data = App\Models\SalesForecast::company()->first() ?? old(); ?>
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <div class="row">
                            <div class="col-md-6">
                                <label><?php echo e(__('Target Base')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date validated">
                                        <select name="target_base" class="form-control" id="target_base">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                            <?php if(hasProductsItems($company)): ?>
                                            <option value="previous_year"
                                                <?php echo e(@$sales_forecast_data['target_base'] !== 'previous_year' ?: 'selected'); ?>>
                                                <?php echo e(__('Based On Pervious Year Sales')); ?></option>
                                            <option value="previous_3_years"
                                                <?php echo e(@$sales_forecast_data['target_base'] !== 'previous_3_years' ?: 'selected'); ?>>
                                                <?php echo e(__('Based On Last 3 Years Sales')); ?></option>
                                                <?php endif; ?> 
                                            <option value="new_start"
                                                <?php echo e(@$sales_forecast_data['target_base'] !== 'new_start' ?: 'selected'); ?>>
                                                <?php echo e(__('New Start')); ?></option>
                                        </select>
                                        <?php if($errors->has('target_base')): ?>
                                            <div class="invalid-feedback"><?php echo e($errors->first('target_base')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6"
                                style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'new_start' ? 'block' : 'none'); ?>"
                                id="new_start_field">
                                <div class="form-group  form-group-marginless validated">
                                    <label>New Start</label>
                                    <div class="col-md-12 " >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="kt-option">
                                                    <span class="kt-option__control">
                                                        <span
                                                            class="kt-radio kt-radio--bold kt-radio--brand kt-radio--check-bold"
                                                            checked>
                                                            <input type="radio" name="new_start" value="annual_target"
                                                                <?php echo e(@$sales_forecast_data['new_start'] == 'annual_target' ? 'checked' : ''); ?>>
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="kt-option__label">
                                                        <span class="kt-option__head">
                                                            <span class="kt-option__title">
                                                                <?php echo e(__('Annual Target')); ?>

                                                            </span>

                                                        </span>
                                                        <span class="kt-option__body">
                                                            
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="kt-option">
                                                    <span class="kt-option__control">
                                                        <span class="kt-radio kt-radio--bold kt-radio--brand">
                                                            <input type="radio" name="new_start" value="product_target"
                                                                <?php echo e(@$sales_forecast_data['new_start'] == 'product_target' ? 'checked' : ''); ?>>
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="kt-option__label">
                                                        <span class="kt-option__head">
                                                            <span class="kt-option__title">
                                                                <?php echo e(__('Prodcuts Targets')); ?>

                                                            </span>

                                                        </span>
                                                        <span class="kt-option__body">
                                                            
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php if($errors->has('new_start')): ?>
                                            <div class="invalid-feedback"><?php echo e($errors->first('new_start')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3"
                                style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'previous_year' || @$sales_forecast_data['target_base'] == 'previous_3_years'? 'block': 'none'); ?>"
                                id="growth_rate_field">
                                <label><?php echo e(__('Growth Rate %')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon validated">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="growth_rate"
                                            value="<?php echo e(@$sales_forecast_data['growth_rate']); ?>" id="growth_rate">
                                    </div>
                                    <?php if($errors->has('growth_rate')): ?>
                                        <div class="invalid-feedback"><?php echo e($errors->first('growth_rate')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-<?php echo e(@$sales_forecast_data['new_start'] == 'annual_target' && @$sales_forecast_data['target_base'] == 'new_start'? '6': '3'); ?>"
                                style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'previous_year' || @$sales_forecast_data['target_base'] == 'previous_3_years' ||@$sales_forecast_data['new_start'] == 'annual_target'? 'block': 'none'); ?>"
                                id="sales_target_field">
                                <label><?php echo e(__('Annual Sales Target')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group validated">
                                        <input type="number" step="any" class="form-control" name="sales_target"
                                            value="<?php echo e(@$sales_forecast_data['sales_target']); ?>"  id="sales_target">
                                        <?php if($errors->has('sales_target')): ?>
                                            <div class="invalid-feedback"><?php echo e($errors->first('sales_target')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-6 ">
                                <label class="kt-option bg-secondary">
                                    <span class="kt-option__control">
                                        <span
                                            class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                            checked>
                                            <input class="rows" name="add_new_products" type="checkbox" value="1"
                                                <?php echo e(@$sales_forecast_data['add_new_products'] == 0 ?: 'checked'); ?>

                                                id="product_item_check_box">
                                            <span></span>
                                        </span>
                                    </span>
                                    <span class="kt-option__label d-flex">
                                        <span class="kt-option__head mr-auto p-2">
                                            <span class="kt-option__title">
                                                <b>
                                                    <?php echo e(__('Add New Products Or Product Item')); ?>

                                                </b>
                                            </span>

                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-6"
                                style="display:<?php echo e(@$sales_forecast_data['add_new_products'] == 1 ? 'block' : 'none'); ?>"
                                id="number_of_products_field">
                                <label><?php echo e(__('How Many Products')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group validated">
                                        <input type="number" step="any" class="form-control" name="number_of_products"
                                            value="<?php echo e(@$sales_forecast_data['number_of_products']); ?>" id="number_of_products">
                                            <?php if($errors->has('number_of_products')): ?>
                                                <div class="invalid-feedback"><?php echo e($errors->first('number_of_products')); ?></div>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <?php ?>
                                                   <?php if(hasProductsItems($company)): ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  form-group-marginless">
                                    <label><?php echo e(__('Seasonality')); ?> <span class="required">*</span></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date validated">

                                            <select name="seasonality" class="form-control" id="seasonality">
                                                <option value="" selected><?php echo e(__('Select')); ?></option>
                                                <option value="previous_year"
                                                    <?php echo e(@$sales_forecast_data['seasonality'] !== 'previous_year' ?: 'selected'); ?>>
                                                    <?php echo e(__('Pervious Year Seasonality')); ?></option>
                                                <option value="last_3_years"
                                                    <?php echo e(@$sales_forecast_data['seasonality'] !== 'last_3_years' ?: 'selected'); ?>>
                                                    <?php echo e(__('Last 3 Years Seasonality')); ?></option>

                                           
                                            </select>
                                            <?php if($errors->has('seasonality')): ?>
                                                <div class="invalid-feedback"><?php echo e($errors->first('seasonality')); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                                                <?php endif; ?> 

                    </div>
                </div>
            </div>
        </div>







        
        
        
        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.next__button','data' => []]); ?>
<?php $component->withName('next__button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"
        type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>"
        type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
    </script>

    <script>
        // $(document).ready(function () {
        //     totalFunction('.months','.total_months',0);
        //     totalFunction('.quarters','.total_quarters',0);
        // });
        $("input[name='new_start']").change(function() {

            if ($(this).val() == 'annual_target') {
                $('#sales_target_field').attr("readonly", false);
                $('#sales_target_field').fadeIn(300);

            } else {
                $('#sales_target_field').fadeOut(300);
                $('#sales_target_field').attr("readonly", true);
            }
        });
        $('#target_base').on('change', function() {
            val = $(this).val();

            if (val == 'previous_year' || val == 'previous_3_years') {

                $('#new_start_field').fadeOut("slow", function() {
                    $('#growth_rate_field').fadeIn(300);
                    $('#sales_target_field').fadeIn(300);
                });
                $('#sales_target_field').attr("readonly", true);
            } else if (val == 'new_start') {
                $('#growth_rate_field').fadeOut("slow", function() {
                    $('#sales_target_field').fadeOut(300);
                    $('#new_start_field').fadeIn(300);
                });
                $('#sales_target_field').attr("readonly", true);
            } else {

            }
        });



        $('#growth_rate,#target_base').on('change', function() {
            val = $('#target_base').val();
            growth_rate = parseFloat($('#growth_rate').val()) / 100;
            result = 0;
            if (val == 'previous_year') {
                result = parseFloat("<?php echo e($sales_forecast['previous_1_year_sales']); ?>") * (1 + growth_rate);
            } else if (val == 'previous_3_years') {
                result = parseFloat("<?php echo e($sales_forecast['average_last_3_years']); ?>") * (1 + growth_rate);

            }
            $('#sales_target').val(result.toFixed(0));
        });











        $('#seasonality').on('change', function() {
            val = $(this).val();

            if (val == 'previous_year' || val == 'last_3_years') {

                $('#monthly_seasonality').fadeOut(300)
                $('#quarterly_seasonality').fadeOut(300)
            } else if (val == 'new_seasonality_monthly') {
                $('#quarterly_seasonality').fadeOut("slow", function() {
                    $('#monthly_seasonality').fadeIn(300);
                });
            } else if (val == 'new_seasonality_quarterly') {
                $('#monthly_seasonality').fadeOut("slow", function() {
                    $('#quarterly_seasonality').fadeIn(300);
                });

            }
        });


        $('#product_item_check_box').change(function(e) {
            if ($(this).prop("checked")) {
                $('#number_of_products_field').fadeIn(300);
            } else {
                $('#number_of_products_field').fadeOut(300);
            }
        });
        // $('.months').change(function(e) {
        //     totalFunction('.months','.total_months',0);
        // });
        // $('.quarters').change(function(e) {
        //     totalFunction('.quarters','.total_quarters',0);
        // });

        function totalFunction(field_name, total_field_name, decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '') {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).val(total.toFixed(decimals));
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/sales_forecast.blade.php ENDPATH**/ ?>