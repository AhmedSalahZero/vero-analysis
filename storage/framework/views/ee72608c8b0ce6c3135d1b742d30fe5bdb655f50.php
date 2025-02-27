<?php
use App\Models\NonBankingService\Study;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/financial-planning/common.css">
<style>
	.bg-white-hover:hover {
		color:white !important;
	}
	.new-study-item i {
		color:#055dac !important
	}
	.new-study-item:hover i {
		color:white !important;
	}
</style>
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
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == Study::BUSINESS_PLAN ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Study::BUSINESS_PLAN); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Business Plan')); ?>

                    </a>
                </li>
				
				 <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == Study::ANNUALLY_STUDY ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Study::ANNUALLY_STUDY); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Annually Study')); ?>

                    </a>
                </li>
				


            </ul>
            
			
			 <div class="flex-tabs">
                 <a href="<?php echo e(route('create.consumerfinance.products',['company'=>$company->id])); ?>" class="btn new-record-class new-study-item rounded btn-icon-sm align-self-center">
                    <i class="fas fa-plus exclude-icon"></i>
                    <?php echo e(__('Consumer Finance Products')); ?>

                </a>
				
				 <a href="<?php echo e(route('create.microfinance.products',['company'=>$company->id])); ?>" class="btn new-record-class new-study-item rounded btn-icon-sm align-self-center">
                    <i class="fas fa-plus exclude-icon"></i>
                    <?php echo e(__('Microfinance Products')); ?>

                </a>
			   
				  <a href="<?php echo e(route('create.leasing.categories',['company'=>$company->id])); ?>" class="btn new-record-class new-study-item rounded btn-icon-sm align-self-center">
                    <i class="fas fa-plus white-icon exclude-icon"></i>
                    <?php echo e(__('Leasing Products')); ?>

                </a>
				
                <a href="<?php echo e(route('create.study',['company'=>$company->id])); ?>" class="btn btn-2-bg bg-white-hover new-study-item rounded btn-icon-sm align-self-center">
                    <i class="fas fa-plus white-icon exclude-icon"></i>
                    <?php echo e(__('New Study')); ?>

                </a>
				
				
            </div>
			
            
            

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
		
			  <?php
            $currentType = Study::BUSINESS_PLAN ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Start Date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('End Date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('End Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Financial Statement')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Financial Statement'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                
                                
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Dashboard')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Dashboard'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Actions')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Actions'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <?php
                                $currentLoanTotalPerYear = [];
                                ?>

                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                        <div class="">

                                            <input value="<?php echo e($model->getName()); ?>" disabled class="form-control text-left " type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $model->getStudyStartDateFormattedForView(),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->getStudyStartDateFormattedForView()),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
									  <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $model->getStudyEndDateFormattedForView(),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->getStudyEndDateFormattedForView()),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
									<td>
										<div class="d-flex align-items-center flex-column " style="gap:10px;">
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="<?php echo e(route('view.non.banking.forecast.income.statement',['company'=>$company->id,'study'=>$model->id])); ?>" class="btn btn-md-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Income Statement')); ?></a>  
											<a href="#" class="btn btn-md-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Balance Sheet')); ?></a>  
										</div>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-md-width btn-3-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Cash Flow')); ?></a>  
											<a href="#" class="btn btn-md-width btn-4-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Ratio Analysis')); ?></a>  
										</div>
										</div>
										
									</td>
									
									<td>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Result')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Valuation')); ?></a>  
										</div>
									</td>
									  <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon edit-btn-class" title="<?php echo e(__('Edit')); ?>" href="<?php echo e(route('edit.study',['company'=>$company->id,'study'=>$model->id])); ?>"><i class="fa fa-pen-alt exclude-icon default-icon-color" ></i></a>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon copy-btn-class" title="<?php echo e(__('Copy')); ?>" href="<?php echo e(route('edit.study',['company'=>$company->id,'study'=>$model->id])); ?>"><i class="fa fa-layer-group exclude-icon default-icon-color" ></i></a>
											
											
                                            <a data-toggle="modal" data-target="#delete-study-<?php echo e($model->id); ?>" type="button" class="btn delete-btn-class btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt exclude-icon default-icon-color"></i></a>
                                            <div class="modal fade" id="delete-study-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('study.destroy',['company'=>$company->id,'study'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											
                                        </span>
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
						
                    
                </div>
            </div>
			
			
			
            <?php
            $currentType = Study::ANNUALLY_STUDY ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => '  header-border-down first-column-th-class','title' => __('Study Name')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => '  header-border-down first-column-th-class','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Study Name'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Start Date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('End Date')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('End Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Income Statement')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Income Statement'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Balance Sheet')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Balance Sheet'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Cash Flow')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Flow'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Dashboard')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Dashboard'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ' interval-class header-border-down ','title' => __('Actions')]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ' interval-class header-border-down ','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Actions'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 

                                <?php
                                $currentLoanTotalPerYear = [];
                                ?>

                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                        <div class="">

                                            <input value="<?php echo e($model->getName()); ?>" disabled class="form-control text-left " type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $model->getStudyStartDateFormattedForView(),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->getStudyStartDateFormattedForView()),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
									  <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.repeat-right-dot-inputs','data' => ['removeThreeDots' => true,'removeCurrency' => true,'mark' => ' ','isNumber' => false,'removeThreeDotsClass' => true,'numberFormatDecimals' => 0,'currentVal' => $model->getStudyEndDateFormattedForView(),'classes' => '','isPercentage' => false,'name' => '','columnIndex' => 0]]); ?>
<?php $component->withName('repeat-right-dot-inputs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['removeThreeDots' => true,'removeCurrency' => true,'mark' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'is-number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'removeThreeDotsClass' => true,'number-format-decimals' => 0,'currentVal' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model->getStudyEndDateFormattedForView()),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'is-percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'columnIndex' => 0]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                        </div>
                                    </td>
									<td>
										<div class="d-flex align-items-center flex-column " style="gap:10px;">
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Forecast')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Actual')); ?></a>  
										</div>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-3-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Adjusted')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-4-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Modified')); ?></a>  
										</div>
										</div>
										
									</td>
									<td>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Forecast')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Actual')); ?></a>  
										</div>
									</td>
									<td>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Forecast')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Actual')); ?></a>  
										</div>
									
									</td>
									<td>
										<div class="d-flex mr-auto" style="gap:10px;">
											<a href="#" class="btn btn-sm-width btn-1-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Forecast')); ?></a>  
											<a href="#" class="btn btn-sm-width btn-2-bg btn-sm btn-brand btn-pill" ><?php echo e(__('Actual')); ?></a>  
										</div>
									</td>
									  <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon edit-btn-class" title="Edit" href="<?php echo e(route('edit.study',['company'=>$company->id,'study'=>$model->id])); ?>"><i class="fa fa-pen-alt exclude-icon default-icon-color" ></i></a>
											
											
                                            <a data-toggle="modal" data-target="#delete-study-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon delete-btn-class" title="Delete" href="#"><i class="fa fa-trash-alt exclude-icon default-icon-color"></i></a>
                                            <div class="modal fade" id="delete-study-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('study.destroy',['company'=>$company->id,'study'=>$model->id ])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											
                                        </span>
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
						
                    
                </div>
            </div>




            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>



<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'transfer_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Transfer Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script src="/custom/js/financial-planning/common.js"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/study/index.blade.php ENDPATH**/ ?>