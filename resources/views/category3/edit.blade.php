<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('Category3Controller@update', [$category3->id]),
            'method' => 'PUT',
            'id' => 'category3_edit_form',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('category.edit_category') 3</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('category.category_name') . ':*') !!}
                {!! Form::text('name', $category3->name, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => __('category.category_name'),
                ]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', __('lang_v1.description') . ':') !!}
                {!! Form::text('description', $category3->description, [
                    'class' => 'form-control',
                    'placeholder' => __('lang_v1.description'),
                ]) !!}
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
