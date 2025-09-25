@props([
'subModel',
'title'=>__('Collection Policy')
])

<script>
 var translations = {
        deleteConfirm: @json(__('Are you sure you want to delete this position?'))
    };
	</script>
<div class="modal collection-modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-blue" id="exampleModalLongTitle">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('Payment Rate %') }}</th>
                                <th class="text-center">{{ __('Due In Days') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($rateIndex= 0 ;$rateIndex<5 ; $rateIndex++) <tr>
                                <td >
								<div class="max-w-selector-popup">
                                    <input multiple name="payment_rate" class="form-control only-percentage-allowed rate-element" value="{{ isset($subModel) ? $subModel->getPaymentRate($rateIndex) :  0 }}" placeholder="{{ __('Rate') .  ' ' . $rateIndex }}">
                                    {{-- <input multiple class="rate-element-hidden" type="hidden" value="{{ (isset($subModel) ? $subModel->getPaymentRate($rateIndex) : 0) }}" > --}}
								</div>
                                </td>
                                <td>
								<div class="">
									<x-select.due-days-selector :id="$rateIndex" :name="'due_days'" :selectedOption="isset($subModel) ? $subModel->getPaymentRateAtDueInDays($rateIndex) : ''" :options="dueInDays()"></x-select.due-days-selector>
                                 
								</div>
                                </td>
                                </tr>
                                @endfor
								<tr style="border-top:1px solid gray;padding-top:5px;text-align:center">
									<td class="td-for-total-payment-rate " disabled readonly>
										0
									</td>
									<td class="">-</td>
								</tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn save-modal btn-primary" data-dismiss="modal">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
