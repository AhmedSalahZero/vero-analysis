<?php $attributes = $attributes->exceptProps([
'selectedValue'=>'',
'label'=>'',
'all'=>false ,
'options'=>[],
'addNew'=>false ,
'isRequired'=>false ,
'isSelect2'=>true,
'addNewText'=>'',
'disabled'=>false ,
'addWithPopup'=>false,
'addNewWithFormPopupClass'=>'',
'addNewFormPath'=>'',
'addModelName'=>'',
'addModalTitle'=>'',
'appendNewOptionToSelectSelector'=>'',
'multiple'=>$multiple ??false ,
'pleaseSelect'=>$pleaseSelect ?? false ,
'addNewModal'=>false,
'addNewModalModalName'=>'',
'addNewModalModalType'=>'',
'addNewModalModalTitle'=>'',
'previousSelectMustBeSelected'=>false ,
'previousSelectSelector'=>'' ,
'previousSelectTitle'=>'',
'previousSelectNameInDB'=>''
]); ?>
<?php foreach (array_filter(([
'selectedValue'=>'',
'label'=>'',
'all'=>false ,
'options'=>[],
'addNew'=>false ,
'isRequired'=>false ,
'isSelect2'=>true,
'addNewText'=>'',
'disabled'=>false ,
'addWithPopup'=>false,
'addNewWithFormPopupClass'=>'',
'addNewFormPath'=>'',
'addModelName'=>'',
'addModalTitle'=>'',
'appendNewOptionToSelectSelector'=>'',
'multiple'=>$multiple ??false ,
'pleaseSelect'=>$pleaseSelect ?? false ,
'addNewModal'=>false,
'addNewModalModalName'=>'',
'addNewModalModalType'=>'',
'addNewModalModalTitle'=>'',
'previousSelectMustBeSelected'=>false ,
'previousSelectSelector'=>'' ,
'previousSelectTitle'=>'',
'previousSelectNameInDB'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if($label): ?>
<label class="form-label font-weight-bold <?php if($addNewModal): ?> d-flex <?php endif; ?> "> <?php echo e($label); ?>



    <?php if($isRequired): ?>
    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if($addNewModal && isset($company->id)): ?>
    <i
	<?php if($previousSelectMustBeSelected): ?>
	data-previous-must-be-opened="1"
	data-previous-select-selector="<?php echo e($previousSelectSelector); ?>"
	data-previous-select-title="<?php echo e($previousSelectTitle); ?>"
	<?php endif; ?> 
	 title="<?php echo e(__('Add New')); ?>" data-company-id="<?php echo e($company->id ?? 0); ?>" data-modal-name="<?php echo e($addNewModalModalName); ?>" data-modal-type="<?php echo e($addNewModalModalType); ?>" data-modal-title="<?php echo e($addNewModalModalTitle); ?>" class="fa fa-plus cursor-pointer block ml-auto trigger-add-new-modal"></i>
    <?php endif; ?>
</label>
<?php endif; ?>
<?php if($disabled): ?>
<?php
$isSelect2 = false ;
?>
<?php endif; ?>

<?php
$basicClasses = $isSelect2 ? "form-control mb-1 select select2-select" :"form-control mb-1 select ";
?>

<select <?php if($addNewModalModalName): ?> data-modal-name="<?php echo e($addNewModalModalName); ?>" data-modal-type="<?php echo e($addNewModalModalType); ?>" <?php endif; ?>  <?php if($disabled): ?> disabled <?php endif; ?> <?php echo e($attributes->merge(['class'=>$basicClasses])); ?> data-live-search="true" data-add-new="<?php echo e($addNew ? 1 : 0); ?>" data-all="<?php echo e($all ? 1 :0); ?>" <?php if($multiple): ?> multiple <?php endif; ?>>

    <?php if($pleaseSelect): ?>
    <option value="" selected><?php echo e(__('Please Select')); ?></option>
    <?php endif; ?>
    <?php if($all): ?>

    <option value=""><?php echo e(__('All')); ?></option>
    <?php endif; ?>
    <?php if($addNew): ?>
    <option class="add-new-item 
                <?php if($addWithPopup): ?>
                add-with-popup
                <?php endif; ?> 
                " data-add-new-form="<?php echo e($addNewWithFormPopupClass ?: ''); ?>" data-add-model-name="<?php echo e($addModelName); ?>" data-add-modal-title="<?php echo e($addModalTitle); ?>"><?php echo e($addNewText ?: __('Add New')); ?></option>
    <?php endif; ?>
    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option 
	<?php if(isset($option['value'])): ?>
	value="<?php echo e($option['value']); ?>"
	<?php endif; ?>
	 title="<?php echo e($option['title']); ?>" <?php $__currentLoopData = $option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($name .'='.$val); ?>

        <?php if($name == 'value' && $val == $selectedValue ): ?>
        selected
        <?php endif; ?>



        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        >

        <?php echo e($option['title']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<div class="modal fade" id="modal-for-<?php echo e($attributes->get('name')); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-add-new-modal-<?php echo e($addNewModalModalName); ?>"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label class="label"><?php echo e(__('Please Enter Name')); ?></label>
                        <input type="text" class="form-control name-class-js">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                <button
				
				
				<?php if($previousSelectMustBeSelected): ?>
				data-previous-select-selector="<?php echo e($previousSelectSelector); ?>"
				data-previous-select-title="<?php echo e($previousSelectTitle); ?>"
				data-previous-select-name-in-db="<?php echo e($previousSelectNameInDB); ?>"
				<?php endif; ?> 
								
				 data-company-id="<?php echo e($company->id ?? 0); ?>" data-modal-type="<?php echo e($addNewModalModalType); ?>" data-modal-name="<?php echo e($addNewModalModalName); ?>" data-modal-title="<?php echo e($addNewModalModalTitle); ?>" type="button" class="btn btn-primary store-new-add-modal"><?php echo e(__('Save')); ?></button>
            </div>
        </div>
    </div>
</div>


<?php echo e($slot); ?>


<?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/select.blade.php ENDPATH**/ ?>