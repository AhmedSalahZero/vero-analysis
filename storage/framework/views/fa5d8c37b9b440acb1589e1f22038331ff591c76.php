<div class="col-md-3 hidden hide-only-bond">

                                        <label> <?php echo e(__('Contract Reference')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <select  data-contract-type="<?php echo e(isset($model) ? $model->getContractType() : ''); ?>"  js-update-purchase-orders-based-on-contract id="contract-id" data-current-selected="<?php echo e(isset($model) ?  $model->getContractId() : 0); ?>" name="contract_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                           
                                        </select>
                                    </div>





                                    <div class="col-md-2 hidden hide-only-bond">

                                        <label> <?php echo e(__('Purchase Order')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>

                                        <select id="purchase-order-id" data-current-selected="<?php echo e(isset($model) ? $model->getPurchaseOrderId() : 0); ?>" name="purchase_order_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                          
                                        </select>
										<input placeholder="<?php echo e(__('New PO')); ?>" id="new-purchase-order-id" class="form-control " type="text" name="new_purchase_order_number" value="<?php echo e(isset($model) ? $model->getNewPoNumber(): ''); ?>" style="display:none">
                                    </div>

                                    <div class="col-md-2 hidden hide-only-bond">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Purchase Order Date'),'required' => true,'model' => $model??null,'name' => 'purchase_order_date','placeholder' => __('Select Purchase Order Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Purchase Order Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('purchase_order_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Purchase Order Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
<?php $__env->startPush('js_end'); ?>
	 <script>
               $(function(){
				
				 $(document).on('change', '[js-update-contracts-based-on-customers]', function(e) {
        const customerId = $('select#customer_name').val()
        if (!customerId) {
            return;
        }
        $.ajax({
            url: "<?php echo e(route('update.contracts.based.on.customer',['company'=>$company->id])); ?>"
            , data: {
                customerId
            , }
            , type: "GET"
            , success: function(res) {
                var currentSelectedId = $('select#contract-id').attr('data-current-selected')
				let contractType = $('select#contract-id').attr('data-contract-type');
                var contractsOptions = `<option value="-1" ${contractType == 'no-po' ? 'selected' : '' }><?php echo e(__("New PO")); ?></option> <option ${contractType == 'existing-po' ? 'selected' : '' } value="-2"><?php echo e(__("Existing PO")); ?></option>`;
                for (var contractId in res.contracts) {
                    var contractName = res.contracts[contractId];
                    contractsOptions += `<option ${currentSelectedId == contractId ? 'selected' : '' } value="${contractId}"> ${contractName}  </option> `;
                }
                $('select#contract-id').empty().append(contractsOptions).selectpicker("refresh");
                $('select#contract-id').trigger('change')
            }
        })
    })
    $('[js-update-contracts-based-on-customers]').trigger('change')
		
				 $(document).on('change', '[js-update-purchase-orders-based-on-contract]', function(e) {
                    let contractId = $('select#contract-id').val()
					$('select#purchase-order-id').empty().append('').selectpicker("refresh");
                    if (!contractId) {
                        contractId = -2;
                    }
					const currentNewPurchaseOrder = $('#new-purchase-order-id').val()
                    $.ajax({
                        url: "<?php echo e(route('update.purchase.orders.based.on.contract',['company'=>$company->id])); ?>"
                        , data: {
                            contractId,
							currentNewPurchaseOrder
                        , }
                        , type: "GET"
                        , success: function(res) {
							$('select#purchase-order-id').parent().parent().find('.form-element-hidden').removeClass('form-element-hidden');
								$('input#new-purchase-order-id').hide();
							if(res.showTextInputForNewPO){
								$('select#purchase-order-id').addClass('form-element-hidden');
								$('input#new-purchase-order-id').show();
								return 
							}
                            var purchaseOrdersOptions = '';
                            var currentSelectedId = $('select#purchase-order-id').attr('data-current-selected')
                            for (var purchaseOrderId in res.purchase_orders) {
                                var contractName = res.purchase_orders[purchaseOrderId];
                                purchaseOrdersOptions += `<option ${currentSelectedId == purchaseOrderId ? 'selected' : '' } value="${purchaseOrderId}"> ${contractName}  </option> `;
                            }
							
                            $('select#purchase-order-id').empty().append(purchaseOrdersOptions).selectpicker("refresh");
                        }
                    })
                })
			$('[js-update-purchase-orders-based-on-contract]').trigger('change')
			   })

            </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditIssuance/_contract-inputs.blade.php ENDPATH**/ ?>