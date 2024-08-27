<?php $attributes = $attributes->exceptProps([
'currencyName','total','color','customerName','showReport','invoiceType'
]); ?>
<?php foreach (array_filter(([
'currencyName','total','color','customerName','showReport','invoiceType'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if (! $__env->hasRenderedOnce('769c4f20-6e35-4049-9dec-2e1b6ef619f0')): $__env->markAsRenderedOnce('769c4f20-6e35-4049-9dec-2e1b6ef619f0'); ?>
<style>
    .report-flex {
        display: flex;
        gap: 5px;
        flex-direction: column;
    }

    .black-card-title-css {
        color: black !important;
        font-weight: 600 !important;
        font-size: 18px !important;
    }

</style>
<?php endif; ?>
<div class="col-md-6 col-lg-4 col-xl-4">
    <!--begin::Total Profit-->
    <div class="kt-widget24 text-center pb-0">
        <div class="kt-widget24__details">
            <div class="kt-widget24__info">
                <h4 class="kt-widget24__title font-size text-nowrap black-card-title-css">
                    <?php echo e(__('Total Balance In ' . $currencyName )); ?>

                </h4>

            </div>
            <?php if($showReport && $currencyName): ?>
            <div class="report-flex">
                <div class="kt-align-right ">
                    <a href="<?php echo e(route('show.total.net.balance.in',['company'=>$company->id , 'currency'=>$currencyName ,'modelType'=>$invoiceType   ])); ?>" type="button" class="d-flex ml-3 btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('All Invoices Report')); ?> </a>
                </div>

                <div class="kt-align-right ">
                    <a href="<?php echo e(route('show.total.net.balance.in',['company'=>$company->id , 'currency'=>$currencyName ,'modelType'=>$invoiceType,'only'=>'past_due'   ])); ?>" type="button" class="d-flex ml-3 btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Past Dues Report')); ?> </a>
                </div>
            </div>
			
			<?php else: ?> 


 <div class="report-flex 
 
 visibility-hidden
 
 ">
                <div class="kt-align-right ">
                    <a href="#" type="button" class="d-flex ml-3 btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </a>
                </div>

                <div class="kt-align-right ">
                    <a href="#" type="button" class="d-flex ml-3 btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> <?php echo e(__('Report')); ?> </a>
                </div>
            </div>
			
            <?php endif; ?>

        </div>
        <div class="kt-widget24__details">
            <span class="kt-widget24__stats kt-font-<?php echo e($color ?? 'brand'); ?>">
                <?php echo e(number_format($total)); ?>

            </span>
        </div>

        <div class="progress progress--sm">
            <div class="progress-bar kt-bg-<?php echo e($color ?? 'brand'); ?>" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="kt-widget24__action">

        </div>


    </div>

    <!--end::Total Profit-->
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/money-card.blade.php ENDPATH**/ ?>