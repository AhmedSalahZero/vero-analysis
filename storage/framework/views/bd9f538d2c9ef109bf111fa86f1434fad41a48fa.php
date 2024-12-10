
<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs',['active'=>'interval_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css" />
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
            <h3 class="kt-portlet__head-title head-title text-primary font-1-5">
                <?php echo e(__('Dashboard Results')); ?>

            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo e(route('dashboard.intervalComparing',$company)); ?>" method="POST">
            <?php echo csrf_field(); ?>
              <div class="form-group row ">
                  <div class="col-md-3">
                        <label style="margin-right: 10px;"><b><?php echo e(__('Comparing Types')); ?></b></label>
                  </div>
                <div class="col-md-9">
                    <div class="input-group date" >
                                        <select  data-live-search="true" data-max-options="2" name="types[]" required class="form-control select2-select form-select form-select-2 form-select-solid fw-bolder"
                                            id="types" multiple>
                                            <option disabled value="0
                                            "><?php echo e(__('Types (Two Options As Maxium)')); ?></option>
                                            <?php $__currentLoopData = $permittedTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($name); ?>"> <?php echo e(__(preg_replace('/(?<!\ )[A-Z]/', ' $0', $zone ))); ?></option>
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                </div>
                
             
            </div>
            <div class="form-group row ">
              
                <div class="col-md-3">
                    <label><b><?php echo e(__('First Inteval')); ?></b></label>
                </div>
                <div class="col-md-3">
                    <label><?php echo e(__('Start Date One')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date_one"  required value="<?php echo e($start_date_0); ?>"  class="form-control"  placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label><?php echo e(__('End Date One')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date_one" required value="<?php echo e($end_date_0); ?>" max="<?php echo e(date('Y-m-d')); ?>"  class="form-control"  placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label><?php echo e(__('Note')); ?> </label>
                    <div class="kt-input-icon">
                        <div class="input-group ">
                                <input type="text" class="form-control" disabled value="<?php echo e(__('The Report Will Show Max Top 50')); ?>"  >
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row ">
                <div class="col-md-3">
                    <label><b><?php echo e(__('Second Inteval')); ?></b></label>
                </div>
                <div class="col-md-3">
                    <label><?php echo e(__('Start Date Two')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date_two"  required value="<?php echo e($start_date_1); ?>"  class="form-control"  placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label><?php echo e(__('End Date Two')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date_two"  required  value="<?php echo e($end_date_1); ?>" max="<?php echo e(date('Y-m-d')); ?>"  class="form-control"  placeholder="Select date" />
                        </div>
                    </div>
                </div>



                <div class="col-md-3">
                    <label><?php echo e(__('Data Type')); ?> </label>
                    <div class="kt-input-icon">
                        <div class="input-group ">
                            <input type="text" class="form-control" disabled value="<?php echo e(__('Value')); ?>"  >
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
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </form>
    </div>
</div>



   
    
    <div class="row">

        
<?php $i = 0 ?> 
<?php $k = 0 ?> 

        <?php $__currentLoopData = $intervalComparing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theType => $intervals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="row w-100" style="order:<?php echo e(++$i); ?>">

          <div style="width:100%" class=" text-center mt-3 mb-3">
                        <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary font-1-5" style="text-transform: capitalize">
                                    <b><?php echo e((ucfirst(str_replace('_',' ' ,$theType))) . ' Sales Interval Comparing Analysis '); ?></b>
                                </h3>
                        </div>
                    </div>
                </div>
          </div>

        <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervalName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6" >
                <div class="kt-portlet kt-portlet--mobile">
                                    <?php echo $__env->make('interval_date' , ['k'=>$k % 2 ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="kt-portlet__body">



                         <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__env->slot('table_header'); ?>
                                <tr class="table-active text-center">
                                    <th class="text-center">#</th>
                                    <th class="text-center"><?php echo e(__('Item')); ?></th>
                                    <th class="text-center"><?php echo e(__('Sales Values')); ?></th>
                                    <th class="text-center"><?php echo e(__('%')); ?></th>

                                </tr>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('table_body'); ?>
							
                                <?php $total = array_sum(array_column($data,'Sales Value')) ?> 
								
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th><?php echo e($key+1); ?></th>
                                    <th><?php echo e($item['item']?? '-'); ?></th>
                                    <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                                    <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($item['Sales Value']/$total)*100) , 1) . ' %'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="table-active text-center">
                                    <th colspan="2"><?php echo e(__('Total')); ?></th>
                                    <td class="hidden"></td>
                                    <td><?php echo e(number_format($total)); ?></td>
                                    <td>100 %</td>
                                </tr>
                            <?php $__env->endSlot(); ?>
                         <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                    </div>
                </div>
            </div>
<?php $k = $k+ 1 ?> 
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


<?php $i = $i + 2 ?> 

     
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



























        <?php $i =  0  ?> 
          <?php $__currentLoopData = $intervalComparing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theType => $intervals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row w-100" style="order:<?php echo e(++$i); ?>">

           <div style="width:100%" class=" text-center mt-3 mb-3">
                        <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary font-1-5" style="text-transform: capitalize">
                                    <b><?php echo e((ucfirst(str_replace('_',' ' ,$theType))) . ' Sales Interval Comparing Analysis '); ?></b>
                                </h3>
                        </div>
                    </div>
                </div>
          </div>

          
        <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervalName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-6">
                <div class="kt-portlet kt-portlet--mobile">

                    

                                 <?php echo $__env->make('interval_date' , ['i'=>$i %2 ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                    <div class="kt-portlet__body">


                        <!--begin: Datatable -->

                        <!-- HTML -->
                        <div id="chartdiv<?php echo e($theType.$intervalName); ?>_product_items" class="chartDiv"></div>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
       
            <input type="hidden" id="data<?php echo e($theType.$intervalName); ?>_product_items" data-total="<?php echo e(json_encode($data)); ?>">


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
        <?php $i =  $i + 2   ?> 


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



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

    <script src="<?php echo e(url('assets/vendors/general/select2/dist/js/select2.full.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/select2.js')); ?>" type="text/javascript"></script>
<script>
        reinitializeSelect2();
</script>


    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Chart code -->
    <?php $__currentLoopData = $intervalComparing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theType => $intervals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervalName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdiv"+'<?php echo e($theType . $intervalName); ?>'+'_product_items', am4charts.PieChart);

                // Add data
                chart.data = $('#data'+'<?php echo e($theType . $intervalName); ?>'+'_product_items').data('total');
                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "Sales Value";
                pieSeries.dataFields.category = "item";
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- Chart code -->
  <?php $__currentLoopData = $intervalComparing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theType => $intervals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervalName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdiv"+'<?php echo e($theType .  $intervalName); ?>', am4charts.PieChart);

                // Add data
                chart.data = $('#data'+'<?php echo e($theType . $intervalName); ?>').data('total');
                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "Sales Value";
                pieSeries.dataFields.category = "item";
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/home_dashboard/dashboard_intervalComparing.blade.php ENDPATH**/ ?>