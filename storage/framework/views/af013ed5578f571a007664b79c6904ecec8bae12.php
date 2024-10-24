<?php $__env->startPush('css'); ?>
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
.max-w-100{
	max-width:100px;
}
    .show-hide-repeater {
        cursor: pointer
    }

    [data-css-col-name="Code"],
    [data-css-col-name="code"],
    [data-css-col-name="id"],
    [data-css-col-name="ID"],
    [data-css-col-name="Id"],
    [data-css-col-name="Item"],
    [data-css-col-name="item"] {
        max-width: 300px !important;
        min-width: 300px !important;
        width: 300px !important;

    }



    svg[xmlns],
    svg[xmlns] * {
        width: 100%;
        height: 100%;
    }

    .dt-buttons.btn-group.flex-wrap {
        float: right;
    }

    .arrow-right {
        right: 10px !important;
    }

    .arrow-left {
        left: 10px !important;
    }

    .dataTables_filter {
        display: none !important;
    }

    .flex-1 {
        flex: 1 !important;
    }

    tbody .kt-option {
        border: none;
        padding: 0 !important;
        position: relative !important;
        top: -20px !important;
        max-width: 30px !important;
        left: 28% !important;
        height: 0 !important;
    }

    th .kt-checkbox.kt-checkbox--brand>span:after {
        border-color: white !important;
    }

    th .kt-checkbox.kt-checkbox--brand>span {
        border-color: white !important;
    }

    th .kt-checkbox.kt-checkbox--brand.kt-checkbox--bold>input~span {
        color: white !important;
    }

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('css'); ?>
<style>
    table {
        white-space: nowrap;

    }

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(camelToTitle($modelName)); ?> <?php echo e(__('Section')); ?>

 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.navigators-dropdown','data' => ['navigators' => $navigators ?? []]]); ?>
