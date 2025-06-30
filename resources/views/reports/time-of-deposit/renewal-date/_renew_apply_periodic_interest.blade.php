  <a
											
											 data-toggle="modal" data-target="#apply-periodic-interest-modal-{{ $model->id }}" type="button" class="btn 
											 
											 {{-- @if($model->isDueTodayOrGreater())
											 disabled 
											@endif  --}}
											 
											  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Apply Periodic Interest') }}" href="#"><i class="fa fa-bolt"></i></a>
											  
											 
                                            <div class="modal fade" id="apply-periodic-interest-modal-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('apply.period.interest.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id ]) }}" method="post">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-left" id="exampleModalLongTitle">{{ __('Do You Want To Apply Periodic Interest To This Time Of Deposit ?') }}</h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">

                                                                    <div class="col-md-6 mb-4">
                                                                        <label>{{__('Interest Amount')}} </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="{{ $model->isMatured() ? $model->getActualInterestAmount() : $model->getInterestAmount() }}" type="text" name="periodic_interest_amount" class="form-control only-greater-than-or-equal-zero-allowed">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6 mb-4">
                                                                        <label>{{__('Deposit Date')}}</label>
                                                                        <div class="kt-input-icon">
                                                                            <div class="input-group date">
                                                                                <input required type="text" name="periodic_interest_date" value="{{ formatDateForDatePicker($model->getEndDate()) }}" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
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
                                                                <a href="{{ route('view.period.interest.to.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'timeOfDeposit'=>$model->id]) }}" type="button" class="btn btn-primary" >{{ __('View Periodic Interests') }}</a>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn bg-green text-white">{{ __('Confirm') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
