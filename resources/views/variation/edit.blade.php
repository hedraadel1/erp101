<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('VariationTemplateController@update', [$variation->id]), 'method' => 'PUT', 'id' => 'variation_edit_form', 'class' => 'form-horizontal' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('lang_v1.edit_variation')</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('name',__('lang_v1.variation_name') . ':*', ['class' => 'col-sm-3 control-label']) !!}

        <div class="col-sm-9">
          {!! Form::text('name', $variation->name, ['class' => 'form-control', 'required', 'placeholder' => __('lang_v1.variation_name')]); !!}
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('lang_v1.add_variation_values'):*</label>
        @foreach( $variation->values as $attr)
          @if( $loop->first )
            <div class="col-sm-7">
              {!! Form::text('edit_variation_values[' . $attr->id . ']', $attr->name, ['class' => 'form-control', 'required']); !!}
            </div>
          @endif
        @endforeach
        <div class="col-sm-2">
          <button type="button" class="btn btn-primary" id="add_variation_values">+</button>
        </div>
      </div>
      <div id="variation_values">
        @foreach( $variation->values as $attr)
          @if( !$loop->first )
            <div class="form-group">
              <div class="col-sm-7 col-sm-offset-3">
                {!! Form::text('edit_variation_values[' . $attr->id . ']', $attr->name, ['class' => 'form-control', 'required']); !!}
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>

    <div class="modal-footer">
      <div class="row">
        <div class="col-md-6">
                <button type="submit" class="btn button-29">@lang('messages.update')</button>

        </div>
        <div class="col-md-6">
                <button type="button" class="btn btn-default button-30" data-dismiss="modal">@lang('messages.close')</button>

        </div>
      </div>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->