<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('\Modules\Superadmin\Http\Controllers\DepositRequestController@update', $resource->id),
            'method' => 'post',
            // 'id' => 'deposit_requests_form',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">تحميل صورة الايداع</h4>
        </div>

        <div class="modal-body">

            <div class="form-group">

                {!! Form::label('image', __('superadmin::lang.image') . ':*') !!}
                {!! Form::file('image', ['class' => 'form-control']) !!}
            </div>



        </div>

        <div class="modal-footer">
            <button class="btn button-29" type="submit">تحميل</button>
          </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
