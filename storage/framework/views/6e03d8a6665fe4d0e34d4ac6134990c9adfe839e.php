<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<style>
.custom-w-25{
	width:23% !important;
}
.custom-w-50{
	width:50% !important;
}

    .max-w-name {
        width: 45% !important;
        min-width: 45% !important;
        max-width: 45% !important;
    }

    .max-w-currency {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .max-w-amount {
        width: 15% !important;
        min-width: 15% !important;
        max-width: 15% !important;
    }

    .max-w-report-btn {
        width: 15% !important;
        min-width: 15% !important;
        max-width: 15% !important;
    }

    .is-sub-row.is-total-row td.sub-numeric-bg,
    .is-sub-row.is-total-row td.sub-text-bg {
        background-color: #087383 !important;
        color: white !important;
    }

    .is-name-cell {
        white-space: normal !important;
    }

    .top-0 {
        top: 0 !important;
    }

    .parent-tr td {
        border: 1px solid #E2EFFE !important;
    }

    .dataTables_filter {
        width: 30% !important;
        text-align: left !important;

    }

    .border-parent {
        border: 2px solid #E2EFFE;
    }

    .dt-buttons.btn-group,
    .buttons-print {
        max-width: 30%;
        margin-left: auto;
        position: relative;
        top: 45px;
    }

    .details-btn {
        display: block;
        margin-top: 10px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 600;

    }

    .expand-all {
        cursor: pointer;
    }

    td.editable-date.max-w-fixed,
    th.editable-date.max-w-fixed,
    input.editable-date.max-w-fixed {
        width: 1050px !important;
        max-width: 1050px !important;
        min-width: 1050px !important;

    }

    td.editable-date.max-w-classes-expand,
    th.editable-date.max-w-classes-expand,
    input.editable-date.max-w-classes-expand {
        width: 70px !important;
        max-width: 70px !important;
        min-width: 70px !important;

    }

    td.max-w-classes-name,
    th.max-w-classes-name,
    input.max-w-classes-name {
        width: 350px !important;
        max-width: 350px !important;
        min-width: 350px !important;

    }

    td.max-w-grand-total,
    th.max-w-grand-total,
    input.max-w-grand-total {
        width: 100px !important;
        max-width: 100px !important;
        min-width: 100px !important;

    }

    * {
        box-sizing: border-box !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Invoices Table') . '[ '. $partnerName .' ] '.'[ '. $currency .' ]'); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">

        <div class="kt-portlet">


            <div class="kt-portlet__body">

                <?php

                $tableId = 'kt_table_1';
                ?>


                <style>
                    td.editable-date,
                    th.editable-date,
                    input.editable-date {
                        width: 100px !important;
                        min-width: 100px !important;
                        max-width: 100px !important;
                        overflow: hidden;
                    }

                    .width-66 {


                        width: 66% !important;
                    }

                    .border-bottom-popup {
                        border-bottom: 1px solid #d6d6d6;
                        padding-bottom: 20px;
                    }

                    .flex-self-start {
                        align-self: flex-start;
                    }

                    .flex-checkboxes {
                        margin-top: 1rem;
                        flex: 1;
                        width: 100% !important;
                    }


                    .flex-checkboxes>div {
                        width: 100%;
                        width: 100% !important;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        flex-wrap: wrap;
                    }

                    .custom-divs-class {
                        display: flex;
                        flex-wrap: wrap;
                        align-items: center;
                        justify-content: center;
                    }


                    .modal-backdrop {
                        display: none !important;
                    }

                    .modal-content {
                        min-width: 600px !important;
                    }

                    .form-check {
                        padding-left: 0 !important;

                    }

                    .main-with-no-child,
                    .main-with-no-child td,
                    .main-with-no-child th {
                        background-color: #046187 !important;
                        color: white !important;
                        font-weight: bold;
                    }

                    .is-sub-row td.sub-numeric-bg,
                    .is-sub-row td.sub-text-bg {
                        border: 1.5px solid white !important;
                        background-color: #0e96cd !important;
                        color: white !important;


                        background-color: #E2EFFE !important;
                        color: black !important
                    }



                    .sub-numeric-bg {
                        text-align: center;

                    }



                    th.dtfc-fixed-left {
                        background-color: #074FA4 !important;
                        color: white !important;
                    }

                    .header-tr,
                        {
                        background-color: #046187 !important;
                    }

                    .dt-buttons.btn-group {
                        display: flex;
                        align-items: flex-start;
                        justify-content: flex-end;
                        margin-bottom: 1rem;
                    }

                    .is-sales-rate,
                    .is-sales-rate td,
                    .is-sales-growth-rate,
                    .is-sales-growth-rate td {
                        background-color: #046187 !important;
                        color: white !important;
                    }

                    .dataTables_wrapper .dataTable th,
                    .dataTables_wrapper .dataTable td {
                        font-weight: bold;
                        color: black;
                    }

                    a[data-toggle="modal"] {
                        color: #046187 !important;
                    }

                    a[data-toggle="modal"].text-white {
                        color: white !important;
                    }

                    .btn-border-radius {
                        border-radius: 10px !important;
                    }

                </style>
                <?php echo csrf_field(); ?>
                <div class="text-right">

                    

                    <a href="<?php echo e(route('view.contracts.down.payments',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType,'currency'=>$currency])); ?>" class="btn active-style btn-icon-sm align-self-center">
                        <i class="fas fa-money-bill"></i>
                        <?php echo e(__('Down Payment Amount Settlement')); ?>

                    </a>

                </div>

                <div class="table-custom-container position-relative  ">


                    <div>




                        <div class="responsive">
                            <table class="table kt_table_with_no_pagination_no_collapse table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                                <thead>

                                    <tr class="header-tr ">

                                        <th class="view-table-th max-w-serial bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('#')); ?>

                                        </th>
										
																				<?php if($hasProjectNameColumn): ?>
																				<th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Project Name')); ?>

                                        </th>
																				<?php endif; ?>

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Date')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Number')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Net Invoice Amount')); ?>

                                        </th>
										
										<th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Withhold Amount')); ?>

                                        </th>
										
										<th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Total Deductions')); ?>

                                        </th>	
										<th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Total Collection')); ?>

                                        </th>
										
										

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Due Date')); ?>

                                        </th>
										
										

                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Net Balance')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Status')); ?>

                                        </th>
                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Aging')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Adjust Due Date')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Deductions')); ?>

                                        </th>


                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Actions')); ?>

                                        </th>

                                        
                                    </tr>

                                </thead>
                                <tbody>
                                    <script>
                                        let currentTable = null;

                                    </script>
                          

                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                        <td class="sub-text-bg max-w-serial   "><?php echo e($index+1); ?></td>
										<?php if($hasProjectNameColumn): ?>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getProjectName()); ?></td>
										<?php endif; ?>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getInvoiceDateFormatted()); ?></td>
										
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getInvoiceNumber()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getNetInvoiceAmountFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getWithholdAmountFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getTotalDeductionFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getTotalCollectedFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getDueDateFormatted()); ?></td>
                                        <td class="sub-text-bg text-center text-nowrap"><?php echo e($invoice->getNetBalanceFormatted()); ?></td>
                                        <td class="sub-text-bg text-center text-wrap"><?php echo e($invoice->getStatusFormatted()); ?></td>
                                        <td class="sub-text-bg  text-center">
                                            <?php echo e($invoice->getAging()); ?>

                                        </td>
                                        <td class="sub-text-bg  text-center">
                                            <?php if(!$invoice->$isCollectedOrPaid()): ?>
                                            <a href="<?php echo e(route('adjust.due.dates',['company'=>$company->id,'modelId'=>$invoice->id ,'modelType'=>getModelNameWithoutNamespace($invoice) ])); ?>" title="<?php echo e(__('Adjust Due Date')); ?>" class="btn btn-sm btn-success" <?php if($invoice->dueDateHistories->count()): ?>
                                                style="background-color:orange !important;color:black !important;border-color:white !important;"
                                                <?php else: ?>
                                                style="background-color:green !important; border-color:white !important;"
                                                <?php endif; ?>
                                                ><?php echo e($invoice->dueDateHistories->count() ? __('Adjusted') : __('Adjust Due Date')); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="sub-text-bg  text-center">
                                            
                                            <button type="button" class="add-new btn btn-primary d-block" data-toggle="modal" data-target="#add-new-customer-modal-<?php echo e($invoice->id); ?>">
                                                <?php echo e(__('Deduct')); ?>

                                            </button>
                                            <div class="modal fade modal-class-js allocate-modal-class" id="add-new-customer-modal-<?php echo e($invoice->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Deduct')); ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                        <form action="<?php echo e(route('update.invoice.deductions',['company'=>$company->id,'modelId'=>$invoice->id , 'modelType'=>$modelType])); ?>" method="post">
														<?php echo method_field('patch'); ?>
														<?php echo csrf_field(); ?>
														    <div class="form-group row justify-content-center">
                                                                <?php
                                                                $index = 0 ;
                                                                ?>

                                                                
                                                                <?php
                                                                $tableId = 'deductions';

                                                                $repeaterId = 'model_repeater';

                                                                ?>
                                                                
                                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['initialJs' => false,'repeaterWithSelect2' => true,'parentClass' => 'show-class-js','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                                                     <?php $__env->slot('ths'); ?> 
                                                                        <?php $__currentLoopData = [
                                                                        __('Deduction')=>'th-main-color custom-w-50',
                                                                        __('Date')=>'th-main-color custom-w-25',
                                                                        __('Deduction Amount')=>'th-main-color custom-w-25',
                                                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title=>$classes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ''.e($classes).'','title' => $title]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ''.e($classes).'','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                     <?php $__env->endSlot(); ?>
                                                                     <?php $__env->slot('trs'); ?> 
                                                                        <?php
                                                                     	 $rows = isset($invoice) ? $invoice->deductions :[-1] ;

                                                                        ?>
                                                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deductionWithPivot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                        $fullPath = new \App\Models\Deduction;
                                                                        if( !($deductionWithPivot instanceof $fullPath) ){
                                                                        unset($deductionWithPivot);
                                                                        }
                                                                        ?>
																	
																						<tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>

																							<td class="text-center">
																								<input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
																								<div class="custom-w-50">
																									<i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
																									</i>
																								</div>
																							</td>
																							<td>

																								 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['insideModalWithJs' => false,'selectedValue' => isset($deductionWithPivot) && $deductionWithPivot->pivot->deduction_id ? $deductionWithPivot->pivot->deduction_id : '','options' => formatOptionsForSelect($deductions),'addNew' => false,'class' => 'select2-select repeater-select form-control custom-w-100','dataFilterType' => ''.e('create').'','all' => false,'name' => 'deduction_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['insideModalWithJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($deductionWithPivot) && $deductionWithPivot->pivot->deduction_id ? $deductionWithPivot->pivot->deduction_id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatOptionsForSelect($deductions)),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select repeater-select form-control custom-w-100','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'deduction_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
																							</td>



																							<td>
																							
																								<div class="kt-input-icon ">
																									<div class="input-group date custom-w-100">
																										<input type="text" name="date" value="<?php echo e(isset($deductionWithPivot) ? formatDateForDatePicker($deductionWithPivot->pivot->date) : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control is-date-css refresh-datepicker-js  kt_datepicker_max_date_is_today" readonly placeholder="Select date"  />
																										<div class="input-group-append">
																											<span class="input-group-text">
																												<i class="la la-calendar-check-o"></i>
																											</span>
																										</div>
																									</div>
																								</div>
																							</td>



																							<td>
																								<div class="kt-input-icon custom-w-100">
																									<div class="input-group">
																										<input type="text" name="amount" class="form-control only-greater-than-or-equal-zero-allowed" value="<?php echo e(isset($deductionWithPivot) ? $deductionWithPivot->pivot->amount: 0); ?>">
																									</div>
																								</div>
																							</td>


																						</tr>



																						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

																						 <?php $__env->endSlot(); ?>




																						 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
																						


                       										 </div>
															 	<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
									<button type="submit" class="btn btn-primary submit-form-btn "><?php echo e(__('Save')); ?></button>
								</div>
														</form>
               				     </div>
							
                </div>
            </div>
        </div>

        
        </td>

        <td class="sub-text-bg  text-center">
            <?php if(!$invoice->$isCollectedOrPaid()): ?>
            <a href="<?php echo e(route($moneyReceivedOrPaidUrlName,['company'=>$company->id,'model'=>$invoice->id ])); ?>" title="<?php echo e($moneyReceivedOrPaidText); ?>" class="btn btn-sm btn-primary"><?php echo e($moneyReceivedOrPaidText); ?></a>
            <?php endif; ?>
        </td>


        

        


        

        </tr>






<?php $__env->startPush('js_end'); ?>
<script>
$(function(){
	$('.kt_datepicker_max_date_is_today').datepicker({
 autoclose: true,
 todayHighlight: true,
   orientation: "bottom left",
// format: 'mm/dd/yyyy',
 endDate: new Date(), 

 rtl:false
});
})
</script>
	
<?php $__env->stopPush(); ?>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        </table>
    </div>

</div>

<?php $__env->startPush('js'); ?>
<script>
    var table = $(".kt_table_with_no_pagination_no_collapse");

    table.DataTable({




            dom: 'Bfrtip'

            , "processing": false
            , "scrollX": true
            , "scrollY": true
            , "ordering": false
            , 'paging': false
            , "fixedColumns": {
                left: 2
            }
            , "fixedHeader": {
                headerOffset: 60
            }
            , "serverSide": false
            , "responsive": false
            , "pageLength": 25
            , drawCallback: function(setting) {
                if (!currentTable) {
                    currentTable = $('.main-table-class').DataTable();
                }
                $('.buttons-html5').addClass('btn border-parent btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
                $('.buttons-print').addClass('btn border-parent top-0 btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
            },





        }

    )

</script>
<?php $__env->stopPush(); ?>

</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
    function getDateFormatted(yourDate) {
        const offset = yourDate.getTimezoneOffset()
        yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000))
        return yourDate.toISOString().split('T')[0]
    }

    am4core.ready(function() {

        // Themes begin



    }); // end am4core.ready()

</script>
<script>
    $(document).on('click', '#show-past-due-detail', function() {
        if (!currentTable) {
            currentTable = $('.main-table-class').DataTable()
        }
        if (currentTable.column(2).visible()) {
            $(this).html("<?php echo e(__('Show Details')); ?>")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(false);
        } else {
            $(this).html("<?php echo e(__('Hide Details')); ?>")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(true);
        }
    })

    $(document).on('click', '#show-coming-due-detail', function() {
        if (!currentTable) {
            currentTable = $('.main-table-class').DataTable()
        }
        if (currentTable.column(13).visible()) {
            $(this).html("<?php echo e(__('Show Details')); ?>")
            currentTable.columns([13, 14, 15, 16, 17, 18, 19, 20, 21]).visible(false);
        } else {
            $(this).html("<?php echo e(__('Hide Details')); ?>")
            currentTable.columns([13, 14, 15, 16, 17, 18, 19, 20, 21]).visible(true);
        }
    })

</script>
<script>
    $('.model_repeater').repeater({
        initEmpty: false,
		initEmpty:false
        , isFirstItemUndeletable: false
        , defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
            $('input.trigger-change-repeater').trigger('change')
            $(document).find('.datepicker-input').datepicker({
                dateFormat: 'mm-dd-yy'
                , autoclose: true
            })
            $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                reinitalizeMonthYearInput(dateInput)
            });
            $('input:not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");
            $(this).find('.refresh-datepicker-js').datepicker('update', '<?php echo e(now()->format("m/d/Y")); ?>')
        },

        hide: function(deleteElement) {
            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement, function() {

                        deleteElement();
                        $('input.trigger-change-repeater').trigger('change')

                    });
                }
            }
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/invoice-report.blade.php ENDPATH**/ ?>