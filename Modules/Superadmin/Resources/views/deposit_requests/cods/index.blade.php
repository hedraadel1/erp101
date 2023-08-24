@extends('layouts.app')
@section('title', __('superadmin::lang.deposit_requests_code'))
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 10px;
            bottom: 3px;

            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: green;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px green;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    @include('superadmin::layouts.nav')
    <br>
    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox blackline">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('superadmin::lang.deposit_requests_code')
            </h3>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => __('superadmin::lang.all_your_deposit_requests_code'),
        ])
            {{-- @can('customer.create') --}}
            @slot('tool')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools">
                            <button type="button"
                                data-href="{{ action('\Modules\Superadmin\Http\Controllers\DepositRequestCodeController@create') }}"
                                class="btn btn-block button-add btn-modal" data-container=".deposit_requests_modal">
                                <i class="fa fa-plus"></i> @lang('messages.add')</button>
                        </div>
                    </div>
                </div>
            @endslot
            {{-- @endcan --}}
            @can('customer.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="deposit_requests_code_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang_v1.code')</th>
                                <th>@lang('lang_v1.value')</th>
                                <th>@lang('lang_v1.status')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent



        <div class="modal fade  deposit_requests_modal" id="deposit_requests_modal" aria-hidden="true"
            aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
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



        $(document).on('submit', 'form#deposit_requests_code_form', function(e) {
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
                    $('.deposit_requests_modal').modal('hide');
                    toastr.success(result.msg);
                    deposit_requests_code_table.ajax.reload();


                },
            });
        });

        $(document).on('click', 'input.status_code_button', function() {
            var status = 0;
            var id = $(this).data('id');
            var check_status = $(this).data('status');
            if (check_status == 0) {
                status = 1;
            }
            $.ajax({
                url: '/superadmin/code-status',
                dataType: 'json',
                method: 'POST',
                data: {
                    'status': status,
                    'id': id,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(result) {
                    deposit_requests_code_table.ajax.reload();
                    toastr.success(result.msg);
                }
            });
        });
    </script>
@endsection
