@if (count($data))
    @foreach ($data as $key => $items)
        @if ($key == 'users' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم المستخدمين</b> --}}
                @can('user.view')
                    <a href="{{ action('ManageUserController@index') }}" class=" btn-block btn btn-xs bg-blue">
                        قسم المستخدمين
                    </a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->username }}
                                        <br><small>{{ $item->getRoleNameAttribute() }}</small>
                                    </b>
                                    <div class="buttons">
                                        @can('user.update')
                                            <a href="{{ action('ManageUserController@edit', [$item->id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
            <hr>
        @elseif($key == 'customer' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم العملاء</b> --}}
                @can('user.view')
                    <a href="{{ action('ContactController@index', ['type' => 'customer']) }}"
                        class=" btn-block btn btn-xs bg-orange">قسم العملاء</a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->name }}
                                        <br>الهاتف:<small>{{ $item->mobile }}</small>
                                        {{-- {{ dd($item->getLastBalance($item->id)) }} --}}
                                        <br>الرصيد النهائي :<small>{{ $item->getLastBalance($item->id) }}</small>
                                    </b>
                                    <div class="buttons">
                                        @can('customer.view')
                                            <a href="{{ action('ContactController@show', [$item->id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fas fa-eye"></i></a>
                                            &nbsp;
                                        @endcan
                                        @can('customer.update')
                                            <a href="{{ action('ContactController@edit', [$item->id]) }}"
                                                class=" edit_contact_button btn btn-xs bg-blue"><i
                                                    class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
        @elseif($key == 'supplier' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم العملاء</b> --}}
                @can('user.view')
                    <a href="{{ action('ContactController@index', ['type' => 'supplier']) }}"
                        class=" btn-block btn btn-xs bg-green">قسم الموردين</a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->name }}
                                        <br>الهاتف:<small>{{ $item->mobile }}</small>
                                        {{-- {{ dd($item->getLastBalance($item->id)) }} --}}
                                        <br>الرصيد النهائي :<small>{{ $item->getLastBalance($item->id) }}</small>
                                    </b>
                                    <div class="buttons">
                                        @can('customer.view')
                                            <a href="{{ action('ContactController@show', [$item->id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fas fa-eye"></i></a>
                                            &nbsp;
                                        @endcan
                                        @can('customer.update')
                                            <a href="{{ action('ContactController@edit', [$item->id]) }}"
                                                class=" edit_contact_button btn btn-xs bg-blue"><i
                                                    class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
        @elseif($key == 'product' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم العملاء</b> --}}
                @can('user.view')
                    <a href="{{ action('ProductController@index') }}" target="_blank"
                        class=" btn-block btn btn-xs text-white" style="background: #964B00">قسم المنتجات</a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->name }}
                                        <br>الكميه : <small>{{ round($item->qty_available, 1) }}</small>
                                        <br>السعر : <small> @format_currency($item->selling_price)</small>
                                    </b>
                                    <div class="buttons">
                                        @can('product.view')
                                            <a href="{{ action('ProductController@view', [$item->product_id]) }}"
                                                class=" view_product_modal btn btn-xs bg-blue"><i
                                                    class="fas fa-eye"></i></a>
                                            &nbsp;
                                        @endcan
                                        @can('product.update')
                                            <a href="{{ action('ProductController@edit', [$item->product_id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
        @elseif($key == 'sells' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم العملاء</b> --}}
                @can('user.view')
                    <a href="{{ action('SellController@index') }}" target="_blank" class=" btn-block btn btn-xs bg-green"
                        style="">قسم المبيعات</a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->name }}
                                        <br>رقم الفاتورة : <small>{{ $item->invoice_no_text }}</small>
                                        <br>الاجمالي : <small> @format_currency($item->final_total)</small>
                                    </b>
                                    <div class="buttons">
                                        @can('sell.view')
                                            <a href="{{ action('SellController@show', [$item->id]) }}"
                                                class=" view_product_modal btn btn-xs bg-blue"><i
                                                    class="fas fa-eye"></i></a>
                                            &nbsp;
                                        @endcan
                                        @can('sell.update')
                                            <a href="{{ action('SellPosController@edit', [$item->id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
        @elseif($key == 'purchase' && count($items) > 0)
            <ul class="list-unstyled list-group" style="padding: 0px!important">
                {{-- <b class="h5">قسم العملاء</b> --}}
                @can('user.view')
                    <a href="{{ action('PurchaseController@index') }}" target="_blank"
                        class=" btn-block btn btn-xs text-white" style="background: #aeaba8">قسم المشتريات</a>
                    &nbsp;
                @endcan
                @if (count($items) > 0)
                    @foreach ($items as $item)
                        <li class="media" style="width: 100%  ;  border-bottom: 1px solid #c5c2c2;">
                            <a href="#" class="list_search_item ">
                                <div class="" style="display:flex;justify-content: space-between;">
                                    {{-- {{ dd($items) }} --}}
                                    <b class="mt-0 mb-1">{{ optional($item)->name }}
                                        <br>رقم الفاتورة : <small>{{ $item->invoice_no_text }}</small>
                                        <br>الاجمالي : <small> @format_currency($item->final_total)</small>
                                    </b>
                                    <div class="buttons">
                                        @can('product.view')
                                            <a href="{{ action('PurchaseController@show', [$item->id]) }}"
                                                class=" view_product_modal btn btn-xs bg-blue"><i
                                                    class="fas fa-eye"></i></a>
                                            &nbsp;
                                        @endcan
                                        @can('product.update')
                                            <a href="{{ action('PurchaseController@edit', [$item->id]) }}"
                                                class="  btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>
                                            &nbsp;
                                        @endcan

                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <br>
                    <li class="list-item">
                        لا توجد نتائج
                    </li>
                @endif
            </ul>
        @endif
    @endforeach
@else
    <div>
        <p>{{ __('front.not_found') }}</p>
    </div>
@endif
