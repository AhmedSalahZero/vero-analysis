 @if($model->isRunning())



 <a data-toggle="modal" data-target="#apply-expense-{{ $model->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Expenses') }}" href="#"><i class=" fa fa-balance-scale"></i></a>
 <div class="modal fade" id="apply-expense-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="{{ route('apply.lc.issuance.expense',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id]) }}" method="post">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Apply Expenses' )  }}</h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">


                         @include('reports.LetterOfCreditIssuance.popup-form')







                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th>{{ __('#') }}</th>
                                             <th>{{ __('Expense Name') }}</th>
                                             <th>{{ __('Date') }}</th>
                                             <th>{{ __('Amount') }}</th>
                                             <th>{{ __('Actions') }}</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach($model->expenses as $index=>$expense)
                                         <tr>
                                             <td> {{ ++$index }} </td>
                                             <td>{{$expense->getName() }}</td>
                                             <td class="text-nowrap">{{$expense->getDateFormatted() }}</td>
                                             <td> {{ $expense->getAmountFormatted() }} </td>
                                             <td>
                                                 <a data-toggle="modal" data-target="#edit-expense-{{ $expense->id }}" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()]) }}"><i class="fa fa-pen-alt"></i></a>










                                                 <a data-toggle="modal" data-target="#delete-lc-issuance-expense{{ $expense->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>


                                             </td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>

                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                     <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                 </div>

             </form>

             @foreach($model->expenses->sortBy('date') as $index=>$expense)
             <div class="modal fade" id="edit-expense-{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">


                 <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="{{ route('update.lc.issuance.expense',['company'=>$company->id,'expense'=>$expense->id ]) }}" method="post">
                             @csrf
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Expenses To' )  }}</h5>
                                 <button data-dismiss="modal2" type="button" class="close" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>


                             <div class="modal-body">
                                 <div class="row mb-3">

                                     @include('reports.LetterOfCreditIssuance.popup-form',['submodel'=>$expense])



                                 </div>
                             </div>


                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal2">{{ __('Close') }}</button>
                                 <button type="submit" class="btn btn-primary submit-form-btn">{{ __('Confirm') }}</button>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>





             <div class="modal fade" id="delete-lc-issuance-expense{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="" method="post">
                             @csrf
                             @method('delete')
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                 <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal2">{{ __('Close') }}</button>

                                 <a href="{{ route('delete.lc.issuance.expense',['company'=>$company->id,'expense'=>$expense->id]) }}" class="btn btn-danger">{{ __('Confirm Delete') }}</a>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>

             @endforeach

           
         </div>
     </div>
 </div>





 <a data-toggle="modal" data-target="#cancel-deposit-modal-{{ $model->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Apply payment') }}" href="#"><i class="fa fa fa-ban"></i></a>
 <div class="modal fade" id="cancel-deposit-modal-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="{{ route('make.letter.of.credit.issuance.as.paid',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource() ]) }}" method="post">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Cancel This Letter ?') }}</h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         <div class="col-md-6 mb-4">
                             <label>{{__('Bank Name')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getFinancialInstitutionBankName()  }}" type="text" class="form-control">
                             </div>
                         </div>

                         <div class="col-md-3 mb-4">
                             <label>{{__('LC Amount')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getLcAmount()  }}" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>

                         <div class="col-md-3 mb-4">
                             <label>{{__('Date')}}</label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="payment_date" value="{{ formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                     <button type="submit" class="btn btn-danger">{{ __('Confirm') }}</button>
                 </div>

             </form>
         </div>
     </div>
 </div>
 @elseif($model->isPaid())

 <a data-toggle="modal" data-target="#back-to-running-modal-{{ $model->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Back To Running') }}" href="#"><i class="fa fa fa-undo"></i></a>

 <div class="modal fade" id="back-to-running-modal-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="{{ route('back.to.running.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource() ]) }}" method="post">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Back This Letter To Running Status ?') }}</h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         <div class="col-md-6 mb-4">
                             <label>{{__('Bank Name')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getFinancialInstitutionBankName()  }}" type="text" class="form-control">
                             </div>
                         </div>

                         <div class="col-md-3 mb-4">
                             <label>{{__('LC Amount')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getLcAmount()  }}" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>
                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                     <button type="submit" class="btn btn-success">{{ __('Confirm') }}</button>
                 </div>

             </form>
         </div>
     </div>
 </div>


 @endif
