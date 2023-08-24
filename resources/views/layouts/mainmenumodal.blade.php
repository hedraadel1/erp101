<input type="checkbox" name="dialog_state" id="dialog_state" class="dialog_state">
@php
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
    $is_admin = auth()
        ->user()
        ->hasRole('Admin#' . session('business.id'))
        ? true
        : false;
@endphp
<div id='dialog'>
    <label id="dlg-back" for="dialog_state"></label>

    <div id='dlg-wrap'>
        <label id="dlg-close" for="dialog_state"><i class="icon ion-ios-close-empty"></i></label>
        <h2 id='dlg-header'>القائمة الرئيسية</h2>
        <div class="row">
            @if(in_array('purchases', $enabled_modules))
            @if(auth()->user()->can('purchase.view') || auth()->user()->can('view_own_purchase'))
            <div class="col-md-3">
                
                <a href="{{ url('/purchases') }}"> <button class="button-19" role="button">قسم المشتريات</button></a>
            </div>
            
            @endif
            @endif
            <div class="col-md-3">
             @if($is_admin || auth()->user()->hasAnyPermission(['sell.view', 'sell.create', 'direct_sell.access', 'direct_sell.view', 'view_own_sell_only', 'view_commission_agent_sell', 'access_shipping', 'access_own_shipping', 'access_commission_agent_shipping']))
                <a href="{{ url('/sells') }}"> <button class="button-19" role="button">قسم المبيعات</button></a>
            </div>
            @endif
            @if(auth()->user()->can('product.view'))
            <div class="col-md-3">
                <a href="{{ url('/products') }}"> <button class="button-19" role="button">قسم المنتجات</button></a>
            </div>
            @endif
            @if(in_array('expenses', $enabled_modules) && (auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense')))
            <div class="col-md-3">
                <a href="{{ url('/expenses') }}"> <button class="button-19" role="button">قسم المصاريف</button></a>
            </div>
            @endif
        </div>
        <div style="margin-top: 10px;" class="row">
            @if(auth()->user()->can('customer.view') || auth()->user()->can('customer.view_own'))
            <div class="col-md-3">
                <a href="{{ url('/contacts?type=customer') }}"> <button class="button-19" role="button">قسم العملاء</button></a>
            </div>
            @endif
            @if(auth()->user()->can('supplier.view') || auth()->user()->can('supplier.view_own'))
            <div class="col-md-3">
                <a href="{{ url('/contacts?type=supplier') }}"> <button class="button-19" role="button">قسم الموردين</button></a>
            </div>
            @endif
            @if(auth()->user()->can('user.view'))
            <div class="col-md-3">
                <a href="{{ url('/users') }}"> <button class="button-19" role="button">قسم المستخدمين</button></a>
            </div>
            @endif
            @if(auth()->user()->can('business_settings.access'))
            <div class="col-md-3">
                <a href="{{ url('/business/settings') }}"> <button class="button-19" role="button">اعدادات النشاط </button></a>
            </div>
            @endif
        </div>
        
    </div>
</div>
