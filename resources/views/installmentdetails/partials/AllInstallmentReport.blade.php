<div class="table-responsive">
    <table class="table  table-striped" id="sr_instllment_report" style="width: 100%;">
        <thead>
            <tr class="row-border blue-heading">
                <th>@lang('lang_v1.customer')</th>
                <th>@lang('lang_v1.installment_value')</th>
                <th>@lang('lang_v1.installment_date')</th>
                <th>التليفون 1 </th>
                <th>التليفون 2 </th>
                <th>ملاحظات</th>
                <th>حقل أضافي 1 </th>
                <th>حقل أضافي 2 </th>
                <th>الاجمالى</th>
                <th>@lang('lang_v1.options')</th>
            </tr>
        </thead>
        <tfoot>
            {{-- <tr class="bg-gray font-17 footer-total text-center">
            <td colspan="4"><strong>@lang('sale.total'):</strong></td>
            <td id="sr_footer_payment_status_count"></td>
            <td><span class="display_currency" id="sr_footer_sale_total" data-currency_symbol ="true"></span></td>
            <td><span class="display_currency" id="sr_footer_total_paid" data-currency_symbol ="true"></span></td>
            <td class="text-left"><small>@lang('lang_v1.sell_due') - <span class="display_currency" id="sr_footer_total_remaining" data-currency_symbol ="true"></span><br>@lang('lang_v1.sell_return_due') - <span class="display_currency" id="sr_footer_total_sell_return_due" data-currency_symbol ="true"></span></small></td>
        </tr> --}}
        </tfoot>
    </table>
    <div class="modal fade" id="Modal_" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="date" id="date" name="date" class="modal_istallment_date form-control"
                            value="">
                    </div>
                    <div class="form-group">
                        <textarea name="notes" class="form-control" placeholder="ملاحظات" id="notes" cols="30" rows="10"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="update_istallment"
                        class="btn btn-primary">{{ __('messages.save') }}</button>
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>

        </div>
    </div>

</div>
