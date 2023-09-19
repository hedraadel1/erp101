@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.serverType'))

@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.serverType') <small>@lang('superadmin::lang.edit_package')</small></h1>
    </section>


    <!-- Main content -->
    <section class="content">

        {!! Form::open([
            'route' => ['server-types.update', $serverType->id],
            'method' => 'put',
            'id' => 'edit_package_form',
        ]) !!}

        <div class="box box-solid">
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_name', __('lang_v1.server_name') . ':') !!}
                            {!! Form::text('server_name', $serverType->server_name, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_speed', __('superadmin::lang.ServerSpeedRate') . ':') !!}
                            {!! Form::text('server_speed', $serverType->server_speed, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_cpu', __('superadmin::lang.server_cpu') . ':') !!}
                            {!! Form::text('server_cpu', $serverType->server_cpu, ['class' => 'form-control', 'required']) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_ram', __('superadmin::lang.server_ram') . ':') !!}
                            {!! Form::text('server_ram', $serverType->server_ram, [
                                'class' => 'form-control',
                                'required'
                            ]) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_network', __('superadmin::lang.server_network') . ':') !!}
                            {!! Form::text('server_network', $serverType->server_network, [
                                'class' => 'form-control',
                                'required'
                            ]) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_pr_limit', __('superadmin::lang.server_pr_limit') . ':') !!}
                            {!! Form::text('server_pr_limit', $serverType->server_pr_limit, ['class' => 'form-control', 'required']) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_response_time_range', __('superadmin::lang.server_response_time_range') . ':') !!}
                            {!! Form::text('server_response_time_range', $serverType->server_response_time_range, [
                                'class' => 'form-control',
                                'required'
                            ]) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('server_price_perday', __('superadmin::lang.server_price_perday') . ':') !!}
                            {!! Form::text('server_price_perday', $serverType->server_price_perday, [
                                'class' => 'form-control',
                                'required'
                            ]) !!}

                            <span class="help-block">
                                @lang('superadmin::lang.infinite_help')
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                          {!! Form::label('status', __('superadmin::lang.is_active') . ':') !!}
                          {!! Form::checkbox('status', $serverType->status, [
                              'class' => 'form-control',
                              'required'
                          ]) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                          {!! Form::label('available', __('superadmin::lang.is_available') . ':') !!}
                          {!! Form::checkbox('available', $serverType->available, [
                              'class' => 'form-control',
                              'required'
                          ]) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('trial_days	', __('superadmin::lang.trial_days') . ':') !!}
                            {!! Form::number('trial_days', $serverType->trial_days, ['class' => 'form-control', 'required', 'min' => 0]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                  </div>
                    <div class="col-sm-6">
                     
                        </div>
                    </div>
            </div>
        </div>

        {!! Form::close() !!}
    </section>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form#edit_servertype_form').validate();
        });
        $('#enable_custom_link').on('ifChecked', function(event) {
            $("div#custom_link_div").removeClass('hide');
        });
        $('#enable_custom_link').on('ifUnchecked', function(event) {
            $("div#custom_link_div").addClass('hide');
        });
    </script>
@endsection
