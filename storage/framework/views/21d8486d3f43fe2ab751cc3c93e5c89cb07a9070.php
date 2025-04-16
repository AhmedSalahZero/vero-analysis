<?php $attributes = $attributes->exceptProps([
'instanceNo','groupName',
'itemClasses'=>'',
'repeaterWithSelect2'=>false
]); ?>
<?php foreach (array_filter(([
'instanceNo','groupName',
'itemClasses'=>'',
'repeaterWithSelect2'=>false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div id="m_repeater_<?php echo e($instanceNo); ?>" <?php echo e($attributes->merge(['class'=>'d-block w-full repeater-class'])); ?>>
    <div class="form-group w-100 m-form__group row d-inline-flex">
        <div data-repeater-list="<?php echo e($groupName); ?>" class="col-lg-12 d-flex flex-wrap  align-items-center mx-auto">
            <div <?php if($repeaterWithSelect2): ?> style="display: none; !important" <?php endif; ?> data-repeater-item class="form-group m-form__group row align-items-center repeater_item <?php echo e($itemClasses ? $itemClasses : 'w-48'); ?>">


                <?php echo e($slot); ?>



                <div class="">
                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                    </i>
                </div>

            </div>
        </div>
    </div>


    <div class="m-form__group form-group row">


        <div class="col-lg-6">
            <div data-repeater-create="" class="btn btn btn-sm btn-success add-row m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        <?php echo e(__('Add')); ?>

                    </span>
                </span>
            </div>
        </div>
    </div>


</div>

<?php $__env->startPush('js'); ?>
<script>
    $(function() {
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-delete]').trigger('click');
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-create]').trigger('click');
    });

</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/helpers/repeater.blade.php ENDPATH**/ ?>