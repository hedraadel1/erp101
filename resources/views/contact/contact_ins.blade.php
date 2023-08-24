@php
    $pos_settings = !empty(session()->get('business.pos_settings')) ? json_decode(session()->get('business.pos_settings'), true) : [];
@endphp
@if (!empty($pos_settings['installment_sales']))
    <div class="col-md-12 col-sm-12 @if (!empty($for_pdf)) width-100 @endif" style="width:100%">

        <form action="{{ route('ledger.instatellment.destroyMulti') }}" method="POST">
            @csrf
            <a data-href="{{ action('ContactController@getInstallment', [$contact->id]) }}" id="reschedule_btn"
                class="btn btn-primary btn-modal" data-container=".payment_modal" role="button">اعدة جدولة</a>
            <span id="btn-delete-all" style="display: none">
                <button class="btn btn-danger" type="submit">حذف الجميع</button>
            </span>
            {{-- <p class="text-center" style="text-align: center;"><strong>@lang('lang_v1.ledger_table_heading', ['start_date' => $ledger_details['start_date'], 'end_date' => $ledger_details['end_date']])</strong></p> --}}
            <div class="table-responsive">
                <table class="table table-striped @if (!empty($for_pdf)) table-pdf td-border @endif"
                    id="ledger_table">
                    <thead>
                        <tr class="row-border blue-heading">
                            <th><input type="checkbox" class="input-icheck" style="color: #e1e1e1!important"
                                    id="CheckAll">
                            </th>
                            <th>@lang('lang_v1.customer')</th>
                            <th>@lang('lang_v1.installment_value')</th>
                            <th>@lang('lang_v1.installment_date')</th>
                            <th>ملاحظات</th>
                            <th class='pull-right'>@lang('lang_v1.options')</th>

                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($ledger_details['ledger'] as $data) --}}
                        <?php
                        $row_count = 0;
                        ?>
                        @foreach ($installmets as $installmet)
                            <?php
                            
                            $row_count++;
                            
                            $date = date('Y-m-d');
                            
                            $background_color = '';
                            
                            $text_color = '';
                            
                            if ($installmet->installment_duo_date > $date && $installmet->status == 0) {
                                $class = 'alert alert-warning';
                            } elseif ($installmet->status == 1) {
                                $class = ' alert alert-success';
                            } elseif ($installmet->installment_duo_date <= $date && $installmet->status == 0) {
                                $class = 'alert alert-danger';
                            }
                            //
                            ?>
                            {{-- background-color:{{ $background_color }}; --}}
                            <tr class="{{ $class }}">
                                <form action="{{ route('installment_update') }}" id="contact_installment_pay"
                                    method="POST">
                                    @csrf
                                    <td>
                                        @if ($installmet->status == 0)
                                            <input type="checkbox"
                                                class="selectedBox input-icheck"name="resource[{{ $installmet->id }}][itemId]"
                                                value="{{ $installmet->id }}">
                                        @endif
                                    </td>
                                    <td>{{ $installmet['contact']['name'] }}</td>
                                    <td>{{ @num_format($installmet->installment_value) }}</td>
                                    <td>
                                        {{-- task-5  --}}
                                        <span class="installment_date">{{ $installmet->installment_duo_date }}</span>
                                        {{-- <span class="installment_date">{{ 'test'}}</span> --}}
                                        <input type="hidden" name="date" class="installment_date"
                                            value="{{ $installmet->installment_duo_date }}">
                                        <input type="hidden" name="installment_id" value="{{ $installmet->id }}">
                                        <input type="hidden" name="paid" id="paid" value="0">
                                    </td>
                                    <td>{{ $installmet->notes }}</td>

                                    <input type="hidden" name="isins" class="isins"
                                        value="{{ $installmet->installment_value }}">
                                    <input type="hidden" name="isid" class="isid" value="{{ $installmet->id }}">
                                    <td class="content-center">
                                        @if ($installmet->status != 1)
                                            <a href="{{ action('TransactionPaymentController@getPayContactDue', [$contact->id]) }}?type=sell&isins={{ $installmet->installment_value }}&isid={{ $installmet->id }}"
                                                class="pay_purchase_due btn btn-primary btn-sm pull-right installment_option installment_paid"><i
                                                    class="fas fa-money-bill-alt" aria-hidden="true"></i>
                                                @lang('lang_v1.pay')</a>
                                            {{-- <input type="button" value="@lang('lang_v1.pay')"
                                 class="btn btn-primary installment_option installment_paid">
                                    <button class="btn btn-primary"> @lang('lang_v1.Convert_to_paid')</button> --}}
                                            <input type="button" style='margin-left: 10px;' value="@lang('lang_v1.edite')"
                                                class="btn pull-right btn-sm btn-primary installment_option installment_edite"
                                                data-toggle="modal" data-target="#Modal_{{ $row_count }}">
                                        @endif
                                    </td>
                                    <input type="hidden" value="{{ $row_count }}" id="row_count">
                                    <div class="modal fade" id="Modal_{{ $row_count }}" role="dialog">
                                        @include('contact.partials.installment_modal')
                                    </div>
                                    {{-- installment_modal --}}
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

    </div>

@endif
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
            // tr.find('span.installment_date').text($(this).val());
            // tr.find('input.installment_date').val($(this).val());



        }

    });

    function update_date(el) {
        var id = $(el).data('id');
        var date = $(el).parent().parent().find('input.modal_istallment_date').val();
        var notes = $(el).parent().parent().find('#notes').val();
        $.ajax({
            url: "{{ url('/installment/update-date') }}",
            type: "post",
            dataType: "json",
            data: {
                'id': id,
                'date': date,
                'notes': notes,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                // alert('Updated');
                window.location.reload();
            }
        });
    }

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
                $('#btn-delete-all').css('display', 'inline');
            }
        } else {
            if ($('.selectedBox').filter(':checked').length > 0) {
                $('#btn-delete-all').css('display', 'inline');
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



    // $('#reschedule_btn').on('click', function() {

    // });
</script>
