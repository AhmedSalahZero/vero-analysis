<?php $attributes = $attributes->exceptProps([
'label'=>$label ?? '' ,
'id'=>$id ,
'name'=>$name ,
'value'=>$value ?? null,
'required'=>true,
'showLabel'=>true,
'onlyMonth'=>true,
'classes'=>''
]); ?>
<?php foreach (array_filter(([
'label'=>$label ?? '' ,
'id'=>$id ,
'name'=>$name ,
'value'=>$value ?? null,
'required'=>true,
'showLabel'=>true,
'onlyMonth'=>true,
'classes'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php if($label && $showLabel): ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['class' => 'label','id' => $id]]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id)]); ?> <?php echo e($label); ?>


    <?php if($required): ?>
    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php endif; ?>
<div class="kt-input-icon">
    <div class="input-group date">

        <input type="text" name="<?php echo e($name); ?>" class="<?php if($onlyMonth): ?>  only-month-year-picker <?php endif; ?> datepicker-input date-input form-control recalc-end-date start-date <?php echo e($classes); ?> " value="<?php echo e($value); ?> " />
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/calendar.blade.php ENDPATH**/ ?>