@extends('layouts.app')
@section('title', __('lang_v1.sales_commission_agents'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.sales_commission_agents')
            </h3>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            @can('user.create')
                @slot('tool')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools">

                                <button style="width:100%" type="button" class="button-add  btn-modal"
                                    data-href="{{ action('SalesCommissionAgentController@create') }}"
                                    data-container=".commission_agent_modal"><i class="fa fa-plus maricon "></i>
                                    @lang('messages.add')</button>
                            </div>

                        </div>

                    </div>
                @endslot
            @endcan
            @can('user.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="sales_commission_agent_table">
                        <thead>
                            <tr>
                                <th>@lang('user.name')</th>
                                <th>@lang('business.email')</th>
                                <th>@lang('lang_v1.contact_no')</th>
                                <th>@lang('business.address')</th>
                                <th>@lang('lang_v1.cmmsn_percent')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade commission_agent_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->

@endsection
