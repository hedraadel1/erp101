@extends('layouts.app')
@section('title', __('lang_v1.deposit_requests'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('superadmin::lang.deposit_requests')</h3>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('lang_v1.all_your_deposit_requests'),
        ])
            {{-- @can('customer.create') --}}

            {{-- @endcan --}}
            @can('customer.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="all_deposit_requests_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('business.business') }}</th>
                                <th>@lang('lang_v1.mobile')</th>
                                <th>@lang('lang_v1.amount')</th>
                                <th>@lang('lang_v1.status')</th>
                                <th>@lang('lang_v1.image')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent



        @include('superadmin::deposit_requests.form')
        <div class="modal fade  image-modal" id="image-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
        </div>
        <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel2">تحميل صورة الايداع</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post"></form>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-target="#deposit_requests_modal" data-toggle="modal"
                            data-dismiss="modal">Back to first</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Open first modal</a> --}}

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




        $(document).on('click', 'a.approved_request', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/approved/deposit_requests',
                dataType: 'json',
                method: 'POST',
                data: {
                    'id': id,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(result) {
                    all_deposit_requests_table.ajax.reload();
                    toastr.success(result.msg);
                }
            });
        });
    </script>
@endsection
