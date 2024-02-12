@props([
'selectedBanks','banks','hasBatchCollection','hasSearch','moneyReceivedType','searchFields'
,'financialInstitutionBanks',
'isFirstExportMoney'=>false
])
<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
			@if($hasBatchCollection)
            <a  data-type="multi" data-toggle="modal" data-target="#send-to-under-collection-modal" id="js-send-to-under-collection-trigger" href="{{route('create.money.receive',['company'=>$company->id])}}" title="{{ __('Please Select More Than One Cheque') }}" class="btn  active-style btn-icon-sm js-can-trigger-cheque-under-collection-modal disabled">
                <i class="fas fa-book"></i>
                {{ __('Create Batch Send To Collection') }}
            </a>
			@endif 
				@if($hasSearch)
            <a  data-type="multi" data-toggle="modal" data-target="#search-money-modal-{{ $moneyReceivedType }}" id="js-search-money-received" href="#" title="{{ __('Search Money Received') }}" class="btn  active-style btn-icon-sm  ">
                <i class="fas fa-search"></i>
                {{ __('Search') }}
            </a>
	
			<div class="modal fade" id="search-money-modal-{{ $moneyReceivedType }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle">{{ __('Search Form') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <form action="{{ route('view.money.receive',['company'=>$company->id]) }}"  class="row ">
                            <input name="active" type="hidden" value="{{ $moneyReceivedType }}">
                                <div class="form-group col-4" >
                                    <label for="Select Field " class="label">{{ __('Field Name') }}</label>
                                    <select id="js-search-modal-name-{{ $moneyReceivedType }}" data-type="{{ $moneyReceivedType }}" class="form-control js-search-modal" type="date" name="field" placeholder="{{ __('Delete From') }}">
									@foreach($searchFields as $name=>$value)
										<option @if(Request('field') == $name) selected @endif value="{{ $name }}">{{ $value }}</option>
										@endforeach 
									</select>
                                </div>
								<div class="form-group col-4" >
                                    <label for="Select Field " class="label">{{ __('Search Text') }}</label>
									<input name="value" type="text" value="{{ request('value') }}" placeholder="{{ __('Search Text') }}" class="form-control search-field" >
                                </div>
								
								<div class="form-group col-2" >
                                    <label for="search-from " class="label">{{ __('From') }} <span class="data-type-span">{{ __('[ Receiving Date ]') }}</span> </label>
									<input name="from"  type="date" value="{{ request('from') }}" class="form-control">
                                </div>
								
								<div class="form-group col-2" >
                                    <label for="search-to " class="label">{{ __('To') }} <span class="data-type-span">{{ __('[ Receiving Date ]') }}</span>  </label>
									<input name="to"  type="date" value="{{ request('to') }}" class="form-control">
	
                                </div>
								
								

                        <div class="modal-footer">
                            <button type="submit" href="{{ route('view.money.receive',['company'=>$company->id]) }}" id="js-search-id" type="submit" id="" class="btn btn-primary">{{ __('Search') }}</button>
                        </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			
			@endif 
			
			
			


            <div class="modal fade" id="send-to-under-collection-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="ajax-send-cheques-to-collection-id" class="ajax-send-cheques-to-collection" action="{{ route('cheque.send.to.collection',['company'=>$company->id]) }}" method="post">
                            <input type="hidden" id="single-or-multi" value="single">
                            <input type="hidden" id="current-single-item" value="0">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Send This Cheque / Cheques To Under Collection ?') }}</h5>
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>{{__('Cheque Deposit Date')}}</label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <input required type="text" name="cheque_deposit_date" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									
									     <div class="col-md-9 mb-3">
                                        <label>{{__('Drawal Bank')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date ">
                                                <select required name="cheque_drawl_bank_id" class="form-control js-drawl-bank">
                                                    @foreach($financialInstitutionBanks as $bankId=>$bankName)
                                                    <option value="{{ $bankId }}" {{ isset($model) && $model->getDraweeBankId() == $bankId ? 'selected':'' }}>{{ $bankName }}</option>
                                                    @endforeach
                                                    {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                                    {{-- <option>{{__('Bank 1')}}</option> --}}
                                                </select>
                                                {{-- <div class="modal fade" id="js-choose-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select Bank') }}</h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <select id="js-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                                                    @foreach($banks as $bankId => $bankEnAndAr)
                                                                    <option data-name="{{ $bankEnAndAr }}" value="{{ $bankId }}">{{ $bankEnAndAr }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary js-close-modal">{{ __('Close') }}</button>
                                                                <button id="js-append-bank-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button id="js-drawee-bank" class="btn btn-sm btn-primary">Add New Bank</button> --}}

                                            </div>
                                        </div>
                                    </div>
									
                                </div>
                                <div class="row mb-3">


                               
                                    <div class="col-md-3 mb-3">
                                        <label>{{__('Main Account Number')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input required type="text" name="cheque_main_account_number" class="form-control" placeholder="{{__('Main Account Number')}}">
                                            <x-tool-tip title="{{__('Kash Vero')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>{{__('Sub Account Number')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input required type="text" name="cheque_sub_account_number" class="form-control" placeholder="{{__('Main Account Number')}}">
                                            <x-tool-tip title="{{__('Kash Vero')}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>{{__('Account Balance')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input required value="0" type="text" name="cheque_account_balance" class="form-control" placeholder="{{__('Account Balance')}}">
                                            <x-tool-tip title="{{__('Kash Vero')}}" />
                                        </div>
                                    </div>
									 <div class="col-md-3 mb-3">
                                        <label>{{__('Clearance Days')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input required  name="cheque_clearance_days" step="any" min="0" class="form-control only-greater-than-zero-or-equal-allowed" placeholder="{{__('Clearance Days')}}">
                                            <x-tool-tip title="{{__('Kash Vero')}}" />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 mb-3">
                                        <label>{{__('Due After (Days)')}}</label>
                                        <div class="kt-input-icon">
                                            <input required type="number" name="cheque_expected_collection_date" min="0" class="form-control" placeholder="{{__('Due After (Days)')}}">
                                            <x-tool-tip title="{{__('Kash Vero')}}" />
                                        </div>
                                    </div> --}}
                                   

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">{{ __('Confirm') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            {{-- <a href="{{route('create.money.receive',['company'=>$company->id])}}" class="btn  active-style btn-icon-sm ">
                <i class="fas fa-plus"></i>
                {{ __('New Record') }}
            </a> --}}



            {{-- @endif --}}

        </div>
    </div>
</div>
