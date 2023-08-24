@extends('layouts.app')
@section('title', __('invoice.invoice_settings'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('invoice.invoice_settings')
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">@lang('invoice.invoice_schemes')</a>
                        </li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">@lang('invoice.invoice_layouts')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            @component('components.widget', ['title' => __('invoice.all_your_invoice_schemes')])
                                @if (is_product_enabled('253'))
                                    @slot('tool')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn button-add btn-modal pull-right"
                                                    data-href="{{ action('InvoiceSchemeController@create') }}"
                                                    data-container=".invoice_modal">
                                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                                            </div>
                                        </div>
                                    @endslot
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="invoice_table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('invoice.name')
                                                            @show_tooltip(__('tooltip.invoice_scheme_name'))
                                                        </th>
                                                        <th>@lang('invoice.prefix')
                                                            @show_tooltip(__('tooltip.invoice_scheme_prefix'))
                                                        </th>
                                                        <th>@lang('invoice.start_number')
                                                            @show_tooltip(__('tooltip.invoice_scheme_start_number'))</th>
                                                        <th>@lang('invoice.invoice_count')
                                                            @show_tooltip(__('tooltip.invoice_scheme_count'))
                                                        </th>
                                                        <th>@lang('invoice.total_digits')
                                                            @show_tooltip(__('tooltip.invoice_scheme_total_digits'))</th>
                                                        <th>@lang('messages.action')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endcomponent





                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            @component('components.widget', ['title' => __('invoice.all_your_invoice_layouts')])
                                @if (is_product_enabled('278'))
                                    @slot('tool')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a class="btn button-add pull-right"
                                                    href="{{ action('InvoiceLayoutController@create') }}">
                                                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                                            </div>
                                        </div>
                                    @endslot
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($invoice_layouts as $layout)
                                            <div class="col-md-3">
                                                <div class="icon-link">
                                                    <a href="{{ action('InvoiceLayoutController@edit', [$layout->id]) }}">
                                                        <i class="fa fa-file-alt fa-4x"></i>
                                                        {{ $layout->name }}
                                                    </a>
                                                    @if ($layout->is_default)
                                                        <span class="badge bg-green">@lang('barcode.default')</span>
                                                    @endif
                                                    @if ($layout->locations->count())
                                                        <span class="link-des">
                                                            <b>@lang('invoice.used_in_locations'): </b><br>
                                                            @foreach ($layout->locations as $location)
                                                                {{ $location->name }}
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                                &nbsp;
                                                            @endforeach
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($loop->iteration % 4 == 0)
                                                <div class="clearfix"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endcomponent

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>

        <div class="modal fade invoice_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade invoice_edit_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
