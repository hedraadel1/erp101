@extends('layouts.app')

@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.server_types'))

@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.server_types') <small>@lang('superadmin::lang.create_new')</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('superadmin::lang.create_new_server_type')</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ action('\Modules\Superadmin\Http\Controllers\ServerTypeController@store') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="server_name">@lang('superadmin::lang.server_name')</label>
                                <input type="text" name="server_name" id="server_name" class="form-control"
                                    placeholder="@lang('superadmin::lang.server_name')">
                            </div>
                            <div class="form-group">
                                <label for="image">@lang('superadmin::lang.server_image')</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="icon">@lang('superadmin::lang.server_icon')</label>
                                <input type="file" name="icon" id="icon" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="server_speed">@lang('superadmin::lang.ServerSpeedRate')</label>
                                <input type="textarea" name="server_speed" id="server_speed" class="form-control"
                                    placeholder="@lang('superadmin::lang.ServerSpeedRate')">
                            </div>
                            <div class="form-group">
                                <label for="server_cpu">@lang('superadmin::lang.server_cpu')</label>
                                <input type="text" name="server_cpu" id="server_cpu" class="form-control"
                                    placeholder="@lang('superadmin::lang.server_cpu')">
                            </div>
                            <div class="form-group">
                                <label for="server_ram">@lang('superadmin::lang.server_ram')</label>
                                <input type="text" name="server_ram" id="server_ram" class="form-control"
                                    placeholder="@lang('superadmin::lang.server_ram')">
                            </div>
                            <div class="form-group">
                                <label for="server_network">@lang('superadmin::lang.server_network')</label>
                                <input type="text" name="server_network" id="server_network" class="form-control"
                                    placeholder="@lang('superadmin::lang.server_network')">
                            </div>
                            <div class="form-group">
                                <label for="server_pr_limit">@lang('superadmin::lang.server_pr_limit')</label>
                                <input type="text" name="server_pr_limit" id="server_pr_limit" class="form-control"
                                    placeholder="@lang('superadmin::lang.server_pr_limit')">
                            </div>
                            <div class="form-group">
                                <label for="server_response_time_range">@lang('superadmin::lang.server_response_time_range')</label>
                                <input type="text" name="server_response_time_range" id="server_response_time_range"
                                    class="form-control" placeholder="@lang('superadmin::lang.server_response_time_range')">
                            </div>
                            <div class="form-group">
                                <label for="server_price_perday">@lang('superadmin::lang.server_price_perday')</label>
                                <input type="text" name="server_price_perday" id="server_price_perday"
                                    class="form-control" placeholder="@lang('superadmin::lang.server_price_perday')">
                            </div>
                            <div class="form-group">
                                <label for="status">@lang('superadmin::lang.is_active')</label>
                                <input type="checkbox" name="status" id="status" value="1">
                            </div>
                            <div class="form-group">
                                <label for="available">@lang('superadmin::lang.is_available')</label>
                                <input type="checkbox" name="available" id="available" value="1">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </section>
@endsection