@extends('layouts.app')
@section('title', __('lang_v1.warehouse_inventory'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        {{-- <h1>@lang('lang_v1.warehouse_inventory')</h1> --}}

    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('lang_v1.warehouse_inventory'),
        ])
            {{-- @can('customer.view') --}}
            <form action="{{ action('WarehouseInventoryController@store') }}" method="post">
                @csrf
                <input type="hidden" name="location_id" value="{{ $location_id }}">
                <div class="form-group">
                    <input type="datetime-local" name="date" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="notes" placeholder="ملاحظات" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>@lang('lang_v1.product_name')</th>
                                <th>@lang('lang_v1.old_quantity')</th>
                                <th>@lang('lang_v1.new_quantity')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->qty_available }} - {{ optional($item->unit)->actual_name }}</td>
                                    <td>
                                        <input type="number" step="any" class="form-control"
                                            value="{{ $item->qty_available }}"
                                            name="products[{{ $item->product_id }}][new_quantity]">
                                        <input type="hidden" name="products[{{ $item->product_id }}][variation_id]"
                                            value="{{ $item->variation_id }}">
                                        <input type="hidden" name="products[{{ $item->product_id }}][old]"
                                            value="{{ $item->qty_available }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn button-29">حفظ</button>
                </div>
            </form>
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
