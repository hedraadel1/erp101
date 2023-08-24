<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => $category->id
                ? action('\Modules\Superadmin\Http\Controllers\BusinessCategoryController@update', [$category->id])
                : action('\Modules\Superadmin\Http\Controllers\BusinessCategoryController@store'),
            'method' => 'post',
            'id' => 'business_category_form',
        ]) !!}
        @if ($category->id)
            @method('PUT')
        @endif


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                @if ($category->id)
                    @lang('superadmin::lang.edit_category')
                @else
                    @lang('superadmin::lang.add_category')
                @endif
            </h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('superadmin::lang.name') . ':*') !!}
                {!! Form::text('name', old('name', $category->name), ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', __('superadmin::lang.description') . ':*') !!}
                {!! Form::textarea('description', old('name', $category->description), ['class' => 'form-control']) !!}
                {{-- {!! Form::text('name', old('name', $category->name), [, 'required']) !!} --}}
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
