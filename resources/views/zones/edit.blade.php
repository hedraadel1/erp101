<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('ZoneController@update', [$zone->id]),
            'method' => 'PUT',
            'id' => 'zone_edit_orm',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('lang_v1.edit_zone')</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Form::label('zone_name', 'أسم المنطقة' . ':*') !!}
                    {!! Form::text('zone_name', $zone->zone_name, [
                        'class' => 'form-control',
                        'required',
                        'placeholder' => 'أسم المنطقة',
                    ]) !!}
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('lang_v1.lat') }} :*</label>
                        <input type="number" step="any" min="0" value="{{ $zone->zone_lat }}" required
                            class="form-control" id="" name="zone_lat">
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('lang_v1.lng') }} :*</label>
                        <input type="number" step="any" min="0" value="{{ $zone->zone_long }}" required
                            class="form-control" id="" name="zone_long">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('max_away', 'النطاق المحدد' . ':*') !!}
                    {!! Form::text('max_away', $zone->max_away, [
                        'class' => 'form-control',
                        'placeholder' => 'النطاق المحدد',
                        'required',
                    ]) !!}
                </div>


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
