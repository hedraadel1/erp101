<!-- app css -->
@if (!empty($for_pdf))
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . $asset_v) }}">
@endif
<div class="col-md-12 col-sm-12 @if (!empty($for_pdf)) width-100 align-right @endif">
    <p class="text-right align-right"><strong>{{ $contact->business->name }}</strong>
        <br>
        @if (!empty($location))
            {!! $location->location_address !!}
        @else
            {!! $contact->business->business_address !!}
        @endif
    </p>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 @if (!empty($for_pdf)) width-50 f-left @endif">
    <p class="blue-heading p-4 width-50">@lang('lang_v1.to'):</p>
    <p><strong>{{ $contact->name }}</strong><br> {!! $contact->contact_address !!} @if (!empty($contact->email))
            <br>@lang('business.email'): {{ $contact->email }}
        @endif
        <br>@lang('contact.mobile'): {{ $contact->mobile }}
        @if (!empty($contact->tax_number))
            <br>@lang('contact.tax_no'): {{ $contact->tax_number }}
        @endif
    </p>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 text-right align-right @if (!empty($for_pdf)) width-50 f-left @endif">
    <h3 class="mb-0 blue-heading p-4">@lang('lang_v1.account_summary')</h3>
    <small>{{ $ledger_details['start_date'] }} @lang('lang_v1.to') {{ $ledger_details['end_date'] }}</small>
    <hr>
    <table
        class="table table-condensed text-left align-left no-border @if (!empty($for_pdf)) table-pdf @endif">
        <tr>
            <td>@lang('lang_v1.opening_balance')</td>
            <td class="align-right">
                @if (isset($ledger_details['ledger']))
                    @if ($ledger_details['ledger'][0]['credit'] != '')
                        @format_currency($ledger_details['beginning_balance'])
                        <small class="text-green"> (رصيد متاح له)</small>
                    @else
                        @format_currency($ledger_details['beginning_balance'])
                        <small class="text-red"> (رصيد مستحق عليه)</small>
                    @endif
                @endif

            </td>
        </tr>
        @if ($contact->type == 'supplier' || $contact->type == 'both')
            <tr>
                <td>@lang('report.total_purchase')</td>
                <td class="align-right">@format_currency($ledger_details['total_purchase'])</td>
            </tr>
        @endif
        @if ($contact->type == 'customer' || $contact->type == 'both')
            <tr>
                <td>@lang('lang_v1.total_invoice')</td>
                <td class="align-right">@format_currency($ledger_details['total_invoice'])</td>
            </tr>
        @endif
        <tr>
            <td>@lang('sale.total_paid')</td>
            <td class="align-right">@format_currency($ledger_details['total_paid'])</td>
        </tr>
        <tr>
            <td>@lang('lang_v1.advance_balance')</td>
            <td class="align-right">@format_currency($contact->balance - $ledger_details['total_reverse_payment'])</td>
        </tr>
        @if ($ledger_details['ledger_discount'] > 0)
            <tr>
                <td>@lang('lang_v1.ledger_discount')</td>
                <td class="align-right">@format_currency($ledger_details['ledger_discount'])</td>
            </tr>
        @endif
        {{-- <tr>
            <td><strong>@lang('lang_v1.balance_due')</strong></td>
            <td class="align-right">@format_currency($ledger_details['balance_due'] - $ledger_details['ledger_discount'])</td>

        </tr> --}}
        @foreach ($ledger_details['ledger'] as $data)
            @if ($loop->last)
                @if ($contact->type = 'customer')
                    <td class="{{ $data['bal'] > 0 ? 'bg-green' : 'bg-red' }}">
                        <strong>@lang('lang_v1.balance_due')</strong>
                    </td>
                    <td class="align-right {{ $data['bal'] > 0 ? 'bg-green' : 'bg-red' }}">
                        {{ $data['balance'] }}
                        <small class="">{{ $data['bal'] > 0 ? '(رصيد متاح له) ' : '(رصيد مستحق عليه)' }}</small>
                    </td>
                @else
                    <td class="{{ $data['bal'] > 0 ? 'bg-red' : 'bg-green' }}"><strong>@lang('lang_v1.balance_due')</strong>
                    </td>
                    <td class="align-right {{ $data['bal'] > 0 ? 'bg-red' : 'bg-green' }}">{{ $data['balance'] }}</td>
                @endif
            @endif
        @endforeach
    </table>
</div>
{{-- task-5 --}}
{{-- ============= contact installment  --}}

{{-- =======================end installment ======================== --}}

