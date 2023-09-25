@props([
'selectedValue'=>'',
'label'=>'',
'all'=>false ,
'options'=>[],
'addNew'=>false ,
'isSelect2'=>true,
'addNewText'=>'',
'disabled'=>false ,
'addWithPopup'=>false,
'addNewWithFormPopupClass'=>'',
'addNewFormPath'=>'',
'addModelName'=>'',
'addModalTitle'=>'',
'appendNewOptionToSelectSelector'=>''
])
{{-- {{ dd() }} --}}
@if($label)
<label class="form-label font-weight-bold "> {{$label}} </label>
@endif
@if($disabled)
@php
$isSelect2 = false ;
@endphp
@endif

@php
$basicClasses = $isSelect2 ? "form-control mb-1 select select2-select" :"form-control mb-1 select ";
@endphp

<select

 @if($disabled) disabled @endif {{ $attributes->merge(['class'=>$basicClasses]) }} data-live-search="true" data-add-new="{{ $addNew ? 1 : 0 }}" data-all="{{ $all ? 1 :0 }}">
    @if($all)
    <option value="">{{ __('All') }}</option>
    @endif
    @if($addNew)
    <option class="add-new-item 
                @if($addWithPopup)
                add-with-popup
                @endif 
                " data-add-new-form="{{ $addNewWithFormPopupClass ?: '' }}" data-add-model-name="{{ $addModelName }}" data-add-modal-title="{{ $addModalTitle }}">{{ $addNewText ?: __('Add New') }}</option>
    @endif

    @foreach($options as $value=>$option)
    <option title="{{ $option['title']  }}" @foreach($option as $name=>$val)
        {{ $name .'='.$val }}
        @if($name == 'value' && $val == $selectedValue )
        selected
        @endif


        @endforeach


        >

        {{ $option['title'] }}</option>
    @endforeach
</select>

{{ $slot }}

@once
@push('js')
<script>
    $(document).on('click', '.add-with-popup', function(e, clickedIndex, isSelected, oldValue) {
        // const formPath =$(this).closest('.bootstrap-select').find('option.add-with-popup').data('form-path');
        const modelName = $(this).closest('.bootstrap-select').find('option.add-with-popup').data('add-model-name');
        const modalTitle = $(this).closest('.bootstrap-select').find('option.add-with-popup').data('add-modal-title');
        const currentSelectId = $(this).closest('.bootstrap-select').find('select').attr('id');
        window['currentSelectSelectorId'] = currentSelectId;
        const lang = $('body').data('lang');
        const companyId = $('body').data('current-company-id');
        const baseUrl = $('body').data('base-url');
        const url = baseUrl + '/' + lang + '/' + companyId + '/get-edit-form';
        $.ajax({
            url: url
            , data: {
                'modelName': modelName
            }
            , success(resView) {
                $('#append-dynamic-form-body-id').empty().append(resView);
                $('#append-dynamic-form-title-id').empty().append(modalTitle);
                $('#add-dynamic-form-id').modal('show');
            }
        });
    });

    $(document).on('click', '.submit-popup-btn-class', function() {
        let form = document.querySelector('#append-dynamic-form-body-id form');
        const formData = new FormData(form);
        const submitBtn = $('#append-dynamic-form-body-id').closest('.modal-content').find('button.submit-popup-btn-class');
        submitBtn.prop('disabled', true);
        let formAction = $(form).attr('action');

        $.ajax({
            processData: false
            , contentType: false
            , url: formAction
            , data: formData
            , type: "POST"
            , complete: function() {
                $(submitBtn).prop('disabled', false);
            }
            , success: function(res) {
                const option = '<option value="' + res.id + '" > ' + res.name + ' </option> ';
                const appendSelectSelector = $('#' + window['currentSelectSelectorId']);
                const addNewOption = appendSelectSelector.find('option.add-new-item').after(option).selectpicker('refresh').trigger('change')
                // appendSelectSelector;
                $('#add-dynamic-form-id').modal('hide');
            }
            , error: function(res) {
                const firstError = Object.keys(res.responseJSON.errors)[0];
                alert(res.responseJSON.errors[firstError][0]);
            }
        });

    })

</script>

@endpush
@endonce
