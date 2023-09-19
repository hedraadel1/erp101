@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.subscription'))

@section('content')

    <!-- Main content -->
    <section class="content">

        @include('superadmin::layouts.partials.currency')

        @component('components.widget', ['title' => 'مـحـفـظـة بـرانـد'])

            @if (!empty($wallet))
                <div class="col-md-6">
                    <div class="box box-success">
                        <div style="background: black;color:#fff !important" class="box-header text-center">
                            <h2 style="color:#fff !important" class="box-title">
                                رصيد المحفظة
                            </h2>
                        </div>
                        <div class="box-header with-border text-center">


                            <div class="box-body text-center">
                                @format_currency($wallet->amount)
                            </div>

                        </div>

                    </div>
                </div>
            @endif
            @if (!empty($wallet))
                <div class="col-md-6">
                    <div class="box box-success">
                        <div style="background: black;color:#fff !important" class="box-header text-center">
                            <h2 style="color:#fff !important" class="box-title">
                                كاش باك - رصيد مجاني
                            </h2>
                        </div>
                        <div class="box-header with-border text-center">


                            <div class="box-body text-center">
                                @format_currency($wallet->free_money)
                            </div>

                        </div>

                    </div>
                </div>
            @endif
            @if (!empty($nexts))
                <div class="clearfix"></div>
                @foreach ($nexts as $next)
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header with-border text-center">
                                <h2 class="box-title">
                                    {{ $next->package_details['name'] }}
                                </h2>
                            </div>
                            <div class="box-body text-center">
                                @lang('superadmin::lang.start_date') : {{ @format_date($next->start_date) }} <br />
                                @lang('superadmin::lang.end_date') : {{ @format_date($next->end_date) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if (!empty($waiting))
                <div class="clearfix"></div>
                @foreach ($waiting as $row)
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border text-center">
                                <h2 class="box-title">
                                    {{ $row->package_details['name'] }}
                                </h2>
                            </div>
                            <div class="box-body text-center">
                                @if ($row->paid_via == 'offline')
                                    @lang('superadmin::lang.waiting_approval')
                                @else
                                    @lang('superadmin::lang.waiting_approval_gateway')
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endcomponent

        @component('components.widget', ['title' => __('superadmin::lang.active_subscription')])
            @if (!empty($active))
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border text-center">
                            <h2 class="box-title">
                                {{ $active->package_details['name'] }}
                            </h2>

                            <div class="box-tools pull-right">
                                <span class="badge bg-green">
                                    @lang('superadmin::lang.running')
                                </span>
                            </div>

                        </div>
                        <div class="box-body text-center">
                            @lang('superadmin::lang.start_date') : {{ @format_date($active->start_date) }} <br />
                            @lang('superadmin::lang.end_date') : {{ @format_date($active->end_date) }} <br />

                            @lang('superadmin::lang.remaining', ['days' => \Carbon::today()->diffInDays($active->end_date)])

                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-danger">@lang('superadmin::lang.no_active_subscription')</h3>
            @endif
        @endcomponent
        {{-- <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang</h3>
            </div>

            <div class="box-body">
                

            </div>
        </div> --}}
        @component('components.widget', ['title' => __('superadmin::lang.all_subscriptions')])
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <!-- location table-->
                        <table class="table table-bordered table-hover" id="all_subscriptions_table">
                            <thead>
                                <tr>
                                    <th>@lang('superadmin::lang.package_name')</th>
                                    <th>@lang('superadmin::lang.start_date')</th>
                                    <th>@lang('superadmin::lang.trial_end_date')</th>
                                    <th>@lang('superadmin::lang.end_date')</th>
                                    <th>@lang('superadmin::lang.price')</th>
                                    <th>@lang('superadmin::lang.paid_via')</th>
                                    <th>@lang('superadmin::lang.payment_transaction_id')</th>
                                    <th>@lang('sale.status')</th>
                                    <th>@lang('lang_v1.created_at')</th>
                                    <th>@lang('business.created_by')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endcomponent

        @component('components.widget', ['title' => __('superadmin::lang.packages')])
            @include('superadmin::subscription.partials.packages')
        @endcomponent



    </section>
@endsection

@section('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#all_subscriptions_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ action('\Modules\Superadmin\Http\Controllers\SubscriptionController@allSubscriptions') }}',
                columns: [{
                        data: 'package_name',
                        name: 'P.name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'trial_end_date',
                        name: 'trial_end_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'package_price',
                        name: 'package_price'
                    },
                    {
                        data: 'paid_via',
                        name: 'paid_via'
                    },
                    {
                        data: 'payment_transaction_id',
                        name: 'payment_transaction_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    },
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#all_subscriptions_table'), true);
                }
            });
        });
    </script>
@endsection
