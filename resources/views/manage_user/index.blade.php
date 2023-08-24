@extends('layouts.app')
@section('title', __('user.users'))

@section('content')


    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px;" class="content-header">
        <div class="newbox blackline">
            <h3 style="margin-top: 10px;margin-bottom: 10px;">@lang('user.manage_users')</h3>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('user.all_users')])
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#users_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes"
                                aria-hidden="true"></i> @lang('user.all_users')</a>
                    </li>
                    @if (is_product_enabled('214'))
                        <li>
                            <a href="#employee_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-hourglass-half"
                                    aria-hidden="true"></i> @lang('user.all_employee')</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="users_list_tab">
                        @can('user.create')
                            @slot('tool')
                                <div class="row">
                                    <div class="{{ !is_product_enabled('214') ? 'col-md-6' : 'col-md-4' }}">
                                        <div class="box-tools">
                                            <a class="button-add" href="{{ action('ManageUserController@create') }}">
                                                <i class="fa fa-plus maricon"></i> @lang('messages.add')</a>
                                        </div>
                                    </div>
                                    @if (is_product_enabled('214'))
                                        <div class="col-md-4">

                                            <div class="box-tools">
                                                <a class="button-add" href="{{ action('ManageUserController@create') }}?type=employee">
                                                    <i class="fa fa-plus maricon"></i> أضافة موظف</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="{{ !is_product_enabled('214') ? 'col-md-6' : 'col-md-4' }}">
                                        <div class="box-tools">
                                            <button type="button" class="button-add btn-modal " data-toggle="modal"
                                                data-target="#short_create_modal">
                                                <i class="fa fa-plus maricon"></i> اضافة مختصرة
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endslot
                        @endcan
                        @can('user.view')
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="users_table">
                                    <thead>
                                        <tr>
                                            <th>@lang('business.username')</th>
                                            <th>@lang('user.name')</th>
                                            <th>@lang('user.role')</th>
                                            <th>@lang('business.email')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        @endcan
                    </div>
                    @if (is_product_enabled('214'))
                        <div class="tab-pane" id="employee_list_tab">
                            @can('user.view')
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="employee_table"
                                        style="width: 100%!important">
                                        <thead>
                                            <tr>
                                                <th>@lang('business.username')</th>
                                                <th>@lang('user.name')</th>
                                                <th>@lang('business.email')</th>
                                                <th>@lang('messages.action')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        @endcomponent

        <div class="modal fade user_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
        <div class="modal fade" id="short_create_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            @include('manage_user.short_create')
        </div>
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        //Roles table
        $(document).ready(function() {
            var users_table = $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/users',
                columnDefs: [{
                    "targets": [4],
                    "orderable": false,
                    "searchable": false
                }],
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "full_name"
                    },
                    {
                        "data": "role"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "action"
                    }
                ]
            });
            $(document).on('click', 'button.delete_user_button', function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_user,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).data('href');
                        var data = $(this).serialize();
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            data: data,
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    users_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

        });
        $(document).ready(function() {
            var employee_table = $('#employee_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/employees',
                columnDefs: [{
                    "targets": [3],
                    "orderable": false,
                    "searchable": false
                }],
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "full_name"
                    },
                    // {
                    //     "data": "role"
                    // },
                    {
                        "data": "email"
                    },
                    {
                        "data": "action"
                    }
                ]
            });
            $(document).on('click', 'button.delete_user_button', function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_user,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).data('href');
                        var data = $(this).serialize();
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            data: data,
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    employee_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection
