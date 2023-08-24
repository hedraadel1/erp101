<div class="ag-format-container">
    <div class="ag-courses_box ">
        @if ($contact->type == 'customer' || $contact->type == 'both')
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('report.total_sell')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_invoice }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="bg_green ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('contact.total_sale_paid')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->invoice_received }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('contact.total_sale_due')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_invoice - $contact->invoice_received }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div
                        class="{{ $contact->opening_balance_type == 'debit' ? 'bg_red' : 'bg-green' }} ag-courses-item_bg">
                    </div>
                    <div class="ag-courses-item_title">
                        @lang('lang_v1.opening_balance')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->opening_balance }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="bg_red ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('lang_v1.total_sell_return')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_sell_return }}</span>
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="bg_green ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('lang_v1.total_sell_return_due')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_sell_return - $contact->total_sell_return_paid }}</span>
                    </div>
                </a>
            </div>
        @endif

        @if ($contact->type == 'supplier' || $contact->type == 'both')
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class=" ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('report.total_purchase')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_purchase }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="bg_green ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('contact.total_purchase_paid')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->purchase_paid }}</span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="bg_red ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        @lang('contact.total_purchase_due')
                    </div>
                    <div class="ag-courses-item_date-box" id="customer_count">
                        <span class="display_currency" data-currency_symbol="true">
                            {{ $contact->total_purchase - $contact->purchase_paid }}</span>
                    </div>
                </a>
            </div>
            @if ($contact->type == 'supplier')
                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                        <div
                            class="{{ $contact->opening_balance_type == 'debit' ? 'bg_red' : 'bg-green' }} ag-courses-item_bg">
                        </div>
                        <div class="ag-courses-item_title">
                            @lang('lang_v1.opening_balance')
                        </div>
                        <div class="ag-courses-item_date-box" id="customer_count">
                            <span class="display_currency" data-currency_symbol="true">
                                {{ $contact->opening_balance }}</span>
                        </div>
                    </a>
                </div>
            @endif

        @endif


        @php
            $balance_type = explode(' ', $contact->getLastBalance($contact->id));
        @endphp
        <div class="ag-courses_item"style=" flex-basis: calc(100% - 30px);">
            <a href="#" class="ag-courses-item_link">
                <div
                    class="{{ isset($balance_type[1]) ? ($balance_type[1] == 'مدين' ? 'bg_red' : 'bg_green') : '' }} ag-courses-item_bg">
                </div>
                <div class="ag-courses-item_title">
                    @lang('lang_v1.balance_due')
                </div>
                <div class="ag-courses-item_date-box" id="customer_count">
                    <span class="" data-currency_symbol="true">
                        {{ $contact->getLastBalance($contact->id) }}</span>
                </div>
            </a>
        </div>
    </div>
</div>
