<?php $attributes = $attributes->exceptProps([
	'navigators'=>[]
]); ?>
<?php foreach (array_filter(([
	'navigators'=>[]
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div id="second_kt_header" class="kt-header  kt-header--fixed fh-fixedHeader" data-ktheader-minimize="on">

    <div class="kt-container ">

        <!-- begin:: Brand -->
        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">

            <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid ml-0" id="second_kt_header_menu_wrapper">
                <div id="second_kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                    <ul class="kt-menu__nav ">
						<?php $__currentLoopData = $navigators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navigatorItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php echo $__env->make('nav-item',['navItem'=>$navigatorItem], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </ul>



                </div>
            </div>

        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/navigators-dropdown.blade.php ENDPATH**/ ?>