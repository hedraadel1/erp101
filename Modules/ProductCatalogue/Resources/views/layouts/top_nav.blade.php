@php
    // if((!request()->routeIs('front.checkout')) && (!request()->routeIs('front.cart'))) {
    // Cart Queries
    $user = auth()->user();
    $carts = auth()->check()
        ? auth()
            ->user()
            ->cart()
            ->with('product')
            ->get()
        : \Gloudemans\Shoppingcart\Facades\Cart::content();
    // $mapping = $carts->map(function ($item) {
    //     $cost = auth()->check() ? $item->product->after_discount_with_tax * $item->quantity : $item->model->after_discount_with_tax * $item->qty;
    //     $item->product_total = sprintf('%0.2f', $cost);
    //     return $cost;
    // });
    
    $items_count = $carts->sum(auth()->check() ? 'quantity' : 'qty');
    // $resultCheckout = [
    //     'items_count' => $items_count,
    //     'sub_total' => number_format(array_sum($mapping->toArray()), 2, '.', ''),
    //     'items' => $carts,
    // ];
    // }
@endphp

<div class="" style="padding: 10px;border-bottom:1px solid">
    <span class="float-right" style="float: right">
        <a href="{{ route('logout') }}" class="btn btn-info">تسجيل خروج</a>
    </span>
    <div class="links " style="display: flex;">
        <a class="nav-link cart_trigger " href="{{ route('product_catalogue.cart') }}" style="margin: 0px 5px">
            <i class="ion-android-cart" style="font-size: 40px"></i>
            <span class="cart_count bg-main"
                style="    position: absolute;left: 10px;color:#fff; background: rgb(0 25 147 / 78%);border-radius: 50px ;border-radius: 50px;padding: 2px 5px;">
                <span>{{ isset($items_count) ? ($items_count > 99 ? '+99' : $items_count) : '0' }}</span>
            </span>
        </a>
        <a class="nav-link" style="margin: 0px 5px"
            href="{{ route('catalogue.view', [auth()->user()->business_id, session('catalog.location_id')]) }}">
            <h3>المنتجات</h3>
        </a>
    </div>
</div>
