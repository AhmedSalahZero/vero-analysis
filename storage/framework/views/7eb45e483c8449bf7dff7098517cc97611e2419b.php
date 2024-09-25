<style>
.header-title-css{
	display: flex;
  align-items: stretch;
  justify-content: space-between;
  position: relative;
  padding: 0 25px;
  border-bottom: 1px solid #ebedf2;
  min-height: 60px;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
  background-color: #ffffff;
  margin-bottom: 20px;
  border-radius: 4px;
  font-variant:small-caps;
}
</style>
<?php $attributes = $attributes->exceptProps([
	'title'
]); ?>
<?php foreach (array_filter(([
	'title'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="col-12">
		                        <h3 class="kt-portlet__head-title head-title header-title-css text-primary d-flex align-items-center "><?php echo e($title); ?></h3>
							</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/title.blade.php ENDPATH**/ ?>