<?php $component->withName('navigators-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['navigators' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($navigators ?? [])]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
$user = auth()->user();
$additionalTitle = $modelName == 'LoanSchedule' && isset($loan)  ? ' [ ' . $loan->getName(). ' ]' : ''; 
?>

<?php if($modelName == 'LabelingItem' ): ?>
<input id="pagination-per-page" type="hidden" value="<?php echo e($company->labeling_pagination_per_page); ?>">
<?php
$date = now()->format('d-m-Y')
?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Labeling Setting')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Labeling Setting'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>
    </div>
    <div class="kt-portlet__body">
        <form class="row" action="<?php echo e(route('save.labeling.item',['company'=>$company->id])); ?>" encrypt="multipart/form-data">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="label-table">
                        <?php echo e(__('Labeling Type')); ?>

                    </label>
                    <select name="labeling_type" class="form-control" id="labeling-type">
                        <option <?php if($company->labeling_type != 'barcode'): ?> selected <?php endif; ?> value="qrcode"><?php echo e(__('QR Code')); ?></option>
                        <option <?php if($company->labeling_type == 'barcode'): ?> selected <?php endif; ?> value="barcode"><?php echo e(__('Barcode')); ?></option>
                    </select>
                </div>

            </div>
			<?php if(!$hasLabelingItemCodeField): ?>
			<div class="col-md-3">
                <div class="form-group">
                    <label for="label-table">
                        <?php echo e(__('Generate Code From ')); ?>

                    </label>
                    <select  multiple name="generate_labeling_code_fields[]" class="form-control select2-select" id="labeling-code" data-live-search="true">
						<?php $__currentLoopData = $exportables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exportableName=> $exportableTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(strtolower($exportableName) == 'item' || strtolower($exportableName) == 'code' ): ?>
						<?php continue; ?>	
						<?php endif; ?>
                        <option <?php if(in_array($exportableName,(array)$company->generate_labeling_code_fields) ): ?> selected <?php endif; ?> value="<?php echo e($exportableName); ?>"><?php echo e($exportableTitle); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </select>
                </div>

            </div>
			<?php endif; ?> 
			



            <div class="col-md-3">
                <div class="form-group">
                    <label for="label-height"><?php echo e(__('Pagination Length')); ?></label>
                    <input value="<?php echo e($company->labeling_pagination_per_page); ?>" class="form-control" type="number" step="any" name="labeling_pagination_per_page">
                </div>
            </div>
			
			 <div class="col-md-3">
                <div class="form-group">
                    <label for="label-height"><?php echo e(__('Label / Sticker Height (cm)')); ?></label>
                    <input value="<?php echo e($company->label_height); ?>" class="form-control" type="number" step="any" name="label_height">
                </div>
            </div>
			
			 <div class="col-md-3">
                <div class="form-group">
                    <label for="label-height"><?php echo e(__('Label / Sticker Width (cm)')); ?></label>
                    <input value="<?php echo e($company->label_width); ?>" class="form-control" type="number" step="any" name="label_width">
                </div>
            </div>
			
			 <div class="col-md-3">
                <div class="form-group">
                    <label for="label-height"><?php echo e(__('Client Logo')); ?></label>
                    <input value="<?php echo e($company->labeling_client_logo); ?>" class="form-control" type="file" step="any" name="labeling_client_logo">
                </div>
            </div>
			
			 <div class="col-md-2">
                <div class="form-group" style="text-align:center">
                    <label for="label-height"><?php echo e(__('Use Client Logo')); ?></label>
                    <input style="max-width:25px;height:25px;margin:auto" value="1" 
					<?php if($company->labeling_use_client_logo): ?>
					checked
					<?php endif; ?> 
					class="form-control" type="checkbox"  name="labeling_use_client_logo">
                </div>
            </div>
			
			
			
			
            <div class="col-md-5">
                <div class="form-group">
                    <label for="label-height"><?php echo e(__('Report Title')); ?></label>
                    <input id="report__title_for_labeling" value="<?php echo e($company->labeling_report_title); ?>" class="form-control" type="text" step="any" name="labeling_report_title">
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group">
                    <label style="visibility:hidden;display:block" for="label-height"><?php echo e(__('submit form')); ?></label>
                    <button class="active-btn btn btn-primary mx-auto submit-form-btn js-save-labeling-info"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if(count($exportables)): ?>


<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-10">
                <div class="d-flex align-items-center ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Filtering')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Filtering'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    
                    
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn active-style show-hide-repeater" data-query=".filtering-repeater"><?php echo e(__('Show/Hide')); ?></div>
            </div>
        </div>
        <div class="row">
            <hr style="flex:1;background-color:lightgray">
        </div>
        <div <?php $inSearchModel=false ; foreach($exportables as $exportableName=> $exportableTitle){
            if(Request()->has($exportableName)){
            $inSearchModel = true ;
            }
            }


            ?>
            <?php if(!$inSearchModel): ?>
            style="display:none"
            <?php endif; ?>
            class="row filtering-repeater">

            <div class="form-group row" style="flex:1;">
                <div class="col-md-12 mt-3">

                    <form method="get" action="<?php echo e(route('view.uploading',['company'=>$company->id,'model'=>'LabelingItem'])); ?>" class="row align-items-center">
                        <input type="hidden" name="filter_labeling" value="1">

                        <?php $__currentLoopData = $exportables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exportableName => $exportableTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						 <div class="col-md-3 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => $labelingUniqueItemsPerColumn[$exportableName]??[],'addNew' => false,'label' => $exportableTitle,'class' => 'select2-select   ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'pricing_plan_id','pleaseSelect' => 'true','id' => ''.e(Request($exportableName).'_'.'pricing_plan_id').'','selectedValue' => Request($exportableName)]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($labelingUniqueItemsPerColumn[$exportableName]??[]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($exportableTitle),'class' => 'select2-select   ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'pricing_plan_id','please-select' => 'true','id' => ''.e(Request($exportableName).'_'.'pricing_plan_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Request($exportableName))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
						
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="col-md-3" style="align-items:flex-end;display:flex;margin-left:auto">
                            <div style="margin-left:auto ">
                                <button type="submit" class="btn active-style"><?php echo e(__('Save')); ?></button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>


        </div>
    </div>
</div>

<?php endif; ?>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <?php if(session('warning')): ?>
        <div class="alert alert-warning">
            <ul>
                <li><?php echo e(session('warning')); ?></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if(count($exportables)): ?>
<?php if($modelName != 'LabelingItem'): ?>

<form action="<?php echo e(route('multipleRowsDelete', [$company, $modelName])); ?>" method="POST">
<?php endif; ?> 
    <?php echo csrf_field(); ?>
    <?php echo method_field('delete'); ?>
     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['instructionsIcon' => 1,'notPeriodClosedCustomerInvoices' => $notPeriodClosedCustomerInvoices??[],'tableTitle' => camelToTitle($modelName).' '.__(' Table') . $additionalTitle ,'tableClass' => 'kt_table_with_no_pagination ','href' => '#','importHref' => $user->can($uploadPermissionName) ? route('salesGatheringImport',['company'=>$company->id , 'model'=>$modelName]) : '#','exportHref' => $user->can($exportPermissionName) ? route('salesGathering.export',['company'=>$company->id , 'model'=>$modelName]):'#' ,'exportTableHref' => $user->can($uploadPermissionName)?route('table.fields.selection.view',[$company,$modelName,'sales_gathering']) : '#','truncateHref' => $user->can($deletePermissionName)?route('truncate',[$company,$modelName]):'#' ]); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
       
        <tr class="table-active text-center">
            <?php if($user->can($deletePermissionName)): ?>
            <th class="">

                <label style="top:-10px;right:-7px" class="kt-option d-inline-flex border-none p-0 mt-[-15px] top-[-10] position-relative">
                    <span class="kt-option__control">
                        <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                            <input class="rows" type="checkbox" id="select_all">
                            <span></span>
                        </span>
                    </span>


                </label>


            </th>
            <?php endif; ?>
            <?php if($modelName == 'LabelingItem'): ?>
            <th class="select-to-delete"><?php echo e(__('No.')); ?></th>
            <th data-css-col-name="qrcode">
                <?php if($company->labeling_type == 'qrcode'): ?>
                <?php echo e(__('QR Code')); ?>

                <?php else: ?>
                <?php echo e(__('Barcode')); ?>

                <?php endif; ?>
            </th>

            <?php endif; ?>


            <?php $__currentLoopData = $viewing_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <th <?php if($modelName == 'LabelingItem'): ?> data-css-col-name="<?php echo e($name); ?>" <?php endif; ?> ><?php echo e(__($name)); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($modelName == 'LabelingItem' && ! $hasCodeColumnForLabelingItem): ?>
			
            <th data-css-col-name="id"><?php echo e(__('ID')); ?></th>

            <?php endif; ?>
			
			 <?php if($modelName == 'LoanSchedule' ): ?>
			 	<th class="max-w-100"><?php echo e(__('Status')); ?></th>
			 	<th><?php echo e(__('Remaining')); ?></th>
			 <?php endif; ?> 

            <th><?php echo e(__('Actions')); ?></th>
        </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
        <?php $__currentLoopData = $salesGatherings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
		$serial = \App\Models\LabelingItem::generateSerial($salesGatherings,$index) ;
		?>
		
        <tr>
            <?php if($user->can($deletePermissionName)): ?>
            <td class="text-center">
                <label class="kt-option">
                    <span class="kt-option__control">
                        <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>

                            <input class="rows" type="checkbox" name="rows[]" value="<?php echo e($item->id); ?>">
                            <span></span>
                        </span>
                    </span>
                    <span class="kt-option__label">
                        <span class="kt-option__head">

                        </span>

                    </span>
                </label>
            </td>

            <?php endif; ?>

            <?php if($modelName == 'LabelingItem'): ?>
            <td>
             <?php echo e($serial); ?>

            </td>
            <td class="text-center" data-css-col-name="<?php echo e('qrcode'); ?>">
                <?php
                $generateCode = $item->getCode($serial)  ;
                ?>
                <?php if($company->labeling_type == 'barcode'): ?>

                <?php echo DNS1D::getBarcodeHTML($generateCode, 'C39',3,33 ); ?>

                <?php else: ?>
                
                <img style="max-width:120px;max-height:120px;" src="data:image/png;base64,<?php echo DNS2D::getBarcodePNG($generateCode, 'QRCODE'); ?>" alt="barcode" />

                <?php endif; ?>
            </td>

            <?php endif; ?>


            <?php $__currentLoopData = $db_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($name == 'date' || $name=='invoice_due_date' || $name == 'invoice_date'): ?>
            <td class="text-center"><?php echo e(isset($item->$name) ? date('d-M-Y',strtotime($item->$name)):  '-'); ?></td>
            <?php elseif($name == 'invoice_amount' || $name == 'vat_amount' || $name == 'withhold_amount' || $name == 'collected_amount' || $name == 'paid_amount' || $name=='net_balance'|| $name=='net_invoice_amount'): ?>
            <td class="text-center"><?php echo e(number_format($item->$name?:0 ,2 )); ?></td>
            <?php else: ?>
            <td <?php if($modelName == 'LabelingItem'): ?> data-css-col-name="<?php echo e($name??''); ?>" <?php endif; ?> class="text-center">
                <?php echo e(qrcodeSpacing($item->$name??'')); ?>



                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                <?php if($modelName == 'LabelingItem' && !$hasCodeColumnForLabelingItem): ?>
					<td data-css-col-name="<?php echo e($name??''); ?>">
						<?php echo e(qrcodeSpacing($item->getCode($serial))); ?>

					</td>
				
            <?php endif; ?>
			
				
					 <?php if($modelName == 'LoanSchedule' ): ?>
					 	<td class="text-capitalize text-wrap max-w-100">
						<?php echo e($item->getStatusFormatted()); ?>

					</td>
					 	<td class="text-center">
						<?php echo e($item->getRemainingFormatted()); ?>

					</td>
					
					
					 <?php endif; ?> 
					 

            <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
			
                <span class="d-flex justify-content-center" style="overflow: visible; position: relative; width: 110px;">
					
                    
                    <form class="kt-portlet__body" method="post" action="<?php echo e(route('salesGathering.destroy',[$company,$item->id])); ?>" style="display: inline">
					
						<?php if($modelName == 'LoanSchedule'): ?>
						<a href="<?php echo e(route('view.loan.schedule.settlements',['company'=>$company->id , 'loanSchedule'=>$item->id])); ?>" class="btn btn-secondary btn-outline-hover-primary btn-icon">
							<i class="fa fa-dollar-sign"></i>
						</a>
						<?php endif; ?> 
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>
					
                        <a class="btn btn-secondary btn-outline-hover-primary btn-icon" title="Edit" href="<?php echo e(route('edit.sales.form',['company'=>$company->id,'model'=>$modelName , 'modelId'=>$item->id])); ?>"><i class="fa fa-edit"></i></a>
                        <button type="submit" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></button>
                    </form>
                </span>
            </td>
        </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__env->endSlot(); ?>
     <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php if($modelName != 'LabelingItem'): ?>
	
