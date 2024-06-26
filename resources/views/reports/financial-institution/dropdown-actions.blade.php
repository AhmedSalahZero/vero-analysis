<div class="btn-group button-space mr-3">
    <button type="button" class="btn btn-outline-success">
        {{__('Add Debit Accounts')}}
    </button>
    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(141px, 36px, 0px);">
        {{-- <a class="dropdown-item" href="#">{{__('Current Account With Interest')}}</a> --}}
        {{-- <a class="dropdown-item" href="#">{{__('Saving Account')}}</a> --}}
        <a class="dropdown-item" href="{{ route('financial.institution.add.account',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Add Current Account')}}</a>
        <a class="dropdown-item" href="{{ route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Certificate Of Deposit "CDs"')}}</a>
        <a class="dropdown-item" href="{{ route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Time Deposit "TDs"')}}</a>

    </div>
</div>

<div class="btn-group">


    <button type="button" class="btn btn-outline-danger">
        {{__('Add Credit Facilities')}}
    </button>

    <button type="button" class="btn btn-outline-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only">{{ __('Toggle Dropdown') }}</span>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(141px, 36px, 0px);">
        <a class="dropdown-item" href="{{ route('view.fully.secured.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Fully Secured Overdraft')}}</a>
        <a class="dropdown-item" href="{{ route('view.clean.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Clean Overdraft')}}</a>
        <a class="dropdown-item" href="{{ route('view.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Overdraft Aganist Commercial Papers')}}</a>
        <a class="dropdown-item" href="{{ route('view.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Overdraft Aganist Contracts Assignment')}}</a>
        {{-- <a class="dropdown-item" href="#">{{__('Discounting Cheques')}}</a> --}}
        <a class="dropdown-item" href="{{ route('view.letter.of.guarantee.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Letter Of Guarantee')}}</a>
        <a class="dropdown-item" href="{{ route('view.letter.of.credit.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Letter Of Credit')}}</a>
        {{-- <a class="dropdown-item" href="{{ route('fixed.loan.fixed.at.end.php',['company'=>$company->id , 'financialInstitution'=>$financialInstitutionBank->id ]) }}">{{__('Medium Term Loans')}}</a> --}}
        {{-- <a class="dropdown-item" href="#">{{__('Direct Lease')}}</a>
        <a class="dropdown-item" href="#">{{__('Sales & Lease Back')}}</a>
        <a class="dropdown-item" href="#">{{__('Factoring Contracts')}}</a> --}}

    </div>
</div>
