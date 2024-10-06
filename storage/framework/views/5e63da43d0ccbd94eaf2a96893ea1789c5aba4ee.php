<?php
use App\Models\Contract;
?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
    .main-td-background {
        background-color: #0742A6;
        color: white;
    }

    #test_filter {
        display: none !important;
    }



    .kt-portlet__body {
        padding-top: 0 !important;
    }

    .sub-item-row,
    table.dataTable tbody tr.second-tr-bg>.dtfc-fixed-left,
    table.dataTable tbody tr.second-tr-bg.sub-item-row>.dtfc-fixed-right {}

    .bg-last-row,
    .bg-last-row td,
    .bg-last-row th {
        background-color: #F2F2F2 !important;
        color: black !important;
        border: 1px solid white !important;
    }

    .first-tr,
    .first-tr td,
    .first-tr th {
        background-color: #9FC9FB !important;
    }

    .sub-item-row,
    table.dataTable tbody tr.second-tr-bg>.dtfc-fixed-left,
    table.dataTable tbody tr.second-tr-bg.sub-item-row>.dtfc-fixed-right {
        background-color: white !important;
        color: black !important;
    }

    .sub-item-row td {
        background-color: #E2EFFE !important;
        color: black !important;
        border: 1px solid white !important;
    }

    .main-row-tr {
        background-color: white !important
    }

    .main-row-tr td {
        border: 1px solid #CCE2FD !important;

    }

    .first-tr-bg,
    .first-tr-bg td,
    .first-tr-bg th {
        background-color: #074FA4 !important;
        color: white !important;
    }

    .second-tr-bg,
    .second-tr-bg td,
    .second-tr-bg th {
        background-color: white !important;
        color: black !important;
        padding: 3px !important;
        border: none !important;
    }

    .second-tr-bg.second-tr-bg-more-padding,
    .second-tr-bg.second-tr-bg-more-padding td,
    .second-tr-bg.second-tr-bg-more-padding th {
        padding: 7px !important;

    }



    body .table-active,
    .table-active>th,
    .table-active>td {
        background-color: white !important
    }

    #DataTables_Table_0_filter {
        float: left !important;
    }

    div.dt-buttons {
        float: right !important;
    }

    body table.dataTable tbody tr.group-color>.dtfc-fixed-left,
    table.dataTable tbody tr.group-color>.dtfc-fixed-right {
        background-color: white !important;
    }

    .text-capitalize {
        text-transform: capitalize;
    }

    .placeholder-light-gray::placeholder {
        color: lightgrey;
    }

    .kt-header-menu-wrapper {
        margin-left: 0 !important;
    }

    .kt-header-menu-wrapper .kt-header-menu .kt-menu__nav>.kt-menu__item>.kt-menu__link {
        padding: 0.60rem 1.25rem !important;
    }

    .max-w-22 {
        max-width: 22%;
    }

    .form-label {
        white-space: nowrap !important;
    }

    .visibility-hidden {
        visibility: hidden !important;
    }

    input.form-control[readonly] {
        background-color: #F7F8FA !important;
        font-weight: bold !important;

    }

    .three-dots-parent {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 0 !important;
        margin-top: 10px;

    }

    .blue-select {
        border-color: #7096f6 !important;
    }

    .div-for-percentage {
        flex-wrap: nowrap !important;
    }

    b {
        white-space: nowrap;
    }

    i.target_last_value {
        margin-left: -60px;
    }

    .total-tr {
        background-color: #074FA4 !important
    }

    .table-striped th,
    .table-striped2 th {
        background-color: #074FA4 !important
    }

    .total-tr td {
        color: white !important;
    }

    .total-tr .three-dots-parent {
        margin-top: 0 !important;
    }

</style>


<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        font-weight: bold;
        color: black;
    }

    table.dataTable tbody tr.group-color>.dtfc-fixed-left,
    table.dataTable tbody tr.group-color>.dtfc-fixed-right {
        background-color: white !important;
    }


    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        color: black;
        font-weight: bold;
    }

    thead * {
        text-align: center !important;
    }

