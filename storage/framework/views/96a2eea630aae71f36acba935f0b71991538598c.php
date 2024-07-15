<?php $attributes = $attributes->exceptProps([
'title','startDate','endDate',
'type'=>''
]); ?>
<?php foreach (array_filter(([
'title','startDate','endDate',
'type'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
$startDateId = $type ? 'startDate_'.$type : 'startDate';
$endDateId = $type ? 'endDate_'.$type : 'endDate';
$startDateInputName = $type ? 'startDate['. $type .']' : 'startDate';
$endDateInputName = $type ? 'endDate['. $type .']' : 'endDate';
?>
<div class="kt-portlet__head kt-portlet__head--lg p-0">
    <div class="kt-portlet__head-label ml-4" style="flex:2.5;">
        <span class="kt-portlet__head-icon">
            <i class="kt-font-secondary text-main-color btn-outline-hover-danger fa fa-layer-group"></i>
        </span>
        <h3 style="font-size:20px !important;" class="kt-portlet__head-title text-main-color text-nowrap">
            <?php echo e($title); ?>

        </h3>
        
        <form class="w-full flex-2  " <?php if($lang=='ar' ): ?> style="margin-right:5rem !important" <?php else: ?> style="margin-left:5rem !important" <?php endif; ?>>
            <input type="hidden" name="active" value="<?php echo e($type); ?>">
            <div class="row align-items-center ">
                <div class="col-md-3 d-flex align-items-center " <?php if($lang=='ar' ): ?> style="margin-left:5rem !important" <?php else: ?> style="margin-right:5rem !important" <?php endif; ?>>
                    <label for="<?php echo e($startDateId); ?>" class="text-nowrap mr-3"><?php echo e(__('Start Date')); ?></label>
                    <input id="<?php echo e($startDateId); ?>" type="date" value="<?php echo e($startDate); ?>" class="form-control" name="<?php echo e($startDateInputName); ?>">
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <label for="<?php echo e($endDateId); ?>" class="text-nowrap mr-3"><?php echo e(__('End Date')); ?></label>
                    <input type="date" value="<?php echo e($endDate??''); ?>" class="form-control" id="<?php echo e($endDateId); ?>" name="<?php echo e($endDateInputName); ?>">
                </div>
                <div <?php if($lang=='ar' ): ?> style="margin-right:2rem !important" <?php else: ?> style="margin-left:2rem !important" <?php endif; ?> class="col-md-2 d-flex justify-content-center">
                    <label for="button"></label>
                    <button style="width:70px !important;font-size:1rem !important;" type="submit" class="btn block form-control btn-primary btn-sm "> <?php echo e(__('Submit')); ?></button>

                </div>


            </div>
        </form>
    </div>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/table-title/with-two-dates.blade.php ENDPATH**/ ?>