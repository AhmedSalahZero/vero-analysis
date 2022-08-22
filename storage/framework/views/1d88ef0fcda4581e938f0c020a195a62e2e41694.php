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

        .fixTableHead {
            overflow-y: auto;
            height: 110px;
        }

        .fixTableHead thead th {
            position: sticky;
            top: 0;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('products.allocations', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="kt-portlet" id="copied_company_target">

        </div>
        <?php $name = ($has_product_item == true) ? 'Items' : '' ?>
        
        <?php if($sales_forecast['add_new_products'] == 1): ?>
            <div class="kt-portlet">
                
                <div class="row ">
                    <div class="col-md-12">
                        <div class="kt-portlet kt-portlet--mobile">

                            <div class="kt-portlet__body">

                                <!--begin: Datatable -->

                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('New Product '.$name.' Monthly Sales Target Year ') . date('Y',strtotime($sales_forecast->start_date)),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                    <?php $__env->slot('table_header'); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Dates')); ?></th>
                                            <?php $__currentLoopData = $new_products_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e(__('Total Values')); ?></th>
                                        </tr>
                                    <?php $__env->endSlot(); ?>
                                    <?php $__env->slot('table_body'); ?>
                                        <?php $__currentLoopData = $new_products_seasonalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_name => $product_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th class="text-center"><?php echo e($product_name); ?></th>
                                                <?php $__currentLoopData = $new_products_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="text-center">
                                                        <?php echo e(number_format($product_data[$date] ?? 0)); ?>

                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <td> <?php echo e(number_format(array_sum($product_data))); ?> </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Month Total')); ?></th>
                                            <?php $__currentLoopData = $new_products_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th><?php echo e(number_format($value)); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <th> <?php echo e(number_format(array_sum($new_products_totals))); ?> </th>
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
            </div>
        <?php endif; ?>


        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Forecast')); ?>

                    </h3>

                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            &nbsp;
                            <a href="<?php echo e(route('modify.seasonality', $company)); ?>" class="btn  active-style btn-icon-sm ">
                                <i class="fas fa-file-import"></i>
                                <?php echo e(__("Modify Seasonality")); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
                <?php if((hasProductsItems($company))): ?>

            <div class="kt-portlet__body ">
                <h2><?php echo e(__('Existing Product '.$name.' Target Year ') .date('Y', strtotime($sales_forecast->start_date)) .' : ' .number_format($existing_products_sales_targets)); ?>

                </h2>
                <br>
                <br>

        

                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Existing Product '.$name.' Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__('Product '.$name.' Name')); ?></th>
                            <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e(__('Total')); ?></th>
                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                        <?php 
                        $totals_per_month = [];

                        ?> 

                        
                        <?php $__currentLoopData = $existing_products_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $product_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $total_existing_targets = 0; ?>
                            <tr>
                                <td> <b> <?php echo e($item ?? '-'); ?></b></td>

                                <?php $__currentLoopData = $product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                    <?php
                                        $totals_per_month[$date] = $value + ($totals_per_month[$date] ?? 0);
                                        $total_existing_targets += $value;
                                    ?>
                                    <td class="text-center"><?php echo e(number_format(($value??0))); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center"><?php echo e(number_format($total_existing_targets)); ?></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="table-active text-center">
                            <td><b> <?php echo e(__('Total')); ?> </b></td>
                            <?php $__currentLoopData = $totals_per_month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e(number_format($value)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e(number_format(array_sum($totals_per_month))); ?></td>
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




                <?php endif; ?>


        <div class="kt-portlet" id="company_target">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--mobile">

                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->
                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Total Company Sales Target'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                <?php $__env->slot('table_header'); ?>
                                    <tr class="table-active text-center">
                                        <th><?php echo e(__('Dates')); ?></th>
                                        <?php $__currentLoopData = $totals_per_month?:$monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e($date); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e(__('Total Values')); ?></th>
                                    </tr>
                                <?php $__env->endSlot(); ?>
                                <?php $__env->slot('table_body'); ?>
                                    <?php $total_existing_new = []; ?>
                                    
                                    <tr>
                                        <th><?php echo e(__('New Product '.$name.' Sales Target')); ?></th>
                                        <?php $__currentLoopData = $new_products_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $total_existing_new[$date] = ($total_existing_new[$date] ?? 0) + $value; ?>
                                            <td><?php echo e(number_format($value)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $all_new_products_totals = array_sum($new_products_totals); ?>
                                        <td class="text-center"><?php echo e(number_format($all_new_products_totals)); ?></td>
                                    </tr>

                                    
                                    <tr>
                                        <th><?php echo e(__('Existing Product '.$name.' Sales Target')); ?></th>
                                        <?php $__currentLoopData = $totals_per_month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $total_existing_new[$date] = ($total_existing_new[$date] ?? 0) + $value; ?>
                                            <td><?php echo e(number_format($value)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $all_existings_total = array_sum($totals_per_month); ?>
                                        <td class="text-center"><?php echo e(number_format($all_existings_total)); ?></td>
                                    </tr>

                                    <tr class="table-active ">
                                        <th class="text-center "><?php echo e(__('Total')); ?></th>
                                        <?php $__currentLoopData = $total_existing_new; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center"><?php echo e(number_format($value)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $all_existing_new_total = array_sum($total_existing_new); ?>
                                        <td class="text-center"><?php echo e(number_format($all_existing_new_total)); ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('New Product '.$name.' Sales %')); ?></th>
                                        <?php $__currentLoopData = $new_products_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(number_format($total_existing_new[$date] == 0 ? 0 : ($value / $total_existing_new[$date]) * 100, 2) . ' %'); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <?php echo e(number_format($all_existing_new_total == 0 ? 0 : ($all_new_products_totals / $all_existing_new_total) * 100,2) . ' %'); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('Existing Product '.$name.' Sales %')); ?></th>
                                        <?php $__currentLoopData = $totals_per_month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(number_format($total_existing_new[$date] == 0 ? 0 : ($value / $total_existing_new[$date]) * 100, 2) . ' %'); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <?php echo e(number_format($all_existing_new_total == 0 ? 0 : ($all_existings_total / $all_existing_new_total) * 100, 2) .' %'); ?>

                                        </td>
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
        </div>

        <div class="kt-portlet">
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <button type="submit" class="btn active-style"><?php echo e(__('Allocation')); ?></button>
                            <a href="<?php echo e(route('collection.settings',$company)); ?>" class="btn btn-secondary active-style"><?php echo e(__('Skip And Apply Collection')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
        $(document).ready(function() {
            companyTargetContent();
            for (let index = 0; index < '<?php echo e($sales_forecast->number_of_products); ?>'; index++) {
                totalFunction('.months', '.total_months', index, 0);
                totalFunction('.quarters', '.total_quarters', index, 0);
            }
        });

        function companyTargetContent() {
            var company_targets = $('#company_target').html();
            $('#copied_company_target').html(company_targets);
            $('#company_target').html('');

        };


        $('.months').on('change', function() {
            key = $(this).data('product');
            totalFunction('.months', '.total_months', key, 0);
        });
        $('.quarters').on('change', function() {
            key = $(this).data('product');
            totalFunction('.quarters', '.total_quarters', key, 0);
        });

        function totalFunction(field_name, total_field_name, key, decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '' && key == $(this).data('product')) {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).eq(key).val(total.toFixed(decimals));
        }


        $('.products').on('change', function() {
            var name = $(this).find(':selected').data('name');
            var id = $(this).find(':selected').data('id');
            var index = $('.products').index(this);
            $('.categories option').eq(index).remove();
            select = '<option value="' + id + '" selected>' + name + '</option>';
            $('.categories').eq(index).append(select);
        });

        $('.sales_target_value').on('change', function() {
            var index = $('.sales_target_value').index(this);
            var sales_target_value = parseFloat($(this).val());
            var percentage = (sales_target_value / parseFloat("<?php echo e($sales_forecast->sales_target); ?>")) * 100;
            $('.sales_target_percentage').eq(index).val(percentage.toFixed(2));
        });

        $('.sales_target_percentage').on('change', function() {
            var index = $('.sales_target_percentage').index(this);
            var sales_target_percentage = parseFloat($(this).val()) / 100;
            var value = (sales_target_percentage * parseFloat("<?php echo e($sales_forecast->sales_target); ?>"));
            $('.sales_target_value').eq(index).val(value.toFixed(0));
        });

        $('.seasonality').on('change', function() {
            val = $(this).val();
            var index = $('.seasonality').index(this);

            if (val == 'new_seasonality_monthly') {
                $('.monthly_seasonality').eq(index).fadeIn(300);
                $('.quarterly_seasonality').eq(index).fadeOut("slow", function() {});
            } else if (val == 'new_seasonality_quarterly') {
                $('.monthly_seasonality').eq(index).fadeOut("slow", function() {
                    $('.quarterly_seasonality').eq(index).fadeIn(300);
                });

            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/products_allocations.blade.php ENDPATH**/ ?>