 <!-- Modal -->

 <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">{{ $installmet['contact']['name'] }}</h4>
         </div>

         <div class="modal-body">
             <input type="hidden" name="id" class="installmet_id" value="{{ $installmet->id }}">

             <div class="form-group">
                 <input type="date" name="date" class="modal_istallment_date form-control"
                     value="{{ $installmet->installment_duo_date }}">
             </div>
             <div class="form-group">
                 <textarea name="notes" class="form-control" placeholder="ملاحظات" id="notes" cols="30" rows="10">{{ $installmet->notes }}</textarea>
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" data-id="{{ $installmet->id }}" onclick="update_date(this)" class="btn btn-primary "
                 form="form_date">تحديث</button>
             {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
         </div>
     </div>

 </div>
