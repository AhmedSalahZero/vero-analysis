<?php $attributes = $attributes->exceptProps([
'wrapWithForm'=>false ,
'saveAndReturn'=>false ,
'redirectRoute'=>'',
'formAction'=>'#',
'method'=>'post',
'formId'=>''
]); ?>
<?php foreach (array_filter(([
'wrapWithForm'=>false ,
'saveAndReturn'=>false ,
'redirectRoute'=>'',
'formAction'=>'#',
'method'=>'post',
'formId'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
$basicTableClasses = 'table table-striped- table-bordered table-hover table-checkable' ;
?>

<input type="hidden" id="no-ajax-loader">
<?php echo e($filter); ?>

<?php echo e($export); ?>


<?php if($wrapWithForm): ?>
<form action="<?php echo e($formAction); ?>" method="<?php echo e($method); ?>" id="<?php echo e($formId); ?>">

    <?php echo csrf_field(); ?>
    
    <?php endif; ?>
    <table <?php echo e($attributes->merge(['class'=>$basicTableClasses ])); ?> id="<?php echo e('#'.$attributes->get('id')); ?>">

        <thead>
            <?php echo e($headerTr); ?>


        </thead>


    </table>

    <?php if($wrapWithForm): ?>
    <?php if(isset($saveAndReturn) && $saveAndReturn): ?>
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.submitting-with-refresh','data' => ['returnRedirectRoute' => $redirectRoute]]); ?>
<?php $component->withName('submitting-with-refresh'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['return-redirect-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($redirectRoute)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    <?php else: ?>
     <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    <?php endif; ?>
</form>
<?php endif; ?>

<?php echo e($js); ?>

<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/tables/basic-view.blade.php ENDPATH**/ ?>