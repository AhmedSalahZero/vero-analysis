<div class="kt-portlet kt-portlet--mobile">
    <?php if($tableTitle !== null): ?>
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                </span>

                <h3 class="kt-portlet__head-title">
                    <?php echo e($tableTitle); ?>

                </h3>
            </div>
            
            <?php if (isset($component)) { $__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Export::class, ['class' => $class,'href' => $href,'importHref' => $importHref,'exportHref' => $exportHref,'exportTableHref' => $exportTableHref,'icon' => $icon,'firstButtonName' => $firstButtonName,'truncateHref' => $truncateHref]); ?>
<?php $component->withName('export'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323)): ?>
<?php $component = $__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323; ?>
<?php unset($__componentOriginal7d524a2baf592aee89087db68e8a63b39a8e6323); ?>
<?php endif; ?>

        </div>
    <?php endif; ?>
    <div class="kt-portlet__body table-responsive">

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

<?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/components/table.blade.php ENDPATH**/ ?>