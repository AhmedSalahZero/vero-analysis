<div class="row " id="contract-row-id">
    <div class="col-12">
        <hr>
    </div>
    <div class="col-md-12">
        <h3 class="kt-portlet__head-title head-title text-primary"><?php echo e(__('Choose Contract For Down Payment')); ?></h3>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="contracts"> <?php echo e(__('Contracts')); ?> </label>
            <select data-current-selected="<?php echo e(isset($model) && $model->downPayment ? $model->downPayment->getContractId():0); ?>" name="contract_id" id="contract-id" class="form-control ajax-get-sales-orders-for-contract">
            </select>
        </div>
    </div>
	<div class="col-md-12">
		

                    <div class="js-append-down-payment-to">
                        <div class="col-md-12 js-duplicate-node">

                        </div>
                    </div>

                    <div class="js-down-payment-template hidden">
                        <div class="col-md-12 js-duplicate-node">
                            <div class=" kt-margin-b-10 border-class">
                                <?php echo $__env->make('reports.moneyReceived._down-payments-sales-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>


              
	</div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyReceived/unapplied-contract.blade.php ENDPATH**/ ?>