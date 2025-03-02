<?php
use App\Helpers\HArr;
use App\Helpers\HMath;
use MathPHP\Statistics\Correlation ;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('dash_nav'); ?>
<style>
.max-column-th-class{
	width:30% !important;
	min-width:30% !important;
	max-width:30% !important;
}
    .three-dots-parent {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .b-bottom {
        border-bottom: 1px solid green !important;
    }

    .expandable-amount-input {
        max-width: 90px !important;
        min-width: 90px !important;
        width: 90px !important;
    }

    table:not(.table-condensed) thead th,
    table:not(.table-condensed) tbody td {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    input {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    .chartdiv_two_lines {
        width: 100%;
        height: 500px;
    }

    .chartDiv {
        max-height: 500px !important;
    }

    .margin__left {
        border-left: 2px solid #366cf3;
    }

    .sky-border {
        border-bottom: 1.5px solid #CCE2FD !important;
    }

    .kt-widget24__title {
        color: black !important;
    }

</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

    /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="kt-portlet">


</div>

<div class="tab-content  kt-margin-t-20">
    <?php
    $index = 0 ;
    ?>


    <div class="tab-pane  active " id="kt_apps_contacts_view_tab_main" role="tabpanel">











        <div class="kt-portlet">

            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">

                   

                    



                </div>
            </div>
        </div>



        <div class="row">



            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--tabs">

                    <div class="kt-portlet__body pt-0">


                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Income Statement Summary')); ?> <?php echo e(__('Fig In Million')); ?> </h3>
                                    </div>
									<div  class="col-md-8 mb-3">
										<?php
											$currentModalId = 'spread-rate-sensitivity';
											$currentModalTitle = __('Spread Rate Sensitivity');
											$spreadRates = [];
										?>
										  <button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>"><?php echo e($currentModalTitle); ?></button>
										  
										
										<?php echo $__env->make('non_banking_services.dashboard._spread-rate-sensitivity-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
														

                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableClass' => 'col-md-6','removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['table-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('col-md-6'),'removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down','title' => __('Yr-') . $yearIndexWithYear[$year] ]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Yr-') . $yearIndexWithYear[$year] )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('Operating Months')); ?>" disabled class="form-control text-left " type="text">
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
                                                    <input value="<?php echo e(__('Total Revenues')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedResult['sales_revenue'][$year]??0) / 1000000 ;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed  total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed  total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <input value="<?php echo e(__('Gross Profit')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedResult['gross_profit'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <input value="<?php echo e(__('EBITDA')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedResult['ebitda'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <input value="<?php echo e(__('EBIT')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedResult['ebit'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <input value="<?php echo e(__('EBT')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                               $currentVal = ($formattedResult['ebt'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <input value="<?php echo e(__('Net Profit')); ?>" disabled class="form-control text-left " type="text">
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedResult['net_profit'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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




                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableClass' => 'col-md-6 margin__left','removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['table-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('col-md-6 margin__left'),'removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
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



                                                <td>
                                                    <div class="">
                                                        <input value="<?php echo e(__('Operating Months')); ?>" disabled class="form-control text-left " type="text">
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



                                                <td>
                                                    <div class="">
                                                        <input value="<?php echo e(__('Growth Rate %')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
                                					      $currentVal = $formattedResult['growth_rate'][$year]  ?? 0;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => '2','removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => '2','removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                              

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													  $currentVal = $formattedResult['gross_profit_percentage_of_sales'][$year]  ?? 0;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => '','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentVal = $formattedResult['ebitda_percentage_of_sales'][$year]  ?? 0;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                          
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentVal = $formattedResult['ebit_percentage_of_sales'][$year]  ?? 0;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                              

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentVal = $formattedResult['ebt_percentage_of_sales'][$year]  ?? 0;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                                

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentVal = $formattedResult['net_profit_percentage_of_sales'][$year]  ?? 0;
												?>
												
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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

            <div class="col-md-6 max-card-height">
                <div class="kt-portlet kt-portlet--tabs">

                    <div class="kt-portlet__body pt-0">


                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                                <div class="row">


                                    <div class="col-md-12 ">

                                        <div class="row mb-3 ml-4 b-bottom">
                                            <div class="col-6">
                                                <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Choose Revenue Stream')); ?> </h3>
                                            </div>
                                            <div class="col-md-6 ">
                                                <select js-refresh-three-line-chart  class="form-control"  >
                                                    <?php $__currentLoopData = $lineChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $arr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>"> <?php echo e($titlesMapping[$id]); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>



                                        </div>
                                        <div class="chartdiv_two_lines" id="three-line-chart-id-chart"></div>
                                        <?php $__currentLoopData = $lineChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $currentChartData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" class="three-line-chart-data-class" data-chart-name="<?php echo e($chartName); ?>" data-chart-data="<?php echo e(json_encode($currentChartData)); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 max-card-height">
                <div class="kt-portlet kt-portlet--tabs">

                    <div class="kt-portlet__body pt-0">


                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                                <div class="row">






                                    <div class="col-md-12 ">

                                        <div class="row mb-3 ml-4 b-bottom">
                                            <div class="col-6">
                                                <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Revenue Stream Breakdown')); ?> </h3>
                                            </div>




                                        </div>
                                        <div id="bar-chart-id" class="chartdashboard"></div>
                                        
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
			
			  <div class="col-md-12">
                <div class="kt-portlet kt-portlet--tabs">

                    <div class="kt-portlet__body pt-0">


                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">


                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap"> <?php echo e(__('Cost And Expense Summary')); ?> </h3>
                                    </div>

                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableClass' => 'col-md-6','removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['table-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('col-md-6'),'removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                                         <?php $__env->slot('ths'); ?> 
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down max-column-th-class','title' => __('Item')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down max-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('Operating Months')); ?>" disabled class="form-control text-left " type="text">
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
											<?php
												$key ='cost-of-service';
												$currentModalId = $key.'-modal-id';
												$currentModalTitle = __('Cost Of Service (Fig In Million)') ;
											?>
                                                <td>
													<div class="d-flex align-items-center ">
                                                    <input value="<?php echo e(__('Cost Of Service')); ?>" disabled class="form-control text-left " type="text">
														<div >
															<i data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>" class="flaticon2-information kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
															<?php echo $__env->make('non_banking_services.dashboard._expense-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle,'modalData'=>$formattedExpenses[$key] ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
														</div>
														
													
													
													</div>
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedExpenses['cost-of-service']['total'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
											<?php
												$key ='other-operation-expense';
												$currentModalId = $key.'-modal-id';
												$currentModalTitle = __('Other Operating Expenses (Fig In Million)' ) ;
											?>
											
                                                <td>
													<div class="d-flex align-items-center ">
                                                    <input value="<?php echo e(__('Other OPEX')); ?>" disabled class="form-control text-left " type="text">
													<div >
															<i data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>" class="flaticon2-information kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
															<?php echo $__env->make('non_banking_services.dashboard._expense-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle,'modalData'=>$formattedExpenses[$key] ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
															
														</div>
														
													</div>
													
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedExpenses['other-operation-expense']['total'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
		
											<?php
												$key ='marketing-expense';
												$currentModalId = $key.'-modal-id';
												$currentModalTitle = __('Marketing Expenses (Fig In Million)') ;
											?>
											
                                                <td>
														<div class="d-flex align-items-center ">
                                                    <input value="<?php echo e(__('Marketing Expenses')); ?>" disabled class="form-control text-left " type="text">
												<div >
															<i data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>" class="flaticon2-information kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
															<?php echo $__env->make('non_banking_services.dashboard._expense-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle,'modalData'=>$formattedExpenses[$key] ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
														</div>
													
													</div>
                                                 
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                             	  $currentVal = ($formattedExpenses['marketing-expense']['total'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
											
												<?php
												$key ='sales-expense';
												$currentModalId = $key.'-modal-id';
												$currentModalTitle = __('Sales Expense (Fig In Million)') ;
											?>
													
                                                <td>
                                                   <div class="d-flex align-items-center ">
                                                    <input value="<?php echo e(__('Sales Expenses')); ?>" disabled class="form-control text-left " type="text">
													<div >
															<i data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>" class="flaticon2-information kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
															<?php echo $__env->make('non_banking_services.dashboard._expense-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle,'modalData'=>$formattedExpenses[$key] ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
														</div>
																											
													</div>
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $currentVal = ($formattedExpenses['sales-expense']['total'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
											<?php
												$key ='general-expense';
												$currentModalId = $key.'-modal-id';
												$currentModalTitle = __('General Expenses (Fig In Million)') ;
											?>
											
                                                <td>
												<div class="d-flex align-items-center ">
                                                    <input value="<?php echo e(__('General Expenses')); ?>" disabled class="form-control text-left " type="text">
<div >
															<i data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>" class="flaticon2-information kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
																<?php echo $__env->make('non_banking_services.dashboard._expense-modal',['currentModalId'=>$currentModalId,'modalTitle'=>$currentModalTitle,'modalData'=>$formattedExpenses[$key] ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
																
														</div>													
													</div>
													
                                                
                                                </td>


                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                 $currentVal = ($formattedExpenses['general-expense']['total'][$year]??0) / 1000000;
                                                ?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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




                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['tableClass' => 'col-md-6 margin__left','removeActionBtn' => true,'removeRepeater' => true,'initialJs' => false,'repeaterWithSelect2' => true,'canAddNewItem' => false,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => '','repeaterId' => '','relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['table-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('col-md-6 margin__left'),'removeActionBtn' => true,'removeRepeater' => true,'initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
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



                                                <td>
                                                    <div class="">
                                                        <input value="<?php echo e(__('Operating Months')); ?>" disabled class="form-control text-left " type="text">
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


											<?php
												$currentExpenseType = 'cost-of-service';
											
											?>
                                                <td>
                                                    <div class="">
                                                        <input value="<?php echo e(__(' % / REV')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                            

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentExpense = $formattedExpenses['cost-of-service']['total'][$year]??0;
													$currentSalesRevenue = $formattedResult['sales_revenue'][$year]??0 ;
													$currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                                

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentExpense = $formattedExpenses['other-operation-expense']['total'][$year]??0;
													$currentSalesRevenue = $formattedResult['sales_revenue'][$year]??0 ;
													$currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
													
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
												<?php
													$currentExpense = $formattedExpenses['marketing-expense']['total'][$year]??0;
													$currentSalesRevenue = $formattedResult['sales_revenue'][$year]??0 ;
													$currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
												?>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;

                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentExpense = $formattedExpenses['sales-expense']['total'][$year]??0;
													$currentSalesRevenue = $formattedResult['sales_revenue'][$year]??0 ;
													$currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
												?>
												
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <div class="">
                                                        <input value="<?php echo e(__('% / REV.')); ?>" disabled class="form-control text-left " type="text">
                                                    </div>


                                                </td>
                                                <?php
                                                $columnIndex = 0 ;
                                                ?>
                                                <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$currentExpense = $formattedExpenses['general-expense']['total'][$year]??0;
													$currentSalesRevenue = $formattedResult['sales_revenue'][$year]??0 ;
													$currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
												?>
												
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['numberFormatDecimals' => 1,'removeThreeDotsClass' => true,'removeThreeDots' => true,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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



        <!--end:: Widgets/Stats-->


    </div>





</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>








<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("three-line-chart-id-chart", am4charts.XYChart);
        var data = [];
        //
        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = data;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
		  dateAxis.dateFormats.setKey("year", "yyyy");
			dateAxis.periodChangeDateFormats.setKey("year", "yyyy");
			dateAxis.tooltipDateFormat = "yyyy";
        // Create series
        function createAxisAndSeries(field, name, opposite, bullet) {
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            if (chart.yAxes.indexOf(valueAxis) != 0) {
                valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            }

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            series.dataFields.dateX = "date";
            series.strokeWidth = 2;
            series.yAxis = valueAxis;
            series.name = name;
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            series.tensionX = 0.8;
            series.showOnInit = true;

            var interfaceColors = new am4core.InterfaceColorSet();

            switch (bullet) {
                case "triangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 12;
                    bullet.height = 12;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var triangle = bullet.createChild(am4core.Triangle);
                    triangle.stroke = interfaceColors.getFor("background");
                    triangle.strokeWidth = 2;
                    triangle.direction = "top";
                    triangle.width = 12;
                    triangle.height = 12;
                    break;
                case "rectangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 10;
                    bullet.height = 10;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var rectangle = bullet.createChild(am4core.Rectangle);
                    rectangle.stroke = interfaceColors.getFor("background");
                    rectangle.strokeWidth = 2;
                    rectangle.width = 10;
                    rectangle.height = 10;
                    break;
                default:
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.stroke = interfaceColors.getFor("background");
                    bullet.circle.strokeWidth = 2;
                    break;
            }

            valueAxis.renderer.line.strokeOpacity = 1;
            valueAxis.renderer.line.strokeWidth = 2;
            valueAxis.renderer.line.stroke = series.stroke;
            valueAxis.renderer.labels.template.fill = series.stroke;
            valueAxis.renderer.opposite = opposite;
        }

        createAxisAndSeries("revenue_value", "<?php echo e(__('Revenues Value ')); ?>", false, "circle");
        createAxisAndSeries("growth_rate", "<?php echo e(__('Growth Rate %')); ?>", true, "triangle");
        //   createAxisAndSeries("revenue_percentage", "<?php echo e(__('Revenue %')); ?>", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()



    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("bar-chart-id");
        root.numberFormatter.set("numberFormat", "#,###.##");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false
            , panY: false
            , wheelX: "panX"
            , wheelY: ""
            , layout: root.verticalLayout
        }));

        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));
        var chartData = <?php echo json_encode($barChart, 15, 512) ?>;

        var data = chartData;





        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {});
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "year"
            , renderer: xRenderer
            , tooltip: am5.Tooltip.new(root, {}),
			
        }));

        xRenderer.grid.template.setAll({
            location: 1
        })

        xAxis.data.setAll(data);

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: 0
            , renderer: am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            })
        }));


        // Add legend
        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50
            , x: am5.p50
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        function makeSeries(name, fieldName) {
            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: name
                , stacked: true
                , xAxis: xAxis
                , yAxis: yAxis
                , valueYField: fieldName
                , categoryXField: "year"
            }));

            series.columns.template.setAll({
                tooltipText: "{name}, {categoryX}: {valueY}"
                , tooltipY: am5.percent(10)
            });
            series.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear();

            series.bullets.push(function() {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: "{valueY}"
                        , fill: root.interfaceColors.get("alternativeText")
                        , centerY: am5.p50
                        , centerX: am5.p50
                        , populateText: true
                    })
                });
            });

            legend.data.push(series);
        }

        makeSeries("Leasing", "leasing");
        makeSeries("Direct Factoring", "direct-factoring");
        makeSeries("Reverse Factoring", "reverse-factoring");
        makeSeries("Ijara Mortgage", "ijara");
        

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);

    }); // end am5.ready()


    //three lines chart

</script>

<script>
   $(function(){
	 $(document).on('change', 'select[js-refresh-three-line-chart]', function(e) {
        let chartId = $(this).val();
		var chartDataArr = $('.three-line-chart-data-class[data-chart-name="'+chartId+'"]').attr('data-chart-data');
		if(chartDataArr){
			chartDataArr = JSON.parse(chartDataArr);
		}else{
			chartDataArr = {};
		}
        let currentChartId = 'three-line-chart-id-chart';
        am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = chartDataArr
    })
	
   })






	
</script> 
<script>
    $(function() {
        $('select[js-refresh-three-line-chart]').trigger('change')
    })

</script>



<!--end::Page Scripts -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/dashboard.blade.php ENDPATH**/ ?>