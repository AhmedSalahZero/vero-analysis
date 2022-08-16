
<?php
$TheMainSectionTitle = @explode('Sales', Request()->segments()[count(Request()->segments()) - 2])[0] ?? '' ;

 ?>

<?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => $TheMainSectionTitle . __(' Seasonality Sales Trend Analysis Report'),'tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active">
                                <th><?php echo e($TheMainSectionTitle); ?></th>
                                
                                <?php $__currentLoopData = $total_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
                                    <?php if($loop->last): ?>
                                    <th><?php echo e(__('Total')); ?></th>
                                    <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
     
                            <?php $__currentLoopData = $final_report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone_name => $zoone_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            
                              
                              
                              
                              
                              
                              

                              

                              
                                <tr class="group-color text-lg-left  ">
                                    <td colspan="<?php echo e(count($total_branches) + 2); ?>"><b
                                            class="white-text"><?php echo e(__($zone_name)); ?></b>
                                    </td>
                                    <?php $__currentLoopData = $total_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="hidden"> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Seasonality %')); ?></th>
                                         <?php $totalSum = array_sum($zoone_data['Sales Values'])  ?>
                                         <?php   $totals = 0 ;  ?>
                                    <?php $__currentLoopData = $total_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            
                                            
                                            
                                            
                                            <?php $totals = $totals + ($totalss = number_format(isset($zoone_data['Sales Values'][$date])  && $totalSum  ? (($zoone_data['Sales Values'][$date] / $totalSum)*100      ) : 0,2) )  ?>
                                            
                                            <?php 

                                            if (isset($totalArrys[$date]['value']))
                                            {
                                               
                                                $totalArrys[$date]['value'] = $totalArrys[$date]['value'] + (isset(($zoone_data['Sales Values'][$date])) ? ($zoone_data['Sales Values'][$date]) : 0)  ;
                                                $totalArrys[$date]['total'] = $totalArrys[$date]['total'] +  array_sum(isset($zoone_data['Sales Values']) ? $zoone_data['Sales Values'] : [])  ;
                                               
                                            }
                                            else
                                            {
                                                $totalArrys[$date]['value'] = (isset($zoone_data['Sales Values'][$date])) ?$zoone_data['Sales Values'][$date] : 0 ;
                                                $totalArrys[$date]['total'] =   array_sum(isset($zoone_data['Sales Values']) ? $zoone_data['Sales Values'] : []) ;
                                                
                                            }

                                            
                                            
                                            
                                            
                                            
                                            ?>
                                          
                                                
                                            <?php echo e(number_format($totalss , 2)); ?> %


                                         
                                        
                                        </td>
                                         <?php if($loop->last): ?>
                                         <td class="text-center">
                                            <?php echo e(number_format($totals )); ?> %
                                        </td>
                                         <?php endif; ?> 

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                            <tr>
                                <th class="active-style text-center"><?php echo e(__('TOTAL')); ?></th>
                                <?php $__currentLoopData = $totalArrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="text-center active-style"><?php echo e(isset($total['total']) && $total['total'] ? number_format($total['value']/ $total['total'] * 100 , 2) : 0); ?> %</td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                          

                        <?php $__env->endSlot(); ?>
                       <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/seasonality_table.blade.php ENDPATH**/ ?>