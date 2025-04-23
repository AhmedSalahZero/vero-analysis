<?php $attributes = $attributes->exceptProps([
'link'
]); ?>
<?php foreach (array_filter(([
'link'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>


<div class="kt-list-timeline__items">

    <div class="kt-list-timeline__item">
        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
        <span class="kt-list-timeline__text">
            <h4 class="subtitle-card-header"> <?php echo e($slot); ?>

            </h4>
        </span>
        
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/bar-nav.blade.php ENDPATH**/ ?>