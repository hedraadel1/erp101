@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    <style>
        /* .button_top {
                                                    opacity: 0;
                                                }

                                                table:hover .button_top {
                                                    opacity: 1;
                                                } */
    </style>
@endsection

@section('content')
    @php
        $dashboard_settings = !empty(session('business.dashboard_settings')) ? json_decode(session('business.dashboard_settings'), true) : [];
    @endphp
    <!-- Content Header (Page header) -->
    <section style="margin-top: 130px">
        {{--  <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
    </h1> --}}
    </section>
    <!-- Main content -->
    <section class="content content-custom no-print row row-custom">
        <br>
        @if (auth()->user()->can('dashboard.data'))
            @if ($is_admin)

                <div style="height: 53px;margin-top: 10px;" class=" button-header-40">
                    <div class="col-md-4 col-xs-12">
                        @if (count($all_locations) > 1)
                            {!! Form::select('dashboard_location', $all_locations, null, [
                                'class' => 'form-control select2',
                                'placeholder' => __('lang_v1.select_location'),
                                'id' => 'dashboard_location',
                            ]) !!}
                        @endif
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="form-group pull-right">
                            <div class="input-group">
                                <button type="button" class="btn btn-primary" id="dashboard_date_filter">
                                    <span>
                                        <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                                    </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @component('components.widget', [
                    'class' => 'box-primary',
                    'display' => 'contents',
                    'title' => __('lang_v1.Fast_Report'),
                ])
                    <div class="row row-custom">
                        <!-- /.col -->
                        {{-- <div class="ag-format-container">
                            <div class="ag-courses_box ">
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('home.total_sell') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number total_sell"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('lang_v1.net') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number net"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('home.invoice_due') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number invoice_due"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('lang_v1.total_sell_return') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number total_sell_return"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('home.total_purchase') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number total_purchase"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('home.purchase_due') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number purchase_due"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class="">{{ __('lang_v1.total_purchase_return') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number total_purchase_return"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ag-courses_item" style=" flex-basis: calc(25% - 30px);">
                                    <a href="#" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title">
                                            <span class=""> {{ __('lang_v1.expense') }}</span>
                                        </div>
                                        <div class="ag-courses-item_date-box" id="">
                                            <span class="info-box-number total_expense"><i
                                                    class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('home.total_sell') }}</span>
                                    <span class="info-box-number total_sell"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-green">
                                    <i class="ion ion-ios-paper-outline"></i>

                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('lang_v1.net') }}
                                        @show_tooltip(__('lang_v1.net_home_tooltip'))</span>
                                    <span class="info-box-number net"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-yellow">
                                    <i class="ion ion-ios-paper-outline"></i>
                                    <i class="fa fa-exclamation"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('home.invoice_due') }}</span>
                                    <span class="info-box-number invoice_due"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-red text-white">
                                    <i class="fas fa-exchange-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('lang_v1.total_sell_return') }}</span>
                                    <span class="info-box-number total_sell_return"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
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
                                <span class="info-box-icon bg-aqua"><i class="ion ion-cash"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('home.total_purchase') }}</span>
                                    <span class="info-box-number total_purchase"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-yellow">
                                    <i class="fa fa-dollar"></i>
                                    <i class="fa fa-exclamation"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('home.purchase_due') }}</span>
                                    <span class="info-box-number purchase_due"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-red text-white">
                                    <i class="fas fa-undo-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('lang_v1.total_purchase_return') }}</span>
                                    <span class="info-box-number total_purchase_return"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <!-- expense -->
                        <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                <span class="info-box-icon bg-red">
                                    <i class="fas fa-minus-circle"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        {{ __('lang_v1.expense') }}
                                    </span>
                                    <span class="info-box-number total_expense"><i
                                            class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
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


                {{-- 
                @component('components.widget', [
    'class' => 'box-primary',
    'display' => 'contents',
    'title' => __('lang_v1.Fast_Report'),
])
                    <div class="row row-custom">
                        <!-- /.col -->
                        <div class="col-md-4` col-sm-6 col-xs-12 col-custom">

                            <br>
                            <div id="lastupdatediv" class="Fast_Report_Box info-box-new-style">
                                <div id="lastupdateclick">
                                    <div>
                                        @lang('lang_v1.lastupdate')
                                    </div>
                                    <div>
                                        @lang('lang_v1.lastupdate_Clickhere')
                                    </div>
                                </div>
                                <div style="display: none" id="lastupdatedetails">

                                    @include('home.lastupdate')
                                </div>

                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4` col-sm-6 col-xs-12 col-custom">
                            <div class="Fast_Report_Box info-box-new-style">
                                الشروحات
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                @endcomponent --}}
            @endif
            {{-- 
            @component('components.widget', ['class' => 'box-primary', 'title' => 'الاقساط'])
            <div class="row row-custom">
                @include('home.homeinstallment')
            </div>
        @endcomponent --}}







            <!-- end is_admin check -->
            @if (auth()->user()->can('sell.view') ||
                    auth()->user()->can('direct_sell.view'))



                @if (!empty($all_locations))
                    <!-- sales chart start -->

                    <div class="col-sm-6">

                        @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')])
                            {!! $sells_chart_1->container() !!}
                        @endcomponent
                    </div>

                @endif
                @if (!empty($widgets['after_sales_last_30_days']))
                    @foreach ($widgets['after_sales_last_30_days'] as $widget)
                        {!! $widget !!}
                    @endforeach
                @endif
                @if (!empty($all_locations))

                    <div class="col-sm-6">
                        @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_current_fy')])
                            {!! $sells_chart_2->container() !!}
                        @endcomponent
                    </div>

                @endif
            @endif
            <!-- sales chart end -->
            @if (!empty($widgets['after_sales_current_fy']))
                @foreach ($widgets['after_sales_current_fy'] as $widget)
                    {!! $widget !!}
                @endforeach
            @endif
            <!-- products less than alert quntity -->

            @if (auth()->user()->can('sell.view') ||
                    auth()->user()->can('direct_sell.view'))
                <div class="col-sm-6">
                    @component('components.widget', ['class' => 'box-warning'])
                        {{--     @slot('icon')
                                <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                            @endslot --}}
                        @slot('title')
                            {{ __('lang_v1.sales_payment_dues') }} @show_tooltip(__('lang_v1.tooltip_sales_payment_dues'))
                        @endslot
                        <div class="row">
                            @if (count($all_locations) > 1)
                                <div class="">
                                    {!! Form::select('sales_payment_dues_location', $all_locations, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang_v1.select_location'),
                                        'id' => 'sales_payment_dues_location',
                                    ]) !!}
                                </div>
                            @endif
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="sales_payment_dues_table"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>@lang('contact.customer')</th>
                                            <th>@lang('sale.invoice_no')</th>
                                            <th>@lang('home.due_amount')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    @endcomponent
                </div>
            @endif
            @can('purchase.view')
                <div class="col-sm-6">
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('title')
                            {{ __('lang_v1.purchase_payment_dues') }} @show_tooltip(__('tooltip.payment_dues'))
                        @endslot
                        <div class="row">
                            @if (count($all_locations) > 1)
                                <div class="">
                                    {!! Form::select('purchase_payment_dues_location', $all_locations, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang_v1.select_location'),
                                        'id' => 'purchase_payment_dues_location',
                                    ]) !!}
                                </div>
                            @endif
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="purchase_payment_dues_table"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>@lang('purchase.supplier')</th>
                                            <th>@lang('purchase.ref_no')</th>
                                            <th>@lang('home.due_amount')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    @endcomponent
                </div>
            @endcan

            {{-- sells --}}
            @if (!empty($dashboard_settings['enable_sell_table']))
                <div class="col-sm-12">
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('title')
                            <b class="text-white">{{ __('lang_v1.all_sales') }} </b>
                        @endslot

                        @include('home.selles_datatable')
                    @endcomponent
                </div>
            @endif

            {{-- expesess --}}
            @if (!empty($dashboard_settings['enable_expense_table']))
                <div class="col-md-12">
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('title')
                            <b class="text-white">{{ __('expense.all_expenses') }} </b>
                        @endslot

                        @include('home.expense_datatable')
                    @endcomponent
                </div>
            @endif
            {{-- purchase table --}}
            @if (
                !empty($dashboard_settings['enable_purchase_table']) &&
                    (auth()->user()->can('purchase_order.view_all') ||
                        auth()->user()->can('purchase_order.view_own')))
                <div class="col-md-12">
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('title')
                            <b class="text-white">{{ __('purchase.all_purchases') }} </b>
                        @endslot

                        @include('home.purchase_datatable')
                    @endcomponent
                </div>
            @endif

            @can('stock_report.view')
                <div class="row">
                    <div class="@if (session('business.enable_product_expiry') != 1 &&
                            auth()->user()->can('stock_report.view')) col-sm-12 @else col-sm-6 @endif">
                        @component('components.widget', ['class' => 'box-warning'])
                            @slot('title')
                                <b class="text-white">اخر الحجوزات</b>
                            @endslot

                            <div class="row">
                                @if (count($all_locations) > 1)
                                    <div class="col-md-12 col-sm-12 ">
                                        {!! Form::select('invoice_alert_location', $all_locations, null, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang_v1.select_location'),
                                            'id' => 'invoice_alert_location',
                                        ]) !!}
                                    </div>
                                @endif
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped" id="invoice_booking" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>@lang('messages.date')</th>
                                                <th>@lang('restaurant.order_no')</th>
                                                <th>@lang('business.location')</th>
                                                <th>@lang('messages.action')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endcomponent
                    </div>
                    <div class="col-sm-12">
                        @component('components.widget', ['class' => 'box-warning'])
                            @slot('title')
                                المنتجات الاكثر مبيعا
                            @endslot
                            @if (count($all_locations) > 1)
                                <div class="col-md-12 col-sm-12">
                                    {!! Form::select('most_product_location', $all_locations, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang_v1.select_location'),
                                        'id' => 'most_product_location',
                                    ]) !!}
                                </div>
                            @endif
                            {{-- <button class="button_top" onclick="scrollToTop('most_product_sell_table')">Scroll to
                                top</button> --}}

                            <table class="table table-bordered table-striped" id="most_product_sell_table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>@lang('business.product')</th>
                                        <th>@lang('business.location')</th>
                                        {{-- <th>@lang('report.stock_left')</th> --}}
                                        <th>الكمية المباعة</th>
                                    </tr>
                                </thead>

                            </table>
                        @endcomponent
                    </div>
                    <div class="@if (session('business.enable_product_expiry') != 1 &&
                            auth()->user()->can('stock_report.view')) col-sm-12 @else col-sm-6 @endif">
                        @component('components.widget', ['class' => 'box-warning'])
                            @slot('icon')
                                <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                            @endslot
                            @slot('title')
                                {{ __('home.product_stock_alert') }} @show_tooltip(__('tooltip.product_stock_alert'))
                            @endslot
                            <div class="row">
                                @if (count($all_locations) > 1)
                                    <div class="col-md-12 col-sm-12">
                                        {!! Form::select('stock_alert_location', $all_locations, null, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang_v1.select_location'),
                                            'id' => 'stock_alert_location',
                                        ]) !!}
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped" id="stock_alert_table"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>@lang('sale.product')</th>
                                                <th>@lang('business.location')</th>
                                                <th>@lang('report.current_stock')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endcomponent
                    </div>
                    @if (session('business.enable_product_expiry') == 1)
                        <div class="col-sm-6">
                            @component('components.widget', ['class' => 'box-warning'])
                                @slot('icon')
                                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                                @endslot
                                @slot('title')
                                    {{ __('home.stock_expiry_alert') }} @show_tooltip( __('tooltip.stock_expiry_alert', [ 'days'
                                    =>session('business.stock_expiry_alert_days', 30) ]) )
                                @endslot
                                <input type="hidden" id="stock_expiry_alert_days"
                                    value="{{ \Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d') }}">
                                <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                                    <thead>
                                        <tr>
                                            <th>@lang('business.product')</th>
                                            <th>@lang('business.location')</th>
                                            <th>@lang('report.stock_left')</th>
                                            <th>@lang('product.expires_in')</th>
                                        </tr>
                                    </thead>
                                </table>
                            @endcomponent
                        </div>
                    @endif
                </div>
            @endcan
            @if (auth()->user()->can('so.view_all') ||
                    auth()->user()->can('so.view_own'))
                <div class="col-md-12 p-0"
                    style="padding:0px; @if (!auth()->user()->can('dashboard.data')) margin-top: 190px !important; @endif ">
                    {{-- sales order --}}
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('icon')
                            <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                        @endslot
                        {{-- طلب المبيعات --}}
                        @slot('title')
                            {{ __('lang_v1.sales_order') }}
                        @endslot
                        <div class="row">
                            @if (count($all_locations) > 1)
                                <div class="col-md-12">
                                    {!! Form::select('so_location', $all_locations, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang_v1.select_location'),
                                        'id' => 'so_location',
                                    ]) !!}
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped ajax_view" id="sales_order_table">
                                        <thead>
                                            <tr>
                                                <th>@lang('messages.action')</th>
                                                <th>@lang('messages.date')</th>
                                                <th>@lang('restaurant.order_no')</th>
                                                <th>@lang('sale.customer_name')</th>
                                                <th>@lang('lang_v1.contact_no')</th>
                                                <th>@lang('sale.location')</th>
                                                <th>@lang('sale.status')</th>
                                                <th>@lang('lang_v1.shipping_status')</th>
                                                <th>@lang('lang_v1.quantity_remaining')</th>
                                                <th>@lang('lang_v1.added_by')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endcomponent

                </div>
            @endif


            @if (
                !empty($common_settings['enable_purchase_order']) &&
                    (auth()->user()->can('purchase_order.view_all') ||
                        auth()->user()->can('purchase_order.view_own')))
                <div class="row" @if (!auth()->user()->can('dashboard.data')) style="margin-top: 190px !important;" @endif>
                    <div class="col-sm-12">
                        @component('components.widget', ['class' => 'box-warning'])
                            @slot('icon')
                                <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                            @endslot
                            @slot('title')
                                @lang('lang_v1.purchase_order')
                            @endslot
                            <div class="row">
                                @if (count($all_locations) > 1)
                                    <div class="col-md-12">
                                        {!! Form::select('po_location', $all_locations, null, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang_v1.select_location'),
                                            'id' => 'po_location',
                                        ]) !!}
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped ajax_view" id="purchase_order_table"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('messages.action')</th>
                                                    <th>@lang('messages.date')</th>
                                                    <th>@lang('purchase.ref_no')</th>
                                                    <th>@lang('purchase.location')</th>
                                                    <th>@lang('purchase.supplier')</th>
                                                    <th>@lang('sale.status')</th>
                                                    <th>@lang('lang_v1.quantity_remaining')</th>
                                                    <th>@lang('lang_v1.added_by')</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endcomponent
                    </div>
                </div>
            @endif

            @if (auth()->user()->can('access_pending_shipments_only') ||
                    auth()->user()->can('access_shipping') ||
                    auth()->user()->can('access_own_shipping'))
                @component('components.widget', ['class' => 'box-warning'])
                    @slot('icon')
                        <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                    @endslot
                    @slot('title')
                        @lang('lang_v1.pending_shipments')
                    @endslot
                    <div class="row">
                        @if (count($all_locations) > 1)
                            <div class="col-md-12 ">
                                {!! Form::select('pending_shipments_location', $all_locations, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang_v1.select_location'),
                                    'id' => 'pending_shipments_location',
                                ]) !!}
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped ajax_view" id="shipments_table"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('messages.action')</th>
                                            <th>@lang('messages.date')</th>
                                            <th>@lang('sale.invoice_no')</th>
                                            <th>@lang('sale.customer_name')</th>
                                            <th>@lang('lang_v1.contact_no')</th>
                                            <th>@lang('sale.location')</th>
                                            <th>@lang('lang_v1.shipping_status')</th>
                                            @if (!empty($custom_labels['shipping']['custom_field_1']))
                                                <th>
                                                    {{ $custom_labels['shipping']['custom_field_1'] }}
                                                </th>
                                            @endif
                                            @if (!empty($custom_labels['shipping']['custom_field_2']))
                                                <th>
                                                    {{ $custom_labels['shipping']['custom_field_2'] }}
                                                </th>
                                            @endif
                                            @if (!empty($custom_labels['shipping']['custom_field_3']))
                                                <th>
                                                    {{ $custom_labels['shipping']['custom_field_3'] }}
                                                </th>
                                            @endif
                                            @if (!empty($custom_labels['shipping']['custom_field_4']))
                                                <th>
                                                    {{ $custom_labels['shipping']['custom_field_4'] }}
                                                </th>
                                            @endif
                                            @if (!empty($custom_labels['shipping']['custom_field_5']))
                                                <th>
                                                    {{ $custom_labels['shipping']['custom_field_5'] }}
                                                </th>
                                            @endif
                                            <th>@lang('sale.payment_status')</th>
                                            <th>@lang('restaurant.service_staff')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcomponent
            @endif

            @if (auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true)
                @component('components.widget', ['class' => 'box-warning'])
                    @slot('icon')
                        <i class="fas fa-money-bill-alt text-yellow fa-lg" aria-hidden="true"></i>
                    @endslot
                    @slot('title')
                        @lang('lang_v1.payment_recovered_today')
                    @endslot
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped ajax_view" id="cash_flow_table"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('messages.date')</th>
                                            <th>@lang('account.account')</th>
                                            <th>@lang('lang_v1.description')</th>
                                            <th>@lang('lang_v1.payment_method')</th>
                                            <th>@lang('lang_v1.payment_details')</th>
                                            <th>@lang('account.credit')</th>
                                            <th>@lang('lang_v1.account_balance') @show_tooltip(__('lang_v1.account_balance_tooltip'))</th>
                                            <th>@lang('lang_v1.total_balance') @show_tooltip(__('lang_v1.total_balance_tooltip'))</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-gray font-17 footer-total text-center">
                                            <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                                            <td class="footer_total_credit"></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcomponent
            @endif

            @if (!empty($widgets['after_dashboard_reports']))
                @foreach ($widgets['after_dashboard_reports'] as $widget)
                    {!! $widget !!}
                @endforeach
            @endif

        @endif
        <!-- can('dashboard.data') end -->
        @include('home.brand_store_products')
    </section>
    <!-- /.content -->
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    @include('home.todays_profit_modal')
@stop
@section('javascript')

    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>

    @includeIf('sales_order.common_js')
    @includeIf('purchase_order.common_js')
    @if (!empty($all_locations))
        {!! $sells_chart_1->script() !!}
        {!! $sells_chart_2->script() !!}
    @endif
    <script type="text/javascript">
        /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    task-4
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    submit update of installment Date
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    */
        $('#installment_pay').on('submit', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
            $.ajax({
                method: 'POST',
                url: "{{ action('HomeController@update_installment') }}",
                data: {},
                cache: false,
                success: function() {
                    aler('success')
                },
                error: function() {
                    alert('errore')
                }
            }); // end ajax()
        });
        // }


        // =================
        var d = document.getElementById("lastupdatediv");
        var b = document.getElementById("lastupdatedetails");
        var c = document.getElementById("lastupdateclick");

        // d.onclick = function() {
        //     b.style.display = "unset";
        //     c.style.display = "none";

        // };
        $(document).ready(function() {
            sales_order_table = $('#sales_order_table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: false,
                dom: 'Btirp',
                buttons: [],

                aaSorting: [
                    [1, 'desc']
                ],
                "ajax": {
                    "url": '{{ action('SellController@index') }}?sale_type=sales_order',
                    "data": function(d) {
                        d.for_dashboard_sales_order = true;

                        if ($('#so_location').length > 0) {
                            d.location_id = $('#so_location').val();
                        }
                    }
                },
                columnDefs: [{
                    "targets": 7,
                    "orderable": false,
                    "searchable": false
                }],
                columns: [{
                        data: 'action',
                        name: 'action'
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status'
                    },
                    {
                        data: 'so_qty_remaining',
                        name: 'so_qty_remaining',
                        "searchable": false
                    },
                    {
                        data: 'added_by',
                        name: 'u.first_name'
                    },
                ]
            });

            @if (auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true)

                // Cash Flow Table
                cash_flow_table = $('#cash_flow_table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    scrollY: "75vh",
                    scrollX: true,
                    scrollCollapse: true,
                    fixedHeader: false,
                    dom: 'Btirp',
                    buttons: [],
                    "ajax": {
                        "url": "{{ action('AccountController@cashFlow') }}",
                        "data": function(d) {
                            d.type = 'credit';
                            d.only_payment_recovered = true;
                        }
                    },
                    "ordering": false,
                    "searching": false,
                    columns: [{
                            data: 'operation_date',
                            name: 'operation_date'
                        },
                        {
                            data: 'account_name',
                            name: 'account_name'
                        },
                        {
                            data: 'sub_type',
                            name: 'sub_type'
                        },
                        {
                            data: 'method',
                            name: 'TP.method'
                        },
                        {
                            data: 'payment_details',
                            name: 'payment_details',
                            searchable: false
                        },
                        {
                            data: 'credit',
                            name: 'amount'
                        },
                        {
                            data: 'balance',
                            name: 'balance'
                        },
                        {
                            data: 'total_balance',
                            name: 'total_balance'
                        },
                    ],
                    "fnDrawCallback": function(oSettings) {
                        __currency_convert_recursively($('#cash_flow_table'));
                    },
                    "footerCallback": function(row, data, start, end, display) {
                        var footer_total_credit = 0;

                        for (var r in data) {
                            footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(
                                data[r].credit).data('orig-value')) : 0;
                        }
                        $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
                    }
                });
            @endif

            $('#so_location').change(function() {
                sales_order_table.ajax.reload();
            });
            @if (!empty($common_settings['enable_purchase_order']))
                //Purchase table
                purchase_order_table = $('#purchase_order_table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    scrollY: "75vh",
                    scrollX: true,
                    scrollCollapse: true,
                    fixedHeader: false,
                    dom: 'Btirp',
                    buttons: [],
                    aaSorting: [
                        [1, 'desc']
                    ],
                    scrollY: "75vh",
                    scrollX: true,
                    scrollCollapse: true,
                    ajax: {
                        url: '{{ action('PurchaseOrderController@index') }}',
                        data: function(d) {
                            d.from_dashboard = true;

                            if ($('#po_location').length > 0) {
                                d.location_id = $('#po_location').val();
                            }
                        },
                    },
                    columns: [{
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'transaction_date',
                            name: 'transaction_date'
                        },
                        {
                            data: 'ref_no',
                            name: 'ref_no'
                        },
                        {
                            data: 'location_name',
                            name: 'BS.name'
                        },
                        {
                            data: 'name',
                            name: 'contacts.name'
                        },
                        {
                            data: 'status',
                            name: 'transactions.status'
                        },
                        {
                            data: 'po_qty_remaining',
                            name: 'po_qty_remaining',
                            "searchable": false
                        },
                        {
                            data: 'added_by',
                            name: 'u.first_name'
                        }
                    ]
                })

                $('#po_location').change(function() {
                    purchase_order_table.ajax.reload();
                });
            @endif

            sell_table = $('#shipments_table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: false,
                dom: 'Btirp',
                buttons: [],
                aaSorting: [
                    [1, 'desc']
                ],
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                "ajax": {
                    "url": '{{ action('SellController@index') }}',
                    "data": function(d) {
                        d.only_pending_shipments = true;
                        if ($('#pending_shipments_location').length > 0) {
                            d.location_id = $('#pending_shipments_location').val();
                        }
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
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
                        data: 'shipping_status',
                        name: 'shipping_status'
                    },
                    @if (!empty($custom_labels['shipping']['custom_field_1']))
                        {
                            data: 'shipping_custom_field_1',
                            name: 'shipping_custom_field_1'
                        },
                    @endif
                    @if (!empty($custom_labels['shipping']['custom_field_2']))
                        {
                            data: 'shipping_custom_field_2',
                            name: 'shipping_custom_field_2'
                        },
                    @endif
                    @if (!empty($custom_labels['shipping']['custom_field_3']))
                        {
                            data: 'shipping_custom_field_3',
                            name: 'shipping_custom_field_3'
                        },
                    @endif
                    @if (!empty($custom_labels['shipping']['custom_field_4']))
                        {
                            data: 'shipping_custom_field_4',
                            name: 'shipping_custom_field_4'
                        },
                    @endif
                    @if (!empty($custom_labels['shipping']['custom_field_5']))
                        {
                            data: 'shipping_custom_field_5',
                            name: 'shipping_custom_field_5'
                        },
                    @endif {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'waiter',
                        name: 'ss.first_name',
                        @if (empty($is_service_staff_enabled))
                            visible: false
                        @endif
                    }
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#sell_table'));
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(4)').attr('class', 'clickable_td');
                }
            });

            $('#pending_shipments_location').change(function() {
                sell_table.ajax.reload();
            });
        });

        $('.installment_option').on('click', function(event) {

            var tr = $(this).parents('tr');
            var row_count = tr.find('#row_count').val();

            if ($(this).hasClass('installment_paid')) {
                // toggle tr background and status value
                if (tr.hasClass('green')) {
                    tr.css('background-color', "yellow")
                    tr.removeClass('green')
                    tr.find('#paid').val(0);
                } else {
                    tr.find('#paid').val(1);
                    tr.css('background-color', "green")
                    tr.addClass('green')
                }

                // update installment pay date 
            } else if ($(this).hasClass('installment_edite')) {
                $(document).on('change', '.contact_modal_istallment_date', function() {
                    tr.find('span.installment_date').text($(this).val())
                    tr.find('input.installment_date').val($(this).val())
                })
            }

        });
        $('#ledger_location').change(function() {
            get_ins();
        });


        function get_ins() {

            var location_id = $('#ledger_location').val();

            var data = {
                location_id: location_id
            }
            $.ajax({
                url: '/home/getinstallment',
                data: data,
                dataType: 'html',
                success: function(result) {
                    $('#insta_table')
                        .html(result);
                    __currency_convert_recursively($('#insta_table'));

                    $('#insta_table').DataTable({
                        searching: false,
                        ordering: false,
                        paging: false,
                        dom: 't'
                    });
                },
            });
        }

        var invoice_booking = $('#invoice_booking').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollY: "75vh",
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: false,
            dom: 'Btirp',
            buttons: [],
            ajax: {
                "url": "{{ route('get.invoice.booking') }}",
                "data": function(d) {
                    if ($('#invoice_alert_location').length > 0) {
                        d.location_id = $('#invoice_alert_location').val();
                    }
                }
            },

            columns: [{
                    data: 'transaction_date',
                    name: 'transaction_date'
                },
                {
                    data: 'contact_id',
                    name: 'contact_id'
                },
                {
                    data: 'location_id',
                    name: 'location_id'
                },

                {
                    data: 'action',
                    name: 'action'
                }
            ],
            fnDrawCallback: function(oSettings) {
                __currency_convert_recursively($('#invoice_booking'));
            },
        });

        $('#invoice_alert_location').change(function() {
            invoice_booking.ajax.reload();
        });




        @php
            $start_date = \Carbon\Carbon::now();
        @endphp
        //date filter for expense table
        dateRangeSettings.startDate = moment('{{ $start_date }}', 'YYYY-MM-DD');
        dateRangeSettings.endDate = moment('{{ $start_date }}', 'YYYY-MM-DD');
        if ($('#expense_date_range').length == 1) {
            $('#expense_date_range').daterangepicker(dateRangeSettings,
                function(start, end) {
                    $('#expense_date_range').val(
                        start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                    );
                    expense_table_home.ajax.reload();
                }
            );
            $('#expense_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#product_sr_date_filter').val('');
                expense_table_home.ajax.reload();
            });
        }

        //Expense table
        expense_table_home = $('#expense_home').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollY: "75vh",
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: false,
            dom: 'Btirp',
            buttons: [],

            aaSorting: [
                [1, 'desc']
            ],
            ajax: {
                url: '{{ action('ExpenseController@index') }}',
                data: function(d) {
                    d.location_id = $('select#location_id').val();
                    d.start_date = $('input#expense_date_range').data('daterangepicker').startDate.format(
                        'YYYY-MM-DD');
                    d.end_date = $('input#expense_date_range').data('daterangepicker').endDate.format(
                        'YYYY-MM-DD');
                },
            },
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'transaction_date',
                    name: 'transaction_date'
                },
                {
                    data: 'ref_no',
                    name: 'ref_no'
                },
                {
                    data: 'recur_details',
                    name: 'recur_details',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'category',
                    name: 'ec.name'
                },
                {
                    data: 'sub_category',
                    name: 'esc.name'
                },
                {
                    data: 'location_name',
                    name: 'bl.name'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
                    orderable: false
                },
                {
                    data: 'tax',
                    name: 'tr.name'
                },
                {
                    data: 'final_total',
                    name: 'final_total'
                },
                {
                    data: 'payment_due',
                    name: 'payment_due'
                },
                {
                    data: 'expense_for',
                    name: 'expense_for'
                },
                {
                    data: 'contact_name',
                    name: 'c.name'
                },
                {
                    data: 'additional_notes',
                    name: 'additional_notes'
                },
                {
                    data: 'added_by',
                    name: 'usr.first_name'
                }
            ],
            fnDrawCallback: function(row, data, start, end, display) {
                var expense_total = sum_table_col($('#expense_home'), 'final-total');
                var total_due = sum_table_col($('#expense_home'), 'payment_due');

                $('.footer_expense_total').html(__currency_trans_from_en(expense_total));
                $('.footer_total_due').html(__currency_trans_from_en(total_due));

                $('.footer_payment_status_count').html(
                    __sum_status_html($('#expense_home'), 'payment-status')
                );
            },
            createdRow: function(row, data, dataIndex) {
                $(row)
                    .find('td:eq(4)')
                    .attr('class', 'clickable_td');
            },
        });

        $('select#location_id,#expense_date_range').on(
            'change',
            function() {
                expense_table_home.ajax.reload();
            }
        );


        @php
            $start_date = \Carbon\Carbon::now();
        @endphp
        //date filter for expense table
        @if (
            !empty($dashboard_settings['enable_purchase_table']) &&
                (auth()->user()->can('purchase_order.view_all') ||
                    auth()->user()->can('purchase_order.view_own')))
            dateRangeSettings.startDate = moment('{{ $start_date }}', 'YYYY-MM-DD');
            dateRangeSettings.endDate = moment('{{ $start_date }}', 'YYYY-MM-DD');
            if ($('#purchase_list_filter_date_range').length == 1) {
                $('#purchase_list_filter_date_range').daterangepicker(dateRangeSettings,
                    function(start, end) {
                        $('#purchase_list_filter_date_range').val(
                            start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                        );
                        purchase_table_home.ajax.reload();
                    }
                );
                $('#purchase_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                    $('#product_sr_date_filter').val('');
                    purchase_table_home.ajax.reload();
                });
            }
            //Purchase table
            purchase_table_home = $('#purchase_table_home').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: false,
                dom: 'Btirp',
                buttons: [],

                aaSorting: [
                    [1, 'desc']
                ],
                ajax: {
                    url: '{{ action('PurchaseController@index') }}',
                    data: function(d) {
                        if ($('#purchase_list_filter_location_id').length) {
                            d.location_id = $('#purchase_list_filter_location_id').val();
                        }
                        if ($('#purchase_list_filter_supplier_id').length) {
                            d.supplier_id = $('#purchase_list_filter_supplier_id').val();
                        }
                        if ($('#purchase_list_filter_payment_status').length) {
                            d.payment_status = $('#purchase_list_filter_payment_status').val();
                        }
                        if ($('#purchase_list_filter_status').length) {
                            d.status = $('#purchase_list_filter_status').val();
                        }

                        var start = '';
                        var end = '';
                        if ($('#purchase_list_filter_date_range').val()) {
                            start = $('input#purchase_list_filter_date_range')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            end = $('input#purchase_list_filter_date_range')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        d.start_date = start;
                        d.end_date = end;

                        d = __datatable_ajax_callback(d);
                    },
                },
                aaSorting: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'ref_no',
                        name: 'ref_no'
                    },
                    {
                        data: 'location_name',
                        name: 'BS.name'
                    },
                    {
                        data: 'name',
                        name: 'contacts.name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'final_total',
                        name: 'final_total'
                    },
                    {
                        data: 'payment_due',
                        name: 'payment_due',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'added_by',
                        name: 'u.first_name'
                    },
                ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#purchase_table_home'));
                },
                "footerCallback": function(row, data, start, end, display) {
                    var total_purchase = 0;
                    var total_due = 0;
                    var total_purchase_return_due = 0;
                    for (var r in data) {
                        total_purchase += $(data[r].final_total).data('orig-value') ?
                            parseFloat($(data[r].final_total).data('orig-value')) : 0;
                        var payment_due_obj = $('<div>' + data[r].payment_due + '</div>');
                        total_due += payment_due_obj.find('.payment_due').data('orig-value') ?
                            parseFloat(payment_due_obj.find('.payment_due').data('orig-value')) : 0;

                        total_purchase_return_due += payment_due_obj.find('.purchase_return').data(
                                'orig-value') ?
                            parseFloat(payment_due_obj.find('.purchase_return').data('orig-value')) : 0;
                    }

                    $('.footer_purchase_total').html(__currency_trans_from_en(total_purchase));
                    $('.footer_total_due').html(__currency_trans_from_en(total_due));
                    $('.footer_total_purchase_return_due').html(__currency_trans_from_en(
                        total_purchase_return_due));
                    $('.footer_status_count').html(__count_status(data, 'status'));
                    $('.footer_payment_status_count').html(__count_status(data, 'payment_status'));
                },
                createdRow: function(row, data, dataIndex) {
                    $(row)
                        .find('td:eq(5)')
                        .attr('class', 'clickable_td');
                },
            });

            $(document).on(
                'change',
                '#purchase_list_filter_location_id, \
                                                                                                                                                                                #purchase_list_filter_supplier_id, #purchase_list_filter_payment_status,\
                                                                                                                                                                                  #purchase_list_filter_status',
                function() {
                    purchase_table_home.ajax.reload();
                }
            );
        @endif
    </script>

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

            sell_table = $('#sell_table_home').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: false,
                dom: 'Btirp',
                buttons: [],
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
                        d.created_by = $('#created_by').val();
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

                columns: [{
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
                    __currency_convert_recursively($('#sell_table_home'));
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
@endsection
