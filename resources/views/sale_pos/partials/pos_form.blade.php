<!-- include module fields -->
@if (!empty($pos_module_data))
    @foreach ($pos_module_data as $key => $value)
        @if (!empty($value['view_path']))
            @includeIf($value['view_path'], ['view_data' => $value['view_data']])
        @endif
    @endforeach
@endif
<div class="row">
    <div class="col-sm-12 pos_product_div">
        <input type="hidden" name="sell_price_tax" id="sell_price_tax" value="{{ $business_details->sell_price_tax }}">

        <!-- Keeps count of product rows -->
        <input type="hidden" id="product_row_count" value="0">
        @php
            $hide_tax = '';
            if (session()->get('business.enable_inline_tax') == 0) {
                $hide_tax = 'hide';
            }
        @endphp
        <table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
            <thead>
                <tr>
                    <th class="tex-center @if (!empty($pos_settings['inline_service_staff'])) col-md-3 @else col-md-4 @endif">
                        @lang('sale.product') @show_tooltip(__('lang_v1.tooltip_sell_product_column'))
                    </th>
                    <th class="text-center col-md-3">
                        @lang('sale.qty')
                    </th>
                    @if (!empty($pos_settings['inline_service_staff']))
                        <th class="text-center col-md-2">
                            @lang('restaurant.service_staff')
                        </th>
                    @endif
                    <th class="text-center col-md-2 {{ $hide_tax }}">
                        @lang('sale.price_inc_tax')
                    </th>
                    <th class="text-center col-md-2">
                        @lang('sale.subtotal')
                    </th>
                    <th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
