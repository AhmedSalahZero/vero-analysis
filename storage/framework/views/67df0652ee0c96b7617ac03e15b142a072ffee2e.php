<div class="kt-portlet">
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-6">
                    
                </div>
                <div class="col-lg-6 kt-align-right">
                    <button type="submit" class="btn active-style"><?php echo e(__('Next')); ?></button>
                    <?php if(isset($report) && App\Models\ModifiedSeasonality::where('company_id', $companyId)->first()): ?>
                    <input type="submit" name="summary_report" id="subkit_summary_report_id" value="<?php echo e(__('Save And Go To Summary Report')); ?>"  class="btn btn-success">
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\projects\veroo\resources\views/components/next__button.blade.php ENDPATH**/ ?>