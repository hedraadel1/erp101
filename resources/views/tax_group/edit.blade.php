<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('GroupTaxController@update', [$tax_rate->id]),
            'method' => 'PUT',
            'id' => 'tax_group_edit_form',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('tax_rate.edit_tax_group')</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('tax_rate.name') . ':*') !!}
                {!! Form::text('name', $tax_rate->name, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => __('tax_rate.name'),
                ]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('taxes[]', __('tax_rate.sub_taxes') . ':*') !!}
                {!! Form::select('taxes[]', $taxes, $sub_taxes, ['class' => 'form-control select2', 'required', 'multiple']) !!}
            </div>

        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button-29">@lang('messages.update')</button>

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
