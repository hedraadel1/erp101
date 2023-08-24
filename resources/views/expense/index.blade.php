@extends('layouts.app')
@section('title', __('expense.expenses'))

@section('content')

    <!-- Content Header (Page header) -->
    <section style="margin-top: -25px" class="content-header">
        <div style="display:block;" class="newbox orange">
            <h3 style="{{ isMobile() ? 'margin: -15px;' : '' }}  justify-content: center;display: flex;">@lang('expense.expenses')
            </h3>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    @if (auth()->user()->can('all_expense.access'))
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('location_id', __('purchase.business_location') . ':') !!}
                                {!! Form::select('location_id', $business_locations, null, [
                                    'class' => 'form-control select2',
                                    'style' => 'width:100%',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('expense_for', __('expense.expense_for') . ':') !!}
                                {!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('expense_contact_filter', __('contact.contact') . ':') !!}
                                {!! Form::select('expense_contact_filter', $contacts, null, [
                                    'class' => 'form-control select2',
                                    'style' => 'width:100%',
                                    'placeholder' => __('lang_v1.all'),
                                ]) !!}
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expense_category_id', __('expense.expense_category') . ':') !!}
                            {!! Form::select('expense_category_id', $categories, null, [
                                'placeholder' => __('report.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'expense_category_id',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expense_sub_category_id_filter', __('product.sub_category') . ':') !!}
                            {!! Form::select('expense_sub_category_id_filter', $sub_categories, null, [
                                'placeholder' => __('report.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'expense_sub_category_id_filter',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expense_date_range', __('report.date_range') . ':') !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'expense_date_range',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expense_payment_status', __('purchase.payment_status') . ':') !!}
                            {!! Form::select(
                                'expense_payment_status',
                                ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial')],
                                null,
                                ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')],
                            ) !!}
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @component('components.widget', ['class' => 'box-primary', 'title' => __('expense.all_expenses')])
                    @can('expense.add')
                        @slot('tool')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-tools">
                                        <a class="btn btn-block button-add" href="{{ action('ExpenseController@create') }}">
                                            <i class="fa fa-plus"></i> @lang('messages.add')</a>
                                    </div>
                                </div>
                            </div>

                            {{-- <button style="float: left" type="button" class="btn btn-sm btn-primary setting_screen_table">
                        اعدادات عرض الاعمدة
                    </button> --}}
                        @endslot
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="expense_table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all-row" data-table-id="expense_table">
                                    </th>
                                    <th>@lang('messages.action')</th>
                                    <th>@lang('messages.date')</th>
                                    <th>@lang('purchase.ref_no')</th>
                                    <th>@lang('lang_v1.recur_details')</th>
                                    <th>@lang('expense.expense_category')</th>
                                    <th>@lang('product.sub_category')</th>
                                    <th>@lang('business.location')</th>
                                    <th>@lang('sale.payment_status')</th>
                                    <th>@lang('product.tax')</th>
                                    <th>@lang('sale.total_amount')</th>
                                    <th>@lang('purchase.payment_due')
                                    <th>@lang('expense.expense_for')</th>
                                    <th>@lang('contact.contact')</th>
                                    <th>@lang('expense.expense_note')</th>
                                    <th>@lang('lang_v1.added_by')</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="bg-gray font-17 text-center footer-total">
                                    <td>
                                        @can('expense.delete')
                                            {!! Form::open([
                                                'url' => action('ExpenseController@massDestroy'),
                                                'method' => 'post',
                                                'id' => 'mass_delete_form',
                                            ]) !!}
                                            {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']) !!}
                                            {!! Form::submit('حذف ', [
                                                'class' => 'btn btn-xs btn-danger ',
                                                'id' => 'delete-selected',
                                            ]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                    <td colspan="7"><strong>@lang('sale.total'):</strong></td>
                                    <td class="footer_payment_status_count"></td>
                                    <td></td>
                                    <td class="footer_expense_total"></td>
                                    <td class="footer_total_due"></td>
                                    <td colspan="4"></td>
                                </tr>

                            </tfoot>
                        </table>

                    </div>
                @endcomponent
            </div>
        </div>

    </section>
    <!-- /.content -->
    <!-- /.content -->
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    @include('expense.screen_setting_modal')

@stop
@section('javascript')
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>


    <script>
        $(document).on('click', '.setting_screen_table', function(e) {
            e.preventDefault();
            // if (selected_rows.length > 0) {
            $('#screen_setting_modal').modal('show');

        });
        $(document).ready(function() {
            $(window).on('load', function() {
                $.ajax({
                    url: "{{ route('getscreen_setting', 'expenses') }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        var cols = res.setting;
                        if (cols != null) {
                            $('.buttons-colvis').click();
                            $('.dt-button-collection').css('display', 'none');
                            $('.dt-button-collection  li').each(function(index, element) {
                                console.log(cols);
                                if (cols[index + 1]) {
                                    cols[index + 1].display == '1' ? $(element)
                                        .click() :
                                        null;
                                } else {
                                    // $(element).click()
                                }
                            });
                        }
                    },
                });
                $('.buttons-colvis').css('display', 'none');
                $('.dt-buttons').append(
                    '<a role="button" class="btn btn-sm btn-primary setting_screen_table">اعدادات عرض الاعمدة</a>'
                );
            });
        });

        $(document).on('click', '#delete-selected', function(e) {
            e.preventDefault();
            var selected_rows = getSelectedRows();

            if (selected_rows.length > 0) {
                $('input#selected_rows').val(selected_rows);
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $('form#mass_delete_form').submit();
                    }
                });
            } else {
                $('input#selected_rows').val('');
                swal('@lang('lang_v1.no_row_selected')');
            }
        });
    </script>
@endsection
