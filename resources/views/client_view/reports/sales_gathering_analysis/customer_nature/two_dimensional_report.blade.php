@extends('layouts.dashboard')
@section('css')
    <link href="{{ url('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
@endsection
@section('sub-header')
    {{ __($view_name) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (session('warning'))
                <div class="alert alert-warning">
                    <ul>
                        <li>{{ session('warning') }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>



    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                </span>
                <h3 class="kt-portlet__head-title">

                    <b> {{ __('From : ') }} </b>{{ $dates['start_date'] }}
                    <b> - </b>
                    <b> {{ __('To : ') }}</b> {{ $dates['end_date'] }}
                    <br>

                    <span class="title-spacing"><b> {{ __('Last Updated Data Date : ') }}</b> {{ $last_date }}</span>

                </h3>
            </div>

        </div>
    </div>

    {{-- <input type="hidden" id="total" data-total="{{ json_encode($report_view_data??[]) }}"> --}}

    <!--Sales Values Table -->

    {{-- @dd(get_defined_vars()) --}}

    <x-table :tableTitle="__('Sales Values Table')"   :tableClass="'kt_table_with_no_pagination'">
        @slot('table_header')
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th>{{ __($main_type_name) . ' / ' . __('Customers Natures') }}</th>
                @foreach ($all_items as $item)
                    <th>{{ __($item) }}</th>
                    <th>{{ __('% / '.$main_type_name) }}</th>
                @endforeach
                <th>{{ __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales')) }}</th>
                <th>{{ __('% / Total '.($type ==  'discounts' ? 'Discounts' : 'Sales')) }}</th>
                <th>{{ __('Stop') }}</th>
                <th>{{ __('% / '.$main_type_name) }}</th>
                <th>{{ __('Dead') }}</th>
                <th>{{ __('% / '.$main_type_name) }}</th>
            </tr>
        @endslot
        @slot('table_body')
            <?php $total_per_item = []; ?>
            <?php

                $dead_stop_totals = [ 'Stop' =>($items_totals_sales_values['Stop']??0), 'Dead' =>($items_totals_sales_values['Dead']??0)];
                unset($items_totals_sales_values['Dead']);
                unset($items_totals_sales_values['Stop']);
                $final_total = array_sum($items_totals_sales_values);
                $final_percentage = $final_total == 0 ? 0 : (($final_total ?? 0) / $final_total) * 100;
                $stop_and_dead = [];
            ?>

            @foreach ($report_totals_sales_values as $main_type_item_name => $main_item_total)

                <tr>
                    <th> {{ __($main_type_item_name) }} </th>
                    @foreach ($all_items as $item)
                        <?php
                            $value = ($report_sales_values[$main_type_item_name][$item] ?? 0);
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;

                        ?>
                        <td class="text-center"> {{ number_format($value) }}</td>
                        <td class="text-center">
                            <span class="active-text-color "><b> {{  number_format($percentage_per_value, 1).' % ' }}</b></span>
                        </td>

                    @endforeach

                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        {{ number_format($main_item_total) }}
                    </td>
                    <td class="text-center">
                        <span class="active-text-color text-center"><b> {{  number_format($total_percentage, 1) . ' % ' }}</b></span>
                    </td>
                    <?php $items_after_total = ['Stop','Dead']; ?>
                    @foreach ($items_after_total as $item)

                        <?php
                            $value =( $report_sales_values[$main_type_item_name][$item] ?? 0);
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;
                        ?>
                        <td class="text-center"> {{ number_format($value) }}</td>
                        <td class="text-center">
                            <span class="active-text-color "><b> {{  number_format($percentage_per_value, 1).' % ' }}</b></span>
                        </td>
                    @endforeach
                </tr>
            @endforeach

            <tr class="table-active text-center">
                <th class="text-center"> {{ __('Total') }} </th>
                @foreach ($all_items as $item_name)
                    <td class="text-center">
                        {{ number_format($items_totals_sales_values[$item_name] ?? 0) }}
                    </td>
                    <td class="text-center">
                        -
                    </td>
                @endforeach
                <td class="text-center">{{ number_format($final_total) }}</td>
                <td class="text-center"><b>{{  number_format($final_percentage, 1) . ' % ' }}</b></td>
                @foreach ($dead_stop_totals as $total)
                    <td class="text-center">
                        {{ number_format(($total ?? 0)) }}
                    </td>
                    <td class="text-center">
                        -
                    </td>

                @endforeach
            </tr>
            <tr class="table-active text-center">
                <th class="text-center"> {{  'Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales')) }} </th>
                @foreach ($all_items as $item_name)
                    <?php $items_percentage = $final_total == 0 ? 0 : (($items_totals_sales_values[$item_name] ?? 0) / $final_total) * 100; ?>
                    <td class="text-center">
                        <b> {{   number_format($items_percentage, 1) . ' %' }}</b>
                    </td>
                    <td class="text-center">
                        -
                    </td>
                @endforeach

                <td><b>{{ number_format($final_percentage, 1) . ' %' }}</b></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endslot
    </x-table>

     <!--Counts Table -->











     <x-table :tableTitle="__('Counts Table')"   :tableClass="'kt_table_with_no_pagination'">
        @slot('table_header')
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th>{{ __($main_type_name) . ' / ' . __('Customers Natures') }}</th>
                @foreach ($all_items as $item)
                    <th>{{ __($item) }}</th>
                    <th>{{ __('% / '.$main_type_name) }}</th>
                @endforeach
                <th>{{ __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales')) }}</th>
                <th>{{ __('% / Total '.($type ==  'discounts' ? 'Discounts' : 'Sales')) }}</th>
                <th>{{ __('Stop') }}</th>
                <th>{{ __('% / '.$main_type_name) }}</th>
                <th>{{ __('Dead') }}</th>
                <th>{{ __('% / '.$main_type_name) }}</th>
            </tr>
        @endslot
        @slot('table_body')
            <?php $total_per_item = []; ?>
            <?php
                $dead_stop_totals = [ 'Stop' =>$items_totals_counts['Stop'] ?? 0, 'Dead' =>$items_totals_counts['Dead'] ?? 0];
                unset($items_totals_counts['Dead']);
                unset($items_totals_counts['Stop']);
                $final_total = array_sum($items_totals_counts);
                $final_percentage = $final_total == 0 ? 0 : (($final_total ?? 0) / $final_total) * 100;
            ?>

            @foreach ($report_totals_counts as $main_type_item_name => $main_item_total)
                <tr>
                    <th> {{ __($main_type_item_name) }} </th>
                    @foreach ($all_items as $item)
                        <?php $value = $report_counts[$main_type_item_name][$item] ?? 0;
                        $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100; ?>
                        <td class="text-center">{{ number_format($value) }}</td>
                        <td class="text-center">
                            <span class="active-text-color "><b> {{  number_format($percentage_per_value, 1).' % ' }}</b></span>
                        </td>
                    @endforeach
                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        {{ number_format($main_item_total) }}

                    </td>
                    <td class="text-center">
                        <span class="active-text-color "><b> {{ number_format($total_percentage, 1) . ' % ' }}</b></span>
                    </td>
                    <?php $items_after_total = ['Stop','Dead']; ?>
                    @foreach ($items_after_total as $item)

                        <?php
                            $value = $report_counts[$main_type_item_name][$item] ?? 0;
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;

                        ?>
                        <td class="text-center"> {{ number_format($value) }}</td>
                        <td class="text-center">
                            <span class="active-text-color "><b> {{  number_format($percentage_per_value, 1).' % ' }}</b></span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            <tr class="table-active text-center">
                <th class="text-center"> {{ __('Total') }} </th>
                @foreach ($all_items as $item_name)
                    <td class="text-center">
                        {{ number_format($items_totals_counts[$item_name] ?? 0) }}
                    </td>
                    <td class="text-center">
                        -
                    </td>
                @endforeach

                <td>{{ number_format($final_total) }}
                </td>
                <td>-</td>
                @foreach ($dead_stop_totals as $total)
                    <td class="text-center">
                        {{ number_format($total ?? 0) }}
                    </td>
                    <td class="text-center">
                        <b>{{  number_format($final_percentage, 1) . ' % ' }}</b>
                    </td>
                @endforeach

            </tr>
            <tr class="table-active text-center">
                <th class="text-center"> {{ 'Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Count')) }} </th>

                @foreach ($all_items as $item_name)
                    <?php $items_percentage = $final_total == 0 ? 0 : (($items_totals_counts[$item_name] ?? 0) / $final_total) * 100; ?>
                    <td class="text-center">
                        <b> {{   number_format($items_percentage, 1) . ' %' }}</b>
                    </td>
                    <td class="text-center">
                        -
                    </td>
                @endforeach

                <td><b>{{ number_format($final_percentage, 1) . ' %' }}</b></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endslot
    </x-table>
@endsection

@section('js')
    <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript">
    </script>
    <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

@endsection
