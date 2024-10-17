<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Contract Cash Flow Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('result.contract.cashflow.report',['company'=>$company->id ])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">

                <div class="kt-portlet__body closest-parent-tr">



                    <div class="form-group row">


                        <div class="col-md-2 mb-3">
                            <label><?php echo e(__('Report Interval')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="report_interval" class="form-control " required>
									     <option value=""><?php echo e(__('Select')); ?></option>
                                        <option value="daily"><?php echo e(__('Daily')); ?></option>
                                        <option value="weekly" ><?php echo e(__('Weekly')); ?></option>
                                        <option value="monthly"><?php echo e(__('Monthly')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['label' => __('Customer'),'pleaseSelect' => false,'selectedValue' => isset($currentContract) && $currentContract->client ? $currentContract->client->id : '','options' => formatOptionsForSelect($clientsWithContracts),'addNew' => false,'class' => 'select2-select suppliers-or-customers-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'partner_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Customer')),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($currentContract) && $currentContract->client ? $currentContract->client->id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatOptionsForSelect($clientsWithContracts)),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select suppliers-or-customers-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'partner_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                        <div class="col-md-3">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['label' => __('Contract'),'pleaseSelect' => false,'dataCurrentSelected' => ''.e(isset($currentContract) ? $currentContract->id : '').'','selectedValue' => isset($currentContract) ? $currentContract->id : '','options' => [],'addNew' => false,'class' => 'select2-select  contracts-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'contract_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contract')),'pleaseSelect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-current-selected' => ''.e(isset($currentContract) ? $currentContract->id : '').'','selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($currentContract) ? $currentContract->id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  contracts-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'contract_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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


                        <div class="col-md-3">
                            <label><?php echo e(__('Contract Start Date')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required disabled type="date" value="" class="form-control contract-start-date-class" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label><?php echo e(__('Contract End Date')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required disabled type="date" value="" class="form-control contract-end-date-class" />
                                </div>
                            </div>
                        </div>









                        <div class="col-md-3">
                            <label><?php echo e(__('Report Start Date')); ?>  <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="start_date">
                                    <input required type="date" class="form-control" name="start_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label><?php echo e(__('Report End Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="end_date">
                                    <input required type="date" class="form-control" name="end_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>

                        </div>



                    </div>
                     <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                </div>
            </div>





        </form>

        <!--end::Form-->

        <!--end::Portlet-->
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
    $(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('.closest-parent-tr')
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
        const parent = $(this).closest('.closest-parent-tr')
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/contract_cash_flow_form.blade.php ENDPATH**/ ?>