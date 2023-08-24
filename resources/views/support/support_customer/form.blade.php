@extends('layouts.app')
@section('title', ' الدعم الفني')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>الدعم الفني</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <form
                        action="{{ $resource->id ? route('support_customer.update.ticket', $resource->id) : route('support_customer.store.ticket') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row " style="padding: 10px">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">العنوان :</label>
                                    {!! Form::text('title', old('title', $resource->title), ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('sr_id', __('priority') . ':') !!}
                                    {!! Form::select('priority', $priority, $resource->priority, [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%',
                                        'required',
                                        'placeholder' => __('report.priority'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('description', __('lang_v1.description') . ':') !!}
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{!! $resource->description !!}</textarea>
                                    {{-- {!! Form::textarea('description', !empty($resourse->description) ? $resource->description : null, [
                                        'class' => 'form-control',
                                    ]) !!} --}}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('file', __('file') . ':') !!}
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        if ($('textarea#description').length > 0) {
            tinymce.init({
                selector: 'textarea#description',
                height: 250
            });
        }
    </script>


@endsection
