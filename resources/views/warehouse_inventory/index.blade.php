@extends('layouts.app')
@section('title', __('lang_v1.warehouse_inventory'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.warehouse_inventory')
            </h3>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('lang_v1.all_your_warehouse_inventory'),
        ])
            {{-- @can('customer.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            {{-- <button type="button" class="btn btn-block btn-primary btn-modal"
                        data-href="{{ action('WarehouseInventoryController@create') }}" data-container=".warehouse_inventory_modal">
                        <i class="fa fa-plus"></i> @lang('messages.add')</button> --}}
                            <button type="button" class="btn btn-block button-add btn-modal" data-toggle="modal"
                                data-target="#warehouse_inventory_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            {{-- @can('customer.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="warehouse_inventory_table">
                    <thead>
                        <tr>
                            <th>@lang('lang_v1.date')</th>
                            <th>@lang('business.location')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
            {{-- @endcan --}}
        @endcomponent

        <div class="modal fade warehouse_inventory_modal" id="warehouse_inventory_modal" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open([
                        'url' => action('WarehouseInventoryController@create'),
                        'method' => 'get',
                        // 'id' => 'customer_group_add_form',
                    ]) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">اضافة اذن جرد</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            @php
                                $default_location = null;
                                if (count($business_locations) == 1) {
                                    $default_location = array_key_first($business_locations->toArray());
                                }
                            @endphp
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('location_id', __('business.business_locations_warehouse') . ':') !!} @show_tooltip(__('lang_v1.product_location_help'))
                                    <br>
                                    {!! Form::select('location_id', $business_locations, $default_location, [
                                        'class' => 'form-control select2',
                                        // 'multiple',
                                        'required',
                                        'style' => 'width:100%',
                                        'id' => 'location_id',
                                    ]) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn button-add">@lang('lang_v1.send')</button>
                        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button> --}}
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

        </div>
        <div class="modal fade warehouse_inventory_show" id="warehouse_inventory_show" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel"></div>
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
