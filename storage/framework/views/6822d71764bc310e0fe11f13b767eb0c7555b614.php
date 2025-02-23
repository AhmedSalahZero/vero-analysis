<?php
use App\Models\FinancialPlanning\Study;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/financial-planning/common.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == Study::STUDY ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Study::STUDY); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e($tableTitle); ?>

                    </a>
                </li>
            </ul>



        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <?php
            $currentType = Study::STUDY ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">




                    <?php
                    $rowIndex = 0;
                    ?>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableClasses' => 'table-condensed table-row-spacing income-class-table','removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden scrollable-table','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['tableClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('table-condensed table-row-spacing income-class-table'),'removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden scrollable-table'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down first-column-th-class','title' => __('+/-')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('+/-'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down first-column-th-class','title' => __('Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Add')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Add'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $currentMonthNumber = explode('-',$dateAsString)[1];
                            $currentYear= explode('-',$dateAsString)[0];
                            $currentYearRepeaterIndex = 0 ;
                            ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['dataColumnIndex' => ''.e($dateAsIndex).'','class' => ' interval-class header-border-down ','title' => dateFormatting($dateAsString, 'M\' Y')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-column-index' => ''.e($dateAsIndex).'','class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(dateFormatting($dateAsString, 'M\' Y'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            <?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['icon' => true,'dataColumnIndex' => ''.e($dateAsIndex).'','fontSizeClass' => 'font-14px','class' => ' interval-class header-border-down '.e('year-repeater-index-'.$currentYearRepeaterIndex).' collapse-before-me exclude-from-collapse ','title' => __('Total Yr.').' <br> '. $currentYear]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => true,'data-column-index' => ''.e($dateAsIndex).'','font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' interval-class header-border-down '.e('year-repeater-index-'.$currentYearRepeaterIndex).' collapse-before-me exclude-from-collapse ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total Yr.').' <br> '. $currentYear)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php
                            $currentYearRepeaterIndex ++;
                            ?>
                            <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Total')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 

                            <?php
                            $currentExpenseType='cost-of-service';
                            ?>
                            <tr data-is-main-row data-repeat-formatting-decimals="0" data-repeater-style>
                                <td>
                                    <a href="#" class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
                                        <i class="fas fa-angle-double-down expand-icon   exclude-icon"></i>
                                    </a>
                                </td>
                                <td>
                                    <div   class="d-flex align-items-center justify-content-center flex-column " style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('Cost Of Goods / Service'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cost Of Goods / Service')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('% Revenue'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('% Revenue')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a data-toggle="modal" data-target="#add-new-cost-of-good" href="#" class="btn btn-2-bg btn-sm btn-brand btn-pill"><?php echo e(__('+')); ?></a>


                                        <div class="modal fade" id="add-new-cost-of-good" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered max-width-modal-income-statement" role="document">
                                                <div class="modal-content modal-content-border">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-black" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Add ?')); ?></h5>
                                                        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="btn-parent d-flex justify-content-between " style="gap:10px !important">
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="<?php echo e(route('view.cost.expenses',['company'=>$company->id ,'study'=>$study->id ])); ?>" class="btn btn-outline-info "><?php echo e(__('Cost & Expenses')); ?></a>
                                                            </span>
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="<?php echo e(route('view.manpower',['company'=>$company->id , 'study'=>$study->id,'expenseType'=>$currentExpenseType])); ?>" class="btn btn-outline-info "><?php echo e(__('Manpower Expense')); ?></a>
                                                            </span>
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="<?php echo e(route('view.manpower',['company'=>$company->id , 'study'=>$study->id,'expenseType'=>$currentExpenseType])); ?>" class="btn btn-outline-info "><?php echo e(__('Expense Per Employee')); ?></a>
                                                            </span>

                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="#" class="btn btn-outline-info "><?php echo e(__('Depreciation Expense')); ?></a>
                                                            </span>

                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="#" class="btn btn-outline-info "><?php echo e(__('Add New Fixed Asset')); ?></a>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary border-green" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                <?php
                                $currentYearRepeaterIndex = 0 ;
                                ?>

                                <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td data-column-index="<?php echo e($dateAsIndex); ?>">

                                    <div data-column-index="<?php echo e($dateAsIndex); ?>" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['classes' => 'repeater-with-collapse-input','dataGroupIndex' => ''.e($currentYearRepeaterIndex).'','formattedInputClasses' => ' custom-input-numeric-width','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'isPercentage' => false,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('repeater-with-collapse-input'),'data-group-index' => ''.e($currentYearRepeaterIndex).'','formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' custom-input-numeric-width'),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => 2,'currentVal' => 0,'classes' => '','isPercentage' => true,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => 2,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>




                                </td>

                                <?php
                                $currentMonthNumber = explode('-',$dateAsString)[1];
                                $currentYear= explode('-',$dateAsString)[0];
                                ?>
                                <?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>

                                <td data-column-index="<?php echo e($dateAsIndex); ?>" class="exclude-from-collapse">
                                    <div class="d-flex align-items-center justify-content-center">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'mark' => ' ','currentVal' => 0 ,'formattedInputClasses' => 'exclude-from-collapse','classes' => 'year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse','isPercentage' => true,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(0 ),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclude-from-collapse'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                </td>
                                <?php
                                $currentYearRepeaterIndex++;
                                ?>
                                <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </td>
                            </tr>

                            <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
                                <td>
                                </td>
                                <td>
                                    <div  class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('Salaries Expenses'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Salaries Expenses')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </td>
                                <td>

                                </td>

                                <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td data-column-index="<?php echo e($dateAsIndex); ?>">

                                    <div  data-column-index="<?php echo e($dateAsIndex); ?>" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => 'custom-input-numeric-width','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $salaryExpensePerTypeAndExpenseTypes['manpower$$$$cost-of-service']->{'salary_expenses_'.$dateAsIndex} ?? 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-numeric-width'),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($salaryExpensePerTypeAndExpenseTypes['manpower$$$$cost-of-service']->{'salary_expenses_'.$dateAsIndex} ?? 0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </td>
                                <?php
                                $currentMonthNumber = explode('-',$dateAsString)[1];
                                $currentYear= explode('-',$dateAsString)[0];
                                ?>

                                <?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>

                                <td data-column-index="<?php echo e($dateAsIndex); ?>" class="exclude-from-collapse">
                                    <div class="d-flex align-items-center justify-content-center">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'mark' => ' ','currentVal' => 0 ,'formattedInputClasses' => 'exclude-from-collapse','classes' => 'year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse','isPercentage' => true,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(0 ),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclude-from-collapse'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                </td>
                                <?php
                                $currentYearRepeaterIndex++;
                                ?>
                                <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </td>
                            </tr>


                            <?php for($i = 0 ; $i<0 ; $i++): ?> <tr data-is-main-row data-repeat-formatting-decimals="0" data-repeater-style>
                                <td>
                                    <a href="#" class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
                                        <i class="fas fa-angle-double-down expand-icon   exclude-icon"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-column " style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('Sales Revenues'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Sales Revenues')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('Sales Growth %'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Sales Growth %')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="#" class="btn btn-2-bg btn-sm btn-brand btn-pill"><?php echo e(__('+')); ?></a>

                                    </div>
                                </td>

                                <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>

                                    <div class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-numeric-width','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-numeric-width'),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => 2,'currentVal' => 0,'classes' => '','isPercentage' => true,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => 2,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>



                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </td>
                                </tr>


                                <?php for($k = 0 ; $k < 5 ; $k++): ?> <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
                                    <td>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => __('Sub Sales Revenues'),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Sub Sales Revenues')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <td>

                                    </td>

                                    <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>

                                        <div class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => 'custom-input-numeric-width','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-numeric-width'),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>



                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    </tr>
                                    <?php endfor; ?>

                                    <?php endfor; ?>

                         <?php $__env->endSlot(); ?>




                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                </div>
            </div>




            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>





<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>


<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'transfer_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Transfer Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script src="/custom/js/financial-planning/common.js"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/financial_planning/income-statement/forecast.blade.php ENDPATH**/ ?>