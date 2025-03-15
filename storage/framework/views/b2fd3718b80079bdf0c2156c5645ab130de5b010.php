<?php $attributes = $attributes->exceptProps([
'hasSearch'=>true 
,'type','searchFields'
]); ?>
<?php foreach (array_filter(([
'hasSearch'=>true 
,'type','searchFields'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;

            <?php if($hasSearch): ?>
            <a data-type="multi" data-toggle="modal" data-target="#search-modal-<?php echo e($type); ?>" id="js-search-money-received" href="#" title="<?php echo e(__('Search Letter Of Credit Issuance')); ?>" class="btn  active-style btn-icon-sm  ">
                <i class="fas fa-search"></i>
                <?php echo e(__('Search')); ?>

            </a>

            <div class="modal fade" id="search-modal-<?php echo e($type); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle"><?php echo e(__('Search Form')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo csrf_field(); ?>
                            <form action="<?php echo e(route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$type])); ?>" class="row ">
                                <input name="active" type="hidden" value="<?php echo e($type); ?>">
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label"><?php echo e(__('Field Name')); ?></label>
                                    <select id="js-search-modal-name-<?php echo e($type); ?>" data-type="<?php echo e($type); ?>" class="form-control js-search-modal" type="date" name="field" placeholder="<?php echo e(__('Delete From')); ?>">
                                        <?php $__currentLoopData = $searchFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(Request('field')==$name): ?> selected <?php endif; ?> value="<?php echo e($name); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label"><?php echo e(__('Search Text')); ?></label>
                                    <input name="value" type="text" value="<?php echo e(request('value')); ?>" placeholder="<?php echo e(__('Search Text')); ?>" class="form-control search-field">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-from " class="label"><?php echo e(__('From')); ?> <span class="data-type-span"><?php echo e(__('[ Contract Start At ]')); ?></span> </label>
                                    <input name="from" type="date" value="<?php echo e(request('from')); ?>" class="form-control">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-to " class="label"><?php echo e(__('To')); ?> <span class="data-type-span"><?php echo e(__('[ Contract Start Date ]')); ?></span> </label>
                                    <input name="to" type="date" value="<?php echo e(request('to')); ?>" class="form-control">

                                </div>



                                <div class="modal-footer">
                                    <button type="submit" id="js-search-id" type="submit" id="" class="btn btn-primary"><?php echo e(__('Search')); ?></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>







         

        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/export-letter-of-credit-issuance.blade.php ENDPATH**/ ?>