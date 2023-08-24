<div class="modal  fade" id="confirm_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i>
                    يرجي ادخال كلمة المرور
                </h4>

            </div>
            <div class="modal-body">
                <input type="text" name="password" id="password" autocomplete="off" class="form-control">
                <div id="msgErr" class="text-red"></div>
                <input type="hidden" id="page_type" class="form-control">
                {{-- for get container modal --}}
                <input type="hidden" id="container" class="form-control">
                {{-- for sell & purchase  --}}
                <input type="hidden" id="item_href" class="form-control">
                {{-- for sell  --}}
                <input type="hidden" id="is_suspended" class="form-control">
            </div>
            <div class="modal-footer">
                @if (request()->is('business/settings'))
                    <button type="button" id='confirm_password_' class="  btn btn-primary">تاكيد</button>
                @elseif(request()->is('contacts*') || request()->is('installment/dashboard'))
                    <button type="button" class="confirm_password_contact btn btn-primary">تاكيد</button>
                @elseif(request()->is('pos/create'))
                    <button type="button" class="confirm_password_pos btn btn-primary">تاكيد</button>
                @else
                    <button type="button" class="confirm_password_setting  btn btn-primary">تاكيد</button>
                @endif



            </div>
        </div>
    </div>
</div>
