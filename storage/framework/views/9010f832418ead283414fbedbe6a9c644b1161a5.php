
<div data-card-id="<?php echo e($cardId); ?>" class="kt-portlet parent-card ">
    <div class="kt-portlet__body">
        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-nowrap" style=""> <?php echo e(__('Items Cost')); ?></h3>
        <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
<input id="net-branch-opening-projections" class="net-branch-opening-projections" type="hidden" value="<?php echo e(json_encode($newBranchCountPerDateIndex)); ?>">
<?php $__currentLoopData = $newBranchCountPerDateIndex; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$newBranchCountPerDateIndexRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<input  data-month-index="<?php echo e($dateAsIndex); ?>" data-year-index="<?php echo e($datesIndexWithYearIndex[$dateAsIndex]); ?>" class="year-index-month-index" type="hidden" >
 

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
		
         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['initEmpty' => false,'removeActionBtn' => false,'firstElementDeletable' => false,'fontSizeClass' => 'font-14px','appendSaveOrBackBtn' => false,'repeaterWithSelect2' => true,'parentClass' => 'js-toggle-visibility-----','tableName' => $tableId ,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['initEmpty' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeActionBtn' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'first-element-deletable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'append-save-or-back-btn' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-toggle-visibility-----'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId ),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
             <?php $__env->slot('ths'); ?> 
                
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => '  header-border-down first-column-th-class','title' => __('Item <br> Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item <br> Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' tenor-selector-class header-border-down ','title' => __('Item <br> Cost')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Item <br> Cost'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' header-border-down rate-class','title' => __('VAT <br> Rate')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' header-border-down rate-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('VAT <br> Rate'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' header-border-down rate-class','title' => __('Withhold <br> Tax %')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' header-border-down rate-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Withhold <br> Tax %'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' header-border-down rate-class','title' => __('Contingency <br> Rate %')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' header-border-down rate-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contingency <br> Rate %'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => ' tenor-selector-class header-border-down ','title' => __('Cost Annual <br> Increase %')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => ' tenor-selector-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cost Annual <br> Increase %'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => 'header-border-down','title' => __('Payment <br> Terms'),'helperTitle' => __('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => 'header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payment <br> Terms')),'helperTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => 'header-border-down','title' => __('Depreciation <br> Duration')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => 'header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Depreciation <br> Duration'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => 'header-border-down','title' => __('Replacement <br> Cost %')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => 'header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Replacement <br> Cost %'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => 'header-border-down','title' => __('Replacement <br> Interval')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => 'header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Replacement <br> Interval'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['fontSizeClass' => 'font-14px','class' => 'header-border-down','title' => __('Count')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['font-size-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('font-14px'),'class' => 'header-border-down','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Count'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('trs'); ?> 
                <?php
                $rows = isset($model) ? $model->fixedAssets : [-1] ;
                ?>
                <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                if( !($subModel instanceof \App\Models\NonBankingService\FixedAsset) ){
                unset($subModel);
                }
                ?>
                <tr data-repeater-item data-repeat-formatting-decimals="2" data-repeater-style>

                    <td class="text-center">
                        <div class="">
                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                            </i>
                        </div>
                    </td>
                    <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
                    <input type="hidden" name="type" value="<?php echo e($fixedAssetType); ?>">
                    <td>
                        <div class="">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getName() : ''); ?>" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> class="form-control text-left exclude-from-trigger-change-when-repeat" type="text">

                        </div>
                    </td>
                    <td>
                        <div class="">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getItemCost() : 0); ?>" <?php if($isRepeater): ?> name="ffe_item_cost" <?php else: ?> name="<?php echo e($tableId); ?>[0][ffe_item_cost]" <?php endif; ?> class="form-control expandable-amount-input text-left ffe-item-cost trigger-change-repeater recalculate-monthly-increase-amounts-branches" type="text">
                        </div>
                    </td>

                    <td>


                        <div class="d-flex align-items-center">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getVatRate():0); ?>" <?php if($isRepeater): ?> name="vat_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][vat_rate]" <?php endif; ?> class="form-control  exclude-from-trigger-change-when-repeat expandable-percentage-input text-left " type="text">
                            <span style="margin-left:3px	">%</span>
                        </div>
                    </td>
                    <td>


                        <div class="d-flex align-items-center">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getWithholdTaxRate():0); ?>" <?php if($isRepeater): ?> name="withhold_tax_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][withhold_tax_rate]" <?php endif; ?> class="form-control exclude-from-trigger-change-when-repeat expandable-percentage-input text-left exclude-from-trigger-change-when-repeat" type="text">
                            <span style="margin-left:3px	">%</span>
                        </div>
                    </td>
					
					 <td>
                        <div class="d-flex align-items-center">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getContingencyRate():0); ?>" <?php if($isRepeater): ?> name="contingency_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][contingency_rate]" <?php endif; ?> class="form-control contingency-rate recalculate-monthly-increase-amounts-branches exclude-from-trigger-change-when-repeat expandable-percentage-input text-left exclude-from-trigger-change-when-repeat" type="text">
                            <span style="margin-left:3px	">%</span>
                        </div>
                    </td>
					
                    <td>


                        <div class="d-flex align-items-center">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getCostAnnualIncreaseRate():0); ?>" <?php if($isRepeater): ?> name="cost_annual_increase_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][cost_annual_increase_rate]" <?php endif; ?> :formattedInputClasses="'exclude-from-trigger-change-when-repeat'" class="form-control expandable-percentage-input text-left cost-annually-increase-rate recalculate-monthly-increase-amounts-branches" type="text">
                            <span style="margin-left:3px	">%</span>
                        </div>
                    </td>
                    <td>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getPaymentTerm() : 'cash','options' => getFfePaymentTerms(),'addNew' => false,'class' => 'select2-select repeater-select payment_terms ','all' => false,'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentTerm() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getFfePaymentTerms()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select payment_terms ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) payment_terms @else '.e($tableId).'[0][payment_terms] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.custom-collection','data' => ['subModel' => isset($subModel) ? $subModel : null ,'tableId' => $tableId,'isRepeater' => $isRepeater,'id' => $repeaterId.'test-modal-id']]); ?>
