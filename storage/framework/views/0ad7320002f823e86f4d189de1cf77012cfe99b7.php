
<?php $__env->startSection('dash_nav'); ?>
<style>
    .chartdiv {
        width: 100%;
        height: 250px;
    }

    .chartdivdonut {
        width: 100%;
        height: 500px;
    }

    .chartdivchart {
        width: 100%;
        height: 500px;
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

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Cash Flow')); ?>

                </h3>





            </div>

        </div>
        <div class="kt-portlet__body">
            <form action="">
                <div class="row ">
				
				<div class="col-md-2 mb-3">
                            <label><?php echo e(__('Report Interval')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="report_interval" class="form-control " required>
									     <option value=""><?php echo e(__('Select')); ?></option>
                                        <option value="daily" <?php if($selectedReportInterval == 'daily' ): ?>  selected <?php endif; ?>><?php echo e(__('Daily')); ?></option>
                                        <option value="weekly"  <?php if($selectedReportInterval == 'weekly' ): ?>  selected <?php endif; ?>><?php echo e(__('Weekly')); ?></option>
                                        <option value="monthly" <?php if($selectedReportInterval == 'monthly' ): ?>  selected <?php endif; ?>><?php echo e(__('Monthly')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-3">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['label' => __('Select'),'pleaseSelect' => false,'selectedValue' => $selectedPartnerId,'options' => array_merge([['title'=>__('Company Cash Flow'),'value'=>'0']],formatOptionsForSelect($clientsWithContracts)),'addNew' => false,'class' => 'select2-select suppliers-or-customers-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'partner_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select')),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedPartnerId),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(array_merge([['title'=>__('Company Cash Flow'),'value'=>'0']],formatOptionsForSelect($clientsWithContracts))),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select suppliers-or-customers-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'partner_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                        <div class="col-md-3">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['label' => __('Contract'),'pleaseSelect' => false,'dataCurrentSelected' => ''.e($selectedContractId).'','selectedValue' => $selectedContractId,'options' => [],'addNew' => false,'class' => 'select2-select  contracts-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'contract_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contract')),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-current-selected' => ''.e($selectedContractId).'','selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedContractId),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  contracts-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'contract_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>



                        <div class="col-md-2">
                            <label><?php echo e(__('Contract Code')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="input-group">
                                <input disabled type="text" class="form-control contract-code" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label><?php echo e(__('Contract Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="input-group">
                                <input disabled type="text" class="form-control contract-amount" value="0">
                            </div>
                        </div>
						
                    <div class="col-md-2 ">
                        <label><?php echo e(__('Start Date')); ?> <span class="multi_selection"></span> </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input required type="date" class="form-control" name="cash_start_date" value="<?php echo e($cashStartDate); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label><?php echo e(__('End Date')); ?> <span class="multi_selection"></span> </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input required type="date" class="form-control" name="cash_end_date" value="<?php echo e($cashEndDate); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="visibility-hidden"> <?php echo e(__('dd')); ?>

                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="input-group">
                            <button type="submit" class="btn active-style save-form"><?php echo e(__('Save')); ?></button>
                        </div>
                    </div>

                </div>
            </form>


            <div class="kt-portlet__body" style="padding-bottom:0 !important;">
                <ul style="margin-bottom:0 ;" class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <?php
                    $index = 0 ;
                    // $selectedCurrencies = ['USD'=>'USD'];
                    ?>


                    <?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyUpper=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li class="nav-item <?php if($index ==0 ): ?> active <?php endif; ?>">
                        <a class="nav-link <?php if($index ==0 ): ?> active <?php endif; ?>" data-toggle="tab" href="#kt_apps_contacts_view_tab_main<?php echo e($index); ?>" role="tab">
                            <i class="flaticon2-checking icon-lg"></i>
                            <span style="font-size:18px !important;"><?php echo e($currency); ?></span>
                        </a>
                    </li>

                    <?php
                    $index++;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

        </div>
    </div>
</div>


<div class="tab-content  kt-margin-t-20">
    <?php
    $index = 0 ;
    ?>
    <?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="tab-pane  <?php if($index == 0): ?> active <?php endif; ?>" id="kt_apps_contacts_view_tab_main<?php echo e($index); ?>" role="tabpanel">

        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Monthly Cash Flow')); ?>

                        </h3>
                    </div>
                    <div class="kt-portlet__head-label ">
                        <div class="kt-align-right">
                            <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chartdivchart" id="chartdivmulti<?php echo e($currency); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Accumulated Cash Flow')); ?>

                        </h3>
                    </div>
                    <div class="kt-portlet__head-label ">
                        <div class="kt-align-right">
                            <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chartdivchart" id="chartdivline1<?php echo e($currency); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__("Receivables & Payables Aging ")); ?>

							<?php echo e(__('Date As Of ')); ?> [ <?php echo e(now()->format('d-m-Y')); ?> ] 
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        

        <?php $__currentLoopData = $invoiceTypesModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e($modelType. __(' Aging')); ?>

                        </h3>
                    </div>
                    <div class="kt-portlet__head-label ">
                        <div class="kt-align-right">
                            <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-sm table-striped table-head-bg-brand ">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th><?php echo e(__('Invoices Aging')); ?></th>
                                        <th class="text-center"><?php echo e(__('Invoices Amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $dashboardResult['invoices_aging'][$modelType][$currency]['table'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dueType => $dueWithValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $dueWithValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInternal => $totalForDaysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(camelizeWithSpace($dueType,'_')); ?> <?php echo e($daysInternal); ?> <?php echo e(__('Days')); ?> </td>
                                        <td class="text-center"><?php echo e(number_format($totalForDaysInterval,0)); ?></td>
                                    </tr>
                                    <?php
                                    $total += $totalForDaysInterval ;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td><?php echo e(__('Total')); ?></td>
                                        <td class="text-center"><?php echo e(number_format($total,0)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <div class="chartdivchart" id="chartdiv__<?php echo e($modelType.$currency); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php if($modelType == 'CustomerInvoice'): ?>
                            <?php echo e(__('Customers Cheques Aging')); ?>

                            <?php else: ?>
                            <?php echo e(__('Suppliers Cheques Aging')); ?>

                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="kt-portlet__head-label ">
                        <div class="kt-align-right">
                            <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>
                            <button type="button" class="btn btn-sm btn-pill color-rose"><i class="fa fa-chart-line"></i> <?php echo e(__('Rejected Cheques Report')); ?> </button>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-sm table-striped table-head-bg-brand ">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th><?php echo e(__('Cheques Aging')); ?></th>
                                        <th class="text-center"><?php echo e(__('Cheques Amount')); ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0 ;
                                    ?>
                                    <?php $__currentLoopData = $dashboardResult['cheques_aging'][$modelType][$currency]['table'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dueType => $dueWithValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($dueType == 'coming_due' || $dueType =='current_due'): ?>
                                    <?php $__currentLoopData = $dueWithValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInternal => $totalForDaysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(camelizeWithSpace($dueType,'_')); ?> <?php echo e($daysInternal); ?> <?php echo e(__('Days')); ?> </td>
                                        <td class="text-center"><?php echo e(number_format($totalForDaysInterval,0)); ?></td>
                                    </tr>
                                    <?php
                                    $total += $totalForDaysInterval ;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(__('Total')); ?></td>
                                        <td class="text-center"><?php echo e(number_format($total)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <div class="chartdivchart" id="chartdivline2_<?php echo e($modelType.$currency); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>














        
        <div class="row">
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__("Long & Short Term Facilities Comming Dues ")); ?>

                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="<?php echo e(route('result.withdrawals.settlement.report',['company'=>$company->id ])); ?>">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="kt-portlet ">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Withdrawal dues')); ?>

                                </h3>
								
                            </div>
							<div class="kt-portlet__head-label" style="gap:25px;margin-top:10px;">
									<div class="form-group">
										<label for="" class="label"><?php echo e(__('Start')); ?></label>
										<input js-refresh-withdrawal-due-data-and-chart type="date" data-currency="<?php echo e($currency); ?>" class="form-control withdrawal-start-date" name="withdrawal_start_date" value="<?php echo e($withdrawalStartDate); ?>">
									</div>
									<div class="form-group">
										<label for="" class="label"><?php echo e(__('End')); ?></label>
                                    <input js-refresh-withdrawal-due-data-and-chart type="date" data-currency="<?php echo e($currency); ?>" class="form-control withdrawal-end-date" name="withdrawal_end_date" value="<?php echo e($withdrawalEndDate); ?>">
									</div>
								</div>
                            <div class="kt-portlet__head-label ">
                                <div class="kt-align-right">

                                    <?php echo csrf_field(); ?>
	
                                    <input type="hidden" name="currency" value="<?php echo e($currency); ?>">
                                    <?php $__currentLoopData = $allFinancialInstitutionIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allFinancialInstitutionId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="financial_institution_ids[]" value="<?php echo e($allFinancialInstitutionId); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <button type="submit" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>

                                </div>



                            </div>


                        </div>


                        <div class="kt-portlet__body">
                            
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <select name="account_type" data-currency="<?php echo e($currency); ?>" js-refresh-withdrawal-due-data-and-chart class="form-control withdrawal-account-type-js">
                                        <?php $__currentLoopData = $overdraftAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overdraftAccountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($overdraftAccountType->isCleanOverdraftAccount() ): ?> selected <?php endif; ?> value="<?php echo e($overdraftAccountType->id); ?>"><?php echo e($overdraftAccountType->getName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-sm table-striped table-head-bg-brand ">
                                                <thead class="thead-inverse">
                                                    <tr>
                                                        <th><?php echo e(__('Date')); ?></th>
                                                        <th class="text-center"><?php echo e(__('Amount')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="append-withdrawal-due-<?php echo e($currency); ?>">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="chartdivchart" id="withdrawal-dues-chart-<?php echo e($currency); ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="kt-portlet ">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Long Term Facilities Comming Dues')); ?>

                                </h3>
                            </div>
							<div class="kt-portlet__head-label" style="gap:25px;margin-top:10px;">
									<div class="form-group">
										<label for="" class="label"><?php echo e(__('Start')); ?></label>
										<input type="date" class="form-control" name="loan_start_date" value="<?php echo e($loanStartDate); ?>">
									</div>
									<div class="form-group">
										<label for="" class="label"><?php echo e(__('End')); ?></label>
                                    <input type="date" class="form-control" name="loan_end_date" value="<?php echo e($loanEndDate); ?>">
									</div>
								</div>
                            <div class="kt-portlet__head-label ">
                                <div class="kt-align-right">
                                    <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </button>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-sm table-striped table-head-bg-brand ">
                                                <thead class="thead-inverse">
                                                    <tr>
                                                        <th><?php echo e(__('Date')); ?></th>
                                                        <th class="text-center"><?php echo e(__('Amount')); ?></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Date 1</td>
                                                        <td class="text-center">600,000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date 2</td>
                                                        <td class="text-center">600,000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date 3</td>
                                                        <td class="text-center">600,000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date 4</td>
                                                        <td class="text-center">600,000</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="chartdivchart" id="chartdivline5<?php echo e($currency); ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </form>
    </div>

    <?php
    $index++;
    ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
    var ammount_array = [{
        "date": "2012-07-27"
        , "value": 13
    }, {
        "date": "2012-07-28"
        , "value": 11
    }, {
        "date": "2012-07-29"
        , "value": 15
    }, {
        "date": "2012-07-30"
        , "value": 16
    }, {
        "date": "2012-07-31"
        , "value": 18
    }, {
        "date": "2012-08-01"
        , "value": 13
    }, {
        "date": "2012-08-02"
        , "value": 22
    }, {
        "date": "2012-08-03"
        , "value": 23
    }, {
        "date": "2012-08-04"
        , "value": 20
    }, {
        "date": "2012-08-05"
        , "value": 17
    }, {
        "date": "2012-08-06"
        , "value": 16
    }, {
        "date": "2012-08-07"
        , "value": 18
    }, {
        "date": "2012-08-08"
        , "value": 21
    }, {
        "date": "2012-08-09"
        , "value": 26
    }, {
        "date": "2012-08-10"
        , "value": 24
    }, {
        "date": "2012-08-11"
        , "value": 29
    }, {
        "date": "2012-08-12"
        , "value": 32
    }, {
        "date": "2012-08-13"
        , "value": 18
    }, {
        "date": "2012-08-14"
        , "value": 24
    }, {
        "date": "2012-08-15"
        , "value": 22
    }, {
        "date": "2012-08-16"
        , "value": 18
    }, {
        "date": "2012-08-17"
        , "value": 19
    }, {
        "date": "2012-08-18"
        , "value": 14
    }, {
        "date": "2012-08-19"
        , "value": 15
    }, {
        "date": "2012-08-20"
        , "value": 12
    }, {
        "date": "2012-08-21"
        , "value": 8
    }, {
        "date": "2012-08-22"
        , "value": 9
    }, {
        "date": "2012-08-23"
        , "value": 8
    }, {
        "date": "2012-08-24"
        , "value": 7
    }, {
        "date": "2012-08-25"
        , "value": 5
    }, {
        "date": "2012-08-26"
        , "value": 11
    }];

</script>
<?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyUpper=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $invoiceTypesModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Chart code -->
<script>
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("chartdiv__<?php echo e($modelType.$currency); ?>", am4charts.XYChart);



        chartData = <?php echo json_encode(($dashboardResult['invoices_aging'][$modelType][$currency]['chart'] ?? []), 15, 512) ?>;
        chartData = chartData.reverse()

        chart.data = chartData;

        // Create axes
        var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        yAxis.dataFields.category = "state";
        yAxis.renderer.grid.template.location = 0;
        yAxis.renderer.labels.template.fontSize = 10;
        yAxis.renderer.minGridDistance = 10;

        var xAxis = chart.xAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueX = "sales";
        series.dataFields.categoryY = "state";
        series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
        series.columns.template.strokeWidth = 0;
        series.columns.template.adapter.add("fill", function(fill, target) {
            if (target.dataItem) {
                switch (target.dataItem.dataContext.region) {

                    case "Past Due":
                        return "#C70039";
                    case "Coming Due":
                        return "#1D9D23";
                    case "Current Due":
                        return "#000";
                }
            }
            return fill;
        });

        var axisBreaks = {};
        var legendData = [];


       

        let groups = [];
        for (i = 0; i < chartData.length; i++) {
            var currentCategory = chartData[i].region;
            var currentState = chartData[i].state;

            var currentCategoryExist = groups.find(element => {
                if (element.name == currentCategory) {
                    return true;
                }
            })


            if (currentCategoryExist) {
                var index = groups.findIndex(obj => obj.name == currentCategory)
                groups[index].last_due = currentState
            } else {
                currentState = null
                if (currentCategory == 'Coming Due') {
                    currentState = getLastAppearanceOfKeyInObject(chartData, 'Coming Due');
                 
                }
                if (currentCategory == 'Past Due') {
                    currentState = getLastAppearanceOfKeyInObject(chartData, 'Past Due');
                }
                if (currentCategory == 'Current Due') {
                    currentState = '0 Days';
                }

                groups.push({
                    name: currentCategory
                    , first_due: currentState
                    , last_due: currentState
                })
            }
        }


        for (var i = 0; i < groups.length; i++) {
            var color = '#000';
            if (groups[i].name == "<?php echo e(__('Coming Due')); ?>") { // coming due 
                color = '#1D9D23';
            }
            if (groups[i].name == "<?php echo e(__('Current Due')); ?>") {
                color = '#000';
            }
            if (groups[i].name == "<?php echo e(__('Past Due')); ?>") {
                color = '#C70039'
            }


        }
        chart.cursor = new am4charts.XYCursor();
        var legend = new am4charts.Legend();
        legend.position = "bottom";
        legend.scrollable = true;
        legend.valign = "top";
        legend.reverseOrder = true;

        chart.legend = legend;

        legend.data = legendData;



    }); 

</script>

<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline2_<?php echo e($modelType.$currency); ?>", am4charts.XYChart);

        // Add data

        var chartData = <?php echo json_encode(($dashboardResult['cheques_aging'][$modelType][$currency]['chart'] ?? []), 15, 512) ?>;
        chart.data = chartData;
        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline1<?php echo e($currency); ?>", am4charts.XYChart);

        // Add data
        chart.data =  <?php echo json_encode($cashFlowReport['accumulated_net_cash'] ?? [], 15, 512) ?>;;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;
		
        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;


        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("withdrawal-dues-chart-<?php echo e($currency); ?>", am4charts.XYChart);

        // Add data
        chart.data = [];

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); 

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline5<?php echo e($currency); ?>", am4charts.XYChart);

        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    });

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivline6<?php echo e($currency); ?>", am4charts.XYChart);

        // Add data
        chart.data = ammount_array;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;

    }); // end am4core.ready()

</script>







<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdivmulti<?php echo e($currency); ?>", am4charts.XYChart);

        //

        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = <?php echo json_encode($cashFlowReport['total_cash_in_out_flow'] ?? [], 15, 512) ?>;
		

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;


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


        createAxisAndSeries("cash_in", "Cash Inflow", false, "circle");
        createAxisAndSeries("cash_out", "Cash Outflow", true, "circle");
        // createAxisAndSeries("hits", "Hits", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); 
    $(document).on('change', '[js-refresh-withdrawal-due-data-and-chart][data-currency="<?php echo e($currency); ?>"]', function() {
        const currencyName = $(this).attr('data-currency')
        const currentChartId = 'withdrawal-dues-chart-' + currencyName;
        const accountTypeId = $('select.withdrawal-account-type-js[data-currency="'+currencyName+'"]').val()
		const withdrawalStartDate = $('.withdrawal-start-date[data-currency="'+currencyName+'"]').val()
		const withdrawalEndDate = $('.withdrawal-end-date[data-currency="'+currencyName+'"]').val()


        $.ajax({
            url: "<?php echo e(route('refresh.withdrawal.report',['company'=>$company->id])); ?>"
            , data: {
                accountTypeId
                , currencyName,
				withdrawalStartDate,
				withdrawalEndDate
            }
            , type: "get"
            , success: function(res) {
                let data = []
                let chartData = []
                let trs = '';
                for (var item of res.data) {
                    trs += `<tr> 
					<td>${item.due_date}</td>
					<td class="text-center">${number_format(item.net_balance)}</td>
				 </tr>`
                    chartData.push({
                        date: item.due_date
                        , value: item.net_balance
                    })
                }
                $('#append-withdrawal-due-' + currencyName).empty().append(trs)
                am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = chartData
            }
        })
    })

</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
   

    $('select[js-refresh-withdrawal-due-data-and-chart]').trigger('change')

</script>
<script>
    function getLastAppearanceOfKeyInObject(items, key) {
        var result = '';
        for (object of items) {
            if (object.region == key) {
                result = object.state;
            }
        }
        return result;
    }

</script>
<script>
 $(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('.kt-portlet__body')
        const code = $(this).find('option:selected').data('code')
        const amount = $(this).find('option:selected').data('amount')
        const currency = $(this).find('option:selected').data('currency') ? $(this).find('option:selected').data('currency').toUpperCase() : ''
        const startDate = $(this).find('option:selected').data('start-date')
        const endDate = $(this).find('option:selected').data('end-date')
        $(parent).find('.contract-code').val(code)
        $(parent).find('.contract-amount').val(number_format(amount) + ' ' + currency)
        $(parent).find('.contract-start-date-class').val(startDate)
        $(parent).find('.contract-end-date-class').val(endDate)


    })

    $(document).on('change', 'select.suppliers-or-customers-js', function() {
        const parent = $(this).closest('.kt-portlet__body')
        const partnerId = parseInt($(this).val())
        const model = 'Customer'
        let inEditMode = 0;

        $.ajax({
            url: "<?php echo e(route('get.contracts.for.customer.or.supplier',['company'=>$company->id])); ?>"
            , data: {
                partnerId
                , model
                , inEditMode
            }
            , type: "get"
            , success: function(res) {
                let contracts = '';
                const currentSelected = $(parent).find('select.contracts-js').data('current-selected')
                for (var contract of res.contracts) {
                    contracts += `<option ${currentSelected ==contract.id ? 'selected' :'' } value="${contract.id}" data-code="${contract.code}" data-amount="${contract.amount}" data-start-date="${contract.start_date}" data-end-date="${contract.end_date}" data-currency="${contract.currency}" >${contract.name}</option>`;
                }
			
                parent.find('select.contracts-js').empty().append(contracts).trigger('change')
            }
        })
    })
    $(function() {
        $('select.suppliers-or-customers-js').trigger('change')
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/forecast.blade.php ENDPATH**/ ?>