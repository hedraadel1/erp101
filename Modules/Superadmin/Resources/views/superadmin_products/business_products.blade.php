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
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('superadmin::lang.business_products')</h3>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('superadmin::lang.business_products'),
        ])
            {{-- @can('customer.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="business_products_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('superadmin::lang.product_name')</th>
                            <th>@lang('superadmin::lang.product_code')</th>
                            <th>@lang('superadmin::lang.price')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $item->name }}</th>
                                <th>{{ $item->code }}</th>
                                <th>{{ $item->price_after_discount }}</th>
                                <th>
                                    <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@deleteProduct', $item->id) }}"
                                        class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- @endcan --}}
        @endcomponent



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
