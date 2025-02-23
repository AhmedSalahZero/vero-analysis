<?php $attributes = $attributes->exceptProps([
    'id','modalTitle','hasSaveBtn'=>true , 'saveBtnTitle'=>__('Save'),'submitBtnClass'=>'','modelBodyId'=>'','modalTitleId'=>''
]); ?>
<?php foreach (array_filter(([
    'id','modalTitle','hasSaveBtn'=>true , 'saveBtnTitle'=>__('Save'),'submitBtnClass'=>'','modelBodyId'=>'','modalTitleId'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo e($modalTitleId ?:'exampleModalLongTitle'); ?>">
            <?php echo e($modalTitle??''); ?>

        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body " <?php if($modelBodyId): ?> id="<?php echo e($modelBodyId); ?>" <?php endif; ?>>
        <?php echo e($slot); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
        <?php if($hasSaveBtn): ?>
        <button type="button" class="btn btn-primary <?php echo e($submitBtnClass); ?> "><?php echo e($saveBtnTitle); ?></button>
        <?php endif; ?> 
      </div>
    </div>
  </div>
</div><?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/bs-modal.blade.php ENDPATH**/ ?>