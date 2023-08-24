<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => $menu->id
                ? action('\Modules\Superadmin\Http\Controllers\SettingGoFastController@update', [$menu->id])
                : action('\Modules\Superadmin\Http\Controllers\SettingGoFastController@store'),
            'method' => 'post',
            'id' => 'menu_form',
        ]) !!}
        @if ($menu->id)
            @method('PUT')
        @endif
          

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                @if ($menu->id)
                    @lang('superadmin::lang.edit_menu')
                @else
                    @lang('superadmin::lang.add_menu')
                @endif
            </h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('menu_name', __('superadmin::lang.name') . ':*') !!}
                {!! Form::text('menu_name', old('name', $menu->menu_name), ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('menu_url', __('superadmin::lang.url') . ':*') !!}
                {!! Form::text('menu_url', old('name', $menu->menu_url), ['class' => 'form-control', 'required']) !!}
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
