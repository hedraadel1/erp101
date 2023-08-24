@php
    $is_mobile = isMobile();
@endphp
<div class="row">
    <div style="margin-right: unset;border-radius: 25px;  background: linear-gradient(to right, #232526, #414345);padding-right: 10px;padding-left: 10px;"
        class="pos-form-actions box box-solid ">

        @if ($is_mobile)
            <div class="col-md-12 text-left">
                <b style="color: white;font-size: 25px;">@lang('sale.total_payable'):</b>
                {{-- <b>totalllll:</b> --}}
                <input type="hidden" name="final_total" id="final_total_input" value=0>
                <span style="    text-align: center !important;
                font-size: 30px;" id="total_payable"
                    class="text-success btn-sm lead text-bold text-left">0</span>
            </div>
        @endif


        @if (!$is_mobile)
            <div class="pull-right pos-total text-white">

                <input type="hidden" name="final_total" id="final_total_input" value=0>
                <span id="total_payable" class="number">0</span>
            </div>
        @endif

    </div>
</div>
<div style="margin-bottom: 110px;" class="row">

    <button type="button"
        class="btn btn-sm btn-default bg-yellow btn-flat @if ($is_mobile) col-xs-6 @endif"
        id="pos-quotation"><i class="fas fa-edit"></i> @lang('lang_v1.quotation')
    </button>

    @if (empty($pos_settings['disable_suspend']))
        <button type="button"
            class="@if ($is_mobile) col-xs-6 @endif btn btn-sm bg-red btn-default btn-flat no-print pos-express-finalize"
            data-pay_method="suspend" title="@lang('lang_v1.tooltip_suspend')">
            <i class="fas fa-pause" aria-hidden="true"></i>
            @lang('lang_v1.suspend')
        </button>
    @endif

    @if (empty($pos_settings['disable_credit_sale_button']))
        <input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
        <button type="button"
            class="btn btn-sm bg-purple btn-default btn-flat no-print pos-express-finalize @if ($is_mobile) col-xs-6 @endif"
            data-pay_method="credit_sale" title="@lang('lang_v1.tooltip_credit_sale')">
            <i class="fas fa-check" aria-hidden="true"></i> @lang('lang_v1.credit_sale')
        </button>
    @endif
    <button type="button"
        class="btn bg-maroon btn-sm btn-default btn-flat no-print @if (!empty($pos_settings['disable_suspend']))  @endif pos-express-finalize @if (!array_key_exists('card', $payment_types)) hide @endif @if ($is_mobile) col-xs-6 @endif"
        data-pay_method="card" title="@lang('lang_v1.tooltip_express_checkout_card')">
        <i class="fas fa-credit-card" aria-hidden="true"></i> @lang('lang_v1.express_checkout_card')
    </button>

    <button type="button"
        class="btn bg-navy btn-default btn-sm @if (!$is_mobile)  @endif btn-flat no-print @if ($pos_settings['disable_pay_checkout'] != 0) hide @endif @if ($is_mobile) col-xs-6 @endif"
        data-container=".modal_payment" id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')"><i class="fas fa-money-check-alt"
            aria-hidden="true"></i> @lang('lang_v1.checkout_multi_pay')
    </button>


    {{--  زر الدفع السريع --}}
    <button type="button"
        class="btn btn-success btn-sm
  @if (!$is_mobile)  @endif
      btn-flat no-print 
  @if ($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif
  
   pos-express-finalize 
  
  @if ($is_mobile) col-xs-6 @endif
  
  "data-pay_method="cash"
        title="@lang('tooltip.express_checkout')"> <i class="fas fa-money-bill-alt" aria-hidden="true"></i>
        @lang('lang_v1.express_checkout_cash')

    </button>
    {{--  زر عرض  الحجوزات --}}
    @if (!empty($pos_settings['show_invoice_booking']))
        <button type="button"
            class="btn-sm btn btn-primary btn-flat @if ($is_mobile) col-xs-6 @endif"
            data-toggle="modal" data-target="#invoice_booking_modal" id="invoice_booking"> <i class="fas fa-file"></i>
            @lang('lang_v1.invoice_bookings')</button>
    @endif
    {{--  زر عرض  المنتجات المحجوزه --}}
    @if (!empty($pos_settings['show_product_booking']))
        <button type="button"
            class=" btn btn-primary btn-sm btn-flat @if ($is_mobile) col-xs-6 @endif"
            data-toggle="modal" data-target="#product_booking_modal" id="product_booking"> <i class="fas fa-list"></i>
            @lang('lang_v1.product_bookings')</button>
    @endif



    {{-- ================================== --}}
    @if (empty($edit))
        <button type="button"
            class="btn btn-danger btn-sm btn-flat @if ($is_mobile) col-xs-6 @else @endif"
            id="pos-cancel"> <i class="fas fa-window-close"></i> @lang('sale.cancel')</button>
    @else
        <button type="button"
            class="btn btn-danger btn-flat hide @if ($is_mobile) col-xs-6 @else btn-xs @endif"
            id="pos-delete"> <i class="fas fa-trash-alt"></i> @lang('messages.delete')</button>
    @endif

    @if (!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
        <button type="button"
            class="btn-sm btn btn-primary btn-flat @if ($is_mobile) col-xs-6 @endif"
            data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions"> <i
                class="fas fa-clock"></i> @lang('lang_v1.recent_transactions')</button>
    @endif



</div>

@if (isset($transaction))
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $transaction->discount_amount,
        'discount_type' => $transaction->discount_type,
        'rp_redeemed' => $transaction->rp_redeemed,
        'rp_redeemed_amount' => $transaction->rp_redeemed_amount,
        'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0,
    ])
@else
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $business_details->default_sales_discount,
        'discount_type' => 'percentage',
        'rp_redeemed' => 0,
        'rp_redeemed_amount' => 0,
        'max_available' => 0,
    ])
@endif

@if (isset($transaction))
    @include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
    @include('sale_pos.partials.edit_order_tax_modal', [
        'selected_tax' => $business_details->default_sales_tax,
    ])
@endif

@include('sale_pos.partials.edit_shipping_modal')
