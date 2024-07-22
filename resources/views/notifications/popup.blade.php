
@push('js')
	<script>
		$(document).on('click','[data-show-notification-modal="{{ $notificationMainType }}"]',function(e){
			e.preventDefault();
			$('.{{ $notificationMainType }}-modal').modal('show');
		})
	</script>
@endpush

@php
	$customerPastDues = $company->notifications->where('data.type',$notificationMainType);
	$notificationHeaders = $customerPastDues->first() ? array_keys($customerPastDues->first()->data['data_array']) : [];
	

@endphp
<div class="modal fade notification-modal {{ $notificationMainType }}-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">


            @csrf
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle">{{ $notificationMainTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
								@foreach($notificationHeaders as $notificationHeader)
                                <th class="text-center"> {!! __($notificationHeader) !!} </th>
								@endforeach
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($customerPastDues  as $customerPastDue)
                            <tr>
							
								@foreach($notificationHeaders as $notificationHeader)
							
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="{{ $customerPastDue['data']['data_array'][$notificationHeader] ??'---' }}">
                                        </div>
                                    </div>
                                </td>
								@endforeach 




                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary 
				{{-- submit-form-btn --}}
				" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </form>
    </div>
</div>
