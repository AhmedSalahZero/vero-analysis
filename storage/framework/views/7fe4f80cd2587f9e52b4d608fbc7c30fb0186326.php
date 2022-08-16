<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
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

    

    <!--begin: Datatable -->

    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination ']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $main_type));  ?>
                <th><?php echo e(__($main_type_name)); ?></th>
                 
                <?php for($i = 1 ; $i <= count($data) ; $i++): ?>
                <?php $__currentLoopData = ['Rank [ '.$i.' ] '.ucwords(str_replace('_', ' ', $type))  , 'Percentage %' , 'Value' , 'Percentage %']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($item)); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php endfor; ?> 
                
                
                    
                

            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
            
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchName => $statistics): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
                <tr>
                    <th> <?php echo e(__($branchName)); ?> </th>
        <?php for($rankNumber = 1 ;$rankNumber <= count($data) ; $rankNumber++ ): ?>
        
        <?php $totalForBranch = countTotalForBranch($data[$branchName]) ?> 
        <?php $allRanksTotals =  countSumForAllRank($data , $rankNumber) ?> 

                        <td class="text-center">
                            
                            

                                <button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_<?php echo e(str_replace(' ' , '-' , $branchName) . $rankNumber); ?>"> 

                                <?php echo e($countItemsPerBranch = (isset($statistics[$rankNumber]) ? count($statistics[$rankNumber]) : 0)); ?>

                            </button>


                               <div class="modal " id="kt_modal_<?php echo e(str_replace(' ' , '-' , $branchName) . $rankNumber); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="text-align: left !important" class="modal-title " id="exampleModalLongTitle">
                                                <?php echo e($branchName . ' [ ' . $rankNumber . ' ]'); ?>

                                            </h5>
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
                                                        <tr class="table-active ">

                                                            <th style="text-align: left !important"><?php echo e(__('Product Name ')); ?></th>
                                                            <th><?php echo e(__('Sales Values')); ?></th>
                                                        </tr>
                                                    <?php $__env->endSlot(); ?>
                                                    <?php $__env->slot('table_body'); ?>
                                                                <?php $produtNumber = 0;$dataForRankings = $data[$branchName][$rankNumber] ?? [];
                                                                orderTotalsForRanking($dataForRankings);
                                                                 ?> 
                                                                
                                                                <?php $__currentLoopData = $dataForRankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productName=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>

                                                                <td> <?php echo e(++$produtNumber); ?> - <?php echo e($productName); ?></td>
                                                                <td><?php echo e(number_format($val['total'] ?? 0)); ?></td>
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                        </div>
                                    </div>
                                </div>
                              </div>  

                              

                        </td>
                        

 <td class="text-center">

     <?php echo e(number_format(($countItemsPerBranch / $totalForBranch) * 100 , 1)); ?>  % 
                             
                        </td>

                         <td class="text-center">
                             <?php echo e(isset($statistics[$rankNumber]) ? number_format(array_sum(flatten($statistics[$rankNumber])) , 0 ) : 0); ?>

                        </td>


                            <td class="text-center">
                                
                             <?php echo e(isset($statistics[$rankNumber]) && $allRanksTotals['values'] ? number_format( (array_sum(flatten($statistics[$rankNumber])) / $allRanksTotals['values'])*100 , 1 ) : 0); ?> % 

                            
                        </td>


                        
            <?php endfor; ?> 
                        


                    




                   

                </tr>


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                 <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchName => $statistics): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php for($rankNumber = 1 ;$rankNumber <= count($data) ; $rankNumber++ ): ?>
                <?php $allRanksTotals =  countSumForAllRank($data , $rankNumber) ?> 
                
                    <td class="text-center">
                        <?php echo e($allRanksTotals['total']); ?>

                    </td>

                   

                      <td class="text-center">
                
                    </td>

                       <td class="text-center">
                        <?php echo e(number_format($allRanksTotals['values'] , 0)); ?>

                    </td>

                    <td class="text-center">
                
                    </td>


                    <?php endfor; ?> 

                    <?php break; ?> 

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                
                    
                
            </tr>


            
            
        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

    <!--end: Datatable -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/two_dimensional_breakdown/sales_ranking_report.blade.php ENDPATH**/ ?>