@component('components.widget', ['title' => 'أحصائيات مختصره'])
    <div class="ag-format-container" style="width: 100%">
        {{-- @if ($type == 'customer') --}}
        <div class="ag-courses_box ">
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link" style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        عدد المنتجات
                    </div>
                    <div class="ag-courses-item_date-box" id="product_count">
                        {{-- {{ $customer_count }} --}}
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        عدد التصنيفات الرئيسية
                    </div>
                    <div class="ag-courses-item_date-box" id="category_count">
                        {{-- {{ $total_debit }} --}}
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        عدد النتجات المنتهية
                    </div>
                    <div class="ag-courses-item_date-box" id="product_count_finished">
                        {{-- {{ $total_sell_return }} --}}
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        عدد المنتجات لحد المخزون
                    </div>
                    <div class="ag-courses-item_date-box" id="product_count_expire">
                        {{-- {{ $total_sell_return }} --}}
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        قيمة المنتجات بسعر الشراء
                    </div>
                    <div class="ag-courses-item_date-box" id="product_total_purchase">
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        قيمة المنتجات بسعر البيع
                    </div>
                    <div class="ag-courses-item_date-box" id="product_total_sell">
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>



        </div>
        {{-- @endif --}}
    </div>
@endcomponent
