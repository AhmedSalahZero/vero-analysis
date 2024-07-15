
<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<style>
.max-w-checkbox{
	min-width:25px !important;
	width:25px !important;
}
.customize-elements .bootstrap-select{
	min-width:100px !important;
	text-align:center !important;
}
.customize-elements input.only-percentage-allowed{
	min-width:100px !important;
	max-width:100px !important;
	text-align:center !important;
}
    [data-repeater-create] span {
        white-space: nowrap !important;
    }

    .type-btn {
        max-width: 150px;
        height: 70px;
        margin-right: 10px;
        margin-bottom: 5px !important;
    }

    .type-btn:hover {}

    .bootstrap-select {
        min-width: 200px;
    }

    input {
        min-width: 200px;
    }

    input.only-month-year-picker {
        min-width: 100px;
    }

    input.only-greater-than-or-equal-zero-allowed {
        min-width: 120px;
    }

    input.only-percentage-allowed {
        min-width: 80px;
    }

    i {
        text-align: left
    }

    .kt-portlet .kt-portlet__body {
        overflow-x: scroll;
    }

    .repeat-to-r {
        flex-basis: 100%;
        cursor: pointer
    }

    .icon-for-selector {
        background-color: white;
        color: #0742A8;
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: 3px;
        transition: all 0.5s;
    }

    .icon-for-selector:hover {
        transform: scale(1.2);

    }

    .filter-option {
        text-align: center !important;
    }


    td input,
    td select,
    .filter-option {
        border: 1px solid #CCE2FD !important;
        margin-left: auto;
        margin-right: auto;
        color: black;
        font-weight: 400;
    }

    th {
        border-bottom: 1px solid #CCE2FD !important;
    }

    tr:last-of-type {}

    .table tbody+tbody {
        border-top: 1px solid #CCE2FD;
    }

</style>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($pageTitle); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(route('admin.store.expense',['company'=>$company->id ])); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="model_id" value="<?php echo e($model->id ?? 0); ?>">
            <input type="hidden" name="model_name" value="IncomeStatement">
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">
            <div class="kt-portlet">


                <div class="kt-portlet__body">


                    <div class="form-group row justify-content-center">
                        <?php
                        $index = 0 ;
                        ?>
						<div class="d-flex align-items-center justify-content-start " style="margin-right:auto">
                        <?php $__currentLoopData = getTypesForValues(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button data-value="<?php echo e($typeElement['value']); ?>" class="btn mb-5 js-type-btn type-btn btn btn-outline-info <?php echo e($index == 0 ? 'active' :''); ?>"><?php echo e($typeElement['title']); ?></button>
                        <?php
                        $index++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>


                        
                    
                    <?php
                    $tableId = 'fixed_monthly_repeating_amount';
                    $repeaterId = 'fixed_monthly_repeating_amount_repeater';

                    ?>
                    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeRepeater' => false,'repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Monthly <br> Amount'),'helperTitle' => __('Please insert amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monthly <br> Amount')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Increase <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Increase <br> Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 
                            <?php
                            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                            ?>
                            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if( !($subModel instanceof \App\Models\Expense) ){
                            unset($subModel);
                            }

                            ?>
                            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                                <td>
                                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                                </td>
                                <td>

                                    <div class="d-flex align-items-center js-common-parent">
                                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>
                                <td>
                                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyAmount(),0) : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?> class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyAmount() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?>>

                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select payment_terms repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select payment_terms repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS):0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                                    </div>
                                </td>
								
								
								 <td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
								
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                                    </div>
                                </td>


                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getIncreaseRate() : 0)); ?>" <?php if($isRepeater): ?> name="increase_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][increase_rate]" <?php endif; ?>>

                                    </div>
                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ,'options' => getDurationIntervalTypesForSelectExceptMonthly(),'addNew' => false,'class' => 'select2-select   repeater-select','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getDurationIntervalTypesForSelectExceptMonthly()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select   repeater-select','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>


                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         <?php $__env->endSlot(); ?>




                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    



                    
                    <?php
                    $tableId = 'varying_amount';
                    $repeaterId = 'varying_amount_repeater';

                    ?>
                    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
							                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => $dateFormatted . ' <br> ' . __('Amount')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateFormatted . ' <br> ' . __('Amount'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 
                            <?php
                            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                            ?>
                            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if( !($subModel instanceof \App\Models\Expense) ){
                            unset($subModel);
                            }

                            ?>
                            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                                <td>
                                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : ''); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                                </td>
                                <td>

                                    <div class="d-flex align-items-center js-common-parent">
                                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </td>


                                <td>
								
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select payment_terms repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select payment_terms repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                                    </div>
                                </td>
								
