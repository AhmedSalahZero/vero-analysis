<?php $__env->startSection('css'); ?>
<?php
use App\Models\MoneyReceived;
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
	th:not(.bank-max-width),
	td:not(.bank-max-width){
		text-wrap:nowrap !important;
	}
</style>
<style>
    button[type="submit"],
    button[type="button"] {
        font-size: 1rem !important;

    }

    button[type="submit"] {
        background-color: green !important;
        border: 1px solid green !important;
    }

    .kt-portlet__body {
        padding-top: 0 !important;
    }

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
<?php echo e(__('Money Received Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == MoneyReceived::CHEQUE ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CHEQUE); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Cheques In Safe')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::CHEQUE_UNDER_COLLECTION ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CHEQUE_UNDER_COLLECTION); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Cheques Under Collection')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::CHEQUE_COLLECTED ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CHEQUE_COLLECTED); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Collected Cheques')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::CHEQUE_REJECTED ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CHEQUE_REJECTED); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Rejected Cheques')); ?>

                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::INCOMING_TRANSFER ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i><?php echo e(__('Incoming Transfer')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::CASH_IN_SAFE ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i><?php echo e(__('Cash In Safe')); ?>

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == MoneyReceived::CASH_IN_BANK ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CASH_IN_BANK); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i><?php echo e(__('Bank Deposit')); ?>

                    </a>
                </li>

            </ul>
			<?php if(auth()->user()->can('create money received')): ?>
            <div class="flex-tabs">
			
			<a href="<?php echo e(route('create.money.receive',['company'=>$company->id])); ?>" class="btn  btn-sm active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                <?php echo e(__('Money Received')); ?>

            </a>
			
			  <a href="<?php echo e(route('create.money.receive',['company'=>$company->id,'type'=>'down-payment'])); ?>" class="btn btn-sm active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                <?php echo e(__('Down Payment')); ?>

            </a>
			</div>
			<?php endif; ?> 
        </div>
    </div>
    
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <!--Begin:: Tab Content-->
            
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == MoneyReceived::CHEQUE ?'active':''); ?>" id="<?php echo e(MoneyReceived::CHEQUE); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CHEQUE,'title' => __('Cheques In Safe'),'startDate' => $filterDates[MoneyReceived::CHEQUE]['startDate']??'','endDate' => $filterDates[MoneyReceived::CHEQUE]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cheques In Safe')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $chequesReceivedTableSearchFields,'moneyReceivedType' => MoneyReceived::CHEQUE,'hasSearch' => 1,'hasBatchCollection' => 1,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chequesReceivedTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE),'has-search' => 1,'has-batch-collection' => 1,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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

                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="align-middle"><?php echo e(__('Select')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Type')); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th class="align-middle"><?php echo __('Receiving<br>Date'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque<br>Number'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque<br>Amount'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Currency')); ?></th>
                                    <th class="align-middle bank-max-width" ><?php echo e(__('Drawee Bank')); ?></th>
                                    <th class="align-middle"><?php echo __('Due<br>Date'); ?></th>
                                    <th class="align-middle"><?php echo __('Due <br> After Days'); ?></th>
                                    <th class="align-middle"><?php echo __('Status'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $receivedChequesInSafe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input style="max-height:25px;" id="cash-send-to-collection<?php echo e($moneyReceived->id); ?>" type="checkbox" name="second_to_collection[]" value="<?php echo e($moneyReceived->id); ?>" data-money-type="<?php echo e(MoneyReceived::CHEQUE); ?>" class="form-control checkbox js-send-to-collection">
                                    </td>
                                    <td><?php echo e($moneyReceived->getMoneyTypeFormatted()); ?></td>
                                    <td class="text-wrap bank-max-width"><?php echo e($moneyReceived->getCustomerName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($moneyReceived->getReceivingDateFormatted()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getChequeNumber()); ?></td>
                                    <td><?php echo e($moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td class="text-transform" data-currency="<?php echo e($moneyReceived->getCurrency()); ?>"><?php echo e($moneyReceived->getCurrencyToReceivingCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getDraweeBankName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($moneyReceived->cheque->getDueDateFormatted()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getDueAfterDays()); ?></td>
									<?php
										$dueStatus = $moneyReceived->cheque->getDueStatusFormatted() ;
									?>
									
                                    <td class="font-weight-bold" style="color:<?php echo e($dueStatus['color']); ?>!important"><?php echo e($dueStatus['status']); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											<?php if(auth()->user()->can('update money received')): ?>
											<?php echo $__env->make('reports._review_modal',['model'=>$moneyReceived], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php if(!$moneyReceived->isOpenBalance()): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
                                            <a data-id="<?php echo e($moneyReceived->id); ?>" data-type="single" data-currency="<?php echo e($moneyReceived->getCurrency()); ?>" data-money-type="<?php echo e(MoneyReceived::CHEQUE); ?>" data-toggle="modal" data-target="#send-to-under-collection-modal<?php echo e(MoneyReceived::CHEQUE); ?>" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-primary btn-icon" title="<?php echo e(__('Send Under Collection')); ?>" href=""><i class="fa fa-money-bill"></i></a>
											<?php endif; ?> 
											
											<?php if(auth()->user()->can('delete money received')): ?>
                                            <a data-toggle="modal" data-target="#delete-cheque-id-<?php echo e($moneyReceived->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-<?php echo e($moneyReceived->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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




            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::CHEQUE_REJECTED ?'active':''); ?>" id="<?php echo e(MoneyReceived::CHEQUE_REJECTED); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CHEQUE_REJECTED,'title' => __('Rejected Cheques'),'startDate' => $filterDates[MoneyReceived::CHEQUE_REJECTED]['startDate']??'','endDate' => $filterDates[MoneyReceived::CHEQUE_REJECTED]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_REJECTED),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Rejected Cheques')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_REJECTED]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_REJECTED]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $chequesRejectedTableSearchFields,'moneyReceivedType' => MoneyReceived::CHEQUE_REJECTED,'hasSearch' => 1,'hasBatchCollection' => 1,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chequesRejectedTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_REJECTED),'has-search' => 1,'has-batch-collection' => 1,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                                    <th><?php echo e(__('Select')); ?></th>

                                    <th><?php echo e(__('Type')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Receiving Date')); ?></th>
                                    <th><?php echo e(__('Cheque Number')); ?></th>
                                    <th><?php echo e(__('Cheque Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Drawee Bank')); ?></th>
                                    <th><?php echo e(__('Due Date')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $receivedRejectedChequesInSafe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input style="max-height:25px;" id="cash-send-to-collection<?php echo e($moneyReceived->id); ?>" type="checkbox" name="second_to_collection[]" value="<?php echo e($moneyReceived->id); ?>" class="form-control checkbox js-send-to-collection" data-money-type="<?php echo e(MoneyReceived::CHEQUE_REJECTED); ?>">
                                    </td>
									   <td><?php echo e($moneyReceived->getMoneyTypeFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->getCustomerName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($moneyReceived->getReceivingDateFormatted()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getChequeNumber()); ?></td>
                                    <td><?php echo e($moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td class="text-transform" data-currency="<?php echo e($moneyReceived->getCurrency()); ?>"><?php echo e($moneyReceived->getCurrencyToReceivingCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getDraweeBankName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($moneyReceived->cheque->getDueDateFormatted()); ?></td>
                                    <td> <?php echo e($moneyReceived->cheque->getStatusFormatted()); ?> </td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											<?php if(!$moneyReceived->isOpenBalance()): ?>
											<?php if(auth()->user()->can('update money received')): ?>
											<?php echo $__env->make('reports._review_modal',['model'=>$moneyReceived], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php endif; ?> 
                                            <a data-id="<?php echo e($moneyReceived->id); ?>" data-type="single" data-currency="<?php echo e($moneyReceived->getCurrency()); ?>" data-id="<?php echo e($moneyReceived->id); ?>" data-money-type="<?php echo e(MoneyReceived::CHEQUE_REJECTED); ?>" data-toggle="modal" data-target="#send-to-under-collection-modal<?php echo e(MoneyReceived::CHEQUE_REJECTED); ?>" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-primary btn-icon" title="<?php echo e(__('Send Under Collection')); ?>" href=""><i class="fa fa-money-bill"></i></a>
											<?php if(!$moneyReceived->isOpenBalance()): ?>
											<?php if(auth()->user()->can('delete money received')): ?>
                                            <a data-toggle="modal" data-target="#delete-cheque-id-<?php echo e($moneyReceived->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-<?php echo e($moneyReceived->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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






            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::CHEQUE_UNDER_COLLECTION ? 'active':''); ?>" id="<?php echo e(MoneyReceived::CHEQUE_UNDER_COLLECTION); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CHEQUE_UNDER_COLLECTION,'title' => __('Cheques Under Collection'),'startDate' => $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['startDate']??'','endDate' => $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_UNDER_COLLECTION),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cheques Under Collection')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $chequesUnderCollectionTableSearchFields,'moneyReceivedType' => MoneyReceived::CHEQUE_UNDER_COLLECTION,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chequesUnderCollectionTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_UNDER_COLLECTION),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">

                                    <th class="align-middle"><?php echo __('Type'); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo __('Customer Name'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque <br> Number'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque <br> Amount'); ?></th>
                                    <th class="align-middle"><?php echo __('Deposit <br> Date'); ?></th>
                                    <th class="bank-max-width align-middle"><?php echo e(__('Drawal Bank')); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo __('Account <br> Type'); ?></th>
                                    <th class="align-middle"><?php echo __('Account <br> Number'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque <br> Due Date'); ?></th>
                                    <th class="align-middle"><?php echo __('Clearance <br>Days'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque Expected <br> Collection Date'); ?></th>
                                    <th class="align-middle"><?php echo __('Status'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $receivedChequesUnderCollection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
  									 <td><?php echo e($moneyReceived->getMoneyTypeFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->getCustomerName()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getChequeNumber()); ?></td>
                                    <td><?php echo e($moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->getDepositDateFormatted()); ?> </td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getDrawlBankName()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getAccountTypeName()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getAccountNumber()); ?></td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->getDueDateFormatted()); ?> </td>
                                    <td> <?php echo e($moneyReceived->cheque->getClearanceDays()); ?> </td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->chequeExpectedCollectionDateFormatted()); ?> </td>
										<?php
										$dueStatus = $moneyReceived->cheque->getDueStatusFormatted() ;
									?>
                                    <td class="font-weight-bold" style="color:<?php echo e($dueStatus['color']); ?>!important"><?php echo e($dueStatus['status']); ?></td>
                                

                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$moneyReceived->isOpenBalance()): ?>
										<?php if(auth()->user()->can('update money received')): ?>
										
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php endif; ?> 
											<?php if($moneyReceived->cheque->getDueStatus()): ?>
											
                                            <a data-toggle="modal" data-target="#apply-collection-modal-<?php echo e($moneyReceived->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Apply Collection')); ?>" href="#"><i class="fa fa-coins"></i></a>
                                            <div class="modal fade" id="apply-collection-modal-<?php echo e($moneyReceived->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('cheque.apply.collection',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Mark This Cheque To Be Collected  ?')); ?></h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Customr Name')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="<?php echo e($moneyReceived->getCustomerName()); ?>" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Cheque Number')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="<?php echo e($moneyReceived->cheque->getChequeNumber()); ?>" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Cheque Amount')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="<?php echo e($moneyReceived->getReceivedAmountFormatted()); ?>" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Due Date')); ?> </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="<?php echo e($moneyReceived->cheque->getDueDateFormatted()); ?>" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Collection Date')); ?></label>
                                                                        <div class="kt-input-icon">
                                                                            <div class="input-group date">
                                                                                <input required type="text" name="actual_collection_date"  class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-calendar-check-o"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4 mb-4">
                                                                        <label><?php echo e(__('Collection Fees')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                                                        <div class="kt-input-icon">
                                                                            <input required value="0" type="text" name="collection_fees" class="form-control" placeholder="<?php echo e(__('Collection Fees')); ?>">
                                                                        </div>
                                                                    </div>



                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success 
																submit-form-btn
																
																"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											
											<?php endif; ?> 
                                            <a type="button" class="btn  btn-secondary btn-outline-hover-warning   btn-icon" title="<?php echo e(__('Send In Safe')); ?>" href="<?php echo e(route('cheque.send.to.safe',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ])); ?>"><i class="fa fa-sync-alt"></i></a>
											<?php if($moneyReceived->cheque->getDueStatus()): ?>
											<?php if(auth()->user()->can('delete money received')): ?>
                                            <a type="button" class="btn  btn-secondary btn-outline-hover-danger   btn-icon" title="<?php echo e(__('Rejected')); ?>" href="<?php echo e(route('cheque.send.to.rejected.safe',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ])); ?>"><i class="fa fa-undo"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-<?php echo e($moneyReceived->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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



            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::CHEQUE_COLLECTED ? 'active':''); ?>" id="<?php echo e(MoneyReceived::CHEQUE_COLLECTED); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CHEQUE_COLLECTED,'title' => __('Collected Cheques'),'startDate' => $filterDates[MoneyReceived::CHEQUE_COLLECTED]['startDate']??'','endDate' => $filterDates[MoneyReceived::CHEQUE_COLLECTED]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_COLLECTED),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Collected Cheques')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_COLLECTED]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CHEQUE_COLLECTED]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $collectedChequesTableSearchFields,'moneyReceivedType' => MoneyReceived::CHEQUE_COLLECTED,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($collectedChequesTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CHEQUE_COLLECTED),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">

                                    <th class="align-middle"><?php echo e(__('Type')); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Cheque Number')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Cheque Amount')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Due Date')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Deposit Date')); ?></th>
                                    <th class="bank-max-width align-middle"><?php echo e(__('Drawal Bank')); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo e(__('Account Type')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Account Number')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Collection Fees')); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque Actual <br> Collection Date'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $collectedCheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
 									  <td ><?php echo e($moneyReceived->getMoneyTypeFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->getCustomerName()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getChequeNumber()); ?></td>
                                    <td><?php echo e($moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->getDueDateFormatted()); ?> </td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->getDepositDateFormatted()); ?> </td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getDrawlBankName()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->cheque->getAccountTypeName()); ?></td>
                                    <td><?php echo e($moneyReceived->cheque->getAccountNumber()); ?></td>
                                    <td> <?php echo e($moneyReceived->cheque->getCollectionFeesFormatted()); ?> </td>
                                    <td class="text-nowrap"> <?php echo e($moneyReceived->cheque->chequeActualCollectionDateFormatted()); ?> </td>
									<td>
										<?php if($moneyReceived->cheque->isCollected()): ?>
											 <a type="button" class="btn  btn-secondary btn-outline-hover-danger   btn-icon" title="<?php echo e(__('Under Collection')); ?>" href="<?php echo e(route('cheque.send.to.under.collection',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ])); ?>"><i class="fa fa-undo"></i></a>
											<?php endif; ?> 
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

            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::INCOMING_TRANSFER ? 'active':''); ?>" id="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::INCOMING_TRANSFER,'title' => __('Incoming Transfer'),'startDate' => $filterDates[MoneyReceived::INCOMING_TRANSFER]['startDate']??'','endDate' => $filterDates[MoneyReceived::INCOMING_TRANSFER]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::INCOMING_TRANSFER),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Incoming Transfer')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::INCOMING_TRANSFER]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::INCOMING_TRANSFER]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $incomingTransferTableSearchFields,'moneyReceivedType' => MoneyReceived::INCOMING_TRANSFER,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($incomingTransferTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::INCOMING_TRANSFER),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Receiving Date')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Receiving Bank')); ?></th>
                                    <th><?php echo e(__('Transfer Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Account Type')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $__currentLoopData = $receivedTransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $money): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
								   <td><?php echo e($money->getMoneyTypeFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getCustomerName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($money->getReceivingDateFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getIncomingTransferReceivingBankName()); ?></td>
                                    <td><?php echo e($money->getReceivedAmountFormatted()); ?></td>
                                    <td data-currency="<?php echo e($money->getCurrency()); ?>"> <?php echo e($money->getCurrencyToReceivingCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getIncomingTransferAccountTypeName()); ?></td>
                                    <td><?php echo e($money->getIncomingTransferAccountNumber()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$money->isOpenBalance()): ?>
										<?php if(auth()->user()->can('update money received')): ?>
										<?php echo $__env->make('reports._review_modal',['model'=>$money], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
<?php endif; ?> 
<?php if(!$money->isOpenBalance()): ?>
<?php if(auth()->user()->can('delete money received')): ?>
                                            <a data-toggle="modal" data-target="#delete-transfer-id-<?php echo e($money->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-<?php echo e($money->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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

            <!--End:: Tab Content-->


            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::CASH_IN_SAFE ? 'active':''); ?>" id="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CASH_IN_SAFE,'title' => __('Cash In Safe'),'startDate' => $filterDates[MoneyReceived::CASH_IN_SAFE]['startDate']??'','endDate' => $filterDates[MoneyReceived::CASH_IN_SAFE]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CASH_IN_SAFE),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash In Safe')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CASH_IN_SAFE]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CASH_IN_SAFE]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $cashInSafeReceivedTableSearchFields,'moneyReceivedType' => MoneyReceived::CASH_IN_SAFE,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cashInSafeReceivedTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CASH_IN_SAFE),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Receiving Date')); ?></th>
                                    <th><?php echo e(__('Branch')); ?></th>
                                    <th><?php echo e(__('Received Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Receipt Number')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $receivedCashesInSafe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($moneyReceived->getMoneyTypeFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($moneyReceived->getCustomerName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($moneyReceived->getReceivingDateFormatted()); ?></td>
                                    <td><?php echo e($moneyReceived->getCashInSafeBranchName()); ?></td>
                                    <td><?php echo e($moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td data-currency="<?php echo e($moneyReceived->getCurrency()); ?>"><?php echo e($moneyReceived->getCurrencyToReceivingCurrencyFormatted()); ?></td>
                                    <td><?php echo e($moneyReceived->getCashInSafeReceiptNumber()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$moneyReceived->isOpenBalance()): ?>
										
											<?php if(auth()->user()->can('update money received')): ?>
											<?php echo $__env->make('reports._review_modal',['model'=>$moneyReceived], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php if(auth()->user()->can('delete money received')): ?>
                                            <a data-toggle="modal" data-target="#delete-transfer-id-<?php echo e($moneyReceived->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-<?php echo e($moneyReceived->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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

            <!--End:: Tab Content-->






            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == MoneyReceived::CASH_IN_BANK ? 'active':''); ?>" id="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => MoneyReceived::CASH_IN_BANK,'title' => __('Bank Deposit'),'startDate' => $filterDates[MoneyReceived::CASH_IN_BANK]['startDate']??'','endDate' => $filterDates[MoneyReceived::CASH_IN_BANK]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CASH_IN_BANK),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Bank Deposit')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CASH_IN_BANK]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[MoneyReceived::CASH_IN_BANK]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-money','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $cashInBankTableSearchFields,'moneyReceivedType' => MoneyReceived::CASH_IN_BANK,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks,'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-money'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cashInBankTableSearchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(MoneyReceived::CASH_IN_BANK),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.money.receive',['company'=>$company->id])).'']); ?>
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
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Customer Name')); ?></th>
                                    <th><?php echo e(__('Receiving Date')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Receiving Bank')); ?></th>
                                    <th><?php echo e(__('Deposit Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Account Type')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $__currentLoopData = $receivedCashesInBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $money): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
								   <td><?php echo e($money->getMoneyTypeFormatted()); ?></td>
                                    <td><?php echo e($money->getCustomerName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($money->getReceivingDateFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getCashInBankReceivingBankName()); ?></td>
                                    <td><?php echo e($money->getReceivedAmountFormatted()); ?></td>
                                    <td data-currency="<?php echo e($money->getCurrency()); ?>"> <?php echo e($money->getCurrencyToReceivingCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getCashInBankAccountTypeName()); ?></td>
                                    <td><?php echo e($money->getCashInBankAccountNumber()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$money->isOpenBalance()): ?>
										<?php echo $__env->make('reports._review_modal',['model'=>$money], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php if(auth()->user()->can('update money received')): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php if(auth()->user()->can('delete money received')): ?>
											
                                            <a data-toggle="modal" data-target="#delete-cash-in-bank-id-<?php echo e($money->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cash-in-bank-id-<?php echo e($money->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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


<script src="/custom/money-receive.js">

</script>

<script>
    $(document).on('click', '.js-can-trigger-cheque-under-collection-modal', function(e) {
        e.preventDefault();
        const moneyType = $(this).attr('data-money-type')
        const type = $(this).attr('data-type') // single or multi
        $('#single-or-multi' + moneyType).val(type);
        if (type == 'single') {
            $('#current-single-item' + moneyType).val($(this).attr('data-id'));
            $('#current-currency' + moneyType).val($(this).attr('data-currency'));
        }
    })
    $(document).on('submit', '.ajax-send-cheques-to-collection', function(e) {
        e.preventDefault();
        const url = $(this).attr('action');
        const moneyType = $(this).attr('data-money-type')
        const type = $('#single-or-multi' + moneyType).val();
        const singleId = parseInt($('#current-single-item' + moneyType).val());
        let checked = [];
        $('.js-send-to-collection[data-money-type="' + moneyType + '"]:checked').each(function(index, element) {
            checked.push(parseInt($(element).val()));
        });

        const checkedItems = type == 'multi' ? checked : [singleId];
        let form = document.getElementById('ajax-send-cheques-to-collection-id' + moneyType);
        let formData = new FormData(form);
        formData.append('cheques', checkedItems);
        $('button').prop('disabled', true)
        $.ajax({
            cache: false
            , contentType: false
            , processData: false
            , url: url
            , data: formData
            , type: "post"
        }).then(function(res) {
            Swal.fire({
                text: 'Done'
                , icon: 'success'
                , timer: 2000
            }).then(function() {
                window.location.href = res.pageLink;
            });
        })
    });

</script>
<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })
    $(document).on('click', '#js-drawee-bank', function(e) {
        e.preventDefault();
        $('#js-choose-bank-id').modal('show');
    })

    $(document).on('click', '#js-append-bank-name-if-not-exist', function() {
        const receivingBank = document.getElementById('js-drawee-bank').parentElement;
        const newBankId = $('#js-bank-names').val();
        const newBankName = $('#js-bank-names option:selected').attr('data-name');
        const isBankExist = $(receivingBank).find('select.js-drawl-bank').find('option[value="' + newBankId + '"]').length;
        if (!isBankExist) {
            const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
            $('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
        }
        $('#js-choose-bank-id').modal('hide');
    });

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'due_date') {
            $('.data-type-span').html('[ <?php echo e(__("Due Date")); ?> ]')
            modal.find(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName == 'receiving_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ <?php echo e(__("Receiving Date")); ?> ]')
        } else if (searchFieldName == 'deposit_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ <?php echo e(__("Deposit Date")); ?> ]')
        } else {
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<script>
$(document).on('change','.js-account-number',function(){
	const parent = $(this).closest('.modal-body') ;
	const financialInstitutionId = parent.find('select.js-drawl-bank').val()
	const accountNumber= $(this).val();
	const accountType = parent.find('select.js-update-account-number-based-on-account-type').val();
	$.ajax({
		url:"<?php echo e(route('update.balance.and.net.balance.based.on.account.number',['company'=>$company->id])); ?>",
		data:{
			accountNumber,
			accountType ,
			financialInstitutionId 
		},
		type:"get",
		success:function(res){
			if(res.balance_date){
			$(parent).find('.balance-date-js').html('[ ' +res.balance_date + ' ]')
			}
			if(res.net_balance_date){
				$(parent).find('.net-balance-date-js').html('[ ' + res.net_balance_date + ' ]')
			}
			$(parent).find('.net-balance-js').val(number_format(res.net_balance))
			$(parent).find('.balance-js').val(number_format(res.balance))
			
		}
	})
})
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyReceived/index.blade.php ENDPATH**/ ?>