</style>
<style>
    td.details-control {
        background: url('<?php echo e(asset('tables_imgs/details_open.png')); ?>') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('<?php echo e(asset('tables_imgs/details_close.png')); ?>') no-repeat center center;
    }

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($customerOrSupplierContractsText); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == Contract::RUNNING ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Contract::RUNNING); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Running')); ?>

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == Contract::RUNNING_AND_AGAINST ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Contract::RUNNING_AND_AGAINST); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Running And Against')); ?>

                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == Contract::FINISHED ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(Contract::FINISHED); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Finished')); ?>

                    </a>
                </li>

           

            </ul>
<?php if(hasAuthFor('view '. str_plural(strtolower($type)) .' contracts')): ?>
            <div class="flex-tabs">
              
                <a href="<?php echo e(route('contracts.create',['company'=>$company->id,'type'=>$type])); ?>" class="btn  active-style btn-icon-sm align-self-center">
                    <i class="fas fa-plus"></i>
                    <?php echo e(__('Create')); ?>

                </a>
            </div>
			<?php endif; ?> 

        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <?php $__currentLoopData = $contractStatues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contractStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $currentType = $contractStatus ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') && $contractStatus == Contract::RUNNING || Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    
                    <div class="kt-portlet__body">


                         <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_fixed  removeGlobalStyle ' ]); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__env->slot('table_header'); ?>


                            <tr class=" text-center second-tr-bg">
                                <th class="text-center absorbing-column "></th>
                                <th></th>
                            </tr>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('table_body'); ?>
                            <tr class=" text-center first-tr-bg ">
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('Partner Name')); ?></b></td>
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('Contract Name')); ?></b></td>
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('Contract Code')); ?></b></td>
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('Start Date')); ?></b></td>
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('End Date')); ?></b></td>
                                <td class=" text-center view-table-th"><b style="color:white !important" class="text-capitalize"><?php echo e(__('Amount')); ?></b></td>


                                <td style="color:white !important" class="text-center view-table-th ">
                                    <?php echo e(__('Actions')); ?>

                                </td>
                            </tr>
                            <?php
                            $id = 0 ;
                            ?>
                            <?php $__currentLoopData = $items[$currentType]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainItemId => $parnetAndSubData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $parent =$parnetAndSubData['parent'] ;
                            $subItems =$parnetAndSubData['sub_items'] ?? [];
                            $contract = $parent['contract'] ;

                            ?>
                            <tr class="group-color main-row-tr">



                                <td class="black-text " style="cursor: pointer;" onclick="toggleRow('<?php echo e($mainItemId); ?>')">

                                    <div class="d-flex align-items-center ">
                                        <?php if(count($subItems)): ?>
                                        <i class="row_icon<?php echo e($mainItemId); ?> flaticon2-up  mr-2  "></i>
                                        <?php endif; ?>
										 <b class="text-capitalize ">
                                        <b class="text-capitalize "><?php echo e($parent['client_name']); ?></b>
                                    </b>
                                      
                                    </div>
                                </td>
								 <td class="text-center">
                                    <b class="text-capitalize ">
                                        <b class="text-capitalize "><?php echo e($parent['contract_code']); ?></b>
                                    </b>

                                </td>
                                <td class="text-center">
                                   
  <b class="text-capitalize "><?php echo e($parent['name']); ?></b>
                                </td>
                                <td class="text-center">
                                    <b class="text-capitalize  ">
                                        <b class="text-capitalize "><?php echo e($parent['start_date']); ?></b>
                                    </b>


                                </td>
                                <td class="text-center">
                                    <b class="text-capitalize">
                                        <b class="text-capitalize"><?php echo e($parent['end_date']); ?></b>
                                    </b>


                                </td>
                                <td class="text-center">
                                    <b class="text-capitalize  ">
                                        <b class="text-capitalize"><?php echo e($parent['amount'] .' '. $parent['currency']); ?></b>
                                    </b>

                                </td>


                                <td class="text-left text-capitalize">

                            



                                    <b class="ml-3">
                                        <?php if($type == 'Customer'): ?>
										                                        <button  type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon"><i class="flaticon2-copy"></i> </button>
                                        
                                        
                                        <?php endif; ?>
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <?php if($currentType == Contract::RUNNING_AND_AGAINST): ?>
<?php if(hasAuthFor('update '. str_plural(strtolower($type)) .' contracts')): ?>
                                            <a data-toggle="modal" data-target="#mark-as-finished-contract-<?php echo e($mainItemId); ?>" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="<?php echo e(__('Finished')); ?>" href="#"><i class="fa fa-thumbs-up"></i></a>
                                            <div class="modal fade" id="mark-as-finished-contract-<?php echo e($mainItemId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('contract.mark.as.finished', ['company'=>$company->id , 'contract'=>$mainItemId,'type'=>$type])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('put'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Mark This Contract As Finished ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-primary"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
