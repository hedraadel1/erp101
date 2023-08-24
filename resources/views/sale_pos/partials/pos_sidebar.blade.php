<div class="row" id="featured_products_box" style="display: none;">
    @if (!empty($featured_products))
        @include('sale_pos.partials.featured_products')
    @endif
</div>


<div style="margin-right: unset !important;margin-left: 15px;" class="">
    <div class="  no-padding pr-12">
        <div style="border-radius: 25px;height: 515px;" class="box box-solid mb-12 ">
            <div class="box-body pb-0">
                <input type="hidden" id="suggestion_page" value="1">
                <div class="">
                    <div class="eq-height-row" id="product_list_body"></div>
                </div>
                <div class=" text-center" id="suggestion_page_loader" style="display: none;">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
