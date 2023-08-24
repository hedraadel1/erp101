@php
$value = json_decode(getSetting('products'), true);
   if ($value) {
    $setting = array_values($value);
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
                <input type="hidden" name="screen" value="products">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="business_id" value="{{ auth()->user()->business_id }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[1][display]"
                                {{ isset($setting['0']['display']) ? ($setting['0']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="image">
                            {!! Form::label('image', ' اخفاء الصورة') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[2][display]"
                                {{ isset($setting['1']) ? ($setting['1']['display'] == '1' ? 'checked' : '') : '' }}
                                value="1" id="action">
                            {!! Form::label('action', ' اخفاء خيارات') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[3][display]" value="1"
                                {{ isset($setting['2']) ? ($setting['2']['display'] == '1' ? 'checked' : '') : '' }}
                                id="location">
                            {!! Form::label('location', ' اخفاء الاسم') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[4][display]" value="1"
                                {{ isset($setting['3']) ? ($setting['3']['display'] == '1' ? 'checked' : '') : '' }}
                                id="location">
                            {!! Form::label('location', ' اخفاء الفرع') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[5][display]" value="1"
                                {{ isset($setting['4']) ? ($setting['4']['display'] == '1' ? 'checked' : '') : '' }}
                                id="purchase">
                            {!! Form::label('purchase', ' اخفاء سعر الشراء') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[6][display]" value="1"
                                {{ isset($setting['5']) ? ($setting['5']['display'] == '1' ? 'checked' : '') : '' }}id="sell">
                            {!! Form::label('sell', ' اخفاء سعر البيع') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[7][display]" value="1"
                                {{ isset($setting['6']) ? ($setting['6']['display'] == '1' ? 'checked' : '') : '' }}
                                id="stock">
                            {!! Form::label('stock', ' اخفاء الخزون الحالي') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[8][display]" value="1"
                                {{ isset($setting['7']) ? ($setting['7']['display'] == '1' ? 'checked' : '') : '' }}
                                id="type">
                            {!! Form::label('type', ' اخفاء نوع النتج') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[9][display]" value="1"
                                {{ isset($setting['8']) ? ($setting['8']['display'] == '1' ? 'checked' : '') : '' }}
                                id="cat">
                            {!! Form::label('cat', ' اخفاء التصنيف الرئيسي') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[10][display]"value="1"
                                {{ isset($setting['9']) ? ($setting['9']['display'] == '1' ? 'checked' : '') : '' }}
                                id="brand">
                            {!! Form::label('brand', ' اخفاء العلامة التجارية ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[11][display]" value="1"
                                {{ isset($setting['10']) ? ($setting['10']['display'] == '1' ? 'checked' : '') : '' }}
                                id="tax">
                            {!! Form::label('tax', ' اخفاء الضريبة  ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[12][display]" value="1"
                                {{ isset($setting['11']) ? ($setting['11']['display'] == '1' ? 'checked' : '') : '' }}id="barcode">
                            {!! Form::label('barcode', ' اخفاء الباركود  ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[13][display]" value="1"
                                {{ isset($setting['12']) ? ($setting['12']['display'] == '1' ? 'checked' : '') : '' }}
                                id="feild1">
                            {!! Form::label('feild1', ' اخفاء الخانة الاضافية 1  ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[14][display]" value="1"
                                {{ isset($setting['13']) ? ($setting['13']['display'] == '1' ? 'checked' : '') : '' }}id="feild2">
                            {!! Form::label('feild2', ' اخفاء  الخانة الاضافية 2  ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[15][display]" value="1"
                                {{ isset($setting['14']) ? ($setting['14']['display'] == '1' ? 'checked' : '') : '' }}
                                id="feild3">
                            {!! Form::label('feild3', ' اخفاء  الخانة الاضافية 3  ') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" name="data[16][display]" value="1"
                                {{ isset($setting['15']) ? ($setting['14']['display'] == '1' ? 'checked' : '') : '' }}
                                id="feild4">
                            {!! Form::label('feild4', ' اخفاء  الخانة الاضافية 4  ') !!}
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
