@extends('layouts.app')
@section('title', __('tax_rate.tax_rates'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('tax_rate.tax_rates')
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('tax_rate.all_your_tax_rates')])
            @can('tax_rate.create')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('TaxRateController@create') }}" data-container=".tax_rate_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @can('tax_rate.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tax_rates_table">
                        <thead>
                            <tr>
                                <th>@lang('tax_rate.name')</th>
                                <th>@lang('tax_rate.rate')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        @component('components.widget', ['class' => 'box-primary'])
            @slot('title')
                @lang('tax_rate.tax_groups') ( @lang('lang_v1.combination_of_taxes') ) @show_tooltip(__('tooltip.tax_groups'))
            @endslot
            @can('tax_rate.create')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('GroupTaxController@create') }}" data-container=".tax_group_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @can('tax_rate.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tax_groups_table">
                        <thead>
                            <tr>
                                <th>@lang('tax_rate.name')</th>
                                <th>@lang('tax_rate.rate')</th>
                                <th>@lang('tax_rate.sub_taxes')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade tax_rate_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade tax_group_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->
@endsection
