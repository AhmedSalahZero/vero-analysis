<?php $attributes = $attributes->exceptProps([
'selectedBanks','banks','hasBatchCollection','hasSearch','moneyPaymentType','searchFields'
,'financialInstitutionBanks',
'isFirstExportMoney'=>false,
'accountTypes',
'popupTitle'=>'',
'routeAction'=>'#',
'routeRedirect'=>route('view.money.payment',['company'=>$company->id])
]); ?>
<?php foreach (array_filter(([
'selectedBanks','banks','hasBatchCollection','hasSearch','moneyPaymentType','searchFields'
,'financialInstitutionBanks',
'isFirstExportMoney'=>false,
'accountTypes',
'popupTitle'=>'',
'routeAction'=>'#',
'routeRedirect'=>route('view.money.payment',['company'=>$company->id])
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
use App\Models\MoneyPayment ;
?>
<div class="kt-portlet__head-toolbar" style="flex:1 !important;">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            <?php if($hasBatchCollection): ?>
            <a  data-money-type="<?php echo e($moneyPaymentType); ?>" data-type="multi" data-toggle="modal" data-target="#send-to-under-collection-modal<?php echo e($moneyPaymentType); ?>" id="js-send-to-under-collection-trigger<?php echo e($moneyPaymentType); ?>" href="<?php echo e(route('create.money.receive',['company'=>$company->id])); ?>" title="<?php echo e(__('Please Select More Than One Cheque')); ?>" class="btn  active-style btn-icon-sm js-can-trigger-cheque-under-collection-modal disabled">
                <i class="fas fa-book"></i>
                <?php echo e(__('Create Batch Mark As Paid')); ?>

            </a>
            <?php endif; ?>
            <?php if($hasSearch): ?>
            <a data-type="multi" data-toggle="modal" data-target="#search-money-modal-<?php echo e($moneyPaymentType); ?>" id="js-search-money-received" href="#" title="<?php echo e(__('Search Money Payments')); ?>" class="btn  active-style btn-icon-sm  ">
                <i class="fas fa-search"></i>
                <?php echo e(__('Advanced Filter')); ?>

            </a>

            <div class="modal fade" id="search-money-modal-<?php echo e($moneyPaymentType); ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <form action="<?php echo e($routeRedirect); ?>" class="row ">
                                <input name="active" type="hidden" value="<?php echo e($moneyPaymentType); ?>">
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label"><?php echo e(__('Field Name')); ?></label>
                                    <select id="js-search-modal-name-<?php echo e($moneyPaymentType); ?>" data-type="<?php echo e($moneyPaymentType); ?>" class="form-control js-search-modal" type="date" name="field" placeholder="<?php echo e(__('Delete From')); ?>">
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





            <div class="modal fade" id="send-to-under-collection-modal<?php echo e($moneyPaymentType); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form  data-money-type="<?php echo e($moneyPaymentType); ?>" id="ajax-send-cheques-to-collection-id<?php echo e($moneyPaymentType); ?>" class="ajax-send-cheques-to-collection" action="<?php echo e($routeAction); ?>" method="post">
                            <input type="hidden" id="single-or-multi<?php echo e($moneyPaymentType); ?>" value="single">
                            <input type="hidden" id="current-single-item<?php echo e($moneyPaymentType); ?>" value="0">
                            <input type="hidden" id="current-currency<?php echo e($moneyPaymentType); ?>" class="current-currency"  value="">
                            <?php echo csrf_field(); ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e($popupTitle); ?></h5>
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label><?php echo e(__('Actual Payment Date')); ?></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <input required type="text" name="actual_payment_date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/export-money-payment.blade.php ENDPATH**/ ?>