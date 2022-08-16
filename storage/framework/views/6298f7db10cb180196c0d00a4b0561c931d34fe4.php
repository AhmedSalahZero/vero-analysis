<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
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
<?php $__env->startSection('sub-header'); ?>
    Inventory Statment Section
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
    <form action="<?php echo e(route('multipleRowsDelete', [$company, 'InventoryStatement'])); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Inventory Statements Table'),'tableClass' => 'kt_table_with_no_pagination editableTable','href' => '#','importHref' => route('inventoryStatementImport',$company),'exportHref' => route('inventoryStatement.export',$company),'exportTableHref' => route('table.fields.selection.view',[$company,'InventoryStatement','inventory_statement']),'truncateHref' => route('truncate',[$company,'InventoryStatement'])]); ?>
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
                <?php $__currentLoopData = $inventoryStatements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <td class="text-center">
                                    <?php echo e(isset($item->$name) ? date('d-M-Y', strtotime($item->$name)) : '-'); ?></td>
                            <?php else: ?>
                                <td class="text-center"><?php echo e($item->$name ?? '-'); ?></td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                            data-autohide-disabled="false">
                            <span class="d-flex justify-content-center"
                                style="overflow: visible; position: relative; width: 110px;">
                                
                                <form method="post" action="<?php echo e(route('inventoryStatement.destroy', [$company, $item->id])); ?>"
                                    style="display: inline">
                                    <?php echo method_field('DELETE'); ?>
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-secondary btn-outline-hover-danger btn-icon"
                                        title="Delete" href=""><i class="fa fa-trash-alt"></i></button>
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
                <?php echo e($inventoryStatements->links()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script>

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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/inventory_statement/index.blade.php ENDPATH**/ ?>