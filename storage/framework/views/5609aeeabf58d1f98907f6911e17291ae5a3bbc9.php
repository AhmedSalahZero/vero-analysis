<?php $__env->startSection('css'); ?>
    <style>
        table {
            white-space: nowrap;
            
        }
    
#kt_header{
    /* display:none; */
}
.kt_table_with_no_pagination {
    /* top:63px !important ; */
}






    </style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
<style>
    table.dataTable thead tr > .dtfc-fixed-left, table.dataTable thead tr > .dtfc-fixed-right{
        background-color:#086691;
    }
    thead *{
        text-align:center !important;
    }
</style>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    Sales Section
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
    <form action="<?php echo e(route('multipleRowsDelete', [$company, 'SalesGathering'])); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Sales Table'),'tableClass' => 'kt_table_with_no_pagination','href' => '#','importHref' => route('salesGatheringImport',$company),'exportHref' => route('salesGathering.export',$company),'exportTableHref' => route('table.fields.selection.view',[$company,'SalesGathering','sales_gathering']),'truncateHref' => route('truncate',[$company,'SalesGathering'])]); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php $__env->slot('table_header'); ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <label class="kt-option bg-secondary">
                                <span class="kt-option__control">
                                    <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                        checked>
                                        <input class="rows" type="checkbox" id="select_all">
                                        <span></span>
                                    </span>
                                </span>
                                <span class="kt-option__label d-flex">
                                    <span class="kt-option__head mr-auto p-2">
                                        <span class="kt-option__title">
                                            <b>
                                                <?php echo e(__('Select All')); ?>

                                            </b>
                                        </span>

                                    </span>
                                    <span class="kt-option__body p-2">
                                        <button type="submit" class="btn active-style btn-icon-sm">
                                            <i class="fas fa-trash-alt"></i>
                                            <?php echo e(__('Delete Selected Rows')); ?>

                                        </button>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <tr class="table-active text-center">
                    <th><?php echo e(__("Select To Delete")); ?> </th>
                    <?php $__currentLoopData = $viewing_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e(__($name)); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__('Actions')); ?></th>
                </tr>
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('table_body'); ?>
                <?php $__currentLoopData = $salesGatherings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center">
                            <label class="kt-option">
                                <span class="kt-option__control">
                                    <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                        checked>
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
                        <?php $__currentLoopData = $db_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($name == 'date'): ?>
                                <td class="text-center"><?php echo e(isset($item->$name) ? date('d-M-Y',strtotime($item->$name)):  '-'); ?></td>
                            <?php else: ?>
                                <td class="text-center"><?php echo e($item->$name ?? '-'); ?></td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                            <span class="d-flex justify-content-center" style="overflow: visible; position: relative; width: 110px;">
                                
                                <form method="post"   action="<?php echo e(route('salesGathering.destroy',[$company,$item->id])); ?>" style="display: inline">
                                    <?php echo method_field('DELETE'); ?>
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></button>
                                </form>
                                
                            </span>
                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
    </form>
    <div class="kt-portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label d-flex justify-content-start">
                <?php echo e($salesGatherings->links()); ?>

            </div>
        </div>
    </div>
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
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
    <script>
        $(document).ready(function(){ $('#kt_modal_2').modal('show'); });
        $('#select_all').change(function(e) {
            if ($(this).prop("checked")) {
                $('.rows').prop("checked", true);
            } else {
                $('.rows').prop("checked", false);
            }
        });
        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                $(this).addClass("cellEditing");
                $(this).html("<input type='text' value='" + OriginalContent + "' />");
                $(this).children().first().focus();
                $(this).children().first().keypress(function (e) {
                    if (e.which == 13) {
                        var newContent = $(this).val();
                        $(this).parent().text(newContent);
                        $(this).parent().removeClass("cellEditing");
                    }
                });
            $(this).children().first().blur(function(){
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
                $(this).find('input').dblclick(function(e){
                    e.stopPropagation();
                });
            });
        });
    </script>

  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/sales_gathering/index.blade.php ENDPATH**/ ?>