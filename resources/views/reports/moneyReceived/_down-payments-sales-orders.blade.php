<div class="form-group row align-items-end">

    <div class="col-md-4">
        <label>{{__('SO Number')}} </label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[][sales_order_name]" type="text" readonly class="form-control js-sales-order-name">
            <input name="sales_orders_amounts[][sales_order_id]" type="hidden" readonly class="form-control js-sales-order-number">
        </div>
    </div>

    <div class="col-md-2">
        <label>{{__('Amount')}} </label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[][net_invoice_amount]" type="text" disabled class="form-control js-amount">
        </div>
    </div>

    <div class="col-md-2">
        <label>{{__('Received Amount')}} @include('star')</label>
        <div class="kt-input-icon">
            <input name="sales_orders_amounts[][received_amounts]" placeholder="{{ __('Received Amount') }}" type="text" class="form-control js-received-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
        </div>
    </div>


</div>
