<div class="kt-portlet kt-portlet--mobile">
    <?php if($tableTitle !== null): ?>
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                </span>
                <h3 class="kt-portlet__head-title">
					 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => $tableTitle]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableTitle)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					<?php if(isset($instructionsIcon)): ?>
						 <span id="open-instructions" class="kt-input-icon__icon kt-input-icon__icon--right ml-2 cursor-pointer" tabindex="0" role="button" data-toggle="kt-tooltip" data-trigger="focus" title="<?php echo e(__('Uploading Instructions')); ?>">
							<span><i class="fa fa-question text-primary"></i></span>
						</span>
						
						   
								
								
					<?php endif; ?> 
                </h3>
            </div>
            
             <?php if (isset($component)) { $__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Export::class, ['notPeriodClosedCustomerInvoices' => $notPeriodClosedCustomerInvoices,'lastUploadFailedHref' => $lastUploadFailedHref,'class' => $class,'href' => $href,'importHref' => $importHref,'exportHref' => $exportHref,'exportTableHref' => $exportTableHref,'icon' => $icon,'firstButtonName' => $firstButtonName,'truncateHref' => $truncateHref]); ?>
<?php $component->withName('export'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323)): ?>
<?php $component = $__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323; ?>
<?php unset($__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

        </div>
    <?php endif; ?>
    <div class=" <?php if('kt_table_with_no_pagination_no_scroll_no_entries' != $tableClass ): ?> kt-portlet__body <?php endif; ?> table-responsive">

        <!--begin: Datatable -->
        <table class="table table-striped- <?php echo e($tableClass); ?> table-bordered table-hover table-checkable  " >

            <thead>
                <?php echo e($table_header); ?>

            </thead>
            <tbody>
                <?php echo e($table_body); ?>

            </tbody>
        </table>

        <!--end: Datatable -->
    </div>
</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/table.blade.php ENDPATH**/ ?>