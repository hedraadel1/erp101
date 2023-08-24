<input type="checkbox" name="dialog_state_report" id="dialog_state_report" class="dialog_state_report">
@php
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
    $is_admin = auth()->user()->hasRole('Admin#' . session('business.id')) ? true : false;
@endphp
<div id='dialogreport'>
    <label id="dlg-back" for="dialog_state_report"></label>

    <div id='dlg-wrap' style="width: 900px;max-height: 36rem;">
        <label id="dlg-close" for="dialog_state_report"><i class="icon ion-ios-close-empty"></i></label>
      
        <div style="" class="content-header dlg-header" >
          <div class="newbox blue">
              <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('lang_v1.reports')</h3>
          </div>
      </div>
        <div class="row">
            @if (auth()->user()->can('purchase_n_sell_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/purchase-payment-report') }}"> <button class="button-19" role="button">تقرير
                            المشتريات</button></a>
                </div>
                
            @endif
            @if (auth()->user()->can('purchase_n_sell_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/product-purchase-report') }}"> <button class="button-19" role="button">تقرير مشتريات
                            المنتجات</button></a>
                </div>
                
            @endif

            @if (auth()->user()->can('purchase_n_sell_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/sell-payment-report') }}"> <button class="button-19" role="button">تقرير
                            المبيعات</button></a>
                </div>
            @endif
            
            @if (auth()->user()->can('purchase_n_sell_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/product-sell-report') }}"> <button class="button-19" role="button">تقرير مبيعات
                            المنتجات</button></a>
                </div>
                
            @endif
        </div>
        <div style="margin-top: 10px;" class="row">
            @if (auth()->user()->can('purchase_n_sell_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/items-report') }}"> <button class="button-19" role="button">تقرير
                            العناصر</button></a>
                </div>
                
            @endif
            @if (auth()->user()->can('trending_product_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/trending-products') }}"> <button class="button-19" role="button">المنتجات
                            الشائعة</button></a>
                </div>
            @endif
            @if (session('business.enable_lot_number') == 1)
                <div class="col-md-3">
                    <a href="{{ url('/reports/lot-report') }}"> <button class="button-19" role="button">تقرير المخزن</button></a>
                </div>
               
            @endif
            @if (auth()->user()->can('stock_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/stock-report') }}"> <button class="button-19" role="button">تقرير
                            المخزون</button></a>
                </div>
                
            @endif



        </div>
        <div style="margin-top: 10px;" class="row">
            @if (auth()->user()->can('profit_loss_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/profit-loss') }}"> <button class="button-19" role="button"> تقرير الربح /
                            الخسارة</button></a>
                </div>
                
            @endif
            @if (auth()->user()->can('sales_representative.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/sales-representative-report') }}"> <button class="button-19" role="button">تقرير
                            مندوب المبيعات</button></a>
                </div>
            @endif
           
            @if (auth()->user()->can('register_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/register-report') }}"> <button class="button-19" role="button">تقرير
                            المناوبة</button></a>
                </div>
            @endif
            @if (in_array('expenses', $enabled_modules) &&
                    auth()->user()->can('expense_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/expense-report') }}"> <button class="button-19" role="button">تقرير
                            المصاريف</button></a>
                </div>
                
            @endif
        </div>
        <div style="margin-top: 10px;" class="row">

            @if (in_array('stock_adjustment', $enabled_modules))
                <div class="col-md-3">
                    <a href="{{ url('/reports/stock-adjustment-report') }}"> <button class="button-19" role="button">تقرير المخزون
                            التالف</button></a>
                </div>
               
            @endif
            @if (auth()->user()->can('contacts_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/customer-group') }}"> <button class="button-19" role="button">تقرير مجموعات
                            العملاء</button></a>
                </div>
                
            @endif
            @if (auth()->user()->can('contacts_report.view'))
                <div class="col-md-3">
                    <a href="{{ url('/reports/customer-supplier') }}"> <button class="button-19" role="button">تقرير الموردين و
                            العملاء</button></a>
                </div>
                
            @endif

        </div>

    </div>
</div>
