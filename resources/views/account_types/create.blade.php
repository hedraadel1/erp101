<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('AccountTypeController@store'),
            'method' => 'post',
            'id' => 'account_type_form',
        ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('lang_v1.add_account_type')</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('lang_v1.name') . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang_v1.name')]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('parent_account_type_id', __('lang_v1.parent_account_type') . ':') !!}
                {!! Form::select('parent_account_type_id', $account_types->pluck('name', 'id'), null, [
                    'class' => 'form-control',
                    'placeholder' => __('messages.please_select'),
                ]) !!}
            </div>
        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button-29">@lang('messages.save')</button>

                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-default button-30"
                        data-dismiss="modal">@lang('messages.close')</button>

                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
