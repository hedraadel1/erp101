<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => $resource->id
                ? action('\Modules\Superadmin\Http\Controllers\DepositRequestCodeController@update', $resource->id)
                : action('\Modules\Superadmin\Http\Controllers\DepositRequestCodeController@store'),
            'method' => 'post',
            'id' => 'deposit_requests_code_form',
        ]) !!}
        @if ($resource->id)
            @method('PUT')
        @endif
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                @if ($resource->id)
                    تعديل الكود
                @else
                    أضافة كود
                @endif
            </h4>
        </div>

        <div class="modal-body">

            <div class="form-group">

                {!! Form::label('code', ' الكود') !!} <small class="text-danger">(اترك الحقل فارغًا لإنشاء الكود تلقائيًا)</small>
                {!! Form::text('code', $resource->code, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">

                {!! Form::label('amount', 'قيمة الكود' . ':*') !!}
                {!! Form::number('value', $resource->value, ['class' => 'form-control', 'step' => 0.00001, 'required']) !!}
            </div>



        </div>

        <div class="modal-footer">
            <button class="btn button-29" type="submit">حفظ </button>

            {{-- <button type="submit" class="btn btn-primary">@lang('messages.save')</button> --}}
            {{-- <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button> --}}
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
