@extends('layouts.app')
@section('title', __('business.business_locations'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('business.business_locations')
                <small>@lang('business.manage_your_business_locations')</small>
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('business.all_your_business_locations')])
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            <button type="button" class="btn btn-block button-add btn-modal"
                                data-href="{{ action('BusinessLocationController@create') }}" data-container=".location_add_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                </div>
            @endslot
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="business_location_table">
                    <thead>
                        <tr>
                            <th>@lang('invoice.name')</th>
                            <th>@lang('lang_v1.location_id')</th>
                            <th>@lang('business.landmark')</th>
                            <th>@lang('business.city')</th>
                            <th>@lang('business.zip_code')</th>
                            <th>@lang('business.state')</th>
                            <th>@lang('business.country')</th>
                            <th>@lang('lang_v1.price_group')</th>
                            <th>@lang('invoice.invoice_scheme')</th>
                            <th>@lang('lang_v1.invoice_layout_for_pos')</th>
                            <th>@lang('lang_v1.invoice_layout_for_sale')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcomponent

        <div class="modal fade location_add_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade location_edit_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
