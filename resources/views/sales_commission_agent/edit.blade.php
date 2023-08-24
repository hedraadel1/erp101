<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open([
            'url' => action('SalesCommissionAgentController@update', [$user->id]),
            'method' => 'PUT',
            'id' => 'sale_commission_agent_form',
        ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('lang_v1.edit_sales_commission_agent')</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('surname', __('business.prefix') . ':') !!}
                        {!! Form::text('surname', $user->surname, [
                            'class' => 'form-control',
                            'placeholder' => __('business.prefix_placeholder'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::label('first_name', __('business.first_name') . ':*') !!}
                        {!! Form::text('first_name', $user->first_name, [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('business.first_name'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::label('last_name', __('business.last_name') . ':') !!}
                        {!! Form::text('last_name', $user->last_name, [
                            'class' => 'form-control',
                            'placeholder' => __('business.last_name'),
                        ]) !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('email', __('business.email') . ':') !!}
                        {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => __('business.email')]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('contact_no', __('lang_v1.contact_no') . ':') !!}
                        {!! Form::text('contact_no', $user->contact_no, [
                            'class' => 'form-control',
                            'placeholder' => __('lang_v1.contact_no'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('address', __('business.address') . ':') !!}
                        {!! Form::textarea('address', $user->address, [
                            'class' => 'form-control',
                            'placeholder' => __('business.address'),
                            'rows' => 3,
                        ]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('cmmsn_percent', __('lang_v1.cmmsn_percent') . ':') !!}
                        {!! Form::text('cmmsn_percent', @num_format($user->cmmsn_percent), [
                            'class' => 'form-control input_number',
                            'placeholder' => __('lang_v1.cmmsn_percent'),
                            'required',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('cmmsn_percent2', __('lang_v1.cmmsn_percent') . ' 2 :') !!} @show_tooltip(__('lang_v1.commsn_percent_help'))
                        {!! Form::text('cmmsn_percent2', !empty($user->cmmsn_percent2) ? @num_format($user->cmmsn_percent2) : 0, [
                            'class' => 'form-control input_number',
                            'placeholder' => __('lang_v1.cmmsn_percent') . ' 2 ',
                        ]) !!}
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_agent" value="1" {{ $user->isAgent() ? 'checked' : '' }}
                            class="input-icheck " id="is_agent">{{ __('lang_v1.is_agent') }}

                    </label>
                    @show_tooltip(__('lang_v1.is_agent'))

                </div> --}}

            </div>
        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn button-29">@lang('messages.save')</button>

                </div>
                <div class="col-md-6">
                    <button type="button" class="btn button-30" data-dismiss="modal">@lang('messages.close')</button>

                </div>
            </div>
            {{-- <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button> --}}
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
