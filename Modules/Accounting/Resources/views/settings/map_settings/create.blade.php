@php
    $is_sell = $map_seetings->where('is_sell', '1')->first();
    $is_purchase = $map_seetings->where('is_purchase', '1')->first();
    $is_expenses = $map_seetings->where('is_expenses', '1')->first();
    $is_salaries = $map_seetings->where('is_salaries', '1')->first();
    $is_customer_payments = $map_seetings->where('is_customer_payments', '1')->first();
    $is_supplier_payments = $map_seetings->where('is_supplier_payments', '1')->first();
@endphp

<div class="modal fade" id="createMapSettingModal" tabindex="-1" role="dialog" aria-labelledby="createMapSettingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMapSettingModalLabel">
                    {{ trans('accounting::lang.create') }}
                    {{ trans_choice('accounting::general.map_setting', 2) }} {{ trans('account.account') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('accounting/settings/map_setting/store') }}" method="post">
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
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                            value="{{ old('name') }}">
                    </div>

                    <div class="form-group"
                        style="display: flex;flex-wrap: wrap;justify-content: space-between;align-items: center;">
                        <div class="checkbox" style="width: 50%">

                            <label>
                                <input class="input-icheck" name="is_sell" type="checkbox" value="1">
                                {{ trans('accounting::lang.sell_pos') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">

                            <label>
                                <input class="input-icheck" name="is_sell_paid" type="checkbox" value="1">
                                {{ trans('accounting::lang.sell_pos_paid') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_purchase" type="checkbox" value="1">
                                {{ trans('accounting::lang.purchase') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_purchase_paid" type="checkbox" value="1">
                                {{ trans('accounting::lang.purchase_paid') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_expenses" type="checkbox" value="1">
                                {{ trans('accounting::lang.expenses') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_expenses_paid" type="checkbox" value="1">
                                {{ trans('accounting::lang.expenses_paid') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_expenses_return" type="checkbox" value="1">
                                {{ trans('accounting::lang.expenses_return') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_expenses_return_paid" type="checkbox"
                                    value="1">
                                {{ trans('accounting::lang.expenses_return_paid') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_salaries" type="checkbox" value="1">
                                {{ trans('accounting::lang.salaries') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_salaries_paid" type="checkbox" value="1">
                                {{ trans('accounting::lang.salaries_paid') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_customer_payments" type="checkbox"
                                    value="1">
                                {{ trans('accounting::lang.customer_payments') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_customer_payments_debit" type="checkbox"
                                    value="1">
                                {{ trans('accounting::lang.customer_payments_debit') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_supplier_payments" type="checkbox"
                                    value="1">
                                {{ trans('accounting::lang.supplier_payments') }}
                            </label>
                        </div>
                        <div class="checkbox" style="width: 50%">
                            <label>
                                <input class="input-icheck" name="is_supplier_payments_debit" type="checkbox"
                                    value="1">
                                {{ trans('accounting::lang.supplier_payments_debit') }}
                            </label>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="">النوع</label> :
                        <label>
                            <input class="input-icheck" checked name="type" type="radio" value="credit">
                            {{ trans('accounting::lang.is_credit') }}
                        </label>
                        <label>
                            <input class="input-icheck" name="type" type="radio" value="debit">
                            {{ trans('accounting::lang.is_debit') }}
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>

        </div>
    </div>
</div>
