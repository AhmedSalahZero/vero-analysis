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
    <form action="<?php echo e(route('allocations', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>

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
                            <?php $allocations_setting = isset($allocations_setting) ? $allocations_setting : old(); ?>
                            <div class="kt-portlet__body">
                                <!--begin: Datatable -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?php echo e(__('Select Allocation Base')); ?> <span
                                                class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date validated">
                                                <select name="allocation_base" class="form-control" id="allocation_base">
                                                    <option value="" disabled selected><?php echo e(__('Select')); ?></option>
                                                    <option value="branch"
                                                        <?php echo e(@$allocations_setting['allocation_base'] !== 'branch' ?: 'selected'); ?>>
                                                        <?php echo e(__('Branches')); ?></option>
                                                    <option value="business_sector"
                                                        <?php echo e(@$allocations_setting['allocation_base'] !== 'business_sector' ?: 'selected'); ?>>
                                                        <?php echo e(__('Business Sectors')); ?></option>
                                                    <option value="sales_channel"
                                                        <?php echo e(@$allocations_setting['allocation_base'] !== 'sales_channel' ?: 'selected'); ?>>
                                                        <?php echo e(__('Sales Channels')); ?></option>
                                                    <option value="zone"
                                                        <?php echo e(@$allocations_setting['allocation_base'] !== 'zone' ?: 'selected'); ?>>
                                                        <?php echo e(__('Zones')); ?></option>
                                                </select>
                                                <?php if($errors->has('allocation_base')): ?>
                                                    <div class="invalid-feedback"><?php echo e($errors->first('allocation_base')); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  form-group-marginless">
                                            <label><?php echo e(__('Select Sales Breakdown %')); ?> <span
                                                    class="required">*</span></label>
                                            <div class="kt-input-icon">
                                                <div class="input-group date validated">
                                                    <select name="breakdown" class="form-control" id="breakdown">
                                                        <option value="" disabled selected><?php echo e(__('Select')); ?></option>
                                                        <option value="previous_year"
                                                            <?php echo e(@$allocations_setting['breakdown'] !== 'previous_year' ?: 'selected'); ?>>
                                                            <?php echo e(__('Pervious Year Breakdown / New Breakdown')); ?></option>
                                                        <option value="last_3_years"
                                                            <?php echo e(@$allocations_setting['breakdown'] !== 'last_3_years' ?: 'selected'); ?>>
                                                            <?php echo e(__('Last 3 Years Average Breakdown')); ?></option>
                                                        
                                                        
                                                    </select>
                                                    <?php if($errors->has('breakdown')): ?>
                                                        <div class="invalid-feedback"><?php echo e($errors->first('breakdown')); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"
                                        style="display: <?php echo e(@$allocations_setting['new_start'] == 'previous_year' || @$allocations_setting['new_start'] == 'previous_3_years'? 'block': 'none'); ?>"
                                        id="new_start_field">
                                        <div class="form-group  form-group-marginless">
                                            <label>New Start</label>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="kt-option">
                                                            <span class="kt-option__control">
                                                                <span
                                                                    class="kt-radio kt-radio--bold kt-radio--brand kt-radio--check-bold"
                                                                    checked>
                                                                    <input type="radio" name="new_start"
                                                                        value="annual_target"
                                                                        <?php echo e(@$section_row['new_start'] == 'annual_target' ? 'checked' : ''); ?>>
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                            <span class="kt-option__label">
                                                                <span class="kt-option__head">
                                                                    <span class="kt-option__title">
                                                                        <?php echo e(__('Annual Target')); ?>

                                                                    </span>

                                                                </span>
                                                                <span class="kt-option__body">
                                                                    
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="kt-option">
                                                            <span class="kt-option__control">
                                                                <span class="kt-radio kt-radio--bold kt-radio--brand">
                                                                    <input type="radio" name="new_start"
                                                                        value="product_target"
                                                                        <?php echo e(@$section_row['new_start'] == 'product_target' ? 'checked' : ''); ?>>
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                            <span class="kt-option__label">
                                                                <span class="kt-option__head">
                                                                    <span class="kt-option__title">
                                                                        <?php echo e(__('Prodcuts Targets')); ?>

                                                                    </span>

                                                                </span>
                                                                <span class="kt-option__body">
                                                                    
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-6 validated">
                                        <label class="kt-option bg-secondary">
                                            <span class="kt-option__control">
                                                <span
                                                    class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                    checked>
                                                    <input class="rows" name="add_new_items" type="checkbox"
                                                        value="1" readonly
                                                        <?php echo e(@$allocations_setting['add_new_items'] == 0 ?: 'checked'); ?>

                                                        id="add_new_items">

                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="kt-option__label d-flex">
                                                <span class="kt-option__head mr-auto p-2">
                                                    <span class="kt-option__title">
                                                        <b>
                                                            <?php echo e(__('Add New')); ?> <span id="item_type"></span>
                                                        </b>
                                                    </span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-6"
                                        style="display:<?php echo e(@$allocations_setting['add_new_items'] == 1 ? 'block' : 'none'); ?>"
                                        id="number_of_items">
                                        <label><?php echo e(__('How Many ? ')); ?> <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group validated">
                                                <input type="number" step="any" class="form-control"
                                                    name="number_of_items" value="<?php echo e(@$allocations_setting['number_of_items']); ?>"
                                                    id="number_of_items">
                                                <?php if($errors->has('number_of_items')): ?>
                                                    <div class="invalid-feedback"><?php echo e($errors->first('number_of_items')); ?></div>
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
    <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $quarter_name = str_replace(' ', '_', $quarter_name); ?>
        <script>
            $('.modify_sales_target_'+'<?php echo e($quarter_name); ?>').on('change', function() {
                var index = $('.modify_sales_target_'+'<?php echo e($quarter_name); ?>').index(this);
                var modify_sales_target = parseFloat($(this).val());

                var percentage = (modify_sales_target / parseFloat("<?php echo e($value); ?>")) * 100;
                $('.modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>').eq(index).val(percentage.toFixed(2));
                totalFunction('.modify_sales_target_'+'<?php echo e($quarter_name); ?>', '#total_modify_sales_target_'+'<?php echo e($quarter_name); ?>', 0);
                totalFunction('.modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>', '#total_modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>', 2);
            });


            $('.modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>').on('change', function() {
                var index = $('.modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>').index(this);
                var modify_sales_target_percentage = parseFloat($(this).val()) / 100;
                var value = (modify_sales_target_percentage * parseFloat("<?php echo e($value); ?>"));
                $('.modify_sales_target_'+'<?php echo e($quarter_name); ?>').eq(index).val(value.toFixed(0));
                totalFunction('.modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>', '#total_modify_sales_target_percentage_'+'<?php echo e($quarter_name); ?>', 2);
                totalFunction('.modify_sales_target_'+'<?php echo e($quarter_name); ?>', '#total_modify_sales_target_'+'<?php echo e($quarter_name); ?>', 0);

            });
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
        $('#allocation_base').on('change', function() {
            val = $(this).find('option:selected').text();
            $('#add_new_items').attr('readonly', false);

            $('#item_type').html(' ' + $.trim(val));
        });


        $('#add_new_items').change(function () {
            if ($(this).prop("checked")) {
                $('#number_of_items').fadeIn(300);
            } else {
                $('#number_of_items').fadeOut(300);
            }

        });

        $('.modify_sales_target').on('change', function () {
            var index = $('.modify_sales_target').index(this);
            var modify_sales_target = parseFloat($(this).val());
            var percentage = (modify_sales_target/parseFloat("<?php echo e($sales_forecast->sales_target??0); ?>"))*100;
            $('.modify_sales_target_percentage').eq(index).val(percentage.toFixed(2));
            totalFunction('.modify_sales_target','#total_modify_sales_target',0);
            totalFunction('.modify_sales_target_percentage','#total_modify_sales_target_percentage',2);
        });
        $('.modify_sales_target_percentage').on('change', function () {
            var index = $('.modify_sales_target_percentage').index(this);
            var modify_sales_target_percentage = parseFloat($(this).val()) /100;
            var value = (modify_sales_target_percentage*parseFloat("<?php echo e($sales_forecast->sales_target??0); ?>")) ;
            $('.modify_sales_target').eq(index).val(value.toFixed(0));
            totalFunction('.modify_sales_target_percentage','#total_modify_sales_target_percentage',2);
            totalFunction('.modify_sales_target','#total_modify_sales_target',0);

        });



        function totalFunction(field_name, total_field_name, decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '') {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).html(total.toFixed(decimals));
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/allocations.blade.php ENDPATH**/ ?>