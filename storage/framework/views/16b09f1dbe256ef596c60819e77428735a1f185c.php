
<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs',['active'=>'breadkdown_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }
        /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php
     $exportableFields  = (new \App\Http\Controllers\ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');
     $exportableFieldsValues = array_keys($exportableFields);
    $exportableFieldsValues[] = 'invoice_count';
    $exportableFieldsValues[] = 'product_item_avg_count';
    $exportableFieldsValues[] = 'avg_invoice_value';

?>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Dashboard Results')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form action="<?php echo e(route('dashboard.breakdown',$company)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-md-5">
                        <label><?php echo e(__('Start Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" name="start_date" required value="<?php echo e($start_date); ?>"
                                    max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label><?php echo e(__('End Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" name="end_date" required value="<?php echo e($end_date); ?>"
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

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body  kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-xl">
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        
                  
                            <div class="col-md-4">
                                <!--begin::Total Profit-->
                                <div class="kt-widget24 text-center">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info w-100">
                                            <h4 class="kt-widget24__title font-size justify-content-between">
                                               
                                                <span><?php echo e(__('Top '. ucwords(str_replace('_',' ',$type)))); ?></span>
                                                <p>
                                                    <button type="button" class="btn text-white btn-small btn-<?php echo e($color); ?>" data-toggle="modal" data-target="#modal_for_<?php echo e($type); ?>">
                                                        <?php echo e(__('Take Away')); ?>

                                                    </button>




                                                    
                                                </p>
                                            </h4>
                                        </div>
                                    </div>


                                                    <div class="modal fade bd-example-modal-xl"  id="modal_for_<?php echo e($type); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-left"  id="exampleModalLabel " style="line-height: 2"><?php echo e(ucwords(str_replace('_',' ',$type)) . ' - ' . __('Take Aways')); ?> <br> 
        <?php echo e(__('From:') . ' ' .  \Carbon\Carbon::make($start_date)->format('d-M-Y')  .' ' . __('To:') . ' ' . \Carbon\Carbon::make($end_date)->format('d-M-Y')); ?> 
        
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php
              $businessSectors = getTypeFor('business_sector',$company->id,false);
          ?>
          <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
          <input type="hidden" name="type" value="business_sector">
          <label class="text-left font-weight-bold  w-100 mb-3 text-black"><?php echo e(__('Please Select')); ?>  <?php echo e(ucwords(str_replace('_',' ',$type))); ?></label>
          <select id="business_sector_select" data-live-search="true" data-actions-box="true" name="selected_type" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" >
              <?php $__currentLoopData = $businessSectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businesSector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($businesSector); ?>"> <?php echo e(__($businesSector)); ?> </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
          </select>

          <table class="table table-bordered mt-5 datatable" id="" style="table-layout: fixed">
              <tr class="text-white" style="background-color:#086691">
                  <th> <?php echo e(__('Item')); ?> </th>
                  <th> <?php echo e(__('Value')); ?> </th>
              </tr>






                   <tr >
                  <td   class="text-left"><?php echo e(__('Business Sector Name')); ?> </td>
                  <td id="selected_type_name"><?php echo e(__('Value')); ?></td>
              </tr>


                 <tr >
                  <td   class="text-left"><?php echo e(__('Sales Value')); ?> </td>
                  <td id="total_sales_value"><?php echo e(__('Value')); ?></td>
              </tr>

              <?php $__currentLoopData = [  'customer_name'=>'Customers Count' , 'category'=>'Categories Count' , 'product_or_service'=> 'Products/Service Count' , 'product_item'=>'Products Item Count' ,'sales_person'=>'Salesperson Count' , 'invoice_count'=> 'Invoices Count','product_item_avg_count'=>'Avg Products Item Per Invoice' ,'avg_invoice_value'=>'Avg Invoice Values' ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if(in_array($id , $exportableFieldsValues)): ?>
               <tr >
                  <td  class="text-left"><?php echo e(__($item)); ?> </td>
                  <td id="<?php echo e($id); ?>">-</td>
              </tr>
              <?php endif; ?>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
              
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
        <button id="recalc_modal" type="button" class="btn btn-primary"><?php echo e(__('Run')); ?></button>
      </div>
    </div>
  </div>
</div>




                                    <div class="kt-widget24__details">
                                        <span class="kt-widget24__stats kt-font-<?php echo e($color); ?>">
                                            <?php echo e(__( '[ ' .($top_data[$type]['item'] ?? ' - ')) .' ]  ' .number_format(($top_data[$type]['Sales Value']??0))); ?>

                                    </div>

                                    <input type="hidden" id="top_for_<?php echo e($type); ?>"  value="<?php echo e($top_data[$type]['item'] ?? ''); ?>">
                                    <input type="hidden" id="value_for_<?php echo e($type); ?>"  value="<?php echo e(number_format(($top_data[$type]['Sales Value']??0))); ?>">

                                    <div class="progress progress--sm">
                                        <div class="progress-bar kt-bg-<?php echo e($color); ?>" role="progressbar" style="width: 100%;" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="kt-widget24__action">
                                        <span class="kt-widget24__change">

                                        </span>
                                        <span class="kt-widget24__number">

                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        <?php $__currentLoopData = $reports_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $report_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-12 col-lg-6">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__(ucwords(str_replace('_',' ',$type)).' Breakdown Analysis')); ?>

                                </h3>
                        </div>
                    </div>
                </div>

                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1_<?php echo e($type); ?>" role="tab">
                                        <i class="flaticon-line-graph"></i> &nbsp; Charts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_2_<?php echo e($type); ?>" role="tab">
                                        <i class="flaticon2-checking"></i>Reports Table
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="kt_apps_contacts_view_tab_1_<?php echo e($type); ?>" role="tabpanel">

                                
                                <div class="col-xl-12">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__body kt-portlet__body--fluid">
                                            <div class="kt-widget12">
                                                <div class="kt-widget12__chart">
                                                    <!-- HTML -->
                                                    <h4> <?php echo e(__('Sales Values')); ?> </h4>
                                                    <div id="chartdiv_<?php echo e($type); ?>" class="chartDiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="kt_apps_contacts_view_tab_2_<?php echo e($type); ?>" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="kt-portlet kt-portlet--mobile">
                                        
                                        <div class="kt-portlet__body">

                                            <!--begin: Datatable -->
                                            <?php
                                                if ($type == 'service_provider_birth_year' || $type == 'service_provider_type') {
                                                    $report_count_data = $report_data['report_count_data'];
                                                    $total_count = ( count($report_count_data) > 0) ? array_sum(array_column($report_count_data,'Count')) : 0;
                                                    $report_data = $report_data['report_view_data']  ;

                                                }
                                                $total = array_sum(array_column(($report_data??[]),'Sales Value'));$key=0;
                                            ?>

                                            <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                <?php $__env->slot('table_header'); ?>
                                                    <tr class="table-active text-center">
                                                        
                                                        <th><?php echo e(__(ucwords(str_replace('_',' ',$type)))); ?></th>
                                                        <th><?php echo e(__('Sales Values')); ?></th>
                                                        <th><?php echo e(__('Percentages %')); ?></th>
                                                        <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                                            <th><?php echo e(__('Count')); ?></th>
                                                            <th><?php echo e(__('Count %')); ?></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php $__env->endSlot(); ?>
                                                <?php $__env->slot('table_body'); ?>



                                                    <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <tr>

                                                            
                                                            <td><?php echo e($item['item']?? '-'); ?></td>
                                                            <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                                                            <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($item['Sales Value']/$total)*100) , 1) . ' %'); ?></td>
                                                            <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                                                <td class="text-center"><?php echo e($report_count_data[$key]['Count']); ?></td>
                                                                <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($report_count_data[$key]['Count'] /$total_count)*100) , 1) . ' %'); ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <tr class="table-active text-center">
                                                        <td  ><?php echo e(__('Total')); ?></td>
                                                        
                                                        <td><?php echo e(number_format($total)); ?></td>
                                                        <td>100 %</td>
                                                        <?php if(isset($report_count_data) && count($report_count_data) > 0): ?>
                                                            <td><?php echo e($total_count); ?></td>
                                                            <td>100 %</td>
                                                        <?php endif; ?>
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
                                <input type="hidden" id="total_<?php echo e($type); ?>" data-total="<?php echo e(json_encode($report_data)); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdiv_"+"<?php echo e($type); ?>", am4charts.PieChart);

                // Add data
                chart.data = $('#total_'+"<?php echo e($type); ?>").data('total');
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

    <script>
        
        $(function(){

            $('#modal_for_business_sector').on('show.bs.modal', function(e){
                let company_id = $(this).find('input[type="hidden"][name="company_id"]').val();
                let type = $(this).find('input[name="type"][type="hidden"]').val();
                 if(! $(this).data('target'))
                 {
                       let topTypeName = $('#top_for_'+type).val();
                let topTypeSalesValue = $('#value_for_'+type).val();
                $(this).find('#selected_type_name').html(topTypeName);
                $(this).find('#total_sales_value').html(topTypeSalesValue);
                    $(this).find(`option[value="${topTypeName}"]`).prop('selected',true).trigger('change');
                }

                let selectedType = $(this).find('select[name="selected_type"]').val();
                $(this).data('target' , 1);
                $.ajax({
                        type: 'post',
                        url: "<?php echo e(route('get.net.sales.modal.for.type')); ?>",
                        data: {
                            "company_id":company_id,
                            "selectedType":selectedType,
                            "start_date":"<?php echo e($start_date); ?>",
                            "end_date":"<?php echo e($end_date); ?>",
                            "type":type ,
                            "modal_id":'modal_for_business_sector'
                        },
                        success: function (result) {
                            if(result.data){
                                let modal_id = result.data[0].modal_id ;

                                for(index in result.data[0])
                                {
                                    // console.log(index);
                                    // console.log(result.data[0]);
                                    if(index != modal_id)
                                    {
                                        $('#'+ modal_id  ).find('#'+index).html(result.data[0][index]);
                                    }
                                }
                            }
                        }, error: function (reject) {
                        }
                    });


            })
            
 
        });

        $(document).on('click' , '#recalc_modal' , function(e){
            e.preventDefault();
            $('#modal_for_business_sector').trigger('show.bs.modal')
        })

    </script>

  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/home_dashboard/dashboard_breakdown.blade.php ENDPATH**/ ?>