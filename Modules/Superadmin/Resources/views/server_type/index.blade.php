@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.server_types'))

@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.server_types') <small>@lang('superadmin::lang.all_server_types')</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('superadmin::layouts.partials.currency')

        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">&nbsp;</h3>
                <div class="box-tools">
                    <a href="{{ action('\Modules\Superadmin\Http\Controllers\ServerTypeController@create') }}"
                        class="btn btn-block btn-primary">
                        <i class="fa fa-plus"></i> @lang('messages.add')</a>
                </div>
            </div>

            <div class="box-body">
                @foreach ($serverTypes as $serverType)
                    <div class="col-md-4">

                        <div class="box box-success hvr-grow-shadow">
                            <div style="background: #000;color:white" class="box-header with-border text-center">
                                <h2 style="color:white" class="box-title">x{{ $serverType->server_name }}</h2>

                                <div class="row">
                                    @if ($serverType->available == 0)
                                        <a href="#!" class="btn btn-box-tool">
                                            <i class="fas fa-lock fa-lg text-warning" data-toggle="tooltip"
                                                title="لا يظهر للعملاء"></i>
                                        </a>
                                    @endif

                                    @if ($serverType->status == 1)
                                        <span class="badge bg-green">
                                            @lang('superadmin::lang.active')
                                        </span>
                                    @else
                                        <span class="badge bg-red">
                                            @lang('superadmin::lang.inactive')
                                        </span>
                                    @endif

                                    <a href="{{ action('\Modules\Superadmin\Http\Controllers\ServerTypeController@edit', [$serverType->id]) }}"
                                        class="btn btn-box-tool" title="edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ action('\Modules\Superadmin\Http\Controllers\ServerTypeController@destroy', [$serverType->id]) }}"
                                        class="btn btn-box-tool link_confirmation" title="delete"><i
                                            class="fa fa-trash"></i>
                                    </a>

                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body text-center">
                                @lang('superadmin::lang.ServerSpeedRate')

                                <div style="color: red">
                                    {{ $serverType->server_speed }}
                                </div>
                                <br />
                                @lang('superadmin::lang.server_cpu')
                                <div style="color: red">
                                    {{ $serverType->server_cpu }}
                                </div>
                                <br />
                                @lang('superadmin::lang.server_ram')
                                <div style="color: red">
                                    {{ $serverType->server_ram }}
                                </div>
                                <br />
                                @lang('superadmin::lang.server_network')
                                <div style="color: red">
                                    {{ $serverType->server_network }}
                                </div>
                                <br />
                                @lang('superadmin::lang.server_pr_limit')
                                <div style="color: red">
                                    {{ $serverType->server_pr_limit }}
                                </div>
                                <br />
                                @lang('superadmin::lang.server_response_time_range')
                                <div style="color: red">
                                    {{ $serverType->server_response_time_range }} <small>
                                        / @lang('superadmin::lang.PerSecond')
                                    </small>
                                </div>
                                <br />



                                <h3 class="text-center">
                                    @if ($serverType->server_price_perday != 0)
                                        <span class="display_currency" data-currency_symbol="true">
                                            {{ $serverType->server_price_perday }}
                                        </span>

                                        <small>
                                            / @lang('superadmin::lang.perday')
                                        </small>
                                    @else
                                        / @lang('superadmin::lang.forfree')
                                    @endif
                                </h3>

                            </div>
                            <!-- /.box-body -->

                            <div style="background: #000;color:white;" class="box-footer text-center">
                                {{ $serverType->server_name }}
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    @if ($loop->iteration % 3 == 0)
                        <div class="clearfix"></div>
                    @endif
                @endforeach

            </div>

        </div>

        <div class="modal fade brands_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
