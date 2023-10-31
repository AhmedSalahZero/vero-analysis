{{-- <div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            @if ($href != '#')
                <a href={{$href}} class="btn active-style btn-icon-sm {{$class}}">
<i class="fas fa-{{$icon}}"></i>
{{ __($firstButtonName) }}
</a>
@endif
@if ($importHref != '#')
<a href={{$importHref}} class="btn  active-style btn-icon-sm {{$class}}">
    <i class="fas fa-file-import"></i>
    {{ __('Upload Data') }}
</a>
@endif
@if ($exportHref != '#')
<a href={{$exportHref}} class="btn  active-style btn-icon-sm {{$class}}">
    <i class="fas fa-file-export"></i>
    {{ __('Export Data') }}
</a>
@endif
@if ($exportTableHref != '#')
<a href={{$exportTableHref}} class="btn  active-style btn-icon-sm {{$class}}">
    <i class="fas fa-file-export"></i>
    {{ __('Template Download') }}
</a>
@endif
@if ($truncateHref != '#')
<a data-toggle="modal" data-target="#exampleModalCenter" href={{$truncateHref}} class="btn  active-style btn-icon-sm {{$class}}">
    <i class="fas fa-file-export"></i>
    {{ __('Delete All Data') }}
</a>
@endif
</div>
</div>
</div> --}}


<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            &nbsp;
            @if ($href != '#')
            <a href={{$href}} class="btn  active-style btn-icon-sm {{$class}}">
                <i class="fas fa-{{$icon}}"></i>
                {{ __($firstButtonName) }}
            </a>
            @endif
            @if ($importHref != '#')
            <a href={{$importHref}} class="btn  active-style btn-icon-sm {{$class}}">
                <i class="fas fa-file-import"></i>
                {{ __('Upload Data') }}
            </a>
            @endif

            @if (isset($lastUploadFailedHref) && $lastUploadFailedHref != '#')
            <a href={{$lastUploadFailedHref}} class="btn  btn-danger btn-icon-sm {{$class}}">
                <i class="fas fa-file-import"></i>
                {{ __('Last Upload Failed Rows') }}
            </a>
            @endif

            @if ($exportHref != '#')
            <a href={{$exportHref}} class="btn  active-style btn-icon-sm {{$class}}">
                <i class="fas fa-file-export"></i>
                {{ __('Export Data') }}
            </a>
            @endif
            @if ($exportTableHref != '#')
            <a href={{$exportTableHref}} class="btn  active-style btn-icon-sm {{$class}}">
                <i class="fas fa-file-export"></i>
                {{ __('Template Download') }}
            </a>
            @endif
           
		    @if ($truncateHref != '#')
            <a href="{{ route('create.sales.form',['company'=>$company->id , 'model'=>getLastSegmentInRequest()]) }}" class="btn  active-style btn-icon-sm {{$class}}" >
                <i class="fas fa-file-export"></i>
                {{ __('Create By Form') }}
            </a>
			
		   
		    <a href={{$truncateHref}} class="btn  active-style btn-icon-sm {{$class}}" data-toggle="modal" data-target="#delete_from_to_modal">
                <i class="fas fa-file-export"></i>
                {{ __('Delete By Date') }}
            </a>

            {{-- <form action="{{ route('delete.export.from.to',['company'=>$company->id]) }}" method="delete"> --}}
                <div class="modal fade" id="delete_from_to_modal" tabindex="-1" role="dialog" aria-labelledby="delete_from_to_modalTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="delete_from_to_modalTitle">{{ __('Delete Between Two Dates') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input id="js-upload-type" type="hidden"  value="{{ getSegmentBeforeLast() }}">
                                @csrf
                                <div class="row ">
                                    <div class="form-group" style="margin-right:15px;">
                                        <label for="delete_from_id" class="label">{{ __('From') }}</label>
                                        <input id="js-delete-date-from" class="form-control" id="delete_from_id" type="date" name="delete_from_date" placeholder="{{ __('Delete From') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="delete_To_id" class="label">{{ __('To') }}</label>
                                        <input id="js-delete-date-to" class="form-control" id="delete_To_id" type="date" name="delete_to_date" placeholder="{{ __('Delete To') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" id="js-delete_from_to" type="submit" id="" class="btn btn-danger">{{ __('Delete') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

            <a href={{$truncateHref}} class="btn  active-style btn-icon-sm {{$class}}">
                <i class="fas fa-file-export"></i>
                {{ __('Delete All Data') }}
            </a>
            @endif
        </div>
    </div>
</div>

@push('js')
@if(isset($company))
	<script>
		$(document).on('click','#js-delete_from_to',function(e){
			e.preventDefault();
			const dateFrom = $('#js-delete-date-from').val();
			const dateTo = $('#js-delete-date-to').val();
				if(!dateFrom){
				Swal.fire({
                                    text: '{{ __("Please Enter Date From") }}'
                                    , icon: 'warning'
                                });
								return ;
			}
			if(!dateTo){
				Swal.fire({
                                    text: '{{ __("Please Enter Date To") }}'
                                    , icon: 'warning'
                                })
								return ;
								
			}
			if(dateFrom && dateTo){
				const url = $('#js-upload-type').val() == 'uploading'  ? "{{ route('multipleRowsDelete',['company'=>$company->id , 'model'=>getLastSegmentInRequest()]) }}" : "{{ route('deleteMultiRowsFromCaching',['company'=>$company->id,'modelName'=>getLastSegmentInRequest()]) }}"
				console.log('url',url)
				$('#js-delete_from_to').prop('disabled',true)
	
					$.ajax({
						url:url,
						method:"delete",
						data:{
							"_token":"{{ csrf_token() }}",
							"delete_date_from":dateFrom,
							'delete_date_to':dateTo,
							'rows':[1] // for validation 
						}
					}).then(function(res){
				$('#js-delete_from_to').prop('disabled',false)
						
						Swal.fire({
                                    text: '{{ __("Date Has Been Deleted Successfully") }}'
                                    , icon: 'warning'
                                }).then(function(){
										window.location.reload();
								})
					});
				
			}
		})
	</script>
	@endif
@endpush
