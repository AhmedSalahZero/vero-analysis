
<div class="row">
    <div class="col-12">
        <hr>
    </div>
    <div class="col-md-12">
        <h3 class="kt-portlet__head-title head-title text-primary"><?php echo e(__('Choose Contract For Downpayment')); ?></h3>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="contracts"> <?php echo e(__('Contracts')); ?> </label>
            <select data-current-selected="<?php echo e(isset($model) ? $model->getContractId():0); ?>" name="contract_id" id="contracts" class="form-control">
            </select>
        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/unapplied-contract.blade.php ENDPATH**/ ?>