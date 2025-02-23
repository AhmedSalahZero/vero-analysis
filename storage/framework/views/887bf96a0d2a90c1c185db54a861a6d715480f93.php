<?php echo csrf_field(); ?>
            <input type="hidden" name="model_id" value="<?php echo e($model->id ?? 0); ?>">
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="model_name" value="Study">
            <input type="hidden" name="type" value="<?php echo e($type); ?>">
            <input type="hidden" name="expense_type" value="<?php echo e($expenseType); ?>">
            <input type="hidden" name="study_id" id="study-id-js" value="<?php echo e($study->id); ?>">
            <input type="hidden" id="study-start-date" value="<?php echo e($study->getStudyStartDate()); ?>">
            <input type="hidden" id="study-end-date" value="<?php echo e($study->getStudyEndDate()); ?>">
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/financial_planning/manpower/_input-hidden.blade.php ENDPATH**/ ?>