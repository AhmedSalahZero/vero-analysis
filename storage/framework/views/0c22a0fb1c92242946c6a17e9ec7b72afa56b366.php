<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<?php
use \App\Models\TimeOfDeposit;
?>
<style>
    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 200px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Time Of Deposit ' )); ?> [<?php echo e($financialInstitution->getName()); ?>]
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == TimeOfDeposit::RUNNING ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(TimeOfDeposit::RUNNING); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Running Time Of Deposit')); ?>

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == TimeOfDeposit::MATURED ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(TimeOfDeposit::MATURED); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Matured Time Of Deposit')); ?>

                    </a>
                </li>
				
				
				 <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == TimeOfDeposit::BROKEN ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(TimeOfDeposit::BROKEN); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Broken Time Of Deposit')); ?>

                    </a>
                </li>
				


            </ul>
<?php if(hasAuthFor('create time of deposit')): ?>
           <div class="flex-tabs">
		    <a href="<?php echo e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])); ?>" class="btn  active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                <?php echo e(__('New Record')); ?>

            </a>
		   </div>
		   <?php endif; ?> 
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
			<?php
				$currentType = TimeOfDeposit::RUNNING ;
			?>
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == $currentType  ? 'active'  :  ''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentType,'title' => __('Running Time Of Deposit'),'startDate' => $filterDates[$currentType]['startDate']??'','endDate' => $filterDates[$currentType]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Running Time Of Deposit')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-time-of-deposit','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields[$currentType],'moneyReceivedType' => $currentType,'hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-time-of-deposit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentType]),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Intreset Rate')); ?></th>
                                    <th><?php echo e(__('Interest Amount')); ?></th>
                                    <th><?php echo e(__('Blocked Against')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td class="text-nowrap"><?php echo e($model->getStartDateFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($model->getEndDateFormatted()); ?></td>
                                    <td><?php echo e($model->getAccountNumber()); ?></td>
                                    <td><?php echo e($model->getAmountFormatted()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getCurrency()); ?></td>
                                    <td><?php echo e($model->getInterestRateFormatted()); ?></td>
                                    <td><?php echo e($model->getInterestAmountFormatted()); ?></td>
                                    <td><?php echo e($model->getBlockedAgainstFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">


                                        <span style="overflow: visible; position: relative; width: 110px;">
											<?php if(hasAuthFor('create time of deposit')): ?>
                                            <a
											
											 data-toggle="modal" data-target="#apply-deposit-modal-<?php echo e($model->id); ?>" type="button" class="btn 
											 
											 <?php if($model->isDueTodayOrGreater()): ?>
											 disabled 
											<?php endif; ?> 
											 
											  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Apply Deposit')); ?>" href="#"><i class="fa fa-coins"></i></a>
											 
                                            <div class="modal fade" id="apply-deposit-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('apply.deposit.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Apply Deposit To This Time Of Deposit ?')); ?></h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">

                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Interest Amount')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="<?php echo e($model->isMatured() ? $model->getActualInterestAmount() : $model->getInterestAmount()); ?>" type="text" name="actual_interest_amount" class="form-control only-greater-than-or-equal-zero-allowed">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Deposit Date')); ?></label>
                                                                        <div class="kt-input-icon">
                                                                            <div class="input-group date">
                                                                                <input required type="text" name="deposit_date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-calendar-check-o"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>




                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											
											
											
											 <?php endif; ?> 
											
											
												<?php if(hasAuthFor('create time of deposit')): ?>
											<a data-toggle="modal" data-target="#apply-break-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-danger   btn-icon" title="<?php echo e(__('Break')); ?>" href="#"><i class="fa fa-ban"></i></a>
                                            <div class="modal fade" id="apply-break-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('apply.break.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Break This Time Of Deposit ?')); ?></h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">

                                                                   

                                                                    <div class="col-md-2 mb-4">
                                                                        <label><?php echo e(__('Break Date')); ?></label>
                                                                        <div class="kt-input-icon">
                                                                            <div class="input-group date">
                                                                                <input required type="text" name="break_date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-calendar-check-o"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																	
																	
																	 <div class="col-md-3 mb-4">
                                                                        <label><?php echo e(__('Amount')); ?> </label>
                                                                        <div class="kt-input-icon">
																			<input type="hidden" name="amount" value="<?php echo e($model->getAmount()); ?>" >
                                                                            <input disabled value="<?php echo e($model->getAmountFormatted()); ?>" type="text"  class="form-control only-greater-than-or-equal-zero-allowed">
                                                                        </div>
                                                                    </div>
																	
																	
																		 <div class="col-md-3 mb-4">
                                                                        <label><?php echo e(__('Break Interest Amount')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input name="break_interest_amount" value="<?php echo e(0); ?>" type="text"  class="form-control only-greater-than-or-equal-zero-allowed">
                                                                        </div>
                                                                    </div>
																	
																	 <div class="col-md-3 mb-4">
                                                                        <label><?php echo e(__('Break Charge Amount')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input name="break_charge_amount" value="<?php echo e(0); ?>" type="text"  class="form-control only-greater-than-or-equal-zero-allowed">
                                                                        </div>
                                                                    </div>
																	
																	



                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
											

	<?php if(hasAuthFor('update time of deposit')): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											
												<?php if(hasAuthFor('delete time of deposit')): ?>
                                            <a data-toggle="modal" data-target="#delete-time-of-deposits-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
									



                                            <div class="modal fade" id="delete-time-of-deposits-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											
													<?php endif; ?> 
													
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			
			
			
			
			
			
			
			
			
			
					<?php
				$currentType = TimeOfDeposit::MATURED ;
			?>
            <div class="tab-pane <?php echo e(Request('active') == $currentType  ? 'active'  :  ''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentType,'title' => __('Matured Time Of Deposit'),'startDate' => $filterDates[$currentType]['startDate']??'','endDate' => $filterDates[$currentType]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Matured Time Of Deposit')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-time-of-deposit','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields[$currentType],'moneyReceivedType' => $currentType,'hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-time-of-deposit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentType]),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Intreset Rate')); ?></th>
                                    <th><?php echo e(__('Interest Amount')); ?></th>
                                    <th><?php echo e(__('Deposit Date')); ?></th>
                                    <th><?php echo e(__('Actual Interest Amount')); ?></th>
                                    <th><?php echo e(__('Blocked Against')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td class="text-nowrap"><?php echo e($model->getStartDateFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($model->getEndDateFormatted()); ?></td>
                                    <td><?php echo e($model->getAccountNumber()); ?></td>
                                    <td><?php echo e($model->getAmountFormatted()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getCurrency()); ?></td>
                                    <td><?php echo e($model->getInterestRateFormatted()); ?></td>
                                    <td><?php echo e($model->getInterestAmountFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($model->getDepositDateFormatted()); ?></td>
                                    <td><?php echo e($model->getActualInterestAmountFormatted()); ?></td>
									     <td><?php echo e($model->getBlockedAgainstFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">


                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a data-toggle="modal" data-target="#reverse-deposit-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Reverse Deposit')); ?>" href="#"><i class="fa fa-undo"></i></a>
                                            <div class="modal fade" id="reverse-deposit-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('reverse.deposit.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Send This Time To Running ?')); ?></h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

	
                                            



                                            
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			
			
			
			
			
			
			
			
			
			
			
			<?php
				$currentType = TimeOfDeposit::BROKEN ;
			?>
            <div class="tab-pane <?php echo e(Request('active') == $currentType  ? 'active'  :  ''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentType,'title' => __('Broken Time Of Deposit'),'startDate' => $filterDates[$currentType]['startDate']??'','endDate' => $filterDates[$currentType]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Broken Time Of Deposit')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-time-of-deposit','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields[$currentType],'moneyReceivedType' => $currentType,'hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-time-of-deposit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentType]),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('create.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Intreset Rate')); ?></th>
                                    <th><?php echo e(__('Interest Amount')); ?></th>
                                    <th><?php echo e(__('Deposit Date')); ?></th>
                                    <th><?php echo e(__('Actual Interest Amount')); ?></th>
                                    <th><?php echo e(__('Blocked Against')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td class="text-nowrap"><?php echo e($model->getStartDateFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($model->getEndDateFormatted()); ?></td>
                                    <td><?php echo e($model->getAccountNumber()); ?></td>
                                    <td><?php echo e($model->getAmountFormatted()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getCurrency()); ?></td>
                                    <td><?php echo e($model->getInterestRateFormatted()); ?></td>
                                    <td><?php echo e($model->getInterestAmountFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($model->getDepositDateFormatted()); ?></td>
                                    <td><?php echo e($model->getActualInterestAmountFormatted()); ?></td>
                                    <td><?php echo e($model->getBlockedAgainstFormatted()); ?></td>
									
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">


                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a data-toggle="modal" data-target="#reverse-broken-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Reverse Broken')); ?>" href="#"><i class="fa fa-undo"></i></a>
                                            <div class="modal fade" id="reverse-broken-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('reverse.broken.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Send This Time To Running ?')); ?></h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                      
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			
			










            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
<script>

</script>
<script>


</script>







<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'start_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Start Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        }
        //else if(searchFieldName === 'balance_date') {
        //     modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
        //     $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        // }
        else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/time-of-deposit/index.blade.php ENDPATH**/ ?>