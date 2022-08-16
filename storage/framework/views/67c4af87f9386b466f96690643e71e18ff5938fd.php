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
    <form action="<?php echo e(route('new.product.seasonality', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <?php if($new_products_allocations): ?>
        <?php $total_products_items = [];
              $allocation_base = str_replace('_', ' ', ucwords($new_products_allocations->allocation_base)) ;?>

        <?php if(count($products_seasonality)>0): ?>
            <div class="kt-portlet">
                <div class="kt-portlet__body ">

                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($allocation_base.' Against New Product Items Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__($allocation_base .' / Months')); ?></th>
                                <?php $__currentLoopData = $allocation_data_total['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($date); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th> <?php echo e(__('Total Year')); ?> </th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                                <?php
                                    sortTwoDimensionalExcept($allocation_data_total , ['Total'] );

                                ?>
                            <?php $__currentLoopData = $allocation_data_total; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $class_name = $base_name == 'Total' ? 'active-style' : '' ; ?>
                                <tr>
                                    <td class="<?php echo e($class_name); ?>"><?php echo e($base_name); ?></td>
                                    <?php $__currentLoopData = $allocation_data_total['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_products_items[$base_name][$date] = ($value[$date] ?? 0);
                                        ?>
                                        <td class="text-center <?php echo e($class_name); ?>"> <?php echo e(number_format($value[$date] ?? 0)); ?> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="<?php echo e($class_name); ?>" ><?php echo e(number_format(array_sum($value))); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php else: ?>
        <?php
            $allocation_base = '';
        ?>
        <?php endif; ?>
        
        <div class="kt-portlet">
            <div class="kt-portlet__body ">
                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($allocation_base.' Against Existing Product Items Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__($allocation_base .' / Months')); ?></th>
                            <?php $__currentLoopData = $existing_product_data['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(date('M-Y',strtotime('01-'.$date.'-'.$year))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th> <?php echo e(__('Total Year')); ?> </th>
                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                    <?php

    sortTwoDimensionalExcept($existing_product_data , ['Total'] );

?>
                        <?php $__currentLoopData = $existing_product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $class_name = $base_name == 'Total' ? 'active-style' : '' ;

                            ?>
                            <tr>
                                <td class="<?php echo e($class_name); ?>"><?php echo e($base_name); ?></td>
                                <?php $__currentLoopData = $existing_product_data['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $full_date = date('M-Y',strtotime('01-'.$date.'-'.$year));
                                        $total_products_items[$base_name][$full_date] = ($value[$date] ?? 0) + ($total_products_items[$base_name][$full_date]??0);
                                    ?>
                                    <td class="text-center <?php echo e($class_name); ?>"> <?php echo e(number_format($value[$date] ?? 0)); ?> </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td class="<?php echo e($class_name); ?>" ><?php echo e(number_format(array_sum($value))); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

            </div>
        </div>
        <?php if(count($products_seasonality)>0): ?>
            
            <div class="kt-portlet">
                <div class="kt-portlet__body ">
                    <?php
                        $total = $total_products_items['Total'];
                        unset($total_products_items['Total']);
                        arsort($total_products_items);
                        $total_products_items['Total'] = $total;
                    ?>
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Total '.$allocation_base.' Monthly Sales Target Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__($allocation_base .' / Months')); ?></th>
                                <?php $__currentLoopData = $total_products_items['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($date); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th> <?php echo e(__('Total Year')); ?> </th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
          <?php

    sortTwoDimensionalExcept($total_products_items , ['Total'] );

?>
                            <?php $__currentLoopData = $total_products_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $class_name = $base_name == 'Total' ? 'active-style' : '' ; ?>
                                <tr>
                                    <td class="<?php echo e($class_name); ?>"><?php echo e($base_name); ?></td>
                                    <?php $__currentLoopData = $total_products_items['Total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                        <?php $total_value = ($existing_product_data_with_dates[$base_name][$date]??0) + ($value[$date]??0) ?>
                                        <td class="text-center <?php echo e($class_name); ?>"> <?php echo e(number_format($total_value ?? 0)); ?> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="<?php echo e($class_name); ?>" ><?php echo e(number_format(array_sum($value))); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        
        <div class="kt-portlet">
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-6">
                            
                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <button type="submit" class="btn active-style"><?php echo e(__('Second Allocation')); ?></button>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/new_product_seasonality.blade.php ENDPATH**/ ?>