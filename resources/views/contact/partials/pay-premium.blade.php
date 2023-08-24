<div class="modal-dialog" role="document" id="details">
    <div class="modal-content">
        {!! Form::open(['url' => action('TransactionPaymentController@postPayContactDue'), 'method' => 'post', 'id' => 'pay_contact_due_form', 'files' => true ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang( "lang_v1.pay$type" )</h4>
        </div>

        <div class="modal-body">
          
            <div class="row" id="select_client_search">
                @if ($type == 'supp')
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('supplier_id', __('purchase.supplier') . ':*') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            {!! Form::select('contact_id', [], null, ['class' => 'form-control', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'supplier_id']); !!}

                        </div>
                    </div>
                    {{-- <strong>
                        @lang('business.address'):
                    </strong>
                    <div id="supplier_address_div"></div> --}}
                </div>
                @elseif($type == 'cust')
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('contact_id', __('contact.customer') . ':*') !!}

                        <div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							{{-- <input type="hidden" id="default_customer_id" 
							value="{{ $walk_in_customer['id']}}" >
							<input type="hidden" id="default_customer_name" 
							value="{{ $walk_in_customer['name']}}" >
							<input type="hidden" id="default_customer_balance" value="{{ $walk_in_customer['balance'] ?? ''}}" >
							<input type="hidden" id="default_customer_address" value="{{ $walk_in_customer['shipping_address'] ?? ''}}" >
							@if(!empty($walk_in_customer['price_calculation_type']) && $walk_in_customer['price_calculation_type'] == 'selling_price_group')
								<input type="hidden" id="default_selling_price_group" 
							value="{{ $walk_in_customer['selling_price_group_id'] ?? ''}}" >
							@endif --}}
							{!! Form::select('contact_id', 
								[], null, ['class' => 'form-control mousetrap', 'id' => 'customer_id', 'placeholder' => 'Enter Customer name / phone', 'required']); !!}
						</div>
                    </div>
                </div>
                @endif
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        @if ($type == 'cust')
					    <small class="contact_due_text"><strong>@lang('account.customer_due'):</strong> <span></span></small><br>

                        @else

                        <small class="contact_name"><strong>@lang('purchase.supplier'):</strong> <span></span></small><br>
					    <small class="contact_due_text"><strong>@lang('account.customer_due'):</strong> <span></span></small><br>

                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well">
                        @if ($type == 'cust')
                        <small class="contact_first"><strong>@lang('report.total_sell'):</strong> <span></span></small><br>
                        <small class="contact_secound"><strong>@lang('contact.total_paid'):</strong> <span></span></small><br>
                        <small class="contact_third"><strong>@lang('contact.total_sale_due'):</strong> <span></span></small><br>
                        {{-- <small class="contact_fourth"><strong>@lang('account.customer_due'):</strong> <span></span></small><br> --}}
                        @else
                        <small class="contact_first"><strong>@lang('report.total_purchase'):</strong> <span></span></small><br>
                        <small class="contact_secound"><strong>@lang('contact.total_paid'):</strong> <span></span></small><br>
                        <small class="contact_third"><strong>@lang('contact.total_purchase_due'):</strong> <span></span></small><br>
                        {{-- <small class="contact_fourth"><strong>@lang('account.customer_due'):</strong> <span></span></small><br> --}}
                        @endif


                    </div>
                </div>
            </div>




            <div class="row payment_row">
                <div class="col-md-4">
                  <div class="form-group">
                    {!! Form::label("amount" , __('sale.amount') . ':*') !!}
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fas fa-money-bill-alt"></i>
                      </span>
                        {{-- {!! Form::text("contact_amount", ['class' => 'form-control input_number contact_amount' , 'id'='contact_amount', 'required', 'placeholder' => __('sale.amount')]); !!} --}}
                      <input type="text" name= 'amount' class="form-control input_number amount" id = 'amount' placeholder='المبلغ' required>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label("paid_on" , __('lang_v1.paid_on') . ':*') !!}
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </span>
                        {{-- {!! Form::text('paid_on', @format_datetime($payment_line->paid_on), ['class' => 'form-control', 'readonly', 'required']); !!} --}}
                        <input type="date" name='paid_on' class="form-control paid_on" id='paid_on'   value="{{ now()->format('Y-m-d') }}" required>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label("method" , __('purchase.payment_method') . ':*') !!}
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fas fa-money-bill-alt"></i>
                        </span>
                        {!! Form::select("method", $payment_types, $payment_line->method, ['id' => 'method_payment','class' => 'form-control select2 payment_types_dropdown', 'required', 'style' => 'width:100%;']); !!}
                      </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    @include('transaction_payment.payment_type_details')
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" id="payment_document_attach">
                        <div class="form-group" >
                          {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                          {!! Form::file('document', ['accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                          <p class="help-block">
                          @includeIf('components.document_help_text')</p>
                      </div>
                </div>
                <div class="col-md-12" id="note_payment">
                    <div class="form-group">
                      {!! Form::label("note", __('lang_v1.payment_note') . ':') !!}
                      {{-- {!! Form::textarea("note", $payment_line->note, ['class' => 'form-control', 'rows' => 3]); !!} --}}
                      <textarea name="note" id="note" cols="30" rows="10" class="form-control" rows="3"></textarea>
                    </div>
                  </div>

            </div>
            
        </div>

        <div class="modal-footer">
            <button type="submit" class="print-invoice btn btn-success" data-href="{{route('sell.printInvoice', [303])}}"><i class="fa fa-print" aria-hidden="true"></i>@lang( 'messages.save' )</button>
            {{-- <button type="button" class="print-invoice btn btn-primary" onclick="printPaymentsData()"><i class="fa fa-print" aria-hidden="true"></i>@lang( 'messages.print' )</button> --}}
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>
        <div id="printerDiv" style="display:none;"></div>
        <input type="hidden" name="payment_id_print" id="payment_id_print">
        <script>
           
                function printPage()
                    {
                        var div = document.getElementById("printerDiv");
                        var payment_id = $('#amount').val();
                        div.innerHTML = "<iframe src='/public/payments/print-payment/"+payment_id+"' onload='this.contentWindow.print();'></iframe>";
                    }
            //  function getDataPrint()
            //  {
                
            //     // printJS("{{ url('/payments/print-payment/"+payment_id+"/"+business_id+"') }}");
            //     printJS("/public/payments/print-payment/161");
            //  }

             function printPaymentsData()
             {
                 $('div.modal button').hide();
                 $('div.modal select').hide();
                 $('div.modal #payment_document_attach').hide();
                 $('div.modal #note_payment').hide();
                 $('div.modal #select_client_search').hide();
                $('div.modal .input-group-addon').hide();
                $('div.modal #supplier_id').replaceWith("<label id='supplier_id'>"+$('div.modal #supplier_id').val()+"</label>");
                $('div.modal #amount').replaceWith("<label id='amount'>"+$('div.modal #amount').val()+"</label>");
                $('div.modal #paid_on').replaceWith("<label id='paid_on'>"+$('div.modal #paid_on').val()+"</label>");
                $('div.modal #method_payment').replaceWith("<label id='method_payment'>"+$('div.modal #method_payment').val()+"</label>");

                 $('div.modal i').hide();
                //  $('div.modal input').replaceWith("<label>"+$('div.modal input').val()+"</label>");
                //  $('input').replaceWith("<div>"+$('input').val()+"</div>");
                  $('div.modal').printThis();
                //   $('div.modal').modal('toggle');
                //   setTimeout(function(){newWin.close();},10);
                //  
                // $('div.modal button').show();
                //  $('div.modal select').show();
                //  $('div.modal #payment_document_attach').show();
                //  $('div.modal #note_payment').show();
                //  $('div.modal #select_client_search').show();
                //  $('div.modal i').show();
                //  $('div.modal .input-group-addon').show();
                //  $('div.modal label#supplier_id').replaceWith("<input type='text' id='supplier_id' value="+"'"+$('div.modal label#supplier_id').val()+"'"+"/>");
                // $('div.modal label#amount').replaceWith("<input type='text' id='amount' value="+"'"+$('div.modal label#amount').val()+"'"+"></label>");
                // $('div.modal label#paid_on').replaceWith("<input type='text' id='paid_on' value="+"'"+$('div.modal label#paid_on').val()+"'"+"></label>");
                // $('div.modal label#method_payment').replaceWith("<label id='method_payment'>"+$('div.modal label#method_payment').val()+"</label>");

             }

           
            // });
         </script>
        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
@if ($type == 'cust')
<script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
@else
<script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>
@endif


