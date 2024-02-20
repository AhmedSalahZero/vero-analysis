@props([
	'model',
	'label',
	'classes'=>'',
	'name',
	'id'=>'',
	'placeholder',
	'required'=>$required??false 
])
<label>
{{ $label }}
@if($required)
@include('star')
@endif 

</label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input @if($id)  id="{{ $id }}" @endif type="date" name="{{ $name }}" value="{{ $model && $model->{$name} ? $model->{$name} : null }}" class="form-control {{ $classes }}"  placeholder="{{ $placeholder }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