<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                                    </div>
                                </td>
                                <?php
                                $payloadIndex = 0 ;
                                ?>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap text-center can-be-repeated-parent">
                                        <input data-column-index="<?php echo e($payloadIndex); ?>" class="form-control can-be-repeated-text only-greater-than-or-equal-zero-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getPayloadAtDate($payloadIndex)) : 0); ?>" type="text">
                                        <input class="can-be-repeated-hidden" type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getPayloadAtDate($payloadIndex) : 0)); ?>" multiple <?php if($isRepeater): ?> name="payload" <?php else: ?> name="<?php echo e($tableId); ?>[0][payload][<?php echo e($fullDate); ?>]" <?php endif; ?>>
                                        <i class="fa fa-ellipsis-h repeat-to-r " title="<?php echo e(__('Repeat To Right')); ?>" data-column-index="<?php echo e($payloadIndex); ?>" data-digit-number="0"></i>
                                    </div>
                                </td>

                                <?php
                                $payloadIndex++ ;
                                ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>






                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         <?php $__env->endSlot(); ?>




                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    

                    
                    <?php
                    $tableId = 'fixed_percentage_of_sales';
                    $repeaterId = 'fixed_percentage_of_sales_repeater';

                    ?>
                    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Revenue <br> Stream'),'helperTitle' => __('Revenue Stream')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue <br> Stream')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue Stream'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base1')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base1'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base2')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base2'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base3')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base3'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Monthly <br> Percentage'),'helperTitle' => __('Please insert percentage excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monthly <br> Percentage')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert percentage excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> To')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> To'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> Value A')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> Value A'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> Value B')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> Value B'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
							                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 





                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            
                            
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 
                            <?php
                            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                            ?>
                            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if( !($subModel instanceof \App\Models\Expense) ){
                            unset($subModel);
                            }

                            ?>
                            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>



                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                                <td>
                                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                                </td>
                                <td>

                                    <div class="d-flex align-items-center js-common-parent">
                                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getRevenueStreamType() : 'service','options' => getRevenueStreamTypes(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getRevenueStreamType() : 'service'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getRevenueStreamTypes()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>

                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseOne() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseOne() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>

                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseTwo() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseTwo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>

                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseThree() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseThree() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>


                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>
                                <td>
                                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyPercentage(),0) : 0)); ?>" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyPercentage() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_percentage" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?>>
                                </td>

                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getConditionalTo() : '','options' => getConditionalToSelect(),'addNew' => false,'class' => 'select2-select js-condition-to-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) conditional_to @else '.e($tableId).'[0][conditional_to] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getConditionalTo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getConditionalToSelect()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select js-condition-to-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) conditional_to @else '.e($tableId).'[0][conditional_to] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                </td>


                                <td>
                                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getConditionalValueA(),0) : 0)); ?>" class="form-control conditional-input conditional-a-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getConditionalValueA() : 0)); ?>" <?php if($isRepeater): ?> name="conditional_value_a" <?php else: ?> name="<?php echo e($tableId); ?>[0][conditional_value_a]" <?php endif; ?>>
                                </td>
								
								 <td>
                                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getConditionalValueB(),0) : 0)); ?>" class="form-control conditional-input conditional-b-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getConditionalValueB() : 0)); ?>" <?php if($isRepeater): ?> name="conditional_value_b" <?php else: ?> name="<?php echo e($tableId); ?>[0][conditional_value_b]" <?php endif; ?>>
                                </td>
								

                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
									

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                                    </div>
                                </td>
								
								<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
								
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                                    </div>
                                </td>


                                


                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 <?php $__env->endSlot(); ?>




                 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                





                
                <?php
                $tableId = 'varying_percentage_of_sales';
                $repeaterId = 'varying_percentage_of_sales_repeater';

                ?>
                <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                     <?php $__env->slot('ths'); ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Revenue <br> Stream')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue <br> Stream'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base1')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base1'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base2')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base2'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base3')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base3'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
						                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => $dateFormatted . ' <br> ' . __('%')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateFormatted . ' <br> ' . __('%'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        
                     <?php $__env->endSlot(); ?>
                     <?php $__env->slot('trs'); ?> 
                        <?php
                        $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                        ?>
                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        if( !($subModel instanceof \App\Models\Expense) ){
                        unset($subModel);
                        }

                        ?>
                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>



                            <td class="text-center">
                                <div class="">
                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                    </i>
                                </div>
                            </td>


                            <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                            <td>
                                <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                            </td>
                            <td>

                                <div class="d-flex align-items-center js-common-parent">
                                    <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                    <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </td>
                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getRevenueStreamType() : 'service','options' => getRevenueStreamTypes(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getRevenueStreamType() : 'service'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getRevenueStreamTypes()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            </td>

                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseOne() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseOne() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            </td>

                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseTwo() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseTwo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            </td>

                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseThree() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseThree() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            </td>

                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </td>
                            
                            <td>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select payment_terms repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select payment_terms repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
								

                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                    <span style="margin-left:3px	">%</span>
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                                </div>
                            </td>
							
							<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
								
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                    <span style="margin-left:3px	">%</span>
                                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                                </div>
                            </td>


                            <?php
                            $payloadIndex = 0 ;
                            ?>
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td>
                                <div class="d-flex align-items-center flex-wrap text-center can-be-repeated-parent">
                                    <input data-column-index="<?php echo e($payloadIndex); ?>" class="form-control can-be-repeated-text only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getPayloadAtDate($payloadIndex),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                    <input class="can-be-repeated-hidden" type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getPayloadAtDate($payloadIndex) : 0)); ?>" multiple <?php if($isRepeater): ?> name="payload" <?php else: ?> name="<?php echo e($tableId); ?>[0][payload][<?php echo e($fullDate); ?>]" <?php endif; ?>>
                                    <i class="fa fa-ellipsis-h repeat-to-r " title="<?php echo e(__('Repeat To Right')); ?>" data-column-index="<?php echo e($payloadIndex); ?>" data-digit-number="0"></i>
                                </div>
                            </td>

                            <?php
                            $payloadIndex++ ;
                            ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            


            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

             <?php $__env->endSlot(); ?>




             <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            








            
            <?php
            $tableId = 'fixed_cost_per_unit';
            $repeaterId = 'fixed_cost_per_unit_repeater';

            ?>
            <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                 <?php $__env->slot('ths'); ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Revenue <br> Stream'),'helperTitle' => __('Revenue Stream')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue <br> Stream')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue Stream'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base1')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base1'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base2')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base2'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base3')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base3'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Cost <br> Per Unit'),'helperTitle' => __('Please insert Cost Per Unit excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cost <br> Per Unit')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert Cost Per Unit excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> To')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> To'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> Value A')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> Value A'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Conditional <br> Value B')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Conditional <br> Value B'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Increase <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Increase <br> Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('trs'); ?> 
                    <?php
                    $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                    ?>
                    <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    if( !($subModel instanceof \App\Models\Expense) ){
                    unset($subModel);
                    }

                    ?>
                    <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>



                        <td class="text-center">
                            <div class="">
                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                </i>
                            </div>
                        </td>


                        <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                        <td>
                            <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                        </td>
                        <td>

                            <div class="d-flex align-items-center js-common-parent">
                                <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </td>
                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getRevenueStreamType() : 'service','options' => getRevenueStreamTypes(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getRevenueStreamType() : 'service'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getRevenueStreamTypes()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </td>


                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseOne() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseOne() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>

                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseTwo() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseTwo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>

                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseThree() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseThree() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>


                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </td>
                        <td>
                            <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyCostOfUnit(),0) : 0)); ?>" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                            <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyCostOfUnit() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_cost_of_unit" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_cost_of_unit]" <?php endif; ?>>

                        </td>

                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getConditionalTo() : '','options' => getConditionalToSelect(),'addNew' => false,'class' => 'select2-select js-condition-to-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) conditional_to @else '.e($tableId).'[0][conditional_to] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getConditionalTo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getConditionalToSelect()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select js-condition-to-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) conditional_to @else '.e($tableId).'[0][conditional_to] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>



                        <td>
                            <input value="<?php echo e((isset($subModel) ? number_format($subModel->getConditionalValueA(),0) : 0)); ?>" class="form-control conditional-input conditional-a-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                            <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getConditionalValueA() : 0)); ?>" <?php if($isRepeater): ?> name="conditional_value_a" <?php else: ?> name="<?php echo e($tableId); ?>[0][conditional_value_a]" <?php endif; ?>>
                        </td>
						
						
						<td>
                            <input value="<?php echo e((isset($subModel) ? number_format($subModel->getConditionalValueB(),0) : 0)); ?>" class="form-control conditional-input conditional-b-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                            <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getConditionalValueB() : 0)); ?>" <?php if($isRepeater): ?> name="conditional_value_b" <?php else: ?> name="<?php echo e($tableId); ?>[0][conditional_value_b]" <?php endif; ?>>
                        </td>




                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
							

                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                            </div>
                        </td>
						
						
								<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
						
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                            </div>
                        </td>


                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getIncreaseRate() : 0)); ?>" <?php if($isRepeater): ?> name="increase_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][increase_rate]" <?php endif; ?>>

                            </div>
                        </td>
                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ,'options' => getDurationIntervalTypesForSelectExceptMonthly(),'addNew' => false,'class' => 'select2-select   repeater-select','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getDurationIntervalTypesForSelectExceptMonthly()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select   repeater-select','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>


                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 <?php $__env->endSlot(); ?>




             <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            





            
            <?php
            $tableId = 'varying_cost_per_unit';
            $repeaterId = 'varying_cost_per_unit_repeater';

            ?>
            <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                 <?php $__env->slot('ths'); ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Revenue <br> Type')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue <br> Type'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base1')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base1'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base2')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base2'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Allocation <br> Base3')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Allocation <br> Base3'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => $dateFormatted . ' <br> ' . __('Amount')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateFormatted . ' <br> ' . __('Amount'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('trs'); ?> 
                    <?php
                    $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
                    ?>
                    <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    if( !($subModel instanceof \App\Models\Expense) ){
                    unset($subModel);
                    }

                    ?>
                    <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>



                        <td class="text-center">
                            <div class="">
                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                </i>
                            </div>
                        </td>


                        <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                        <td>
                            <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                        </td>
                        <td>

                            <div class="d-flex align-items-center js-common-parent">
                                <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                                <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </td>
                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getRevenueStreamType() : 'service','options' => getRevenueStreamTypes(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getRevenueStreamType() : 'service'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getRevenueStreamTypes()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) revenue_stream_type @else '.e($tableId).'[0][revenue_stream_type] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>



                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseOne() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseOne() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_1 @else '.e($tableId).'[0][allocation_base_1] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>

                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseTwo() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseTwo() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_2 @else '.e($tableId).'[0][allocation_base_2] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>

                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getAllocationBaseThree() : '','options' => getAllocationsBases(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getAllocationBaseThree() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getAllocationsBases()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) allocation_base_3 @else '.e($tableId).'[0][allocation_base_3] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>


                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </td>
                        
                        <td>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                            </div>
                        </td>
						
						<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
								
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                            </div>
                        </td>


                        <?php
                        $payloadIndex = 0 ;
                        ?>
                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fullDate => $dateFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <div class="d-flex align-items-center flex-wrap text-center can-be-repeated-parent">
                                <input data-column-index="<?php echo e($payloadIndex); ?>" class="form-control can-be-repeated-text only-greater-than-or-equal-zero-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getPayloadAtDate($payloadIndex)) : 0); ?>" type="text">
                                <input class="can-be-repeated-hidden" type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getPayloadAtDate($payloadIndex) : 0)); ?>" multiple <?php if($isRepeater): ?> name="payload" <?php else: ?> name="<?php echo e($tableId); ?>[0][payload][<?php echo e($fullDate); ?>]" <?php endif; ?>>
                                <i class="fa fa-ellipsis-h repeat-to-r " title="<?php echo e(__('Repeat To Right')); ?>" data-column-index="<?php echo e($payloadIndex); ?>" data-digit-number="0"></i>
                            </div>
                        </td>

                        <?php
                        $payloadIndex++ ;
                        ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        


    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     <?php $__env->endSlot(); ?>




     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    








    
    <?php
    $tableId = 'expense_per_employee';
    $repeaterId = 'expense_per_employee_repeater';

    ?>
    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
         <?php $__env->slot('ths'); ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Department'),'helperTitle' => __('Department')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Department')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Department'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Employee <br> Position')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Employee <br> Position'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Monthly Cost <br> Per Unit'),'helperTitle' => __('Please insert Cost Per Unit excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monthly Cost <br> Per Unit')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert Cost Per Unit excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
			 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Increase <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Increase <br> Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('trs'); ?> 
            <?php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
            ?>
            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            if( !($subModel instanceof \App\Models\Expense) ){
            unset($subModel);
            }

            ?>
            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>



                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>


                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                <td>
                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                </td>
                <td>

                    <div class="d-flex align-items-center js-common-parent">
                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </td>
                <td>
                    
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getDepartment() : 'department','options' => [],'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) department @else '.e($tableId).'[0][department] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getDepartment() : 'department'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) department @else '.e($tableId).'[0][department] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </td>
                <td>
                    
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getEmployee() : 'employee','options' => [],'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) employee @else '.e($tableId).'[0][employee] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getEmployee() : 'employee'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) employee @else '.e($tableId).'[0][employee] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </td>
                <td>
                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyCostOfUnit(),0) : 0)); ?>" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyCostOfUnit() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_cost_of_unit" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_cost_of_unit]" <?php endif; ?>>

                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select  payment_terms','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  payment_terms','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					

                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                    </div>
                </td>
				<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                    </div>
                </td>


                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getIncreaseRate() : 0)); ?>" <?php if($isRepeater): ?> name="increase_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][increase_rate]" <?php endif; ?>>

                    </div>
                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ,'options' => getDurationIntervalTypesForSelectExceptMonthly(),'addNew' => false,'class' => 'select2-select   repeater-select','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getDurationIntervalTypesForSelectExceptMonthly()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select   repeater-select','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </td>


            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

         <?php $__env->endSlot(); ?>




     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    




    
    <?php
    $tableId = 'intervally_repeating_amount';
    $repeaterId = 'intervally_repeating_amount_repeater';

    ?>
    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
         <?php $__env->slot('ths'); ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Start <br> Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start <br> Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Amount'),'helperTitle' => __('Please insert amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> After'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> After')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
			 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Increase <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Increase <br> Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Increase <br> Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('trs'); ?> 
            <?php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
            ?>
            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            if( !($subModel instanceof \App\Models\Expense) ){
            unset($subModel);
            }

            ?>
            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>


                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                <td>
                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                </td>
                <td>

                    <div class="d-flex align-items-center js-common-parent">
                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </td>
                <td>
                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyAmount(),0) : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?> class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyAmount() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?>>

                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					

                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getInterval() : 2,'options' => getPaymentIntervals(),'addNew' => false,'class' => 'select2-select repeater-select  ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) interval @else '.e($tableId).'[0][interval] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getInterval() : 2),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentIntervals()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) interval @else '.e($tableId).'[0][interval] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                    </div>
                </td>
				
				