<?php endif; ?> 
                                            <?php elseif($currentType == Contract::FINISHED): ?>
											<?php if(hasAuthFor('update '. str_plural(strtolower($type)) .' contracts')): ?>
                                            <a data-toggle="modal" data-target="#mark-as-running-and-against-contract-<?php echo e($mainItemId); ?>" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="<?php echo e(__('Running And Against')); ?>" href="#"><i class="fa fa-thumbs-up"></i></a>
                                            <div class="modal fade" id="mark-as-running-and-against-contract-<?php echo e($mainItemId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('contract.mark.as.running.and.against', ['company'=>$company->id , 'contract'=>$mainItemId,'type'=>$type])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('put'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Mark This Contract As Running And Against ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-primary"><?php echo e(__('Confirm')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 

                                            <?php endif; ?>
											<?php if(hasAuthFor('update '. str_plural(strtolower($type)) .' contracts')): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('contracts.edit', ['company'=>$company->id , 'contract'=>$mainItemId,'type'=>$type])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php if(hasAuthFor('delete '. str_plural(strtolower($type)) .' contracts')): ?>
                                            <a class="btn btn-secondary btn-outline-hover-danger btn-icon  " href="#" data-toggle="modal" data-target="#modal-delete-<?php echo e($mainItemId); ?>" title="Delete"><i class="fa fa-trash-alt"></i>
                                            </a>

                                            <div id="modal-delete-<?php echo e($mainItemId); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo e(__('Delete Contract ' .$parent['name'])); ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3><?php echo e(__('Are You Sure To Delete This Item ? ')); ?></h3>
                                                        </div>
                                                        <form action="<?php echo e(route('contracts.destroy',['company'=>$company->id , 'contract'=> $mainItemId,'type'=>$type ])); ?>" method="post" id="delete_form">
                                                            <?php echo e(csrf_field()); ?>

                                                            <?php echo e(method_field('DELETE')); ?>

                                                            <div class="modal-footer">
                                                                <button class="btn btn-danger">
                                                                    <?php echo e(__('Delete')); ?>

                                                                </button>
                                                                <button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">
                                                                    <?php echo e(__('Close')); ?>

                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 

                                        </span>
                                    </b>
                                </td>






                            </tr>

                            <?php $__currentLoopData = $subItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemId => $titleAndValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                            <tr class="row<?php echo e($mainItemId); ?>  text-center sub-item-row" style="display: none">
                                <td colspan="5" class="text-left  text-capitalize">
                                    <table class="table ml-3 table-borderless">


                                        <tr>
                                            <?php if(isset($titleAndValue['so_number'] )): ?>
                                            <td><?php echo e(__('Sales Order Number')); ?></td>
                                            <td><?php echo e($titleAndValue['so_number']); ?></td>
                                            <?php elseif(isset($titleAndValue['po_number'] )): ?>
                                            <td><?php echo e(__('Purchase Order Number')); ?></td>
                                            <td><?php echo e($titleAndValue['po_number']); ?></td>
                                            <?php endif; ?>

                                            <td><?php echo e(__('Amount')); ?></td>
                                            <td><?php echo e($titleAndValue['amount']); ?></td>
                                        </tr>

                                    </table>
                                </td>

                                <td>
                                </td>







                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <?php $id++ ;?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>



</div>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>

<script>
    $(document).on('click', '#delete-btn', function() {
        $('#delete_form').attr('action', $(this).data('url'));
    });

    function toggleRow(rowNum) {
        $(".row" + rowNum).toggle();
        $('.row_icon' + rowNum).toggleClass("flaticon2-down flaticon2-up");
        $(".row2" + rowNum).hide();
    }

</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/contracts/index.blade.php ENDPATH**/ ?>