<div class="col-md-12 col-sm-12 @if (!empty($for_pdf)) width-100 @endif">
    <p class="text-center" style="text-align: center;"><strong>@lang('lang_v1.ledger_table_heading', ['start_date' => $ledger_details['start_date'], 'end_date' => $ledger_details['end_date']])</strong></p>
    <div class="table-responsive">
        <table class="table table-striped @if (!empty($for_pdf)) table-pdf td-border @endif"
            id="ledger_table">
            <thead>
                <tr class="row-border blue-heading">
                    <th width="18%" class="text-center">@lang('lang_v1.date')</th>
                    <th width="9%" class="text-center">@lang('purchase.ref_no')</th>
                    <th width="8%" class="text-center">@lang('lang_v1.type')</th>
                    <th width="10%" class="text-center">@lang('sale.location')</th>
                    <th width="5%" class="text-center">@lang('sale.payment_status')</th>
                    {{-- <th width="10%" class="text-center">@lang('sale.total')</th> --}}
                    <th width="10%" class="text-center">@lang('account.debit')</th>
                    <th width="10%" class="text-center">@lang('account.creditor')</th>
                    <th width="10%" class="text-center">@lang('lang_v1.balance')</th>
                    <th width="5%" class="text-center">@lang('lang_v1.payment_method')</th>
                    <th width="15%" class="text-center">@lang('report.others')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ledger_details['ledger'] as $data)
                    {{-- {{ dd($ledger_details['ledger']) }} --}}
                    <tr @if (!empty($for_pdf) && $loop->iteration % 2 == 0) class="odd" @endif>
                        <td class="row-border">{{ @format_datetime($data['date']) }}</td>
                        <td>{{ $data['ref_no'] }}</td>
                        <td>{{ $data['type'] }}</td>
                        <td>{{ $data['location'] }}</td>
                        <td>{{ $data['payment_status'] }}</td>
                        {{-- <td class="ws-nowrap align-right">@if ($data['total'] !== '') @format_currency($data['total']) @endif</td> --}}
                        <td class="ws-nowrap align-right">

                            @if ($data['debit'] != '')
                                @format_currency($data['debit'])
                            @endif
                        </td>
                        <td class="ws-nowrap align-right">
                            @if ($data['credit'] != '')
                                @format_currency($data['credit'])
                            @endif
                        </td>
                        <td class="ws-nowrap align-right">{{ $data['balance'] }}</td>
                        <td>{{ $data['payment_method'] }}</td>
                        <td>
                            {!! $data['others'] !!}

                            @if (!empty($is_admin) && !empty($data['transaction_id']) && $data['transaction_type'] == 'ledger_discount')
                                <br>
                                <button type="button" class="btn btn-xs btn-danger delete_ledger_discount"
                                    data-href="{{ action('LedgerDiscountController@destroy', ['id' => $data['transaction_id']]) }}"><i
                                        class="fas fa-trash"></i></button>
                                <button type="button" class="btn btn-xs btn-primary btn-modal"
                                    data-href="{{ action('LedgerDiscountController@edit', ['id' => $data['transaction_id']]) }}"
                                    data-container="#edit_ledger_discount_modal"><i class="fas fa-edit"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    /*
    -task-4
	update installment staus to paid
 */
    $('.installment_option').on('click', function(event) {

        var tr = $(this).parents('tr');
        var row_count = tr.find('#row_count').val();

        if ($(this).hasClass('installment_paid')) {
            // toggle tr background and status value
            if (tr.hasClass('green')) {
                tr.css('background-color', "yellow")
                tr.removeClass('green')
                tr.find('#paid').val(0);
            } else {
                tr.find('#paid').val(1);
                tr.css('background-color', "green")
                tr.addClass('green')
            }

            // update installment pay date 
        } else if ($(this).hasClass('installment_edite')) {
            $(document).on('change', '.contact_modal_istallment_date', function() {
                tr.find('span.installment_date').text($(this).val())
                tr.find('input.installment_date').val($(this).val())
            })
        }

    });

    // ==================== send request =========
    $('#contact_installment_pay').on('submit', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        });
        $.ajax({
            method: 'POST',
            url: "{{ action('HomeController@update_installment') }}",
            data: {},
            cache: false,
            success: function() {
                aler('success')
            },
            error: function() {
                alert('errore')
            }
        }); // end ajax()
    });
    // }
    // =================


    $('#CheckAll').on('click', function() {
        if ($(this).prop('checked') === true) {
            $('.selectedBox').prop('checked', true);
            if ($('.selectedBox').filter(':checked').length > 0) {
                $('#btn-delete-all').css('display', 'block');
            }
        } else {
            if ($('.selectedBox').filter(':checked').length > 0) {
                $('#btn-delete-all').css('display', 'block');
                $('.CheckAll').prop('checked', true);
            }
            $('.selectedBox').prop('checked', false);
            $('#btn-delete-all').css('display', 'none');
        }
    });

    $('.selectedBox').on('click', function() {
        $('#btn-delete-all').css('display', 'block');
        $('.CheckAll').prop('checked', true);
    });
</script>
