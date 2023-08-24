<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => $automsg->id
                ? action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@update', [$automsg->id])
                : action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@store'),
            'method' => 'post',
            'id' => 'whatsapp_notifications_form',
        ]) !!}
        @if ($automsg->id)
            @method('PUT')
        @endif


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                @if ($automsg->id)
                    @lang('superadmin::lang.edit_message')
                @else
                    @lang('superadmin::lang.add_message')
                @endif
            </h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('msg_time', __('superadmin::lang.msg_time') . ':*') !!}
                {{-- {!! Form::time($name, $value, [$options]) !!} --}}
                {!! Form::time('msg_time', old('msg_time', $automsg->msg_time), ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::select('msg_to', $types, $automsg->msg_to, ['class' => 'form-control select-bs select2']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('msg_details', __('superadmin::lang.contents') . ':*') !!}
                {!! Form::textarea('msg_details', $automsg->msg_details, ['class' => 'form-control ']) !!}
            </div>



        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
    init_tinymce('msg_details');
</script>