<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
								
                
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                    </div>
                </td>


                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getIncreaseRate() : 0)); ?>" <?php if($isRepeater): ?> name="increase_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][increase_rate]" <?php endif; ?>>

                    </div>
                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ,'options' => getDurationIntervalTypesForSelectExceptMonthly(),'addNew' => false,'class' => 'select2-select   repeater-select','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' ),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getDurationIntervalTypesForSelectExceptMonthly()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select   repeater-select','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) increase_interval @else '.e($tableId).'[0][increase_interval] @endif','id' => ''.e($type.'_'.'duration_type').'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </td>


            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

         <?php $__env->endSlot(); ?>




     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    






    
    <?php
    $tableId = 'one_time_expense';
    $repeaterId = 'one_time_expense_repeater';

    ?>
    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visiability','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visiability'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
         <?php $__env->slot('ths'); ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Expense <br> Category'),'helperTitle' => __('If you have different expense items under the same category, please insert Category Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense <br> Category')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('If you have different expense items under the same category, please insert Category Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Date'),'helperTitle' => __('Defualt date is Income Statement start date, if else please select a date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Date')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Defualt date is Income Statement start date, if else please select a date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Amount'),'helperTitle' => __('Please insert amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Please insert amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-2','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-2','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
			  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Is Deductible')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Is Deductible'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => 'col-md-1','title' => __('Withhold <br> Tax Rate'),'helperTitle' => __('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'col-md-1','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax Rate')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            
            
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('trs'); ?> 
            <?php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId)->get() : [-1] ;
            ?>
            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            if( !($subModel instanceof \App\Models\Expense) ){
            unset($subModel);
            }

            ?>
            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>


                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                <td>
                    <input value="<?php echo e(isset($subModel) ?  $subModel->getName() : old('name')); ?>" class="form-control" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> type="text">
                </td>
                <td>

                    <div class="d-flex align-items-center js-common-parent">
                        <input value="<?php echo e(isset($subModel) ? $subModel->getCategoryName() : null); ?>" class="form-control js-show-all-categories-popup" <?php if($isRepeater): ?> name="category_name" <?php else: ?> name="<?php echo e($tableId); ?>[0][category_name]" <?php endif; ?> type="text">
                        <?php echo $__env->make('ul-to-trigger-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($subModel) ? $subModel->getStartDateFormatted() : null ,'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getStartDateFormatted() : null ),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </td>
                <td>
                    <input value="<?php echo e((isset($subModel) ? number_format($subModel->getMonthlyAmount(),0) : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?> class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getMonthlyAmount() : 0)); ?>" <?php if($isRepeater): ?> name="monthly_amount" <?php else: ?> name="<?php echo e($tableId); ?>[0][monthly_amount]" <?php endif; ?>>

                </td>
                <td>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getPaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','dataFilterType' => ''.e($type).'','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getPaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					

                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getVatRate() : 0)); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?>>

                    </div>
                </td>
				
				<td>
                                    <div class="d-flex align-items-center">
                                        <input <?php if($isRepeater): ?> name="is_deductible" <?php else: ?> name="<?php echo e($tableId); ?>[0][is_deductible]" <?php endif; ?> class="form-control max-w-checkbox  text-center" value="1" <?php if(isset($subModel) ? $subModel->isDeductible() : false): ?>  checked <?php endif; ?> type="checkbox">
                                    </div>
                                </td>
                
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="<?php echo e(isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : 0); ?>" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getWithholdTaxRate() : 0)); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?>>
                    </div>
                </td>


                


