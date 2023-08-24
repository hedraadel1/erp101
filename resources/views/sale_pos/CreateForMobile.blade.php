@extends('layouts.app')

@section('title', __('sale.pos_sale'))

@section('content')

    {{-- @if (empty($is_direct_sell)) --}}
    {{-- <div class="modal fade" id="row_edit_product_price_modal" tabindex="-1" role="dialog">
    @include('sale_pos.partials.row_edit_product_price_modal')
  </div> --}}
    {{-- @endif --}}

    <section style="padding-top:unset !important;padding-bottom:unset !important" class="content no-print">
        <input type="hidden" id="amount_rounding_method" value="{{ $pos_settings['amount_rounding_method'] ?? '' }}">
        @if (!empty($pos_settings['allow_overselling']))
            <input type="hidden" id="is_overselling_allowed">
        @endif
        @if (session('business.enable_rp') == 1)
            <input type="hidden" id="reward_point_enabled">
        @endif
        @php
            $is_discount_enabled = $pos_settings['disable_discount'] != 1 ? true : false;
            $is_rp_enabled = session('business.enable_rp') == 1 ? true : false;
        @endphp
        {!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'id' => 'add_pos_sell_form']) !!}
        <div class="row mb-12">
            <div class="col-md-12">
                @include('sale_pos.partials.payment_modal')
                @include('sale_pos.partials.pos-input-form')
                @if (empty($pos_settings['disable_suspend']))
                    @include('sale_pos.partials.suspend_note_modal')
                @endif
                <div class="row">
                    <div
                        class="@if (empty($pos_settings['hide_product_suggestion'])) col-md-4 @else col-md-10 col-md-offset-1 @endif no-padding pr-12">
                        <div style="border-radius: 25px;height: 515px;"
                            class="box box-solid mb-12 @if (!isMobile())  @endif">
                            <div class="box-body pb-0">
                                {!! Form::hidden('location_id', $default_location->id ?? null, [
                                    'id' => 'location_id',
                                    'data-receipt_printer_type' => !empty($default_location->receipt_printer_type)
                                        ? $default_location->receipt_printer_type
                                        : 'browser',
                                    'data-default_payment_accounts' => $default_location->default_payment_accounts ?? '',
                                ]) !!}
                                <!-- sub_type -->
                                {!! Form::hidden('sub_type', isset($sub_type) ? $sub_type : null) !!}
                                <input type="hidden" id="item_addition_method"
                                    value="{{ $business_details->item_addition_method }}">

                                {{-- first row header --}}
                                @include('sale_pos.partials.pos_form')





                                @if (empty($pos_settings['disable_recurring_invoice']))
                                    @include('sale_pos.partials.recurring_invoice_modal')
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (empty($pos_settings['hide_product_suggestion']) && !isMobile())
                        <div class="col-md-8 no-padding">
                            @include('sale_pos.partials.pos_sidebar')
                        </div>
                    @endif
                </div>
            </div>

        </div>
        @include('sale_pos.partials.pos_form_totals')
        @include('sale_pos.partials.pos_form_actionsForMobile')
        {!! Form::close() !!}
    </section>

    <!-- This will be printed -->
    <section class="invoice print_section" id="receipt_section">
    </section>
    <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        @include('contact.create', ['quick_add' => true])
    </div>
    @if (empty($pos_settings['hide_product_suggestion']) && isMobile())
        @include('sale_pos.partials.mobile_product_suggestions')
    @endif
    <!-- /.content -->
    <div class="modal fade register_details_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade close_register_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <!-- quick product modal -->
    <div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

    <div class="modal fade" id="expense_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade" id="modal_payment" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    @include('sale_pos.partials.configure_search_modal')

    @include('sale_pos.partials.recent_transactions_modal')
    @include('sale_pos.partials.invoice_booking_modal')
    @include('sale_pos.partials.product_booking_modal', ['customers' => $customers])

    @include('sale_pos.partials.weighing_scale_modal')

@stop
@section('css')
    <!-- include module css -->
    @if (!empty($pos_module_data))
        @foreach ($pos_module_data as $key => $value)
            @if (!empty($value['module_css_path']))
                @includeIf($value['module_css_path'])
            @endif
        @endforeach
    @endif
@stop
@section('javascript')
    <script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    @include('sale_pos.partials.keyboard_shortcuts')

    <!-- Call restaurant module if defined -->
    @if (in_array('tables', $enabled_modules) ||
            in_array('modifiers', $enabled_modules) ||
            in_array('service_staff', $enabled_modules))
        <script src="{{ asset('js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
    <!-- include module js -->
    @if (!empty($pos_module_data))
        @foreach ($pos_module_data as $key => $value)
            @if (!empty($value['module_js_path']))
                @includeIf($value['module_js_path'], ['view_data' => $value['view_data']])
            @endif
        @endforeach
    @endif


    <script>
        $('select#customer_id').on('change', function() {

            $.ajax({
                method: 'GET',
                url: '/contacts/get-view-url',
                data: {
                    contact_id: $(this).val(),

                },
                dataType: 'json',
                success: function(re) {
                    var html =
                        `<a target="_blank" class="btn btn-default bg-white btn-flat" href="` + re.url +
                        `"><i class="fa fa-eye"></i></a>`;
                    $('div#link-show').empty();
                    $('div#link-show').append(html);
                },
            });


        });
    </script>

    <script>
        $('#btnfilter').on('click', function() {
            if ($('#section_filter').hasClass('hide')) {
                setCookie('filter', '0', '30');
            } else {
                setCookie('filter', '1', '30');
            }
            $('#section_filter').toggleClass('hide');
        });

        function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            let user = getCookie("filter");
            if (user == '0') {
                $('#section_filter').removeClass('hide')
            } else {
                $('#section_filter').addClass('hide');
            }
        }

        function eraseCookie(c_name) {
            setCookie(c_name, "", -1);
        }
        window.onload = checkCookie();
    </script>
@endsection
