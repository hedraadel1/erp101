@if (count($products) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>#</td>
                <td>أسم المنتج</td>
                <td>الكميه المحجوزة</td>
                {{-- <td>الكميه المحجوزة</td> --}}
            </tr>
        </thead>
        @foreach ($products as $product)
            <tr class="cursor-pointer">
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    ({{ optional($product->product)->name }})
                </td>
                <td class="">
                    {{ $product->product->unit->short_name }} {{ $product->product_qty }}
                </td>
                {{-- <td>

                     <a class="btn btn-success"
                        href="{{ action('SellPosController@confirmInvoiceBooking', [$transaction->id]) }}">
                        <i class="fas fa-pen " aria-hidden="true" title="تاكيد الحجز"></i> تاكيد الحجز
                    </a>
                  
                    <a class="btn btn-danger"
                        href="{{ action('SellPosController@cancelInvoiceBooking', [$transaction->id]) }}"><i
                            class="fas fa-undo"></i>
                        الغاء الحجز</a> 

                </td> --}}
            </tr>
        @endforeach
    </table>
@else
    <p>لا توجد منتجات</p>
@endif
