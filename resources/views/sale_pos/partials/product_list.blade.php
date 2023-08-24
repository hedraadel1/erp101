<style>
    .probox {
        position: relative;
        background: #fff;
        border-top: 3px solid #d2d6de !important;
        border-bottom: 3px solid #d2d6de;
        border-right: 3px solid #d2d6de;
        border-left: 3px solid #d2d6de;
        margin-bottom: 20px;

        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        transform: translate3d(0, 0, 0);
    }
</style>

@forelse($products as $product)
    <div style="padding-right: unset !important;padding: 2px;padding-left: unset !important;"
        class="col-md-2 probox box-solid product_list no-print">
        <div class="product_box" data-variation_id="{{ $product->id }}"
            title="{{ $product->name }} @if ($product->type == 'variable') - {{ $product->variation }} @endif {{ '(' . $product->sub_sku . ')' }} @if (!empty($show_prices)) @lang('lang_v1.default') - @format_currency($product->selling_price) @foreach ($product->group_prices as $group_price) @if (array_key_exists($group_price->price_group_id, $allowed_group_prices)) {{ $allowed_group_prices[$group_price->price_group_id] }} - @format_currency($group_price->price_inc_tax) @endif @endforeach @endif">

            <div style="top:0;width:100%;height:40px; {{ $product->qty_available > 0 ? ' background: linear-gradient(to right, #232526, #414345);color:white' : '' }}"
                class="{{ $product->qty_available < 0 ? 'bg-red' : '' }}" class="">{{ $product->name }}
                @if ($product->type == 'variable')
                    - {{ $product->variation }}
                @endif
            </div>

            <div class="image-container"
                style="background-image: url(
					@if (count($product->media) > 0) {{ $product->media->first()->display_url }}
					@elseif(!empty($product->product_image))
						{{ asset('/uploads/img/' . rawurlencode($product->product_image)) }}
					@else
						{{ asset('/img/default.png') }} @endif
				);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">

            </div>

            <div class="text_div">


                {{-- <small class="text-muted">
				({{$product->sub_sku}})
			</small> --}}
                <div
                    style="bottom:0;width:100%;height:20px;  background: linear-gradient(to right, #232526, #414345);color:white;margin-top:5px">
                    ({{ $product->selling_price }})
                </div>

                <div style="bottom:0;width:100%;height:20px;background: darkgrey;color:white" class="">
                    ({{ $product->qty_available }})
                </div>
            </div>

        </div>
    </div>
@empty
    <input type="hidden" id="no_products_found">
    <div class="col-md-12">
        <h4 class="text-center">
            @lang('lang_v1.no_products_to_display')
        </h4>
    </div>
@endforelse
