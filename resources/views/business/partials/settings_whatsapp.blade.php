@php
    $sms_service = isset($sms_settings['sms_service']) ? $sms_settings['sms_service'] : 'other';
@endphp
<div class="pos-tab-content">
    <div class="row">
        <div class="col-xs-12" style="padding-bottom:10px ">
            <b class="h4">اعدادات اشعار الواتس اب : </b>
            <br>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('setting_appkey', 'اعدادات AppKey' . ':') !!}
                {!! Form::text('setting_appkey', !empty($business->setting_appkey) ? $business->setting_appkey : null, [
                    'class' => 'form-control',
                    'placeholder' => 'اعدادات AppKey',
                    'id' => 'setting_app_key',
                ]) !!}
            </div>

        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('setting_authkey', 'اعدادات  AuthKey' . ':') !!}
                {!! Form::text('setting_authkey', !empty($business->setting_authkey) ? $business->setting_authkey : null, [
                    'class' => 'form-control',
                    'placeholder' => 'اعدادات  AuthKey',
                    'id' => 'setting_app_key',
                ]) !!}
            </div>

        </div>
    </div>
    <hr>
    @php
        $auto_sells = $whastapp_setting['auto_action_msgs']->where('action_name', 'selles')->first();
        $auto_purchase = $whastapp_setting['auto_action_msgs']->where('action_name', 'purchase')->first();
        $auto_products = $whastapp_setting['auto_action_msgs']->where('action_name', 'products')->first();
        $auto_expenses = $whastapp_setting['auto_action_msgs']->where('action_name', 'expenses')->first();
    @endphp
    <div class="row">
        <div class="col-md-6">
            {!! Form::checkbox('auto_action[selles]', 1, isset($auto_sells) ? $auto_sells->action_value : null, [
                'class' => 'input-icheck',
                'id' => 'selles',
            ]) !!}
            {!! Form::label('selles', ' ارسال رسالة اّلية بعد كل عملية مبيعات') !!}
        </div>
        <div class="col-md-6">
            {!! Form::checkbox('auto_action[purchase]', 1, isset($auto_purchase) ? $auto_purchase->action_value : null, [
                'class' => 'input-icheck',
                'id' => 'purchase',
            ]) !!}
            {!! Form::label('purchase', ' ارسال رسالة اّلية بعد كل عملية شراء') !!}
        </div>
        <div class="col-md-6">
            {!! Form::checkbox('auto_action[expenses]', 1, isset($auto_expenses) ? $auto_expenses->action_value : null, [
                'class' => 'input-icheck',
                'id' => 'expenses',
            ]) !!}
            {!! Form::label('expenses', ' ارسال رسالة اّلية بعد كل عملية مصروف') !!}
        </div>
        <div class="col-md-6">
            {!! Form::checkbox('auto_action[products]', 1, isset($auto_products) ? $auto_products->action_value : null, [
                'class' => 'input-icheck',
                'id' => 'products',
            ]) !!}
            {!! Form::label('products', ' ارسال رسالة اّلية بأجمالى الاصناف المنتهيه') !!}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="table-resposive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('lang_v1.action_name') }}</th>
                            <th>{{ __('lang_v1.action_time') }}</th>
                            <th>{{ __('lang_v1.action_duration') }}</th>
                            <th>{{ __('lang_v1.action_day') }}</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($whastapp_setting['actions'] as $key => $action)
                            @php
                                $action_item = $whastapp_setting['all_action']->where('action_name', $action)->first() ?? new App\StaticsMsg();
                            @endphp
                            <tr>
                                <td> {{ __('lang_v1.' . $action) }}</td>
                                <td>
                                    <input class="form-control" type="time" value="{{ $action_item->action_time }}"
                                        name="whatsapp_setting[{{ $action }}][action_time]">
                                </td>
                                <td>
                                    <select class="form-control select-bs"
                                        onchange="toggle_hide_td_day(this , '{{ $loop->iteration }}')"
                                        name="whatsapp_setting[{{ $action }}][action_duration]"
                                        id="action_duration">

                                        @foreach ($whastapp_setting['type'] as $key => $type)
                                            <option {{ $action_item->action_duration == $type ? 'selected' : '' }}
                                                value="{{ $type }}"> {{ __('lang_v1.' . $type) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select-bs"
                                        name="whatsapp_setting[{{ $action }}][action_day]"
                                        {{ $action_item->action_day ? '' : 'disabled' }}
                                        id="action_day-{{ $loop->iteration }}">
                                        <option value="">غير محدد</option>
                                        @foreach ($whastapp_setting['days'] as $key => $day)
                                            <option {{ $action_item->action_day == $day ? 'selected' : '' }}
                                                value="{{ $day }}"> {{ __('lang_v1.' . $day) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