</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

 <?php $__env->endSlot(); ?>




 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 














































</div>


</div>
</div>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.save','data' => []]); ?>
<?php $component->withName('save'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 




<!--end::Form-->

<!--end::Portlet-->
</div>


</div>

</div>




</div>









</div>
</div>
</form>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<script>
    $(document).on('change', '.financial-statement-type', function() {
        validateDuration();
    })
    $(document).on('change', 'select[name="duration_type"]', function() {
        validateDuration();
    })
    $(document).on('change', '#duration', function() {
        validateDuration();
    })

    function validateDuration() {
        let type = $('input[name="type"]:checked').val();
        let durationType = $('select[name="duration_type"]').val();
        let duration = $('#duration').val();
        let isValid = true;
        let allowedDuration = 24;
        if (type == 'forecast' && durationType == 'monthly') {
            allowedDuration = 24;
            isValid = duration <= allowedDuration;
        }
        if (type == 'forecast' && durationType == 'quarterly') {
            allowedDuration = 8;
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'semi-annually') {
            allowedDuration = 4
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'annually') {
            allowedDuration = 2;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'monthly') {
            allowedDuration = 36;
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'quarterly') {
            allowedDuration = 12
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'semi-annually') {
            allowedDuration = 6;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'annually') {
            allowedDuration = 3
            isValid = duration <= allowedDuration
        }
        let allowedDurationText = "<?php echo e(__('Allowed Duration')); ?>";

        $('#allowed-duration').html(allowedDurationText + '  ' + allowedDuration)

        if (!isValid) {
            Swal.fire({
                icon: 'error'
                , title: 'Invalid Duration. Allowed [ ' + allowedDuration + ' ]'
            , })

            $('#duration').val(allowedDuration).trigger('change');

        }


    }

    $(function() {
        $('.financial-statement-type').trigger('change')

    })

</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            let form = document.getElementById('form-id');
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);

            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {
                    $('.save-form').prop('disabled', false);
                    $('.submit-form-btn-new').prop('disabled', false)
                    Swal.fire({
                        icon: 'error'
                        , title: res.responseJSON.message
                    , });
                }
            });
        }
    })

