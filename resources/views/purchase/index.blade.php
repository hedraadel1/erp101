@extends('layouts.app')
@section('title', __('purchase.purchases'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('purchase.purchases')
            </h3>

    </section>

    <!-- Main content -->
    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_location_id', __('purchase.business_location') . ':') !!}
                    {!! Form::select('purchase_list_filter_location_id', $business_locations, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_supplier_id', __('purchase.supplier') . ':') !!}
                    {!! Form::select('purchase_list_filter_supplier_id', $suppliers, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_status', __('purchase.purchase_status') . ':') !!}
                    {!! Form::select('purchase_list_filter_status', $orderStatuses, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_payment_status', __('purchase.payment_status') . ':') !!}
                    {!! Form::select(
                        'purchase_list_filter_payment_status',
                        [
                            'paid' => __('lang_v1.paid'),
                            'due' => __('lang_v1.due'),
                            'partial' => __('lang_v1.partial'),
                            'overdue' => __('lang_v1.overdue'),
                        ],
                        null,
                        ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')],
                    ) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('purchase_list_filter_date_range', null, [
                        'placeholder' => __('lang_v1.select_a_date_range'),
                        'class' => 'form-control',
                        'readonly',
                    ]) !!}
                </div>
            </div>
        @endcomponent
        @if (is_product_enabled('274'))
            @component('components.widget', ['title' => 'أحصائيات مختصره'])
                <div class="ag-format-container" style="width: 100%">
                    {{-- @if ($type == 'customer') --}}
                    <div class="ag-courses_box ">
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link" style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title">
                                    عدد الفواتير
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_count">
                                    {{-- {{ $customer_count }} --}}
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg bg-green"></div>
                                <div class="ag-courses-item_title">
                                    عدد المدفوعة
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_paid_count">
                                    {{-- {{ $total_debit }} --}}
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title">
                                    عدد الجزئية
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_partial_count">
                                    {{-- {{ $total_sell_return }} --}}
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title">
                                    عدد المستحقة
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_due_count">
                                    {{-- {{ $total_sell_return }} --}}
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title">
                                    اجمالى قيمة المبيعات
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_total">
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title">
                                    اجمالى قيمة المستحقات
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_partial_total">
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="ag-courses_item">
                            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                                <div class="ag-courses-item_bg bg-danger"></div>
                                <div class="ag-courses-item_title">
                                    اجمالى المرتجعات
                                </div>
                                <div class="ag-courses-item_date-box" id="invoice_return_total">
                                    <span class="ag-courses-item_date">
                                    </span>
                                </div>
                            </a>
                        </div>



                    </div>
                    {{-- @endif --}}
                </div>
            @endcomponent
        @endif

        @component('components.widget', ['class' => 'box-primary', 'title' => __('purchase.all_purchases')])
            @can('purchase.create')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <a class="btn btn-block button-add" href="{{ action('PurchaseController@create') }}">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @include('purchase.partials.purchase_table')
        @endcomponent

        <div class="modal fade product_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

        @include('purchase.partials.update_purchase_status_modal')

    </section>

    <section id="receipt_section" class="print_section"></section>
    @include('purchase.partials.screen_setting_modal')

    <!-- /.content -->
@stop
@section('javascript')
    <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        //Date range as a button
        // $('#purchase_list_filter_date_range').daterangepicker(
        //     dateRangeSettings,
        //     function(start, end) {
        //         $('#purchase_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
        //             moment_date_format));
        //         purchase_table.ajax.reload();
        //     }
        // );
        // $('#purchase_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        //     $('#purchase_list_filter_date_range').val('');
        //     purchase_table.ajax.reload();
        // });

        $(document).on('click', '.update_status', function(e) {
            e.preventDefault();
            $('#update_purchase_status_form').find('#status').val($(this).data('status'));
            $('#update_purchase_status_form').find('#purchase_id').val($(this).data('purchase_id'));
            $('#update_purchase_status_modal').modal('show');
        });

        $(document).on('submit', '#update_purchase_status_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    if (result.success == true) {
                        $('#update_purchase_status_modal').modal('hide');
                        toastr.success(result.msg);
                        purchase_table.ajax.reload();
                        $('#update_purchase_status_form')
                            .find('button[type="submit"]')
                            .attr('disabled', false);
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });

        // $('#btn_update_status').on('click', function() {
        //     var status = $(this).data('status');
        //     var purchase_id = $(this).data('purchase_id');
        //     $.ajax({
        //         url: '/purchases/update-status',
        //         type: 'POST',
        //         dataType: 'json',
        //         data: {
        //             'status': status,
        //             'purchase_id': purchase_id
        //         },
        //         success: function(data) {
        //             purchase_table.ajax.reload();
        //         }
        //     });
        // });
    </script>

    <script>
        $(document).on('click', '.setting_screen_table', function(e) {
            e.preventDefault();
            // if (selected_rows.length > 0) {
            $('#screen_setting_modal').modal('show');

        });
        $(document).ready(function() {
            $(window).on('load', function() {
                $.ajax({
                    url: "{{ route('getscreen_setting', 'purchase_order') }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        var cols = res.setting;
                        if (cols != null) {
                            $('.buttons-colvis').click();
                            $('.dt-button-collection').css('display', 'none');
                            $('.dt-button-collection  li').each(function(index, element) {
                                console.log(cols);
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


        /**
         * return short statictics
         */
        $(document).ready(function() {
            getStatistics();
        });
        $('#purchase_list_filter_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#purchase_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                    moment_date_format));
                sell_table.ajax.reload();
            }
        );
        $('#purchase_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#purchase_list_filter_date_range').val('');
            sell_table.ajax.reload();
        });
        $(document).on('change',
            '#purchase_list_filter_date_range, #purchase_list_filter_supplier_id, #purchase_list_filter_payment_status, #purchase_list_filter_location_id,#purchase_list_filter_status',
            function() {
                var start = null;
                var end = null;
                var supplier_id = null;
                var payment_status = null;
                var location_id = null;
                var status = null;
                if ($('#purchase_list_filter_date_range').val()) {
                    start = $('#purchase_list_filter_date_range').data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('#purchase_list_filter_date_range').data('daterangepicker').endDate
                        .format('YYYY-MM-DD');
                    // d.start_date = start;
                    // d.end_date = end;
                }
                if ($('#purchase_list_filter_payment_status').length > 0) {
                    payment_status = $('#purchase_list_filter_payment_status').val();
                }

                if ($('#purchase_list_filter_supplier_id').length > 0) {
                    supplier_id = $('#purchase_list_filter_supplier_id').val();
                }

                if ($('#purchase_list_filter_location_id').length > 0) {
                    location_id = $('#purchase_list_filter_location_id').val();
                }
                if ($('#purchase_list_filter_status').length > 0) {
                    status = $('#purchase_list_filter_status').val();
                }

                getStatistics(start, end, supplier_id, status,
                    location_id, payment_status);
            }
        );

        function getStatistics(start = null, end = null, supplier_id = null, status = null,
            location_id = null, payment_status = null
        ) {
            $.ajax({
                url: "{{ route('purchases.getStatistics') }}",
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
                    'supplier_id': supplier_id,
                    'payment_status': payment_status,
                    'status': status,
                    'location_id': location_id,

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
