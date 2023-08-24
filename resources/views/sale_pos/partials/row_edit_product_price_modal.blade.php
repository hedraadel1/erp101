<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ $product->product_name }} - {{ $product->sub_sku }}</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-xs-6 @if (!auth()->user()->can('edit_product_price_from_sale_screen')) hide @endif">
                    @php
                        $pos_unit_price = !empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price;
                    @endphp
                    {{-- سعر جزئى  --}}
                    <label>@lang('sale.unit_price')</label>
                    <input type="text" name="products[{{ $row_count }}][unit_price]"
                        class="form-control pos_unit_price input_number mousetrap" value="{{ $pos_unit_price }}"
                        @if (!empty($pos_settings['enable_msp'])) data-rule-min-value="{{ $pos_unit_price }}" data-msg-min-value="{{ __('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($pos_unit_price)]) }}" @endif>
                </div>
                {{-- ================ السعر كلى --}}
                <div class="form-group col-xs-6 hide">

                    <label>السعر كلى</label>
                    {{-- <input type="text" name="all" class="form-control pos_unit_price input_number mousetrap" value="{{$multiplier}}">  --}}
                    @php
                        $subtotal_type = !empty($pos_settings['is_pos_subtotal_editable']) ? 'text' : 'hidden';
                    @endphp
                    <input type="text"
                        class="form-control pos_line_total 
					@if (!empty($pos_settings['is_pos_subtotal_editable'])) input_number @endif"
                        value="{{ @num_format($product->quantity_ordered * $unit_price_inc_tax) }}">
                    {{-- ============================== --}}
                </div>

                @if (!auth()->user()->can('edit_product_price_from_sale_screen'))
                    <div class="form-group col-xs-12">
                        <strong>@lang('sale.unit_price'):</strong>
                        {{ @num_format(!empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price) }}
                    </div>
                @endif



                <div class="form-group col-xs-12 col-sm-6 input-number hide">
                    @foreach ($sub_units as $key => $value)
                        @if ($value['multiplier'] >= $multiplier)
                            @php
                                $maxqty = $value['multiplier'];
                            @endphp
                        @endif
                    @endforeach
                    <label>كميه جزئى</label>
                    <br>
                    <button style="width: 100%;height: 20px;padding:unset !important" type="button"
                        class="btn btn-default btn-flat quantity-down part"><i
                            class="fa fa-minus text-danger"></i></button>
                    <input type="text" data-min="1" max="{{ isset($maxqty) ? $maxqty : '' }}" id="part"
                        class="form-control pos_quantity input_number mousetrap input_quantity part"
                        value="{{ @format_quantity($product->quantity_ordered) }}"
                        name="products[{{ $row_count }}][quantity]"
                        data-allow-overselling="@if (empty($pos_settings['allow_overselling'])) {{ 'false' }}@else{{ 'true' }} @endif">
                    <button style="width:100%;height: 16px;display:inline;padding:unset !important" type="button"
                        class="btn btn-default btn-flat quantity-up part"><i
                            class="fa fa-plus text-success"></i></button>
                </div>
                {{-- ================ كميه كلى --}}

                <div class="form-group col-xs-12 col-sm-6 input-number hide">

                    <label>كميه كلى</label>
                    <br>
                    <button style="width:100%;height: 20px;display:inline;padding:unset !important" type="button"
                        class="btn btn-default btn-flat quantity-down all"><i
                            class="fa fa-minus text-danger"></i></button>
                    <input type="text" data-min="0" id="all ald"
                        class="form-control pos_quantity input_number mousetrap input_quantity all" value="0"
                        name="products[{{ $row_count }}][quantity_new]" data-allow-overselling="">
                    <button style="width:100%;height: 16px;display:inline;padding:unset !important" type="button"
                        class="btn btn-default btn-flat quantity-up all"><i
                            class="fa fa-plus text-success"></i></button>
                </div>
                {{-- ========================= --}}
                <div class="form-group col-xs-12 col-sm-6 @if (!$edit_discount) hide @endif">
                    <label>@lang('sale.discount_type')</label>
                    {!! Form::select(
                        "products[$row_count][line_discount_type]",
                        ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')],
                        $discount_type,
                        ['class' => 'form-control row_discount_type'],
                    ) !!}
                </div>
                <div class="form-group col-xs-12 col-sm-6 @if (!$edit_discount) hide @endif">
                    <label>@lang('sale.discount_amount')</label>
                    {!! Form::text("products[$row_count][line_discount_amount]", @num_format($discount_amount), [
                        'class' => 'form-control input_number row_discount_amount',
                    ]) !!}
                </div>
                @if (!empty($discount))
                    <div class="form-group col-xs-12">
                        <p class="help-block">{!! __('lang_v1.applied_discount_text', [
                            'discount_name' => $discount->name,
                            'starts_at' => $discount->formated_starts_at,
                            'ends_at' => $discount->formated_ends_at,
                        ]) !!}</p>
                    </div>
                @endif
                <div class="form-group col-xs-12 {{ $hide_tax }}">
                    <label>@lang('sale.tax')</label>

                    {!! Form::hidden("products[$row_count][item_tax]", @num_format($item_tax), ['class' => 'item_tax']) !!}

                    {!! Form::select(
                        "products[$row_count][tax_id]",
                        $tax_dropdown['tax_rates'],
                        $tax_id,
                        ['placeholder' => 'Select', 'class' => 'form-control tax_id'],
                        $tax_dropdown['attributes'],
                    ) !!}
                </div>
                @if (!empty($warranties))
                    <div class="form-group col-xs-12">
                        <label>@lang('lang_v1.warranty')</label>
                        {!! Form::select("products[$row_count][warranty_id]", $warranties, $warranty_id, [
                            'placeholder' => __('messages.please_select'),
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                @endif
                <div class="form-group col-xs-12">
                    <label>@lang('lang_v1.description')</label>
                    <textarea class="form-control" name="products[{{ $row_count }}][sell_line_note]" rows="3">{{ $sell_line_note }}</textarea>
                    <p class="help-block">@lang('lang_v1.sell_line_description_help')</p>
                </div>
                @if (is_product_enabled('279'))
                    <div class="form-group col-xs-12">
                        <label> السريال الخاص بالمنتج</label>
                        <input type="text" name="products[{{ $row_count }}][sell_line_serial_code]"
                            class="form-control check_seral" data-id="{{ $product->product_id }}">
                        <p class="help-block">ادخل السريال الخاص بالمنتج</p>
                        <p class="text-danger " id="msgErrs"></p>
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>
    </div>
</div>
