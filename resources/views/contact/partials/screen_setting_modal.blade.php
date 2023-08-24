@php
    $value = json_decode(getSetting($type), true);
    if ($value) {
        $mapping = [$value];
        $setting = [];
        foreach ($mapping as $key => $value) {
            $setting = $value;
        }
        // dd($setting);
    }
@endphp

<div class="modal fade" id="screen_setting_modal" tabindex="-1" role="dialog">
    {!! Form::open([
        'url' => action('ScreenSettingController@setting'),
        'method' => 'post',
    ]) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    اعدادات رؤية الاعمدة
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="screentype" name="screen" value="{{ $type }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="business_id" value="{{ auth()->user()->business_id }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[0][display]"
                                {{ isset($setting['0']['display']) ? ($setting['0']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="multi-delete">
                            {!! Form::label('multi-delete', ' اخفاء الحذف المتعدد') !!}
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="data[1][display]"
                                {{ isset($setting['1']['display']) ? ($setting['1']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="action">
                            {!! Form::label('action', ' اخفاء خيارات') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[2][display]"
                                {{ isset($setting['2']['display']) ? ($setting['2']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="code">
                            {!! Form::label('code', ' اخفاء كود التصال') !!}
                        </div>
                    </div>
                    @if ($type == 'supplier')
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[3][display]" value="1"
                                    {{ isset($setting['3']['display']) ? ($setting['3']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="location">
                                {!! Form::label('location', ' اخفاء اسم النشاط') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[4][display]" value="1"
                                    {{ isset($setting['4']['display']) ? ($setting['4']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="name">
                                {!! Form::label('name', ' اخفاء الاسم') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[5][display]" value="1"
                                    {{ isset($setting['5']['display']) ? ($setting['5']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="email">
                                {!! Form::label('email', ' اخفاء البريد الاليكتروني') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[6][display]" value="1"
                                    {{ isset($setting['6']['display']) ? ($setting['6']['display'] == '1' ? 'checked' : '') : '' }}id="tax">
                                {!! Form::label('tax', ' اخفاء الرقم الضريبي ') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[7][display]" value="1"
                                    {{ isset($setting['7']['display']) ? ($setting['7']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="pay_term">
                                {!! Form::label('pay_term', __('contact.pay_term')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[8][display]" value="1"
                                    {{ isset($setting['8']['display']) ? ($setting['8']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="opening_balance">
                                {!! Form::label('opening_balance', __('account.opening_balance')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[9][display]" value="1"
                                    {{ isset($setting['9']['display']) ? ($setting['9']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="advance_balance">
                                {!! Form::label('advance_balance', __('lang_v1.advance_balance')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[10][display]"value="1"
                                    {{ isset($setting['10']['display']) ? ($setting['10']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="added_on">
                                {!! Form::label('added_on', __('lang_v1.added_on')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[11][display]" value="1"
                                    {{ isset($setting['11']['display']) ? ($setting['11']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="address">
                                {!! Form::label('address', __('business.address')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[12][display]" value="1"
                                    {{ isset($setting['12']) ? ($setting['12']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="barcode">
                                {!! Form::label('barcode', __('contact.mobile')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[13][display]" value="1"
                                    {{ isset($setting['13']) ? ($setting['13']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="total_purchase_due">
                                {!! Form::label('total_purchase_due', __('contact.total_purchase_due')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[14][display]" value="1"
                                    {{ isset($setting['14']) ? ($setting['14']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="total_purchase_return_due">
                                {!! Form::label('total_purchase_return_due', __('lang_v1.total_purchase_return_due')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[15][display]" value="1"
                                    {{ isset($setting['15']) ? ($setting['15']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field1">
                                {!! Form::label('contact_custom_field1', __('lang_v1.contact_custom_field1')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[16][display]" value="1"
                                    {{ isset($setting['16']) ? ($setting['16']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field2">
                                {!! Form::label('contact_custom_field2', __('lang_v1.contact_custom_field2')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[17][display]" value="1"
                                    {{ isset($setting['17']) ? ($setting['17']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field3">
                                {!! Form::label('contact_custom_field3', __('lang_v1.contact_custom_field3')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[18][display]" value="1"
                                    {{ isset($setting['18']) ? ($setting['18']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field4">
                                {!! Form::label('contact_custom_field4', __('lang_v1.contact_custom_field4')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[19][display]" value="1"
                                    {{ isset($setting['19']) ? ($setting['19']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field5">
                                {!! Form::label('contact_custom_field5', __('lang_v1.custom_field', ['number' => 5])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[20][display]" value="1"
                                    {{ isset($setting['20']) ? ($setting['20']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field6">
                                {!! Form::label('contact_custom_field6', __('lang_v1.custom_field', ['number' => 6])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[21][display]" value="1"
                                    {{ isset($setting['21']) ? ($setting['21']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field7">
                                {!! Form::label('contact_custom_field7', __('lang_v1.custom_field', ['number' => 7])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[22][display]" value="1"
                                    {{ isset($setting['22']) ? ($setting['22']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field8">
                                {!! Form::label('contact_custom_field8', __('lang_v1.custom_field', ['number' => 8])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[23][display]" value="1"
                                    {{ isset($setting['23']) ? ($setting['23']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field9">
                                {!! Form::label('contact_custom_field9', __('lang_v1.custom_field', ['number' => 9])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[24][display]" value="1"
                                    {{ isset($setting['24']) ? ($setting['24']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field10">
                                {!! Form::label('contact_custom_field10', __('lang_v1.custom_field', ['number' => 10])) !!}
                            </div>
                        </div>
                    @endif
                    @if ($type == 'customer')
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[3][display]" value="1"
                                    {{ isset($setting['3']) ? ($setting['3']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="feild3">
                                {!! Form::label('feild3', __('business.business_name')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[4][display]" value="1"
                                    {{ isset($setting['4']) ? ($setting['4']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="namec">
                                {!! Form::label('namec', __('user.name')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[5][display]" value="1"
                                    {{ isset($setting['5']) ? ($setting['5']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="emailc">
                                {!! Form::label('emailc', __('business.email')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[6][display]" value="1"
                                    {{ isset($setting['6']) ? ($setting['6']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="tax_no2">
                                {!! Form::label('tax_no2', __('contact.tax_no')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[7][display]" value="1"
                                    {{ isset($setting['7']) ? ($setting['7']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="credit_limit2">
                                {!! Form::label('credit_limit2', __('lang_v1.credit_limit')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[8][display]" value="1"
                                    {{ isset($setting['8']) ? ($setting['8']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="pay_term2">
                                {!! Form::label('pay_term2', __('contact.pay_term')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[9][display]" value="1"
                                    {{ isset($setting['9']) ? ($setting['9']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="opening_balance2">
                                {!! Form::label('opening_balance2', __('account.opening_balance')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[10][display]" value="1"
                                    {{ isset($setting['10']) ? ($setting['10']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="advance_balance2">
                                {!! Form::label('advance_balance2', __('lang_v1.advance_balance')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[11][display]" value="1"
                                    {{ isset($setting['11']) ? ($setting['11']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="added_on2">
                                {!! Form::label('added_on2', __('lang_v1.added_on')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[12][display]" value="1"
                                    {{ isset($setting['12']) ? ($setting['12']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="customer_group2">
                                {!! Form::label('customer_group2', __('lang_v1.customer_group')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[13][display]" value="1"
                                    {{ isset($setting['13']) ? ($setting['13']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="address2">
                                {!! Form::label('address2', __('business.address')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[14][display]" value="1"
                                    {{ isset($setting['14']) ? ($setting['14']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="mobile12">
                                {!! Form::label('mobile12', __('contact.mobile')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[15][display]" value="1"
                                    {{ isset($setting['15']) ? ($setting['15']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="total_sale_due2">
                                {!! Form::label('total_sale_due2', __('contact.total_sale_due')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[16][display]" value="1"
                                    {{ isset($setting['16']) ? ($setting['16']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="total_sell_return_due2">
                                {!! Form::label('total_sell_return_due2', __('lang_v1.total_sell_return_due')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[17][display]" value="1"
                                    {{ isset($setting['17']) ? ($setting['17']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field1">
                                {!! Form::label('contact_custom_field1', __('lang_v1.contact_custom_field1')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[18][display]" value="1"
                                    {{ isset($setting['18']) ? ($setting['18']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field2">
                                {!! Form::label('contact_custom_field2', __('lang_v1.contact_custom_field2')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[19][display]" value="1"
                                    {{ isset($setting['19']) ? ($setting['19']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field3">
                                {!! Form::label('contact_custom_field3', __('lang_v1.contact_custom_field3')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[20][display]" value="1"
                                    {{ isset($setting['20']) ? ($setting['20']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field4">
                                {!! Form::label('contact_custom_field4', __('lang_v1.contact_custom_field4')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[21][display]" value="1"
                                    {{ isset($setting['21']) ? ($setting['21']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field5">
                                {!! Form::label('contact_custom_field5', __('lang_v1.custom_field', ['number' => 5])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[22][display]" value="1"
                                    {{ isset($setting['22']) ? ($setting['22']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field6">
                                {!! Form::label('contact_custom_field6', __('lang_v1.custom_field', ['number' => 6])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[23][display]" value="1"
                                    {{ isset($setting['23']) ? ($setting['23']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field7">
                                {!! Form::label('contact_custom_field7', __('lang_v1.custom_field', ['number' => 7])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[24][display]" value="1"
                                    {{ isset($setting['24']) ? ($setting['24']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field8">
                                {!! Form::label('contact_custom_field8', __('lang_v1.custom_field', ['number' => 8])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[25][display]" value="1"
                                    {{ isset($setting['25']) ? ($setting['25']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field9">
                                {!! Form::label('contact_custom_field9', __('lang_v1.custom_field', ['number' => 9])) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" name="data[26][display]" value="1"
                                    {{ isset($setting['26']) ? ($setting['26']['display'] == '1' ? 'checked' : '') : '' }}
                                    id="contact_custom_field10">
                                {!! Form::label('contact_custom_field10', __('lang_v1.custom_field', ['number' => 10])) !!}
                            </div>
                        </div>
                    @endif


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
