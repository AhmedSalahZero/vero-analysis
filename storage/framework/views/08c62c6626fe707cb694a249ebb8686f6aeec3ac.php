 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.modal','data' => ['title' => __('Filter Options'),'tableId' => $tableId,'type' => 'filter']]); ?>
<?php $component->withName('form.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Filter Options')),'table-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('filter')]); ?>

<?php echo $__env->make('admin.income-statement.report.options' , [
                    'type'=>'filter'
                ] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.filter-btn','data' => ['type' => 'filter','id' => 'filter-btn-id','datatableId' => $tableId]]); ?>
<?php $component->withName('form.filter-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('filter'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('filter-btn-id'),'datatable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId)]); ?>
               
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
<?php endif; ?> <?php /**PATH E:\projects\veroo\resources\views/admin/income-statement/report/filter.blade.php ENDPATH**/ ?>