@extends('layouts.app')
@section('title', ' تفاصيل المندوب')

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">
                تفاصيل المندوب
            </h3>
        </div>
    </section>


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

                            {!! Form::label('sr_date_filter', __('report.date_range') . ':') !!}
                            {{-- <input type="text" class="form-controller" name="datetimes" /> --}}

                            {!! Form::text('sr_date_filter', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'sr_date_filter',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            {!! Form::label('is_moving', __('lang_v1.is_moving') . ':') !!}
                            {!! Form::select('is_moving', ['no' => 'عدم حركه', '1' => 'متحرك'], null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'جميع الحالات',
                            ]) !!}

                        </div>
                    </div>


                    {!! Form::close() !!}
                @endcomponent
                <div class="col-md-12">
                    @include('agents.contact_map')
                </div>
            </div>


        </div>

        <div class="row nav-tabs-custom">
            <input type="hidden" id="resource_id" value="{{ $resource->id }}">
            <div class="col-md-12 ">
                <div class=" ">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="details_agent_table" style="width: 100%;">
                            <thead>
                                <tr class="row-border blue-heading">
                                    <th>اسم المندوب</th>
                                    <th>التاريخ</th>
                                    <th>نسبة البطاريه</th>
                                    <th>حالة الهاتف</th>
                                    <th> عدم حركة</th>

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


@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        $('select[name="is_moving"]').on('change', function() {
            var url = "/agents/showdetails/" + $('#resource_id').val();
            var data = {
                is_moving: $(this).val(),
            };
            console.log(data);
            details_agent_table.ajax.url(url + "?" + $.param(data)).load();
        });
    </script>

    <script>
        $(document).ready(function() {
            initMap();
        });
        var map;

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {
                    lat: {{ isset(request()->lat) ? request()->lat : $last_latitude }},
                    lng: {{ isset(request()->lng) ? request()->lng : $last_longitude }}
                }
            });

            // setMarkers(map);
            setAgent(map);
        }
        var request = false;
        @if (isset(request()->lat))
            request = true;
        @endif
        if (request == true) {
            function setAgent(map) {

                var agent = [
                    @foreach ($resource->agentDetails()->get() as $item)
                        @if ($loop->last)
                            [
                                "{{ optional($resource->user)->getUserFullNameAttribute() }} \n ({{ $resource->id }}) ",
                                {{ request()->lat }},
                                {{ request()->lng }}
                            ],
                        @endif
                    @endforeach
                ];

                for (var i = 0; i < agent.length; i++) {
                    var agent = agent[i];
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
        } else {
            function setAgent(map) {

                var agent = [
                    @foreach ($resource->agentDetails()->get() as $item)
                        @if ($loop->last)
                            [
                                "{{ optional($resource->user)->getUserFullNameAttribute() }} \n ({{ $resource->id }}) ",
                                {{ $item->latitude }},
                                {{ $item->longitude }}
                            ],
                        @endif
                    @endforeach
                ];

                for (var i = 0; i < agent.length; i++) {
                    var agent = agent[i];
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
        }
    </script>


@endsection
