@extends('layouts.app')
@section('title', __('barcode.print_labels'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('barcode.print_labels') @show_tooltip(__('tooltip.print_label'))
            </h3>
        </div>

    </section>
    <section class="content-header">
        <br>
        <h1></h1>
        <!-- <ol class="breadcrumb">
                                                                                                                        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                                                                                                                        <li class="active">Here</li>
                                                                                                                    </ol> -->
    </section>

    <!-- Main content -->
    <section class="content no-print">
        {!! Form::open(['url' => action('LabelsBarcodeController@preview'), 'method' => 'post']) !!}
        @component('components.widget', ['class' => 'box-primary', 'title' => __('product.add_product_for_labels')])
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            {!! Form::text('search_product', null, [
                                'class' => 'form-control',
                                'id' => 'search_product_for_label',
                                'placeholder' => __('lang_v1.enter_product_name_to_print_labels'),
                                'autofocus',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-2">
                    <table class="table table-bordered table-striped table-condensed" id="product_table">
                        <thead>
                            <tr>
                                <th>@lang('barcode.products')</th>
                                <th>@lang('barcode.no_of_labels')</th>
                                @if (request()->session()->get('business.enable_lot_number') == 1)
                                    <th>@lang('lang_v1.lot_number')</th>
                                @endif
                                @if (request()->session()->get('business.enable_product_expiry') == 1)
                                    <th>@lang('product.exp_date')</th>
                                @endif
                                <th>@lang('lang_v1.packing_date')</th>
                                <th>@lang('lang_v1.selling_price_group')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('labels.partials.show_table_rows', ['index' => 0])
                        </tbody>
                    </table>
                </div>
            </div>
        @endcomponent

        @component('components.widget', ['class' => 'box-primary', 'title' => __('barcode.info_in_labels')])
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked name="print[name]" value="1">
                                        <b>@lang('barcode.print_name')</b>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                    <input type="text" class="form-control" name="print[name_size]" value="12">
                                </div>
                            </td>

                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked name="print[variations]" value="1">
                                        <b>@lang('barcode.print_variations')</b>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                    <input type="text" class="form-control" name="print[variations_size]" value="12">
                                </div>
                            </td>

                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked name="print[price]" value="1" id="is_show_price">
                                        <b>@lang('barcode.print_price')</b>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                    <input type="text" class="form-control" name="print[price_size]" value="10">
                                </div>

                            </td>

                            <td>

                                <div class="" id="price_type_div">
                                    <div class="form-group">
                                        {!! Form::label('print[price_type]', @trans('barcode.show_price') . ':') !!}
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-info"></i>
                                            </span>
                                            {!! Form::select(
                                                'print[price_type]',
                                                ['inclusive' => __('product.inc_of_tax'), 'exclusive' => __('product.exc_of_tax')],
                                                'inclusive',
                                                ['class' => 'form-control'],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked name="print[business_name]" value="1">
                                        <b>@lang('barcode.print_business_name')</b>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                    <input type="text" class="form-control" name="print[business_name_size]" value="13">
                                </div>
                            </td>

                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked name="print[packing_date]" value="1">
                                        <b>@lang('lang_v1.print_packing_date')</b>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                    <input type="text" class="form-control" name="print[packing_date_size]" value="12">
                                </div>
                            </td>

                            <td>
                                @if (request()->session()->get('business.enable_lot_number') == 1)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" checked name="print[lot_number]" value="1">
                                            <b>@lang('lang_v1.print_lot_number')</b>
                                        </label>
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                        <input type="text" class="form-control" name="print[lot_number_size]" value="12">
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if (request()->session()->get('business.enable_product_expiry') == 1)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" checked name="print[exp_date]" value="1">
                                            <b>@lang('lang_v1.print_exp_date')</b>
                                        </label>
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-addon"><b>@lang('lang_v1.size')</b></div>
                                        <input type="text" class="form-control" name="print[exp_date_size]" value="12">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>





                <div class="col-sm-12">
                    <hr />
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('price_type', @trans('barcode.barcode_setting') . ':') !!}
                    </div>
                    {{-- <div class="col-sm-12">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('is_continuous', 1, false, ['id' => 'is_continuous']) !!} @lang('barcode.is_continuous')</label>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('top_margin', __('barcode.top_margin') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                                </span>
                                {!! Form::number('barcode_setting[top_margin]', $barcode_settings->top_margin ?? 0, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.top_margin'),
                                    'min' => 0,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('left_margin', __('barcode.left_margin') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                                </span>
                                {!! Form::number('barcode_setting[left_margin]', $barcode_settings->left_margin ?? 0, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.left_margin'),
                                    'min' => 0,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div> --}}
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('width', __('barcode.width') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-text-width" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[width]', $barcode_settings->width, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.width'),
                                    'min' => 0.1,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('height', __('barcode.height') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-text-height" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[height]', $barcode_settings->height, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.height'),
                                    'min' => 0.1,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('paper_width', __('barcode.paper_width') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-text-width" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[paper_width]', $barcode_settings->paper_width, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.paper_width'),
                                    'min' => 0.1,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 paper_height_div">
                        <div class="form-group">
                            {!! Form::label('paper_height', __('barcode.paper_height') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-text-height" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[paper_height]', $barcode_settings->paper_height ?? 0, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.paper_height'),
                                    'min' => 0.1,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('stickers_in_one_row', __('barcode.stickers_in_one_row') . ':*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[stickers_in_one_row]', $barcode_settings->stickers_in_one_row, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.stickers_in_one_row'),
                                    'min' => 1,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('row_distance', __('barcode.row_distance') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-resize-vertical" aria-hidden="true"></span>
                                </span>
                                {!! Form::number('barcode_setting[row_distance]', $barcode_settings->row_distance ?? 0, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.row_distance'),
                                    'min' => 0,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('col_distance', __('barcode.col_distance') . ' (' . __('barcode.in_in') . '):*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span>
                                </span>
                                {!! Form::number('barcode_setting[col_distance]', $barcode_settings->col_distance ?? 0, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.col_distance'),
                                    'min' => 0,
                                    'step' => 0.00001,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    {{-- <div class="col-sm-6 stickers_per_sheet_div">
                        <div class="form-group">
                            {!! Form::label('stickers_in_one_sheet', __('barcode.stickers_in_one_sheet') . ':*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-th" aria-hidden="true"></i>
                                </span>
                                {!! Form::number('barcode_setting[stickers_in_one_sheet]', $barcode_settings->stickers_in_one_sheet, [
                                    'class' => 'form-control',
                                    'placeholder' => __('barcode.stickers_in_one_sheet'),
                                    'min' => 1,
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div> --}}

                </div>

                <div class="clearfix"></div>

                <div class="col-sm-4 col-sm-offset-8">
                    <button type="submit" id="labels_preview_"
                        class="btn btn-primary pull-right btn-flat btn-block">@lang('barcode.preview')</button>
                </div>
            </div>
        @endcomponent
        {!! Form::close() !!}


        <div class="clearfix"></div>
    </section>

    <!-- Preview section-->
    <div id="preview_box">
    </div>

@stop
@section('javascript')
    <script src="{{ asset('js/labels.js?v=' . $asset_v) }}"></script>
@endsection
