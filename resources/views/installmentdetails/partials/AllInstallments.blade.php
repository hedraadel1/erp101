<div class="table-responsive">
    {{-- =============================  installment     =============== --}}
                    
    <div class="col-md-12 col-sm-12 @if (!empty($for_pdf)) width-100 @endif" style="width:100%">
        <div class="table-responsive">
            <table class="table table-striped @if (!empty($for_pdf)) table-pdf td-border @endif"
                id="">
                <thead>
                    <tr class="row-border blue-heading">
                        <th>@lang('lang_v1.customer')</th>
                        <th>@lang('lang_v1.installment_value')</th>
                        <th>@lang('lang_v1.installment_date')</th>
                        <th>التليفون 1 </th>
                        <th>التليفون 2 </th>
                        <th>الاجمالى</th>
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
                            $background_color = 'yellow';
                            $text_color = 'black';
                        } elseif ($installmet->status == 1) {
                            $background_color = 'green';
                            $text_color = 'white';
                        } elseif ($installmet->installment_duo_date <= $date && $installmet->status == 0) {
                            $background_color = 'red';
                            $text_color = 'white';
                        }
                        //
                        ?>
                        {{-- background-color:{{ $background_color }}; --}}
                        <tr style="color:{{ $text_color }};background-color:{{ $background_color }};">
                            <form action="{{ route('installment_update') }}" id="contact_installment_pay" method="POST">
                                @csrf
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
    
                                <td>{{ $installmet['contact']['mobile'] }}</td>
                                <td>{{ $installmet['contact']['landline'] }}</td>
                                <td>{{ $installmet->total_installment }}</td>
    
                                <input type="hidden" name="isins" class="isins"
                                    value="{{ $installmet->installment_value }}">
                                <input type="hidden" name="isid" class="isid"
                                       value="{{ $installmet->id }}">
                                <td class="content-center">
                                    @if ($installmet->status != 1)
    
                                    <input type="hidden" name="date"  class="installment_date" value="{{ $installmet->installment_duo_date}}">
                                    <input type="hidden" name="installment_id" value="{{ $installmet->id}}">
                                    <input type="hidden"   name="paid" id="paid" value="0">
                                    <button class="btn pull-right btn-primary">تحصيل</button>
                                    <input type="button" style='margin-left: 10px;' value="تعديل"
                                    class="btn pull-right btn-primary installment_option installment_edite" data-toggle="modal"
                                    data-target="#Modal_{{ $row_count }}">
                                    <input type="hidden" value="{{$row_count}}" id="row_count">
    
                                      {{--   <a href="{{ action('TransactionPaymentController@getPayContactDue', [$installmet->contact_id]) }}?type=sell&isins={{ $installmet->installment_value }}&isid={{ $installmet->id }}"
                                            class="pay_purchase_due btn btn-primary btn-sm pull-right installment_option installment_paid "><i
                                                class="fas fa-money-bill-alt" aria-hidden="true"></i> @lang('lang_v1.pay')</a> --}}
                                {{-- <input type="button" value="@lang('lang_v1.pay')"
                                     class="btn btn-primary installment_option installment_paid">
                                        <button class="btn btn-primary"> @lang('lang_v1.Convert_to_paid')</button>--}}
                               
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
    </div>
    {{-- =======================end installment ======================== --}}
    </div>