
{{-- task-3 all file--}}
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Modal Header</h4>
	  </div>
	  <div class="modal-body form-inline">
				<div class="row">
					
					<div class="form-group col-xs-6">
						<span> الكميه كلى </span>
           			 {{-- {!! Form::text('purchases[' . 0 . '][test]','hh', ['class' => 'form-control input-sm input_number default_sell_price part_sell_price', 'required','style'=>'width:80%','id'=>"part_sell_price_$row_count"]); !!} --}}
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_total_quantity">
					</div>
					
					<div class="form-group col-xs-6">
						<span>الكميه جزئى</span>
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_part_quantity">
					</div>

					<div class="form-group col-xs-6">
						<span>سعر الوحده كلى</span>
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_total_sell_price">
					</div>
					
					<div class="form-group col-xs-6">
						<span>سعر الوحده جزئى</span>
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_part_sell_price">
					</div>

					<div class="form-group col-xs-6">
						<span>الوزن</span>
						<br>
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_weight">
					</div>
					<div class="form-group col-xs-6">
						<span>نوع الخصم</span>
						<br>
						<input type="text" value="0" 
						class="form-control input-sm pur_quantity input_number mousetrap modal_discount_type">
					</div>

				</div>


				<div class="col-ls-10 mb-3">
					<span>العدد</span>
					<br>
					<input type="text" value="0"  style="width:87%"
					class="form-control input-sm pur_quantity input_number mousetrap modal_count">
				</div>
                {{-- buttons --}}
				<div class="form-row">
					<div class="form-group col-xs-6">
						{{-- <button >Large button</button> --}}
						<button type="button" class="btn btn-secondary btn-md col-xs-6 add_Weight btn_wight" id="btn_wight">اضافه الاوزن</button>	
					</div>

					<div class="form-group col-xs-6">
							<button type="button" class="btn btn-secondary btn-md col-xs-6 add_Weight btn_k_wight" id="btn_k_wight">اضافه ك الاوزان</button>
				    </div>
			    </div>

				
				<div style="width:100%;height:100px;overflow:scroll" class='input_count' id="input_count">
						{{-- append child from js --}}
				</div>
			

			
{{--end body modal --}}
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
</div>
