<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }
        .col-sm-6.text-left{
            display: none ;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__('Comparing Sales Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <?php if(session('warning')): ?>
                <div class="alert alert-warning">
                    <ul>
                        <li><?php echo e(session('warning')); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand"
                    role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                            <i class="flaticon2-checking"></i>Reports Table
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content  kt-margin-t-20">


                <!--End:: Tab  EGP FX Rate Table -->

                <!--Begin:: Tab USD FX Rate Table -->
                <div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">

                                    <b> <?php echo e(__('From : ')); ?> </b><?php echo e($request_dates['start_date']); ?>

                                    <b> - </b>
                                    <b> <?php echo e(__('To : ')); ?></b> <?php echo e($request_dates['end_date']); ?>

                                    <br>

                                    <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b>
                                        <?php echo e($last_date); ?></span>
                                </h3>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <?php
                            $total_previous_year=0;
                            $col_num = 12;
                            if (count($report_data) == 2 ) {
                                $col_num = 6;
                            }elseif (count($report_data) > 2 ){
                                $col_num = 4;
                            }
                        ?>
                        <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year =>$data_per_year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-<?php echo e($col_num); ?>">

                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => 'Year -' .$year,'tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                    <?php $__env->slot('table_header'); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Month')); ?></th>
                                            <th><?php echo e(__('Sales Value')); ?></th>
                                            <th><?php echo e(__('Month Sales %')); ?></th>
                                            <td><?php echo e(__('YoY GR%')); ?></td>
                                        </tr>
                                    <?php $__env->endSlot(); ?>
                                    <?php $__env->slot('table_body'); ?>
                                        <?php $__currentLoopData = $data_per_year['Months']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="text-center">
                                                <td><?php echo e($date); ?></td>
                                                <td><?php echo e(number_format(($data_per_year['Sales Values'][$date]??0),0)); ?></td>
                                                <td><?php echo e(number_format(($data_per_year['Month Sales %'][$date]??0),2) . ' %'); ?></td>
                                                <td><?php echo e(number_format(($data_per_year['YoY GR%'][$date]??0),2) . ' %'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_sales_values_per_year = (array_sum($data_per_year['Sales Values']??[]));
                                            $total_yoy = $total_previous_year ==0 ? 0 : ($total_sales_values_per_year - $total_previous_year)/$total_previous_year *100;
                                        ?>
                                        <tr class="table-active text-center odd">
                                            <th><?php echo e(__('Total')); ?></th>
                                            <td><?php echo e(number_format(($total_sales_values_per_year),0)); ?></td>
                                            <td><?php echo e(number_format((array_sum($data_per_year['Month Sales %']??[])),2) . ' %'); ?></td>
                                            <td><?php echo e(number_format($total_yoy,2) . ' %'); ?></td>
                                        </tr>
                                        <?php $total_previous_year=$total_sales_values_per_year;?>
                                    <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>






                    <div class="row">


                        <div class="col-md-6">

                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => 'Monthly Seasonality Table','tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                    <?php $__env->slot('table_header'); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Month')); ?></th>
                                            <th><?php echo e(__('Month Sales %')); ?></th>
                                        </tr>
                                    <?php $__env->endSlot(); ?>
                                    <?php $__env->slot('table_body'); ?>
                                        <?php $sum_totals = array_sum($total_full_data); ?>
                                        <?php $__currentLoopData = $total_full_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="text-center">
                                                <td><?php echo e($date); ?></td>
                                                <td><?php echo e(number_format(((($total/$sum_totals)*100)??0),2)  . ' %'); ?> </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_sales_values_per_year = (array_sum($data_per_year['Sales Values']??[]));
                                            $total_yoy = $total_previous_year ==0 ? 0 : ($total_sales_values_per_year - $total_previous_year)/$total_previous_year *100;
                                        ?>
                                        <tr class="table-active text-center odd">
                                            <th><?php echo e(__('Total')); ?></th>
                                            
                                            <td>100%</td>
                                        </tr>
                                        <?php $total_previous_year=$total_sales_values_per_year;?>
                                    <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                            </div>


                            <div class="col-md-6">

                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => 'Quarterly Seasonality Table','tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                    <?php $__env->slot('table_header'); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Quarter')); ?></th>
                                            <th><?php echo e(__('Quarter Sales %')); ?></th>
                                        </tr>
                                    <?php $__env->endSlot(); ?>
                                    <?php $__env->slot('table_body'); ?>
                                        <?php $sum_totals = array_sum($total_full_data); ?>
                                            <tr class="text-center">
                                                <td><?php echo e(__('Quarter One (Jan / Feb / Mar)')); ?></td>
                                                <td> <?php echo e(sumBasedOnQuarterNumber($total_full_data , ['January','February','March']  , $sum_totals)); ?> </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><?php echo e(__('Quarter Two (Apr / May / Jun)')); ?></td>
                                                <td> <?php echo e(sumBasedOnQuarterNumber($total_full_data , ['April','May','June'] , $sum_totals)); ?> </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><?php echo e(__('Quarter Three (Jul / Aug / Sep)')); ?></td>
                                                <td> <?php echo e(sumBasedOnQuarterNumber($total_full_data , ['July','August','September'] , $sum_totals)); ?> </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><?php echo e(__('Quarter Four (Oct / Nov / Dec)')); ?></td>
                                                <td><?php echo e(sumBasedOnQuarterNumber($total_full_data , ['October','November','December'] , $sum_totals)); ?></td>
                                            </tr>

                                            <tr class="table-active text-center odd">
                                            <th><?php echo e(__('Total')); ?></th>
                                            <td>100%</td>
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







                    
                 




                    <input type="hidden" id="monthly_data" data-total="<?php echo e(json_encode($chart_data??[])); ?>">
                    <input type="hidden" id="accumulated_data" data-total="<?php echo e(json_encode($accumulated_chart_data??[])); ?>">
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/sales_report/comparing_sales_report.blade.php ENDPATH**/ ?>