</form>
<?php endif; ?>
<div class="kt-portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label d-flex justify-content-start">
            <?php echo e($salesGatherings->links()); ?>

        </div>
    </div>
</div>
<?php endif; ?>
<?php if($user->can('upload sales gathering data')): ?>
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__("Instructions")); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p class="pop-up-font">
                    <b> 1. Click on Template Download button </b>
                </p>
                <p class="pop-up-font">
                    <b> 2. Select the fields that suits your sales data structure </b>
                </p>
                <p class="pop-up-font">
                    <b> 3. Click download </b>
                </p>
                <p class="pop-up-font">
                    <b> 4. Fill your excel template </b>
                </p>
                <p class="pop-up-font">
                    <b> 5. Click Upload Data, choose your excel file then select date format finally click save </b>
                </p>
                <p class="pop-up-font">
                    <b> 6. Review your data, and then click Save Table </b>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<?php if($modelName != 'LabelingItem'): ?>
<script>
$(document).on('click', '#open-instructions', function(e) {
        e.preventDefault();
        $('#kt_modal_2').modal('show');
    })

    
    $(function() {
        $("td:not(.not-editable)").dblclick(function() {
            var OriginalContent = $(this).text();
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");
                }
            });
            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
            $(this).find('input').dblclick(function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
<?php endif; ?> 
<script>
    
	
	
	$('#select_all').change(function(e) {
        if ($(this).prop("checked")) {
            $('.rows').prop("checked", true);
        } else {
            $('.rows').prop("checked", false);
        }
    });
	








    window.addEventListener('scroll', function() {
        const top = window.scrollY > 140 ? window.scrollY + 210 : 250;

        $('.arrow-nav').css('top', top + 'px')
    })
    if ($('div.kt-portlet__body').length) {

        $('div.kt-portlet__body').append(`
								<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i>
								<i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>
								`)


        $(document).on('click', '.arrow-nav', function() {
            const scrollLeftOfTableBody = document.querySelector('.kt-portlet__body').scrollLeft
            const scrollByUnit = 500
            if (this.classList.contains('arrow-right')) {
                document.querySelector('.dataTables_scrollBody').scrollLeft += scrollByUnit

            } else {
                document.querySelector('.dataTables_scrollBody').scrollLeft -= scrollByUnit

            }
        })

        window.dispatchEvent(new Event('scroll'));

    }

</script>
<script>
    $(document).on('click', '.show-hide-repeater', function() {
        const query = this.getAttribute('data-query')
        $(query).fadeToggle(300)

    })
</script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/sales_gathering/index.blade.php ENDPATH**/ ?>