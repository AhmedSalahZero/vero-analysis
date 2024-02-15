@if($financialInstitutionBank->accounts->count())
<div class="btn-group button-space mr-3">
    <button type="button" class="btn btn-outline-primary">
        {{__('Banks Accounts')}}
    </button>

    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(141px, 36px, 0px);">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#open-accounts-for-{{ $financialInstitutionBank->id }}">{{__('Show All')}}</a>
        <a class="dropdown-item" href="{{ route('financial.institution.add.account',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Add New')}}</a>
    </div>


    <div class="modal fade" id="open-accounts-for-{{ $financialInstitutionBank->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Accounts For') . ' ' . $financialInstitutionBank->getName() }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table ">
                        <thead>
                            <tr class="table-active">
                                <td>#</td>
                                <td>{{ __('Account Number') }}</td>
                                <td>{{ __('Currency') }}</td>
                                <td>{{ __('IBAN') }}</td>
                                <td>{{ __('Balance Amount') }}</td>
                                <td>{{ __('Is Main Account') }}</td>
                                <td>{{ __('Actions') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financialInstitutionBank->accounts as $key=>$account)
                            <tr>
                                <td>{{ $key + 1  }}</td>
                                <td>{{ $account->getAccountNumber() }}</td>
                                <td>{{ $account->getCurrency() }}</td>
                                <td>{{ $account->getIban() }}</td>
                                <td>{{ $account->getBalanceAmount() }}</td>
                                <td>{{ $account->isMainAccountFormatted() }}</td>
                                <td>
                                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.financial.institutions.account',['company'=>$company->id , 'financialInstitutionAccount'=>$account->id ]) }}"><i class="fa fa-pen-alt"></i></a>
                                    @if(!$account->isMainAccount())
                                    <a data-toggle="modal" data-target="#delete-account-{{ $account->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                    <div class="modal inner-modal fade" id="delete-account-{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('delete.financial.institutions.account',['company'=>$company->id,'financialInstitutionAccount'=>$account->id]) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                        <button type="button" class="close" data-dismiss-modal="inner-modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss-modal="inner-modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>






</div>
@endif

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
        <a class="dropdown-item" href="{{ route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Certificate Of Deposit "CDs"')}}</a>
        <a class="dropdown-item" href="#">{{__('Time Deposit "TDs"')}}</a>

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
        <a class="dropdown-item" href="{{ route('view.clean.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Clean Overdraft')}}</a>
        <a class="dropdown-item" href="{{ route('view.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Overdraft Aganist Commercial Papers')}}</a>
        <a class="dropdown-item" href="#">{{__('Overdraft Aganist Contracts Assignment')}}</a>
        <a class="dropdown-item" href="#">{{__('Discounting Cheques')}}</a>
        <a class="dropdown-item" href="{{ route('view.letter.of.guarantee.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Letter Of Guarantee')}}</a>
        <a class="dropdown-item" href="{{ route('view.letter.of.credit.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id]) }}">{{__('Letter Of Credit')}}</a>
        <a class="dropdown-item" href="#">{{__('Medium Term Loans')}}</a>
        <a class="dropdown-item" href="#">{{__('Direct Lease')}}</a>
        <a class="dropdown-item" href="#">{{__('Sales & Lease Back')}}</a>
        <a class="dropdown-item" href="#">{{__('Factoring Contracts')}}</a>

    </div>
</div>
