<?php
	$mode = isset($rate) ? 'edit' : 'create';
?>

<div class="col-md-3">
    <label><?php echo e(__('Date')); ?> </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input name="date_<?php echo e($mode); ?>" type="date" value="<?php echo e(isset($rate) ? $rate->getDate() : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" />
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
<?php if (! $__env->hasRenderedOnce('cd274d22-875a-4fd1-8b24-2f72f7506462')): $__env->markAsRenderedOnce('cd274d22-875a-4fd1-8b24-2f72f7506462'); ?>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/clean-overdraft/rates-form.blade.php ENDPATH**/ ?>