<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet"
        type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('collection.settings', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php $collection_settings = isset($collection_settings) ? $collection_settings : old(); ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Annual Target Year ') .date('Y', strtotime($sales_forecast->start_date)) .' : ' .number_format($sales_forecast->sales_target)); ?>

                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="kt-portlet kt-portlet--mobile">

                            <div class="kt-portlet__body">
                                <!--begin: Datatable -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?php echo e(__('Select Collection Base')); ?> <span
                                                class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date validated">
                                                <select name="collection_base" class="form-control" id="collection_base">
                                                    <option value="" disabled selected><?php echo e(__('Select')); ?></option>
                                                    <option id="general_collection_policy" value="general_collection_policy"
                                                        <?php echo e(@$collection_settings['collection_base'] !== 'general_collection_policy' ?: 'selected'); ?>>
                                                        <?php echo e(__('General Collection Policy')); ?></option>
                                                    <?php if(isset($first_allocation_setting_base)): ?>

                                                        <option id="first_allocation_setting_base"
                                                            value="<?php echo e($first_allocation_setting_base); ?>"
                                                            <?php echo e(@$collection_settings['collection_base'] !== $first_allocation_setting_base ?: 'selected'); ?>>
                                                            <?php echo e(__(ucwords(str_replace('_', ' ', $first_allocation_setting_base)))); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                    <?php if(isset($second_allocation_setting_base)): ?>

                                                        <option id="second_allocation_setting_base"
                                                            value="<?php echo e($second_allocation_setting_base); ?>"
                                                            <?php echo e(@$collection_settings['collection_base'] !== $second_allocation_setting_base ?: 'selected'); ?>>
                                                            <?php echo e(__(ucwords(str_replace('_', ' ', $second_allocation_setting_base)))); ?>

                                                        </option>
                                                    <?php endif; ?>

                                                </select>
                                                <?php if($errors->has('seasonality')): ?>
                                                    <div class="invalid-feedback"><?php echo e($errors->first('seasonality')); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="kt-portlet" id="general_collection_policy_view"
            style="display:<?php echo e(@$collection_settings['collection_base'] == 'general_collection_policy' ? 'block' : 'none'); ?>">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('General Collection Policy')); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <?php if($errors->has('general_collection_rates_total')): ?>
                    <h4 style="color: red"><i class="fa fa-hand-point-right">
                        </i></i><?php echo e($errors->first('general_collection_rates_total')); ?></h4>
                <?php endif; ?>

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__body">
                        <?php if($errors->has('total_rate.general_collection_policy')): ?>
                            <h3 style="color: red"><i class="fa fa-hand-point-right">
                                </i></i><?php echo e($errors->first('total_rate.general_collection_policy')); ?></h3>
                        <?php endif; ?>
                        <div class="row">
                            
                            <div class="col-md-3">
                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[a][rate]"
                                            value="<?php echo e(@$collection_settings['general_collection']['a']['rate']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[a][due_days]"
                                            value="<?php echo e(@$collection_settings['general_collection']['a']['due_days']); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[b][rate]"
                                            value="<?php echo e(@$collection_settings['general_collection']['b']['rate']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[b][due_days]"
                                            value="<?php echo e(@$collection_settings['general_collection']['b']['due_days']); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-3">
                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[c][rate]"
                                            value="<?php echo e(@$collection_settings['general_collection']['c']['rate']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[c][due_days]"
                                            value="<?php echo e(@$collection_settings['general_collection']['c']['due_days']); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[d][rate]"
                                            value="<?php echo e(@$collection_settings['general_collection']['d']['rate']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control"
                                            name="general_collection[d][due_days]"
                                            value="<?php echo e(@$collection_settings['general_collection']['d']['due_days']); ?>">
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="kt-portlet" id="first_allocation_setting_base_view"
            style="display:<?php echo e(@$collection_settings['collection_base'] == $first_allocation_setting_base ? 'block' : 'none'); ?>">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__(ucwords(str_replace('_', ' ', $first_allocation_setting_base))) . ' Collection Policy'); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-portlet kt-portlet--mobile">

                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__(ucwords(str_replace('_', ' ', $first_allocation_setting_base)))); ?></th>
                                <th> <?php echo e(__('Collection A')); ?> </th>
                                <th> <?php echo e(__('Collection B')); ?> </th>
                                <th> <?php echo e(__('Collection C')); ?> </th>
                                <th> <?php echo e(__('Collection D')); ?> </th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $__currentLoopData = $first_allocation_base_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td>
                                        <b><?php echo e($base_name); ?></b>
                                        <?php if($errors->has('total_rate.' . $base_name)): ?>
                                            <h5 style="color: red"><i class="fa fa-hand-point-right">
                                                </i></i><?php echo e($errors->first('total_rate.' . $base_name)); ?></h5>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][a][rate]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['a']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][a][due_days]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['a']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][b][rate]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['b']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][b][due_days]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['b']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][c][rate]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['c']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][c][due_days]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['c']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][d][rate]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['d']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="first_allocation_collection[<?php echo e($base_name); ?>][d][due_days]"
                                                            value="<?php echo e(@$collection_settings['first_allocation_collection'][$base_name]['d']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

                </div>
            </div>
        </div>

        
        <div class="kt-portlet" id="second_allocation_setting_base_view"
            style="display:<?php echo e(@$collection_settings['collection_base'] == $second_allocation_setting_base ? 'block' : 'none'); ?>">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__(ucwords(str_replace('_', ' ', $second_allocation_setting_base))) . ' Collection Policy'); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-portlet kt-portlet--mobile">

                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__(ucwords(str_replace('_', ' ', $second_allocation_setting_base)))); ?></th>
                                <th> <?php echo e(__('Collection A')); ?> </th>
                                <th> <?php echo e(__('Collection B')); ?> </th>
                                <th> <?php echo e(__('Collection C')); ?> </th>
                                <th> <?php echo e(__('Collection D')); ?> </th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $__currentLoopData = $second_allocation_base_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td>
                                        <b><?php echo e($base_name); ?></b>
                                        <?php if($errors->has('total_rate.' . $base_name)): ?>
                                            <h5 style="color: red"><i class="fa fa-hand-point-right">
                                                </i></i><?php echo e($errors->first('total_rate.' . $base_name)); ?></h5>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][a][rate]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['a']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][a][due_days]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['a']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][b][rate]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['b']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][b][due_days]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['b']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][c][rate]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['c']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][c][due_days]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['c']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Rate %')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][d][rate]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['d']['rate']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo e(__('Due Days')); ?> <span class="required">*</span></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="number" step="any" class="form-control"
                                                            name="second_allocation_collection[<?php echo e($base_name); ?>][d][due_days]"
                                                            value="<?php echo e(@$collection_settings['second_allocation_collection'][$base_name]['d']['due_days']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

                </div>
            </div>
        </div>

        <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"
        type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>"
        type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
    </script>

    <script>
        $('#collection_base').on('change', function() {
            id = $(this).children(":selected").attr("id");
            if (id == "general_collection_policy") {
                $('#general_collection_policy_view').fadeIn(300);
                $('#first_allocation_setting_base_view').fadeOut(300);
                $('#second_allocation_setting_base_view').fadeOut(300);
            } else if (id == "first_allocation_setting_base") {
                $('#first_allocation_setting_base_view').fadeIn(300);
                $('#general_collection_policy_view').fadeOut(300);
                $('#second_allocation_setting_base_view').fadeOut(300);
            } else if (id == "second_allocation_setting_base") {
                $('#second_allocation_setting_base_view').fadeIn(300);
                $('#first_allocation_setting_base_view').fadeOut(300);
                $('#general_collection_policy_view').fadeOut(300);
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/collection_settings.blade.php ENDPATH**/ ?>