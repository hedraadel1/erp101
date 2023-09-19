@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.packages') <small>@lang('superadmin::lang.add_package')</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Page level currency setting -->
        <input type="hidden" id="p_code" value="{{ $currency->code }}">
        <input type="hidden" id="p_symbol" value="{{ $currency->symbol }}">
        <input type="hidden" id="p_thousand" value="{{ $currency->thousand_separator }}">
        <input type="hidden" id="p_decimal" value="{{ $currency->decimal_separator }}">

        {!! Form::open([
            'url' => action('\Modules\Superadmin\Http\Controllers\PackagesController@store'),
            'method' => 'post',
            'id' => 'add_package_form',
        ]) !!}

        <div class="box box-solid">
            <div class="box-body">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('name', __('lang_v1.name') . ':') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('is_active', 1, true, ['class' => 'input-icheck']) !!}
                                {{ __('superadmin::lang.is_active') }}
                            </label>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary pull-right btn-flat">@lang('messages.save')</button>
                    </div>
                </div>

            </div>
        </div>

        {!! Form::close() !!}
    </section>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form#add_package_form').validate();
        });
        $('#enable_custom_link').on('ifChecked', function(event) {
            $("div#custom_link_div").removeClass('hide');
        });
        $('#enable_custom_link').on('ifUnchecked', function(event) {
            $("div#custom_link_div").addClass('hide');
        });
    </script>
@endsection
