<div class="row">
    @if (count($all_locations) > 1)
        <div class="col-md-6 ">
            {!! Form::label('purchase_list_filter_location_id', __('lang_v1.select_location') . ':') !!}
            {!! Form::select('purchase_list_filter_location_id', $all_locations, null, [
                'class' => 'form-control select2',
                'placeholder' => __('lang_v1.select_location'),
            ]) !!}
        </div>
    @endif
    <div class="{{ count($all_locations) > 1 ? 'col-md-6' : 'col-md-12' }}">
        <div class="form-group">
            {!! Form::label('purchase_list_filter_date_range', __('report.date_range') . ':') !!}
            {!! Form::text('purchase_list_filter_date_range', null, [
                'placeholder' => __('lang_v1.select_a_date_range'),
                'class' => 'form-control',
                'readonly',
            ]) !!}
        </div>
    </div>
    <div class="col-sm-12 ">
        <div class="table-responsive">
            <table class="table table-bordered table-striped ajax_view" id="purchase_table_home">
                <thead>
                    <tr>
                        <th>@lang('messages.action')</th>
                        <th>@lang('messages.date')</th>
                        <th>@lang('purchase.ref_no')</th>
                        <th>@lang('purchase.location')</th>
                        <th>@lang('purchase.supplier')</th>
                        <th>@lang('purchase.purchase_status')</th>
                        <th>@lang('purchase.payment_status')</th>
                        <th>@lang('purchase.grand_total')</th>
                        <th>@lang('purchase.payment_due') &nbsp;&nbsp;<i class="fa fa-info-circle text-info no-print"
                                data-toggle="tooltip" data-placement="bottom" data-html="true"
                                data-original-title="{{ __('messages.purchase_due_tooltip') }}" aria-hidden="true"></i>
                        </th>
                        <th>@lang('lang_v1.added_by')</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray font-17 text-center footer-total">
                        <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                        <td class="footer_status_count"></td>
                        <td class="footer_payment_status_count"></td>
                        <td class="footer_purchase_total"></td>
                        <td class="text-left"><small>@lang('report.purchase_due') - <span class="footer_total_due"></span><br>
                                @lang('lang_v1.purchase_return') - <span class="footer_total_purchase_return_due"></span>
                            </small></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
