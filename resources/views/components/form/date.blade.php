@props([
	'model',
	'label',
	'name',
	'placeholder',
	'required'=>$required??false 
])
<label>
{{ $label }}
@if($required)
<span class="required">*</span>
@endif 

{{-- {{ dd(formatDateForDatePicker($model->{$name})) }} --}}
</label>
{{-- {{ dd(formatDateForDatePicker($model->{$name}),$name) }} --}}
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="{{ $name }}" value="{{ $model && $model->{$name} ? $model->{$name} : null }}" class="form-control"  placeholder="{{ $placeholder }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
