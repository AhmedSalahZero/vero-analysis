 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.modal','data' => ['title' => __('Export Options'),'tableId' => $tableId,'type' => 'export','action' => ''.e($exportRoute).'']]); ?>
<?php $component->withName('form.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Export Options')),'table-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('export'),'action' => ''.e($exportRoute).'']); ?>

    <?php echo $__env->make('admin.financial-statement.options' , [
    'type'=>'export'
    ] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['label' => __('Format'),'name' => 'format','options' => getExportFormat()]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Format')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('format'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getExportFormat())]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.filter-btn','data' => ['type' => 'export','id' => 'export-btn-id','datatableId' => $tableId,'btnTitle' => __('Export')]]); ?>
<?php $component->withName('form.filter-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('export'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('export-btn-id'),'datatable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'btn-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Export'))]); ?>

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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/financial-statement/export.blade.php ENDPATH**/ ?>