@extends('layouts.dashboard')

@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/leasing-revenue-stream-breakdown.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/select2.css">
<style>
    .positions_repeater {
        max-width: 50% !important;
    }

</style>
@endsection
@section('sub-header')
<x-main-form-title :id="'main-form-title'" :class="''">{{ $title }}</x-main-form-title>

{{-- <x-navigators-dropdown :navigators="$navigators"></x-navigators-dropdown> --}}

@endsection
@section('content')



        {{-- <div class="kt-portlet">
            <div class="kt-portlet__body"> --}}

                <div class="row fixed-asset-names">

                    <div class="form-group row" style="flex:1;">
                        <div class="col-md-12 mt-3" data-repeater-row=".fixed-asset-names">

                            <form class="kt-form kt-form--label-right" action="{{ route('store.expenses',['company'=>$company->id , 'study'=>$study->id]) }}" method="POST">
                                {{ csrf_field() }}

                                @include('non_banking_services.expenses._content',$study->getExpensesViewVars())

                                <x-save-or-continue-btn />
                            </form>


                        </div>


                    </div>

                </div>
            {{-- </div>

        </div> --}}



@endsection
@section('js')
<x-js.commons></x-js.commons>

<script>


</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            const hasSalesChannel = $('#add-sales-channels-share-discount-id:checked').length

            let canSubmitForm = true;
            let errorMessage = '';
            let messageTitle = 'Oops...';



            if (!canSubmitForm) {
                Swal.fire({
                    icon: "warning"
                    , title: messageTitle
                    , text: errorMessage
                , })

                return;
            }

            let formId = $(this).closest('form').attr('id')

            let form = document.getElementById(formId);
            var formData = new FormData(form);
            formData.append('submitBtnType', formId)

            $('.save-form').prop('disabled', true);


            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {

                    let title = '{{ __("Something Went Wrong") }}';
                    if (res.responseJSON && res.responseJSON.message) {
                        title = res.responseJSON.message;
                    }
                    $('.submit-form-btn,.save-form').prop('disabled', false)
                    let message = null;
                    if (res.responseJSON && res.responseJSON.errors) {
                        message = res.responseJSON.errors[Object.keys(res.responseJSON.errors)[0]][0]
                    }
                    Swal.fire({
                        icon: 'error'
                        , title: title
                        , text: message

                    })

                }
            });
        }
    })

</script>

<script>
    $('.use-rooms:checked').trigger('change');

</script>

<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })
    $(document).on('change', '.can-not-be-removed-checkbox', function() {
        $(this).prop('checked', true)
    })

    $(document).on('click', '.show-hide-repeater', function() {
        const query = this.getAttribute('data-query')
        $(query).fadeToggle(300)

    })
    $(document).on('change', '.not-allowed-duplication-in-selection-inside-repeater', function() {
        const val = $(this).val()
        const currentSelect = this
        const currentSelectedOption = $(currentSelect).find('option[value="' + val + '"]')
        const commonParent = $(this).closest('[data-repeater-list]')
        // let selectItems = []
        // $(commonParent).find('select').each(function(index,select){
        // 	selectItems.push($(select).val())
        // })
        $(commonParent).find('select').each(function(index, select) {
            if (select != currentSelect) {
                if ($(select).find('option[value="' + val + '"]:selected').length) {
                    alert('This Item has been choosen before')
                    $(currentSelect).val('').trigger('change')

                }

                //.prop('disabled',true).attr('title','This Item has been choosen before')
            } else {}
        })
    })

    $(document).on('change', '.can-be-toggle-show-repeater-btn', function() {
        let val = $(this).is(':checked')
        let repeaterQuery = $(this).attr('data-repeater-query')
        if (!val) {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').addClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeOut(300)
            $(this).val(0)
        } else {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').removeClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeIn(300)
            $(this).val(1)

        }

    })
    $('.can-be-toggle-show-repeater-btn').trigger('change')

</script>

<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/select2.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>







