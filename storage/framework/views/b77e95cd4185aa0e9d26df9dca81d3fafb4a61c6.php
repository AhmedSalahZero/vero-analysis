
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
.failed-td{
}
.success-td{
}
    .table-bordered.table-hover.table-checkable.dataTable.no-footer.fixedHeader-floating {
        display: none
    }

    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>
<style>
    table {
        white-space: nowrap;
    }

    .bg-table-head {
        background-color: #075d96;
        color: white !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" action="#" enctype="multipart/form-data">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label w-full "> 
                        <h3 class="kt-portlet__head-title head-title text-primary w-full">
                            <?php echo e(__('Failed Rows')); ?> <br>
							<span style="display: block;

    text-align: center;
    color: red;">
							 <?php echo e(__('Review and Correct mentioned errors in your excel and please upload your excel again')); ?>

							 
							</span>
                        </h3>
						
				
						
						<br>
						<h3 class="d-block"></h3>
						
                    </div>
					
                </div>
                  <div class="kt-portlet__body">

                                         
                                             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_fixed_right']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                <?php $__env->slot('table_header'); ?>
                                                    <tr class="table-active text-center">
                                                        <th><?php echo e(__('Row Number')); ?></th>
														<?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<th><?php echo e($header); ?></th>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                      
                                                    </tr>
                                                <?php $__env->endSlot(); ?>
                                                <?php $__env->slot('table_body'); ?>


                                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowNumber => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php
													?>
                                                        <tr>
															
															<th style="font-weight:bold;text-align:center;"> <?php echo e($rowNumber); ?> </th>
															<?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php
														$failed = isset($items[$header]['value']) ;
																
															?>
															<td class="<?php echo e($failed ? 'failed-td':'success-td'); ?>">
															<?php if($failed): ?>
															<?php echo e($items[$header]['message'] ??'-'); ?> [ <?php echo e($items[$header]['value'] ??'-'); ?> ]
															<?php else: ?>
															
															<?php endif; ?> 
															
															</td>
															
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
															
	
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                
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


        </form>
        <!--end::Form-->
        
        <!--end::Portlet-->
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/sales_gathering/failed.blade.php ENDPATH**/ ?>