<?php $component->withName('modal.custom-collection'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subModel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel : null ),'tableId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId.'test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </td>
                    <td>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getDepreciationDuration() : 0,'options' => getDepreciationDurations(),'addNew' => false,'class' => 'select2-select repeater-select depreciation_duration ','all' => false,'name' => '@if($isRepeater) depreciation_duration @else '.e($tableId).'[0][depreciation_duration] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getDepreciationDuration() : 0),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getDepreciationDurations()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select depreciation_duration ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) depreciation_duration @else '.e($tableId).'[0][depreciation_duration] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </td>
                    <td>


                        <div class="">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getReplacementCostRate():0); ?>" <?php if($isRepeater): ?> name="replacement_cost_rate" <?php else: ?> name="<?php echo e($tableId); ?>[0][replacement_cost_rate]" <?php endif; ?> class="form-control expandable-percentage-input exclude-from-trigger-change-when-repeat text-left " type="text">

                        </div>
                    </td>
                    <td>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['selectedValue' => isset($subModel) ? $subModel->getReplacementInterval() : 'cash','options' => getReplacementInterval(),'addNew' => false,'class' => 'select2-select repeater-select  ','all' => false,'name' => '@if($isRepeater) replacement_interval @else '.e($tableId).'[0][replacement_interval] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getReplacementInterval() : 'cash'),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getReplacementInterval()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select  ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) replacement_interval @else '.e($tableId).'[0][replacement_interval] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </td>
					 <td>


                        <div class="">
                            <input value="<?php echo e(isset($subModel) ? $subModel->getCount():0); ?>" <?php if($isRepeater): ?> name="counts" <?php else: ?> name="<?php echo e($tableId); ?>[0][counts]" <?php endif; ?> class="form-control expandable-percentage-input current-count recalculate-monthly-increase-amounts-branches exclude-from-trigger-change-when-repeat text-left " type="text">
                        </div>
						<div>
							<input class="current-row-counts" type="hidden" name="ffe_counts" value="">
							
						</div>
						
						
						<?php $__currentLoopData = $newBranchCountPerDateIndex; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex=>$newBranchCountPerDateIndexRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						 <input type="hidden" value="<?php echo e(isset($subModel) ? $subModel->getMonthlyAmountAtMonthIndex($dateAsIndex) : 0); ?>" name="monthly_amounts" multiple class="current-month-amounts" data-column-index="<?php echo e($dateAsIndex); ?>">

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                    </td>

                    



                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php $__env->endSlot(); ?>





         <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 




        
        
	<?php
		$isFullyFundingTroughEquity = $model->getFixedAssetStructureForFixAssetType($fixedAssetType) ? $model->getFixedAssetStructureForFixAssetType($fixedAssetType)->is_fully_funded_though_equity : 1;
	?>

        <div class="form-group d-inline-block">
            <div class="kt-radio-inline">
                <label class="mr-3">

                </label>
                <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                    <input class="is-fully-funded-checkbox exclude-from-trigger-change-when-repeat" type="radio" value="1" name="fixedAssetsFundingStructures[is_fully_funded_though_equity]" <?php if(!isset($subModel) || ($isFullyFundingTroughEquity)): ?> checked <?php endif; ?>
                    > <?php echo e(__('Fully Funded Through Equity')); ?>

                    <span></span>
                </label>

                <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                    <input class="is-fully-funded-checkbox exclude-from-trigger-change-when-repeat" type="radio" value="0" name="fixedAssetsFundingStructures[is_fully_funded_though_equity]" <?php if(isset($subModel) && !$isFullyFundingTroughEquity): ?> checked <?php endif; ?>
                    > <?php echo e(__('Funded Through Equity & Debt')); ?>

                    <span></span>
                </label>
            </div>
        </div>

    </div>


</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/new-branch-fixed-assets/_repeater.blade.php ENDPATH**/ ?>