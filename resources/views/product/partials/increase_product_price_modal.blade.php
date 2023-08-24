<div class="modal fade" id="increase_product_price_modal" tabindex="-1" role="dialog">
    {!! Form::open([
        'url' => action('ProductController@increaseProductsPrice'),
        'method' => 'post',
    ]) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    زيادة أسعار المنتجات
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('all-product', __('product.in_case') . __('lang_v1.all_products') . ':') !!}
                            <input type="checkbox" name="all_product" value="1" id="all-product">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('', __('product.pro_category') . ':') !!}
                            {!! Form::select('category_id', $categories, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                // 'id' => 'product_list_filter_category_id',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('brand_id', __('product.pro_brand') . ':') !!}
                            {!! Form::select('brand_id', $brands, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('lang_v1.all'),
                            ]) !!}
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('', __('product.amount_increas') . ':') !!}
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            @php
                                $types = ['fixed' => 'ثابت', 'presentage' => 'نسبة مئوية'];
                            @endphp
                            {!! Form::label('', __('product.amount_type') . ':') !!}
                            {!! Form::select('amount_type', $types, 'fixed', [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'required',
                                'placeholder' => __('product.select'),
                            ]) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    @lang('messages.close')
                </button>
                <button type="submit" class="btn btn-primary ">
                    @lang('messages.save')
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
