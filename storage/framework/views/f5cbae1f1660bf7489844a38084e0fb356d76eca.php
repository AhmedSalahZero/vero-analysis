
                              <div class="mb-1">
       <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => $interval,'addNew' => false,'label' => __('Interval View'),'class' => 'select2-select revenue_business_line_class  ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'interval_view','id' => ''.e($type.'_'.'interval_view').'','selectedValue' => '']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($interval),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Interval View')),'class' => 'select2-select revenue_business_line_class  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'interval_view','id' => ''.e($type.'_'.'interval_view').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?>
       <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
</div>



                                         <?php /**PATH E:\projects\veroo\resources\views/admin/income-statement/report/options.blade.php ENDPATH**/ ?>