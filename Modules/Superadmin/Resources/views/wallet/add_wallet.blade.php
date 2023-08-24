<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('\Modules\Superadmin\Http\Controllers\WalletController@store'),
            'method' => 'post',
            'id' => '',
        ]) !!}

        {!! Form::hidden('business_id', $business_id) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('superadmin::lang.add_amount')</h4>
        </div>

        <div class="modal-body">
            @if ($type == 'free')
                <div class="form-group">
                    {!! Form::label('amount', __('superadmin::lang.cash_back') . ':*') !!}
                    {!! Form::number('free_money', null, ['class' => 'form-control', 'step' => 0.00001, 'required']) !!}
                </div>
            @else
                <div class="form-group">

                    {!! Form::label('amount', __('superadmin::lang.wallet_amount') . ':*') !!}
                    {!! Form::number('amount', null, ['class' => 'form-control', 'step' => 0.00001, 'required']) !!}
                </div>
            @endif

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
