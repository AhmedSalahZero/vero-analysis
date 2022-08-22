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
    <form action="<?php echo e(route('products.seasonality', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Forecast')); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <h2><?php echo e(__('Sales Annual Target Year ' )  . date('Y',strtotime($sales_forecast->start_date)) .' : '. number_format($sales_forecast->sales_target)); ?></h2>
                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Product Items Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__('Product '.($has_product_item == true ? 'Item' : '').' Name')); ?></th>
                            <?php if($has_product_item == true): ?>
                                <th><?php echo e(__('Choose Product / Service')); ?></th>
                            <?php endif; ?>
                            <th><?php echo e(__('Choose Category')); ?></th>
                            <th><?php echo e(__('Sales Target Value')); ?></th>
                            <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                <th><?php echo e(__('Sales Target %')); ?></th>
                            <?php endif; ?>

                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>

                        <?php $key=0; $product_seasonality = count($product_seasonality)>0 ? $product_seasonality : old() ;?>
                        <?php for($number = 1; $number <= $sales_forecast->number_of_products; $number++): ?>
                            <tr>

                                <td class="text-center">
                                    <div class="input-group date validated">
                                        <input type="text" name="product_items_name[<?php echo e($key); ?>]" placeholder="<?php echo e(__("Insert Name")); ?>" class="product_items_name form-control" value="<?php echo e($product_seasonality[$key]->name ?? (old('product_items_name')[$key]??'')); ?>">
                                        <?php if($errors->has("product_items_name.".$key)): ?>
                                            <div class="invalid-feedback"><?php echo e($errors->first("product_items_name.".$key)); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php if($has_product_item == true): ?>
                                    <?php $product_id = ($product_seasonality[$key]->product_id)??(old('products')[$key]??''); ?>
                                    <td class="text-center">
                                        <div class="kt-input-icon">
                                            <div class="input-group date validated">
                                                <select name="products[]" class="form-control products" >
                                                    <option value=""  ><?php echo e(__('Select')); ?></option>
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($product->category): ?>
                                                        <option value="<?php echo e($product->id); ?>" 
                                                        data-name="<?php echo e($product->category->name); ?>" data-id="<?php echo e($product->category->id); ?>"
                                                         <?php echo e(( $product_id != $product->id ) ?'': "selected"); ?> ><?php echo e($product->name); ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>
                                                <?php if($errors->has("products.".$key)): ?>
                                                    <div class="invalid-feedback"><?php echo e($errors->first("products.".$key)); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <div class="kt-input-icon">
                                        <?php if($has_product_item == true): ?>
                                            <?php $category = isset($product_seasonality[$key]->category_id) ?  App\Models\Category::find($product_seasonality[$key]->category_id) : null?>
                                            <div class="input-group date">
                                                <select name="categories[]" readonly class="form-control categories" required>
                                                    <?php if($category !== null): ?>
                                                        <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        <?php else: ?>
                                            <?php $categories =  App\Models\Category::where('company_id',$company->id)->get(); ?>
                                            <div class="input-group date">
                                                <select name="categories[]" readonly class="form-control categories" required>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>" <?php echo e(@$product_seasonality[$key]->category_id !== $category->id ?:'selected'); ?>><?php echo e($category->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group date validated">
                                        
                                        <input type="number" name="sales_target_value[]"  placeholder="<?php echo e(__('Sales Target Value')); ?>" class="sales_target_value form-control" >
                                        <?php if($errors->has("sales_target_value.".$key)): ?>
                                            <div class="invalid-feedback"><?php echo e($errors->first("sales_target_value.".$key)); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                    <td class="text-center">
                                        <div class="input-group date validated">
                                            <input type="number" step="any" name="sales_target_percentage[]" placeholder="<?php echo e(__('Sales Target %')); ?>" class="sales_target_percentage form-control" value="<?php echo e(($product_seasonality[$key]->sales_target_percentage ?? (old('sales_target_percentage')[$key]??''))); ?>">
                                            <?php if($errors->has("sales_target_percentage.".$key)): ?>
                                                <div class="invalid-feedback"><?php echo e($errors->first("sales_target_percentage.".$key)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php $key++; ?>
                        <?php endfor; ?>
                    <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
            </div>
        </div>


        <?php $key = 0;?>
        
        <?php for($number = 1; $number <= $sales_forecast->number_of_products; $number++): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--mobile">

                        <div class="kt-portlet__body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group  form-group-marginless">
                                        <label style="font-size: 1.7rem"><?php echo e(__('Seasonality For Product '. (($has_product_item == true) ? 'Item' : '')).$number); ?> <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date validated">
                                                <select name="seasonality[<?php echo e($key); ?>]" class="form-control seasonality">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                    <option value="new_seasonality_monthly" <?php echo e(($product_seasonality[$key]->seasonality ??(old('seasonality')[$key]??'')) !== 'new_seasonality_monthly' ?:'selected'); ?>><?php echo e(__('New Seasonality - Monthly')); ?></option>
                                                    <option value="new_seasonality_quarterly" <?php echo e(($product_seasonality[$key]->seasonality ??(old('seasonality')[$key]??'')) !== 'new_seasonality_quarterly' ?:'selected'); ?>><?php echo e(__('New Seasonality - Quarterly')); ?></option>
                                                </select>
                                                <?php if($errors->has("seasonality.".$key)): ?>
                                                    <div class="invalid-feedback"><?php echo e($errors->first("seasonality.".$key)); ?></div>
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
            
            <div  class="row monthly_seasonality"  style="display: <?php echo e(($product_seasonality[$key]['seasonality'] ?? (old('seasonality')[$key]??'') ) == 'new_seasonality_monthly' ? 'block' :  'none'); ?>">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--mobile">
                        
                        <div class="kt-portlet__body">
                            <?php if($errors->has("percentages_total.".$key)): ?>
                                <h4 style="color: red"><i class="fa fa-hand-point-right">
                                </i></i><?php echo e($errors->first("percentages_total.".$key)); ?></h4>
                                
                            <?php else: ?>
                                <h4 class="text-success"><i class="fa fa-hand-point-right">
                                </i></i><?php echo e(__('Total Percentages Must Be Equal To 100 %')); ?></h4>

                            <?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Monthly Seasonality'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                <?php $__env->slot('table_header'); ?>
                                    <tr class="table-active text-center">
                                        <th><?php echo e(__('Dates')); ?></th>
                                        <?php $__currentLoopData = $sales_forecast['dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e(__('Total Values')); ?></th>
                                    </tr>
                                <?php $__env->endSlot(); ?>
                                <?php $__env->slot('table_body'); ?>
                                <tr>
                                    <th class="text-center"><?php echo e(__('Sales %')); ?></th>
                                    <?php $__currentLoopData = $sales_forecast['dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $value = $product_seasonality[$key]['seasonality_data'][$date] ?? (old('new_seasonality_monthly')[$key][$date]??0) ?>

                                            <td class="text-center">
                                                <input type="number" data-product="<?php echo e($key); ?>" class="form-control months"  name="new_seasonality_monthly[<?php echo e($key); ?>][<?php echo e($date); ?>]" value="<?php echo e(($product_seasonality[$key]['seasonality'] ?? (old('seasonality')[$key]??'')) == 'new_seasonality_monthly' ? $value : 0); ?>" >
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td> <input type="number" disabled class="form-control total_months" value=""> </td>
                                    </tr>
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
            </div>
            
            <div  class="row quarterly_seasonality"style="display: <?php echo e(($product_seasonality[$key]['seasonality'] ??(old('seasonality')[$key]??'') ) == 'new_seasonality_quarterly' ? 'block' :  'none'); ?>">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--mobile">

                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->

                            <?php if($errors->has("percentages_total.".$key)): ?>
                                <h4 style="color: red"><i class="fa fa-hand-point-right">
                                </i></i><?php echo e($errors->first("percentages_total.".$key)); ?></h4>
                                
                            <?php else: ?>
                                <h4 class="text-success"><i class="fa fa-hand-point-right">
                                </i></i><?php echo e(__('Total Percentages Must Be Equal To 100 %')); ?></h4>

                            <?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Quarterly Seasonality'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                <?php $__env->slot('table_header'); ?>
                                    <tr class="table-active text-center">
                                        <th><?php echo e(__('Dates')); ?></th>
                                        <?php $__currentLoopData = $sales_forecast['quarter_dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e(__('Total Values')); ?></th>
                                    </tr>
                                <?php $__env->endSlot(); ?>
                                <?php $__env->slot('table_body'); ?>

                                    <tr>
                                        <th class="text-center"><?php echo e(__('Sales %')); ?></th>
                                        <?php $__currentLoopData = $sales_forecast['quarter_dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $value = $product_seasonality[$key]['seasonality_data'][$date] ?? (old('new_seasonality_quarterly')[$key][$date]??0) ?>
                                            <td class="text-center">
                                                <input type="number" data-product="<?php echo e($key); ?>" name="new_seasonality_quarterly[<?php echo e($key); ?>][<?php echo e($date); ?>]" value="<?php echo e(($product_seasonality[$key]['seasonality'] ?? (old('seasonality')[$key]??''))  == 'new_seasonality_quarterly' ? $value :0); ?>"
                                                    class="form-control quarters">
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td> <input type="number" disabled class="form-control total_quarters"></td>
                                    </tr>

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
            </div>
            <?php $key++; ?>
        <?php endfor; ?>
        
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.next__button','data' => []]); ?>
<?php $component->withName('next__button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            for (let index = 0; index < '<?php echo e($sales_forecast->number_of_products); ?>' ; index++) {
                totalFunction('.months','.total_months',index,0);
                totalFunction('.quarters','.total_quarters',index,0);
                percentageCangeing(index,$('.sales_target_percentage').eq(index).val());
                cat(index);
            }
        });
        $('.months').on('change',function () {
            key = $(this).data('product');
            totalFunction('.months','.total_months',key,0);
        });
        $('.quarters').on('change',function () {
            key = $(this).data('product');
            totalFunction('.quarters','.total_quarters',key,0);
        });

        function totalFunction(field_name,total_field_name,key,decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '' && key ==  $(this).data('product')) {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).eq(key).val(total.toFixed(decimals));
        }


        $('.products').on('change', function () {
            var index = $('.products').index(this);
            cat(index);
        });
        function cat(index) {
            var name= $('.products').eq(index).find(':selected').data('name');
            var id= $('.products').eq(index).find(':selected').data('id');

            $('.categories option').eq(index).remove();
            select = '<option value="'+id+'" selected>'+name +'</option>';
            $('.categories').eq(index).append(select);
        }
        $('.sales_target_value').on('change', function () {
            var index = $('.sales_target_value').index(this);
            var sales_target_value = parseFloat($(this).val());
            var percentage = (sales_target_value/parseFloat("<?php echo e($sales_forecast->sales_target); ?>"))*100;
            $('.sales_target_percentage').eq(index).val(percentage.toFixed(2));
        });

        $('.sales_target_percentage').on('change', function () {
            var index = $('.sales_target_percentage').index(this);
            percentageCangeing(index,$(this).val());
        });

        function percentageCangeing(index,percentage) {

            var sales_target_percentage = parseFloat(percentage) /100;
            var value = (sales_target_percentage*parseFloat("<?php echo e($sales_forecast->sales_target); ?>")) ;
            $('.sales_target_value').eq(index).val(value.toFixed(0));
        }

        $('.seasonality').on('change', function() {
            val = $(this).val();
            var index = $('.seasonality').index(this);

              if (val == 'new_seasonality_monthly') {
                    $('.monthly_seasonality').eq(index).fadeIn(300);
                $('.quarterly_seasonality').eq(index).fadeOut("slow", function() {
                });
            } else if (val == 'new_seasonality_quarterly') {
                $('.monthly_seasonality').eq(index).fadeOut("slow", function() {
                    $('.quarterly_seasonality').eq(index).fadeIn(300);
                });

            }
        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/products_seasonality.blade.php ENDPATH**/ ?>