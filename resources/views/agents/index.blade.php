@extends('layouts.app')
@section('title', __('lang_v1.traking_agent'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.traking_agent')
            </h3>
        </div>
    </section>
    {{-- <section class="content-header">
        <h1>{{ __('lang_v1.traking_agent') }}</h1>
    </section> --}}

    <!-- Main content -->
    <section class="content">
        <div class="row">
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

            <div class="col-md-12">
                @include('agents.contact_map')
            </div>
        </div>

        <div class="row nav-tabs-custom">

            <div class="col-md-12 ">
                <div class=" ">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="all_agent_table" style="width: 100%;">
                            <thead>
                                <tr class="row-border blue-heading">
                                    <th>اسم المندوب</th>
                                    <th>الفرع</th>

                                    <th>@lang('lang_v1.options')</th>
                                </tr>
                            </thead>

                        </table>
                        <div class="modal fade" id="Modal_" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="date" id="date" name="date" class="modal_istallment_date"
                                            value="">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="errands_table" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script></script>


    {{-- @if (!empty($api_key)) --}}
    <script type="text/javascript">
        $(document).ready(function() {
            initMap();
        });
        var map;

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {
                    lat: 29.150009,
                    lng: 29.197109
                }
            });

            // setMarkers(map);
            setAgents(map);
        }



        function setAgents(map) {

            var agents = [
                @foreach ($agents as $agent)
                    @foreach ($agent->agentDetails()->get() as $item)
                        @if ($loop->last)
                            [
                                "{{ optional($agent->user)->getUserFullNameAttribute() }} \n ({{ $agent->id }}) ",
                                {{ $item->latitude }},
                                {{ $item->longitude }}
                            ],
                        @endif
                    @endforeach
                @endforeach
            ];

            for (var i = 0; i < agents.length; i++) {
                var agent = agents[i];
                var marker = new google.maps.Marker({
                    position: {
                        lat: agent[1],
                        lng: agent[2]
                    },
                    map: map,
                    title: agent[0]
                });
            }
        };
    </script>
    {{-- @endif --}}

    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4ow5PXyqH-gJwe2rzihxG71prgt4NRFQ&amp;libraries=places&amp;callback=initMap&language=ar&region=EG"
        async="" defer=""></script> --}}
@endsection
