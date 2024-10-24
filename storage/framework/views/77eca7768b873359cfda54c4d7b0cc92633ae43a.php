<?php $attributes = $attributes->exceptProps([
	'model',
	'label'=>'',
	'classes'=>'',
	'useOldValue'=>false,
	'name',
	'id'=>'',
	'placeholder'=>'',
	'required'=>$required??false ,
	'readonly'=>false,
	'type'=>'date',
	'defaultValue'=>null
]); ?>
<?php foreach (array_filter(([
	'model',
	'label'=>'',
	'classes'=>'',
	'useOldValue'=>false,
	'name',
	'id'=>'',
	'placeholder'=>'',
	'required'=>$required??false ,
	'readonly'=>false,
	'type'=>'date',
	'defaultValue'=>null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if($label): ?>
<label>
<?php echo e($label); ?>

<?php if($required): ?>
<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?> 

</label>
<?php endif; ?>

<?php
	if($name == 'contract_start_date' && !$model){
		$defaultValue = date("Y").'-01-01';
	}
	if($name == 'contract_end_date' && !$model){
		$defaultValue =date("Y").'-12-31' ;
	}
	
	$defaultValue = old($name) ? old($name):$defaultValue;
	
?>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input
										<?php if($readonly): ?>
										readonly
										<?php endif; ?>
										
										
										 <?php if($id): ?>  id="<?php echo e($id); ?>" <?php endif; ?> type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" value="<?php echo e(isset($defaultValue) ? $defaultValue : ($model && $model->{$name} ? $model->{$name} : now()->format('Y-m-d') )); ?>" class="form-control <?php echo e($classes); ?>"  <?php if($placeholder): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?> />
										
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/date.blade.php ENDPATH**/ ?>