
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
<?php echo e(__('Cash Expense Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('result.cash.expense.statement',['company'=>$company->id ])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('Start Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="start_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('End Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="end_date" value="<?php echo e(now()->addYear()); ?>">
                                </div>
                            </div>
                        </div>





                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('Select Currency')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="currency" required class="form-control  kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name">
                                        <?php $__currentLoopData = getCurrency(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency=>$currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency); ?>"><?php echo e(touppercase($currencyName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-3 mb-4">
							 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'CashExpenseCategory','addNewModalModalTitle' => __('Expense Category'),'options' => $cashExpenseCategories,'addNew' => false,'label' => __('Expense Category'),'class' => 'select2-select expense_category  ','dataUpdateCategoryNameBasedOnCategory' => true,'dataFilterType' => ''.e('create').'','all' => false,'name' => 'expense_category_id','id' => 'expense_category_id','selectedValue' => isset($model) ? $model->getExpenseCategoryId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CashExpenseCategory'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Category')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cashExpenseCategories),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Category')),'class' => 'select2-select expense_category  ','data-update-category-name-based-on-category' => true,'data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'expense_category_id','id' => 'expense_category_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getExpenseCategoryId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
						</div>


					<div class="col-md-3 mb-4">
						 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'CashExpenseCategoryName','addNewModalModalTitle' => __('Expense Name'),'previousSelectNameInDB' => 'cash_expense_category_id','previousSelectMustBeSelected' => true,'previousSelectSelector' => 'select.expense_category','previousSelectTitle' => __('Expense Name'),'options' => [],'addNew' => false,'label' => __('Expense Name'),'class' => 'select2-select category_name  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'cash_expense_category_name_id','id' => ''.e('cash_expense_category_name_id').'','selectedValue' => isset($model) ? $model->getCashExpenseCategoryNameId() : 0,'dataCurrentSelected' => ''.e(isset($model) ? $model->getCashExpenseCategoryNameId() : 0).'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CashExpenseCategoryName'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Name')),'previous-select-name-in-dB' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cash_expense_category_id'),'previous-select-must-be-selected' => true,'previous-select-selector' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('select.expense_category'),'previous-select-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Name')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Name')),'class' => 'select2-select category_name  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'cash_expense_category_name_id','id' => ''.e('cash_expense_category_name_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getCashExpenseCategoryNameId() : 0),'data-current-selected' => ''.e(isset($model) ? $model->getCashExpenseCategoryNameId() : 0).'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
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
 $(document).on('change', '[data-update-category-name-based-on-category]', function(e) {
                    const expenseCategoryId = $('select.expense_category').val()
                    if (!expenseCategoryId) {
                        return;
                    }
                    $.ajax({
                        url: "<?php echo e(route('update.expense.category.name.based.on.category',['company'=>$company->id])); ?>"
                        , data: {
                            expenseCategoryId
                        , }
                        , type: "GET"
                        , success: function(res) {
                            var options = '';
                            var currentSelectedId = $('select.category_name').attr('data-current-selected')
						
                            for (var categoryName in res.categoryNames) {
                                var categoryNameId = res.categoryNames[categoryName];
                                options += `<option ${currentSelectedId == categoryNameId ? 'selected' : '' } value="${categoryNameId}"> ${categoryName}  </option> `;
                            }
                            $('select.category_name').empty().append(options).selectpicker("refresh");
                            $('select.category_name').trigger('change')
                        }
                    })
                })
                $('[data-update-category-name-based-on-category]').trigger('change')
				
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/cash_expense_statement_form.blade.php ENDPATH**/ ?>