<div class="row">
    @if (count($all_locations) > 1)
        <div class="col-md-6 ">
            {!! Form::label('location_id', __('lang_v1.select_location') . ':') !!}
            {!! Form::select('location_id', $all_locations, null, [
                'class' => 'form-control select2',
                'placeholder' => __('lang_v1.select_location'),
            ]) !!}
        </div>
    @endif
    <div class="{{ count($all_locations) > 1 ? 'col-md-6' : 'col-md-12' }}">
        <div class="form-group">
            {!! Form::label('expense_date_range', __('report.date_range') . ':') !!}
            {!! Form::text('date_range', null, [
                'placeholder' => __('lang_v1.select_a_date_range'),
                'class' => 'form-control',
                'id' => 'expense_date_range',
                'readonly',
            ]) !!}
        </div>
    </div>
    <div class="col-sm-12 ">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="expense_home">
                <thead>
                    <tr>
                        <th>@lang('messages.action')</th>
                        <th>@lang('messages.date')</th>
                        <th>@lang('purchase.ref_no')</th>
                        <th>@lang('lang_v1.recur_details')</th>
                        <th>@lang('expense.expense_category')</th>
                        <th>@lang('product.sub_category')</th>
                        <th>@lang('business.location')</th>
                        <th>@lang('sale.payment_status')</th>
                        <th>@lang('product.tax')</th>
                        <th>@lang('sale.total_amount')</th>
                        <th>@lang('purchase.payment_due')
                        <th>@lang('expense.expense_for')</th>
                        <th>@lang('contact.contact')</th>
                        <th>@lang('expense.expense_note')</th>
                        <th>@lang('lang_v1.added_by')</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray font-17 text-center footer-total">
                        <td colspan="7"><strong>@lang('sale.total'):</strong></td>
                        <td class="footer_payment_status_count"></td>
                        <td></td>
                        <td class="footer_expense_total"></td>
                        <td class="footer_total_due"></td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
