<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            <?php if($href != '#'): ?>
            <a href=<?php echo e($href); ?> class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                <i class="fas fa-<?php echo e($icon); ?>"></i>
                <?php echo e(__($firstButtonName)); ?>

            </a>
            <?php endif; ?>
            

            <?php if(isset($lastUploadFailedHref) && $lastUploadFailedHref != '#'): ?>
            <a href=<?php echo e($lastUploadFailedHref); ?> class="btn  btn-danger btn-icon-sm <?php echo e($class); ?>">
                <i class="fas fa-file-import"></i>
                <?php echo e(__('Last Upload Failed Rows')); ?>

            </a>
            <?php endif; ?>

            <?php if($truncateHref != '#'): ?>
            <?php if(count($exportables)): ?>

            <?php if(request()->has('field')): ?>
            <a href="<?php echo e(route('view.uploading',['company'=>$company->id , 'model'=>getLastSegmentInRequest()])); ?>" class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                <i class="fas fa-file-export"></i>
                <?php echo e(__('Reset Search')); ?>

            </a>
            <?php endif; ?>

            <div class="modal fade" id="search-form-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle"><?php echo e(__('Data Filter')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="js-upload-type" type="hidden" value="<?php echo e(getSegmentBeforeLast()); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row ">
                                <div class="form-group flex-1" style="margin-right:15px;">
                                    <label for="Select Field " class="label"><?php echo e(__('Filter Item')); ?></label>
                                    <select id="js-search-modal-name" class="form-control" id="Select Field " type="date" name="delete_from_date" placeholder="<?php echo e(__('Delete From')); ?>">
                                        <?php $__currentLoopData = $exportables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(Request('field')==$name): ?> selected <?php endif; ?> value="<?php echo e($name); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group flex-1" style="margin-right:15px;">
                                    <label for="Select Field " class="label"><?php echo e(__('Filter Text')); ?></label>
                                    <input id="search-text" type="text" value="<?php echo e(request('value')); ?>" placeholder="<?php echo e(__('Filter Text')); ?>" class="form-control">
                                </div>

                                <div class="form-group flex-1" style="margin-right:15px;">
                                    <label for="search-from " class="label"><?php echo e(__('From')); ?></label>
                                    <input id="search-from" type="date" value="<?php echo e(request('from')); ?>" class="form-control">

                                </div>

                                <div class="form-group flex-1" style="margin-right:15px;">
                                    <label for="search-to " class="label"><?php echo e(__('To')); ?></label>
                                    <input id="search-to" type="date" value="<?php echo e(request('to')); ?>" class="form-control">

                                </div>




                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="js-search-id" type="submit" id="" class="btn btn-primary"><?php echo e(__('Go')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>


            <a href="<?php echo e(route('create.sales.form',['company'=>$company->id , 'model'=>in_array('LoanSchedule',Request()->segments())?'LoanSchedule':getLastSegmentInRequest()])); ?>" class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                <i class="fas fa-plus"></i>
                <?php echo e(__('Create New Record')); ?>

            </a>

         

            <span class="kt-option__body p-2">
                <button type="submit" class="btn active-style btn-icon-sm">
                    <i class="fas fa-trash"></i>
                    <?php echo e(__('Delete Selected Rows')); ?>

                </button>
            </span>
            <?php if(getLastSegmentInRequest() == 'CustomerInvoice'): ?>

            <a data-toggle="modal" data-target="#close-period-modal" href="#" class="btn  active-style btn-icon-sm <?php echo e($class); ?>">
                <i class="fas fa-file-export"></i>
                <?php echo e(__('Close Period')); ?>

            </a>

            <div class="modal fade" id="close-period-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Close Period Modal')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-strip">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $notPeriodClosedCustomerInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$notPeriodClosedCustomerInvoiceArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $canNotClosePeriod = $index>0 ;
                                    ?>
                                    <tr>
                                        <td class="not-editable text-center"><?php echo e($notPeriodClosedCustomerInvoiceArr['invoice_month'] .'-'.$notPeriodClosedCustomerInvoiceArr['invoice_year']); ?></td>
                                        
                                        <td class="not-editable text-center">
                                            <form class="form ajax-store-close-period-form " data-index="<?php echo e($index); ?>" action="<?php echo e(route('store.close.period',['company'=>$company->id ])); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <?php if(!$canNotClosePeriod): ?>
                                                <input type="hidden" id="close-month-input" name="month" value="<?php echo e($notPeriodClosedCustomerInvoiceArr['invoice_month']); ?>">
                                                <input type="hidden" id="close-year-input" name="year" value="<?php echo e($notPeriodClosedCustomerInvoiceArr['invoice_year']); ?>">
                                                <?php endif; ?>
                                                <button <?php if(!$canNotClosePeriod): ?> id="close-period-btn" type="submit" <?php endif; ?> class="btn btn-primary btn-sm <?php if($canNotClosePeriod): ?> disabled <?php endif; ?> "> <?php echo e(__('Close')); ?> </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>

            <?php endif; ?>




            <div class="modal fade" id="delete_from_to_modal" tabindex="-1" role="dialog" aria-labelledby="delete_from_to_modalTitle" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle"><?php echo e(Request()->segment(4) == 'LabelingItem' ? __('Delete Data Between Serials') : __('Delete Data Between Two Dates')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="js-upload-type" type="hidden" value="<?php echo e(getSegmentBeforeLast()); ?>">
                            <div class="row ">
                                <?php if(Request()->segment(4) == 'LabelingItem'): ?>
                                <?php echo csrf_field(); ?>
                                <div class="form-group flex-1">
                                    <label for="delete_from_id" class="label"><?php echo e(__('From')); ?></label>
                                    <input id="js-delete-serial-from" class="form-control" id="delete_from_id" type="text" name="delete_from_serial" placeholder="<?php echo e(__('From Serial')); ?>">
                                </div>

                                <div class="form-group flex-1">
                                    <label for="delete_to_id" class="label"><?php echo e(__('To')); ?></label>
                                    <input id="js-delete-serial-to" class="form-control" id="delete_to_id" type="text" name="delete_to_serial" placeholder="<?php echo e(__('To Serial')); ?>">
                                </div>


                                <?php else: ?>
                                <div class="form-group flex-1" style="margin-right:15px;">
                                    <label for="delete_from_id" class="label"><?php echo e(__('From')); ?></label>
                                    <input id="js-delete-date-from" class="form-control" id="delete_from_id" type="date" name="delete_from_date" placeholder="<?php echo e(__('Delete From')); ?>">
                                </div>

                                <div class="form-group flex-1">
                                    <label for="delete_To_id" class="label"><?php echo e(__('To')); ?></label>
                                    <input id="js-delete-date-to" class="form-control" id="delete_To_id" type="date" name="delete_to_date" placeholder="<?php echo e(__('Delete To')); ?>">
                                </div>

                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="<?php echo e(Request()->segment(4) == 'LabelingItem' ? 'js-labeling-delete_from_to' :'js-delete_from_to'); ?>" type="submit" id="" class="btn btn-danger"><?php echo e(__('Delete')); ?></a>
                        </div>
                    </div>
                </div>
            </div>


            <?php if(Request()->segment(4) == 'LabelingItem'): ?>
            <div class="modal fade" id="print_report" tabindex="-1" role="dialog" aria-labelledby="delete_from_to_modalTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="print_reportTitle"><?php echo e(__('Export As PDF')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="js-upload-type" type="hidden" value="<?php echo e(getSegmentBeforeLast()); ?>">
                            <form method="post" enctype="multipart/form-data" action="<?php echo e(route('print.custom.header',['company'=>$company->id ])); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Select Field " class="label"><?php echo e(__('Headers')); ?></label>
                                            <select multiple  class="form-control select2-select" data-live-search="true" type="date" name="labeling_print_headers[]" placeholder="<?php echo e(__('Delete From')); ?>">
                                                <?php $__currentLoopData = $exportables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if(in_array($name , (array)$company->labeling_print_headers )): ?> selected <?php endif; ?> value="<?php echo e($name); ?>"><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Select Field " class="label"><?php echo e(__('Page Layout')); ?></label>
                                            <select id="js-type" class="form-control select2-select" data-live-search="true" type="date" name="print_labeling_type" placeholder="<?php echo e(__('Type')); ?>">
                                                <?php $__currentLoopData = ['landscape'=>__('LandScape') , 'portrait'=>__('Portrait') ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($company->print_labeling_type ==$type): ?> selected <?php endif; ?> value="<?php echo e($type); ?>"><?php echo e($title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Select Field " class="label"><?php echo e(__('Page Size')); ?></label>
                                            <select id="js-type" class="form-control select2-select" data-live-search="true" type="date" name="print_labeling_type" placeholder="<?php echo e(__('Type')); ?>">
                                                <?php $__currentLoopData = ['a3'=>__('A3') , 'a4'=>__('A4'),'a5'=>__('A5') ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($company->labeling_paper_size ==$type): ?> selected <?php endif; ?> value="<?php echo e($type); ?>"><?php echo e($title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.image-uploader','data' => ['required' => false,'name' => 'labeling_logo_1','id' => 'labeling_logo_1','label' => __('First Logo'),'image' => isset($company) && $company->getFirstLabelingLogo() ? $company->getFirstLabelingLogo() : getDefaultImage()]]); ?>
<?php $component->withName('form.image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_1'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_1'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('First Logo')),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($company) && $company->getFirstLabelingLogo() ? $company->getFirstLabelingLogo() : getDefaultImage())]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.image-uploader','data' => ['required' => false,'name' => 'labeling_logo_2','id' => 'labeling_logo_2','label' => __('Second Logo'),'image' => isset($company) && $company->getSecondLabelingLogo() ? $company->getSecondLabelingLogo() : getDefaultImage()]]); ?>
<?php $component->withName('form.image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_2'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_2'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Second Logo')),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($company) && $company->getSecondLabelingLogo() ? $company->getSecondLabelingLogo() : getDefaultImage())]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.image-uploader','data' => ['required' => false,'name' => 'labeling_logo_3','id' => 'labeling_logo_3','label' => __('Third Image'),'image' => isset($company) && $company->getThirdLabelingLogo() ? $company->getThirdLabelingLogo() : getDefaultImage()]]); ?>
<?php $component->withName('form.image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_3'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_logo_3'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Third Image')),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($company) && $company->getThirdLabelingLogo() ? $company->getThirdLabelingLogo() : getDefaultImage())]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.image-uploader','data' => ['required' => false,'name' => 'labeling_stamp','id' => 'labeling_stamp','label' => __('Stamp Image'),'image' => isset($company) && $company->getStampLabelingLogo() ? $company->getStampLabelingLogo() : getDefaultImage()]]); ?>
<?php $component->withName('form.image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_stamp'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('labeling_stamp'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Stamp Image')),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($company) && $company->getStampLabelingLogo() ? $company->getStampLabelingLogo() : getDefaultImage())]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button href="#" type="submit" id="" class="btn btn-primary "><?php echo e(__('Export')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>


            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('js'); ?>
<?php if(isset($company)): ?>
<script>
    $(document).on('change', '#js-search-modal-name', function() {
        const val = $(this).val();
        if (val.includes('date')) {
            $('#search-text').prop('disabled', true).val('')
        } else {
            $('#search-text').prop('disabled', false)
        }
    })
    $(document).on('click', '#js-search-id', function(e) {
        e.preventDefault();
        const field = $('#js-search-modal-name').val();
        const value = $('#search-text').val();
        const from = $('#search-from').val();
        const to = $('#search-to').val();
        const fieldIsRequired = !field.includes('date')
        if ((!value && fieldIsRequired) || !field) {
            Swal.fire({
                text: '<?php echo e(__("Please Select Field And Value")); ?>'
                , icon: 'warning'
            });
            return;
        }


        let url = "<?php echo e(route('view.uploading',['company'=>$company->id,'model'=>getLastSegmentInRequest()])); ?>"
        let appendToUrl = '?field=' + field + '&value=' + value;
        if (from) {
            appendToUrl += '&from=' + from;
        }
        if (to) {
            appendToUrl += '&to=' + to;
        }
        url = url + appendToUrl;
        window.location.href = url;
        return



    })









    $(document).on('click', '#js-delete_from_to', function(e) {
        e.preventDefault();
        const dateFrom = $('#js-delete-date-from').val();
        const dateTo = $('#js-delete-date-to').val();
        if (!dateFrom) {
            Swal.fire({
                text: '<?php echo e(__("Please Enter Date From")); ?>'
                , icon: 'warning'
            });
            return;
        }
        if (!dateTo) {
            Swal.fire({
                text: '<?php echo e(__("Please Enter Date To")); ?>'
                , icon: 'warning'
            })
            return;

        }
        if (dateFrom && dateTo) {
            const url = $('#js-upload-type').val() == 'uploading' ? "<?php echo e(route('multipleRowsDelete',['company'=>$company->id , 'model'=>getLastSegmentInRequest()])); ?>" : "<?php echo e(route('deleteMultiRowsFromCaching',['company'=>$company->id,'modelName'=>getLastSegmentInRequest()])); ?>"
            $('#js-delete_from_to').prop('disabled', true)

            $.ajax({
                url: url
                , method: "delete"
                , data: {
                    "_token": "<?php echo e(csrf_token()); ?>"
                    , "delete_date_from": dateFrom
                    , 'delete_date_to': dateTo
                    , 'rows': [1] // for validation 
                }
            }).then(function(res) {
                $('#js-delete_from_to').prop('disabled', false)

                Swal.fire({
                    text: '<?php echo e(__("Date Has Been Deleted Successfully")); ?>'
                    , icon: 'warning'
                }).then(function() {
                    window.location.reload();
                })
            });

        }
    })
    $(document).on('click', '#js-labeling-delete_from_to', function(e) {
        e.preventDefault();
        const serialFrom = $('#js-delete-serial-from').val();
        const serialTo = $('#js-delete-serial-to').val();
        if (!serialFrom) {
            Swal.fire({
                text: '<?php echo e(__("Please Enter Serial From")); ?>'
                , icon: 'warning'
            });
            return;
        }
        if (!serialTo) {
            Swal.fire({
                text: '<?php echo e(__("Please Enter Serial To")); ?>'
                , icon: 'warning'
            })
            return;

        }
        if (serialFrom && serialTo) {
            const url = $('#js-upload-type').val() == 'uploading' ? "<?php echo e(route('multipleRowsDelete',['company'=>$company->id , 'model'=>getLastSegmentInRequest()])); ?>" : "<?php echo e(route('deleteMultiRowsFromCaching',['company'=>$company->id,'modelName'=>getLastSegmentInRequest()])); ?>"
            $('#js-labeling-delete_from_to').prop('disabled', true)

            $.ajax({
                url: url
                , method: "delete"
                , data: {
                    "_token": "<?php echo e(csrf_token()); ?>"
                    , "delete_serial_from": serialFrom
                    , 'delete_serial_to': serialTo
                    , 'rows': [1] // for validation 
                }
            }).then(function(res) {
                $('#js-labeling-delete_from_to').prop('disabled', false)

                Swal.fire({
                    text: '<?php echo e(__("Date Has Been Deleted Successfully")); ?>'
                    , icon: 'warning'
                }).then(function() {
                    window.location.reload();
                })
            });

        }
    })








    $(document).on('click', '#close-period-btn', function(e) {
        e.preventDefault();
        $(this).attr('disabled', true);
        const month = $(document).find('#close-month-input').val();
        const year = $(document).find('#close-year-input').val();
        const form = $(document).find('#search-from').val();
        const url = "<?php echo e(route('store.close.period',['company'=>$company->id ])); ?>";

        $.ajax({
            url: url
            , data: {
                "_token": "<?php echo e(csrf_token()); ?>"
                , month
                , year
            }
            , method: "post"
            , success: function(res) {
                Swal.fire({
                    text: 'Done'
                    , icon: 'success'
                    , timer: 1200
                }).then(res => {
                    window.location.reload();
                })
            }
            , error: function(res) {
                Swal.fire({
                    text: 'Error Happend Please Try Again'
                    , icon: 'error'
                }).then(res => {
                    window.location.reload();
                })
            }
            , complete: function(res) {
                $('#close-period-btn').attr('disabled', false)
            }

        })
    })

</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/export.blade.php ENDPATH**/ ?>