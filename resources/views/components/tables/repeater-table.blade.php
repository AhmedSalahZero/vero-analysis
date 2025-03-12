@props([
'repeater-with-select2'=>true,
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? '',
'initialJs'=>true ,
'initEmpty'=>false,
'firstElementDeletable'=>false,
'hideAddBtn'=>false,
'canAddNewItem'=>true,
'removeActionBtn'=>false,
'tableClass'=>'col-md-12',
'tableClasses'=>'',
'actionBtnTitle'=>__('Action'),
'appendSaveOrBackBtn'=>false,
'addExpenseName'=>false,
'showRows'=>true,
'departmentId'=>0,
'department'=>null ,
'fontSizeClass'=>'',
'addExpenseType'=>false
])
@php

$canAddNewItem = true;
@endphp

<div class="{{ $tableClass }} {{ $parentClass }}  js-parent-to-table" data-table-id="{{ $repeaterId??'' }}" style="display:none">

    @if($addExpenseName)
    <div class="row align-items-center mb-3 mt-3 border-bottom-green  ">
        <div class="col-md-4">
            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                {{ __('Department Name') }}
            </h3>
            <div class="form-group mb-0 d-flex" style="margin-right:auto;gap:20px;">
                <input readonly class="form-control" name="departments[{{ $departmentId }}][name]" value="{{ $department ? $department->getName():'' }}" placeholder="">
            </div>
        </div>

        @if($addExpenseType)
        <div class="col-md-2">


            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                {{ __('Expense Type') }}
            </h3>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
							<div class="form-group mb-0 d-flex" style="margin-right:auto;gap:20px;">
						<input readonly class="form-control"  value="{{ $department ? $department->getExpenseTypeName():'' }}" placeholder="">
					</div>
                       
                    </div>
                </div>
            </div>




        </div>
        @endif


        <div class="col-md-5">
         


        </div>

    </div>
    @endif
    @if($showRows)
    <table @if($initialJs) id="{{ $repeaterId }}" @endif class="table  {{ $repeaterId }} {{ $tableClasses }} table-white  repeater-class repeater {{ $tableName }}">
        <thead>
            <tr>
                @if(!$removeActionBtn)
                <x-tables.repeater-table-th :fontSizeClass="$fontSizeClass" class="col-md-1 action-class" :title="$actionBtnTitle"></x-tables.repeater-table-th>
                @endif
                {{ $ths }}

            </tr>
        </thead>
        <tbody data-repeater-list="{{$tableName}}">

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
            @if($canAddNewItem && !$removeActionBtn)
            <div data-repeater-create="" class="btn btn btn-sm text-white add-row   border-green bg-green  m-btn m-btn--icon m-btn--pill m-btn--wide {{__('right')}}">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        @if(!$hideAddBtn)
                        {{ __('Add') }}
                        @endif
                    </span>
                </span>
            </div>
            @endif
        </td>

    </table>
    @endif
    @if($appendSaveOrBackBtn)
    <x-save-or-back-inside-table :department="$department" :btn-text="__('Create')" />
    @endif
</div>

<input type="hidden" id="initi-empty-{{ $repeaterId }}" value="{{ $initEmpty }}">
<input type="hidden" id="first-element-deleteable-{{ $repeaterId }}" value="{{ $firstElementDeletable }}">
@if($initialJs)
@push('js_end')
<script>
    var initEmpty = $("#initi-empty-{{ $repeaterId }}").val() === "1" ? true : false;
    var firstElementDeleteable = $("#first-element-deleteable-{{ $repeaterId }}").val() === "1" ? true : false;
    var studyStartDate = $('#study-start-date').val()
    var studyEndDate = $('#study-end-date').val()



    $('#' + "{{ $repeaterId }}").repeater({
        initEmpty: initEmpty
        , isFirstItemUndeletable: !firstElementDeleteable
        , defaultValues: {
            'grace_period': 0
            , 'tenor': 12
            , "margin_rate": 0
            , "step_rate": 0
            , "loan_type": "normal"
            , "loan_nature": "fixed-at-end"
            , "installment_interval": "monthly"
            , "step_interval": "annually",

            "amount": 0
            , "increase_interval": "annually"
            , "payment_terms": "cash"
            , "vat_rate": 0
            , "start_date": studyStartDate
            , "end_date": studyEndDate,

        },

        show: function() {

            var appendNewOptionsToAllSelects = function(currentRepeaterItem) {

                if ($('[data-modal-title]').length) {

                    let currentSelect = $(currentRepeaterItem).find('select').attr('data-modal-name')
                    let modalType = $(currentRepeaterItem).find('select').attr('data-modal-type')
                    let selects = {}
                    $('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"] option').each(function(index, option) {
                        selects[$(option).attr('value')] = $(option).html()
                    })

                    $('select[data-modal-name="' + currentSelect + '"][data-modal-type="' + modalType + '"]').each(function(index, select) {
                        var selectedValue = $(select).val()
                        var currentOptions = ''
                        var currentOptionsValue = []
                        $(select).find('option').each(function(index, option) {
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
            $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                reinitalizeMonthYearInput(dateInput)
            });
            $(document).find('.datepicker-input:not(.only-month-year-picker)').datepicker({
                dateFormat: 'yy-mm-dd'
                , autoclose: true
            })
            $('input:not(.exclude-from-trigger-change-when-repeat):not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");
            appendNewOptionsToAllSelects(this)
        },

        hide: function(deleteElement) {

            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {

                if (confirm('Are you sure you want to delete this element?')) {

                    $(this).slideUp(deleteElement, function() {
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
