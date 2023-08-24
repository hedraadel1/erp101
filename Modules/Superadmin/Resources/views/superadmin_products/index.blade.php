@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.business_products'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('superadmin::lang.brand_store')</h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('superadmin::lang.all_products'),
        ])
            {{-- @can('customer.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            <a class="btn btn-block  button-add "
                                href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@create') }}">
                                <i class="fa fa-plus"></i> @lang('messages.add')</a>
                            {{-- <button type="button" class="btn btn-block btn-primary btn-modal" data-toggle="modal"
                        data-target="#products_modal">
                        <i class="fa fa-plus"></i> @lang('messages.add')</button> --}}
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            {{-- @can('customer.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="superadmin_products_table">
                    <thead>
                        <tr>
                            <th>@lang('superadmin::lang.image')</th>
                            <th>@lang('superadmin::lang.product_name')</th>
                            <th>@lang('superadmin::lang.product_code')</th>
                            <th>@lang('superadmin::lang.price')</th>
                            <th>@lang('superadmin::lang.free_price')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
            {{-- @endcan --}}
        @endcomponent


        <div class="modal fade superadmin_products_show" id="products_show" tabindex="-1" role="dialog"
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
