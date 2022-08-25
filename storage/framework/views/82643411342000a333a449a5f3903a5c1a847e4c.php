
<?php $__env->startSection('css'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css"/>


    
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<style>
    .table-active .dtfc-fixed-left,
    .table-active .dtfc-fixed-right
    {
 background-color:#086691 !important;
color: white !important;

    }
</style>

<?php echo $__env->make('datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__($view_name)); ?>

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



    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                </span>
                <h3 class="kt-portlet__head-title">

                    <b> <?php echo e(__('From : ')); ?> </b><?php echo e($dates['start_date']); ?>

                    <b> - </b>
                    <b> <?php echo e(__('To : ')); ?></b> <?php echo e($dates['end_date']); ?>

                    <br>

                    <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b> <?php echo e($last_date); ?></span>

                </h3>
            </div>

        </div>
    </div>

    

    <!--Sales Values Table -->
    <?php
    // dd();
$startTime = microtime(true);
        $getIterableTimes = getIterableItems(array_merge($customersNaturesActive , $customersNaturesDead));

    ?>



    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Sales Values Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th><?php echo e(__($main_type_name) . ' / ' . __('Customers Natures')); ?></th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportType=>$reportDataArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($reportType)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e(__('Total'.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>
                <th><?php echo e(__('% / Total'.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>

                   <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportType=>$reportDataArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($reportType)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
        <?php
        // dd();
        $totalForTotalSales = calcTotalsForTotalsActiveItems($customersNaturesActive , 'total_sales') ;
        ?> 
        
        <?php $__currentLoopData = $getIterableTimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainTypeItem=>$totalPerType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th> <?php echo e(__($mainTypeItem)); ?> </th>
                    <?php
                        $totalForActiveRaw = 0 ;
                    ?>
                      <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainType => $mainTypeValueArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                                // $totalPerType = getTotalForThisType($customersNaturesActive , $mainTypeItem , 'total_sales') ;
                                $accumlatedValuesFor[$mainTypeItem][$mainType] = $value = sum_array_of_std_objectsForSubType($mainTypeValueArray[$mainTypeItem]??[]  ,'total_sales') ; 
                                $percentage_per_value = $totalPerType  == 0 ? 0 : ($value / $totalPerType) * 100;
                                $totalForActiveRaw += $value ;
                        ?>

                        <td class="text-center"> <?php echo e(number_format($value)); ?> ---------------- <?php echo e($totalPerType); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <td class="text-center">
                        <?php echo e(number_format($totalForActiveRaw)); ?>

                    </td>
                    <td class="text-center">
                        <span class="active-text-color text-center"><b> <?php echo e($totalForTotalSales ? number_format(($totalForActiveRaw/$totalForTotalSales)*100, 1) . ' % '  : 0); ?></b></span>
                    </td>
                    <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainType => $mainTypeValueArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                    //   year for $customersNaturesActive not $customersNaturesDead
                                $totalPerType = getTotalForThisType($customersNaturesActive , $mainTypeItem , 'total_sales') ;
                                  $accumlatedValuesFor[$mainTypeItem][$mainType]  = $value = sum_array_of_std_objectsForSubType($mainTypeValueArray[$mainTypeItem]??[]  ,'total_sales') ; 
                               $percentage_per_value = $totalPerType  == 0 ? 0 : ($value / $totalPerType) * 100;
                        ?>

                        <td class="text-center"> <?php echo e(number_format($value)); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


             <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   $totalForVerticalTypes[$keyy] = getTotalForSingleType($customersNaturesActive[$keyy] ?? [] , 'total_sales');


               ?>
                    <td class="text-center">
                        <?php echo e($totalForVerticalTypes[$keyy] ? number_format($totalForVerticalTypes[$keyy]) : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                <td class="text-center"><?php echo e(number_format($totalForTotalSales)); ?></td>
                <td class="text-center"><b><?php echo e('100 %'); ?></b></td>
              

                  <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   $totalForVerticalTypes[$keyy] = getTotalForSingleType($customersNaturesDead[$keyy] ?? [] , 'total_sales');
               ?>

               
                    <td class="text-center">
                        <?php echo e($totalForVerticalTypes[$keyy] ? number_format($totalForVerticalTypes[$keyy]) : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>




             <tr class="table-active text-center">
                <th class="text-center"> <?php echo e('Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?> </th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                      <?php echo e($totalForTotalSales ? number_format($totalForVerticalTypes[$keyy]  / $totalForTotalSales * 100 , 1 ) . ' %'  : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                <td class="text-center"><?php echo e('100 %'); ?></td>
                <td class="text-center"><b>-</b></td>
              

                  <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   
               ?>

               
                    <td class="text-center">
                        <?php echo e($totalForTotalSales ? number_format($totalForVerticalTypes[$keyy]  / $totalForTotalSales * 100 , 1 ) . ' %'  : 0); ?>

                    
                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>

        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>















     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Counts Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th><?php echo e(__($main_type_name) . ' / ' . __('Customers Natures')); ?></th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportType=>$reportDataArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($reportType)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e(__('Total'.($type ==  'discounts' ? 'Discounts' : 'Count'))); ?></th>
                <th><?php echo e(__('% / Total'.($type ==  'discounts' ? 'Discounts' : 'Count'))); ?></th>

                   <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportType=>$reportDataArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($reportType)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
        <?php
        $totalForTotalSales = countTotalsForTotalsActiveItems($customersNaturesActive , 'no_customers') ;
        ?> 
        <?php $__currentLoopData = $getIterableTimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainTypeItem=>$totalPerType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th> <?php echo e(__($mainTypeItem)); ?> </th>
                    <?php
                        $totalForActiveRaw = 0 ;
                    ?>
                      <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainType => $mainTypeValueArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                                $totalPerType = countTotalForThisType($customersNaturesActive , $mainTypeItem ) ;
                                $value = count_array_of_std_objects($mainTypeValueArray[$mainTypeItem]??[]  ) ; 
                                $percentage_per_value = $totalPerType  == 0 ? 0 : ($value / $totalPerType) * 100;
                                $totalForActiveRaw += $value ;
                   
                                
                        ?>
                         <td class="text-center"><button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_<?php echo e(str_replace(["/" ,' ','&' ] , '-' , $mainTypeItem) . str_replace(["/" ,' ','&'] , '-' , $mainType)); ?>"> 
                                        <?php echo e($value); ?>


                                        </button>
                                        
                                          <div class="modal fade" id="kt_modal_<?php echo e(str_replace(["/" ,' ' ,'&'] , '-' , $mainTypeItem) . str_replace(["/" ,' ' ,'&'] , '-' , $mainType)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e($mainTypeItem); ?> <?php echo e($mainType); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                                <?php $__env->slot('table_header'); ?>
                                                                    <tr class="table-active text-center">

                                                                        <th><?php echo e(__('Customer Name')); ?></th>
                                                                        <th><?php echo e(__('Sales')); ?></th>
                                                                        <th><?php echo e(__('Percentage')); ?></th>
                                                                    </tr>
                                                                <?php $__env->endSlot(); ?>
                                                                <?php $__env->slot('table_body'); ?>
                                                                <?php
                                                                    $totalForModalItem = 0; 
                                                                ?>
                                                                <?php $__currentLoopData = $customersNaturesActive[$mainType][$mainTypeItem] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iterationModalItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo e($iterationModalItem->customer_name); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo e(number_format($iterationModalItem->total_sales)); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo e($accumlatedValuesFor[$mainTypeItem][$mainType] ? (number_format($iterationModalItem->total_sales / $accumlatedValuesFor[$mainTypeItem][$mainType] *100  , 1) . ' %') : 0); ?>

                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                                <tr class="table-active text-center">
                                                                    <td>
                                                                            -
                                                                    </td>
                                                                    <td>

                                                                        <?php echo e($accumlatedValuesFor[$mainTypeItem][$mainType] ?  number_format($accumlatedValuesFor[$mainTypeItem][$mainType]) : 0); ?>

                                                                    </td>
                                                                    <td>
                                                                        100 %
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </td>

                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <td class="text-center">
                        <?php echo e(($totalForActiveRaw)); ?>

                    </td>
                    <td class="text-center">
                        <span class="active-text-color text-center"><b> <?php echo e($totalForTotalSales ? number_format(($totalForActiveRaw/$totalForTotalSales)*100, 1) . ' % '  : 0); ?></b></span>
                    </td>
                    <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainType => $mainTypeValueArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                    //   yes for $customersNaturesActive not for $customersNaturesDead
                                $totalPerType = countTotalForThisType($customersNaturesActive , $mainTypeItem) ;
                               $value = count_array_of_std_objects($mainTypeValueArray[$mainTypeItem]??[] ) ; 
                               $percentage_per_value = $totalPerType  == 0 ? 0 : ($value / $totalPerType) * 100;
                        ?>

                           <td class="text-center"><button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_<?php echo e(str_replace(["/" ,' ','&' ] , '-' , $mainTypeItem) . str_replace(["/" ,' ','&'] , '-' , $mainType)); ?>"> 
                                        <?php echo e($value); ?>


                                        </button>
                                        
                                          <div class="modal fade" id="kt_modal_<?php echo e(str_replace(["/" ,' ' ,'&'] , '-' , $mainTypeItem) . str_replace(["/" ,' ' ,'&'] , '-' , $mainType)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e($mainTypeItem); ?> <?php echo e($mainType); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                                <?php $__env->slot('table_header'); ?>
                                                                    <tr class="table-active text-center">

                                                                        <th><?php echo e(__('Customer Name')); ?></th>
                                                                        <th><?php echo e(__('Sales')); ?></th>
                                                                        <th><?php echo e(__('Percentage')); ?></th>
                                                                    </tr>
                                                                <?php $__env->endSlot(); ?>
                                                                <?php $__env->slot('table_body'); ?>
                                                                <?php
                                                                    $totalForModalItem = 0; 
                                                                ?>
                                                                <?php $__currentLoopData = $customersNaturesDead[$mainType][$mainTypeItem] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iterationModalItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo e($iterationModalItem->customer_name); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo e(number_format($iterationModalItem->total_sales)); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo e($accumlatedValuesFor[$mainTypeItem][$mainType] ? (number_format($iterationModalItem->total_sales / $accumlatedValuesFor[$mainTypeItem][$mainType] *100  , 1) . ' %') : 0); ?>

                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                                <tr class="table-active text-center">
                                                                    <td>
                                                                            -
                                                                    </td>
                                                                    <td>

                                                                        <?php echo e($accumlatedValuesFor[$mainTypeItem][$mainType] ?  number_format($accumlatedValuesFor[$mainTypeItem][$mainType]) : 0); ?>

                                                                    </td>
                                                                    <td>
                                                                        100 %
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </td>

                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


             <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   $totalForVerticalTypes[$keyy] = countTotalForSingleType($customersNaturesActive[$keyy] ?? [] );
               ?>
                    <td class="text-center">
                        <?php echo e($totalForVerticalTypes[$keyy] ? ($totalForVerticalTypes[$keyy]) : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td class="text-center"><?php echo e(($totalForTotalSales)); ?></td>
                <td class="text-center"><b><?php echo e('100 %'); ?></b></td>
              

                  <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   $totalForVerticalTypes[$keyy] = countTotalForSingleType($customersNaturesDead[$keyy] ?? [] );
               ?>

               
                    <td class="text-center">
                        <?php echo e($totalForVerticalTypes[$keyy] ? ($totalForVerticalTypes[$keyy]) : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>

             <tr class="table-active text-center">
                <th class="text-center"> <?php echo e('Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Count'))); ?> </th>
                <?php $__currentLoopData = $customersNaturesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                      <?php echo e($totalForTotalSales ? number_format($totalForVerticalTypes[$keyy]  / $totalForTotalSales * 100 , 1 ) . ' %'  : 0); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                <td class="text-center"><?php echo e('100 %'); ?></td>
                <td class="text-center"><b>-</b></td>
              

                  <?php $__currentLoopData = $customersNaturesDead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyy=>$item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                   
               ?>

               
                    <td class="text-center">
                        <?php echo e($totalForTotalSales ? number_format($totalForVerticalTypes[$keyy]  / $totalForTotalSales * 100 , 1 ) . ' %'  : 0); ?>

                    
                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>

        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
    

     <!--Counts Table -->








     
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/customer_nature/two_dimensional_report.blade.php ENDPATH**/ ?>