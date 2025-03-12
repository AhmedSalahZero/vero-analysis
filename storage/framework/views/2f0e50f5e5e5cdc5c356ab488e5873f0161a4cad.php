<div data-card-id="<?php echo e($cardId); ?>" class="kt-portlet parent-card ">
            <div class="kt-portlet__body">
 <?php
                            //$numberOfPositions = $department ? $department->positions->count() : 1 ;
							$initialDepartmentIndex = isset($initialDepartmentIndex) ? $initialDepartmentIndex :  0 ; 
						
							
                            ?>
                    <?php echo $__env->make('non_banking_services.manpower._input-hidden', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    

                
                    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                    
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['addExpenseType' => true,'initEmpty' => false,'removeActionBtn' => true,'firstElementDeletable' => false,'fontSizeClass' => 'font-14px','department' => $department,'departmentId' => is_object($department) ? $department->id :$initialDepartmentIndex,'showRows' => is_object($department),'addExpenseName' => true,'appendSaveOrBackBtn' => false,'repeaterWithSelect2' => false,'parentClass' => 'js-toggle-visibility-----','tableName' => $department ? $tableId.$department->id : $tableId ,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['addExpenseType' => true,'initEmpty' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeActionBtn' => true,'first-element-deletable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'department' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($department),'departmentId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(is_object($department) ? $department->id :$initialDepartmentIndex),'showRows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(is_object($department)),'add-expense-name' => true,'append-save-or-back-btn' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visibility-----'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($department ? $tableId.$department->id : $tableId ),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => '  header-border-down first-column-th-class','title' => __('Actions')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Actions'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => '  header-border-down first-column-th-class','title' => __('Position')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' tenor-selector-class header-border-down ','title' => __('Existing <br> Count')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Existing <br> Count'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' tenor-selector-class header-border-down ','title' => __('Monthly Net <br> Salary')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monthly Net <br> Salary'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['dataColumnIndex' => ''.e($dateAsIndex).'','fontSizeClass' => 'font-14px','class' => ' interval-class header-border-down ','title' => dateFormatting($dateAsString, 'M\' Y') . ' <br> ' .__('Hiring #')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-column-index' => ''.e($dateAsIndex).'','font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(dateFormatting($dateAsString, 'M\' Y') . ' <br> ' .__('Hiring #'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
								<?php if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last): ?>
									   <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['icon' => true,'dataColumnIndex' => ''.e($dateAsIndex).'','fontSizeClass' => 'font-14px','class' => ' tenor-selector-class header-border-down '.e('year-repeater-index-'.$currentYearRepeaterIndex).' collapse-before-me exclude-from-collapse','title' => __('Total Yr.').' <br> '. $currentYear]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => true,'data-column-index' => ''.e($dateAsIndex).'','font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' tenor-selector-class header-border-down '.e('year-repeater-index-'.$currentYearRepeaterIndex).' collapse-before-me exclude-from-collapse','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total Yr.').' <br> '. $currentYear)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 
                           
                            <?php $__currentLoopData = $department->positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowIndex=>$position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
							<?php $departmentId=$department ? $department->id : $initialDepartmentIndex ;
                                $currentPosition = isset($department->positions[$rowIndex]) ? $department->positions[$rowIndex] : null ;

                                ?>
                                <tr  data-repeat-formatting-decimals="2" data-repeater-style>

                                    <td class="text-center">
                                        
                                    </td>

                                    <input type="hidden" name="departments[<?php echo e($departmentId); ?>][positions][<?php echo e($rowIndex); ?>][id]" value="<?php echo e($currentPosition ? $currentPosition->id : 0); ?>">
                                    

                                    <td>
                                        <div class="">
                                            <input readonly value="<?php echo e($currentPosition ? $currentPosition->getName() : ''); ?>" name="departments[<?php echo e($departmentId); ?>][positions][<?php echo e($rowIndex); ?>][name]" class="form-control text-left mt-2" type="text">

                                        </div>
                                    </td>
                                    <td>


                                        <div class="">
                                            <input value="<?php echo e($currentPosition ? $currentPosition->getExistingCount():0); ?>" name="departments[<?php echo e($departmentId); ?>][positions][<?php echo e($rowIndex); ?>][existing_count]" class="form-control expandable-percentage-input text-left mt-2" type="text">

                                        </div>
                                    </td>
                                    <td>


                                        <div class="">
                                            <input value="<?php echo e($currentPosition ? $currentPosition->getMonthlyNetSalary() : 0); ?>" name="departments[<?php echo e($departmentId); ?>][positions][<?php echo e($rowIndex); ?>][monthly_net_salary]" class="form-control expandable-amount-input text-left mt-2" type="text">
                                        </div>
                                    </td>
                                    <?php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;
									$currentYearRepeaterIndex =  0 ;
                                    ?>
								
                                    <?php $__currentLoopData = $studyMonthsForViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <td data-column-index="<?php echo e($dateAsIndex); ?>">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php
                                            $name = "departments[$departmentId][positions][$rowIndex][hiring_counts][$dateAsIndex]";
                                            ?>
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['numberFormatDecimals' => 0,'mark' => ' ','currentVal' => $currentPosition ? $currentPosition->getHiringCountsAtDateIndex($dateAsIndex) : 0 ,'dataGroupIndex' => ''.e($currentYearRepeaterIndex).'','classes' => 'repeater-with-collapse-input only-greater-than-or-equal-zero-allowed ','isPercentage' => true,'name' => $name,'columnIndex' => $columnIndex]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['number-format-decimals' => 0,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentPosition ? $currentPosition->getHiringCountsAtDateIndex($dateAsIndex) : 0 ),'data-group-index' => ''.e($currentYearRepeaterIndex).'','classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('repeater-with-collapse-input only-greater-than-or-equal-zero-allowed '),'is-percentage' => true,'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name),'columnIndex' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnIndex)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/manpower/_department_card.blade.php ENDPATH**/ ?>