</script>
<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })

</script>
<script>
    function reinitalizeMonthYearInput(dateInput) {
        var currentDate = $(dateInput).val();
        var startDate = "<?php echo e(isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1); ?>";
        startDate = startDate == '-1' ? '' : startDate;
        var endDate = "<?php echo e(isset($studyEndDate) && $studyEndDate? $studyEndDate : -1); ?>";
        endDate = endDate == '-1' ? '' : endDate;

        $(dateInput).datepicker({
                viewMode: "year"
                , minViewMode: "year"
                , todayHighlight: false
                , clearBtn: true,


                autoclose: true
                , format: "mm/01/yyyy"
            , })
            .datepicker('setDate', new Date(currentDate))
            .datepicker('setStartDate', new Date(startDate))
            .datepicker('setEndDate', new Date(endDate))


    }

    $(function() {

        $('.only-month-year-picker').each(function(index, dateInput) {
            reinitalizeMonthYearInput(dateInput)
        })



    });
    //  $(document).on('change', '#expense_type', function() {
    //      $('.js-parent-to-table').hide();
    //      let tableId = '.' + $(this).val();
    //      $(tableId).closest('.js-parent-to-table').show();
    //
    //  }) 
    $(document).on('click', '.js-type-btn', function(e) {
        e.preventDefault();
        $('.js-type-btn').removeClass('active');
        $(this).addClass('active');
        $('.js-parent-to-table').hide();
        let tableId = '.' + $(this).attr('data-value');
        $(tableId).closest('.js-parent-to-table').show();

    })
    $(function() {
        $('#expense_type').trigger('change')
        $('.js-type-btn.active').trigger('click')
    })

    $(function() {
        $(document).on('click', '.js-show-all-categories-trigger', function() {
            const elementToAppendIn = $(this).parent().find('.js-append-into');
            const texts = [];
            let lis = '';
            text = '<u><a href="#" data-close-new class="text-decoration-none mb-2 d-inline-block text-nowrap ">' + 'Add New' + '</a></u>'
            lis += '<li >' + text + '</li>'
            $(this).closest('table').find('.js-show-all-categories-popup').each(function(index, element) {
                let text = $(element).val().trim();
                if (text && !texts.includes(text)) {
                    texts.push(text)
                    text = '<a href="#" data-add-new class="text-decoration-none mb-2 d-inline-block">' + text + '</a>'
                    lis += '<li >' + text + '</li>'
                }
            })




            elementToAppendIn.removeClass('d-none');
            elementToAppendIn.find('ul').empty().append(lis);
        })


    })
    $(document).on('click', '[data-add-new]', function(e) {
        e.preventDefault();
        let content = $(this).html();
        $(this).closest('.js-common-parent').find('input').val(content);
    })
    $(document).on('click', '[data-close-new]', function(e) {
        e.preventDefault();
        $(this).closest('.js-append-into').addClass('d-none');
        $(this).closest('.js-common-parent').find('input').val('').focus();
    })
    $(document).on('click', function(e) {
        let closestParent = $(e.target).closest('.js-append-into').length;
        if (!closestParent && !$(e.target).hasClass('js-show-all-categories-trigger')) {
            $('.js-append-into').addClass('d-none');
        }
    })
    $(function() {
        // alert($('.reapter-select').length)
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-delete]').trigger('click');
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-create]').trigger('click');
    });

