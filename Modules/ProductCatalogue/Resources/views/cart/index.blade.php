@extends('layouts.guest')
@section('title', 'عربة التسوق')

@section('content')
    @include('productcatalogue::layouts.top_nav')

    <div class="container">
        {!! Form::open([
            'url' => action('\Modules\ProductCatalogue\Http\Controllers\CartController@storeOrder'),
            'method' => 'post',
            'id' => 'add_sell_form',
            'files' => true,
        ]) !!}

        @component('components.widget', ['class' => 'box-solid', 'title' => 'عربة التسوق'])
            <div class="row col-sm-12 pos_product_div" style="min-height: 0">

                {{-- <input type="hidden" name="sell_price_tax" id="sell_price_tax" value="{{ $business_details->sell_price_tax }}"> --}}

                <!-- Keeps count of product rows -->
                <input type="hidden" id="product_row_count" value="0">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    @lang('sale.product')
                                </th>
                                <th class="text-center">
                                    @lang('sale.qty')
                                </th>
                                <th class="text-center">
                                    @lang('sale.price_inc_tax')
                                </th>
                                <th class="text-center">
                                    @lang('sale.subtotal')
                                </th>
                                <th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="product_row" data-row_index="{{ $loop->iteration }}">
                                    <td>
                                        {{ $product->product_name }}
                                        <input type="hidden" class="enable_sr_no" value="{{ $product->enable_sr_no }}">
                                        <input type="hidden" class="product_type"
                                            name="products[{{ $loop->iteration }}][product_type]"
                                            value="{{ $product->product_type }}">

                                        @php
                                            $hide_tax = 'hide';
                                            // dd($product);
                                            $tax_id = $product->tax_id;
                                            $item_tax = !empty($product->item_tax) ? $product->item_tax : 0;
                                            $unit_price_inc_tax = $product->sell_price_inc_tax;
                                            
                                            $discount_type = !empty($product->line_discount_type) ? $product->line_discount_type : 'fixed';
                                            $discount_amount = !empty($product->line_discount_amount) ? $product->line_discount_amount : 0;
                                            
                                            $sell_line_note = '';
                                            if (!empty($product->sell_line_note)) {
                                                $sell_line_note = $product->sell_line_note;
                                            }
                                        @endphp

                                        @php
                                            $max_quantity = $product->qty_available;
                                            $formatted_max_quantity = $product->formatted_qty_available;
                                            $max_qty_rule = $max_quantity;
                                            $max_qty_msg = __('validation.custom-messages.quantity_not_available', ['qty' => $formatted_max_quantity, 'unit' => $product->unit]);
                                        @endphp
                                        <textarea class="form-control hide" name="products[{{ $loop->iteration }}][sell_line_note]" rows="2">{{ $sell_line_note }}</textarea>
                                        <p class="help-block hide"><small>@lang('lang_v1.sell_line_description_help')</small></p>
                                    </td>

                                    <td>

                                        <input type="hidden" name="products[{{ $loop->iteration }}][product_id]"
                                            class="form-control product_id" value="{{ $product->product_id }}">

                                        <input type="hidden" value="{{ $product->variation_id }}"
                                            name="products[{{ $loop->iteration }}][variation_id]" class="row_variation_id">

                                        <input type="hidden" value="{{ $product->enable_stock }}"
                                            name="products[{{ $loop->iteration }}][enable_stock]">

                                        @php
                                            $multiplier = 1;
                                            $allow_decimal = true;
                                            if ($product->unit_allow_decimal != 1) {
                                                $allow_decimal = false;
                                            }
                                        @endphp
                                        {{-- @foreach ($sub_units as $key => $value)
                                            @if (!empty($product->sub_unit_id) && $product->sub_unit_id == $key)
                                                @php
                                                    $multiplier = $value['multiplier'];
                                                    
                                                    if ($value['allow_decimal']) {
                                                        $allow_decimal = true;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach --}}
                                        <div class="input-group input-number">
                                            <input type="hidden" value="{{ $product->cart_id }}" class="cart_id">
                                            <span class="input-group-btn"><button type="button"
                                                    class="btn btn-default btn-flat quantity-down"><i
                                                        class="fa fa-minus text-danger"></i></button></span>
                                            <input type="text" data-min="1" min="1"
                                                data-product_id="{{ $product->product_id }}"
                                                class="form-control pos_quantity input_number mousetrap input_quantity"
                                                value="{{ @format_quantity($product->quantity_ordered) }}"
                                                name="products[{{ $loop->iteration }}][quantity]"
                                                data-allow-overselling="@if (empty($pos_settings['allow_overselling'])) {{ 'false' }}@else{{ 'true' }} @endif"
                                                @if ($allow_decimal) data-decimal=1 
                                @else 
                                  data-decimal=0 
                                  data-rule-abs_digit="true" 
                                  data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" @endif
                                                data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')">
                                            <span class="input-group-btn"><button type="button"
                                                    class="btn btn-default btn-flat quantity-up plus"><i
                                                        class="fa fa-plus text-success"></i></button></span>
                                        </div>

                                        <input type="hidden" name="products[{{ $loop->iteration }}][product_unit_id]"
                                            value="{{ $product->unit_id }}">
                                        {{-- @if (count($sub_units) > 0)
                                            <br>
                                            <select name="products[{{ $loop->iteration }}][sub_unit_id]"
                                                class="form-control input-sm sub_unit">
                                                @foreach ($sub_units as $key => $value)
                                                    <option value="{{ $key }}"
                                                        data-multiplier="{{ $value['multiplier'] }}"
                                                        data-unit_name="{{ $value['name'] }}"
                                                        data-allow_decimal="{{ $value['allow_decimal'] }}"
                                                        @if (!empty($product->sub_unit_id) && $product->sub_unit_id == $key) selected @endif>
                                                        {{ $value['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{ $product->unit }}
                                        @endif --}}

                                        <input type="hidden" class="base_unit_multiplier"
                                            name="products[{{ $loop->iteration }}][base_unit_multiplier]"
                                            value="{{ $multiplier }}">

                                        <input type="hidden" class="hidden_base_unit_sell_price"
                                            value="{{ $product->default_sell_price / $multiplier }}">

                                        {{-- Hidden fields for combo products --}}
                                        @if ($product->product_type == 'combo' && !empty($product->combo_products))
                                            @foreach ($product->combo_products as $k => $combo_product)
                                                @php
                                                    $qty_total = $combo_product['qty_required'];
                                                @endphp

                                                <input type="hidden"
                                                    name="products[{{ $loop->iteration }}][combo][{{ $k }}][product_id]"
                                                    value="{{ $combo_product['product_id'] }}">

                                                <input type="hidden"
                                                    name="products[{{ $loop->iteration }}][combo][{{ $k }}][variation_id]"
                                                    value="{{ $combo_product['variation_id'] }}">

                                                <input type="hidden" class="combo_product_qty"
                                                    name="products[{{ $loop->iteration }}][combo][{{ $k }}][quantity]"
                                                    data-unit_quantity="{{ $combo_product['qty_required'] }}"
                                                    value="{{ $qty_total }}">
                                            @endforeach
                                        @endif
                                    </td>
                                    @php
                                        $pos_unit_price = !empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price;
                                    @endphp
                                    <td class="hide">
                                        <input type="text" name="products[{{ $loop->iteration }}][unit_price]"
                                            class="form-control pos_unit_price input_number mousetrap"
                                            value="{{ @num_format($pos_unit_price) }}"
                                            @if (!empty($pos_settings['enable_msp'])) data-rule-min-value="{{ $pos_unit_price }}" data-msg-min-value="{{ __('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($pos_unit_price)]) }}" @endif>
                                    </td>
                                    <td class="hide">
                                        {!! Form::text("products[$loop->iteration][line_discount_amount]", @num_format($discount_amount), [
                                            'class' => 'form-control input_number row_discount_amount',
                                        ]) !!}<br>
                                        {!! Form::select(
                                            "products[$loop->iteration][line_discount_type]",
                                            ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')],
                                            $discount_type,
                                            ['class' => 'form-control row_discount_type'],
                                        ) !!}
                                        @if (!empty($discount))
                                            <p class="help-block">{!! __('lang_v1.applied_discount_text', [
                                                'discount_name' => $discount->name,
                                                'starts_at' => $discount->formated_starts_at,
                                                'ends_at' => $discount->formated_ends_at,
                                            ]) !!}</p>
                                        @endif
                                    </td>
                                    <td class="text-center hide">
                                        {!! Form::hidden("products[$loop->iteration][item_tax]", @num_format($item_tax), ['class' => 'item_tax']) !!}

                                        {!! Form::select(
                                            "products[$loop->iteration][tax_id]",
                                            $tax_dropdown['tax_rates'],
                                            $tax_id,
                                            ['placeholder' => 'Select', 'class' => 'form-control tax_id'],
                                            $tax_dropdown['attributes'],
                                        ) !!}
                                    </td>
                                    <td class="text-center">
                                        @format_currency($unit_price_inc_tax)
                                        <input type="hidden" name="products[{{ $loop->iteration }}][unit_price_inc_tax]"
                                            class="form-control pos_unit_price_inc_tax input_number"
                                            value="{{ @num_format($unit_price_inc_tax) }}"
                                            @if (!empty($pos_settings['enable_msp'])) data-rule-min-value="{{ $unit_price_inc_tax }}" data-msg-min-value="{{ __('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($unit_price_inc_tax)]) }}" @endif>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden"
                                            class="form-control pos_line_total @if (!empty($pos_settings['is_pos_subtotal_editable'])) input_number @endif"
                                            value="{{ @num_format($product->quantity_ordered * $unit_price_inc_tax) }}">
                                        <span class="display_currency pos_line_total_text"
                                            data-currency_symbol="true">{{ $product->quantity_ordered * $unit_price_inc_tax }}</span>
                                    </td>
                                    <td class="text-center v-center">
                                        <i class="fa fa-times text-danger pos_remove_row removeItemCart cursor-pointer"
                                            data-cart_id="{{ $product->cart_id }}" aria-hidden="true"></i>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-striped">
                        <tr>
                            <td>
                                <div class="pull-right">
                                    <b>@lang('sale.item'):</b>
                                    <span class="total_quantity">{{ $cart_data['items_count'] }}</span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <b>@lang('sale.total'): </b>
                                    <span class="price_total">{{ $cart_data['sub_total'] }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endcomponent
        @component('components.widget', ['class' => 'box-solid'])
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('sell_note', __('purchase.additional_notes')) !!}
                    {!! Form::textarea('sale_note', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('shipping_address', __('lang_v1.shipping_address')) !!}
                    {!! Form::textarea('shipping_address', null, [
                        'class' => 'form-control',
                        'placeholder' => __('lang_v1.shipping_address'),
                        'rows' => '3',
                        'cols' => '30',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-4 col-md-offset-8">
                @if (!empty($pos_settings['amount_rounding_method']) && $pos_settings['amount_rounding_method'] > 0)
                    <small id="round_off"><br>(@lang('lang_v1.round_off'): <span id="round_off_text">0</span>)</small>
                    <br />
                    <input type="hidden" name="round_off_amount" id="round_off_amount" value=0>
                @endif
                <div><b>@lang('sale.total_payable'): </b>
                    <input type="hidden" name="final_total" id="final_total_input" value="{{ $cart_data['sub_total'] }}">
                    <span id="total_payable">{{ $cart_data['sub_total'] }}</span>
                </div>
            </div>
            <input type="hidden" name="is_direct_sale" value="1">
        @endcomponent

        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" id="submit-sell" class="btn btn-primary btn-big">@lang('messages.save')</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script>
        $(document).on('click', '.quantity-up', function(e) {
            e.preventDefault();
            var qtyProduct = $(this).parent().parent().find('.pos_quantity');
            let value = +qtyProduct.val();
            let max = +qtyProduct.attr('max');
            qtyProduct.val(value + 1);
            updateCart($(this), true);
        });
        $(document).on('click', '.quantity-down', function(e) {
            e.preventDefault();
            var qtyProduct = $(this).parent().parent().find('.pos_quantity');
            let value = +qtyProduct.val();
            let max = +qtyProduct.attr('max');
            let min = +qtyProduct.attr('min');

            if (value > min) {
                value = value - 1;
                qtyProduct.val(value)
            }

            updateCart($(this), true);
        });


        function updateCart(self, updateOldQty = false) {
            let CartUpdateR = $('#CartUpdateR');
            var cartId = self.parent().parent().find('.cart_id').val();
            var qtyProduct = self.parent().parent().find('.pos_quantity').val();
            var prodId = self.parent().parent().find('.pos_quantity').data('product_id');

            // Set Send Data
            let sendData = [{
                'cart_id': cartId,
                'product_id': prodId,
                'quantity': qtyProduct,
            }];
            console.log(sendData);
            $.ajax({
                url: "{{ route('product_catalogue.updatecart') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'cart': sendData,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === true) {
                        $('#cart_table').html(res.data.resultCheckout);
                        window.location.reload();
                    }
                },
                error: function(reject) {
                    if (reject.status === 422) {
                        var response = JSON.parse(reject.responseText);
                        var errorString = '<small class="text-danger">';
                        $.each(response.errors, function(key, value) {
                            errorString += value;
                        });
                        // errorString += '</small>';
                        // console.log(errorString)
                        // msgErrors.empty();
                        // msgErrors.append(errorString);

                    }
                }
            });
        }

        $(document).on('click', '.removeItemCart', function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            var id = $(this).data('cart_id');
            $.ajax({
                url: "{{ route('product_catalogue.deleteItem') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'id': id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === true) {
                        window.location.reload();
                    }
                }
            });
        });
    </script>

@endsection
