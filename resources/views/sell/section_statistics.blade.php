@component('components.widget', ['title' => 'أحصائيات مختصره'])
<div class="ag-format-container" style="width: 100%">
    {{-- @if ($type == 'customer') --}}
    <div class="ag-courses_box ">
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link" style="padding: 15px 20px;">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    عدد الفواتير
                </div>
                <div class="ag-courses-item_date-box" id="invoice_count">
                    {{-- {{ $customer_count }} --}}
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg bg-green"></div>
                <div class="ag-courses-item_title">
                    عدد المدفوعة
                </div>
                <div class="ag-courses-item_date-box" id="invoice_paid_count">
                    {{-- {{ $total_debit }} --}}
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    عدد الجزئية
                </div>
                <div class="ag-courses-item_date-box" id="invoice_partial_count">
                    {{-- {{ $total_sell_return }} --}}
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    عدد المستحقة
                </div>
                <div class="ag-courses-item_date-box" id="invoice_due_count">
                    {{-- {{ $total_sell_return }} --}}
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    اجمالى قيمة المبيعات
                </div>
                <div class="ag-courses-item_date-box" id="invoice_total">
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    اجمالى قيمة المستحقات
                </div>
                <div class="ag-courses-item_date-box" id="invoice_partial_total">
                    
                </div>
            </a>
        </div>
        <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link"style="padding: 15px 20px;">
                <div class="ag-courses-item_bg bg-danger"></div>
                <div class="ag-courses-item_title">
                    اجمالى المرتجعات
                </div>
                <div class="ag-courses-item_date-box" id="invoice_return_total">
                    
                </div>
            </a>
        </div>



    </div>
    {{-- @endif --}}
</div>
@endcomponent