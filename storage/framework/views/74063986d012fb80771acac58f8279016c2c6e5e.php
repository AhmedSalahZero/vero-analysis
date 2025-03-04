<?php
 use App\Models\NonBankingService\Study;
 use App\Models\NonBankingService\MicrofinanceBreakdown;
?>
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
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($title); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 



<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">


        <form id="factoring-loans" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($disabled) && $disabled ? '#' :  $storeRoute); ?>">

            <?php echo csrf_field(); ?>
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">
            <input type="hidden" name="study_id" value="<?php echo e($study->id); ?>">


			  
             <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Microfinance Branches & Loan Cases Info')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.microfinance-branches-loan-cases-info']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.microfinance-branches-loan-cases-info')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row microfinance-branches-loan-cases-info">
                        <?php
                        $rowIndex = 0;
                        ?>


                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                             <?php $__env->slot('ths'); ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down first-column-th-class','title' => __('Item')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">


                                    <td>
                                        <div class="">
                                            <input value="<?php echo e(__('Operating Months Per Year')); ?>" disabled class="form-control text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <td>
                                        <div class="form-group three-dots-parent">
                                            <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                                                <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="<?php echo e(sumNumberOfOnes($yearsWithItsMonths,$year,$datesIndexWithYearIndex)); ?>" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
                                                <span class="ml-2">
                                                    <b style="visibility:hidden">%</b>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>
								
								
								  <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="<?php echo e(__('Branches Count')); ?>" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $currentVal =0;
                                    ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'currentVal' => $currentVal,'formattedInputClasses' => '','classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++ ;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>
								
								
								 <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="<?php echo e(__('Loan Officers Count')); ?>" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $currentVal =0;
                                    ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'currentVal' => $currentVal,'formattedInputClasses' => '','classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++ ;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>
								


                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="<?php echo e(__('Total Loan Case Count')); ?>" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $currentVal =  0;
                                    ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'currentVal' => $currentVal,'formattedInputClasses' => '','classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeCurrency' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++ ;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>






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
            
			

            

            
             <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Microfinance Revenue Projection By Category')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.revenue-projection-by-category']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.revenue-projection-by-category')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row revenue-projection-by-category">
                        <?php
                        $rowIndex = 0;
                        ?>


                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                             <?php $__env->slot('ths'); ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down first-column-th-class','title' => __('Item')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">


                                    <td>
                                        <div class="">
                                            <input value="<?php echo e(__('Operating Months Per Year')); ?>" disabled class="form-control text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <td>
                                        <div class="form-group three-dots-parent">
                                            <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                                                <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="<?php echo e(sumNumberOfOnes($yearsWithItsMonths,$year,$datesIndexWithYearIndex)); ?>" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
                                                <span class="ml-2">
                                                    <b style="visibility:hidden">%</b>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>


                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">


                                    <td>
                                        <div class="">
                                            <input value="<?php echo e(__('Growth Rate %')); ?>" disabled class="form-control text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;
							
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['currentVal' => $model->microfinanceRevenueProjectionByCategory ? $model->microfinanceRevenueProjectionByCategory->getGrowthRateAtYearIndex($year) : 0,'classes' => 'only-greater-than-or-equal-zero-allowed recalculate-gr gr-field','isPercentage' => true,'name' => 'MicrofinanceRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceRevenueProjectionByCategory ? $model->microfinanceRevenueProjectionByCategory->getGrowthRateAtYearIndex($year) : 0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed recalculate-gr gr-field'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MicrofinanceRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>




                             

                                


                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="<?php echo e(__('Avg Loan Case Amount')); ?>" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $currentVal = $model->microfinanceRevenueProjectionByCategory ? $model->microfinanceRevenueProjectionByCategory->getLoanAmountsAtYearIndex($year) : 0;
							
                                    ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'currentVal' => $currentVal,'formattedInputClasses' => 'current-growth-rate-result-value-formatted','classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value factoring-projection-amount recalculate-factoring current-growth-rate-result-value','isPercentage' => false,'name' => 'MicrofinanceRevenueProjectionByCategory['.'loan_case_amounts'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('current-growth-rate-result-value-formatted'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value factoring-projection-amount recalculate-factoring current-growth-rate-result-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MicrofinanceRevenueProjectionByCategory['.'loan_case_amounts'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++ ;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>
								
								      <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="<?php echo e(__('Total Loan Case Amount')); ?>" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $currentVal =  0;
                                    ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['readonly' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 0,'currentVal' => $currentVal,'formattedInputClasses' => '','classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'formattedInputClasses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++ ;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>
								






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
            


            

				
				
				 
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Microfinance Breakdown')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.admin-fees']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.admin-fees')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row admin-fees">
                        <?php
                        $rowIndex = 0;
                        $relationName ='microfinanceBreakdowns';
                        $repeaterId =$relationName.'repeater';
						?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableName' => $relationName,'repeaterId' => $repeaterId,'removeActionBtn' => false,'removeRepeater' => false,'initialJs' => true,'repeaterWithSelect2' => true,'canAddNewItem' => true,'parentClass' => 'js-remove-hidden scrollable-table','hideAddBtn' => true,'relationName' => $relationName,'isRepeater' => true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relationName),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'removeActionBtn' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'initialJs' => true,'repeater-with-select2' => true,'canAddNewItem' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden scrollable-table'),'hide-add-btn' => true,'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relationName),'isRepeater' => true]); ?>
                             <?php $__env->slot('ths'); ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' category-selector-class header-border-down w-header-400','title' => __('Product / Installment Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' category-selector-class header-border-down w-header-400','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Product / Installment Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' tenor-selector-class header-border-down ','title' => __('Tenor <br> (Months)')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Tenor <br> (Months)'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' tenor-selector-class header-border-down ','title' => __('Funded')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Funded'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                     
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' tenor-selector-class header-border-down ','title' => __('Info')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Info'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 
								<?php
                            $rows = count($model->microfinanceBreakdowns) ? $model->microfinanceBreakdowns : [-1] ;
                            ?>
                             <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                             if( !($subModel instanceof MicrofinanceBreakdown) ){
                             unset($subModel);
                             }
                            ?>
					
                                <tr 
								
								data-repeater-item
								
								data-repeat-formatting-decimals="2" data-repeater-style>
									
									<td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>
								
                                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">

                                    <td>
                           				  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['required' => true,'label' => '','pleaseSelect' => false,'selectedValue' => isset($subModel) ? $subModel->getMicrofinanceProductId() : '','options' => $microfinanceProductsFormatted,'addNew' => false,'class' => 'select2-select  repeater-select  ','all' => false,'name' => 'microfinance_product_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getMicrofinanceProductId() : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($microfinanceProductsFormatted),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  repeater-select  ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'microfinance_product_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                           				  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['required' => true,'label' => '','pleaseSelect' => false,'selectedValue' => isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly','options' => [['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]],'addNew' => false,'class' => 'select2-select  repeater-select  ','all' => false,'name' => 'installment_interval']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  repeater-select  ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'installment_interval']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
										  
										  
                                    </td>
										 <td>
                                                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => '0','mark' => 'Mth','removeThreeDots' => true,'currentVal' => isset($subModel) ? $subModel->getTenor():12,'classes' => 'only-greater-than-zero-allowed','isPercentage' => true,'name' => 'tenor','columnIndex' => null]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['number-format-decimals' => '0','mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mth'),'remove-three-dots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getTenor():12),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('tenor'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </td>
									  <td class="text-center">

                 <div class="form-group d-inline-block">
                     <div class="kt-radio-inline">
                         <label class="mr-3">

                         </label>
                         <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                             <input type="radio" value="1" name="is_funding_by_mtl" <?php if(isset($subModel) && $subModel->isMtl()): ?> checked <?php endif; ?>
                             > <?php echo e(__('MTLs')); ?>

                             <span></span>
                         </label>

                         <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                             <input type="radio" value="0" name="is_funding_by_mtl" <?php if(isset($subModel) && $subModel->isOda()): ?> checked <?php endif; ?>
                             > <?php echo e(__('ODAs')); ?>

                             <span></span>
                         </label>
                     </div>
                 </div>

             </td>
									 
									 <td>
                                                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeCurrency' => true,'readonly' => true,'removeThreeDots' => true,'currentVal' => __('Contribution %'),'classes' => '','isNumber' => false,'isPercentage' => false,'name' => '','columnIndex' => null]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeCurrency' => true,'readonly' => true,'remove-three-dots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contribution %')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeCurrency' => true,'readonly' => true,'removeThreeDots' => true,'currentVal' => __('Loan Amount'),'classes' => '','isNumber' => false,'isPercentage' => false,'name' => '','columnIndex' => null]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeCurrency' => true,'readonly' => true,'remove-three-dots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Loan Amount')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeCurrency' => true,'readonly' => true,'removeThreeDots' => true,'currentVal' => __('Flat Rate'),'classes' => '','isNumber' => false,'isPercentage' => false,'name' => '','columnIndex' => null]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeCurrency' => true,'readonly' => true,'remove-three-dots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Flat Rate')),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </td>
											
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['multiple' => true,'currentVal' => isset($subModel) ? $subModel->getContributionPercentageAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed recalculate-factoring factoring-rate','isPercentage' => true,'name' => 'contribution_percentages','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['multiple' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getContributionPercentageAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed recalculate-factoring factoring-rate'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('contribution_percentages'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['multiple' => true,'numberFormatDecimals' => 0,'currentVal' => isset($subModel) ? $subModel->getLoanAmountPayloadAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed current-loan-input factoring-value','isPercentage' => false,'name' => 'loan_amounts','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['multiple' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getLoanAmountPayloadAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed current-loan-input factoring-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('loan_amounts'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['multiple' => true,'currentVal' => isset($subModel) ? $subModel->getFlatRateAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed ','isPercentage' => true,'name' => 'flat_rates','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['multiple' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getFlatRateAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('flat_rates'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </td>
                                    <?php
                                    $columnIndex++;
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
                        


                    </div>

                </div>
            </div>
            
			



           
            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Administration Fees Rate & ECL Rate')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.admin-fees']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.admin-fees')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row admin-fees">
                        <?php
                        $rowIndex = 0;
                        ?>


                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                             <?php $__env->slot('ths'); ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' category-selector-class header-border-down ','title' => __('Item')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' category-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    


                                    <td>
                                        <input value="<?php echo e(__('Administration Fees Rate')); ?>" disabled class="form-control text-left mt-2" type="text">
										
                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">


                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['currentVal' => $model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getAdminFeeRatesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'microfinanceAdminFeesRate['.'admin_fees_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getAdminFeeRatesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('microfinanceAdminFeesRate['.'admin_fees_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>


                                <tr data-repeat-formatting-decimals="2" data-repeater-style>


                                    <td>
                                        <input disabled value="<?php echo e(__('Expected Credit Loss Rate (ECL %)')); ?>" class="form-control text-left" type="text">

                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>

                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['currentVal' => $model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getEclRatesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'microfinanceAdminFeesRate['.'ecl_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getEclRatesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('microfinanceAdminFeesRate['.'ecl_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>


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
            




             
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Factoring New Portfolio Funding Structure')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.new-portfolio-funding']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.new-portfolio-funding')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row new-portfolio-funding">
                        <?php
                        $rowIndex = 0;
                        ?>


                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                             <?php $__env->slot('ths'); ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' category-selector-class header-border-down ','title' => __('Item')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' category-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <tr data-repeat-formatting-decimals="2" data-repeater-style >

                                    


                                    <td>
                                        <input value="<?php echo e(__('Equity Funding Rate (%)')); ?>" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['inputHiddenAttributes' => 'js-recalculate-equity-funding-value','currentVal' => $model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class','isPercentage' => true,'name' => 'microfinanceNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['inputHiddenAttributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-recalculate-equity-funding-value'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('microfinanceNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>



                                <tr data-repeat-formatting-decimals="0" data-repeater-style >

                                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">


                                    <td>
                                        <input value="<?php echo e(__('Equity Funding Value')); ?>" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'currentVal' => $model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed ','formattedInputClasses' => 'equity-funding-formatted-value-class','isPercentage' => false,'name' => 'microfinanceNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('equity-funding-formatted-value-class'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('microfinanceNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>



                                <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                    <td>
                                        <input disabled value="<?php echo e(__('New Loans Funding Rate (%)')); ?>" class="form-control text-left" type="text">
                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>

                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" data-column-index="<?php echo e($columnIndex); ?>" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="microfinanceNewPortfolioFundingStructure[new_loans_funding_rates][<?php echo e($year); ?>]" value="<?php echo e($model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getNewLoansFundingRatesAtYearIndex($year):0); ?>"> <span class="ml-2">%</span>
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>






                                <tr data-repeat-formatting-decimals="0" data-repeater-style>


                                    <td>
                                        <input disabled value="<?php echo e(__('New Loans Funding Value')); ?>" class="form-control text-left" type="text">

                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    ?>

                                    <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'formattedInputClasses' => 'new-loans-funding-formatted-value-class','currentVal' => $model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => 'microfinanceNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new-loans-funding-formatted-value-class'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('microfinanceNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex++;
                                    ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                </tr>

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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.save-or-back','data' => []]); ?>
<?php $component->withName('save-or-back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 





























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


</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            const hasSalesChannel = $('#add-sales-channels-share-discount-id:checked').length

            let canSubmitForm = true;
            let errorMessage = '';
            let messageTitle = 'Oops...';



            if (!canSubmitForm) {
                Swal.fire({
                    icon: "warning"
                    , title: messageTitle
                    , text: errorMessage
                , })

                return;
            }

            let formId = $(this).closest('form').attr('id')

            let form = document.getElementById(formId);
            var formData = new FormData(form);
            formData.append('submitBtnType', formId)

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
    $('.use-rooms:checked').trigger('change');

</script>

<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })
    $(document).on('change', '.can-not-be-removed-checkbox', function() {
        $(this).prop('checked', true)
    })

    $(document).on('click', '.show-hide-repeater', function() {
        const query = this.getAttribute('data-query')
        $(query).fadeToggle(300)

    })
    $(document).on('change', '.not-allowed-duplication-in-selection-inside-repeater', function() {
        const val = $(this).val()
        const currentSelect = this
        const currentSelectedOption = $(currentSelect).find('option[value="' + val + '"]')
        const commonParent = $(this).closest('[data-repeater-list]')
        // let selectItems = []
        // $(commonParent).find('select').each(function(index,select){
        // 	selectItems.push($(select).val())
        // })
        $(commonParent).find('select').each(function(index, select) {
            if (select != currentSelect) {
                if ($(select).find('option[value="' + val + '"]:selected').length) {
                    alert('This Item has been choosen before')
                    $(currentSelect).val('').trigger('change')

                }

                //.prop('disabled',true).attr('title','This Item has been choosen before')
            } else {}
        })
    })

    $(document).on('change', '.can-be-toggle-show-repeater-btn', function() {
        let val = $(this).is(':checked')
        let repeaterQuery = $(this).attr('data-repeater-query')
        if (!val) {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').addClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeOut(300)
            $(this).val(0)
        } else {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').removeClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeIn(300)
            $(this).val(1)

        }

    })
    $('.can-be-toggle-show-repeater-btn').trigger('change')

</script>

<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/microfinance-revenue-stream-breakdown/form.blade.php ENDPATH**/ ?>