 
 
                    <?php
                    $repeaterId = $tableId.'_repeater';
					use App\Formatter\Select2Formatter; 
					use App\Models\NonBankingService\Position;
                    ?>
                    <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['removeRepeater' => false,'repeaterWithSelect2' => true,'canAddNewItem' => $canAddNewItem,'parentClass' => 'js-remove-hidden','hideAddBtn' => true,'tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=!(isset($removeRepeater) && $removeRepeater)]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'canAddNewItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($canAddNewItem),'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('js-remove-hidden'),'hide-add-btn' => true,'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=!(isset($removeRepeater) && $removeRepeater))]); ?>
                         <?php $__env->slot('ths'); ?> 
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' category-selector-class header-border-down  ','title' => __('Position Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' category-selector-class header-border-down  ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            
                            
                            
                            
                            
                            
                            
                            
                            
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('trs'); ?> 
                            <?php
                            $rows = isset($model) ? $model->positions : [-1] ;
                            ?>
                            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if( !($subModel instanceof Position) ){
                            unset($subModel);
                            }
                            ?>
                            <tr data-repeater-style="<?php echo e($isRepeater ? 1 : -1); ?>" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="<?php echo e(isset($subModel) ? $subModel->id : 0); ?>">
								
								    <td>
 									<input value="<?php echo e((isset($subModel) ?$subModel->getName() : '')); ?>" <?php if($isRepeater): ?> name="name" <?php else: ?> name="<?php echo e($tableId); ?>[0][name]" <?php endif; ?> class="form-control text-center " type="text">
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
                    
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/manpower-structure/_repeater.blade.php ENDPATH**/ ?>