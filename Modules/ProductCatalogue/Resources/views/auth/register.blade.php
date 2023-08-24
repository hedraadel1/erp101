@extends('layouts.auth2')

<head>
    <link rel="stylesheet" href="{{ asset('css/loginbrand.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
</head>
@section('content')
    <div class="background-wrap" style="margin-top: 0px">
        <div class="background"></div>
    </div>
    <div class="">
        <div class="">
            <div class="modal-dialog" role="document">
                {!! Form::open([
                    'url' => route('product_catalogue.store'),
                    'method' => 'post',
                    'id' => 'contact_login_add',
                    'style' => 'width:100%;height:545px',
                ]) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            أنشاء حساب
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('surname', __('business.prefix') . ':') !!}
                                    {!! Form::text('surname', null, ['class' => 'form-control', 'placeholder' => __('business.prefix_placeholder')]) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('first_name', __('business.first_name') . ':*') !!}
                                    {!! Form::text('first_name', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('business.first_name'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('last_name', __('business.last_name') . ':') !!}
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('business.last_name')]) !!}
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', __('business.email') . ':*') !!}
                                    {!! Form::text('email', null, ['class' => 'form-control', 'required', 'placeholder' => __('business.email')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('contact_number', __('lang_v1.mobile_number') . ':*') !!}
                                    {!! Form::text('contact_number', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('lang_v1.mobile_number'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('alt_number', __('business.alternate_number') . ':') !!}
                                    {!! Form::text('alt_number', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('business.alternate_number'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('family_number', __('lang_v1.family_contact_number') . ':') !!}
                                    {!! Form::text('family_number', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang_v1.family_contact_number'),
                                    ]) !!}
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('username', __('business.username') . ':*') !!}
                                    {!! Form::text('username', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('business.username'),
                                        'required',
                                    ]) !!}
                                    @error('username')
                                        <span class="text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('password', __('business.password') . ':*') !!}
                                    {!! Form::password('password', [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('business.password'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('confirm_password', __('business.confirm_password') . ':*') !!}
                                    {!! Form::password('confirm_password', [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('business.confirm_password'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4" style="display: none">
                                <div class="form-group">
                                    <label>
                                        {!! Form::checkbox('is_active', 'active', true, ['class' => 'input-icheck status ']) !!} {{ __('lang_v1.status_for_user') }}
                                    </label>
                                    @show_tooltip(__('lang_v1.tooltip_enable_user_active'))
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">
                            تسجيل
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
