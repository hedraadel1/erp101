@extends('layouts.app')
@if ($product->id)
    @section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.edit_product'))
@else
    @section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.add_product'))
@endif
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css" media="all"
        rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput-rtl.css" media="all"
        rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @if ($product->id)
                @lang('superadmin::lang.edit_product')
            @else
                @lang('superadmin::lang.add_product')
            @endif
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <form
                            action="{{ $product->id ? action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@update', $product->id) : action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@store') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            @csrf
                            @if ($product->id)
                                @method('PUT');
                            @endif
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <h3>{{ __('superadmin::lang.product_info') }}</h3>
                                    <br>
                                </div>
                                <div class="col-md-6"style="padding-top:15px ">
                                    @if ($product->image)
                                        <img src="{{ $product->image_url }}" style="width: 100px;float:left"
                                            alt="{{ $product->name }}">
                                    @endif
                                    {!! Form::label('image', __('superadmin::lang.product_image')) !!}
                                    {!! Form::file('image') !!}
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6" style="padding-top:15px ">
                                    {!! Form::label('name', __('superadmin::lang.product_name') . ':*') !!}
                                    {!! Form::text('name', old('name', $product->name), ['class' => 'form-control', 'required']) !!}
                                </div>
                                {{-- <div class="col-md-6"style="padding-top:15px ">
                                    {!! Form::label('code', __('superadmin::lang.product_code') . ':*') !!}
                                    {!! Form::text('code', old('code', $product->code), ['class' => 'form-control', 'required']) !!}
                                </div> --}}
                                <div class="col-md-3"style="padding-top:15px ">
                                    {!! Form::label('price', __('superadmin::lang.product_price') . ':*') !!}
                                    {!! Form::number('price', old('price', $product->price), [
                                        'class' => 'form-control',
                                        'required',
                                        'step' => 'any',
                                    ]) !!}
                                </div>
                                <div class="col-md-3"style="padding-top:15px ">
                                    {!! Form::label('free_price', __('superadmin::lang.free_price') ) !!}
                                    {!! Form::number('free_price', old('free_price', $product->free_price), [
                                        'class' => 'form-control',
                                        'required',
                                        'step' => 'any',
                                    ]) !!}
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4"style="padding-top:15px ">
                                    <label for="is_required">
                                        <input type="checkbox" {{ $product->is_required == 1 ? 'checked' : '' }}
                                            name="is_required" id="is_required" value="1">
                                        {{ __('superadmin::lang.product_is_required') }}
                                    </label>
                                </div>
                                <div class="col-md-4"style="padding-top:15px ">
                                    <label for="is_distinct">
                                        <input type="checkbox" {{ $product->is_distinct == 1 ? 'checked' : '' }}
                                            name="is_distinct" id="is_distinct" value="1">
                                        {{ __('superadmin::lang.product_is_distinct') }}
                                    </label>
                                </div>
                                <div class="col-md-4"style="padding-top:15px ">
                                    <label for="is_unique">
                                        <input type="checkbox" {{ $product->is_unique == 1 ? 'checked' : '' }}
                                            name="is_unique" id="is_unique" value="1">
                                        {{ __('superadmin::lang.product_is_unique') }}
                                    </label>


                                </div>
                                <div class="col-md-4"style="padding-top:15px ">
                                    <label for="is_expire">
                                        <input type="checkbox" {{ $product->is_expire == 1 ? 'checked' : '' }}
                                            name="is_expire" id="is_expire" value="1">
                                        {{ __('superadmin::lang.product_is_expire') }}
                                    </label>


                                </div>
                                <div class="col-md-8 {{ $product->is_expire == 1 ? '' : 'hide' }}"style="padding-top:15px "
                                    id="div_duration">
                                    <label for="duration">
                                        {{ __('superadmin::lang.product_duration') }} <small class=text-red>(الفتره المحدد
                                            بالايام)</small>

                                    </label>
                                    <input type="number" id="duration" name="duration" class="form-control">


                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-12 form-group" style="padding-top:15px ">
                                    {!! Form::label('description', __('superadmin::lang.description')) !!}
                                    {!! Form::textarea('description', old('description', $product->description), [
                                        'class' => 'form-control',
                                        'required',
                                        'rows' => 6,
                                    ]) !!}
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                <h3>{{ __('superadmin::lang.product_info_discount') }}</h3>
                                <br>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('discount', __('superadmin::lang.discount')) !!}
                                {!! Form::number(
                                    'discount',
                                    old('discount', $product->id ? $product->get_product_discount($product->id)->discount : ''),
                                    [
                                        'class' => 'form-control',
                                        'step' => 'any',
                                    ],
                                ) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('discount_type', __('superadmin::lang.type')) !!}
                                <select name="type" id="discount_type" class="form-control select2">
                                    <option value="">{{ __('lang_v1.none') }}</option>
                                    <option
                                        {{ $product->id ? ($product->get_product_discount($product->id)->type == 'fixed' ? 'selected' : '') : '' }}
                                        value="fixed">{{ __('lang_v1.fixed') }}</option>
                                    <option
                                        {{ $product->id ? ($product->get_product_discount($product->id)->type == 'percent' ? 'selected' : '') : '' }}
                                        value="percent">نسبة مئوية</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="is_limited_offer">
                                    <input
                                        type="checkbox"{{ $product->id ? ($product->get_product_discount($product->id)->is_limited_offer == 1 ? 'checked' : '') : '' }}
                                        value="1" name="is_limited_offer" id="is_limited_offer">
                                    {{ __('superadmin::lang.is_limited_offer') }}
                                </label>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-6 {{ $product->id ? '' : 'hide' }}" id="date1">
                                {!! Form::label('date_from', __('superadmin::lang.date_from')) !!}
                                {!! Form::date(
                                    'date_from',
                                    old('date_from', $product->id ? $product->get_product_discount($product->id)->date_from : ''),
                                    ['class' => 'form-control', 'step' => 'any'],
                                ) !!}
                            </div>
                            <div class="col-md-6 {{ $product->id ? '' : 'hide' }}" id="date2">
                                {!! Form::label('date_to', __('superadmin::lang.date_to')) !!}
                                {!! Form::date(
                                    'date_to',
                                    old('date_to', $product->id ? $product->get_product_discount($product->id)->date_to : ''),
                                    ['class' => 'form-control', 'step' => 'any'],
                                ) !!}
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            @if ($product->id)
                                <div class="col-md-12">
                                    <label for="">{{ __('superadmin::lang.image_gallery') }}</label>
                                    <div class="row">
                                        @foreach ($product->product_media as $item)
                                            <div class="col-md-4">
                                                @php
                                                    $type = explode('.', $item->media);
                                                @endphp
                                                @if ($type['1'] == 'mp4')
                                                    <video width="100%" height="240px" style="border: 1px solid #fafafa;"
                                                        controls>
                                                        <source src="{{ asset($item->media) }}" type="video/mp4">
                                                    </video>
                                                    {{-- <iframe
                                                        src=""style="position:relative;width: 100%; height: 100%;"
                                                        frameborder="0"></iframe> --}}
                                                @else
                                                    <img style="position:relative;width: 100%"
                                                        src="{{ asset($item->media) }}" />
                                                @endif
                                                <a href="{{ action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@deleteMedia', $item->id) }}"
                                                    style="position: absolute ;left:15px" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>
                                </div>
                            @endif
                            <div class="col-sm-12">

                                <label for="">{{ __('superadmin::lang.image_gallery') }}</label>
                                <small class="text-red">(يمكنك تحميل المزيد من الصور او الفديوهات)</small>
                                <input type="file" class="form-control" name="media[]" multiple class="form-file ">
                            </div>
                            <div class="col-md-12 form-group">
                                <br>
                                <button type="submit"
                                    class="btn btn-primary pull-right"id="">@lang('messages.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        </div>
    </section>
    <!-- /.content -->
@stop
@section('javascript')

    <script type="text/javascript">
        init_tinymce('description');
        $('.select2').select2();

        $('#is_limited_offer').on('click', function() {
            if ($(this).is(':checked')) {
                $('#date1').removeClass('hide');
                $('#date2').removeClass('hide');
            } else {
                $('#date_from').val('');
                $('#date_to').val('');
                $('#date1').addClass('hide');
                $('#date2').addClass('hide');
            }
        });
        $('#is_expire').on('click', function() {
            if ($(this).is(':checked')) {
                $('#div_duration').removeClass('hide');
            } else {
                $('#duration').val('');
                $('#div_duration').addClass('hide');
            }
        });
    </script>
@endsection
