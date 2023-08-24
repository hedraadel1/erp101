@extends('layouts.app')
@section('title', __('lang_v1.all_sales'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('sale.sells')
            </h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            @include('sell.partials.sell_list_filters')
            @if (!empty($sources))
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_source', __('lang_v1.sources') . ':') !!}

                        {!! Form::select('sell_list_filter_source', $sources, null, [
                            'class' => 'form-control select2',
                            'style' => 'width:100%',
                            'placeholder' => __('lang_v1.all'),
                        ]) !!}
                    </div>
                </div>
            @endif
        @endcomponent
        @if (is_product_enabled('273'))
            @include('sell.section_statistics')
        @endif

        @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.all_sales')])
            @can('direct_sell.access')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <a class="btn btn-block button-add" href="{{ action('SellController@create') }}">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @if (auth()->user()->can('direct_sell.view') ||
                    auth()->user()->can('view_own_sell_only') ||
                    auth()->user()->can('view_commission_agent_sell'))
                @php
                    $custom_labels = json_decode(session('business.custom_labels'), true);
                @endphp
                <table class="table table-bordered table-striped ajax_view" id="sell_table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all-row" data-table-id="sell_table">
                            </th>
                            <th>@lang('messages.action')</th>
                            <th>@lang('messages.date')</th>
                            <th>@lang('sale.invoice_no')</th>
                            <th>@lang('sale.customer_name')</th>
                            <th>@lang('lang_v1.contact_no')</th>
                            <th>@lang('sale.location')</th>
                            <th>@lang('sale.payment_status')</th>
                            <th>@lang('lang_v1.payment_method')</th>
                            <th>@lang('sale.total_amount')</th>
                            <th>@lang('sale.total_paid')</th>
                            <th>@lang('lang_v1.sell_due')</th>
                            <th>@lang('lang_v1.sell_return_due')</th>
                            <th>@lang('lang_v1.shipping_status')</th>
                            <th>@lang('lang_v1.total_items')</th>
                            <th>@lang('lang_v1.types_of_service')</th>
                            <th>{{ $custom_labels['types_of_service']['custom_field_1'] ?? __('lang_v1.service_custom_field_1') }}
                            </th>
                            <th>{{ $custom_labels['sell']['custom_field_1'] ?? '' }}</th>
                            <th>{{ $custom_labels['sell']['custom_field_2'] ?? '' }}</th>
                            <th>{{ $custom_labels['sell']['custom_field_3'] ?? '' }}</th>
                            <th>{{ $custom_labels['sell']['custom_field_4'] ?? '' }}</th>
                            <th>@lang('lang_v1.added_by')</th>
                            <th>@lang('sale.sell_note')</th>
                            <th>@lang('sale.staff_note')</th>
                            <th>@lang('sale.shipping_details')</th>
                            <th>@lang('restaurant.table')</th>
                            <th>@lang('restaurant.service_staff')</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr class="bg-gray font-17 footer-total text-center">
                            <td>
                                @if (auth()->user()->can('direct_sell.delete') ||
                                        auth()->user()->can('sell.delete') ||
                                        auth()->user()->can('so.delete'))
                                    {!! Form::open([
                                        'url' => action('SellPosController@massDestroy'),
                                        'method' => 'post',
                                        'id' => 'mass_delete_form',
                                    ]) !!}
                                    {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']) !!}
                                    {!! Form::submit('حذف', [
                                        'class' => 'btn btn-xs btn-danger ',
                                        'id' => 'delete-selected',
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                            <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                            <td class="footer_payment_status_count"></td>
                            <td class="payment_method_count"></td>
                            <td class="footer_sale_total"></td>
                            <td class="footer_total_paid"></td>
                            <td class="footer_total_remaining"></td>
                            <td class="footer_total_sell_return_due"></td>
                            <td colspan="2"></td>
                            <td class="service_type_count"></td>
                            <td colspan="7"></td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        @endcomponent
    </section>
    <!-- /.content -->
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    @include('sell.partials.screen_setting_modal')

    <!-- This will be printed -->
    <!-- <section class="invoice print_section" id="receipt_section">
                                                                                                                                                                                                    </section> -->

@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            //Date range as a button
            $('#sell_list_filter_date_range').daterangepicker(
                dateRangeSettings,
                function(start, end) {
                    $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                        moment_date_format));
                    sell_table.ajax.reload();
                }
            );
            $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#sell_list_filter_date_range').val('');
                sell_table.ajax.reload();
            });

            sell_table = $('#sell_table').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [
                    [1, 'desc']
                ],
                "ajax": {
                    "url": "/sells",
                    "data": function(d) {
                        if ($('#sell_list_filter_date_range').val()) {
                            var start = $('#sell_list_filter_date_range').data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate
                                .format('YYYY-MM-DD');
                            d.start_date = start;
                            d.end_date = end;
                        }
                        d.is_direct_sale = 1;

                        d.location_id = $('#sell_list_filter_location_id').val();
                        d.customer_id = $('#sell_list_filter_customer_id').val();
                        d.payment_status = $('#sell_list_filter_payment_status').val();
                        d.created_by = $('.sell_created_by').val();
                        d.sales_cmsn_agnt = $('#sales_cmsn_agnt').val();
                        d.service_staffs = $('#service_staffs').val();

                        if ($('#shipping_status').length) {
                            d.shipping_status = $('#shipping_status').val();
                        }

                        if ($('#sell_list_filter_source').length) {
                            d.source = $('#sell_list_filter_source').val();
                        }

                        if ($('#only_subscriptions').is(':checked')) {
                            d.only_subscriptions = 1;
                        }

                        d = __datatable_ajax_callback(d);
                    }
                },
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                columns: [{
                        data: 'mass_delete',
                        name: 'mass_delete',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'conatct_name',
                        name: 'conatct_name'
                    },
                    {
                        data: 'mobile',
                        name: 'contacts.mobile'
                    },
                    {
                        data: 'business_location',
                        name: 'bl.name'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'payment_methods',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'final_total',
                        name: 'final_total'
                    },
                    {
                        data: 'total_paid',
                        name: 'total_paid',
                        "searchable": false
                    },
                    {
                        data: 'total_remaining',
                        name: 'total_remaining'
                    },
                    {
                        data: 'return_due',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status'
                    },
                    {
                        data: 'total_items',
                        name: 'total_items',
                        "searchable": false
                    },
                    {
                        data: 'types_of_service_name',
                        name: 'tos.name',
                        @if (empty($is_types_service_enabled))
                            visible: false
                        @endif
                    },
                    {
                        data: 'service_custom_field_1',
                        name: 'service_custom_field_1',
                        @if (empty($is_types_service_enabled))
                            visible: false
                        @endif
                    },
                    {
                        data: 'custom_field_1',
                        name: 'transactions.custom_field_1',
                        @if (empty($custom_labels['sell']['custom_field_1']))
                            visible: false
                        @endif
                    },
                    {
                        data: 'custom_field_2',
                        name: 'transactions.custom_field_2',
                        @if (empty($custom_labels['sell']['custom_field_2']))
                            visible: false
                        @endif
                    },
                    {
                        data: 'custom_field_3',
                        name: 'transactions.custom_field_3',
                        @if (empty($custom_labels['sell']['custom_field_3']))
                            visible: false
                        @endif
                    },
                    {
                        data: 'custom_field_4',
                        name: 'transactions.custom_field_4',
                        @if (empty($custom_labels['sell']['custom_field_4']))
                            visible: false
                        @endif
                    },
                    {
                        data: 'added_by',
                        name: 'u.first_name'
                    },
                    {
                        data: 'additional_notes',
                        name: 'additional_notes'
                    },
                    {
                        data: 'staff_note',
                        name: 'staff_note'
                    },
                    {
                        data: 'shipping_details',
                        name: 'shipping_details'
                    },
                    {
                        data: 'table_name',
                        name: 'tables.name',
                        @if (empty($is_tables_enabled))
                            visible: false
                        @endif
                    },
                    {
                        data: 'waiter',
                        name: 'ss.first_name',
                        @if (empty($is_service_staff_enabled))
                            visible: false
                        @endif
                    },
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#sell_table'));
                },
                "footerCallback": function(row, data, start, end, display) {
                    var footer_sale_total = 0;
                    var footer_total_paid = 0;
                    var footer_total_remaining = 0;
                    var footer_total_sell_return_due = 0;
                    for (var r in data) {
                        footer_sale_total += $(data[r].final_total).data('orig-value') ? parseFloat($(
                            data[r].final_total).data('orig-value')) : 0;
                        footer_total_paid += $(data[r].total_paid).data('orig-value') ? parseFloat($(
                            data[r].total_paid).data('orig-value')) : 0;
                        footer_total_remaining += $(data[r].total_remaining).data('orig-value') ?
                            parseFloat($(data[r].total_remaining).data('orig-value')) : 0;
                        footer_total_sell_return_due += $(data[r].return_due).find('.sell_return_due')
                            .data('orig-value') ? parseFloat($(data[r].return_due).find(
                                '.sell_return_due').data('orig-value')) : 0;
                    }

                    $('.footer_total_sell_return_due').html(__currency_trans_from_en(
                        footer_total_sell_return_due));
                    $('.footer_total_remaining').html(__currency_trans_from_en(footer_total_remaining));

                    $('.footer_total_paid').html(__currency_trans_from_en(footer_total_paid));
                    $('.footer_sale_total').html(__currency_trans_from_en(footer_sale_total));

                    $('.footer_payment_status_count').html(__count_status(data, 'payment_status'));
                    $('.service_type_count').html(__count_status(data, 'types_of_service_name'));
                    $('.payment_method_count').html(__count_status(data, 'payment_methods'));
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(6)').attr('class', 'clickable_td');
                }
            });

            $(document).on('change',
                '#sell_list_filter_location_id, #sell_list_filter_customer_id, #sell_list_filter_payment_status, #created_by, #sales_cmsn_agnt, #service_staffs, #shipping_status, #sell_list_filter_source',
                function() {
                    sell_table.ajax.reload();
                });

            $('#only_subscriptions').on('ifChanged', function(event) {
                sell_table.ajax.reload();
            });
        });
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>


    <script>
        $(document).on('click', '.setting_screen_table', function(e) {
            e.preventDefault();
            // if (selected_rows.length > 0) {
            $('#screen_setting_modal').modal('show');

        });
        $(document).ready(function() {
            $(window).on('load', function() {
                $.ajax({
                    url: "{{ route('getscreen_setting', 'sell') }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        var cols = res.setting;
                        if (cols != null) {
                            $('.buttons-colvis').click();
                            $('.dt-button-collection').css('display', 'none');
                            $('.dt-button-collection  li').each(function(index, element) {
                                console.log(cols);
                                if (cols[index + 1]) {
                                    cols[index + 1].display == '1' ? $(element)
                                        .click() :
                                        null;
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
        $('#sell_list_filter_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                    moment_date_format));
                sell_table.ajax.reload();
            }
        );
        $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#sell_list_filter_date_range').val('');
            sell_table.ajax.reload();
        });
        $(document).on('change',
            '#sell_list_filter_date_range, #sell_list_filter_customer_id, #sell_list_filter_payment_status, #sell_list_filter_location_id',
            '#sales_cmsn_agnt, #active_state',
            function() {
                var start = null;
                var end = null;
                var customer_id = null;
                var payment_status = null;
                var location_id = null;
                var agent_id = null;
                var active_state = null;
                var unit_id = null;
                if ($('#sell_list_filter_date_range').val()) {
                    start = $('#sell_list_filter_date_range').data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('#sell_list_filter_date_range').data('daterangepicker').endDate
                        .format('YYYY-MM-DD');
                    // d.start_date = start;
                    // d.end_date = end;
                }
                if ($('#sell_list_filter_payment_status').length > 0) {
                    payment_status = $('#sell_list_filter_payment_status').val();
                }
                if ($('#sales_cmsn_agnt').length > 0) {
                    agent_id = $('#sales_cmsn_agnt').val();
                }
                if ($('#sell_list_filter_customer_id').length > 0) {
                    customer_id = $('#sell_list_filter_customer_id').val();
                }
                if ($('#product_list_filter_tax_id').length > 0) {
                    tax_id = $('#product_list_filter_tax_id').val();
                }
                if ($('#sell_list_filter_location_id').length > 0) {
                    location_id = $('#sell_list_filter_location_id').val();
                }
                if ($('#active_state').length > 0) {
                    active_state = $('#active_state').val();
                }

                getStatistics(start, end, customer_id, active_state,
                    location_id, payment_status, agent_id);
            }
        );

        function getStatistics(start = null, end = null, customer_id = null, active_state = null,
            location_id = null, payment_status = null, agent_id = null
        ) {
            $.ajax({
                url: "{{ route('sell.getStatistics') }}",
                type: 'get',

                dataType: 'json',
                beforeSend: function() {
                    $('#invoice_count').html('');
                    $('#invoice_paid_count').html('');
                    $('#invoice_partial_count').html('');
                    $('#invoice_due_count').html('');
                    $('#invoice_total').html('');
                    $('#invoice_partial_total').html('');
                    $('#invoice_return_total').html('');

                    $('#invoice_count').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_paid_count').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_partial_count').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_due_count').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_total').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_partial_total').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                    $('#invoice_return_total').append(
                        '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                },
                data: {
                    'start': start,
                    'end': end,
                    'customer_id': customer_id,
                    'payment_status': payment_status,
                    'commission_agent': agent_id,
                    'active_state': active_state,
                    'location_id': location_id,
                    // 'has_no_sell_from': has_no_sell_from,
                    // 'region': region,
                },
                success: function(res) {
                    $('#invoice_count').html(res.invoice_count);
                    $('#invoice_paid_count').html(res.invoice_paid_count);
                    $('#invoice_partial_count').html(res.invoice_partial_count);
                    $('#invoice_due_count').html(res.invoice_due_count);
                    $('#invoice_total').html(res.invoice_total);
                    $('#invoice_partial_total').html(res.invoice_partial_total);
                    $('#invoice_return_total').html(res.invoice_return_total);

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
