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
                    <input data-save-and-continue="0" type="submit" class="btn max-w-btn active-style save-form" value="<?php echo e(isset($text) ? $text : __('Save Changes')); ?>">
					
                    <input data-save-and-continue="1"  type="submit" class="btn  text-white bg-green save-form" value="<?php echo e(isset($text) ? $text : __('Save & Go To Next')); ?>">
					
                </div>
            </div>
        
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/save-or-continue-btn.blade.php ENDPATH**/ ?>