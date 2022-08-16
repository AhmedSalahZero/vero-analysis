<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            <?php if($href != '#'): ?>
                <a href=<?php echo e($href); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                    <i class="fas fa-<?php echo e($icon); ?>"></i>
                    <?php echo e(__($firstButtonName)); ?>

                </a>
            <?php endif; ?>
            <?php if($importHref != '#'): ?>
                <a href=<?php echo e($importHref); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                    <i class="fas fa-file-import"></i>
                    <?php echo e(__('Upload Data')); ?>

                </a>
            <?php endif; ?>
            <?php if($exportHref != '#'): ?>
                <a href=<?php echo e($exportHref); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                    <i class="fas fa-file-export"></i>
                    <?php echo e(__('Export Data')); ?>

                </a>
            <?php endif; ?>
            <?php if($exportTableHref != '#'): ?>
                <a href=<?php echo e($exportTableHref); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                    <i class="fas fa-file-export"></i>
                    <?php echo e(__('Template Download')); ?>

                </a>
            <?php endif; ?>
            <?php if($truncateHref != '#'): ?>
                <a href=<?php echo e($truncateHref); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                    <i class="fas fa-file-export"></i>
                    <?php echo e(__('Delete All Data')); ?>

                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/components/export.blade.php ENDPATH**/ ?>