<!--Purchase related settings -->
<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('default_credit_limit', __('lang_v1.default_credit_limit') . ':') !!}
                {!! Form::text('common_settings[default_credit_limit]', $common_settings['default_credit_limit'] ?? '', [
                    'class' => 'form-control input_number',
                    'placeholder' => __('lang_v1.default_credit_limit'),
                    'id' => 'default_credit_limit',
                ]) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('common_settings[show_final_balance]', 1, !empty($common_settings['show_final_balance']), [
                            'class' => 'input-icheck',
                            'id' => 'show_final_balance',
                        ]) !!} عرض الرصيد النهائي للعميل
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
