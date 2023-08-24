@extends('layouts.app')
@php
    $heading = !empty($module_category_data['heading']) ? $module_category_data['heading'] : __('category.categories');
    $navbar = !empty($module_category_data['navbar']) ? $module_category_data['navbar'] : null;
@endphp
@section('title', $heading)

@section('content')
    @if (!empty($navbar))
        @include($navbar)
    @endif
    <!-- Content Header (Page header) -->
    <br>
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                {{ $heading }}
                <small>
                    {{ $module_category_data['sub_heading'] ?? __('category.manage_your_categories') }}
                </small>
                @if (isset($module_category_data['heading_tooltip']))
                    @show_tooltip($module_category_data['heading_tooltip'])
                @endif
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @php
            $cat_code_enabled = isset($module_category_data['enable_taxonomy_code']) && !$module_category_data['enable_taxonomy_code'] ? false : true;
        @endphp
        <input type="hidden" id="category_type" value="{{ request()->get('type') }}">
        @php
            $can_add = true;
            if (
                request()->get('type') == 'product' &&
                !auth()
                    ->user()
                    ->can('category.create')
            ) {
                $can_add = false;
            }
        @endphp
        @component('components.widget', ['class' => 'box-solid', 'can_add' => $can_add])
            @if ($can_add)
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('TaxonomyController@create') }}?type={{ request()->get('type') }}"
                                    data-container=".category_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="category_table">
                    <thead>
                        <tr>
                            <th>
                                @if (!empty($module_category_data['taxonomy_label']))
                                    {{ $module_category_data['taxonomy_label'] }}
                                @else
                                    @lang('category.category')
                                @endif
                            </th>
                            @if ($cat_code_enabled)
                                <th>{{ $module_category_data['taxonomy_code_label'] ?? __('category.code') }}</th>
                            @endif
                            <th>@lang('lang_v1.description')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcomponent

        <div class="modal fade category_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->
@stop
@section('javascript')
    @includeIf('taxonomy.taxonomies_js')
@endsection
