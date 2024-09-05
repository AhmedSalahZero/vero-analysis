<?php $attributes = $attributes->exceptProps([
	'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true 
]); ?>
<?php foreach (array_filter(([
	'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true 
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="col-md-12 <?php echo e($parentClass); ?>  js-parent-to-table" style="display:none">
    <hr style="width:100%;">
    <table <?php if($initialJs): ?> id="<?php echo e($repeaterId); ?>"  <?php endif; ?> class="table  <?php echo e($repeaterId); ?> table-white repeater-class repeater <?php echo e($tableName); ?>"  >
        <thead>
            <tr>
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1 action-class','title' => __('Action')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1 action-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Action'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                <?php echo e($ths); ?>


            </tr>
        </thead>
        <tbody data-repeater-list="<?php echo e($tableName); ?>"
	
		>

            <?php if(isset($model) && $model->{$relationName}->count() ): ?>

            <?php $__currentLoopData = $model->{$relationName}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-tr','data' => ['isRepeater' => true,'model' => $subModel]]); ?>
<?php $component->withName('tables.repeater-table-tr'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['isRepeater' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subModel)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-tr','data' => ['trs' => $trs,'isRepeater' => true]]); ?>
<?php $component->withName('tables.repeater-table-tr'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['trs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($trs),'isRepeater' => true]); ?>

             <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


            <?php endif; ?>

        </tbody>

        <td>
			
            <div  data-repeater-create="" class="btn btn btn-sm text-white   border-green bg-green  m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        <?php echo e(__('Add')); ?>

                    </span>
                </span>
            </div>
			
        </td>

    </table>
</div>
<?php if($initialJs): ?>
<?php $__env->startPush('js_end'); ?>
	<script>
	$('#'+"<?php echo e($repeaterId); ?>").repeater({            
            initEmpty: false,
              isFirstItemUndeletable: true,
            defaultValues: {
                'text-input': 'foo'
            },
             
            show: function() {
                $(this).slideDown();      
				$('input.trigger-change-repeater').trigger('change')   
				 $(this).find('.only-month-year-picker').each(function(index,dateInput){
					reinitalizeMonthYearInput(dateInput)
				 });
				 $(document).find('.datepicker-input:not(.only-month-year-picker)').datepicker({
                            dateFormat: 'mm-dd-yy'
                            , autoclose: true
                        })
				$('input:not([type="hidden"])').trigger('change');
				$(this).find('.dropdown-toggle').remove();
				$(this).find('select.repeater-select').selectpicker("refresh");
					
            },

            hide: function(deleteElement) {
                if($('#first-loading').length){
                        $(this).slideUp(deleteElement,function(){
                   
                               deleteElement();
                            //   $('select.main-service-item').trigger('change');
                    });
                }
                else{
                     if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement,function(){
                   
                               deleteElement();
                              $('select.main-service-item').trigger('change');
							$('input.trigger-change-repeater').trigger('change')                         
							  
                    });
                }         
                }
                       }
        });
	</script>
<?php $__env->stopPush(); ?>
<?php endif; ?> 
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/tables/repeater-table.blade.php ENDPATH**/ ?>