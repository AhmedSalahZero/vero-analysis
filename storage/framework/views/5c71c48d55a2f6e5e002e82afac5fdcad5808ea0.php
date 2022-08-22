
<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs',['active'=>'customer_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title head-title text-primary">
                <?php echo e(__('Dashboard Results')); ?>

            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo e(route('dashboard.customers',$company)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group row">
                <div class="col-md-10">
                    <label><?php echo e(__('Choose Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="date" required value="<?php echo e($date); ?>"
                                max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label> </label>
                    <div class="kt-input-icon">
                        <button type="submit" class="btn active-style"><?php echo e(__('Submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Customers Sales Breakdown Analysis')); ?>

                    </h3>
            </div>
        </div>
    </div>
</div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->

                    <!-- HTML -->
                    <div id="chartdiv" class="chartDiv"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->

                     <?php
            $others = array_slice($customers_natures['totals'] , 50 ,null,true ) ;
            $allFormattedWithOthers = array_merge(
                array_slice($customers_natures['totals'] , 0 , 50 , true) , 
                count($others) ? [
                  (object)[
                        'customer_name'=>__('Others') . ' ( ' . count($others) . ' )'  ,
                    'val'=>array_sum(array_column($others , 'val')) ,
                    'percentage'=>array_sum(array_column($others,'percentage')) 
                  ]
                ]   : []  
            );

        ?>

         <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th>#</th>
                                <th><?php echo e(__('Customers')); ?></th>
                                <th><?php echo e(__('Sales Values')); ?></th>
                                <th><?php echo e(__('Percentages %')); ?></th>

                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $__currentLoopData = $allFormattedWithOthers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            
                            <tr>
                                <th><?php echo e($key+1); ?></th>
                                <th><?php echo e($item->customer_name); ?></th>
                                <td class="text-center"><?php echo e(number_format($item->val)); ?></td>
                                <td class="text-center"><?php echo e($item->percentage); ?> % </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      
                            <tr class="table-active text-center">
                                <th colspan="2"><?php echo e(__('Total')); ?></th>
                                <td class="hidden"></td>
                                <td><?php echo e(number_format(array_sum(array_column($allFormattedWithOthers,'val')))); ?></td>
                                <td>100 %</td>
                            </tr>
                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

        


                    

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    
       

        <input type="hidden" id="total" data-total="<?php echo e(json_encode(
            $allFormattedWithOthers 
        )); ?>">


    </div>

    <div class="row">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Customers Natures Analysis')); ?>

                        </h3>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->


                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__('Customer Nature')); ?></th>
                                <th><?php echo e(__('Count')); ?></th>
                                <th><?php echo e(__('Count %')); ?></th>
                                <th><?php echo e(__('Sales Value [Yr -') . date('Y',strtotime($date)) .']'); ?></th>
                                <th><?php echo e(__('Sales Value %')); ?></th>
                                <th><?php echo e(__('View')); ?></th>

                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                        
                            <?php 
                            $totalCount = array_sum(array_map("count", $customers_natures['statictics'])) ;
                            $totalSales = 0 ;
                            foreach( $customers_natures['statictics']  as $key => $val ){
                                $totalSales += array_sum ( array_column($val , 'total_sales') );
                                
                                                                }

                              ?>

                            <?php $__currentLoopData = $customers_natures['statictics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staticName=>$vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                             $countVals = count($vals) ;
                            $totalSaleForCustomerType = array_sum(array_column($vals,'total_sales'));
                              ?>
                            
                                <tr>
                                    <th><?php echo e($staticName); ?></th>
                                    <td class="text-center"><?php echo e($countVals); ?></td>
                                    <td class="text-center"><?php echo e($totalCount ? number_format(($countVals / $totalCount)*100 , 1 ) . ' %' : 0); ?></td>

                                    <td class="text-center"><?php echo e(number_format($totalSaleForCustomerType,0)); ?></td>

                                    <td class="text-center"><?php echo e($totalSales ? number_format(($totalSaleForCustomerType / $totalSales)*100 , 1 ) . ' %' : 0); ?></td>

                                    <?php if($countVals > 0): ?> 
                                    
                                        <td class="text-center"><button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_<?php echo e(str_replace(["/" ,' ' ] , '-' , $staticName)); ?>"> 
                                        <?php echo e(__($staticName.' - Customers')); ?>

                                        </button>

                                        
                                        
                                           <?php if($countVals > 0): ?>
                            <div class="modal fade" id="kt_modal_<?php echo e(str_replace(["/" ,' ' ] , '-' , $staticName)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__($staticName.' Customers')); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                    <?php $__env->slot('table_header'); ?>
                                                        <tr class="table-active text-center">

                                                            <th><?php echo e(__('Customer Name')); ?></th>
                                                            <th><?php echo e(__('Sales')); ?></th>
                                                            <th><?php echo e(__('Percentage')); ?></th>
                                                        </tr>
                                                    <?php $__env->endSlot(); ?>
                                                    <?php $__env->slot('table_body'); ?>
                                                        <?php
                                                        $totalForThisCategory = array_sum(array_column($vals,'total_sales')) ;
                                                        ?> 
                                                        <?php $__currentLoopData = $vals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($customer->customer_name); ?></td>
                                                                <td><?php echo e($customer->total_sales ? number_format($customer->total_sales) : 0); ?></td>
                                                                <td><?php echo e($customer->total_sales && $totalForThisCategory ? number_format(($customer->total_sales/$totalForThisCategory)*100 , 2) . ' %' : 0); ?> </td>
                                                            </tr>
                                                            <?php if($loop->last): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo e(__('Total')); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e(number_format($totalForThisCategory , 2 )); ?>

                                                                </td>
                                                                <td>
                                                                    100 %
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?> 
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__env->endSlot(); ?>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                                        </td>
                                    <?php else: ?>
                                        <td  class="text-center"><b><?php echo e(__('No Customers')); ?></b></td>

                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            <tr class="table-active text-center">
                                <th><?php echo e(__('Total')); ?></th>
                                <td><?php echo e(number_format($totalCount)); ?></td>
                                <td><?php echo e(number_format(100) . '%'); ?></td>
                                <td><?php echo e(number_format($totalSales)); ?></td>
                                <td><?php echo e(number_format(100) . '%'); ?></td>
                                <td><b>-</b></td>
                            </tr>
                             <?php 
                            $totalCount = array_sum(array_map("count", $customers_natures['stops'])) ;
                            foreach( $customers_natures['stops']  as $key => $val ){
                                }
                              ?>
                            <?php $__currentLoopData = $customers_natures['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php
                             $countVals = count($vals) ;
                            $totalSaleForCustomerType = array_sum(array_column($vals,'total_sales'));
                              ?>
                                <tr>
                                    <th><?php echo e($name); ?></th>
                                    <td class="text-center"><?php echo e($countVals); ?></td>
                                       <td class="text-center">
                                           --
                                           
                                           </td>
                                    <td class="text-center"><?php echo e(number_format($totalSaleForCustomerType,0)); ?></td>
                                   <td class="text-center"><?php echo e($totalSales ? number_format(($totalSaleForCustomerType / $totalSales)*100 , 1 ) . ' %' : 0); ?></td>
                                    <?php if($countVals > 0): ?>
                                        <td class="text-center"><button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_<?php echo e(str_replace(["/" .' ' ] , '-' , $name)); ?>"> <?php echo e(__($name.' - Customers')); ?></button></td>
                                    <?php else: ?>
                                        <td  class="text-center"><b><?php echo e(__('No Customers')); ?></b></td>
                                    <?php endif; ?>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

                    <?php $__currentLoopData = $customers_natures['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      
                        <?php if($countVals > 0): ?>
                            <div class="modal fade" id="kt_modal_<?php echo e(str_replace(["/" .' ' ] , '-' , $name)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__($name.' Customers')); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                    <?php $__env->slot('table_header'); ?>
                                                        <tr class="table-active text-center">

                                                            <th><?php echo e(__('Customer Name')); ?></th>

                                                                  <th><?php echo e(__('Sales')); ?></th>
                                                            <th><?php echo e(__('Percentage')); ?></th>


                                                        </tr>
                                                    <?php $__env->endSlot(); ?>
                                                    <?php $__env->slot('table_body'); ?>
                                                      <?php
                                                        $totalForThisCategory = array_sum(array_column($vals,'total_sales')) ;
                                                        ?> 

                                                        <?php $__currentLoopData = $vals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($customer->customer_name); ?></td>
                                                                    <td><?php echo e($customer->total_sales ? number_format($customer->total_sales) : 0); ?></td>
                                                                <td><?php echo e($customer->total_sales && $totalForThisCategory ? number_format(($customer->total_sales/$totalForThisCategory)*100 , 2) . ' %' : 0); ?> </td>

                                                            </tr>

                                                            <?php if($loop->last): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo e(__('Total')); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e(number_format($totalForThisCategory , 2 )); ?>

                                                                </td>
                                                                <td>
                                                                    100 %
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?> 
                                                            
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__env->endSlot(); ?>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        // Add data
        chart.data = $('#total').data('total');
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "val";
        pieSeries.dataFields.category = "customer_name";
        pieSeries.innerRadius = am4core.percent(50);
        // arrow
        pieSeries.ticks.template.disabled = true;
        //number
        pieSeries.labels.template.disabled = true;

        var rgm = new am4core.RadialGradientModifier();
        rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
        pieSeries.slices.template.fillModifier = rgm;
        pieSeries.slices.template.strokeModifier = rgm;
        pieSeries.slices.template.strokeOpacity = 0.4;
        pieSeries.slices.template.strokeWidth = 0;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "right";
    chart.legend.scrollable = true;

    }); // end am4core.ready()
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/home_dashboard/dashboard_customers.blade.php ENDPATH**/ ?>