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
                                        $currentVal = $formattedResult['growth_rate'][$year] ?? 0;
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
                                        $currentVal = $formattedResult['gross_profit_percentage_of_sales'][$year] ?? 0;
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
                                        $currentVal = $formattedResult['ebitda_percentage_of_sales'][$year] ?? 0;
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
                                        $currentVal = $formattedResult['ebit_percentage_of_sales'][$year] ?? 0;
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
                                        $currentVal = $formattedResult['ebt_percentage_of_sales'][$year] ?? 0;
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
                                        $currentVal = $formattedResult['net_profit_percentage_of_sales'][$year] ?? 0;
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/_income-statement-percentage-of.blade.php ENDPATH**/ ?>