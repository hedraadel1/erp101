@extends('layouts.app')
@section('title', 'لوحة الاقساط')
@section('css')
    <style>
        .red {
            background: red;
            color: #fff;
        }

        .green {
            background: green;
            color: #fff;
        }
    </style>
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">لوحة الاقساط</h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open([
                        'url' => action('ReportController@getStockReport'),
                        'method' => 'get',
                        'id' => 'sales_representative_filter_form',
                    ]) !!}
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('sr_id', __('report.user') . ':') !!}
                            {!! Form::select('sr_id', $users, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('report.all_users'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('sr_business_id', __('business.business_location') . ':') !!}
                            {!! Form::select('sr_business_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">

                            {!! Form::label('sr_date_filter', __('report.date_range') . ':') !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'sr_date_filter',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('sr_status', __('business.status') . ':') !!}
                            <select name="sr_status" id="" class="select2 form-control">
                                <option value="" selected hidden>{{ __('report.all') }}</option>
                                <option value="1">محصل</option>
                                <option value="no">غير محصل</option>
                            </select>

                        </div>
                    </div>

                    {!! Form::close() !!}
                @endcomponent
            </div>
        </div>

        @if (auth()->user()->can('superadmin'))
            {{-- Abanoub Statics component data --}}
            @component('components.widget', ['class' => 'box-primary', 'title' => 'احصائيات الاقساط'])
                <div class="row row-custom">
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">

                            <div class="info-box-content">
                                <span class="info-box-text">عدد العملاء</span>
                                <span class="info-box-number total_sell" id="total_sell">{{ $totalDistinctContactIds }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">عدد الاقساط المسددة</span>
                                <span class="info-box-number net" id="net">{{ $paidInstallmentsTotalCount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">قيمة الاقساط المسددة</span>
                                <span class="info-box-number invoice_due" id="invoice_due">{{ $totalPaidInstallments }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">عدد الاقساط الغير مسددة</span>
                                <span class="info-box-number total_sell_return"
                                    id="total_sell_return">{{ $unpaidInstallmentsTotalCount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row row-custom">
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">قيمة الاقساط الغير مسددة</span>
                                <span class="info-box-number total_purchase" id="total_purchase">{{ $roundedTotal }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">عدد الاقساط المتاخرة</span>
                                <span class="info-box-number purchase_due"
                                    id="purchase_due">{{ $unpaidDueInstallmentsCount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">قيمة الاقساط المتأخرة </span>
                                <span class="info-box-number total_purchase_return"
                                    id="total_purchase_return">{{ $unpaidDueInstallmentsAmount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <!-- expense -->
                    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                        <div class="Fast_Report_Box info-box-new-style">


                            <div class="info-box-content">
                                <span class="info-box-text">
                                    اجمالى قيمة الاقساط
                                </span>
                                <span class="info-box-number total_expense" id="total_expense">{{ $total }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
                @if (!empty($widgets['after_sale_purchase_totals']))
                    @foreach ($widgets['after_sale_purchase_totals'] as $widget)
                        {!! $widget !!}
                    @endforeach
                @endif
            @endcomponent
            <!-- Summary -->
            <div class="row">
                <div class="col-sm-12">
                    @component('components.widget', ['title' => __('report.summary')])
                        <h5 class="text-muted">
                            {{ __('report.total_sell') }} - {{ __('lang_v1.total_sales_return') }}:
                            <span id="sr_total_sales">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                            </span>
                            -
                            <span id="sr_total_sales_return">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                            </span>
                            =
                            <span id="sr_total_sales_final">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                            </span>
                        </h5>


                        <h5 class="text-muted">
                            {{ __('report.total_expense') }}:
                            <span id="sr_total_expenses">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                            </span>
                        </h5>
                    @endcomponent
                </div>
            </div>
        @endif





        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#sr_clients_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cog"
                                    aria-hidden="true"></i>لوحة العملاء</a>
                        </li>
                        <li>
                            <a href="#sr_installments_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cog"
                                    aria-hidden="true"></i> لوحة الاقساط</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="sr_clients_tab">
                            @include('installmentdetails.partials.AllClientsReport')
                        </div>

                        <div class="tab-pane" id="sr_installments_tab">
                            {{-- @include('installmentdetails.partials.AllInstallments') --}}
                            @include('installmentdetails.partials.AllInstallmentReport')
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
    <div class="modal fade view_register" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade pay_contact_due_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>

    <script>
        $('#Modal_').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var date = button.data('date')
            var modal = $(this)
            modal.find('.modal-body #id').empty();
            modal.find('.modal-title').empty();
            modal.find('.modal-body #date').empty();
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-title').append(name);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-footer #update_istallment').on('click', function() {
                $.ajax({
                    url: "{{ url('/installment/update-date') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        'id': id,
                        'date': modal.find('.modal-body #date').val(),
                        'notes': modal.find('.modal-body #notes').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        sr_instllment_report.ajax.url('/installment/data').load();
                        modal.modal('hide');
                    }
                });
            });
        });



        function updateStatus(el) {
            $.ajax({
                url: "{{ url('/installment/update-status') }}",
                type: "post",
                dataType: "json",
                data: {
                    'id': $(el).data('id'),
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    sr_instllment_report.ajax.url('/installment/data').load();
                },
            });
        }
    </script>
@endsection
