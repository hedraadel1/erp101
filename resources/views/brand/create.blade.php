<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('BrandController@store'),
            'method' => 'post',
            'id' => $quick_add ? 'quick_add_brand_form' : 'brand_add_form',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('brand.add_brand')</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('brand.brand_name') . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('brand.brand_name')]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', __('brand.short_description') . ':') !!}
                {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => __('brand.short_description')]) !!}
            </div>

            @if ($is_repair_installed)
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('use_for_repair', 1, false, ['class' => 'input-icheck']) !!}
                        {{ __('repair::lang.use_for_repair') }}
                    </label>
                    @show_tooltip(__('repair::lang.use_for_repair_help_text'))
                </div>
            @endif

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
