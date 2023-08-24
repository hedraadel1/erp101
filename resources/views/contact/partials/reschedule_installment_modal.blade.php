 <!-- Modal -->

 <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4>أعادة جدولة الاقساط - {{ $installments[0]['contact']['name'] }}</h4>
             {{-- <h4 class="modal-title">{{ $installments[0]['contact']['name'] }}</h4> --}}
         </div>
         <form action="{{ action('ContactController@rescheduleInstallment') }}" method="post">
             @csrf
             <div class="modal-body">
                 {{-- <div class="col-md-3">
                     <div class="form-group">
                         <label>قيمة القسط</label>
                         <div class="input-group">
                             <span class="input-group-addon">
                                 <i class="fas fa-money-bill-alt"></i>
                             </span>
                             {!! Form::number('pay_term_value', '', ['class' => 'form-control  input_number']) !!}
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group">
                         <div class="multi-input">

                             {!! Form::label('pay_term_number', __('contact.pay_term') . ':') !!} @show_tooltip(__('tooltip.pay_term'))
                             <br />
                             {!! Form::number('installment_pay_term_number', '', [
                                 'class' => 'form-control width-40 pull-left',
                                 'placeholder' => __('contact.pay_term'),
                             ]) !!}

                             {!! Form::select(
                                 'installment_pay_term_type',
                                 [
                                     'weak' => __('lang_v1.weak'),
                                     'months' => __('lang_v1.months'),
                                     'years' => __('lang_v1.years'),
                                 ],
                                 null,
                                 ['class' => 'form-control width-60 pull-left', 'placeholder' => __('messages.please_select')],
                             ) !!}

                         </div>
                     </div>
                 </div>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label>{{ __('sale.interest_rate') }}</label>
                         <div class="input-group">
                             <span class="input-group-addon">
                                 <i class="fas fa-money-bill-alt"></i>
                             </span>
                             {!! Form::text('interest_rate', '', ['class' => 'form-control  input_number']) !!}
                         </div>
                     </div>
                 </div> --}}
                 <div class="row">
                     <div class="col-md-12">
                         <table class="table table-striped">
                             <thead>
                                 <tr class="row-border blue-heading">
                                     <th>#</th>
                                     <th>@lang('lang_v1.customer')</th>
                                     <th>@lang('lang_v1.installment_value')</th>
                                     <th>@lang('lang_v1.installment_date')</th>

                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($installments as $installmet)
                                     <?php
                                     
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

                                         <td>
                                             {{ $loop->iteration }}
                                         </td>
                                         <td>{{ $installmet['contact']['name'] }}</td>
                                         <td>
                                             {{-- {{ @num_format($installmet->installment_value) }} --}}
                                             <input type="number" class="form-control" step="any"
                                                 name="installmet[{{ $installmet->id }}][value]"
                                                 value="{{ $installmet->installment_value }}">
                                         </td>
                                         <td>
                                             {{-- task-5  --}}
                                             {{-- <span
                                                 class="installment_date">{{ $installmet->installment_duo_date }}</span> --}}
                                             {{-- <span class="installment_date">{{ 'test'}}</span> --}}
                                             <input type="date" class="form-control"
                                                 name="installmet[{{ $installmet->id }}][date]"
                                                 class="installment_date"
                                                 value="{{ $installmet->installment_duo_date }}">
                                             <input type="hidden" name="installment_id" value="{{ $installmet->id }}">
                                             <input type="hidden" name="paid" id="paid" value="0">
                                         </td>

                                         <input type="hidden" name="isins" class="isins"
                                             value="{{ $installmet->installment_value }}">
                                         <input type="hidden" name="isid" class="isid"
                                             value="{{ $installmet->id }}">


                                         {{-- installment_modal --}}
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>

                 {{-- <div class="row">
                     <div class="col-sm-12">
                         <div class="pull-right">
                             <strong>@lang('sale.total_installment'):</strong> <span
                                 class="balance_due text-danger">{{ $installments_total }}</span>
                             <input type="hidden" id="balance_due" name='installment_balance_due'
                                 value='{{ $installments_total }}'>
                         </div>
                     </div>
                 </div> --}}
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn btn-primary ">تحديث</button>
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
         </form>
     </div>

 </div>
