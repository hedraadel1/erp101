@extends('layouts.app')
@section('title', __('lang_v1.warehouse_categories'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.warehouse_categories')
            </h3>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('lang_v1.all_your_warehouse_categories'),
        ])
            {{-- @can('customer.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            <button type="button" class="btn btn-block button-add btn-modal"
                                data-href="{{ action('WarehouseCategoryController@create') }}"
                                data-container=".warehouse_categories_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            @can('customer.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="warehouse_category_table">
                        <thead>
                            <tr>
                                <th>@lang('lang_v1.warehouse_category_name')</th>
                                <th>@lang('lang_v1.description')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade warehouse_categories_modal" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
        </div>

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
