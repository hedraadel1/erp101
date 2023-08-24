@extends('accounting::settings.layout')
@section('tab-title')
    {{ trans_choice('accounting::general.map_setting', 2) }}
@endsection
@php
    $is_sell = $map_seetings->where('is_sell', '1')->first();
    $is_purchase = $map_seetings->where('is_purchase', '1')->first();
    $is_expenses = $map_seetings->where('is_expenses', '1')->first();
    $is_salaries = $map_seetings->where('is_salaries', '1')->first();
    $is_customer_payments = $map_seetings->where('is_customer_payments', '1')->first();
    $is_supplier_payments = $map_seetings->where('is_supplier_payments', '1')->first();
@endphp
@section('tab-content')
    <!-- Main content -->
    <section class="content no-print" id="vue-app">
        <div class="row">

            @component('accounting::components.box')
                @slot('title')
                    {{ trans_choice('accounting::general.map_setting', 1) }}
                    #{{ $map_setting->id }}
                @endslot

                @slot('body')
                    <!-- Main content -->
                    <section class="content" id="vue-app">
                        <div class="card">

                            <form action="{{ url('accounting/settings/map_setting/' . $map_setting->id . '/update') }}"
                                method="post">
                                @csrf
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="account_type"
                                            class="control-label">{{ trans_choice('accounting::general.account', 1) }}
                                        </label>
                                        <select name="chart_account_id" class="form-control form select" id="">
                                            <option value="" selected disabled hidden>
                                                {{ trans_choice('accounting::general.select', 1) }}{{ trans_choice('accounting::general.account', 1) }}
                                            </option>
                                            @foreach ($chart_of_accounts as $item)
                                                <option {{ $map_setting->chart_account_id == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('chart_account_id')
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

                                    <div class="form-group"
                                        style="display: flex;flex-wrap: wrap;justify-content: space-between;align-items: center;">

                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_sell" {{ $map_setting->is_sell ? 'checked' : '' }}
                                                type="checkbox" id="sell"
                                                value="1"
                                                onchange="this.checked? this.value=1 : this.value=0">
                                            <label for="sell">
                                                {{ trans('accounting::lang.sell_pos') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_sell_paid"
                                                {{ $map_setting->is_sell_paid ? 'checked' : '' }} type="checkbox" id="is_sell_paid"
                                                value="1"
                                                onclick="this.checked? this.value=1 : this.value=0">
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
                                                {{ $map_setting->is_purchase_paid ? 'checked' : '' }} type="checkbox"
                                                id="is_purchase_paid"
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
                                                {{ $map_setting->is_expenses_paid ? 'checked' : '' }} type="checkbox"
                                                id="is_expenses_paid"
                                                value="1">
                                            <label for="is_expenses_paid">
                                                {{ trans('accounting::lang.expenses_paid') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_expenses_return"
                                                onchange="this.checked? this.value=1 : this.value=0"
                                                {{ $map_setting->is_expenses_return ? 'checked' : '' }} type="checkbox"
                                                id="is_expenses_return"
                                                value="1">
                                            <label for="is_expenses_return">
                                                {{ trans('accounting::lang.expenses_return') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_expenses_return_paid"
                                                onchange="this.checked? this.value=1 : this.value=0"
                                                {{ $map_setting->is_expenses_return_paid ? 'checked' : '' }} type="checkbox"
                                                id="is_expenses_return_paid"
                                                value="1">
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
                                                id="is_salaries_paid"
                                                value="1">
                                            <label for="is_salaries_paid">
                                                {{ trans('accounting::lang.salaries_paid') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_customer_payments"
                                                onchange="this.checked? this.value=1 : this.value=0"
                                                {{ $map_setting->is_customer_payments ? 'checked' : '' }} type="checkbox"
                                                id="is_customer_payments"
                                                value="1">
                                            <label for="is_customer_payments">
                                                {{ trans('accounting::lang.customer_payments') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_customer_payments_debit"
                                                onchange="this.checked? this.value=1 : this.value=0"
                                                {{ $map_setting->is_customer_payments_debit ? 'checked' : '' }} type="checkbox"
                                                id="is_customer_payments_debit"
                                                value="1">
                                            <label for="is_customer_payments_debit">
                                                {{ trans('accounting::lang.customer_payments_debit') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_supplier_payments"
                                                onchange="this.checked? this.value=1 : this.value=0"
                                                {{ $map_setting->is_supplier_payments ? 'checked' : '' }} type="checkbox"
                                                id="is_supplier_payments"
                                                value="1">
                                            <label for="is_supplier_payments">
                                                {{ trans('accounting::lang.supplier_payments') }}
                                            </label>
                                        </div>
                                        <div class="form-group" style="width: 50%">
                                            <input class="input-icheck" name="is_supplier_payments_debit"
                                                onclick="check_value(this)"
                                                {{ $map_setting->is_supplier_payments_debit ? 'checked' : '' }} type="checkbox"
                                                id="is_supplier_payments_debit"
                                                value="1">
                                            <label for="is_supplier_payments_debit">
                                                {{ trans('accounting::lang.supplier_payments_debit') }}
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="">النوع</label> :
                                            <label>
                                                <input class="input-icheck" name="type"
                                                    {{ $map_setting->type == 'credit' ? 'checked' : '' }} type="radio"
                                                    value="credit">
                                                {{ trans('accounting::lang.is_credit') }}
                                            </label>
                                            <label>
                                                <input class="input-icheck" name="type"
                                                    {{ $map_setting->type == 'debit' ? 'checked' : '' }} type="radio"
                                                    value="debit">
                                                {{ trans('accounting::lang.is_debit') }}
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>

                            </form>

                        </div>
                    </section>
                @endslot
            @endcomponent
        </div>
    </section>

@endsection

@section('tab-javascript')
    <script>
        function check_value(el) {

            if ($(el).is(":checked")) {
                $(el).val('1');
            } else if ($(el).not(":checked")) {
                $(el).val('0');
            }
        }
    </script>
@endsection
