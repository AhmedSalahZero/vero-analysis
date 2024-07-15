
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />
<?php
$redirectUrl = $modelName == 'LabelingItem' ? route('view.uploading',['company'=>getCurrentCompanyId(),'model'=> $modelName ]) : route('dashboard',getCurrentCompanyId()) ;
if($modelName == 'CustomerInvoice'){
	$redirectUrl = route('view.balances',['company'=>$company->id,'modelType'=>'CustomerInvoice']);
}
elseif($modelName == 'SupplierInvoice'){
	$redirectUrl = route('view.balances',['company'=>$company->id,'modelType'=>'SupplierInvoice']);
}




?> 
<style>
.mx-auto{
	margin-left:auto;
	margin-right:auto;
}
    .table-bordered.table-hover.table-checkable.dataTable.no-footer.fixedHeader-floating {
        display: none
    }

    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>
<style>
    table {
        white-space: nowrap;
    }

    .bg-table-head {
        background-color: #075d96;
        color: white !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(camelToTitle($modelName)); ?>

                    </h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action=<?php echo e(route('salesGatheringImport', ['company'=>$company->id , 'model'=>$modelName])); ?> enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(camelToTitle($modelName) . ' ' . __('Import')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo e(__('Import File')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input required type="file" name="excel_file" class="form-control" placeholder="<?php echo e(__('Import File')); ?>">
                                     <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Vero Analysis')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </div>
                            </div>
                        </div>
                        <?php if($modelName != 'LabelingItem'): ?>

                        <div class="col-md-6">
                            <label><?php echo e(__('Date Formatting')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <select name="format" class="form-control" required>
                                    <option value=""><?php echo e(__('Select')); ?></option>
                                    <option value="d-m-Y"><?php echo e(__('Day-Month-Year')); ?> eg [ 15-01-2024]</option>
									  <option value="d-M-Y" ><?php echo e(__('Day-Month-Year')); ?> eg [ 15-Jan-2024]</option>
                                    <option value="m-d-Y"><?php echo e(__('Month-Day-Year')); ?> eg [ 05-15-2024] </option>
                                    <option value="Y-m-d"><?php echo e(__('Year-Month-Day')); ?> eg [2024-05-15] </option>
                                    <option value="Y-d-m"><?php echo e(__('Year-Day-Month')); ?> eg [2024-15-05] </option>
                                </select>
                                 <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Vero Analysis')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php $active_job = App\Models\ActiveJob::where('company_id', $company->id)
                            ->where('status', 'test_table')
                            ->where('model_name', 'SalesGatheringTest')
							->where('model',$modelName)
                            ->first(); ?>
                    <?php $active_job_for_saving = App\Models\ActiveJob::where('company_id', $company->id)
                    ->where('status', 'save_to_table')
                    ->where('model_name', 'SalesGatheringTest')
                    ->where('model',$modelName)
                    ->first(); ?>
                    <?php
                    use Illuminate\Support\Facades\Cache;
                    $canViewPleaseReviewMessage = !hasFailedRow($company->id,$modelName)&&hasCachingCompany($company->id,$modelName) && ! $active_job_for_saving && Cache::get(getShowCompletedTestMessageCacheKey($company->id,$modelName)) && ! (bool)Cache::get(getCanReloadUploadPageCachingForCompany($company->id,$modelName) );
                    ?>
                    <?php if($canViewPleaseReviewMessage): ?>
                    <h4 id="please-review-and-click-save" class="text-center alert alert-info " style="text-transform:capitalize;justify-content:center"><?php echo e(__('Please review And Click Save')); ?></h4>
                    <?php endif; ?>
                    <?php if($active_job): ?>
                    <div class="kt-section__content uploading_div">
                        <label class="text-success text-xl-center"> <b> <?php echo e(__('Uploading')); ?></b> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated  bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

             <?php if (isset($component)) { $__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\CustomButtonNameToSubmit::class, ['displayName' => __('Upload')]); ?>
<?php $component->withName('custom-button-name-to-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6)): ?>
<?php $component = $__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6; ?>
<?php unset($__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

        </form>

        
   

        

        <!--end::Form-->
        <form action="<?php echo e(route('deleteMultiRowsFromCaching', ['company'=>$company , 'modelName'=>$modelName])); ?>" method="POST" encrypt="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['notPeriodClosedCustomerInvoices' => $notPeriodClosedCustomerInvoices??[],'lastUploadFailedHref' => hasFailedRow($company->id,$modelName)?route('last.upload.failed',['company'=>$company->id , 'model'=>$modelName]):'#','tableTitle' => __(capitializeType($modelName). ' ' . 'Table'),'href' => route('salesGatheringTest.insertToMainTable',['company'=>$company->id , 'modelName'=>$modelName]),'icon' => __('file-import'),'firstButtonName' => __('Save Data'),'tableClass' => 'kt_table_with_no_pagination','truncateHref' => route('deleteAllCaches',[$company,$modelName])]); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

                <?php $__env->slot('table_header'); ?>

                <?php if($active_job_for_saving): ?>
                <div class="row uploading_div_for_saving_data mb-5">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="kt-section__content text-center ">
                            <label id="saving_data" class="text-success text-xl-center"> <b> <?php echo e(__('Saving Data')); ?></b> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="progress ">
                                <div id="progress_id" class="progress-bar progress-bar-striped progress-bar-animated  bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>


                            </div>
                            <span id="percentage_value" style="display: block;margin-top:10px;font-size:1.5rem;color:#1dc9b7 !important;font-weight:bold;"> 0 % </span>
                        </div>
                    </div>
                </div>

                <br>
                <?php endif; ?>

                <tr class="table-active text-center">	
                    <th class="select-to-delete">Select To Delete </th>
					
                    <?php $__currentLoopData = $viewing_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($name)); ?></th>
					
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					
                    <th><?php echo e(__('Actions')); ?></th>
                </tr>
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('table_body'); ?>
                <?php $__currentLoopData = $salesGatherings->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                
                <tr>
                    <td class="text-center">
                        <label class="kt-option">
                            <span class="kt-option__control">
                                <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                    <input class="rows" type="checkbox" name="rows[]" value="<?php echo e($item['id'] ?? 0); ?>">
                                    <span></span>
                                </span>
                            </span>
                            <span class="kt-option__label">
                                <span class="kt-option__head">

                                </span>

                            </span>
                        </label>
                    </td>
	
                    <?php $__currentLoopData = $db_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($name == 'date'): ?>
                    <td class="text-center">
                        <?php echo e(isset($item[$name]) ? date('d-M-Y', strtotime($item[$name])) : '-'); ?></td>
                    <?php else: ?>
				
                    <td class="text-center"><?php echo e($item[$name] ?? '-'); ?></td>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					
					

                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                        <span class="d-flex justify-content-center" style="overflow: visible; position: relative; width: 110px;">
                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" ><i class="fa fa-pen-alt"></i></a>
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
        </form>
        <!--end::Portlet-->
    </div>
    <div class="kt-portlet text-center">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label d-flex justify-content-start">
                <?php echo e($salesGatherings->appends(Request::except('page'))->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>
<?php if($active_job_for_saving): ?>
<script>
    setInterval(() => {
        if (!$('#please-review-and-click-save').length) {
            $('.kt-portlet__head-actions > a').each((index, a) => {
                $(a).addClass('disabled');
            })
        } else {
            $('.kt-portlet__head-actions > a').each((index, a) => {
                $(a).removeClass('disabled');
            })
        }
    }, 1000);

</script>
<?php endif; ?>
<?php if($active_job): ?>
<script>
    var row = '1';
    $(document).ready(function() {

        setInterval(function() {

            $.ajax({
                type: 'GET'
                , data: {
                    'id': "<?php echo e($active_job->id); ?>"
                }
                , url: "<?php echo e(route('active.job', ['modelName'=>$modelName , 'company'=>$company->id])); ?>"
                , dataType: 'json'
                , accepts: 'application/json'
            }).done(function(data) {

                if (data == '0' && row == '1') {
                    $('.uploading_div').fadeOut(300);
                    location.reload();
                }
                row = data;
            });
        }, 3000);

    });

</script>
<?php endif; ?>


<?php if($active_job_for_saving ): ?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                type: 'post'
                , url: "/get-uploading-percentage/" + "<?php echo e($company->id); ?>" + "/" + "<?php echo e($modelName); ?>"
                , data: {
                    '_token': "<?php echo e(csrf_token()); ?>"
                , },

                success: function(data) {
                    $('#progress_id').css('width', (data.totalPercentage) + '%');
                    $('#percentage_value').html(data.totalPercentage.toFixed(2) + ' %');
                    if (parseFloat(data.totalPercentage) >= 100 || data.reloadPage) {
                        $('#saving_data').html("<?php echo e(__('Parsing Data .. Please Wait')); ?>");
                        const company_id = "<?php echo e($company->id); ?>"
                        Swal.fire({
                            position: 'center'
                            , icon: 'success'
                            , title: '<?php echo e(__("Uploading Proccess Has Completed Successfully !")); ?>'
                            , showConfirmButton: false
                            , timer: 1500
                        }).then(function() {
                            window.location.href = "<?php echo e($redirectUrl); ?>"

                        })



                    }
                    if (data.reloadPage) {
                        // window.location.reload();
                    }
                }
                , error: function(reject) {}
            });
        }, 5000)
    })

</script>
<?php endif; ?>
<?php if(hasFailedRow($company->id,$modelName)): ?>
<script>
    Swal.fire({
        title: "<?php echo e(__('Last Upload Failed ! .. Please Review Last Upload Failed Rows Below')); ?>"
        , icon: 'error'
    })

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
    $(function() {
        $("td").dblclick(function() {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/client_view/sales_gathering/import.blade.php ENDPATH**/ ?>