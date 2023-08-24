<div style="margin-right: unset;padding: 15px;border-radius: 25px;background: whitesmoke;" class="row box box-solid ">
    <div class="row" id="section_filter" style="{{ !isMobile() ? 'display: flex;flex-wrap: wrap;' : '' }}">
        {{-- <div class="row"> --}}
        @if (!empty($pos_settings['enable_transaction_date']))
            <div class="col-md-3">
                <div class="">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('transaction_date', $default_datetime, [
                                'class' => 'form-control',
                                'readonly',
                                'required',
                                'id' => 'transaction_date',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group">

                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    @if (!empty($pos_settings['enable_default_customer']))
                        <input type="hidden" id="default_customer_id" value="{{ $walk_in_customer['id'] ?? '' }}">
                        <input type="hidden" id="default_customer_name" value="{{ $walk_in_customer['name'] ?? '' }}">
                        <input type="hidden" id="default_customer_balance"
                            value="{{ $walk_in_customer['balance'] ?? '' }}">
                        <input type="hidden" id="default_customer_address"
                            value="{{ $walk_in_customer['shipping_address'] ?? '' }}">
                    @endif

                    @if (
                        !empty($walk_in_customer['price_calculation_type']) &&
                            $walk_in_customer['price_calculation_type'] == 'selling_price_group')
                        <input type="hidden" id="default_selling_price_group"
                            value="{{ $walk_in_customer['selling_price_group_id'] ?? '' }}">
                    @endif

                    <style>
                        #section_filter>div:nth-child(2)>div>div>span.select2.select2-container.select2-container--default {
                            width: 235.75px !important;
                        }
                    </style>
                    {!! Form::select('contact_id', [], null, [
                        'class' => 'form-control mousetrap ',
                        'id' => 'customer_id',
                        'placeholder' => 'Enter Customer name / phone',
                        'required',
                    ]) !!}
                    <span class="input-group-btn">
                        <button style="padding: {{ isMobile() ? '6px ' : '7px' }}" type="button"
                            class="btn btn-default bg-white btn-flat add_new_customer" data-name=""><i
                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                        <div style="    padding: 8px 4px;" id="link-show" type="button"
                            class="btn btn-sm btn-default bg-white btn-flat" data-name="">
                            <i class="fa fa-eye"></i>
                        </div>
                    </span>

                </div>
                <small class="text-danger hide contact_due_text"><strong>@lang('account.customer_due'):</strong>
                    <span></span></small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default bg-white btn-flat" data-toggle="modal"
                            data-target="#configure_search_modal"
                            title="{{ __('lang_v1.configure_product_search') }}"><i
                                class="fas fa-search-plus"></i></button>
                    </div>
                    {!! Form::text('search_product', null, [
                        'class' => 'form-control mousetrap',
                        'id' => 'search_product',
                        'placeholder' => __('lang_v1.search_product_placeholder'),
                        'disabled' => is_null($default_location) ? true : false,
                        'autofocus' => is_null($default_location) ? false : true,
                    ]) !!}
                    <span class="input-group-btn">

                        <!-- Show button for weighing scale modal -->
                        @if (isset($pos_settings['enable_weighing_scale']) && $pos_settings['enable_weighing_scale'] == 1)
                            <button type="button" class="btn btn-default bg-white btn-flat" id="weighing_scale_btn"
                                data-toggle="modal" data-target="#weighing_scale_modal" title="@lang('lang_v1.weighing_scale')"><i
                                    class="fa fa-digital-tachograph text-primary fa-lg"></i></button>
                        @endif


                        <button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product"
                            data-href="{{ action('ProductController@quickAdd') }}"
                            data-container=".quick_add_product_modal"><i
                                class="fa fa-plus-circle text-primary fa-lg"></i></button>
                    </span>
                </div>
            </div>
        </div>

        {{-- <div class=""> --}}
        @if (!empty($price_groups) && count($price_groups) > 1)
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-money-bill-alt"></i>
                        </span>
                        @php
                            reset($price_groups);
                            $selected_price_group = !empty($default_price_group_id) && array_key_exists($default_price_group_id, $price_groups) ? $default_price_group_id : null;
                        @endphp
                        {!! Form::hidden('hidden_price_group', key($price_groups), ['id' => 'hidden_price_group']) !!}
                        {!! Form::select('price_group', $price_groups, $selected_price_group, [
                            'class' => 'form-control select2',
                            'id' => 'price_group',
                        ]) !!}
                        <span class="input-group-addon">
                            @show_tooltip(__('lang_v1.price_group_help_text'))
                        </span>
                    </div>
                </div>
            </div>
        @else
            @php
                reset($price_groups);
            @endphp
            {!! Form::hidden('price_group', key($price_groups), ['id' => 'price_group']) !!}
        @endif
        @if (!empty($default_price_group_id))
            {!! Form::hidden('default_price_group', $default_price_group_id, ['id' => 'default_price_group']) !!}
        @endif
        {{-- </div> --}}
        <div class="clearfix" style="display: unset;"></div>

        {{-- </div> --}}


        {{-- <div class="row"> --}}
        @if (!empty($commission_agent))
            <div class="col-md-3" style="">
                @php
                    $is_commission_agent_required = !empty($pos_settings['is_commission_agent_required']);
                @endphp
                <div class="form-group">
                    {!! Form::select('commission_agent', $commission_agent, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang_v1.commission_agent'),
                        'id' => 'commission_agent',
                        'required' => $is_commission_agent_required,
                    ]) !!}
                </div>
            </div>
        @endif
        @if (!empty($pos_settings['show_invoice_layout']))
            <div class="col-md-3"style="">
                <div class="form-group">
                    {!! Form::select('invoice_layout_id', $invoice_layouts, $default_location->invoice_layout_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang_v1.select_invoice_layout'),
                        'id' => 'invoice_layout_id',
                    ]) !!}
                </div>
            </div>
        @endif
        <input type="hidden" name="pay_term_number" id="pay_term_number"
            value="{{ $walk_in_customer['pay_term_number'] ?? '' }}">
        <input type="hidden" name="pay_term_type" id="pay_term_type"
            value="{{ $walk_in_customer['pay_term_type'] ?? '' }}">




        @if (!empty($pos_settings['show_invoice_scheme']))
            <div class="col-md-3"style="">
                <div class="form-group">
                    {!! Form::select('invoice_scheme_id', $invoice_schemes, $default_invoice_schemes->id, [
                        'class' => 'form-control',
                        'placeholder' => __('lang_v1.select_invoice_scheme'),
                    ]) !!}
                </div>
            </div>
        @endif
        @if (in_array('types_of_service', $enabled_modules) && !empty($types_of_service))
            <div class="col-md-3"style="">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-external-link-square-alt text-primary service_modal_btn"></i>
                        </span>
                        {!! Form::select('types_of_service_id', $types_of_service, null, [
                            'class' => 'form-control',
                            'id' => 'types_of_service_id',
                            'style' => 'width: 100%;',
                            'placeholder' => __('lang_v1.select_types_of_service'),
                        ]) !!}

                        {!! Form::hidden('types_of_service_price_group', null, ['id' => 'types_of_service_price_group']) !!}

                        <span class="input-group-addon">
                            @show_tooltip(__('lang_v1.types_of_service_help'))
                        </span>
                    </div>
                    <small>
                        <p class="help-block hide" id="price_group_text">@lang('lang_v1.price_group'): <span></span></p>
                    </small>
                </div>
            </div>
            <div class="modal fade types_of_service_modal" tabindex="-1" role="dialog"
                aria-labelledby="gridSystemModalLabel"></div>
        @endif
        {{-- <div class="clearfix"></div> --}}

        @if (!empty($categories))
            <div class="col-md-3"style="">
                <div class="" id="product_category_div">
                    <select class="select2" id="product_category" style="width:100% !important">

                        <option value="all">@lang('lang_v1.all_category')</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach

                        @foreach ($categories as $category)
                            @if (!empty($category['sub_categories']))
                                <optgroup label="{{ $category['name'] }}">
                                    @foreach ($category['sub_categories'] as $sc)
                                        <i class="fa fa-minus"></i>
                                        <option value="{{ $sc['id'] }}">{{ $sc['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        @if (!empty($categorys2))
            <div class="col-md-3"style="">
                <div class="" id="product_categorys2-div">
                    {!! Form::select('category2_id', $categorys2, null, [
                        'id' => 'product_categorys2',
                        'class' => 'select2',
                        'name' => null,
                        'style' => 'width:100% !important',
                    ]) !!}
                </div>
            </div>
        @endif
        @if (!empty($categorys3))
            <div></div>
            <div class="col-md-3"style="">
                <div class="" id="product_categorys3-div">
                    {!! Form::select('category3_id', $categorys3, null, [
                        'id' => 'product_categorys3',
                        'class' => 'select2',
                        'name' => null,
                        'style' => 'width:100% !important',
                    ]) !!}
                </div>
            </div>
        @endif
        @if (!empty($brands))
            <div class="col-md-3"style="">
                <div class="" id="product_brand_div">
                    {!! Form::select('size', $brands, null, [
                        'id' => 'product_brand',
                        'class' => 'select2',
                        'name' => null,
                        'style' => 'width:100% !important',
                    ]) !!}
                </div>
            </div>
        @endif
        @if (!empty($pos_settings['show_filter_variation_template']))
            <div></div>
            <div class="col-md-3"style="">
                {!! Form::select('variation_templates', $variation_templates, null, [
                    'class' => 'form-control select2',
                    'id' => 'variation_templates',
                ]) !!}
            </div>
            <div class="col-md-3"style="padding-top:15px">
                <select name="variation_value_template" id="variation_value_template"
                    class="form-control select2"></select>

            </div>
        @endif
        {{-- </div> --}}

        <div class="col-md-3"style="padding-top:15px">

            <!-- Call restaurant module if defined -->
            @if (in_array('tables', $enabled_modules) || in_array('service_staff', $enabled_modules))
                <div class="clearfix"></div>
                <span id="restaurant_module_span">
                    <div class=""></div>
                </span>
            @endif

        </div>
        <div class="row hide">


            <!-- used in repair : filter for service/product -->
            <div class="col-md-6 hide" id="product_service_div">
                {!! Form::select(
                    'is_enabled_stock',
                    ['' => __('messages.all'), 'product' => __('sale.product'), 'service' => __('lang_v1.service')],
                    null,
                    ['id' => 'is_enabled_stock', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important'],
                ) !!}
            </div>
            {{-- <div class="col-md-3">
                <div class=" @if (empty($featured_products)) hide @endif" id="feature_product_div">
                    <button type="button" class="btn btn-primary btn-flat"
                        id="show_featured_products">@lang('lang_v1.featured_products')</button>
                </div>
            </div> --}}

        </div>


        <!-- include module fields -->
        @if (config('constants.enable_sell_in_diff_currency') == true)
            <div class="col-md-3"style="">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-exchange-alt"></i>
                        </span>
                        {!! Form::text('exchange_rate', config('constants.currency_exchange_rate'), [
                            'class' => 'form-control input-sm input_number',
                            'placeholder' => __('lang_v1.currency_exchange_rate'),
                            'id' => 'exchange_rate',
                        ]) !!}
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($pos_module_data))
            @foreach ($pos_module_data as $key => $value)
                @if (!empty($value['view_path']))
                    @includeIf($value['view_path'], ['view_data' => $value['view_data']])
                @endif
            @endforeach
        @endif
        @if (in_array('subscription', $enabled_modules))
            <div class="col-md-3">
                <label>
                    {!! Form::checkbox('is_recurring', 1, false, ['class' => 'input-icheck', 'id' => 'is_recurring']) !!} @lang('lang_v1.subscribe')?
                </label><button type="button" data-toggle="modal" data-target="#recurringInvoiceModal"
                    class="btn btn-link"><i
                        class="fa fa-external-link-square-alt"></i></button>@show_tooltip(__('lang_v1.recurring_invoice_help'))
            </div>
        @endif
    </div>
</div>
