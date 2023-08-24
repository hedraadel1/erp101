<!--Purchase related settings -->
<div class="pos-tab-content">
    <div class="row">
        <div class="col-md-12 mb-5">
            <h3>اعدادات كلمات المرور :- </h3>
            <hr>
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label(
                'enable_password_for_remove_invoice_item',
                __('lang_v1.enable_password_for_remove_invoice_item'),
            ) !!}
            {!! Form::text(
                'password_settings[remove_invoice_pos_item_pass]',
                isset($password_settings['remove_invoice_pos_item_pass'])
                    ? $password_settings['remove_invoice_pos_item_pass']
                    : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        {{-- <div class="col-md-6" style="padding-top:10px">
            {!! Form::label(
                'enable_password_for_remove_invoice_item',
                __('lang_v1.enable_password_for_remove_invoice_sell_item'),
            ) !!}
            {!! Form::text(
                'password_settings[remove_invoice_sell_item_pass]',
                isset($password_settings['remove_invoice_sell_item_pass'])
                    ? $password_settings['remove_invoice_sell_item_pass']
                    : null,
                ['class' => 'form-control'],
            ) !!}
        </div> --}}
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_for_replace', __('lang_v1.enable_password_for_replace')) !!}
            {!! Form::text(
                'password_settings[enable_password_for_replace]',
                isset($password_settings['enable_password_for_replace']) ? $password_settings['enable_password_for_replace'] : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_for_recovery', __('lang_v1.enable_password_for_recovery')) !!}
            {!! Form::text(
                'password_settings[enable_password_for_recovery]',
                isset($password_settings['enable_password_for_recovery'])
                    ? $password_settings['enable_password_for_recovery']
                    : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_for_setting', __('lang_v1.enable_password_for_setting')) !!}
            {!! Form::text(
                'password_settings[enable_password_for_setting]',
                isset($password_settings['enable_password_for_setting']) ? $password_settings['enable_password_for_setting'] : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_for_pay_contant', __('lang_v1.enable_password_for_pay_contant')) !!}
            {!! Form::text(
                'password_settings[enable_password_for_pay_contant]',
                isset($password_settings['enable_password_for_pay_contant'])
                    ? $password_settings['enable_password_for_pay_contant']
                    : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_delete_purchase', __('lang_v1.enable_password_delete_purchase')) !!}
            {!! Form::text(
                'password_settings[enable_password_delete_purchase]',
                isset($password_settings['enable_password_delete_purchase'])
                    ? $password_settings['enable_password_delete_purchase']
                    : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_delete_sell', __('lang_v1.enable_password_delete_sell')) !!}
            {!! Form::text(
                'password_settings[enable_password_delete_sell]',
                isset($password_settings['enable_password_delete_sell']) ? $password_settings['enable_password_delete_sell'] : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="col-md-6" style="padding-top:10px">
            {!! Form::label('enable_password_close_cash', __('lang_v1.enable_password_close_cash')) !!}
            {!! Form::text(
                'password_settings[enable_password_close_cash]',
                isset($password_settings['enable_password_close_cash']) ? $password_settings['enable_password_close_cash'] : null,
                ['class' => 'form-control'],
            ) !!}
        </div>
    </div>
</div>
