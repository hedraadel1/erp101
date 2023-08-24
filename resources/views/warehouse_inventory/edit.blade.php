@extends('layouts.app')
@section('title', __('lang_v1.warehouse_inventory'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('lang_v1.warehouse_inventory')</h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            // 'title' => __('lang_v1.all_your_warehouse_inventory'),
        ])
            {{-- @can('customer.create') --}}

            {{-- @endcan --}}
            {{-- @can('customer.view') --}}
            <form action="{{ action('WarehouseInventoryController@update', $warehouse_inventory->id) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="location_id" value="{{ $warehouse_inventory->location_id }}">
                <div class="form-group">
                    <input type="datetime-local" name="date" class="form-control" value="{{ $warehouse_inventory->date }}">
                </div>
                <div class="form-group">
                    <textarea name="notes" class="form-control" id="" cols="30" rows="10" placeholder="ملاحظات">{{ $warehouse_inventory->notes }}</textarea>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>@lang('lang_v1.product_name')</th>
                                <th>@lang('business.old_quantity')</th>
                                <th>@lang('messages.new_quantity')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouse_inventory->inventory_products as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->old_quantity }} - {{ optional(optional($item->product)->unit)->actual_name }}
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control"
                                            value="{{ $item->new_quantity }}"
                                            name="products[{{ $item->product_id }}][new_quantity]">
                                        <input type="hidden" name="products[{{ $item->product_id }}][variation_id]"
                                            value="{{ $item->variation_id }}">
                                        <input type="hidden" name="products[{{ $item->product_id }}][old]"
                                            value="{{ $item->old_quantity }}">

                                        {{-- <input type="number" step="any" class="form-control"
                                            value="{{ $item->new_quantity }}"
                                            name="products[{{ $item->product_id }}][{{ $item->old_quantity }}][new_quantity]"> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn button-29">تحديث</button>
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
