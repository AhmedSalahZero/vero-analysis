<?php
	$mode = isset($rate) ? 'edit' : 'create';
?>
<input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
<div class="col-md-3">
    <label><?php echo e(__('Date')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input required name="date_<?php echo e($mode); ?>" type="date" value="<?php echo e(isset($rate) ? $rate->getDate() : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" />
        </div>
    </div>
</div>

<div class="col-md-3 mb-4 ">
    <label class="form-label font-weight-bold "><?php echo e(__('Borrowing Rate')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input type="number" class="form-control only-percentage-allowed borrowing-rate-class recalculate-interest-rate" name="borrowing_rate_<?php echo e($mode); ?>" value="<?php echo e(isset($rate) ? $rate->getBorrowingRate() : 0); ?>" step="any">
        </div>
    </div>
</div>

<div class="col-md-3 mb-4 ">
    <label class="form-label font-weight-bold "><?php echo e(__('Margin Rate')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input type="number" class="form-control only-percentage-allowed margin-rate-class recalculate-interest-rate" name="margin_rate_<?php echo e($mode); ?>" value="<?php echo e(isset($rate) ? $rate->getMarginRate() : 0); ?>" step="any">
        </div>
    </div>
</div>

<div class="col-md-3 mb-4 ">
    <label class="form-label font-weight-bold "><?php echo e(__('Interest Rate')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input disabled type="number" class="form-control interest-rate-class" value="<?php echo e(isset($rate) ? $rate->getInterestRate() : ''); ?>" step="any">
        </div>
    </div>
</div>
<?php if (! $__env->hasRenderedOnce('c1c49715-8af9-41e8-b966-1ab324084f4d')): $__env->markAsRenderedOnce('c1c49715-8af9-41e8-b966-1ab324084f4d'); ?>
<?php $__env->startPush('js'); ?>
	<script>
		$(document).on('change','.recalculate-interest-rate',function(){
			const parent = $(this).closest('.closest-parent') ;
			const marginRate = parent.find('.margin-rate-class').val();
			const borrowingRate = parent.find('.borrowing-rate-class').val();
			const interestRate = parseFloat(marginRate) + parseFloat(borrowingRate) ; 
			parent.find('.interest-rate-class').val(number_format(interestRate));
		})		
	</script>
<?php $__env->stopPush(); ?>
<?php endif; ?> 
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/overdraft-against-commercial-paper/rates-form.blade.php ENDPATH**/ ?>