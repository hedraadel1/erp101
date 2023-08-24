<!--Purchase related settings -->
<div class="pos-tab-content">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="business_products_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('superadmin::lang.product_name')</th>
                        <th>@lang('superadmin::lang.product_code')</th>
                        <th>@lang('superadmin::lang.price')</th>
                        {{-- <th>@lang('messages.action')</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (count($products) >0 )
                    @foreach ($products as $item)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th>{{ $item->name }}</th>
                        <th>{{ $item->code }}</th>
                        <th>{{ $item->price_after_discount }}</th>
                        {{-- <th>
                        <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@deleteProduct', $item->id) }}"
                            class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </th> --}}
                    </tr>
                @endforeach
                    @else
                        <tr>
                          <th colspan="4">
                            <span>
                              لا توجد منتجات
                            </span>
                          </th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
