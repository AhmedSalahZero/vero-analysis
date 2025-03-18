<?php $attributes = $attributes->exceptProps([
'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true ,
'initEmpty'=>false,
'firstElementDeletable'=>false,
'hideAddBtn'=>false,
'canAddNewItem'=>true,
'removeActionBtn'=>false,
'tableClass'=>'col-md-12',
'tableClasses'=>'',
'actionBtnTitle'=>__('Action'),
'appendSaveOrBackBtn'=>false,
'addExpenseName'=>false,
'showRows'=>true,
'departmentId'=>0,
'department'=>null ,
'fontSizeClass'=>'',
'addExpenseType'=>false
]); ?>
<?php foreach (array_filter(([
'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true ,
'initEmpty'=>false,
'firstElementDeletable'=>false,
'hideAddBtn'=>false,
'canAddNewItem'=>true,
'removeActionBtn'=>false,
'tableClass'=>'col-md-12',
'tableClasses'=>'',
'actionBtnTitle'=>__('Action'),
'appendSaveOrBackBtn'=>false,
'addExpenseName'=>false,
'showRows'=>true,
'departmentId'=>0,
'department'=>null ,
'fontSizeClass'=>'',
'addExpenseType'=>false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php

$canAddNewItem = true;
?>

<div class="<?php echo e($tableClass); ?> <?php echo e($parentClass); ?>  js-parent-to-table" data-table-id="<?php echo e($repeaterId??''); ?>" style="display:none">

    <?php if($addExpenseName): ?>
    <div class="row align-items-center mb-3 mt-3 border-bottom-green  ">
        <div class="col-md-4">
            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                <?php echo e(__('Department Name')); ?>

            </h3>
            <div class="form-group mb-0 d-flex" style="margin-right:auto;gap:20px;">
                <input readonly class="form-control" name="departments[<?php echo e($departmentId); ?>][name]" value="<?php echo e($department ? $department->getName():''); ?>" placeholder="">
            </div>
        </div>

        <?php if($addExpenseType): ?>
        <div class="col-md-2">


            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                <?php echo e(__('Expense Type')); ?>

            </h3>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
							<div class="form-group mb-0 d-flex" style="margin-right:auto;gap:20px;">
						<input readonly class="form-control"  value="<?php echo e($department ? $department->getExpenseTypeName():''); ?>" placeholder="">
					</div>
                       
                    </div>
                </div>
            </div>




        </div>
        <?php endif; ?>


        <div class="col-md-5">
         


        </div>

    </div>
    <?php endif; ?>
    <?php if($showRows): ?>
    <table <?php if($initialJs): ?> id="<?php echo e($repeaterId); ?>" <?php endif; ?> class="table  <?php echo e($repeaterId); ?> <?php echo e($tableClasses); ?> table-white  repeater-class repeater <?php echo e($tableName); ?>">
        <thead>
            <tr>
                <?php if(!$removeActionBtn): ?>
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => $fontSizeClass,'class' => 'col-md-1 action-class','title' => $actionBtnTitle]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['fontSizeClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fontSizeClass),'class' => 'col-md-1 action-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionBtnTitle)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                <?php endif; ?>
                <?php echo e($ths); ?>


            </tr>
        </thead>
        <tbody data-repeater-list="<?php echo e($tableName); ?>">

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
            
            <?php if($canAddNewItem && !$removeActionBtn): ?>
            <div data-repeater-create="" class="btn btn btn-sm text-white add-row   border-green bg-green  m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        <?php if(!$hideAddBtn): ?>
                        <?php echo e(__('Add')); ?>

                        <?php endif; ?>
                    </span>
                </span>
            </div>
            <?php endif; ?>
        </td>

    </table>
    <?php endif; ?>
    <?php if($appendSaveOrBackBtn): ?>
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.save-or-back-inside-table','data' => ['department' => $department,'btnText' => __('Create')]]); ?>
<?php $component->withName('save-or-back-inside-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['department' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($department),'btn-text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Create'))]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    <?php endif; ?>
</div>

<input type="hidden" id="initi-empty-<?php echo e($repeaterId); ?>" value="<?php echo e($initEmpty); ?>">
<input type="hidden" id="first-element-deleteable-<?php echo e($repeaterId); ?>" value="<?php echo e($firstElementDeletable); ?>">
<?php if($initialJs): ?>
<?php $__env->startPush('js_end'); ?>
<script>
    var initEmpty = $("#initi-empty-<?php echo e($repeaterId); ?>").val() === "1" ? true : false;
    var firstElementDeleteable = $("#first-element-deleteable-<?php echo e($repeaterId); ?>").val() === "1" ? true : false;
    var studyStartDate = $('#study-start-date').val()
    var studyEndDate = $('#study-end-date').val()


    $('#' + "<?php echo e($repeaterId); ?>").repeater({
        initEmpty: initEmpty
        , isFirstItemUndeletable: !firstElementDeleteable
        , defaultValues: {
            'grace_period': 0
            , 'tenor': 12
            , "margin_rate": 0
            , "step_rate": 0
            , "loan_type": "normal"
            , "loan_nature": "fixed-at-end"
            , "installment_interval": "monthly"
            , "step_interval": "annually",

            "amount": 0
            , "increase_interval": "annually"
            , "payment_terms": "cash"
            , "vat_rate": 0
            , "start_date": studyStartDate
            , "end_date": studyEndDate,

        },

        show: function() {

            var appendNewOptionsToAllSelects = function(currentRepeaterItem) {

                if ($('[data-modal-title]').length) {

                    let currentSelect = $(currentRepeaterItem).find('select').attr('data-modal-name')
                    let modalType = $(currentRepeaterItem).find('select').attr('data-modal-type')
                    let selects = {}
                    $('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"] option').each(function(index, option) {
                        selects[$(option).attr('value')] = $(option).html()
                    })

                    $('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"]').each(function(index, select) {
                        var selectedValue = $(select).val()
                        var currentOptions = ''
                        var currentOptionsValue = []
                        $(select).find('option').each(function(index, option) {
                            var currentOption = $(option).attr('value')
                            var isCurrentSelected = currentOption == selectedValue ? 'selected' : ''
                            currentOptions += '<option value="' + currentOption + '" ' + isCurrentSelected + ' > ' + $(option).html() + ' </option>'
                            currentOptionsValue.push(currentOption)
                        })
                        for (var allOptionValue in selects) {
                            if (!currentOptionsValue.includes(allOptionValue)) {
                                var isCurrentSelected = false
                                currentOptions += '<option value="' + allOptionValue + '" ' + isCurrentSelected + ' > ' + selects[allOptionValue] + ' </option>'
                                currentOptionsValue.push(allOptionValue)
                            }
                        }
                        $(select).empty().append(currentOptions).selectpicker('refresh').trigger('change')

                    })
                }
            }
            $(this).slideDown();
            $('input.trigger-change-repeater').trigger('change')
            $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                reinitalizeMonthYearInput(dateInput)
            });
            $(document).find('.datepicker-input:not(.only-month-year-picker)').datepicker({
                dateFormat: 'yy-mm-dd'
                , autoclose: true
            })
            $('input:not(.exclude-from-trigger-change-when-repeat):not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");
            appendNewOptionsToAllSelects(this)
        },

        hide: function(deleteElement) {

            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {

                if (confirm('Are you sure you want to delete this element?')) {

                    $(this).slideUp(deleteElement, function() {
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