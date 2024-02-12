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



                    <div class="col-4">
                        <label class="form-label font-weight-bold ">{{ __('Account Number') }}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input placeholder="{{ __('Account Number') }}" type="text" class="form-control  exclude-text" @if($isRepeater) name="account_number" @else name="accounts[0][account_number]" @endif value="{{ isset($account) ? $account->getAccountNumber() : old('account_number') }}">
                                {{-- <input type="hidden" class="form-control " @if($isRepeater) name="old_receivable_name" @else name="accounts[0][old_receivable_name]" @endif value="{{ isset($account) ? $account->getName() : old('old_receivable_name') }}"> --}}
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <label>{{__('Select Currency')}} <span class="required">*</span></label>
                        <div class="input-group">
                            <select @if($isRepeater) name="currency" @else name="accounts[0][currency]" @endif class="form-control repeater-select">
                                <option selected>{{__('Select')}}</option>
                                @foreach(getCurrencies() as $currencyName => $currencyValue )
                                <option value="{{ $currencyName }}" @if(isset($account) && $account->getCurrency() == $currencyName ) selected @endif > {{ $currencyValue }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <label class="form-label font-weight-bold">{{ __('Balance Amount') }}
                            {{-- @include('star') --}}
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="{{ number_format(isset($account) ? $account->getBalanceAmount() : old('balance_amount',0)) }}">
                                <input type="hidden" value="{{ (isset($account) ? $account->getBalanceAmount() : old('balance_amount',0)) }}" @if($isRepeater) name="balance_amount" @else name="accounts[0][balance_amount]" @endif>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="col-lg-3">
                        <label>{{__('Balance Date')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" @if($isRepeater) name="balance_date" @else name="accounts[0][balance_date]" @endif value="{{ isset($account) && $account->balance_date ? formatDateForDatePicker($account->getBalanceDate()) : null }}" class="form-control datepicker-input" readonly placeholder="{{ __('Select Balance Date') }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> --}}





                    @if($isRepeater)
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                    @endif


                </div>
