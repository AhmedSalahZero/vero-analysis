<div class="form-group row align-items-end">

    <div class="col-md-4">
        <label><?php echo e(__('SO Number')); ?> </label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[0][sales_order_name]" type="text" readonly class="form-control js-sales-order-name">
            <input name="sales_orders_amounts[0][sales_order_id]" type="hidden" readonly class="form-control js-sales-order-number">
        </div>
    </div>

    <div class="col-md-2 closest-parent">
        <label><?php echo e(__('Amount')); ?>  <span class="contract-currency"></span> </label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[0][net_invoice_amount]" type="text" disabled class="form-control js-amount">
        </div>
    </div>

    <div class="col-md-2 closest-parent">
        <label><?php echo e(__('Received Amount')); ?> <span class="contract-currency"> </label> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[0][received_amount]" placeholder="<?php echo e(__('Received Amount')); ?>" value="0" type="text" class="form-control js-received-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
        </div>
    </div>


</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyReceived/_down-payments-sales-orders.blade.php ENDPATH**/ ?>