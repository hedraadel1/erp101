<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" {{ !empty($dashboard_settings['enable_sell_table']) ? 'checked' : '' }}
                            name="dashboard_settings[enable_sell_table]" value="1" class="input-icheck"
                            id="enable_sell_table">{{ __('lang_v1.enable_sell_table') }}

                    </label>
                    @show_tooltip(__('lang_v1.enable_sell_table'))

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                            {{ !empty($dashboard_settings['enable_purchase_table']) ? 'checked' : '' }}
                            name="dashboard_settings[enable_purchase_table]" value="1" class="input-icheck"
                            id="enable_purchase_table">{{ __('lang_v1.enable_purchase_table') }}

                    </label>
                    @show_tooltip(__('lang_v1.enable_purchase_table'))

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                            {{ !empty($dashboard_settings['enable_expense_table']) ? 'checked' : '' }}
                            name="dashboard_settings[enable_expense_table]" value="1" class="input-icheck"
                            id="enable_expense_table">{{ __('lang_v1.enable_expense_table') }}

                    </label>
                    @show_tooltip(__('lang_v1.enable_expense_table'))

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" {{ !empty($dashboard_settings['enable_brand_store']) ? 'checked' : '' }}
                            name="dashboard_settings[enable_brand_store]" value="1" class="input-icheck"
                            id="enable_brand_store">{{ __('lang_v1.enable_brand_store') }}

                    </label>
                    @show_tooltip(__('lang_v1.enable_brand_store'))

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('stock_expiry_alert_days', __('business.view_stock_expiry_alert_for') . ':*') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fas fa-calendar-times"></i>
                    </span>
                    {!! Form::number('stock_expiry_alert_days', $business->stock_expiry_alert_days, [
                        'class' => 'form-control',
                        'required',
                    ]) !!}
                    <span class="input-group-addon">
                        @lang('business.days')
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
