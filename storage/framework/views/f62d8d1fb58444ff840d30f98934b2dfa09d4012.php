<?php
use App\Models\NonBankingService\Expense;
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
<link rel="stylesheet" href="/custom/css/non-banking-services/expenses.css">
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



        <div class="kt-portlet " style="margin-bottom:5px;">


            <div class="kt-portlet__body">


                <div class="">
                    <?php
                    // $index = 0 ;
                    ?>
                    <div class="d-flex align-items-center justify-content-start " style="margin-right:auto">
                        
                        <button data-value="ffe-fixed-assets" class="btn mb-5 js-type-btn type-btn btn btn-outline-info active"><?php echo e(__('FFE Fixed Assets')); ?></button>
                        <?php
                        // $index++;
                        ?>
                        
                    </div>




                </div>


            </div>
        </div>

        
        <?php
        $tableId = 'ffe-fixed-assets';
        $cardId = $tableId;
        $repeaterId = $tableId.'_repeater';
        ?>
        <?php echo $__env->make('non_banking_services.ffe-fixed-assets._repeater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        
        




        <!--end::Form-->

        <!--end::Portlet-->


        <div class="kt-portlet " style="margin-bottom:5px;">


            <div class="kt-portlet__body">

                
                <div class="kt-portlet " id="new-funding-id">
                    <div class="kt-portlet__body">
                        <div class="row">

                            <div class="col-md-10">
                                <div class="d-flex align-items-center ">
                                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                        <?php echo e(__('FFE Funding Structure')); ?>

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

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>




                                        <td>
                                            <input value="<?php echo e(__('Direct FFE Amounts')); ?>" disabled class="form-control text-left mt-2" type="text">

                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">

                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'readonly' => true,'removeThreeDots' => true,'inputHiddenAttributes' => '','currentVal' => $study->getTotalDirectFactoringNewPortfolioAmountsAtYearIndex($year),'classes' => 'js-recalculate-equity-funding-value total-loans-hidden','isPercentage' => false,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'readonly' => true,'removeThreeDots' => true,'inputHiddenAttributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($study->getTotalDirectFactoringNewPortfolioAmountsAtYearIndex($year)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-recalculate-equity-funding-value total-loans-hidden'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input value="<?php echo e(__('Equity Funding Rate (%)')); ?>" disabled class="form-control text-left mt-2" type="text">

                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">

                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['inputHiddenAttributes' => 'js-recalculate-equity-funding-value','currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class','isPercentage' => true,'name' => 'directFactoringNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['inputHiddenAttributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-recalculate-equity-funding-value'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0,'classes' => 'only-greater-than-or-equal-zero-allowed ','formattedInputClasses' => 'equity-funding-formatted-value-class','isPercentage' => false,'name' => 'directFactoringNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('equity-funding-formatted-value-class'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input disabled value="<?php echo e(__('Loans Funding Rate (%)')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="text" data-column-index="<?php echo e($columnIndex); ?>" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="directFactoringNewPortfolioFundingStructure[new_loans_funding_rates][<?php echo e($year); ?>]" value="<?php echo e($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingRatesAtYearIndex($year):0); ?>"> <span class="ml-2">%</span>
                                            </div>
                                        </td>
                                        <?php
                                        $columnIndex++;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                    </tr>






                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>


                                        <td>
                                            <input disabled value="<?php echo e(__('Loans Funding Value')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'formattedInputClasses' => 'new-loans-funding-formatted-value-class','currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => 'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new-loans-funding-formatted-value-class'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input disabled value="<?php echo e(__('Loans Tenor ( Months )')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'mark' => 'Mth','formattedInputClasses' => 'new-loans-funding-formatted-value-class','currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => 'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mth'),'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new-loans-funding-formatted-value-class'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input disabled value="<?php echo e(__('Grace Period ( Months )')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'mark' => 'Mth','formattedInputClasses' => 'new-loans-funding-formatted-value-class','currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => 'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mth'),'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new-loans-funding-formatted-value-class'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input disabled value="<?php echo e(__('Interest Rate %')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'mark' => '%','formattedInputClasses' => 'new-loans-funding-formatted-value-class','currentVal' => $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => false,'name' => 'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('%'),'formatted-input-classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new-loans-funding-formatted-value-class'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 ),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                            <input disabled value="<?php echo e(__('IInstallment Interval')); ?>" class="form-control text-left" type="text">
                                        </td>
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>

                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
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
                
            </div>
        </div>

    </div>


</div>

</div>




</div>









</div>
</div>


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

            let form = $(this).closest('form')[0];
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);
            let addNewDepartment = $(this).attr('data-save-and-add-new-department');
            addNewDepartment = addNewDepartment ? addNewDepartment : 0;
            formData.append('addNewDepartment', addNewDepartment)

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
    function reinitalizeMonthYearInput(dateInput) {
        var currentDate = $(dateInput).val();
        var startDate = "<?php echo e(isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1); ?>";
        startDate = startDate == '-1' ? '' : startDate;
        var endDate = "<?php echo e(isset($studyEndDate) && $studyEndDate? $studyEndDate : -1); ?>";
        endDate = endDate == '-1' ? '' : endDate;
        if (startDate && endDate) {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
                .datepicker('setStartDate', new Date(startDate))
                .datepicker('setEndDate', new Date(endDate))
        } else {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
        }



    }

    $(function() {

        $('.only-month-year-picker').each(function(index, dateInput) {
            //     reinitalizeMonthYearInput(dateInput)
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
        const mainCardId = $(this).attr('data-value')
        $('.js-parent-to-table').show();
        $('.js-type-btn').removeClass('active');
        $(this).addClass('active');
        $('.parent-card').hide();
        console.log(mainCardId)
        $('[data-card-id="' + mainCardId + '"]').show();
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
    $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
        if (!$(this).hasClass('exclude-text')) {
            let val = $(this).val()
            val = number_unformat(val)
            if (isNumber(val)) {
                $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)
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


    $('select.js-condition-to-select').change(function() {
        const value = $(this).val();
        const conditionalValueTwoInput = $(this).closest('tr').find('input.conditional-b-input');
        if (value == 'between-and-equal' || value == 'between') {
            conditionalValueTwoInput.prop('disabled', false).trigger('change');
        } else {
            conditionalValueTwoInput.prop('disabled', true).trigger('change');
        }
    })

    $('select.js-condition-to-select').trigger('change');
    $(document).on('change', '.conditional-input', function() {
        if (!$(this).closest('tr').find('conditional-b-input').prop('disabled')) {
            const conditionalA = $(this).closest('tr').find('.conditional-a-input').val();
            const conditionalB = $(this).closest('tr').find('.conditional-b-input').val();
            if (conditionalA >= conditionalB) {
                if (conditionalA == 0 && conditionalB == 0) {
                    return;
                }
                Swal.fire('conditional a must be less than conditional b value');
                $(this).closest('tr').find('.conditional-a-input').val($(this).closest('tr').find('.conditional-b-input').val() - 1);
            }
        }

    })

</script>
<script>
    const handlePaymentTermModal = function() {
        const parentTermsType = $(this).closest('select').val();
        const tableId = $(this).closest('table').attr('id');
        if (parentTermsType == 'customize') {
            $(this).closest('tr').find('#' + tableId + 'test-modal-id').modal('show')
        }



    };
    $(document).on('change', 'select.payment_terms', handlePaymentTermModal)


    //$(document).on('click','option',handlePaymentTermModal)
    $(document).on('change', '.rate-element', function() {
        let total = 0;
        const parent = $(this).closest('tbody');
        parent.find('.rate-element-hidden').each(function(index, element) {
            total += parseFloat($(element).val());
        });
        parent.find('td.td-for-total-payment-rate').html(number_format(total, 2) + ' %');

    })
    $(function() {
        $('.rate-element').trigger('change');
    })

</script>
<script src="/custom/js/non-banking-services/common.js"></script>
<script>


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/ffe-fixed-assets/form.blade.php ENDPATH**/ ?>