<?php $__env->startSection('css'); ?>
<?php
use App\Enums\LcTypes;
use App\Models\LetterOfCreditIssuance;

$currentActiveTab = isset($currentActiveTab) ? $currentActiveTab : null ;


?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    .custom-w-25 {
        width: 23% !important;
    }

    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 300px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Foreign Exchange Rate')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lc nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <?php
                $index = 0 ;
                ?>
                <?php $__currentLoopData = $existingCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentCurrencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <a data-currency="<?php echo e($currentCurrencyName); ?>" class="nav-link currency-change-js <?php echo e(!Request('active',$currentActiveTab) && $index==0 || (!in_array($mainFunctionalCurrency,$existingCurrencies) && $currentCurrencyName == array_key_first($existingCurrencies) && !$currentActiveTab ) || Request('active',$currentActiveTab) == $currentCurrencyName ?'active':''); ?>" data-toggle="tab" href="#<?php echo e($currentCurrencyName); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e($currentCurrencyName .' '. __('Table')); ?>

                    </a>
                </li>
                <?php
                $index = $index+1;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>


        </div>
    </div>
    <div class="kt-portlet__body">
	
	  	<?php
			$index = 0 ;
		?>
        <div class="tab-content  kt-margin-t-20">
			<?php $__currentLoopData = $existingCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $existingCurrency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			
            <?php
            $currentTab = $existingCurrency ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e((!Request('active',$currentActiveTab) && $currentTab == $mainFunctionalCurrency || !in_array($mainFunctionalCurrency,$existingCurrencies) && $currentTab == array_key_first($existingCurrencies) && !$currentActiveTab   )  || Request('active',$currentActiveTab) == $existingCurrency ?'active':''); ?>" id="<?php echo e($currentTab); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentTab,'title' => $existingCurrency . ' ' .__('Table') ,'startDate' => $filterDates[$currentTab]['startDate'],'endDate' => $filterDates[$currentTab]['endDate']]]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($existingCurrency . ' ' .__('Table') ),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['startDate']),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentTab]['endDate'])]); ?>
                        
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                    <div class="kt-portlet__body">
					<?php if(hasAuthFor('create foreign exchange rate')): ?>
					<div class="row">
                    <div class="col-md-12">
                       <?php echo $__env->make('admin.foreign-exchange-rate._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
				<?php endif; ?> 

                        <!--begin: Datatable -->
                          <table class="table kt_table_with_no_pagination_no_collapse table-for-currency  table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class-for-currency dataTable no-footer">
                                        <thead>

                                            <tr class="header-tr ">

                                                <th class="view-table-th max-w-serial  header-th  align-middle text-center">
                                                    <?php echo e(__('#')); ?>

                                                </th>

                                                <th class="view-table-th   max-w-16  align-middle text-center">
                                                    <?php echo e(__('Date')); ?>

                                                </th>

                                                <th class="view-table-th max-w-16    header-th  align-middle text-center">
                                                    <?php echo e(__('From Currency')); ?>

                                                </th>

                                                <th class="view-table-th max-w-16    header-th  align-middle text-center">
                                                    <?php echo e(__('To Currency')); ?>

                                                </th>

                                                <th class="view-table-th  max-w-16  header-th  align-middle text-center">
                                                    <?php echo e(__('Exchange Rate')); ?>

                                                </th>
                                                <th class="view-table-th  max-w-16  header-th  align-middle text-center">
                                                    <?php echo e(__('Reciprocal Exchange Rate')); ?>

                                                </th>
<?php if(hasAuthFor('update foreign exchange rate') || hasAuthFor('delete foreign exchange rate')): ?>
                                                <th class="view-table-th  max-w-action  header-th  align-middle text-center">
                                                    <?php echo e(__('Actions')); ?>

                                                </th>
												<?php endif; ?> 







                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $previousDate = null ;
                                            ?>
                                            <?php $__currentLoopData = $models[$existingCurrency]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foreignExchangeRate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                                <td class="sub-text-bg max-w-serial text-center   "><?php echo e(++$index); ?></td>
                                                <td class="sub-text-bg max-w-16  text-center   "><?php echo e($currentDueDate = $foreignExchangeRate->getDateFormatted()); ?> </td>
                                                <td class="sub-text-bg  max-w-16 text-center   "><?php echo e($foreignExchangeRate->getFromCurrency()); ?></td>
                                                <?php
                                                $previousDate = $foreignExchangeRate->getDate();
                                                ?>
                                                <td class="sub-text-bg max-w-16  text-center  "><?php echo e($foreignExchangeRate->getToCurrency()); ?></td>
                                                <td class="sub-text-bg max-w-16  text-center  "><?php echo e(number_format($foreignExchangeRate->getExchangeRate(),4)); ?></td>
                                                <td class="sub-text-bg max-w-16  text-center  "><?php echo e(number_format(1/$foreignExchangeRate->getExchangeRate(),4)); ?></td>
												<?php if(hasAuthFor('update foreign exchange rate') || hasAuthFor('delete foreign exchange rate')): ?>
                                                <td class="sub-text-bg   text-center max-w-action   ">
                                                    <?php if($loop->first): ?>
													<?php if(hasAuthFor('update foreign exchange rate')): ?>
                                                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.foreign.exchange.rate',[$company,$foreignExchangeRate->id])); ?>"><i class="fa fa-pen-alt"></i></a>
													<?php endif; ?> 
													<?php if(hasAuthFor('delete foreign exchange rate')): ?>
                                                    <a class="btn btn-secondary btn-outline-hover-danger btn-icon  " href="#" data-toggle="modal" data-target="#modal-delete-<?php echo e($foreignExchangeRate['id']); ?>" title="Delete"><i class="fa fa-trash-alt"></i>
                                                    </a>
													<div id="modal-delete-<?php echo e($foreignExchangeRate['id']); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><?php echo e(__('Delete Foreign Exchange ' .$foreignExchangeRate->getDateFormatted())); ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3><?php echo e(__('Are You Sure To Delete This Item ? ')); ?></h3>
                                                                </div>
                                                                <form action="<?php echo e(route('delete.foreign.exchange.rate',[$company,$foreignExchangeRate->id])); ?>" method="post" id="delete_form">
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
                                                    <?php endif; ?>

                                                    

                                                </td>
												<?php endif; ?> 
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


    <!--End:: Tab Content-->



    <!--End:: Tab Content-->
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script>

</script>



<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'purchase_order_date') {
            modal.find('.data-type-span').html('[<?php echo e(__("Purchase Order Date")); ?>]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'issuance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Issuance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Issuance Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {
        $('.js-search-modal').trigger('change')
    })


    $("button[data-dismiss=modal2]").click(function() {
        $(this).closest('.modal').modal('hide');
    });

</script>
<script>
    $(document).on('change', '.recalculate-amount-in-main-currency', function() {
        const parent = $(this).closest('.modal-body');
        const amount = parseFloat($(parent).find('.amount-js').val())
        const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
        const amountInMainCurrency = parseFloat(amount * exchangeRate);
        $(parent).find('.amount-in-main-currency-js-hidden').val(amountInMainCurrency)
        $(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
    })
    $(document).on('change', 'select.update-net-balance-inputs', function() {
        const selectedOption = $(this).find('option:selected')
        const currency = $(selectedOption).attr('data-currency')
        const netBalance = $(selectedOption).attr('data-invoice-net-balance')
        const exchangeRate = $(selectedOption).attr('data-exchange-rate')
        const netBalanceInMainCurrency = $(selectedOption).attr('data-invoice-net-balance-in-main-currency');
        const parent = $(this).closest('.modal-body')
        $(parent).find('.net-balance').val(number_format(netBalance) + ' ' + currency)
        $(parent).find('.exchange-rate').val(number_format(exchangeRate, 2))
        $(parent).find('.net-balance-in-main-currency').val(number_format(netBalanceInMainCurrency))
    })
    $('select.update-net-balance-inputs').trigger('change')

</script>

<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })
    $('.m_repeater_9').repeater({
        initEmpty: false
        , isFirstItemUndeletable: true
        , defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();

            $('input.trigger-change-repeater').trigger('change')
            $(document).find('.datepicker-input:not(.only-month-year-picker)').datepicker({
                dateFormat: 'mm-dd-yy'
                , autoclose: true
            })

            $('input:not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");

        },

        hide: function(deleteElement) {
            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement, function() {

                        deleteElement();
                        $('input.trigger-change-repeater').trigger('change')

                    });
                }
            }
        }
    });

</script>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script>
$(document).on('click','.currency-change-js',function(){
	let currentCurrency = $(this).attr('data-currency');
	console.log(currentCurrency)
	$('#from-currency').val(currentCurrency).trigger('change');
})
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/foreign-exchange-rate/foreign-exchange-rate.blade.php ENDPATH**/ ?>