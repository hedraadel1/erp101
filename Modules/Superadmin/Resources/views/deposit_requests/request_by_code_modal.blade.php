<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('\Modules\Superadmin\Http\Controllers\DepositRequestController@requestPassCode'),
            'method' => 'post',
            // 'id' => 'deposit_requests_form',
            'enctype' => 'multipart/form-data',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                شحن عن طريق الاكواد
            </h4>
        </div>

        <div class="modal-body">

            <div class="form-group">

                @if (count($codes))
                    {!! Form::label('code', __('superadmin::lang.code') . ':*') !!}
                    {!! Form::select('code', $codes, null, [
                        'class' => 'form-control select-bs',
                        'style' => 'width:100%',
                        'id' => 'request_code',
                        'placeholder' => 'يرجي التحديد',
                    ]) !!}
                @else
                    <div class="alert alert-warning text-center">لا تتوفر اكواد حاليا</div>
                @endif
            </div>



        </div>
        @if (count($codes))
        <div class="modal-footer">
            <button class="btn button-29 code_value" type="submit">شحن </button>
        </div>
@endif
        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
