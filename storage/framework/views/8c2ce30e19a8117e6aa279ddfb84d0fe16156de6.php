

<?php $attributes = $attributes->exceptProps([
	'label',
	'type' ,
	'name',
	'required'=>$required??false ,
	'model'=>$model,
	'readonly'=>false,
	'placeholder'=>$placeholder ?? null,
	'class'=>$class ?? '',
	'id'=>'',
	'defaultValue'=>'',
	'useOldValue'=>false,
	'dataCurrentValue'=>null
]); ?>
<?php foreach (array_filter(([
	'label',
	'type' ,
	'name',
	'required'=>$required??false ,
	'model'=>$model,
	'readonly'=>false,
	'placeholder'=>$placeholder ?? null,
	'class'=>$class ?? '',
	'id'=>'',
	'defaultValue'=>'',
	'useOldValue'=>false,
	'dataCurrentValue'=>null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
	$value = $useOldValue && old($name) ? old($name) :  ($model  ?  $model->{$name} : $defaultValue);
?>
<label> <?php echo e($label); ?>

<?php if($required): ?>
<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</label>
                                <div class="kt-input-icon">
                                    <input
									<?php if($dataCurrentValue!=null): ?>
									data-current-value="<?php echo e($dataCurrentValue); ?>"
									<?php endif; ?> 
									<?php if($required): ?>
									required
									<?php endif; ?>
									 <?php if($readonly): ?> readonly <?php endif; ?> <?php if($id): ?> id="<?php echo e($id); ?>" <?php endif; ?> name="<?php echo e($name); ?>"  value="<?php echo e($value); ?>" type="<?php echo e($type); ?>" class="form-control <?php echo e($class); ?>" placeholder="<?php echo e($placeholder); ?>">
                                </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/input.blade.php ENDPATH**/ ?>