<script>
    function initMultiselect(container) {
        const $container = $(container);
        const $trigger = $container.find('.multiselect-trigger');
        const $dropdown = $container.find('.multiselect-dropdown');
        const $searchInput = $container.find('.search-input');
        const $selectAllBtn = $container.find('.btn-select-all');
        const $deselectAllBtn = $container.find('.btn-deselect-all');
        const $optionsContainer = $container.find('.multiselect-options');
        const $selectedText = $container.find('.selected-text');
        const $selectedOptionsContainer = $container.find('.selected-options-container');
        let selectedValues = [];

        // Toggle dropdown
        $trigger.on('click', function(e) {
            e.stopPropagation();
            $dropdown.toggle();
        });

        // Close on outside click
        $(document).on('click', function(e) {
            if (!$container.has(e.target).length) {
                $dropdown.hide();
            }
        });

        // Bind checkbox events
        function bindCheckboxEvents($checkbox) {
            $checkbox.on('change', function() {
                const $this = $(this);
                const isMain = $this.hasClass('main-checkbox');
                const value = $this.val();

                if (isMain) {
                    // If main item is checked/unchecked, update sub-items
                    const $subItems = $optionsContainer.find(`.sub-item input[data-parent="${value}"]`);
                    $subItems.prop('checked', $this.prop('checked'));
                } else {
                    // If sub-item is checked, ensure parent is checked
                    const parentValue = $this.data('parent');
                    const $parentCheckbox = $optionsContainer.find(`.main-checkbox[value="${parentValue}"]`);
                    const $subItems = $optionsContainer.find(`.sub-item input[data-parent="${parentValue}"]`);
                    const allSubChecked = $subItems.length === $subItems.filter(':checked').length;
                    $parentCheckbox.prop('checked', allSubChecked);
                }

                updateSelected();
            });
        }

        // Update selected values and display
        function updateSelected() {
            const $options = $optionsContainer.find('.option-item input[type="checkbox"]');
            selectedValues = $options.filter(':checked').map(function() { return $(this).val(); }).get();
            $selectedText.text(selectedValues.length ? `${selectedValues.length} selected` : 'Select options...');

            // Clear existing hidden inputs
            $selectedOptionsContainer.empty();
            // Add a hidden input for each selected value
            selectedValues.forEach(function(value) {
                $selectedOptionsContainer.append(
                    `<input type="hidden" name="selectedOptions[]" value="${value}">`
                );
            });
        }

        // Bind initial checkboxes
        $optionsContainer.find('.option-item input[type="checkbox"]').each(function() {
            bindCheckboxEvents($(this));
        });

        // Select All
        $selectAllBtn.on('click', function(e) {
            e.preventDefault();
            $optionsContainer.find('.option-item input[type="checkbox"]').prop('checked', true);
            updateSelected();
        });

        // Deselect All
        $deselectAllBtn.on('click', function(e) {
            e.preventDefault();
            $optionsContainer.find('.option-item input[type="checkbox"]').prop('checked', false);
            updateSelected();
        });

        // Search filter
        $searchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            $optionsContainer.find('.option-group').each(function() {
                const $group = $(this);
                const $mainItem = $group.find('.main-item');
                const $subItems = $group.find('.sub-item');
                const mainText = $mainItem.text().toLowerCase();
                let hasVisibleSubItems = false;

                $subItems.each(function() {
                    const subText = $(this).text().toLowerCase();
                    const isVisible = subText.includes(query);
                    $(this).toggle(isVisible);
                    if (isVisible) hasVisibleSubItems = true;
                });

                $mainItem.toggle(mainText.includes(query) || hasVisibleSubItems);
                $group.toggle(mainText.includes(query) || hasVisibleSubItems);
            });
        });

        updateSelected(); // Initial call
    }
</script>



@foreach(getExpensesTypes() as $expenseType)
<script>
    $(document).ready(function() {
        var selector = "#{{ $expenseType.'_repeater' }}";
        $(selector).repeater({
            initEmpty: false
            , defaultValues: {
                'category_id': 'manufacturing-expenses'
                , 'payment_terms': 'cash',
				'is_as_revenue_percentages':1,
				'monthly_percentage':0,
				'amount':0,
				'monthly_cost_of_unit':0
            }
            , show: function() {
                $(this).slideDown();
                $('.js-select2-with-one-selection').select2({});
                initMultiselect($(this));
				$('.allocate-checkbox').trigger('change')
            }
            , ready: function(setIndexes) {

            }
            , hide: function(deleteElement) {
                if (confirm(translations.deleteConfirm)) {
                    $(this).slideUp(deleteElement);


                }

            }
            , isFirstItemUndeletable: true
        });
    });


</script>
@endforeach
<script>
    $('.repeater_item').each(function() {
	
	      initMultiselect($(this));
    });
</script>

<script>

$(document).on('change','select.expense_category',function(){
		const parent = $(this).closest('[data-repeater-item]');
		const expenseCategoryId = $(this).val();
		const currentSelected = $(parent).find('select.expense_name_id').attr('data-current-selected');
		$.ajax({
			url:"{{ route('get.expense.name.for.category',['company'=>$company->id,'study'=>$study->id]) }}",
			data:{expenseCategoryId},
			success:function(res){
				let result = res.data ;
				let options = '';
				for(index in result){
					var row = result[index];
					options += `<option ${currentSelected==row.id ? 'selected':''} value="${row.id}">${row.name}</option>`;
				}
				console.log('options',options);
				$(parent).find('select.expense_name_id').empty().append(options).trigger('change');
			}
		})
	})
	$(function(){
		$('select.expense_category').trigger('change')
	})
	
</script>
{{-- <script></script> --}}
@endsection
