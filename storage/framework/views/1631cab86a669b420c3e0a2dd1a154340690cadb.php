      <?php $attributes = $attributes->exceptProps([
      'model'=>$model ?? null,
	  'isRepeater'=>$isRepeater,
	  'trs'=>$trs
      ]); ?>
<?php foreach (array_filter(([
      'model'=>$model ?? null,
	  'isRepeater'=>$isRepeater,
	  'trs'=>$trs
      ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
      <?php
      
      $type = 'create';
      ?>


		  <?php echo e($trs); ?>

<?php /**PATH C:\laragon\www\veroo\resources\views/components/tables/repeater-table-tr.blade.php ENDPATH**/ ?>