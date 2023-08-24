@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.education_learn'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('superadmin::lang.education_learn')</h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('superadmin::lang.education_learn'),
        ])
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#education_category_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes"
                                aria-hidden="true"></i> @lang('superadmin::lang.all_categories')</a>
                    </li>
                    @can('stock_report.view')
                        <li>
                            <a href="#education_video_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-video"
                                    aria-hidden="true"></i> @lang('superadmin::lang.all_videos')</a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="education_category_tab">
                        {{-- @slot('tool') --}}
                        <div class="box-tools" style="padding: 5px">
                            <button type="button" class="btn btn-block btn-primary btn-modal"
                                data-href="{{ action('\Modules\Superadmin\Http\Controllers\EducationCategoryController@create') }}"
                                data-container=".education_category_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                        {{-- @endslot --}}

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="education_categories">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('superadmin::lang.name')</th>
                                        <th>@lang('messages.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="education_video_tab">
                        {{-- @slot('tool') --}}
                        <div class="box-tools" style="padding: 5px">
                            <button type="button" class="btn btn-block btn-primary btn-modal"
                                data-href="{{ action('\Modules\Superadmin\Http\Controllers\EducationVideoController@create') }}"
                                data-container=".education_category_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                        {{-- @endslot --}}

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="education_videos" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('superadmin::lang.name')</th>
                                        <th>@lang('superadmin::lang.category')</th>
                                        <th>@lang('messages.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcomponent


        <div class="modal fade education_category_modal" id="education_category_modal" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel"></div>
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
