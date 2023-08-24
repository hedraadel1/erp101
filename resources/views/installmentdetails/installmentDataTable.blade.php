@extends('layouts.app')
@section('title', 'ادارة الاقساط')
{{-- <head>
    <title>Laravel 8 Yajra Datatable Example Tutorial - Techsolutionstuff</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head> --}}
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>ادارة الاقساط</h1>
    </section>

    <!-- Main content -->
    <section class="content">
    {{--     <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open([
                        'url' => action('ReportController@getStockReport'),
                        'method' => 'get',
                        'id' => 'sales_representative_filter_form',
                    ]) !!}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('sr_id', __('report.user') . ':') !!}
                            {!! Form::select('sr_id', $users, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'placeholder' => __('report.all_users'),
                            ]) !!}
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

                    <div class="col-md-3">
                        <div class="form-group">

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
        </div> --}}
       



        <div class="row">
            <table class="table installment-table">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم العميل</th>
                        <th>قيمة القسط</th>
                        <th>اجمالى القسط</th>
                       
                        <th>ت 1</th>
                        
                        <th width="100px">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </section>
    <!-- /.content -->
    <div class="modal fade view_register" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

@endsection

@section('javascript')
<script type="text/javascript">
$(function () {
    
    var table = $('.installment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('instadata') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'installment_value', name: 'installment_value'},
            {data: 'total_installment', name: 'total_installment'},
          
            {data: 'mobile', name: 'mobile'},
       
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection
