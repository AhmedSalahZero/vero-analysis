  <div class="form-group row align-items-end">

      <div class="col-md-4">
          <label><?php echo e(__('PO Number')); ?> </label>
          <div class="kt-input-icon">
              <input name="purchases_orders_amounts[][purchases_order_name]" type="text" readonly class="form-control js-purchases-order-name">
              <input name="purchases_orders_amounts[][purchases_order_id]" type="hidden" readonly class="form-control js-purchases-order-number">
          </div>
      </div>

      <div class="col-md-2">
          <label><?php echo e(__('Amount')); ?> </label>
          <div class="kt-input-icon">
              <input name="purchases_orders_amounts[][net_invoice_amount]" type="text" disabled class="form-control js-amount">
          </div>
      </div>


      <div class="col-md-2">
          <label><?php echo e(__('Paid Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
          <div class="kt-input-icon">
              <input name="purchases_orders_amounts[][paid_amounts]" placeholder="<?php echo e(__('Paid Amount')); ?>" type="text" class="form-control js-paid-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
          </div>
      </div>


  </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyPayments/_down-payments-purchase-orders.blade.php ENDPATH**/ ?>