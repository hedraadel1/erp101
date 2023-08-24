<div class="modal fade" id="deposit_requests_modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {!! Form::open([
                'url' => action('\Modules\Superadmin\Http\Controllers\DepositRequestController@store'),
                'method' => 'post',
                'id' => 'deposit_requests_form',
            ]) !!}
  
            {!! Form::hidden('business_id', session('business.id')) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('superadmin::lang.add_amount')</h4>
            </div>

            <div class="modal-body">

                <div class="form-group">

                    {!! Form::label('amount', __('superadmin::lang.wallet_amount') . ':*') !!}
                    {!! Form::number('amount', null, ['class' => 'form-control', 'step' => 0.00001, 'required']) !!}
                </div>
                <div class="form-group">

                    {!! Form::label('payment_method', __('superadmin::lang.payment_method') . ':*') !!} <br>

                    <select name="payment_method" id="payment_method" class="form-control select2 select-bs"
                        style="width: 100%">
                        <option value="">يرجي التحديد</option>
                        @foreach ($payments as $key => $value)
                            <option value="{{ $value }}">{{ __('superadmin::lang.' . $value) }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <div class="info_deposit hide text-danger">
                        @php
                            $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
                            // dd($admin);
                        @endphp
                        <ul>
                            <li>يرجي اسال التحويل علي هاتف {{ $admin->contact_number }}</li>
                            <li>بعد اتمام عملية التحويل يجب ارسال صورة من التحويل</li>
                            <li>في حالة عدم ارسال الصورة سيظل الطلب قيد الانتظار او بامكان المشرف الغاء الطلب</li>

                        </ul>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn button-29" type="submit">حفظ والاستمرار لرفع الصورة</button>

                {{-- <button type="submit" class="btn btn-primary">@lang('messages.save')</button> --}}
                {{-- <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button> --}}
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
