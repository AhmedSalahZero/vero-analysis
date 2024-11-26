

<?php $__env->startSection('css'); ?>
    <?php echo $__env->make('datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo e(url('assets/vendors/general/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

    .hideit {
        display: none;
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
            <div class="alert-text"><?php echo e(__(' Please .. refill the fields according to the new dates')); ?></div>
        </div>
    </div>
</div>
<?php endif; ?>
<form action="<?php echo e(route('sales.forecast.quantity.save', $company)); ?>" method="POST">
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
                            <input type="date" name="start_date" required value="<?php echo e($sales_forecast['start_date']); ?>" class="form-control" placeholder="<?php echo e(__('Select date')); ?>" aria-describedby="emailHelp" />
                        </div>
                        <span class="input-note text-muted kt-font-primary kt-font-bold"> <i class="flaticon-warning note-icon"> </i>
                            <?php echo e(__('Kindly take note incase you changed the dates the info you filled will be deleted ')); ?>

                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label><?php echo e(__('End Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date" disabled value="<?php echo e($sales_forecast['end_date']); ?>" class="form-control" placeholder="<?php echo e(__('Select date')); ?>" />
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
                    <?php echo e(__('Sales Results (Value)')); ?>

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
                            <input type="hidden" name="previous_1_year_sales" value="<?php echo e($sales_forecast['previous_1_year_sales'] ?? 0); ?>">
                            <input type="hidden" name="previous_year" value="<?php echo e($sales_forecast['previous_year']); ?>">
                        </div>
                        <div class="progress progress--sm">
                            <div class="progress-bar kt-bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <input type="hidden" name="previous_year_gr" value="<?php echo e($sales_forecast['previous_year_gr'] ?? 0); ?>">
                        </div>

                        <div class="progress progress--sm">
                            <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <input type="hidden" name="average_last_3_years" value="<?php echo e($sales_forecast['average_last_3_years'] ?? 0); ?>">
                        </div>
                        <div class="progress progress--sm">
                            <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">

                            <b> <?php echo e(__('Previous Year Sales Breakdown')); ?> </b>

                        </h3>
                    </div>


                </div>
                <div class="kt-portlet__head kt-portlet__head--lg">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <?php $sales_forecast['others_products_previous_year'] = isset($sales_forecast['others_products_previous_year']) ? $sales_forecast['others_products_previous_year'] : old('others_products_previous_year'); ?>

                                <label><?php echo e(__('Show From Others (Multi-Selector  - Maximum 5 )')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                                <select class="form-control kt-select2" id="kt_select2_9" name="others_products_previous_year[]" multiple="multiple">
                                    <?php $__currentLoopData = $selector_products_previous_year??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product); ?>" <?php echo e((false !== $found = array_search($product,($sales_forecast['others_products_previous_year']??[]))) ? 'selected' : ''); ?>><?php echo e($product); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn active-style" name="submit" value="<?php echo e(__('Show Result')); ?>">
                        </div>
                    </div>
                    


                </div>

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->
                     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th>#</th>
                            <th class="max-w-classes"><?php echo e(__('Product Item')); ?></th>
                            <th><?php echo e(__('Sales Values')); ?></th>
                            <th><?php echo e(__('Sales %')); ?></th>
                            <th><?php echo e(__('Sales Qt')); ?></th>
                            <th><?php echo e(__('Av. Price')); ?></th>


                        </tr>

                        <?php $__env->endSlot(); ?>

                        <?php $__env->slot('table_body'); ?>
                        <?php $total = array_sum(array_column($sales_forecast['previous_year_seasonality']??[],'Sales Value')); ?>
                        <?php $__currentLoopData = $sales_forecast['previous_year_seasonality']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th><?php echo e($key+1); ?></th>
                            <th class="max-w-classes"><?php echo e($item['item']?? '-'); ?></th>
                            <input type="hidden" name="previous_year_seasonality[<?php echo e($key); ?>][item]" value="<?php echo e(($item['item']?? '-')); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                            <input type="hidden" name="previous_year_seasonality[<?php echo e($key); ?>][Sales Value]" value="<?php echo e(($item['Sales Value']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales %']??0,2)); ?> %</td>
                            <input type="hidden" name="previous_year_seasonality[<?php echo e($key); ?>][Sales %]" value="<?php echo e(($item['Sales %']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales Quantity']??0)); ?></td>
                            <input type="hidden" name="previous_year_seasonality[<?php echo e($key); ?>][Sales Quantity]" value="<?php echo e(($item['Sales Quantity']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Average Price']??0)); ?></td>
                            <input type="hidden" name="previous_year_seasonality[<?php echo e($key); ?>][Average Price]" value="<?php echo e(($item['Average Price']??0)); ?>">

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-active text-center">
                            <th colspan="2"><?php echo e(__('Total')); ?></th>
                            <td class="hidden"></td>
                            <td><?php echo e(number_format($total)); ?></td>
                            <td>100 %</td>
                            
                            <td>-</td>
                            <td>-</td>
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
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">

                            <b> <?php echo e(__('Average Last 3 Years Sales Breakdown')); ?> </b>

                        </h3>
                    </div>

                </div>
                <div class="kt-portlet__head kt-portlet__head--lg">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $sales_forecast['others_products_previous_3_year'] = isset($sales_forecast['others_products_previous_3_year']) ? $sales_forecast['others_products_previous_3_year'] : old('others_products_previous_3_year'); ?>
                                <label><?php echo e(__('Show From Others (Multi-Selector  - Maximum 5 )')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                                <select class="form-control kt-select2" id="kt_select2_8" name="others_products_previous_3_year[]" multiple="multiple">
                                    <?php $__currentLoopData = $selector_products_previous_3_year??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product); ?>" <?php echo e((false !== $found = array_search($product,($sales_forecast['others_products_previous_3_year']??[]))) ? 'selected' : ''); ?>><?php echo e($product); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn active-style" name="submit" value="<?php echo e(__('Show Result')); ?>">
                        </div>
                    </div>
                    


                </div>
                <div class="kt-portlet__body">

                    <!--begin: Datatable -->
                     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th>#</th>
                            <th class="max-w-classes"><?php echo e(__('Product Item')); ?></th>
                            <th><?php echo e(__('Sales Values')); ?></th>
                            <th><?php echo e(__('Sales %')); ?></th>
                            <th><?php echo e(__('Sales Qt')); ?></th>
                            <th><?php echo e(__('Av. Price')); ?></th>


                        </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                        <?php $total = array_sum(array_column($sales_forecast['last_3_years_seasonality'],'Sales Value')); ?>
                        <?php $__currentLoopData = $sales_forecast['last_3_years_seasonality']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th><?php echo e($key+1); ?></th>
                            <th class="max-w-classes"><?php echo e($item['item']?? '-'); ?></th>
                            <input type="hidden" name="last_3_years_seasonality[<?php echo e($key); ?>][item]" value="<?php echo e(($item['item']?? '-')); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                            <input type="hidden" name="last_3_years_seasonality[<?php echo e($key); ?>][Sales Value]" value="<?php echo e(($item['Sales Value']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales %']??0,2)); ?> %</td>
                            <input type="hidden" name="last_3_years_seasonality[<?php echo e($key); ?>][Sales %]" value="<?php echo e(($item['Sales %']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Sales Quantity']??0)); ?></td>
                            <input type="hidden" name="last_3_years_seasonality[<?php echo e($key); ?>][Sales Quantity]" value="<?php echo e(($item['Sales Quantity']??0)); ?>">
                            <td class="text-center"><?php echo e(number_format($item['Average Price']??0)); ?></td>
                            <input type="hidden" name="last_3_years_seasonality[<?php echo e($key); ?>][Average Price]" value="<?php echo e(($item['Average Price']??0)); ?>">

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-active text-center">
                            <th colspan="2"><?php echo e(__('Total')); ?></th>
                            <td class="hidden"></td>
                            <td><?php echo e(number_format($total)); ?></td>
                            <td>100 %</td>
                            
                            <td>-</td>
                            <td>-</td>
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
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--mobile">
                <?php $sales_forecast_data = App\Models\QuantitySalesForecast::company()->first() ?? old(); ?>
                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <div class="row">
                        <div class="col-md-6">
                            <label><?php echo e(__('Target Base')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date validated">

                                    <select name="target_base" class="form-control" id="target_base" required>
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        <?php if(hasProductsItems($company)): ?>
                                        <option value="previous_year" <?php echo e(@$sales_forecast_data['target_base'] !== 'previous_year' ?'': 'selected'); ?>>
                                            <?php echo e(__('Based On Pervious Year Sales')); ?></option>
                                        <option value="previous_3_years" <?php echo e(@$sales_forecast_data['target_base'] !== 'previous_3_years' ?'': 'selected'); ?>>
                                            <?php echo e(__('Based On Last 3 Years Sales')); ?></option>
                                        <?php endif; ?>
                                        <option value="new_start" <?php echo e(@$sales_forecast_data['target_base'] !== 'new_start' ?'': 'selected'); ?>>
                                            <?php echo e(__('New Start')); ?></option>
                                    </select>
                                    <?php if($errors->has('target_base')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('target_base')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-2" style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'previous_year' || @$sales_forecast_data['target_base'] == 'previous_3_years'? 'block': 'none'); ?>" id="quantity_growth_rate_field">
                            <label><?php echo e(__('Quantity Growth Rate %')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon validated">
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="quantity_growth_rate" value="<?php echo e(@$sales_forecast_data['quantity_growth_rate']); ?>" id="quantity_growth_rate">
                                </div>
                                <?php if($errors->has('quantity_growth_rate')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('quantity_growth_rate')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-2" style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'previous_year' || @$sales_forecast_data['target_base'] == 'previous_3_years' ? 'block': 'none'); ?>" id="prices_increase_rate_field">
                            <label><?php echo e(__('Prices Increase Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group validated">
                                    <input type="number" step="any" class="form-control" name="prices_increase_rate" value="<?php echo e(@$sales_forecast_data['prices_increase_rate']); ?>" id="prices_increase_rate">
                                    <?php if($errors->has('prices_increase_rate')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('prices_increase_rate')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" style="display: <?php echo e(@$sales_forecast_data['target_base'] == 'previous_year' || @$sales_forecast_data['target_base'] == 'previous_3_years' ? 'block': 'none'); ?>" id="other_products_growth_rate_field">
                            <label><?php echo e(__('Other Products Growth Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group validated">
                                    <input type="number" step="any" class="form-control" name="other_products_growth_rate" value="<?php echo e(@$sales_forecast_data['other_products_growth_rate']); ?>" id="other_products_growth_rate">
                                    <?php if($errors->has('other_products_growth_rate')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('other_products_growth_rate')); ?></div>
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
                                    <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                        <input class="rows" name="add_new_products" type="checkbox" value="1" <?php echo e(@$sales_forecast_data['add_new_products'] == 0 ?: 'checked'); ?> id="product_item_check_box" data-old-checked="<?php echo e(@$sales_forecast_data['add_new_products']?:0); ?>">
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
                        <div class="col-md-6" style="display:<?php echo e(@$sales_forecast_data['add_new_products'] == 1 ? 'block' : 'none'); ?>" id="number_of_products_field" data-old-value="<?php echo e(@$sales_forecast_data['number_of_products'] ?: 0); ?>">
                            <label><?php echo e(__('How Many Products')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group validated">
                                    <input type="number" step="any" class="form-control" name="number_of_products" value="<?php echo e(@$sales_forecast_data['number_of_products']); ?>" id="number_of_products">
                                    <?php if($errors->has('number_of_products')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('number_of_products')); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if(hasProductsItems($company)): ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group  form-group-marginless">
                                <label><?php echo e(__('Seasonality')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date validated">

                                        <select name="seasonality" class="form-control" id="seasonality">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                            <option value="previous_year" <?php echo e(@$sales_forecast_data['seasonality'] !== 'previous_year' ?: 'selected'); ?>>
                                                <?php echo e(__('Pervious Year Seasonality')); ?></option>
                                            <option value="last_3_years" <?php echo e(@$sales_forecast_data['seasonality'] !== 'last_3_years' ?: 'selected'); ?>>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.next__button','data' => ['report' => true,'companyId' => $company->id]]); ?>
<?php $component->withName('next__button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['report' => true,'companyId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($company->id)]); ?>  <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/vendors/general/select2/dist/js/select2.full.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/select2.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>
    <?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>

<script>
    $('#target_base').on('change', function() {
        val = $(this).val();

        if (val == 'previous_year' || val == 'previous_3_years') {

            // $('#new_start_field').fadeOut("slow", function() {
            $('#quantity_growth_rate_field').fadeIn(300);
            $('#prices_increase_rate_field').fadeIn(300);
            $('#other_products_growth_rate_field').fadeIn(300);
            // });
        } else if (val == 'new_start') {
            // $('#quantity_growth_rate_field').fadeOut("slow", function() {
            $('#quantity_growth_rate_field').fadeOut(300);
            $('#prices_increase_rate_field').fadeOut(300);
            $('#other_products_growth_rate_field').fadeOut(300);

            // });
        }
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


<script>
    $(document).on('change', '#product_item_check_box , #number_of_products', function(e) {
        let oldIsChedked = $('#product_item_check_box').attr('data-old-checked');
        let newIsChecked = $('#product_item_check_box').is(':checked') ? 1 : 0;

        let oldNewProductsItems = parseFloat($('#number_of_products_field').attr('data-old-value'));
        let newProductsItems = parseFloat($('#number_of_products').val());

        if (oldIsChedked != newIsChecked || oldNewProductsItems != newProductsItems) {
            $('#subkit_summary_report_id').addClass('hideit');
        } else {
            $('#subkit_summary_report_id').removeClass('hideit');
        }

    })

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/client_view/quantity_forecast/sales_forecast.blade.php ENDPATH**/ ?>