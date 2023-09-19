<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('\Modules\Superadmin\Http\Controllers\SerSuperadminSubscriptionsController@store'), 'method' => 'post', 'id' => 'Sersuperadmin_add_subscription' ]) !!}

    {!! Form::hidden('business_id', $business_id); !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'superadmin::lang.add_subscription' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('server_types_id', __( 'superadmin::lang.subscription_packages' ) . ':*') !!}
          {!! Form::select('server_types_id', $servertype, 1, ['class' => 'form-control', 'required', 'placeholder' => __( 'messages.please_select' ) ]); !!}
      </div>
      <div class="form-group">
        {!! Form::label('paid_via', __( 'superadmin::lang.paid_via' ) . ':*') !!}
          {!! Form::select('paid_via', $gateways, "offline", ['class' => 'form-control', 'required', 'placeholder' => __( 'messages.please_select' ) ]); !!}
      </div>
      <div class="form-group">
        {!! Form::label('payment_transaction_id', __( 'superadmin::lang.payment_transaction_id' ) . ':') !!}
          {!! Form::text('payment_transaction_id', 11, ['class' => 'form-control', 'placeholder' => __( 'superadmin::lang.payment_transaction_id' ) ]); !!}
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->