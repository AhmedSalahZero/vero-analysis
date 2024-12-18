@props([
'hasSearch','moneyReceivedType','searchFields',
'isFirstExportMoney'=>false,
'partnerId','modelType'
])

<div class="kt-portlet__head-toolbar" style="flex:1 !important;">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            
            @if($hasSearch)
            <a data-type="multi" data-toggle="modal" data-target="#search-money-modal-{{ $moneyReceivedType }}" id="js-search-money-received" href="#" title="{{ __('Search Settlements') }}" class="btn  active-style btn-icon-sm  ">
                <i class="fas fa-search"></i>
                {{ __('Advanced Filter') }}
            </a>

            <div class="modal fade" id="search-money-modal-{{ $moneyReceivedType }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_from_to_modalTitle">{{ __('Filter Form') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <form action="{{ route('view.settlement.by.unapplied.amounts',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType]) }}" class="row ">
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label">{{ __('Field Name') }}</label>
                                    <select id="js-search-modal-name-{{ $moneyReceivedType }}" data-type="{{ $moneyReceivedType }}" class="form-control js-search-modal" type="date" name="field" placeholder="{{ __('Delete From') }}">
                                        @foreach($searchFields as $name=>$value)
                                        <option @if(Request('field')==$name) selected @endif value="{{ $name }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Select Field " class="label">{{ __('Search Text') }}</label>
                                    <input name="value" type="text" value="{{ request('value') }}" placeholder="{{ __('Search Text') }}" class="form-control search-field">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-from " class="label">{{ __('From') }} <span class="data-type-span">{{ __('[ Settlement Date ]') }}</span> </label>
                                    <input name="from" type="date" value="{{ request('from') }}" class="form-control">
                                </div>

                                <div class="form-group col-2">
                                    <label for="search-to " class="label">{{ __('To') }} <span class="data-type-span">{{ __('[ Settlement Date ]') }}</span> </label>
                                    <input name="to" type="date" value="{{ request('to') }}" class="form-control">

                                </div>



                                <div class="modal-footer">
                                    <button type="submit" href="{{ route('view.settlement.by.unapplied.amounts',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType]) }}" id="js-search-id" type="submit" id="" class="btn btn-primary">{{ __('Search') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @endif






        </div>
    </div>
</div>
