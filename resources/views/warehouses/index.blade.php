@extends('layouts.app')
@section('title', __('business.warehouses'))

@section('content')

    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('business.warehouses')
            </h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {{-- {!! Form::open([
                    'url' => action('ReportController@getStockReport'),
                    'method' => 'get',
                    'id' => 'sales_representative_filter_form',
                ]) !!} --}}

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('location_id', __('business.business_location') . ':') !!}
                            {!! Form::select('location_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'id' => 'location_id',
                                'style' => 'width:100%',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('warehouse_category_id', __('lang_v1.warehouse_categories') . ':') !!}
                            <select name="warehouse_category_id" class="form-control select2" id="warehouse_category_id">
                                <option value="">{{ __('lang_v1.all_your_warehouse_categories') }}</option>
                                @foreach ($warehouse_categories as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>



                    {!! Form::close() !!}
                @endcomponent
            </div>
        </div>
        @component('components.widget', ['class' => 'box-primary', 'title' => __('business.all_your_warehouse')])
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            @can('add_warehouse')
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('WarehouseController@create') }}" data-container=".location_add_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            @endcan

                        </div>
                    </div>
                </div>
            @endslot
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="warehouse_table">
                    <thead>
                        <tr>
                            <th>@lang('invoice.name')</th>
                            <th>@lang('business.warehouse_id')</th>
                            {{-- <th>@lang('business.landmark')</th> --}}
                            <th>@lang('business.location')</th>
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
