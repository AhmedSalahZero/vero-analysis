<div class="col-lg-3" data-dd="{{ isset($lendingInformationAgainstAssignmentOfContract) ? 1 : -1 }}">
    <label>{{__('Select Customer')}} @include('star')</label>
    <div class="input-group">
        <select data-live-search="true" name="customer_id" class="form-control kt-bootstrap-select select2-select select2 ajax-get-contracts-for-customer-{{ isset($lendingInformationAgainstAssignmentOfContract) ? 'edit' : 'create' }}">
            @foreach($customers as $customerId => $customerName )
            <option value="{{ $customerId  }}" @if(isset($lendingInformationAgainstAssignmentOfContract) && $lendingInformationAgainstAssignmentOfContract->getCustomerId() == $customerId ) selected  @endif > {{ $customerName }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-3">
    <label>{{__('Select Contract')}} @include('star')</label>
    <div class="input-group">
        <select name="contract_id" class="form-control append-contracts-{{ isset($lendingInformationAgainstAssignmentOfContract) ? 'edit' : 'create' }}">
            {{-- <option selected>{{__('Select')}}</option> --}}
			@if(isset($lendingInformationAgainstAssignmentOfContract))
			@foreach(\App\Models\Contract::getForParentAndCurrency($lendingInformationAgainstAssignmentOfContract->getCustomerId()   , $odAgainstAssignmentOfContract->getCurrency() ) as $contract)
			<option value="{{ $contract->id }}"> {{ $contract->getName() }} </option>
			@endforeach 
			@endif 
        </select>
    </div>
</div>

<div class="col-md-2">
    <label>{{__('Start Date')}} </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input disabled type="date" value="{{ isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getContractStartDate() : '' }}" class="form-control contract-start-date-class-{{ isset($lendingInformationAgainstAssignmentOfContract) ? 'edit' : 'create' }}" />
        </div>
    </div>
</div>
<div class="col-md-2">
    <label>{{__('End Date')}} </label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input disabled type="date" value="{{ isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getContractEndDate() : '' }}" class="form-control contract-end-date-class-{{ isset($lendingInformationAgainstAssignmentOfContract) ? 'edit' : 'create' }}" />
        </div>
    </div>
</div>

<div class="col-md-2 mb-4 ">

    <label class="form-label font-weight-bold">{{ __('Lending Rate %') }} </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input type="number" class="form-control only-percentage-allowed" name="lending_rate" value="{{ isset($lendingInformationAgainstAssignmentOfContract) ? $lendingInformationAgainstAssignmentOfContract->getLendingRate() : '' }}" step="any">
        </div>
    </div>
</div>
