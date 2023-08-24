<div class="modal-dialog " role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action('ManageUserController@store'), 'method' => 'post']) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('user.add_user')</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        {!! Form::label('first_name', __('business.first_name') . ':*') !!}
                        {!! Form::text('first_name', null, [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('business.first_name'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="checkbox">
                            <label style="display: none">
                                {!! Form::checkbox('is_active', 'active', true, ['class' => 'input-icheck status ', 'style' => 'display:none']) !!} {{ __('lang_v1.status_for_user') }}

                            </label>
                            <label>

                                {!! Form::checkbox('allow_login', 1, true, ['class' => 'input-icheck', 'id' => 'allow_login']) !!} {{ __('lang_v1.allow_login') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('username', __('business.username') . ':') !!}
                        @if (!empty($username_ext))
                            <div class="input-group">
                                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('business.username')]) !!}
                                <span class="input-group-addon">{{ $username_ext }}</span>
                            </div>
                            <p class="help-block" id="show_username"></p>
                        @else
                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('business.username')]) !!}
                        @endif
                        <p class="help-block">@lang('lang_v1.username_help')</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('password', __('business.password') . ':*') !!}
                        {!! Form::password('password', [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('business.password'),
                        ]) !!}
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('confirm_password', __('business.confirm_password') . ':*') !!}
                        {!! Form::password('confirm_password', [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('business.confirm_password'),
                        ]) !!}
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('role', __('user.role') . ':*') !!} @show_tooltip(__('lang_v1.admin_role_location_permission_help'))
                        {!! Form::select('role', $roles, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <h4>@lang('role.access_locations') @show_tooltip(__('tooltip.access_locations_permission'))</h4>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('access_all_locations', 'access_all_locations', true, ['class' => 'input-icheck']) !!} {{ __('role.all_locations') }}
                            </label>
                            @show_tooltip(__('tooltip.all_location_permission'))
                        </div>
                    </div>
                    @foreach ($locations as $location)
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('location_permissions[]', 'location.' . $location->id, false, ['class' => 'input-icheck']) !!} {{ $location->name }} @if (!empty($location->location_id))
                                        ({{ $location->location_id }})
                                    @endif
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button style="width:100%" type="submit" class="button-29">@lang('messages.save')</button>
            {{-- <button type="button"class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button> --}}
        </div>
        {!! Form::close() !!}

    </div>




</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
