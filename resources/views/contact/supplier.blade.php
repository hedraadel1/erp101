@extends('layouts.app')
@section('title', __('lang_v1.' . $type . 's'))
@php
    $api_key = env('GOOGLE_MAP_API_KEY');
@endphp
@if (!empty($api_key))
    @section('css')
        @include('contact.partials.google_map_styles')

    @endsection
@endif

@section('content')
    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style=" {{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">
                @lang('lang_v1.' . $type . 's')
                {{-- <small>@lang('contact.manage_your_contact', ['contacts' => __('lang_v1.' . $type . 's')])</small> --}}
            </h3>
        </div>
    </section>
    {{-- <section class="content-header">
        <h1> @lang('lang_v1.' . $type . 's')
            <small>@lang('contact.manage_your_contact', ['contacts' => __('lang_v1.' . $type . 's')])</small>
        </h1>
    </section> --}}

    <!-- Main content -->
    <section class="content">
        @component('components.filters', ['title' => __('report.filters')])

            @if ($type == 'supplier')
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_purchase_due', 1, false, ['class' => 'input-icheck', 'id' => 'has_purchase_due']) !!} <strong>@lang('report.purchase_due')</strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            {!! Form::checkbox('has_purchase_return', 1, false, ['class' => 'input-icheck', 'id' => 'has_purchase_return']) !!} <strong>@lang('lang_v1.purchase_return')</strong>
                        </label>
                    </div>
                </div>
            @endif
            <div class="col-md-2">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('has_advance_balance', 1, false, ['class' => 'input-icheck', 'id' => 'has_advance_balance']) !!} <strong>@lang('lang_v1.advance_balance')</strong>
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('has_opening_balance', 1, false, [
                            'class' => 'input-icheck opening_balance',
                            'id' => 'has_opening_balance',
                        ]) !!} <strong>@lang('lang_v1.opening_balance')</strong>
                    </label>
                </div>
            </div>
            @if ($type == 'customer')
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('region', __('lang_v1.region')) !!}
                        {!! Form::text('region', null, ['class' => 'form-control', 'id' => 'region']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="has_no_sell_from">@lang('lang_v1.has_no_sell_from'):</label>
                        {!! Form::select(
                            'has_no_sell_from',
                            [
                                'one_month' => __('lang_v1.one_month'),
                                'three_months' => __('lang_v1.three_months'),
                                'six_months' => __('lang_v1.six_months'),
                                'one_year' => __('lang_v1.one_year'),
                            ],
                            null,
                            ['class' => 'form-control', 'id' => 'has_no_sell_from', 'placeholder' => __('messages.please_select')],
                        ) !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cg_filter">@lang('lang_v1.customer_group'):</label>
                        {!! Form::select('cg_filter', $customer_groups, null, ['class' => 'form-control', 'id' => 'cg_filter']) !!}
                    </div>
                </div>
            @endif

            @if (config('constants.enable_contact_assign') === true)
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('assigned_to', __('lang_v1.assigned_to') . ':') !!}
                        {!! Form::select('assigned_to', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                    </div>
                </div>
            @endif

            <div class="col-md-3">
                <div class="form-group">
                    <label for="status_filter">@lang('sale.status'):</label>
                    {!! Form::select(
                        'status_filter',
                        ['active' => __('business.is_active'), 'inactive' => __('lang_v1.inactive')],
                        null,
                        ['class' => 'form-control', 'id' => 'status_filter', 'placeholder' => __('lang_v1.none')],
                    ) !!}
                </div>
            </div>
        @endcomponent
        @if (is_product_enabled('270'))
            @component('components.widget', ['title' => 'أحصائيات مختصره'])
                <div class="ag-format-container" style="width: 100%">
                    {{-- @if ($type == 'customer') --}}
                    <div class="ag-courses_box ">
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link" style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title" style="    margin: 0px 0 -45px;">
                                    عدد الموردين
                                </div>
                                <div class="ag-courses-item_date-box" id="customer_count">
                                    {{-- {{ $customer_count }} --}}

                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title"style="    margin: 0px 0 -45px;">
                                    اجمالى المشتريات

                                </div>
                                <div class="ag-courses-item_date-box" id="total_debit">
                                    {{-- {{ $total_debit }} --}}

                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title"style="    margin: 0px 0 -45px;">
                                    اجمالى المرتجعات
                                    {{-- اجمالى المرتجعات --}}
                                </div>
                                <div class="ag-courses-item_date-box" id="total_sell_return">
                                    {{-- {{ $total_sell_return }} --}}

                                </div>
                            </a>
                        </div>



                    </div>
                    {{-- @endif --}}
                </div>
            @endcomponent
        @endif
        <input type="hidden" value="{{ $type }}" id="contact_type">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('contact.all_your_contact', ['contacts' => __('lang_v1.' . $type . 's')]),
        ])
            @if (auth()->user()->can('supplier.create') ||
                    auth()->user()->can('supplier.view_own'))
                @slot('tool')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-tools">
                                <button type="button" class="button-add btn-modal"
                                    data-href="{{ action('ContactController@create', ['type' => $type]) }}"
                                    data-container=".contact_modal">
                                    <i class="fa fa-plus maricon"></i> @lang('messages.add')</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-tools">
                                <button type="button" class="  btn-modal button-add"
                                    data-href="{{ action('ContactController@shortCreate', ['type' => $type]) }}"
                                    data-container=".contact_modal">
                                    <i class="fa fa-plus maricon"></i> اضافة مختصرة
                                </button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endif
            @if (auth()->user()->can('supplier.view') ||
                    auth()->user()->can('supplier.view_own'))
                <table class="table table-bordered table-striped" id="contact_table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input style="width: 40px;" type="checkbox" id="select-all-row" data-table-id="contact_table">
                            </th>
                            <th>@lang('messages.action')</th>
                            <th>@lang('lang_v1.contact_id')</th>
                            @if ($type == 'supplier')
                                <th>@lang('business.business_name')</th>
                                <th>@lang('contact.name')</th>
                                <th>@lang('business.email')</th>
                                <th>@lang('contact.tax_no')</th>
                                <th>@lang('contact.pay_term')</th>
                                <th>@lang('lang_v1.balance_due')</th>
                                <th>@lang('lang_v1.advance_balance')</th>
                                <th>@lang('lang_v1.added_on')</th>
                                <th>@lang('business.address')</th>
                                <th>@lang('contact.mobile')</th>
                                <th>@lang('contact.total_purchase_due')</th>
                                <th>@lang('lang_v1.total_purchase_return_due')</th>

                            @endif
                            @php
                                $custom_labels = json_decode(session('business.custom_labels'), true);
                            @endphp
                            <th>
                                {{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_5'] ?? __('lang_v1.custom_field', ['number' => 5]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_6'] ?? __('lang_v1.custom_field', ['number' => 6]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_7'] ?? __('lang_v1.custom_field', ['number' => 7]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_8'] ?? __('lang_v1.custom_field', ['number' => 8]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_9'] ?? __('lang_v1.custom_field', ['number' => 9]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_10'] ?? __('lang_v1.custom_field', ['number' => 10]) }}
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="bg-gray font-17 text-center footer-total">
                            <td>
                                @if (auth()->user()->can('supplier.delete') ||
                                        auth()->user()->can('supplier.view_own'))
                                    {!! Form::open([
                                        'url' => action('ContactController@massDestroy'),
                                        'method' => 'post',
                                        'id' => 'mass_delete_form',
                                    ]) !!}
                                    {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']) !!}
                                    {!! Form::submit('حذف', [
                                        'class' => 'btn btn-xs btn-danger',
                                        'id' => 'delete-selected',
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td @if ($type == 'supplier') colspan="6"
                            @elseif($type == 'customer')
                                @if ($reward_enabled)
                                    colspan="9"
                                @else
                                    colspan="8" @endif
                                @endif>
                                <strong>
                                    @lang('sale.total'):
                                </strong>
                            </td>
                            <td class="footer_contact_due"></td>
                            <td class="footer_contact_return_due"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

            @endif
        @endcomponent

        <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade pay_contact_due_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        @include('contact.partials.screen_setting_modal')
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    @if (!empty($api_key))
        <script>
            // This example adds a search box to a map, using the Google Place Autocomplete
            // feature. People can enter geographical searches. The search box will return a
            // pick list containing a mix of places and predicted search terms.

            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

            function initAutocomplete() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: -33.8688,
                        lng: 151.2195
                    },
                    zoom: 10,
                    mapTypeId: 'roadmap'
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        map.setCenter(initialLocation);
                    });
                }


                // Create the search box and link it to the UI element.
                var input = document.getElementById('shipping_address');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                var markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        //set position field value
                        var lat_long = [place.geometry.location.lat(), place.geometry.location.lng()]
                        $('#position').val(lat_long);

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $api_key }}&libraries=places" async defer></script>
        <script type="text/javascript">
            $(document).on('shown.bs.modal', '.contact_modal', function(e) {
                initAutocomplete();
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.setting_screen_table', function(e) {
            e.preventDefault();
            // if (selected_rows.length > 0) {
            $('#screen_setting_modal').modal('show');

        });
        $(document).ready(function() {
            $(window).on('load', function() {
                $.ajax({
                    url: "{{ route('getscreen_setting', $type) }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        var cols = res.setting;
                        if (cols != null) {
                            $('.buttons-colvis').click();
                            $('.dt-button-collection').css('display', 'none');
                            $('.dt-button-collection  li').each(function(index, element) {
                                // console.log(cols);
                                if (cols[index]) {
                                    cols[index].display == '1' ? $(element)
                                        .click() :
                                        null;
                                } else {
                                    // $(element).click()
                                }
                            });
                        }
                    },

                });
                $('.buttons-colvis').css('display', 'none');
                $('.dt-buttons').append(
                    '<a role="button" class="btn btn-sm btn-primary setting_screen_table">اعدادات عرض الاعمدة</a>'
                );


            });
        });

        $(document).ready(function() {
            getStatistics();
        });
        $(document).on('ifChanged',
            ' #has_advance_balance, #has_opening_balance ,#has_sell_return,#has_sell_due,#has_no_sell_from',
            function() {
                var has_opening_balance = null;
                var has_advance_balance = null;
                var has_sell_return = null;
                var has_sell_due = null;

                if ($('#has_opening_balance').is(":checked")) {
                    has_opening_balance = $('#has_opening_balance').val();
                }
                if ($('#has_advance_balance').is(":checked")) {
                    has_advance_balance = $('#has_advance_balance').val();
                }
                if ($('#has_sell_return').is(":checked")) {
                    has_sell_return = $('#has_sell_return').val();
                }
                if ($('#has_sell_due').is(":checked")) {
                    has_sell_due = $('#has_sell_due').val();
                }
                $('#has_no_sell_from').on("change", function() {

                });
                getStatistics(has_opening_balance, has_advance_balance, has_sell_return, has_sell_due);


            });
        $(document).on('change', '#has_no_sell_from, #cg_filter, #status_filter, #assigned_to', function() {
            var has_opening_balance = null;
            var has_advance_balance = null;
            var has_sell_return = null;
            var has_sell_due = null;
            var status_filter = null;
            var assigned_to = null;
            var cg_filter = null;
            if ($('#has_no_sell_from').length > 0) {
                has_no_sell_from = $('#has_no_sell_from').val();
            }
            if ($('#status_filter').length > 0) {
                status_filter = $('#status_filter').val();
            }
            if ($('#assigned_to').length > 0) {
                assigned_to = $('#assigned_to').val();
            }
            if ($('#cg_filter').length > 0) {
                cg_filter = $('#cg_filter').val();
            }

            getStatistics(has_opening_balance, has_advance_balance, has_sell_return, has_sell_due,
                has_no_sell_from, status_filter, assigned_to, cg_filter);
        });
        // $('#region').on('keydwon', function() {
        //     region = $('#region').val();
        //     getStatistics(has_opening_balance, has_advance_balance, has_sell_return, has_sell_due,
        //         has_no_sell_from, status_filter, assigned_to, cg_filter, region);
        // });

        function getStatistics(has_opening_balance = null, has_advance_balance = null, has_sell_return = null,
            has_sell_due = null, has_no_sell_from = null, status_filter = null, assigned_to = null, cg_filter = null,
            region = null) {
            $.ajax({
                url: "{{ route('contact.getStatistics', ['type' => $type]) }}",
                type: 'get',

                dataType: 'json',
                beforeSend: function() {
                    $('#customer_count').html('');
                    $('#total_sell_return').html('');
                    $('#total_debit').html('');
                    $('#customer_count').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#total_sell_return').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#total_debit').append('<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                },
                data: {
                    'has_opening_balance': has_opening_balance,
                    'has_advance_balance': has_advance_balance,
                    'has_sell_return': has_sell_return,
                    'has_sell_due': has_sell_due,
                    'has_no_sell_from': has_no_sell_from,
                    'contact_status': status_filter,
                    'assigned_to': assigned_to,
                    'customer_group_id': cg_filter,
                    'region': region,
                },
                success: function(res) {
                    $('#customer_count').html(res.customer_count);
                    $('#total_sell_return').html(res.total_sell_return);
                    $('#total_debit').html(res.total_debit);

                },

            });
        }


        $(document).on('click', '#delete-selected', function(e) {
            e.preventDefault();
            var selected_rows = getSelectedRows();

            if (selected_rows.length > 0) {
                $('input#selected_rows').val(selected_rows);
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $('form#mass_delete_form').submit();
                    }
                });
            } else {
                $('input#selected_rows').val('');
                swal('@lang('lang_v1.no_row_selected')');
            }
        });
    </script>
@endsection
