                @php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                @endphp


                <div style="flex-wrap:nowrap;" @if($isRepeater) data-repeater-item @endif class="form-group date-element-parent m-form__group row align-items-center 
                                         @if($isRepeater)
                                         repeater_item
                                         @endif 
				                         ">
                    <input type="hidden" class="form-control " @if($isRepeater) name="id" @else name="accounts[0][id]" @endif value="{{ isset($account) ? $account->getId() : 0 }}">



                    <div class="col-2">
                        <label class="form-label font-weight-bold ">{{ __('Account Number') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input placeholder="{{ __('Account Number') }}" type="text" class="form-control  exclude-text" @if($isRepeater) name="account_number" @else name="accounts[0][account_number]" @endif value="{{ isset($account) ? $account->getAccountNumber() : old('account_number') }}">
                            </div>
                        </div>
                    </div>

                   

                    <div 
					 
					
					class="col-2"
			
					>
                        <label class="form-label font-weight-bold">{{ __('IBAN') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input @if($isRepeater) name="iban" @else name="accounts[0][iban]" @endif type="text" class="form-control " value="{{ isset($account) ? $account->getIban() : old('iban','') }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-2">
                        <label class="form-label font-weight-bold">{{ __('Balance Amount') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="{{ number_format(isset($account) ? $account->getBalanceAmount() : old('balance_amount',0)) }}">
                                <input type="hidden" value="{{ (isset($account) ? $account->getBalanceAmount() : old('balance_amount',0)) }}" @if($isRepeater) name="balance_amount" @else name="accounts[0][balance_amount]" @endif>
                            </div>
                        </div>
                    </div>


                    <div
					@if(isset($addStartDate) && $addStartDate)
					
					 class="col-1"
					 
					 @else
					 
					 class="col-2"
					 @endif 
					 >
                        <label>{{__('Currency')}} @include('star') </label>
                        <div class="input-group">
                            <select @if($isRepeater) name="currency" @else name="accounts[0][currency]" @endif class="form-control repeater-select">
                                <option selected>{{__('Select')}}</option>
                                @foreach(getCurrencies() as $currencyName => $currencyValue )
                                <option value="{{ $currencyName }}" @if(isset($account) && $account->getCurrency() == $currencyName ) selected @endif > {{ $currencyValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-1">
                        <label class="form-label font-weight-bold">{{ __('Exchange Rate') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input @if($isRepeater) name="exchange_rate" @else name="accounts[0][exchange_rate]" @endif type="text" class="form-control " value="{{ number_format(isset($account) ? $account->getExchangeRate() : old('exchange_rate',1)) }}">
                            </div>
                        </div>
                    </div>




                    <div class="col-1">
                        <label class="form-label font-weight-bold">{{ __('Interest Rate') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input @if($isRepeater) name="interest_rate" @else name="accounts[0][interest_rate]" @endif type="text" class="form-control " value="{{ number_format(isset($account) ? $account->getInterestRate() : old('interest_rate',0)) }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-1">
                        <label class="form-label font-weight-bold">{{ __('Min Balance') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="{{ number_format(isset($account) ? $account->getMinBalance() : old('min_balance',0)) }}">
                                <input type="hidden" value="{{ (isset($account) ? $account->getMinBalance() : old('min_balance',0)) }}" @if($isRepeater) name="min_balance" @else name="accounts[0][min_balance]" @endif>
                            </div>
                        </div>
                    </div>
					
					 @if(isset($addStartDate) && $addStartDate)
                    <div class="col-md-1">
                        <x-calendar :label="__('Start Date')"  :id="'start_date'" name="start_date"></x-calendar>
                    </div>
                    @endif


                    @if($isRepeater)
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                    @endif


                </div>
