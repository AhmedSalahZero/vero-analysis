<?php $attributes = $attributes->exceptProps([
'selectedBanks','banks','hasBatchCollection','hasSearch','moneyReceivedType','searchFields'
,'financialInstitutionBanks',
'isFirstExportMoney'=>false,
'accountTypes'
]); ?>
<?php foreach (array_filter(([
'selectedBanks','banks','hasBatchCollection','hasSearch','moneyReceivedType','searchFields'
,'financialInstitutionBanks',
'isFirstExportMoney'=>false,
'accountTypes'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
use App\Models\MoneyReceived ;
?>
<div class="kt-portlet__head-toolbar" style="flex:1 !important;">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            <?php if($hasBatchCollection): ?>
            <a  data-money-type="<?php echo e($moneyReceivedType); ?>" data-type="multi" data-toggle="modal" data-target="#send-to-under-collection-modal<?php echo e($moneyReceivedType); ?>" id="js-send-to-under-collection-trigger<?php echo e($moneyReceivedType); ?>" href="<?php echo e(route('create.money.receive',['company'=>$company->id])); ?>" title="<?php echo e(__('Please Select More Than One Cheque')); ?>" class="btn  active-style btn-icon-sm js-can-trigger-cheque-under-collection-modal disabled">
                <i class="fas fa-book"></i>
                <?php echo e(__('Create Batch Send To Collection')); ?>

            </a>
            <?php endif; ?>
            <?php if($hasSearch): ?>
            <a data-type="multi" data-toggle="modal" data-target="#search-money-modal-<?php echo e($moneyReceivedType); ?>" id="js-search-money-received" href="#" title="<?php echo e(__('Search Money Received')); ?>" class="btn  active-style btn-icon-sm  ">
                <i class="fas fa-search"></i>
                <?php echo e(__('Advanced Filter')); ?>

            </a>

            <div class="modal fade" id="search-money-modal-<?php echo e($moneyReceivedType); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle"><?php echo e(__('Filter Form')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo csrf_field(); ?>
                            <form action="<?php echo e(route('view.money.receive',['company'=>$company->id])); ?>" class="row ">
                                <input name="active" type="hidden" value="<?php echo e($moneyReceivedType); ?>">
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label"><?php echo e(__('Field Name')); ?></label>
                                    <select id="js-search-modal-name-<?php echo e($moneyReceivedType); ?>" data-type="<?php echo e($moneyReceivedType); ?>" class="form-control js-search-modal" type="date" name="field" placeholder="<?php echo e(__('Delete From')); ?>">
                                        <?php $__currentLoopData = $searchFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(Request('field')==$name): ?> selected <?php endif; ?> value="<?php echo e($name); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label"><?php echo e(__('Search Text')); ?></label>
                                    <input name="value" type="text" value="<?php echo e(request('value')); ?>" placeholder="<?php echo e(__('Search Text')); ?>" class="form-control search-field">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-from " class="label"><?php echo e(__('From')); ?> <span class="data-type-span"><?php echo e(__('[ Receiving Date ]')); ?></span> </label>
                                    <input name="from" type="date" value="<?php echo e(request('from')); ?>" class="form-control">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-to " class="label"><?php echo e(__('To')); ?> <span class="data-type-span"><?php echo e(__('[ Receiving Date ]')); ?></span> </label>
                                    <input name="to" type="date" value="<?php echo e(request('to')); ?>" class="form-control">

                                </div>



                                <div class="modal-footer">
                                    <button type="submit" href="<?php echo e(route('view.money.receive',['company'=>$company->id])); ?>" id="js-search-id" type="submit" id="" class="btn btn-primary"><?php echo e(__('Search')); ?></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>





            <div class="modal fade" id="send-to-under-collection-modal<?php echo e($moneyReceivedType); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form  data-money-type="<?php echo e($moneyReceivedType); ?>" id="ajax-send-cheques-to-collection-id<?php echo e($moneyReceivedType); ?>" class="ajax-send-cheques-to-collection" action="<?php echo e(route('cheque.send.to.collection',['company'=>$company->id])); ?>" method="post">
                            <input type="hidden" id="single-or-multi<?php echo e($moneyReceivedType); ?>" value="single">
                            <input type="hidden" id="current-single-item<?php echo e($moneyReceivedType); ?>" value="0">
                            <input type="hidden" id="current-currency<?php echo e($moneyReceivedType); ?>" class="current-currency"  value="">
                            <?php echo csrf_field(); ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Send This Cheque / Cheques To Under Collection ?')); ?></h5>
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label><?php echo e(__('Cheque Deposit Date')); ?></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <input required type="text" name="deposit_date" value="" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9 mb-3">
                                        <label><?php echo e(__('Drawal Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date ">
                                                <select js-when-change-trigger-change-account-type data-financial-institution-id required name="drawl_bank_id" class="form-control js-drawl-bank">
                                                    <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->cheque && $model->cheque->getDraweeBankId() == $financialInstitutionBank->id ? 'selected':''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">


                                    <div class="col-md-3 ">
                                        <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                    <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select name="account_number" class="form-control js-account-number">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label><?php echo e(__('Balance')); ?> <span class="balance-date-js"></span> </label>
                                        <div class="kt-input-icon">
                                            <input   value="0" type="text" disabled class="form-control balance-js" placeholder="<?php echo e(__('Account Balance')); ?>">
											
                                            
                                        </div>
                                    </div>
									  <div class="col-md-2 mb-3">
                                        <label><?php echo e(__('Net Balance')); ?> <span class="net-balance-date-js"></span> </label>
                                        <div class="kt-input-icon">
                                            <input   value="0" type="text" disabled class="form-control net-balance-js" placeholder="<?php echo e(__('Net Balance')); ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label><?php echo e(__('Clearance Days')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <input value="0" required name="clearance_days" step="any" min="0" class="form-control only-greater-than-zero-or-equal-allowed" placeholder="<?php echo e(__('Clearance Days')); ?>">
                                             <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                        </div>
                                    </div>



                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success 
								
								
								
								"><?php echo e(__('Confirm')); ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/export-money.blade.php ENDPATH**/ ?>