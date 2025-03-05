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
                                    <a href="#" class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
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
<div class="input-hidden-parent">
            <input data-number-of-decimals="0" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted  custom-input-string-width input-text-left  " type="text" value="<?php echo e($mainItemArr['options']['title']??$mainItemId); ?>" data-column-index="-1">
        </div>
                                        
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
            <?php if($isPercentage): ?>
            <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                <div class="input-hidden-parent">
                    <input disabled data-number-of-decimals="2" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-percentage-input  			  repeat-to-right-input-formatted   " type="text" value="<?php echo e(number_format($mainItemArr['data'][$dateAsIndex]??0,2)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                    <input data-number-of-decimals="2" data-group-index="<?php echo e($currentIndex ==0   ? $currentYearRepeaterIndex : -1); ?>" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  " value="<?php echo e($mainItemArr['data'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                </div>
                <span class="ml-2 currency-class">%</span>
            </div>
            <?php else: ?>
            <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                <div class="input-hidden-parent">
                    <input disabled data-number-of-decimals="0" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted  custom-input-numeric-width  " type="text" value="<?php echo e(number_format($mainItemArr['data'][$dateAsIndex]??0)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                    <input data-number-of-decimals="0" data-group-index="<?php echo e($currentIndex ==0   ? $currentYearRepeaterIndex : -1); ?>" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  repeater-with-collapse-input" value="<?php echo e($mainItemArr['data'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                </div>
            </div>
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
            <?php if($currentIndex == 0): ?>
            <div class="

form-group 
three-dots-parent
 

">
                <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                    <div class="input-hidden-parent">
                        <input disabled data-number-of-decimals="0" readonly="" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted  exclude-from-collapse repeat-group-year " type="text" value="<?php echo e(number_format($mainItemArr['total'][$dateAsIndex]??0,0)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                        <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  year-repeater-index-<?php echo e($currentYearRepeaterIndex); ?>  exclude-from-collapse" value="<?php echo e($mainItemArr['total'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                    </div>

                    <span class="ml-2 currency-class">
                        EGP
                    </span>

                </div>



                

            </div>
            <?php else: ?>
            <div class="

form-group 
three-dots-parent
 

">
                <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                    <div class="input-hidden-parent">
                        <input disabled data-number-of-decimals="0" readonly="" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-percentage-input  			  repeat-to-right-input-formatted  exclude-from-collapse repeat-group-year " type="text" value="<?php echo e(number_format($mainItemArr['total'][$dateAsIndex]??0,2)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                        <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  year-repeater-index-<?php echo e($currentYearRepeaterIndex); ?>  exclude-from-collapse" value="<?php echo e($mainItemArr['total'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                    </div>
                    <span class="ml-2">%</span>
                </div>



                <i class="fa fa-ellipsis-h pull-left repeat-to-right row-repeater-icon visibility-hidden"></i>

            </div>
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
			<div class="

 

">
    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
        <div class="input-hidden-parent">
            <input disabled readonly data-number-of-decimals="0" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted   " type="text" value="0" data-column-index="-1">
            <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  total-td" value="0" data-column-index="-1">
        </div>
					  <span class="ml-2 currency-class"> </span>
				    </div>
	 
</div>

            
        </div>
    </td>
    </tr>
    <?php $__currentLoopData = $subItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemId => $subItemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
        <td>
        </td>
        <td>
            <div class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
			
			<div class="

 

">
    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
        <div class="input-hidden-parent">
            <input disabled data-number-of-decimals="0" readonly="" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted  custom-input-string-width input-text-left  " type="text" value="<?php echo e($subItemArr['options']['title']??$subItemId); ?>" data-column-index="-1">
            <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  " value="<?php echo e($subItemArr['options']['title']??$subItemId); ?>" data-column-index="-1">
        </div>
					  <span class="ml-2 currency-class"> </span>
				    </div>
	 
</div>

                
            </div>
        </td>
        <td>

        </td>

        <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td data-column-index="<?php echo e($dateAsIndex); ?>">

            <div data-column-index="<?php echo e($dateAsIndex); ?>" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">

                <div class="">
                    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                        <div class="input-hidden-parent">
                            <input disabled data-number-of-decimals="0" readonly="" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted  custom-input-numeric-width  " type="text" value="<?php echo e(number_format($subItemArr['data'][$dateAsIndex]??0)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                            <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  repeater-with-collapse-input" value="<?php echo e($subItemArr['data'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
                        </div>
                        <span class="ml-2 currency-class"> </span>
                    </div>

                </div>

                
            </div>
        </td>
        <?php
        $currentMonthNumber = explode('-',$dateAsString)[1];
        $currentYear= explode('-',$dateAsString)[0];
        ?>

        <?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>
        <td data-column-index="<?php echo e($dateAsIndex); ?>" class="exclude-from-collapse">
            <div class="d-flex align-items-center justify-content-center">
			
			<div class="

 

">
    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
        <div class="input-hidden-parent">
            <input disabled readonly data-number-of-decimals="0" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted   " type="text" value="<?php echo e(number_format($subItemArr['total'][$dateAsIndex]??0)); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
            <input data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  total-td" value="<?php echo e($subItemArr['total'][$dateAsIndex]??0); ?>" data-column-index="<?php echo e($dateAsIndex); ?>">
        </div>
					  <span class="ml-2 currency-class"> </span>
				    </div>
	 
</div>

                
            </div>

        </td>
        <?php
        $currentYearRepeaterIndex++;
        ?>
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <td>
            <div class="d-flex align-items-center justify-content-center">
			
			<div class="

 

">
    <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
        <div class="input-hidden-parent">
            <input disabled readonly data-number-of-decimals="0" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control copy-value-to-his-input-hidden 

			  expandable-amount-input 			  repeat-to-right-input-formatted   " type="text" value="0" data-column-index="-1">
            <input  data-number-of-decimals="0" type="hidden" data-name="" class="repeat-to-right-input-hidden input-hidden-with-name  total-td" value="0" data-column-index="-1">
        </div>
					  <span class="ml-2 currency-class"> </span>
				    </div>
	 
</div>

                
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