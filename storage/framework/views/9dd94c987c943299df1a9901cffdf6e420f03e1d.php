<?php
	$mode = isset($lendingInformationAgainstAssignmentOfContract) ? 'edit' : 'create';
?>
<div class="col-lg-2" data-dd="<?php echo e(isset($lendingInformationAgainstAssignmentOfContract) ? 1 : -1); ?>">
    <label><?php echo e(__('Select Customer')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
    <div class="input-group">
        <select data-live-search="true" name="customer_id_<?php echo e($mode); ?>" class="form-control kt-bootstrap-select select2-select select2 ajax-get-contracts-for-customer-<?php echo e($mode); ?>">
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerId => $customerName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($customerId); ?>" <?php if(isset($lendingInformationAgainstAssignmentOfContract) && $lendingInformationAgainstAssignmentOfContract->getCustomerId() == $customerId ): ?> selected  <?php endif; ?> > <?php echo e($customerName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>



<div class="col-md-3">
    <label><?php echo e(__('Select Contract')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
    <div class="input-group">
        <select name="contract_id_<?php echo e($mode); ?>" class="form-control append-contracts-<?php echo e($mode); ?>">
			<?php if(isset($lendingInformationAgainstAssignmentOfContract)): ?>
			<?php $__currentLoopData = \App\Models\Contract::getForParentAndCurrency($lendingInformationAgainstAssignmentOfContract->getCustomerId()   , $odAgainstAssignmentOfContract->getCurrency() ); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<option value="<?php echo e($contract->id); ?>"> <?php echo e($contract->getName()); ?> </option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
			<?php endif; ?> 
        </select>
    </div>
</div>

<div class="col-md-2 mb-4 ">
    <label class="form-label font-weight-bold"><?php echo e(__('Amount')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input type="text" disabled class="form-control  contract-amount-class-<?php echo e($mode); ?>" value="<?php echo e(isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getContractAmountFormatted() : 0); ?>" step="any">
        </div>
    </div>
</div>

<div class="col-md-2">
    <label><?php echo e(__('Start Date')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input disabled type="date" value="<?php echo e(isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getContractStartDate() : ''); ?>" class="form-control contract-start-date-class-<?php echo e($mode); ?>" />
        </div>
    </div>
</div>
<div class="col-md-2">
    <label><?php echo e(__('End Date')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input disabled type="date" value="<?php echo e(isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getContractEndDate() : ''); ?>" class="form-control contract-end-date-class-<?php echo e($mode); ?>" />
        </div>
    </div>
</div>

<div class="col-md-1 mb-4 ">
    <label class="form-label font-weight-bold "><?php echo e(__('Lending %')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input type="number" class="form-control only-percentage-allowed" name="lending_rate_<?php echo e($mode); ?>" value="<?php echo e(isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getLendingRate() : ''); ?>" step="any">
        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/overdraft-against-assignment-of-contract/lending-rate-form.blade.php ENDPATH**/ ?>