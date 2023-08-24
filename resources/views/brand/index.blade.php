@extends('layouts.app')
@section('title', 'Brands')

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                @lang('brand.manage_your_brands')
            </h3>
        </div>

    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('brand.all_your_brands')])
            @can('brand.create')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">
                                <button type="button" class="btn btn-block button-add btn-modal"
                                    data-href="{{ action('BrandController@create') }}" data-container=".brands_modal">
                                    <i class="fa fa-plus"></i> @lang('messages.add')</button>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcan
            @can('brand.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="brands_table">
                        <thead>
                            <tr>
                                <th>@lang('brand.brands')</th>
                                <th>@lang('brand.note')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade brands_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