</script>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('js_end'); ?>

<script>
    
    $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('blur', function() {

        if ($(this).val() == '') {
            if (isNumber(oldValForInputNumber)) {
                $(this).val(oldValForInputNumber)
            }
        }
    })

    $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
        if (!$(this).hasClass('exclude-text')) {
            let val = $(this).val()
            val = number_unformat(val)
            if (isNumber(val)) {
                $(this).parent().find('input[type="hidden"]').val(val)
            }

        }
    })
    $(document).on('click', '.repeat-to-r', function() {
        const columnIndex = $(this).data('column-index');
        const digitNumber = $(this).data('digit-number');
        const val = $(this).parent().find('input[type="hidden"]').val();
        $(this).closest('tr').find('.can-be-repeated-parent').each(function(index, parent) {
            if (index > columnIndex) {
                $(parent).find('.can-be-repeated-text').val(val);
                $(parent).find('.can-be-repeated-text').val(number_format(val, digitNumber));

            }
        })
    })
	
	
	$('select.js-condition-to-select').change(function(){
		const value = $(this).val() ;
		const conditionalValueTwoInput = $(this).closest('tr').find('input.conditional-b-input') ;
		console.log(value,value == 'between-and-equal')
		if(value == 'between-and-equal' || value == 'between'){
			conditionalValueTwoInput.prop('disabled',false).trigger('change');
		}else{
			conditionalValueTwoInput.prop('disabled',true).trigger('change');
		}
	})	
	
	$('select.js-condition-to-select').trigger('change');
	$(document).on('change','.conditional-input',function(){
		if(!$(this).closest('tr').find('conditional-b-input').prop('disabled')){
			const conditionalA = $(this).closest('tr').find('.conditional-a-input').val();
			const conditionalB = $(this).closest('tr').find('.conditional-b-input').val();
			if(conditionalA >= conditionalB ){
				if(conditionalA == 0 && conditionalB == 0){
					return ;
				}
				Swal.fire('conditional a must be less than conditional b value');
				$(this).closest('tr').find('.conditional-a-input').val($(this).closest('tr').find('.conditional-b-input').val() - 1);
			}
		}
		
	})
