<style>
    .display_elem {
        padding: 10px;
        margin-top: 8px;
        border: 1px dashed;
    }
</style>
<div class="row">
    <div class="col-lg-6">
        <div class="display_elem">
            <p>
                <strong>المنتج : </strong>
                <b>{{ $sell_product->product->name }}</b>
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="display_elem">
            <p>
                <strong>قيمة المنتج : </strong>
                <b> @format_currency($sell_product->unit_price_inc_tax) </b>
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="display_elem">
            <p>
                <strong>وقت البيع : </strong>
                <b>{{ $sell_product->created_at }}</b>
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="display_elem">
            <p>
                <strong>أسم العميل : </strong>
                <b>{{ optional(optional($sell_product->transaction))->contact->name }}</b>
            </p>
        </div>
    </div>

    @if (count($sell_product->warranties) > 0)
        <div class="col-lg-6">
            <div class="display_elem">
                <p>
                    <strong> الضمان : </strong>
                    <b>{{ optional($sell_product->warranties[0])->name . ' ' . optional($sell_product->warranties[0])->duration . __('lang_v1.' . optional($sell_product->warranties[0])->duration_type) }}</b>
                </p>
            </div>
        </div>
        @php
            $sell_date = Carbon\Carbon::parse($sell_product->created_at);
            // dd($sell_product->warranties[0]);
            if ($sell_product->warranties[0]->duration_type == 'years') {
                $fins_date = $sell_date->addMonth($sell_product->warranties[0]->duration * 12);
            } elseif ($sell_product->warranties[0]->duration_type == 'days') {
                $fins_date = $sell_date->addDay($sell_product->warranties[0]->duration);
            } else {
                $fins_date = $sell_date->addMonth($sell_product->warranties[0]->duration);
            }
            
            $months = $sell_date->diffInMonths($fins_date);
            // $diff = strtotime($fins_date->format('Y-m-d')) - strtotime($sell_date->format('Y-m-d'));
        @endphp
        <div class="col-lg-6">
            <div class="display_elem">
                <p>
                    <strong>وقت انتهاء الضمان : </strong>
                    <b>{{ $fins_date }}</b>
                </p>
            </div>
        </div>
    @else
        <div class="col-lg-6">
            <div class="display_elem">
                <p>
                    <strong> الضمان : </strong>
                    <b>لا يوجد ضمان</b>
                </p>
            </div>
        </div>
    @endif
</div>
