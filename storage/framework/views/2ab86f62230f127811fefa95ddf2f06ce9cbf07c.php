<?php $__env->startSection('css'); ?>
<?php
use App\Enums\LcTypes;
use App\Models\LetterOfCreditIssuance;
$slightLcType = LcTypes::SIGHT_LC ;
$deferredType = LcTypes::DEFERRED ;
$cashAgainstDocumentType = LcTypes::CASH_AGAINST_DOCUMENT ;
$allLcs = LcTypes::getAll() ;
$currentActiveTab = isset($currentActiveTab) ? $currentActiveTab : null ;


?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 300px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Letter Of Credit Issuance ')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lc nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <?php
                $index = 0 ;
                ?>
                <?php $__currentLoopData = $allLcs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active',$currentActiveTab) && $index==0 || Request('active',$currentActiveTab) == $type ?'active':''); ?>" data-toggle="tab" href="#<?php echo e($type); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e($name .' '. __('Table')); ?>

                    </a>
                </li>
                <?php
                $index = $index+1;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

            <div class="flex-tabs">
				<a href="<?php echo e(route('create.letter.of.credit.issuance',['company'=>$company->id,'source'=>LetterOfCreditIssuance::LC_FACILITY  ])); ?>" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					<?php echo e(__('New From LC Facility')); ?>

				</a>
				<a href="<?php echo e(route('create.letter.of.credit.issuance',['company'=>$company->id,'source'=>LetterOfCreditIssuance::AGAINST_CD  ])); ?>" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					<?php echo e(__('New LC Agnist CDs')); ?>

				</a>
				<a href="<?php echo e(route('create.letter.of.credit.issuance',['company'=>$company->id,'source'=>LetterOfCreditIssuance::AGAINST_TD  ])); ?>" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					<?php echo e(__('New LC Agnist TDs')); ?>

				</a>
				<a href="<?php echo e(route('create.letter.of.credit.issuance',['company'=>$company->id,'source'=>LetterOfCreditIssuance::HUNDRED_PERCENTAGE_CASH_COVER])); ?>" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					<?php echo e(__('New LC 100% Cash Cover')); ?>

				</a>
			</div >

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <?php
            $currentTab = $slightLcType ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active',$currentActiveTab) && $currentTab == $slightLcType  || Request('active',$currentActiveTab) == $currentTab ?'active':''); ?>" id="<?php echo e($currentTab); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentTab,'title' => $allLcs[$currentTab] . ' ' .__('Table') ,'startDate' => $filterDates[$currentTab]['startDate'],'endDate' => $filterDates[$currentTab]['endDate']]]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allLcs[$currentTab] . ' ' .__('Table') ),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['startDate']),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['endDate'])]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-letter-of-credit-issuance','data' => ['searchFields' => $searchFields[$currentTab],'type' => $currentTab,'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']]); ?>
<?php $component->withName('export-letter-of-credit-issuance'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentTab]),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle"><?php echo e(__('#')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Transaction <br> Name'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Source'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Status'); ?> </th>
									
                                    <th class="text-center align-middle bank-max-width" ><?php echo e(__('Bank Name')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Code')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Transaction <br> Reference'); ?> </th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Amount')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Transaction <br> Order Date'); ?> </th>
                                    <th class="text-center align-middle"><?php echo e(__('Issuance Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Due Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentTab]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td><?php echo e($model->getTransactionName()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getSourceFormatted()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getStatusFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($model->getFinancialInstitutionBankName()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getLcCode()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getTransactionReference()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getLcAmountFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getTransactionDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getIssuanceDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getDueDateFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                          <?php echo $__env->make('reports.LetterOfCreditIssuance.actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php if(!$model->isPaid()): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>" method="post">
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
											<?php endif; ?> 
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>











            <?php
            $currentTab = $deferredType ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active',$currentActiveTab) && $currentTab == $slightLcType  || Request('active',$currentActiveTab) == $currentTab ?'active':''); ?>" id="<?php echo e($currentTab); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentTab,'title' => $allLcs[$currentTab] . ' ' .__('Table') ,'startDate' => $filterDates[$currentTab]['startDate'],'endDate' => $filterDates[$currentTab]['endDate']]]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allLcs[$currentTab] . ' ' .__('Table') ),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['startDate']),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['endDate'])]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-letter-of-credit-issuance','data' => ['searchFields' => $searchFields[$currentTab],'type' => $currentTab,'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']]); ?>
