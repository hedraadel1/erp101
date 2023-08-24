@extends('layouts.app')
@section('title', __('lang_v1.zones'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">
                {{ __('lang_v1.zones') }}
            </h3>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">
        {{-- <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open([
                        'url' => action('ReportController@getStockReport'),
                        'method' => 'get',
                        'id' => 'sales_representative_filter_form',
                    ]) !!}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('agent', __('lang_v1.agents') . ':') !!}
                            <select name="agent" id="agent" class="form-control select2">
                                <option value="" selected disabled hidden> جميع المناديب</option>
                                @foreach ($agents as $item)
                                    <option value="{{ $item->id }}">{{ optional($item->user)->getUserFullNameAttribute() }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('sr_business_id', __('business.business_location') . ':') !!}
                            {!! Form::select('sr_business_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-4" style="padding-top: 35px">
                        <div class="form-group">
                            {!! Form::checkbox('show_contant', 1, null, ['class' => 'input-check ', 'id' => 'show_contant']) !!}
                            {!! Form::label('show_contant', 'عرض العملاء') !!}
                        </div>
                        <div class="form-group" style="display: none">

                            {!! Form::label('sr_date_filter', __('report.date_range') . ':') !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'sr_date_filter',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>


                    {!! Form::close() !!}
                @endcomponent
            </div>

        </div> --}}
        @component('components.widget', ['class' => 'box-primary', 'title' => __('unit.all_your_zones')])
            {{-- @can('unit.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            <button type="button" class="btn btn-block button-add btn-modal"
                                data-href="{{ action('ZoneController@create') }}" data-container=".view_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            {{-- @can('unit.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="all_zone_table" style="width: 100%;">
                    <thead>
                        <tr class="row-border blue-heading">
                            <th>اسم المنطقة</th>
                            <th>نقطة الطول</th>
                            <th>نقطة العرض</th>
                            <th>اقصي بعد</th>

                            <th>@lang('lang_v1.options')</th>
                        </tr>
                    </thead>

                </table>


            </div>
            {{-- @endcan --}}
        @endcomponent

    </section>

    <div class="modal fade zone_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade" id="user_zone_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection

@section('javascript')




@endsection
