@extends('layouts.app')
@section('title', __('lang_v1.deposit_requests'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('lang_v1.deposit_requests')
            </h3>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('lang_v1.all_your_deposit_requests'),
        ])
            {{-- @can('customer.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-6">
                        <div class="box-tools">
                            <button type="button" class="btn btn-block button-add btn-modal" data-toggle="modal"
                                data-target="#deposit_requests_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-tools">
                            <button type="button" class="btn btn-block button-add btn-modal"
                                data-href="{{ action('\Modules\Superadmin\Http\Controllers\DepositRequestController@requestByCode') }}"
                                data-container=".image-modal">
                                <i class="fa fa-plus"></i>شحن عن طريق الاكواد</button>
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            @can('customer.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="deposit_requests_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang_v1.image')</th>
                                <th>@lang('lang_v1.amount')</th>
                                <th>@lang('lang_v1.status')</th>
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

                    <form action="{{ action('\Modules\Superadmin\Http\Controllers\DepositRequestController@saveImage') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">تحميل صورة الايداع</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                {!! Form::label('image', __('superadmin::lang.image') . ':*') !!}
                                {!! Form::file('image', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn button-29" type="submit">تحميل</button>
                        </div>
                    </form>

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

        $('#payment_method').on('change', function() {
            $('div.info_deposit').removeClass('hide');
        });

        $(document).on('change', '#request_code', function() {
            var code = $(this).val();
            $.ajax({
                url: '/business/getCodeValue',
                method: 'GET',
                dataType: 'json',
                data: {
                    code: code
                },
                success: function(data) {
                    if (data) {
                        $('.code_value').html('');
                        $('.code_value').append('شحن ' + data.value);
                    } else {

                    }
                }
            });
        });



        $(document).on('submit', 'form#deposit_requests_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    $('#deposit_requests_modal').modal('hide');
                    toastr.success(result.msg);
                    deposit_requests_table.ajax.reload();

                    $('#exampleModalToggle2').modal('show');

                },
            });
        });
        $(document).on('submit', 'form#image_from_store', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    $('#deposit_requests_modal').modal('hide');
                    toastr.success(result.msg);
                    deposit_requests_table.ajax.reload();

                    $('#exampleModalToggle2').modal('show');

                },
            });
        });
    </script>
@endsection
