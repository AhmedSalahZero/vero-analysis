<?php
use App\Models\NonBankingService\Study;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
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
                            ?>
                            <?php $__currentLoopData = $tableDataFormatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableIndex => $currentTableData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $subItems = $currentTableData['sub_items']??[] ;
                            $hasSubItems = count($subItems);
                            ?>
                            <tr data-is-main-row data-repeat-formatting-decimals="0" data-repeater-style>
                                <td>
                                    <?php if($hasSubItems): ?>
                                    <a href="#"  class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
                                        <i class="fas fa-angle-double-down expand-icon   exclude-icon"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-column " style="gap:10px">
                                        <?php
                                        $currentIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $currentTableData['main_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainItemId => $mainItemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => $mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals'],'currentVal' => $mainItemArr['options']['title']??$mainItemId,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals']),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['title']??$mainItemId),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        <?php
                                        $currentIndex++;
                                        ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </td>
                                <td>
                                    <?php if($hasSubItems): ?>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a data-toggle="modal" data-target="#add-new-cost-of-good" href="#" class="btn btn-2-bg btn-sm btn-brand btn-pill"><?php echo e(__('+')); ?></a>


                                        

    </div>
    <?php endif; ?>
    </td>
    <?php
    $currentYearRepeaterIndex = 0 ;
    ?>

    <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   
    <td data-column-index="<?php echo e($dateAsIndex); ?>">

        <div data-column-index="<?php echo e($dateAsIndex); ?>" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
            <?php
            $currentIndex = 0 ;
            ?>
            <?php $__currentLoopData = $currentTableData['main_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainItemTitle => $mainItemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $isPercentage = $mainItemArr['options']['is-percentage']??$defaultClasses[$currentIndex]['is-percentage'] ;
            ?>
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => false,'classes' => $mainItemArr['options']['classes']??$defaultClasses[$currentIndex]['classes'],'dataGroupIndex' => ''.e($currentIndex ==0   ? $currentYearRepeaterIndex : -1).'','formattedInputClasses' => $mainItemArr['options']['formatted-input-classes']??$defaultClasses[$currentIndex]['formatted-input-classes'],'removeThreeDots' => true,'removeCurrency' => true,'mark' => $isPercentage ? '%' : '','isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => $mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals'],'currentVal' => $mainItemArr['data'][$dateAsIndex]??0,'isPercentage' => $isPercentage,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['classes']??$defaultClasses[$currentIndex]['classes']),'data-group-index' => ''.e($currentIndex ==0   ? $currentYearRepeaterIndex : -1).'','formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['formatted-input-classes']??$defaultClasses[$currentIndex]['formatted-input-classes']),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPercentage ? '%' : ''),'is-number' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals']),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['data'][$dateAsIndex]??0),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPercentage),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            <?php
            $currentIndex++;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>




    </td>

    <?php
    $currentMonthNumber = explode('-',$dateAsString)[1];
    $currentYear= explode('-',$dateAsString)[0];
    ?>
    <?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>
    <td data-column-index="<?php echo e($dateAsIndex); ?>" class="exclude-from-collapse">
		<?php
			$currentIndex =0 ;
		?>
		 
		<?php $__currentLoopData = $currentTableData['main_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainItemId => $mainItemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="d-flex align-items-center justify-content-center">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'mark' => '','currentVal' => $mainItemArr['total'][$dateAsIndex]??0 ,'formattedInputClasses' => 'exclude-from-collapse repeat-group-year','classes' => 'year-repeater-index-'.$currentYearRepeaterIndex.' ' .' exclude-from-collapse','isPercentage' => $mainItemArr['options']['is-percentage']??$defaultClasses[$currentIndex]['is-percentage'],'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['total'][$dateAsIndex]??0 ),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclude-from-collapse repeat-group-year'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('year-repeater-index-'.$currentYearRepeaterIndex.' ' .' exclude-from-collapse'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainItemArr['options']['is-percentage']??$defaultClasses[$currentIndex]['is-percentage']),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>
		<?php
			$currentIndex++;
		?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
	


    </td>
    <?php
    $currentYearRepeaterIndex++;
    ?>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <td>
        <div class="d-flex align-items-center justify-content-center">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => 'total-td','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total-td'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>
    </td>
    </tr>
    <?php $__currentLoopData = $subItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemId => $subItemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
        <td>
        </td>
        <td>
            <div class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => 'custom-input-string-width input-text-left ','removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $subItemArr['options']['title']??$subItemId,'classes' => '','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom-input-string-width input-text-left '),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['options']['title']??$subItemId),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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

            <div data-column-index="<?php echo e($dateAsIndex); ?>" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'formattedInputClasses' => $subItemArr['options']['formatted-input-classes']??$defaultClasses[0]['formatted-input-classes'],'removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => $subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals'],'currentVal' => $subItemArr['data'][$dateAsIndex]??0,'classes' => $subItemArr['options']['classes']??'','isPercentage' => $subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals'],'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['options']['formatted-input-classes']??$defaultClasses[0]['formatted-input-classes']),'removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals']),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['data'][$dateAsIndex]??0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['options']['classes']??''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals']),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'mark' => ' ','currentVal' => $subItemArr['total'][$dateAsIndex]??0 ,'formattedInputClasses' => 'exclude-from-collapse ','classes' => 'year-repeater-index-'.$currentYearRepeaterIndex.' ' .' exclude-from-collapse','isPercentage' => false,'name' => '','columnIndex' => $dateAsIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subItemArr['total'][$dateAsIndex]??0 ),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclude-from-collapse '),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('year-repeater-index-'.$currentYearRepeaterIndex.' ' .' exclude-from-collapse'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateAsIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => true,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => 0,'classes' => 'total-td','isPercentage' => false,'name' => '','columnIndex' => -1]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => true,'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => 0,'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total-td'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => -1]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </td>
    </tr>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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




    <!--End:: Tab Content-->



    <!--End:: Tab Content-->
    </div>
    </div>
    </div>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('js'); ?>

    
   
    <script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
    </script>


    <script>
        $(document).on('click', '.js-close-modal', function() {
            $(this).closest('.modal').modal('hide');
        })

    </script>
   
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('js'); ?>
    <script src="/custom/js/non-banking-services/common.js"></script>
    <script>
        $(function() {
            //	$('[data-group-index]').trigger('change');
        })

    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/income-statement/forecast.blade.php ENDPATH**/ ?>