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
                                                <div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                <div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                <div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                <div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                <div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'numberFormatDecimals' => 2,'currentVal' => $currentVal,'classes' => 'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value','isPercentage' => false,'mark' => ' ','name' => 'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']','columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => true,'removeThreeDotsClass' => true,'removeThreeDots' => true,'number-format-decimals' => 2,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentVal),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$year.']'),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/_expenses.blade.php ENDPATH**/ ?>