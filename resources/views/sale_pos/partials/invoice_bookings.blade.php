@php
    $subtype = '';
@endphp
@if (!empty($transaction_sub_type))
    @php
        $subtype = '?sub_type=' . $transaction_sub_type;
    @endphp
@endif

@if (count($transactions) > 0)
    <table class="table   table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>رقم الفاتورة</th>
                <th>الاجمالي</th>
                <th>خيار</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr class="cursor-pointer"
                    title="Customer: {{ optional($transaction->contact)->name }} 
        @if (!empty($transaction->contact->mobile) && $transaction->contact->is_default == 0) <br/>Mobile: {{ $transaction->contact->mobile }} @endif
      ">
                    <td>
                        {{ $loop->iteration }}.
                    </td>
                    <td>
                        {{ $transaction->invoice_no }} ({{ optional($transaction->contact)->name }})
                        @if (!empty($transaction->table))
                            - {{ $transaction->table->name }}
                        @endif
                    </td>
                    <td class="">
                        {{ $transaction->final_total }}
                    </td>
                    <td>
                        <div style="display: flex;justify-content: space-between">
                            <a href="#" data-href="{{ action('SellController@show', [$transaction->id]) }}"
                                class="btn-modal" data-container=".view_modal">
                                <span class="btn btn-info btn-sm"><i class="fas fa-eye" aria-hidden="true"></i>
                                    {{ __('messages.view') }}</span>
                            </a>

                            <a class="btn btn-success btn-sm"
                                href="{{ action('SellPosController@confirmInvoiceBooking', [$transaction->id]) }}">
                                <i class="fas fa-pen " aria-hidden="true" title="تاكيد الحجز"></i> تاكيد الحجز
                            </a>

                            <a class="btn btn-danger btn-sm"
                                href="{{ action('SellPosController@cancelInvoiceBooking', [$transaction->id]) }}"><i
                                    class="fas fa-undo"></i>
                                الغاء الحجز</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>@lang('sale.no_recent_transactions')</p>
@endif
