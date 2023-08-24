@extends('layouts.app')

@section('title', __('crm::lang.lead'))

@section('content')
    @include('crm::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>@lang('crm::lang.leads')</h1>
    </section>

    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('source', __('crm::lang.source') . ':') !!}
                        {!! Form::select('source', $sources, null, [
                            'class' => 'form-control select2',
                            'id' => 'source',
                            'placeholder' => __('messages.all'),
                        ]) !!}
                    </div>
                </div>
                @if ($lead_view != 'kanban')
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('life_stage', __('crm::lang.life_stage') . ':') !!}
                            {!! Form::select('life_stage', $life_stages, null, [
                                'class' => 'form-control select2',
                                'id' => 'life_stage',
                                'placeholder' => __('messages.all'),
                            ]) !!}
                        </div>
                    </div>
                @endif
                @if (count($users) > 0)
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('user_id', /* __('lang_v1.assigned_to') */ 'المسئول' . ':') !!}
                            {!! Form::select('user_id', $users, null, [
                                'class' => 'form-control select2',
                                'id' => 'user_id',
                                'placeholder' => __('messages.all'),
                            ]) !!}
                        </div>
                    </div>
                @endif
            </div>
        @endcomponent
        <button type="button" class="btn btn-sm btn-primary btn-add-lead pull-right m-5"
            data-href="{{ action('\Modules\Crm\Http\Controllers\LeadController@create') }}">
            <i class="fa fa-plus"></i> @lang('messages.add')
        </button>
        @component('components.widget', ['class' => 'box-primary', 'title' => __('crm::lang.all_leads')])
            @slot('tool')
                <div class="box-tools">


                    <div class="btn-group btn-group-toggle pull-right m-5" data-toggle="buttons">
                        <label class="btn btn-info btn-sm active list">
                            <input type="radio" name="lead_view" value="list_view" class="lead_view"
                                data-href="{{ action('\Modules\Crm\Http\Controllers\LeadController@index') . '?lead_view=list_view' }}">
                            @lang('crm::lang.list_view')
                        </label>
                        <label class="btn btn-info btn-sm kanban">
                            <input type="radio" name="lead_view" value="kanban" class="lead_view"
                                data-href="{{ action('\Modules\Crm\Http\Controllers\LeadController@index') . '?lead_view=kanban' }}">
                            @lang('crm::lang.kanban_board')
                        </label>
                    </div>
                </div>
            @endslot
            @if ($lead_view == 'list_view')
                <table class="table table-bordered table-striped" id="leads_table">
                    <thead>
                        <tr>
                            <th> @lang('messages.action')</th>
                            <th>اضافة متابعة</th>
                            <th>@lang('lang_v1.contact_id')</th>
                            <th>@lang('contact.name')</th>
                            <th>@lang('contact.mobile')</th>
                            <th>@lang('business.email')</th>
                            <th>@lang('crm::lang.source')</th>
                            <th style="width: 200px !important">
                                اخر متابعة
                            </th>
                            {{-- <th style="width: 200px !important">
                              @lang('crm::lang.last_follow_up')
                          </th> --}}
                            <th style="width: 200px !important">
                                @lang('crm::lang.last_follow_up')2
                            </th>
                            {{--                        <th style="width: 200px !important">
                                @lang('crm::lang.last_follow_up')3
                            </th> --}}
                            <th style="width: 200px !important">
                                @lang('crm::lang.last_follow_up')3
                            </th>
                            <th style="width: 200px !important">
                                @lang('crm::lang.upcoming_follow_up')
                            </th>
                            <th>@lang('crm::lang.life_stage')</th>
                            <th>@lang('lang_v1.assigned_to')</th>
                            <th>@lang('business.address')</th>
                            <th>@lang('contact.tax_no')</th>
                            <th>@lang('lang_v1.added_on')</th>
                            @php
                                $custom_labels = json_decode(session('business.custom_labels'), true);
                            @endphp
                            <th>
                                {{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_5'] ?? __('lang_v1.custom_field', ['number' => 5]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_6'] ?? __('lang_v1.custom_field', ['number' => 6]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_7'] ?? __('lang_v1.custom_field', ['number' => 7]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_8'] ?? __('lang_v1.custom_field', ['number' => 8]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_9'] ?? __('lang_v1.custom_field', ['number' => 9]) }}
                            </th>
                            <th>
                                {{ $custom_labels['contact']['custom_field_10'] ?? __('lang_v1.custom_field', ['number' => 10]) }}
                            </th>
                        </tr>
                    </thead>
                </table>
            @endif
            @if ($lead_view == 'kanban')
                <div class="lead-kanban-board">
                    <div class="page">
                        <div class="main">
                            <div class="meta-tasks-wrapper">
                                <div id="myKanban" class="meta-tasks">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endcomponent
        <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade schedule" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
    </section>
@endsection
@section('javascript')
    <script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var lead_view = urlSearchParam('lead_view');

            //if lead view is empty, set default to list_view
            if (_.isEmpty(lead_view)) {
                lead_view = 'list_view';
            }

            if (lead_view == 'kanban') {
                $('.kanban').addClass('active');
                $('.list').removeClass('active');
                initializeLeadKanbanBoard();
            } else if (lead_view == 'list_view') {
                if ((typeof leads_datatable == 'undefined')) {

                    leads_datatable = $("#leads_table").DataTable({
                        processing: true,
                        serverSide: true,
                        scrollY: "75vh",
                        scrollX: true,
                        scrollCollapse: true,
                        ajax: {
                            url: "/crm/leads",
                            data: function(d) {
                                d.source = $("#source").val();
                                d.life_stage = $("#life_stage").val();
                                d.user_id = $("#user_id").val();
                                d.lead_view = urlSearchParam('lead_view');
                            }
                        },
                        columnDefs: [{
                            targets: [0, 5, 8, 9],
                            orderable: false,
                            searchable: false,
                        }, ],
                        aaSorting: [
                            [7, 'desc']
                        ],
                        columns: [{
                                data: 'action',
                                name: 'action'
                            },
                            {
                                data: 'new_schedule',
                                name: 'new_schedule'
                            },
                            {
                                data: 'contact_id',
                                name: 'contact_id',
                                visible: false

                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'mobile',
                                name: 'mobile'
                            },
                            {
                                data: 'email',
                                name: 'email',
                                visible: false

                            },
                            {
                                data: 'crm_source',
                                name: 'crm_source',
                                visible: false

                            },
                            {
                                data: 'last_follow_up',
                                name: 'last_follow_up',
                                searchable: false
                            },
                            {
                                data: 'follow_up_2',
                                name: 'follow_up_2',
                                searchable: false
                            },
                            {
                                data: 'follow_up_3',
                                name: 'follow_up_3',
                                searchable: false
                            },
                            {
                                data: 'upcoming_follow_up',
                                name: 'upcoming_follow_up',
                                searchable: false
                            },
                            {
                                data: 'crm_life_stage',
                                name: 'crm_life_stage'
                            },
                            {
                                data: 'leadUsers',
                                name: 'leadUsers'
                            },
                            {
                                data: 'address',
                                name: 'address',
                                orderable: false
                            },
                            {
                                data: 'tax_number',
                                name: 'tax_number'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at'
                            },
                            {
                                data: 'custom_field1',
                                name: 'custom_field1'
                            },
                            {
                                data: 'custom_field2',
                                name: 'custom_field2'
                            },
                            {
                                data: 'custom_field3',
                                name: 'custom_field3'
                            },
                            {
                                data: 'custom_field4',
                                name: 'custom_field4'
                            },
                            {
                                data: 'custom_field5',
                                name: 'custom_field5',
                                visible: false
                            },
                            {
                                data: 'custom_field6',
                                name: 'custom_field6',
                                visible: false
                            },
                            {
                                data: 'custom_field7',
                                name: 'custom_field7',
                                visible: false
                            },
                            {
                                data: 'custom_field8',
                                name: 'custom_field8',
                                visible: false
                            },
                            {
                                data: 'custom_field9',
                                name: 'custom_field9',
                                visible: false
                            },
                            {
                                data: 'custom_field10',
                                name: 'custom_field10',
                                visible: false
                            }
                        ]
                    });


                } else {
                    leads_datatable.ajax.reload();
                }
            }
        });
    </script>
@endsection
