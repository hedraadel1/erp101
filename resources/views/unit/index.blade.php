@extends('layouts.app')
@section('title', __('unit.units'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('unit.units')
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('unit.all_your_units')])
            @can('unit.create')
                @slot('tool')
                    <div class="row">
                        <div class="box-tools">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('UnitController@create') }}" data-container=".unit_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float: left" class="btn  button-add increase_product_price">
                                    تسعير المنتجات
                                </button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @can('unit.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="unit_table">
                        <thead>
                            <tr>
                                <th>@lang('unit.name')</th>
                                <th>@lang('unit.short_name')</th>
                                <th>@lang('unit.allow_decimal') @show_tooltip(__('tooltip.unit_allow_decimal'))</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade unit_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        @include('unit.edit_price', ['units_for_price' => $units_for_price])
    </section>
    <!-- /.content -->

@endsection
@section('javascript')
    <script>
        $(document).on('click', '.increase_product_price', function(e) {
            e.preventDefault();
            var selected_rows = getSelectedRows();
            $('#increase_product_price_modal').modal('show');

        });
    </script>
@endsection
