<style>
.max-w-btn{
	max-width:125px !important;
	min-width:125px !important;
}
</style>
            <div class="row btn-for-submit--js <?php echo e(isset($isHidden)&&$isHidden ? 'd-none':''); ?>">
                <div class="col-lg-6">
              
                </div>
                <div class="col-lg-6 kt-align-right">
                    <input data-save-and-add-new-department="0" type="submit" class="btn max-w-btn active-style save-form" value="<?php echo e(isset($text) ? $text : __('Save Changes')); ?>">
					<?php if($department): ?>
                    <input data-save-and-add-new-department="1"  type="submit" class="btn  text-white bg-green save-form" value="<?php echo e(isset($text) ? $text : __('Save & Add New Department')); ?>">
					<?php endif; ?>
                </div>
            </div>
        
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/save-or-back-inside-table.blade.php ENDPATH**/ ?>