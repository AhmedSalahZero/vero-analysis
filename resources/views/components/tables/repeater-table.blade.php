@props([
'isRepeater'=>$isRepeater,
'relationName'=>$relationName,
'repeaterId'=>$repeaterId,
'tableName'=>$tableName ?? '',
'parentClass'=>$parentClass ?? ''
])
<div class="col-md-12 {{ $parentClass }} js-parent-to-table">
    <hr style="width:100%;">
    <table id="{{ $repeaterId }}" class="table {{ $repeaterId }} table-white repeater {{ $tableName }}"  >
        <thead>
            <tr>
                <x-tables.repeater-table-th class="col-md-1" :title="__('Action')"></x-tables.repeater-table-th>
                {{ $ths }}

            </tr>
        </thead>
        <tbody data-repeater-list="items">

            @if(isset($model) && $model->{$relationName}->count() )

            @foreach($model->{$relationName} as $subModel)
            <x-tables.repeater-table-tr :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)" :model="$subModel"></x-tables.repeater-table-tr>

            @endforeach
            @else
            <x-tables.repeater-table-tr :tds="$tds" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">

            </x-tables.repeater-table-tr>


            @endif

        </tbody>

        <td>

            <div data-repeater-create="" class="btn btn btn-sm text-white   border-green bg-green  m-btn m-btn--icon m-btn--pill m-btn--wide {{__('right')}}" id="add-row">
                <span>
                    <i class="fa fa-plus"> </i>
                    <span>
                        {{ __('Add') }}
                    </span>
                </span>
            </div>
        </td>

    </table>
</div>
