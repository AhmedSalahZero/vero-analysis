@props([
	'model',
	'label'=>'',
	'classes'=>'',
	'name',
	'id'=>'',
	'placeholder'=>'',
	'required'=>$required??false ,
	'readonly'=>false,
	'type'=>'date',
	'defaultValue'=>null
])
@if($label)
<label>
{{ $label }}
@if($required)
@include('star')
@endif 

</label>
@endif
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input
										@if($readonly)
										readonly
										@endif
										 @if($id)  id="{{ $id }}" @endif type="{{ $type }}" name="{{ $name }}" value="{{ isset($defaultValue) ? $defaultValue : ($model && $model->{$name} ? $model->{$name} : now()->format('Y-m-d') ) }}" class="form-control {{ $classes }}"  @if($placeholder) placeholder="{{ $placeholder }}" @endif />
										
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