</script>
<script>
const handlePaymentTermModal = function(){
	const parentTermsType = $(this).closest('select').val();
	console.log(parentTermsType)
	const tableId = $(this).closest('table').attr('id');
	if(parentTermsType == 'customize'){
		 $(this).closest('tr').find('#' + tableId + 'test-modal-id' ).modal('show') 
	}
	
	
	
} ;
$(document).on('change','select.payment_terms',handlePaymentTermModal)
$('select.js-due_in_days').change(function(){
	// const selectValue = $(this).val();
	// $(this).find('option').prop('selected',false)
	// $(this).find('option[value="'+selectValue+'"]').prop('selected',true);
	// reinitializeSelect2();
})

//$(document).on('click','option',handlePaymentTermModal)
$(document).on('change','.rate-element',function(){
	let total = 0 ;
	const parent = $(this).closest('tbody') ;
	console.log(parent.find('.rate-element-hidden'));
	parent.find('.rate-element-hidden').each(function(index,element){
		total += parseFloat($(element).val());
	});
	console.log(total);
	parent.find('td.td-for-total-payment-rate').html(number_format(total,2) + ' %');
	
})
$(function(){
	$('.rate-element').trigger('change');
})
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/admin/ready-made-forms/expense.blade.php ENDPATH**/ ?>