<?php $attributes = $attributes->exceptProps([
'isPercentage',
'classes'=>'only-greater-than-zero-allowed',
'currentVal',
'columnIndex'=>$columnIndex , 
'name',
'numberFormatDecimals'=>2 ,
'inputHiddenAttributes'=>'',
'formattedInputClasses'=>'',
'removeThreeDots'=>false,
'removeCurrency'=>false,
'multiple'=>false,
'readonly'=>false,
'mark'=>'',
'removeThreeDotsClass'=>false,
'isNumber'=>true,

]); ?>
<?php foreach (array_filter(([
'isPercentage',
'classes'=>'only-greater-than-zero-allowed',
'currentVal',
'columnIndex'=>$columnIndex , 
'name',
'numberFormatDecimals'=>2 ,
'inputHiddenAttributes'=>'',
'formattedInputClasses'=>'',
'removeThreeDots'=>false,
'removeCurrency'=>false,
'multiple'=>false,
'readonly'=>false,
'mark'=>'',
'removeThreeDotsClass'=>false,
'isNumber'=>true,

]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="

<?php if(!$removeThreeDotsClass): ?>
form-group 
three-dots-parent
<?php endif; ?> 

">
    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
        <div class="input-hidden-parent">
            <input
				data-number-of-decimals="<?php echo e($numberFormatDecimals); ?>"
				<?php if($readonly): ?>
				readonly
				<?php endif; ?> 
				<?php if($name): ?>
				data-name="<?php echo e(removeSquareBrackets($name)); ?>"
				<?php endif; ?>
			 onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			 <?php if($isPercentage): ?> expandable-percentage-input  <?php else: ?> expandable-amount-input <?php endif; ?>
			  repeat-to-right-input-formatted  <?php echo e($formattedInputClasses); ?> " type="text" value="<?php echo e($isNumber ?  number_format($currentVal,$numberFormatDecimals) : $currentVal); ?>" 
			 <?php if(!is_null($columnIndex)): ?>
			 data-column-index="<?php echo e($columnIndex); ?>" 
			 <?php endif; ?>
			 
			 >
            <input 
			data-number-of-decimals="<?php echo e($numberFormatDecimals); ?>"
			<?php if($multiple): ?>
			multiple
			<?php endif; ?> 
			<?php echo e($inputHiddenAttributes); ?>  <?php echo e($attributes->merge([])); ?> type="hidden" data-name="<?php echo e(removeSquareBrackets($name)); ?>"  class="repeat-to-right-input-hidden input-hidden-with-name  <?php echo e($classes); ?>" value="<?php echo e($currentVal); ?>" 
			 <?php if(!is_null($columnIndex)): ?>
			data-column-index="<?php echo e($columnIndex); ?>"
			<?php endif; ?>
			 name="<?php echo e($name); ?>">
        </div>
		<?php if($mark): ?>
			  <span class="ml-2"><?php echo e($mark); ?></span>
		<?php endif; ?>
		<?php if(!$removeCurrency && !$mark): ?>
            <?php if($isPercentage): ?>
        <span class="ml-2">%</span>
		<?php else: ?> 
        <span class="ml-2 currency-class">
			<?php echo e($company->getMainFunctionalCurrency()); ?>

		</span>
		
    <?php endif; ?>
	<?php endif; ?>
    </div>
	<?php if(!$removeThreeDots): ?>
    <i 
	data-name="<?php echo e(removeSquareBrackets($name)); ?>"
	class="fa
	

	 fa-ellipsis-h pull-left repeat-to-right row-repeater-icon " data-column-index="<?php echo e($columnIndex); ?>" data-section="target" title="<?php echo e(__('Repeat Right')); ?>"></i>
	 <?php elseif(!$removeThreeDotsClass): ?> 


    <i class="fa fa-ellipsis-h pull-left repeat-to-right row-repeater-icon visibility-hidden" ></i>
	 <?php endif; ?> 
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/repeat-right-dot-inputs.blade.php ENDPATH**/ ?>