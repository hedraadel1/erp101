<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

@php
    $dashboard_settings = json_decode(session('business.dashboard_settings'), true) ?? [];
    // dd($dashboard_settings);
@endphp
{{-- @if (isset($dashboard_settings['enable_brand_store']) || is_admin()) --}}
{{-- {{ dd($dashboard_settings['enable_brand_store'] == '1') }} --}}
@if (!empty($dashboard_settings['enable_brand_store']) || is_admin())
    <div class="col-sm-12">
        @component('components.widget', ['class' => 'box-warning'])
            @slot('title')
                <b class="text-white">{{ __('superadmin::lang.brand_store') }} </b>
            @endslot
            {{-- @if (is_admin())
                @slot('tool')
                    {!! Form::open([
                        'url' => action('BusinessController@postBusinessSettings'),
                        'method' => 'post',
                        'id' => 'bussiness_edit_form',
                        'files' => true,
                    ]) !!}
                    <input type="hidden" name="dashboard_settings[enable_brand_store]" value="1" class="input-icheck"
                        id="enable_brand_store">

                    <button class="btn button-29" type="submit">امكانية عرض المتجر لجميع المستخدمين </button>
                    {!! Form::close() !!}
                @endslot
            @endif --}}
            <div class="row">
                @foreach ($brand_store_products as $item)
                    <div class="col-md-3  ">
                        <div class="box">
                            <div
                                style="height: 150px;background-position: center;background-repeat: no-repeat;background-size: cover;;background-image: url({{ $item->image_url }})">
                            </div>
                            @if ($item->is_distinct == '1')
                                <div class="ribbon ribbon-bookmark ribbon-vertical-right ribbon-info">
                                    <i class="fas fa-star text-white"></i>

                                </div>
                            @endif
                            @if ($item->price == 0)
                                <span class="w3-tag w3-green w3-padding"
                                    style="position: absolute;top: 0px;left:-2px;padding: 5px;">
                                    FREE
                                </span>
                            @endif
                            @if (isset($item->get_product_discount($item->id)->discount))
                                @if ($item->get_product_discount($item->id)->is_limited_offer == 1)
                                    @if (
                                        $item->get_product_discount($item->id)->date_from <= date('Y-m-d') &&
                                            $item->get_product_discount($item->id)->date_to >= date('Y-m-d'))
                                        <span class="w3-tag  discount"
                                            style="position: absolute;top: 117px;width: 93%;left:12px;padding: 5px;">
                                            {{-- خصم: --}}
                                            <small>
                                                @if ($item->get_product_discount($item->id)->type == 'fixed')
                                                    <small> @format_currency($item->get_product_discount($item->id)->discount)</small>
                                                @else
                                                    {{ round($item->get_product_discount($item->id)->discount, 0) }}%
                                                @endif
                                                | <span id="demo"></span>

                                                <input type="hidden" id="date_from"
                                                    value="{{ $item->get_product_discount($item->id)->date_to }}">
                                            </small>
                                        </span>
                                    @endif
                                @else
                                    <span
                                        class="w3-tag w3-red discount"style="padding: 5px;position: absolute;top: 20px;width: 25%;left: -4px;rotate: -43deg;">
                                        {{-- style="position: absolute;top: 117px;width: 93%;left:12px;padding: 5px;"> --}}
                                        {{-- خصم: --}}

                                        @if ($item->get_product_discount($item->id)->type == 'fixed')
                                            <small> @format_currency($item->get_product_discount($item->id)->discount)</small>
                                        @else
                                            {{ round($item->get_product_discount($item->id)->discount, 0) }}%
                                        @endif

                                    </span>
                                @endif
                            @endif


                            <div class="box-body " style="padding: 7px">
                                <h4 style="    height: 50px;overflow:hidden">{{ $item->name }}</h4>
                                @if ($item->price > 0)
                                    <span class="new ">
                                        <b class="h3"> @format_currency($item->price_after_discount)</b>
                                    </span>
                                    @if (isset($item->get_product_discount($item->id)->discount))
                                        <span class="old">
                                            <s> @format_currency($item->price)</s>
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <div class="box-footer">
                                <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@productDetails', $item->id) }}"
                                    class="btn Btn-Brand Btn-bx btn-info btn-block">التفاصيل</a>
                                {{-- <a href="" class="btn Btn-Brand Btn-bx btn-primary width-120">شراء</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <iframe style="width: 100%;height:400px"
                src="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@getBrandStoreIfram') }}"
                frameborder="0"></iframe> --}}
            {{ $brand_store_products->appends(request()->query())->render() }}
        @endcomponent
    </div>

@endif
{{-- @endif --}}
