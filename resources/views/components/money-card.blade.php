@props([
'currencyName','total','color','customerName','showReport'
])
@once
<style>
    .black-card-title-css {
        color: black !important;
        font-weight: 600 !important;
        font-size: 18px !important;
    }

</style>
@endonce
<div class="col-md-6 col-lg-4 col-xl-4">

    <!--begin::Total Profit-->
    <div class="kt-widget24 text-center pb-0">
        <div class="kt-widget24__details">
            <div class="kt-widget24__info">
                <h4 class="kt-widget24__title font-size text-nowrap black-card-title-css">
                    {{ __('Total Balance In ' . $currencyName ) }}
                </h4>

            </div>
			@if($showReport)
            <div class="kt-align-right ">
                <a href="{{ route('show.total.net.balance.in',['company'=>$company->id , 'currency'=>$currencyName   ]) }}" type="button" class="d-flex ml-3 btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </a>
            </div>
			@endif

        </div>
        <div class="kt-widget24__details">
            <span class="kt-widget24__stats kt-font-{{ $color ?? 'brand' }}">
                {{ number_format($total) }}
            </span>
        </div>

        <div class="progress progress--sm">
            <div class="progress-bar kt-bg-{{ $color ?? 'brand' }}" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="kt-widget24__action">
            {{-- <span class="kt-widget24__change">
                                {{ __('Change') }}
            </span>
            <span class="kt-widget24__number">
                100%
            </span> --}}
        </div>


    </div>

    <!--end::Total Profit-->
</div>
