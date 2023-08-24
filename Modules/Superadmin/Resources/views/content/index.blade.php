@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.contents'))

@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.contents')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-edit"></i>
                        {{-- <h3 class="box-title">@lang('superadmin::lang.add_content')</h3> --}}
                    </div>
                    <div class="box-body">
                        <form action="{{ action('\Modules\Superadmin\Http\Controllers\ContentController@store') }}"
                            method="post" novalidate>
                            @csrf
                            <div class="col-md-12 form-group">


                                <div class="col-md-12 form-group">
                                    {!! Form::label('description', __('superadmin::lang.contents') . ':*') !!}
                                    {!! Form::textarea('description', $content->description ?? null, [
                                        'class' => 'form-control',
                                        'required',
                                        'rows' => 6,
                                    ]) !!}
                                </div>
                                <div class="col-md-12 form-group">
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
    </script>
@endsection
