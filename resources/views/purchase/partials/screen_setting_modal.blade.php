@php
    $value = json_decode(getSetting('purchase_order'), true);
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
                    اخفاء بعض الاعمده من الجدول
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="screentype" name="screen" value="purchase_order">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="business_id" value="{{ auth()->user()->business_id }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[0][display]"
                                {{ isset($setting['0']['display']) ? ($setting['0']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="action">
                            {!! Form::label('action', 'الحذف المتعدد') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[1][display]"
                                {{ isset($setting['1']['display']) ? ($setting['1']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="action">
                            {!! Form::label('action', __('messages.action')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[2][display]"
                                {{ isset($setting['2']['display']) ? ($setting['2']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="date">
                            {!! Form::label('date', __('messages.date')) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[3][display]" value="1"
                                {{ isset($setting['3']['display']) ? ($setting['3']['display'] == '1' ? 'checked' : '') : '' }}
                                id="ref_no">
                            {!! Form::label('ref_no', __('purchase.ref_no')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[4][display]" value="1"
                                {{ isset($setting['4']['display']) ? ($setting['4']['display'] == '1' ? 'checked' : '') : '' }}
                                id="location">
                            {!! Form::label('location', __('purchase.location')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[5][display]" value="1"
                                {{ isset($setting['5']['display']) ? ($setting['5']['display'] == '1' ? 'checked' : '') : '' }}
                                id="supplier">
                            {!! Form::label('supplier', __('purchase.supplier')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[6][display]" value="1"
                                {{ isset($setting['6']['display']) ? ($setting['6']['display'] == '1' ? 'checked' : '') : '' }}
                                id="purchase_status">
                            {!! Form::label('purchase_status', __('purchase.purchase_status')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[7][display]" value="1"
                                {{ isset($setting['7']['display']) ? ($setting['7']['display'] == '1' ? 'checked' : '') : '' }}
                                id="payment_status">
                            {!! Form::label('payment_status', __('purchase.payment_status')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[8][display]" value="1"
                                {{ isset($setting['8']['display']) ? ($setting['8']['display'] == '1' ? 'checked' : '') : '' }}
                                id="grand_total">
                            {!! Form::label('grand_total', __('purchase.grand_total')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[9][display]" value="1"
                                {{ isset($setting['9']['display']) ? ($setting['9']['display'] == '1' ? 'checked' : '') : '' }}
                                id="payment_due">
                            {!! Form::label('payment_due', __('purchase.payment_due')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[10][display]"value="1"
                                {{ isset($setting['10']['display']) ? ($setting['10']['display'] == '1' ? 'checked' : '') : '' }}
                                id="added_by">
                            {!! Form::label('added_by', __('lang_v1.added_by')) !!}
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
