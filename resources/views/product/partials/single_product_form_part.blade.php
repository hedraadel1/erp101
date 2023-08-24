@if (!session('business.enable_price_tax'))
    @php
        $default = 0;
        $class = 'hide';
    @endphp
@else
    @php
        $default = null;
        $class = '';
    @endphp
@endif

<div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed {{ $class }}">
        <tr style="background: #111827 !important;color: white !important;">
            <th style="background: #111827 !important;color: white !important;">@lang('product.default_purchase_price') <button
                    data-toggle="modal" data-target="#price_modal" style="float: left" type="button"
                    class="btn btn-success btn-xs ">السعر</button>
            </th>
            <th style="background: #111827 !important;color: white !important;">@lang('product.profit_percent')
                @show_tooltip(__('tooltip.profit_percent'))</th>
            <th style="background: #111827 !important;color: white !important;">@lang('product.default_selling_price')</th>
            @if (empty($quick_add))
                <th style="background: #111827 !important;color: white !important;">@lang('lang_v1.product_image')</th>
            @endif
        </tr>
        <tr>
            <td>
                <div class="col-sm-12">
                    {!! Form::label('single_dpp', trans('product.exc_of_tax') . ':*') !!}

                    {!! Form::text('single_dpp', $default, [
                        'class' => 'form-control input-sm dpp input_number',
                        'placeholder' => __('product.exc_of_tax'),
                        'required',
                    ]) !!}
                </div>

                <div style="display: none" class="">
                    {!! Form::label('single_dpp_inc_tax', trans('product.inc_of_tax') . ':*') !!}

                    {!! Form::text('single_dpp_inc_tax', $default, [
                        'class' => 'form-control input-sm dpp_inc_tax input_number',
                        'placeholder' => __('product.inc_of_tax'),
                        'required',
                    ]) !!}
                </div>
            </td>

            <td>

                {!! Form::label('single_dpp', trans('product.profitnum') . ':*') !!}
                {!! Form::text('profit_percent', @num_format($profit_percent), [
                    'class' => 'form-control input-sm input_number',
                    'id' => 'profit_percent',
                    'required',
                ]) !!}
            </td>

            <td>
                <label><span class="dsp_label">@lang('product.exc_of_tax')</span></label>
                {!! Form::text('single_dsp', $default, [
                    'class' => 'form-control input-sm dsp input_number',
                    'placeholder' => __('product.exc_of_tax'),
                    'id' => 'single_dsp',
                    'required',
                ]) !!}

                {!! Form::text('single_dsp_inc_tax', $default, [
                    'class' => 'form-control input-sm hide input_number',
                    'placeholder' => __('product.inc_of_tax'),
                    'id' => 'single_dsp_inc_tax',
                    'required',
                ]) !!}
            </td>
            @if (empty($quick_add))
                <td>
                    <div class="form-group">
                        {!! Form::label('variation_images', __('lang_v1.product_image') . ':') !!}
                        {!! Form::file('variation_images[]', ['class' => 'variation_images', 'accept' => 'image/*', 'multiple']) !!}
                        <small>
                            <p class="help-block">@lang('purchase.max_file_size', ['size' => config('constants.document_size_limit') / 1000000]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p>
                        </small>
                    </div>
                </td>
            @endif
        </tr>
    </table>
</div>

<div class="modal fade" id="price_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ادخل السعر للكيلو</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">سعر الشراء للكيلو</label>
                            <input type="number" step="0.00" class="form-control" id="purchase_price">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">سعر البيع للكيلو</label>
                            <input type="number" class="form-control" id="sell_price">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="calcPrice()" type="button" class="btn btn-primary">حساب السعر</button>
            </div>
        </div>
    </div>
</div>