<?php $component->withName('export-letter-of-credit-issuance'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentTab]),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle"><?php echo e(__('#')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Transaction <br> Name'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Source'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Status'); ?> </th>
                                    <th class="text-center align-middle bank-max-width"><?php echo e(__('Bank Name')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Code')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Amount')); ?></th>
							
                                    <th class="text-center align-middle"> <?php echo __('Purchase <br> Order Date'); ?> </th>
                                    <th class="text-center align-middle"><?php echo e(__('Issuance Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Due Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentTab]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td><?php echo e($model->getTransactionName()); ?></td>
                                    <td><?php echo e($model->getSourceFormatted()); ?></td>
                                    <td><?php echo e($model->getStatusFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($model->getFinancialInstitutionBankName()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getLcCode()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getLcAmountFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getPurchaseOrderDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getIssuanceDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getDueDateFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                          <?php echo $__env->make('reports.LetterOfCreditIssuance.actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
											<?php if(!$model->isPaid()): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>" method="post">
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
											<?php endif; ?> 
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>








            <?php
            $currentTab = $cashAgainstDocumentType ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active',$currentActiveTab) && $currentTab == $cashAgainstDocumentType  || Request('active',$currentActiveTab) == $currentTab ?'active':''); ?>" id="<?php echo e($currentTab); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentTab,'title' => $allLcs[$currentTab] . ' ' .__('Table') ,'startDate' => $filterDates[$currentTab]['startDate'],'endDate' => $filterDates[$currentTab]['endDate']]]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allLcs[$currentTab] . ' ' .__('Table') ),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['startDate']),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['endDate'])]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-letter-of-credit-issuance','data' => ['searchFields' => $searchFields[$currentTab],'type' => $currentTab,'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']]); ?>
<?php $component->withName('export-letter-of-credit-issuance'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentTab]),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'href' => ''.e(route('create.letter.of.credit.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfCreditIssuance::LC_FACILITY])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle"><?php echo e(__('#')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Transaction <br> Name'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Source'); ?> </th>
                                    <th class="text-center align-middle"> <?php echo __('Status'); ?> </th>
                                    <th class="text-center align-middle bank-max-width"><?php echo e(__('Bank Name')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Code')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Amount')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('LC Current Amount')); ?></th>
                                    <th class="text-center align-middle"> <?php echo __('Purchase <br> Order Date'); ?> </th>
                                    <th class="text-center align-middle"><?php echo e(__('Issuance Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Due Date')); ?></th>
                                    <th class="text-center align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentTab]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td><?php echo e($model->getTransactionName()); ?></td>
									<td><?php echo e($model->getSourceFormatted()); ?></td>
									<td><?php echo e($model->getStatusFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($model->getFinancialInstitutionBankName()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getLcCode()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getLcAmountFormatted()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getLcCurrentAmountFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getPurchaseOrderDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getIssuanceDateFormatted()); ?></td>
                                    <td class="text-transform text-nowrap"><?php echo e($model->getDueDateFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                        	  <?php echo $__env->make('reports.LetterOfCreditIssuance.actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
											  
											
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>">
											<i class="fa fa-pen-alt"></i>
											
											</a>
											
											<?php if(!$model->isPaid()): ?>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>" method="post">
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
											<?php endif; ?> 
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>







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
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
<script>

</script>
<script>


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
        if (searchFieldName === 'purchase_order_date') {
            modal.find('.data-type-span').html('[<?php echo e(__("Purchase Order Date")); ?>]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'issuance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Issuance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Issuance Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {
        $('.js-search-modal').trigger('change')
    })


$("button[data-dismiss=modal2]").click(function(){
    $(this).closest('.modal').modal('hide');
});

</script>
<script>
    $(document).on('change', '.recalculate-amount-in-main-currency', function() {
        const parent = $(this).closest('.modal-body');
        const amount = parseFloat($(parent).find('.amount-js').val())
        const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
        const amountInMainCurrency = parseFloat(amount * exchangeRate);
        $(parent).find('.amount-in-main-currency-js-hidden').val(amountInMainCurrency)
        $(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
    })

</script>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditIssuance/index.blade.php ENDPATH**/ ?>