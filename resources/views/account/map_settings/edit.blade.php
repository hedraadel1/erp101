@php
    $is_sell = $map_seetings->where('is_sell', '1')->first();
    $is_purchase = $map_seetings->where('is_purchase', '1')->first();
    $is_expenses = $map_seetings->where('is_expenses', '1')->first();
    $is_salaries = $map_seetings->where('is_salaries', '1')->first();
    $is_customer_payments = $map_seetings->where('is_customer_payments', '1')->first();
    $is_supplier_payments = $map_seetings->where('is_supplier_payments', '1')->first();
@endphp

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                {{ trans('accounting::lang.create') }}
                {{ trans_choice('accounting::general.map_setting', 2) }} {{ trans('account.account') }}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="{{ action('AccountSettingController@update', $map_setting->id) }}" method="post">
            @csrf
            @method('put')
            <div class="modal-body">

                <div class="form-group">
                    <label for="account_type" class="control-label">{{ trans_choice('accounting::general.account', 1) }}
                    </label>
                    <select name="account_id" class="form-control form select" id="">
                        <option value="" selected disabled hidden>
                            {{ trans_choice('accounting::general.select', 1) }}{{ trans_choice('accounting::general.account', 1) }}
                        </option>
                        @foreach ($chart_of_accounts as $item)
                            <option {{ $map_setting->account_id == $item->id ? 'selected' : '' }}
                                value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">{{ trans('accounting::lang.name') }}</label>
                    <input class="form-control" type="text" name="name" id="name"
                        value="{{ old('name', $map_setting->name) }}">
                </div>
                <div class="form-group">
                    {!! Form::label('location_id', __('business.select_business_location') . ':*') !!} @show_tooltip(__('lang_v1.invoice_layout_for_sale_tooltip'))
                    {!! Form::select('location_id', $business_locations, $map_setting->location_id, [
                        'class' => 'form-control',
                        'required',
                        'placeholder' => __('messages.please_select'),
                    ]) !!}
                </div>

                {{-- <div class="form-group">
                    <div class="form-group">
                        <input class="" {{ $is_sell && $is_sell->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_sell" {{ $map_setting->is_sell ? 'checked' : '' }} type="checkbox" id="sell"
                            value="{{ $map_setting->id ? $map_setting->is_sell : '0' }}"
                            onchange="this.checked? this.value=1 : this.value=0">
                        <label for="sell">
                            {{ trans('accounting::lang.sell_pos') }}
                        </label>
                    </div>
                    <div class="form-group">
                        <input class=""
                            {{ $is_purchase && $is_purchase->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_purchase" onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_purchase ? 'checked' : '' }} type="checkbox" id="is_purchase"
                            value="{{ $map_setting->id ? $map_setting->is_purchase : '0' }}">
                        <label for="is_purchase">
                            {{ trans('accounting::lang.purchase') }}
                        </label>
                    </div>
                    <div class="form-group">
                        <input class=""
                            {{ $is_expenses && $is_expenses->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_expenses" onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_expenses ? 'checked' : '' }} type="checkbox" id="is_expenses"
                            value="{{ $map_setting->id ? $map_setting->is_expenses : '0' }}">
                        <label for="is_expenses">
                            {{ trans('accounting::lang.expenses') }}
                        </label>
                    </div>
                    <div class="form-group">
                        <input class=""
                            {{ $is_salaries && $is_salaries->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_salaries" onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_salaries ? 'checked' : '' }} type="checkbox" id="is_salaries"
                            value="{{ $map_setting->id ? $map_setting->is_salaries : '0' }}">
                        <label for="is_salaries">
                            {{ trans('accounting::lang.salaries') }}
                        </label>
                    </div>
                    <div class="form-group">
                        <input class=""
                            {{ $is_customer_payments && $is_customer_payments->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_customer_payments" onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_customer_payments ? 'checked' : '' }} type="checkbox"
                            id="is_customer_payments"
                            value="{{ $map_setting->id ? $map_setting->is_customer_payments : '0' }}">
                        <label for="is_customer_payments">
                            {{ trans('accounting::lang.customer_payments') }}
                        </label>
                    </div>
                    <div class="form-group">
                        <input class=""
                            {{ $is_supplier_payments && $is_supplier_payments->id != $map_setting->id ? 'disabled' : '' }}
                            name="is_supplier_payments" onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_supplier_payments ? 'checked' : '' }} type="checkbox"
                            id="is_supplier_payments"
                            value="{{ $map_setting->id ? $map_setting->is_supplier_payments : '0' }}">
                        <label for="is_supplier_payments">
                            {{ trans('accounting::lang.supplier_payments') }}
                        </label>
                    </div>

                </div> --}}
                <div class="form-group"
                    style="display: flex;flex-wrap: wrap;justify-content: space-between;align-items: center;">

                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_sell" {{ $map_setting->is_sell ? 'checked' : '' }}
                            type="checkbox" id="sell" value="1"
                            onchange="this.checked? this.value=1 : this.value=0">
                        <label for="sell">
                            {{ trans('accounting::lang.sell_pos') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_sell_paid"
                            {{ $map_setting->is_sell_paid ? 'checked' : '' }} type="checkbox" id="is_sell_paid"
                            value="1" onclick="this.checked? this.value=1 : this.value=0">
                        <label for="is_sell_paid">
                            {{ trans('accounting::lang.sell_pos_paid') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_purchase"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_purchase ? 'checked' : '' }} type="checkbox" id="is_purchase"
                            value="1">
                        <label for="is_purchase">
                            {{ trans('accounting::lang.purchase') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_purchase_paid"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_purchase_paid ? 'checked' : '' }} type="checkbox" id="is_purchase_paid"
                            value="1">
                        <label for="is_purchase_paid">
                            {{ trans('accounting::lang.purchase_paid') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_expenses"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_expenses ? 'checked' : '' }} type="checkbox" id="is_expenses"
                            value="1">
                        <label for="is_expenses">
                            {{ trans('accounting::lang.expenses') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_expenses_paid"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_expenses_paid ? 'checked' : '' }} type="checkbox" id="is_expenses_paid"
                            value="1">
                        <label for="is_expenses_paid">
                            {{ trans('accounting::lang.expenses_paid') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_expenses_return"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_expenses_return ? 'checked' : '' }} type="checkbox"
                            id="is_expenses_return" value="1">
                        <label for="is_expenses_return">
                            {{ trans('accounting::lang.expenses_return') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_expenses_return_paid"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_expenses_return_paid ? 'checked' : '' }} type="checkbox"
                            id="is_expenses_return_paid" value="1">
                        <label for="is_expenses_return_paid">
                            {{ trans('accounting::lang.expenses_return_paid') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_salaries"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_salaries ? 'checked' : '' }} type="checkbox" id="is_salaries"
                            value="1">
                        <label for="is_salaries">
                            {{ trans('accounting::lang.salaries') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_salaries_paid"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_salaries_paid ? 'checked' : '' }} type="checkbox"
                            id="is_salaries_paid" value="1">
                        <label for="is_salaries_paid">
                            {{ trans('accounting::lang.salaries_paid') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_customer_payments"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_customer_payments ? 'checked' : '' }} type="checkbox"
                            id="is_customer_payments" value="1">
                        <label for="is_customer_payments">
                            {{ trans('accounting::lang.customer_payments') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_customer_payments_debit"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_customer_payments_debit ? 'checked' : '' }} type="checkbox"
                            id="is_customer_payments_debit" value="1">
                        <label for="is_customer_payments_debit">
                            {{ trans('accounting::lang.customer_payments_debit') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_supplier_payments"
                            onchange="this.checked? this.value=1 : this.value=0"
                            {{ $map_setting->is_supplier_payments ? 'checked' : '' }} type="checkbox"
                            id="is_supplier_payments" value="1">
                        <label for="is_supplier_payments">
                            {{ trans('accounting::lang.supplier_payments') }}
                        </label>
                    </div>
                    <div class="form-group" style="width: 50%">
                        <input class="input-icheck" name="is_supplier_payments_debit" onclick="check_value(this)"
                            {{ $map_setting->is_supplier_payments_debit ? 'checked' : '' }} type="checkbox"
                            id="is_supplier_payments_debit" value="1">
                        <label for="is_supplier_payments_debit">
                            {{ trans('accounting::lang.supplier_payments_debit') }}
                        </label>
                    </div>


                </div>
                <hr>
                <div class="form-group">
                    <label for="">النوع</label> :
                    <label>
                        <input class="input-icheck" name="type"
                            {{ $map_setting->type == 'credit' ? 'checked' : '' }} type="radio" value="credit">
                        {{ trans('accounting::lang.is_credit') }}
                    </label>
                    <label>
                        <input class="input-icheck" name="type"
                            {{ $map_setting->type == 'debit' ? 'checked' : '' }} type="radio" value="debit">
                        {{ trans('accounting::lang.is_debit') }}
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-secondary button-30"
                            data-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn button-29">{{ __('messages.update') }}</button>
                    </div>
                </div>


            </div>

        </form>

    </div>
</div>
