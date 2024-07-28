

<div class="modal fade " id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">
		
								
		@csrf
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"> {{ $title }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
							
								
                                <th class="text-center w-60-percentage text-capitalize">{{ __('Financial Institution / Branch Name') }}</th>
                                <th class="text-center w-20-percentage text-capitalize">{{ __('Account Number') }}</th>
                                <th class="text-center w-20-percentage text-capitalize"> {!! __('Amount') !!} </th>
								
							
                            
                            </tr>
                        </thead>
                        <tbody>
						
							@php
								$total = 0 ;
								
								
							@endphp
                            @foreach($detailItems as $detailItem)
							
                       
                            <tr>
                               
					
                                <td class="w-60-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="{{  isset($detailItem['branch_name']) ? $detailItem['branch_name'] : $detailItem['financial_institution_name'] }}">
                                        </div>
                                    </div>
                                </td>
								
								 <td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="{{   $detailItem['account_number'] ?? '-' }}">
                                        </div>
                                    </div>
                                </td>
								

                                <td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="{{ number_format($detailItem['amount']) }}">
											@php
												$total +=$detailItem['amount'];
											@endphp
                                        </div>
                                    </div>
                                </td>

                              
								
								
								    
								

                            

                            </tr>
                         @endforeach
						 <tr>
						 	<td>
							
							</td>
							
							
							<td>
							
							</td>
							<td class="text-center">
							
							{{ number_format($total) }}
							</td>
						
							
						 </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary 
				{{-- submit-form-btn --}}
				"
				 data-dismiss="modal"
				 
				 >{{ __('Close') }}</button>
            </div>
        </form>
    </div>
</div>
