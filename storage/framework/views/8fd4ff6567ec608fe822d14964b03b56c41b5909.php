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

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($disabled) && $disabled ? '#' :  $storeRoute); ?>">

            <?php echo csrf_field(); ?>
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">
            <input type="hidden" name="study_id" value="<?php echo e($study->id); ?>">


            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 mb-4">

                                    <div class="d-flex align-items-center ">
                                        <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                            <?php echo e(__('Reserve Assumption')); ?>

                                        </h3>


                                    </div>
                                    <div class="row">
                                        <hr style="flex:1;background-color:lightgray">
                                    </div>

                                </div>


                                <div class="col-md-3 mb-4">
                                    <label class="form-label font-weight-bold"><?php echo e(__('Legal Reserve Rate %')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="number" class="form-control only-greater-than-or-equal-zero-allowed " name="legal_reserve_rate" value="<?php echo e(isset($model) ? $model->getLegalReserveRate() : 5); ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3 mb-4">
                                    <label class="form-label font-weight-bold"><?php echo e(__('Max Legal Reserve Rate %') . ' ' . __(' ( From Paid Up Capital)')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="number" class="form-control only-greater-than-or-equal-zero-allowed " name="max_legal_reserve_rate" value="<?php echo e(isset($model) ? $model->getMaxLegalReserveRate() : 50); ?>">
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-3 mb-4">
                                    <label class="form-label font-weight-bold"><?php echo e(__('Financial Regularity Authority Reserve (FRA %) ')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="number" class="form-control only-greater-than-or-equal-zero-allowed " name="financial_regulatory_authority_rate" value="<?php echo e(isset($model) ? $model->getFinancialRegulatoryAuthorityRate() : 0); ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3 mb-4">
                                    <label class="form-label font-weight-bold"><?php echo e(__('Max Financial Regularity Authority Reserve (FRA %) ')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="number" class="form-control only-greater-than-or-equal-zero-allowed " name="max_financial_regulatory_authority_rate" value="<?php echo e(isset($model) ? $model->getMaxFinancialRegulatoryAuthorityRate() : 0); ?>">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('Profit Distribution Assumption')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn active-style show-hide-repeater" data-query=".reserve-and-profit-distribution-assumption"><?php echo e(__('Show/Hide')); ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row reserve-and-profit-distribution-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class="first-column-th-class-medium form-label font-weight-bold text-center align-middle interval-class header-border-down"><?php echo e(__('Item')); ?></th>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="form-label font-weight-bold  text-center align-middle interval-class header-border-down"> <?php echo e(__('Yr-')); ?><?php echo e($yearIndexWithYear[$year]); ?> </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentTotal = [];

                                    ?>
                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>
                                                <input value="<?php echo e(__('Operating Months Per Year')); ?>" disabled="" class="form-control text-left mt-2" type="text">

                                            </div>

                                        </td>


                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            ?>

                                            
                                            <div class="form-group three-dots-parent">
                                                <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                                                    <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="<?php echo e(sumNumberOfOnes($yearsWithItsMonths,$year,$datesIndexWithYearIndex)); ?>" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
                                                    <span class="ml-2">
                                                        <b style="visibility:hidden">%</b>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tr>








                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="<?php echo e(__('Employee Profit Share Rate')); ?>" disabled="" class="form-control text-left mt-2" type="text">
                                            </div>

                                        </td>

                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getEmployeeProfitShareRatesAtYearIndex($year) : 10;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-zero-allowed','isPercentage' => true,'name' => 'employee_profit_share_rates['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('employee_profit_share_rates['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                        <td class="td-classes">
                                            <div>
                                                <input value="<?php echo e(__('Board Of Directors Profit Share Rates')); ?>" disabled="" class="form-control text-left mt-2" type="text">
                                            </div>

                                        </td>

                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getBorderOfDirectorsProfitShareRateAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'border_of_directors_profit_share_rates['.$year.']','currentVal' => $currentVal,'classes' => 'only-greater-than-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('border_of_directors_profit_share_rates['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>





                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                        <td class="td-classes">
                                            <div>
                                                <input value="<?php echo e(__('Shareholders First Dividend Portion')); ?>" disabled="" class="form-control text-left mt-2" type="text">

                                            </div>

                                        </td>


                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getShareholderFirstDividendPortionAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'shareholders_first_dividend_portions['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shareholders_first_dividend_portions['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 



                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                        <td class="td-classes">
                                            <div>
                                                <input value="<?php echo e(__('Shareholders Dividend Payout Ratio %')); ?>" disabled="" class="form-control text-left mt-2" type="text">

                                            </div>

                                        </td>

                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getShareholderDividendPayoutRatioAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'shareholders_dividend_payout_ratios['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shareholders_dividend_payout_ratios['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>



                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                        <td class="td-classes">
                                            <div>
                                                <input value="<?php echo e(__('Shareholders Dividend (In Cash Or Shares)')); ?>" disabled="" class="form-control text-left mt-2" type="text">

                                            </div>

                                        </td>

                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getShareholderDividendInCashOrSharesAtYearIndex($year) : 0;
                                            ?>
                                            
                                            <div class="form-group three-dots-parent">

                                                <select class="form-control select-inside-repeating-table-css repeat-to-right-select text-center " name="shareholders_dividend_in_cash_or_shares[<?php echo e($year); ?>]" data-column-index="<?php echo e($columnIndex); ?>">
                                                    <?php $__currentLoopData = ['in_cash'=>__('In Cash') , 'in_share'=>__('In Shares')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if($value==$currentVal): ?> selected <?php endif; ?> value="<?php echo e($value); ?>"> <?php echo e($title); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <i class="fa fa-ellipsis-h pull-left repeat-select-to-right row-repeater-icon " data-column-index="<?php echo e($columnIndex); ?>" title="<?php echo e(__('Repeat Right')); ?>"></i>
                                            </div>

                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>











                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            




            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('General Assumption')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn active-style show-hide-repeater" data-query=".general-assumption"><?php echo e(__('Show/Hide')); ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row general-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class="first-column-th-class-medium form-label font-weight-bold  text-center align-middle interval-class header-border-down"><?php echo e(__('Item')); ?></th>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="form-label font-weight-bold  text-center align-middle interval-class header-border-down"> <?php echo e(__('Yr-')); ?><?php echo e($yearIndexWithYear[$year]); ?> </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentTotal = [];

                                    ?>
                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
									
									 <td class="td-classes">
										<div>
										<input value="<?php echo e(__('Operating Months Per Year')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
                                    


                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            ?>


                                            <div class="form-group three-dots-parent">
                                                <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                                                    <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="<?php echo e(sumNumberOfOnes($yearsWithItsMonths,$year,$datesIndexWithYearIndex)); ?>" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
                                                    <span class="ml-2">
                                                        <b style="visibility:hidden">%</b>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style >
									<td class="td-classes">
										<div>
										<input value="<?php echo e(__('Salaries Annual Increase Rate %')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
                                       
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getSalariesAnnualIncreaseRateAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'salaries_annual_increase_rates['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('salaries_annual_increase_rates['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                      
										
											<td class="td-classes">
										<div>
										<input value="<?php echo e(__('Expense Annual Increase Rate %')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getExpenseAnnualIncreaseRateAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'expense_annual_increase_rates['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('expense_annual_increase_rates['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>



                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            









            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    <?php echo e(__('CBE Corridor & Banks Lending Margins & Interest Rates')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn active-style show-hide-repeater" data-query=".general-assumption"><?php echo e(__('Show/Hide')); ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row general-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class="first-column-th-class-medium form-label font-weight-bold text-center align-middle interval-class header-border-down"><?php echo e(__('Item')); ?></th>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="form-label font-weight-bold text-center align-middle interval-class header-border-down"> <?php echo e(__('Yr-')); ?><?php echo e($yearIndexWithYear[$year]); ?> </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentTotal = [];

                                    ?>
                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
									
									 <td class="td-classes">
										<div>
										<input value="<?php echo e(__('Operating Months Per Year')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
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

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style >
									
									 <td class="td-classes">
										<div>
										<input value="<?php echo e(__('CBE Lending Corridor Rate %')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
                                       
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getCbeLendingCorridorRatesAtYearIndex($year) : 0;
                                            ?>


                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'name' => 'cbe_lending_corridor_rates['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cbe_lending_corridor_rates['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
									
									 <td class="td-classes">
										<div>
										<input value="<?php echo e(__('Banks Lending Margin Rate %')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
										
                                     
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getBankLendingMarginRatesAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'bank_lending_margin_rates['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('bank_lending_margin_rates['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>




                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
									
									 <td class="td-classes">
										<div>
										<input value="<?php echo e(__('Credit Interest Rate For Surplus Cash %')); ?>" disabled="" class="form-control text-left mt-2" type="text">
										
										</div>
										
                                        </td>
									
                                        <?php
                                        $columnIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $yearsWithItsMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year=>$monthsForThisYearArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td>

                                            <?php
                                            $currentVal = $model ? $model->getCreditInterestRateForSurplusCashAtYearIndex($year) : 0;
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['name' => 'credit_interest_rate_for_surplus_cash['.$year.']','currentVal' => number_format($currentVal,1),'classes' => 'only-greater-than-or-equal-zero-allowed','isPercentage' => true,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('credit_interest_rate_for_surplus_cash['.$year.']'),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($currentVal,1)),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed'),'is-percentage' => true,'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </td>
                                        <?php
                                        $columnIndex++ ;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            





































             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.save-or-back','data' => ['btnText' => __('Create')]]); ?>
<?php $component->withName('save-or-back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['btn-text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Create'))]); ?>
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


    $(document).on('change', '.use-rooms', function() {
        let useRooms = $("#use-rooms-1").is(':checked')
        if (useRooms) {
            $('.rooms-repeater').fadeIn(300)
            $('input[type="radio"][name*="rooms"]').val(1);

        } else {
            $('.rooms-repeater').fadeOut(300);
            $('input[type="radio"][name*="rooms"]').val(0);
        }
    });

    $('.use-rooms').trigger('change')




    $(document).on('change', '.use-foods', function() {
        let useFoods = $("#use-foods-1").is(':checked')
        if (useFoods) {
            $('.foods-repeater').fadeIn(300)
            $('input[type="radio"][name*="foods"]').val(1);

        } else {
            $('.foods-repeater').fadeOut(300);
            $('input[type="radio"][name*="foods"]').val(0);
        }
    });
    $('.use-foods').trigger('change')



    $(document).on('change', '.use-casino', function() {
        let useCasino = $("#use-casinos-1").is(':checked')

        if (useCasino) {
            $('.casino-repeater').fadeIn(300)
            $('input[type="radio"][name*="casinos"]').val(1);
        } else {
            $('.casino-repeater').fadeOut(300);
            $('input[type="radio"][name*="casinos"]').val(0);
        }
    });

    $('.use-casino').trigger('change')


    $(document).on('change', '.use-meeting', function() {
        let useCasino = $("#use-meetings-1").is(':checked')

        if (useCasino) {
            $('.meeting-repeater').fadeIn(300)
            $('input[type="radio"][name*="meetings"]').val(1);
        } else {
            $('.meeting-repeater').fadeOut(300);
            $('input[type="radio"][name*="meetings"]').val(0);
        }
    })
    $('.use-meeting').trigger('change')


    $(document).on('change', '.use-other', function() {
        let useCasino = $("#use-others-1").is(':checked')

        if (useCasino) {
            $('.other-repeater').fadeIn(300)
            $('input[type="radio"][name*="other"]').val(1);
        } else {
            $('.other-repeater').fadeOut(300);
            $('input[type="radio"][name*="other"]').val(0);
        }
    })
    $('.use-other').trigger('change')

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

    $(function() {
        $('.discount-table tr:first-of-type td .target_repeating_amounts').trigger('keyup')
    })

</script>
<script>
    $(document).on('change', '[data-calc-adr-operating-date]', function() {
        const power = parseFloat($('#daysDifference').val());
        const roomTypeId = $(this).attr('data-room-type-id');
        let avgDailyRate = $('.avg-daily-rate[data-room-type-id="' + roomTypeId + '"]').val();
        avgDailyRate = number_unformat(avgDailyRate)
        let ascalationRate = $('.adr-escalation-rate[data-room-type-id="' + roomTypeId + '"]').val() / 100;

        const result = avgDailyRate * Math.pow(((1 + ascalationRate)), power)
        $('.value-for-adr_at_operation_date[data-room-type-id="' + roomTypeId + '"]').val(result)
        $('.html-for-adr_at_operation_date[data-room-type-id="' + roomTypeId + '"]').val(number_format(result))
    })
    $(document).on('change', '.add-sales-channels-share-discount', function() {
        let val = +$(this).attr('value');
        if (val) {
            $('[data-is-sales-channel-revenue-discount-section]').show();
        } else {
            $('[data-is-sales-channel-revenue-discount-section]').hide();

        }
    })
    $(document).on('change', '.occupancy-rate', function() {
        let val = $(this).attr('value');

        if (val == 'general_occupancy_rate') {
            $('[data-name="general_occupancy_rate"]').fadeIn(300)
            $('[data-name="occupancy_rate_per_room"]').fadeOut(300)
        } else {
            $('[data-name="general_occupancy_rate"]').fadeOut(300)
            $('[data-name="occupancy_rate_per_room"]').fadeIn(300)

        }
    })
    $(document).on('change', '.collection_rate_class', function() {
        let val = $(this).val();
        if (val == 'terms_per_sales_channel') {
            $('[data-name="per-sales-channel-collection"]').fadeIn(300)
            $('[data-name="general-collection-policy"]').fadeOut(300)
        } else {
            $('[data-name="per-sales-channel-collection"]').fadeOut(300)
            $('[data-name="general-collection-policy"]').fadeIn(300)

        }
    })

    $(document).on('change', '.seasonlity-select', function() {
        const mainSelect = $('.main-seasonality-select').val()
        const secondarySelect = $('.secondary-seasonality-select').val();
        $('.one-of-seasonality-tables-parent').addClass('d-none');
        $('[data-select-1*="' + mainSelect + '"][data-select-2*="' + secondarySelect + '"]').removeClass('d-none')

    })

    $(document).on('change', '.collection_rate_input', function() {
        let salesChannelName = $(this).attr('data-sales-channel-name')
        let total = 0;
        $('.collection_rate_input[data-sales-channel-name="' + salesChannelName + '"]').each(function(index, input) {
            total += parseFloat(input.value)
        })
        $('.collection_rate_total_class[data-sales-channel-name="' + salesChannelName + '"]').val(total)
    })


    $(function() {
        $('[data-calc-adr-operating-date]').trigger('change')
        $('.occupancy-rate:checked').trigger('change')
        $('.collection_rate_class:checked').trigger('change')
        $('.add-sales-channels-share-discount:checked').trigger('change')
        $('.main-seasonality-select').trigger('change')
        $('[data-repeater-create]').trigger('')
    })

    $(document).on('change keyup', '.recalc-avg-weight-total', function() {
        const order = this.getAttribute('data-order')
        let currentTotal = 0;
        $('.revenue-share-percentage[data-order="' + order + '"]').each(function(i, revenueSharePercentageInput) {
            var currentIndex = revenueSharePercentageInput.getAttribute('data-index');
            var revenueSharePercentageAtIndex = $(revenueSharePercentageInput).parent().find('input[type="hidden"]').val();
            revenueSharePercentageAtIndex = revenueSharePercentageAtIndex ? revenueSharePercentageAtIndex / 100 : 0;
            var discountSharePercentageAtIndex = $('.discount-commission-percentage[data-order="' + order + '"][data-index="' + currentIndex + '"]').parent().find('input[type="hidden"]').val();
            discountSharePercentageAtIndex = discountSharePercentageAtIndex ? discountSharePercentageAtIndex / 100 : 0;
            currentTotal += discountSharePercentageAtIndex * revenueSharePercentageAtIndex;
        })
        currentTotal = currentTotal * 100;
        $('.weight-avg-total-hidden[data-order="' + order + '"]').val(currentTotal);
        $('.weight-avg-total[data-order="' + order + '"]').val(number_format(currentTotal, 1)).trigger('keyup');
    })


    $(function() {



        $('.recalc-avg-weight-total').trigger('change')
    })
    $(function() {
        $('.choosen-currency-class').on('change', function() {
            $('.choosen-currency-class').val($(this).val())
        })
        $('.choosen-currency-class').trigger('change');
    })

</script>
<script src="/custom/js/non-banking-services/common.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/general-assumption/form.blade.php ENDPATH**/ ?>