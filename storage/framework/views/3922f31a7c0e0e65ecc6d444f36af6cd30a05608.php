<?php $attributes = $attributes->exceptProps([
'title'=>$title,
'helperTitle'=>$hasHelper ?? '',
// 'helperPrependTitle'=> '',
// 'helperAppendTitle'=> '',

]); ?>
<?php foreach (array_filter(([
'title'=>$title,
'helperTitle'=>$hasHelper ?? '',
// 'helperPrependTitle'=> '',
// 'helperAppendTitle'=> '',

]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<th <?php echo e($attributes->merge(['class'=>'form-label font-weight-bold  text-center align-middle'])); ?>>
	<div class="d-flex align-items-center justify-content-center">
	<span><?php echo $title; ?></span>
    <?php if($helperTitle): ?>
    <span class="kt-input-icon__icon kt-input-icon__icon--right ml-2" tabindex="0" role="button" data-toggle="kt-tooltip" data-trigger="focus" title="<?php echo e(str_replace('{title}',$title,$helperTitle)); ?>">
        <span><i class="fa fa-question text-primary"></i></span>
    </span>
    <?php endif; ?>
	   
	</div>

</th>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/tables/repeater-table-th.blade.php ENDPATH**/ ?>