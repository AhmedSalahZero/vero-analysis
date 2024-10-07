@props([
	'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true 
])
<div class="col-md-12 {{ $parentClass }}  js-parent-to-table" style="display:none">
    <hr style="width:100%;">
    <table @if($initialJs) id="{{ $repeaterId }}"  @endif class="table  {{ $repeaterId }} table-white repeater-class repeater {{ $tableName }}"  >
        <thead>
            <tr>
                <x-tables.repeater-table-th class="col-md-1 action-class" :title="__('Action')"></x-tables.repeater-table-th>
                {{ $ths }}

            </tr>
        </thead>
        <tbody data-repeater-list="{{$tableName}}"
	
		>

            @if(isset($model) && $model->{$relationName}->count() )

            @foreach($model->{$relationName} as $subModel)
            <x-tables.repeater-table-tr :isRepeater="true" :model="$subModel"></x-tables.repeater-table-tr>

            @endforeach
            @else
            <x-tables.repeater-table-tr :trs="$trs" :isRepeater="true">

            </x-tables.repeater-table-tr>


            @endif

        </tbody>

        <td>
			{{-- @if(!$isRepeater) --}}
            <div  data-repeater-create="" class="btn btn btn-sm text-white   border-green bg-green  m-btn m-btn--icon m-btn--pill m-btn--wide {{__('right')}}" id="add-row">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        {{ __('Add') }}
                    </span>
                </span>
            </div>
			{{-- @endif --}}
        </td>

    </table>
</div>
@if($initialJs)
@push('js_end')
	<script>
	$('#'+"{{ $repeaterId }}").repeater({            
            initEmpty: false,
              isFirstItemUndeletable: true,
            defaultValues: {
                'text-input': 'foo'
            },
             
            show: function() {
				var appendNewOptionsToAllSelects = function (currentRepeaterItem) {
	
		if ($('[data-modal-title]').length) {
			
			let currentSelect = $(currentRepeaterItem).find('select').attr('data-modal-name')
			let modalType = $(currentRepeaterItem).find('select').attr('data-modal-type')
			let selects = {}
			$('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"] option').each(function (index, option) {
				selects[$(option).attr('value')] = $(option).html()
			})

			$('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"]').each(function (index, select) {
				var selectedValue = $(select).val()
				var currentOptions = ''
				var currentOptionsValue = []
				$(select).find('option').each(function (index, option) {
					var currentOption = $(option).attr('value')
					var isCurrentSelected = currentOption == selectedValue ? 'selected' : ''
					currentOptions += '<option value="' + currentOption + '" ' + isCurrentSelected + ' > ' + $(option).html() + ' </option>'
					currentOptionsValue.push(currentOption)
				})
				for (var allOptionValue in selects) {
					if (!currentOptionsValue.includes(allOptionValue)) {
						var isCurrentSelected = false
						currentOptions += '<option value="' + allOptionValue + '" ' + isCurrentSelected + ' > ' + selects[allOptionValue] + ' </option>'
						currentOptionsValue.push(allOptionValue)
					}
				}
				$(select).empty().append(currentOptions).selectpicker('refresh').trigger('change')

			})
		}
	}
                $(this).slideDown();      
				$('input.trigger-change-repeater').trigger('change')   
				 $(this).find('.only-month-year-picker').each(function(index,dateInput){
					reinitalizeMonthYearInput(dateInput)
				 });
				 $(document).find('.datepicker-input:not(.only-month-year-picker)').datepicker({
                            dateFormat: 'mm-dd-yy'
                            , autoclose: true
                        })
				$('input:not([type="hidden"])').trigger('change');
				$(this).find('.dropdown-toggle').remove();
				$(this).find('select.repeater-select').selectpicker("refresh");
						appendNewOptionsToAllSelects(this)
            },

            hide: function(deleteElement) {
                if($('#first-loading').length){
                        $(this).slideUp(deleteElement,function(){
                   
                               deleteElement();
                            //   $('select.main-service-item').trigger('change');
                    });
                }
                else{
                     if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement,function(){
                   
                               deleteElement();
                              $('select.main-service-item').trigger('change');
							$('input.trigger-change-repeater').trigger('change')                         
							  
                    });
                }         
                }
                       }
        });
	</script>
@endpush
@endif 
